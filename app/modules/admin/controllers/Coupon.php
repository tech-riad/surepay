<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Coupon extends My_AdminController {
    private $tb_main = 'coupons';

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');
        if (!is_current_logged_staff()) redirect(admin_url('logout'));
        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "coupon";
        $this->params            = [];
        $this->columns     =  array(
            "code"             => ['name' => 'Code',    'class' => ''],
            "type"             => ['name' => 'Type',    'class' => 'text-center'],
            "price"            => ['name' => 'Price', 'class' => 'text-center'],
            "limit"            => ['name' => 'Limit', 'class' => 'text-center'],
            "used"             => ['name' => 'Used', 'class' => 'text-center'],
            "start_date"       => ['name' => 'From', 'class' => 'text-center'],
            "end_date"         => ['name' => 'To', 'class' => 'text-center'],
            "status"           => ['name' => 'Status',  'class' => 'text-center'],
        );
    }

    // Edit form
    public function update($id = null){
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $item = null;
        if ($id !== null) {
            $this->params = ['id' => $id];
            $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
        }
        $data = array(
            "controller_name"   => $this->controller_name,
            "item"              => $item,
        );
        $this->load->view($this->path_views . '/update', $data);
    }

    public function store(){
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        
        $this->form_validation->set_rules('start_date', 'Start date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('end_date', 'End date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]|xss_clean');
        $this->form_validation->set_rules('type', 'Type', 'trim|required|in_list[0,1]|xss_clean');

        $id = post('id');
        if ($id) {
            $code = "|edit_unique[$this->tb_main.code.$id]";
            $task = 'edit-item';
        }else{
            $code = "|is_unique[$this->tb_main.code]";
            $task   = 'add-item';
        }
        $this->form_validation->set_rules('code', 'code', 'trim|required|xss_clean' . $code, [
            'is_unique' => 'The code already exists.',
        ]);

        if (!$this->form_validation->run()) _validation('error', validation_errors());

        $response = $this->main_model->save_item( $this->params, ['task' => $task]);
        ms($response);
    }
}