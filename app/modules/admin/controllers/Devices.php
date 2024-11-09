<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Devices extends My_AdminController {

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');
        if (!is_current_logged_staff()) redirect(admin_url('logout'));
        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "devices";
        $this->params            = [];
        $this->columns     =  array(
            "email"            => ['name' => 'Email', 'class' => 'text-center'],
            "device"           => ['name' => 'Device Name', 'class' => 'text-center'],
            "device_key"           => ['name' => 'Device Key', 'class' => 'text-center'],
            "device_ip"               => ['name' => 'Device ip', 'class' => 'text-center'],
        );
    } 

    // Edit form
    public function update($id = null){
        $item = null;
        if ($id !== null) {
            $this->params = ['id' => $id];
            $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
        } 
        $data = array(
            "controller_name"   => $this->controller_name,
            "item"              => $item,
        );
        if (!$this->input->is_ajax_request()) {
            $this->template->build($this->path_views . "/update", $data);
        }else{
            $this->load->view($this->path_views . '/update', $data);
        }
    }

    public function store(){
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        
        if (post('id')) {
            $task = 'edit-item';
        }else{
            $task = 'add-item';
        }
        $response = $this->main_model->save_item( $this->params, ['task' => $task]);
        ms($response);
    }

   
}