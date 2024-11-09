<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Invoice extends My_AdminController {
    private $tb_main = INVOICE;

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');
        if (!is_current_logged_staff()) redirect(admin_url('logout'));
        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "invoice";
        $this->params            = [];
        $this->columns     =  array(
            "name"             => ['name' => 'Cus Name',    'class' => ''],
            "email"            => ['name' => 'Cus Email',    'class' => 'text-center'],
            "Mname"            => ['name' => 'Merchant Email', 'class' => 'text-center'],
            "amount"           => ['name' => 'Amount', 'class' => 'text-center'],
            "domain"           => ['name' => 'Domain', 'class' => 'text-center'],
            "date"             => ['name' => 'DateTime', 'class' => 'text-center'],
            "status"           => ['name' => 'Status',  'class' => 'text-center'],
            "pay_status"           => ['name' => 'Pay_Status',  'class' => 'text-center'],
        );
    } 

    // Edit form
    public function update($id = null){
        
        $item = null;
        if ($id !== null) {
            $this->params = ['id' => $id];
            $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
        } 
        $this->load->model('users_model', 'users_model');
        $users = $this->users_model->list_items(null, ['task' => 'admin-list-items-on-invoice']);
        
        $data = array(
            "controller_name"   => $this->controller_name,
            "item"              => $item,
            "users"             => $users
        );
        if (!$this->input->is_ajax_request()) {
            $this->template->build($this->path_views . "/update", $data);
        }else{
            $this->load->view($this->path_views . '/update', $data);
        }
    }

    public function store(){
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        
        $this->form_validation->set_rules('customer_name', 'Customer name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('customer_email', 'Customer Email', 'trim|valid_email|required|xss_clean');
        $this->form_validation->set_rules('customer_amount', 'Amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('customer_address', 'Customer Address', 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]|xss_clean');
        $this->form_validation->set_rules('user_id', 'Merchant Email', 'trim|required|xss_clean');

        if (!$this->form_validation->run()) _validation('error', validation_errors());
        if (post('id')) {
            $task = 'edit-item';
        }else{
            $task = 'add-item';
        }
        $response = $this->main_model->save_item( $this->params, ['task' => $task]);
        ms($response);
    }
    public function get_brand()
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $this->db->select('i.*,u.id,u.email');
        $this->db->where('u.email', post('user_id'));
        $this->db->join(USERS.' u', 'u.id = i.user_id', 'left');
        $data = $this->db->get('domain_whitelist i')->result();
        
            echo '<option value="">Select a brand</option>';
        foreach($data as $d){
            echo '<option value="'.$d->domain.'">'.$d->brand_name.'</option>'; 
        }
        
    }
    public function view_invoice($id=''){
        $this->params = ['id' => $id];
        $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
        $data['items']= $item;

        $this->template->build($this->path_views . "/view", $data);       


    }
}