<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Blogs extends My_AdminController {

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');
        if (!is_current_logged_staff()) redirect(admin_url('logout'));
        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "blogs";
        $this->params            = [];

        $this->columns     =  array(
            "description" => ['name' => 'description', 'class' => 'text-center'],
            "title"       => ['name' => 'title',        'class' => 'text-center'],
            "start"       => ['name' => 'Start',       'class' => 'text-center'],
            "status"      => ['name' => 'status',      'class' => 'text-center'],
        );
    }

    public function store($id = null){
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $this->form_validation->set_rules('start', 'start', 'trim|required|xss_clean');
        $this->form_validation->set_rules('title', 'title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('description', 'description', 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', 'status', 'trim|required|in_list[0,1]|xss_clean');

        if (!$this->form_validation->run()) _validation('error', validation_errors());

        $task = 'add-item';
        if($id !== null){
            $task   = 'edit-item';
        }
        $response = $this->main_model->save_item( $this->params, ['task' => $task]);
        ms($response);
    }

    public function view()
    {
        if (!$this->input->is_ajax_request()) redirect(cn($this->controller_name));
        $data = array(
            "controller_name" => $this->controller_name,
            "items"           => $this->main_model->list_items(null, ['task' => 'list-items-view-blogs']),
        );
        $this->load->view($this->path_views . "/view", $data);
    }
}