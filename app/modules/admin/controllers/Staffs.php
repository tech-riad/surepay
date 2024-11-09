<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Staffs extends My_AdminController {
    // private $tb_main = STAFFS;

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');
        if (!is_current_logged_staff()) redirect(admin_url('logout'));
        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "staffs";
        $this->params            = [];
    }

    private $tb_main = USERS;

    // public function __construct()
    // {
    //     if (!is_current_logged_staff()) redirect(admin_url('logout'));
    //     parent::__construct();
    //     $this->load->model(get_class($this) . '_model', 'main_model');

    //     $this->controller_name = strtolower(get_class($this));
    //     $this->controller_title = ucfirst(str_replace('_', ' ', get_class($this)));
    //     $this->path_views = "staffs";
    //     $this->params = [];
    //     $this->tb_main = STAFFS;
    //     $this->columns = array(
    //         "users" => ['name' => 'User Profile', 'class' => ''],
    //         "funds" => ['name' => 'Balance', 'class' => 'text-center'],
    //         "created" => ['name' => 'Created', 'class' => 'text-center'],
    //         "status" => ['name' => 'Status', 'class' => 'text-center'],
    //     );
        
    // }

    


    public function index()
    {
        $items = $this->main_model->staffs($this->params, ['task' => 'staff-get']);
        $data = array(
            "controller_name"     => $this->controller_name,
            'items' => $items,
        );
        $this->template->build($this->path_views . '/index', $data);
    }

}