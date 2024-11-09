<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Invoice extends My_UserController {
    private $tb_main = INVOICE;

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');
        if (!is_client_logged_in()) redirect(client_url('logout'));
        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "invoice";
        $this->params            = [];
        $this->columns     =  array(
            "name"             => ['name' => 'Cus Name',    'class' => ''],
            "email"            => ['name' => 'Cus Email',    'class' => 'text-center'],
            "amount"           => ['name' => 'Amount', 'class' => 'text-center'],
            "domain"           => ['name' => 'Domain', 'class' => 'text-center'],
            "date"             => ['name' => 'DateTime', 'class' => 'text-center'],
            "status"           => ['name' => 'Status',  'class' => 'text-center'],
            "pay_status"           => ['name' => 'Pay_Status',  'class' => 'text-center'],
        );
    } 

    public function index()
    {
        $items = $this->main_model->list_items($this->params, ['task' => 'list-items']);
        $data = array(
            "controller_name"     => $this->controller_name,
            'items' => $items,
        );
        $this->template->build($this->path_views . '/index', $data);
    }

    // Edit form
    public function update($id = null){
        
        $item = null;
        if ($id !== null) {
            $this->params = ['id' => $id];
            $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
        } 
        $this->load->model('domain_model', 'users_model');
        $brands = $this->users_model->get_item(null, ['task' => 'brand-list-items-on-invoice']);
        
        
        $data = array(
            "controller_name"   => $this->controller_name,
            "item"              => $item,
            "item2"             => $brands
        );
        if (!$this->input->is_ajax_request()) {
            $this->template->build($this->path_views . "/update", $data);
        }else{
            $this->load->view($this->path_views . '/update', $data);
        }
    }

    public function store(){
        if (!$this->input->is_ajax_request()) redirect(client_url($this->controller_name));
        
        $this->form_validation->set_rules('customer_name', 'Customer name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('customer_number', 'Customer number', 'trim|required|xss_clean');
        $this->form_validation->set_rules('customer_email', 'Customer Email', 'trim|valid_email|required|xss_clean');
        $this->form_validation->set_rules('customer_amount', 'Amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('domain', 'Brand Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('customer_address', 'Customer Address', 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]|xss_clean');

        if (!$this->form_validation->run()) _validation('error', validation_errors());
        if (post('id')) {
            $task = 'edit-item';
        }else{
            $task = 'add-item';
        }
        $response = $this->main_model->save_item( $this->params, ['task' => $task]);
        ms($response);
    }

    public function view_invoice($id=''){
        $this->params = ['id' => $id];
        $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
        $data['items']= $item;

        $this->template->build($this->path_views . "/view", $data);       


    }



}