<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Dashboard extends My_UserController {

    public function __construct(){
        parent::__construct(); 
        $this->load->model(get_class($this).'_model', 'main_model');
         
        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "dashboard";
        $this->params            = [];
    }

    public function index() 
    {
        
        $data = array(
            "controller_name"         => $this->controller_name,
            "script"         => 'dashboard',
        );
        $data['line_chart']=json_encode($this->main_model->lineChart2());
        $data['bar_chart']=json_encode($this->main_model->barChart());
        
        $this->db->select('t.cus_email,t.transaction_id,m.ids,m.id, m.uid, m.amount,m.transaction_id, m.status, m.type, m.created,m.currency');
        $this->db->join('temp_transaction t', 't.transaction_id = m.transaction_id', 'left');
        $this->db->from('general_transaction_logs m');
        $this->db->where('m.uid', session('uid'));
        $this->db->limit(10);
        $this->db->order_by('m.id', 'DESC');
        $data['items'] = $this->db->get()->result_array();

        $this->template->build("dashboard", $data);
    }

    public function get_data($date='')
    {
        if (!$this->input->is_ajax_request()) redirect(client_url($this->controller_name));
        $data=$this->main_model->breadboard_values();//Model->Method
        echo json_encode($data);
    }
}  