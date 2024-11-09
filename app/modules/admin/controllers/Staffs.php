<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Staffs extends My_AdminController {
    private $tb_main = STAFFS;

    public function __construct()
    {
        if (!is_current_logged_staff()) redirect(admin_url('logout'));
        parent::__construct();
        $this->load->model(get_class($this) . '_model', 'main_model');

        $this->controller_name = strtolower(get_class($this));
        $this->controller_title = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views = "staffs";
        $this->params = [];
        $this->tb_main = USERS;
        $this->columns = array(
            "staffs" => ['name' => 'Staff Profile', 'class' => ''],
            "timezone" => ['name' => 'Time Zone', 'class' => 'text-center'],
            "created" => ['name' => 'Created', 'class' => 'text-center'],
            "status" => ['name' => 'Status', 'class' => 'text-center'],
        );
        
    }
}