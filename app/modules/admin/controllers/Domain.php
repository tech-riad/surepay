<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Domain extends My_AdminController {

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');
        if (!is_current_logged_staff()) redirect(admin_url('logout'));
        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "domain";
        $this->params            = [];
        $this->columns     =  array(
            "name"             => ['name' => 'Merchant Email',    'class' => 'text-center'],
            "email"            => ['name' => 'Business Email', 'class' => 'text-center'],
            "domain"           => ['name' => 'Domain', 'class' => 'text-center'],
            "ip"               => ['name' => 'ip', 'class' => 'text-center'],
            "status"           => ['name' => 'Status',  'class' => 'text-center'],
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

    public function validateHost()
    {
        $myUrl = "http://www.domain.com/link.php";
        $myParsedURL = parse_url($myUrl);
        $myDomainName= $myParsedURL['host'];
        $ipAddress = gethostbyname($myDomainName);
        echo $ipAddress;
        if($ipAddress == $myDomainName)
        {
           echo "There is no url";
        }
        else
        {
           echo "url found";
        }
    }
}