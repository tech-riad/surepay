<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Developers extends My_AdminController {

    public function __construct(){
        parent::__construct();
        if (!is_current_logged_staff()) redirect(admin_url('logout'));
        // 
        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "developers";
        $this->params            = [];
    } 

    public function index()
    {
        
        $data = array(
            "controller_name"         => $this->controller_name,
        );
        
        $this->template->build($this->path_views . "/index", $data);
    }
    public function store()
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $data = $this->input->post('developers_docs',FALSE);
        file_put_contents(APPPATH.'./modules/developers/views/docs.php',$data,ENT_IGNORE);
        
        

        ms(["status"  => "success", "message" => 'Update successfully']);
    }
}