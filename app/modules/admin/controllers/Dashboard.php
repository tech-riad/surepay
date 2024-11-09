<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Dashboard extends My_AdminController {

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');
        if (!is_current_logged_staff()) redirect(admin_url('logout'));
        // 
        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "dashboard";
        $this->params            = [];
    }

    public function index()
    {

        $this->columns     =  array(
            "id"         => ['name' => '#',                            'class' => 'text-center'],
            "email"   => ['name' => 'Usr Email',                            'class' => 'text-center'],
            "cus_email"   => ['name' => 'Cus Email',                    'class' => 'text-center'],
            "type"       => ['name' => lang('Payment_method'),         'class' => 'text-center'],
            "trxId"       => ['name' => 'Transaction_ID',         'class' => 'text-center'],
            "amount"     => ['name' => 'amount',    'class' => 'text-center'],
            "created"    => ['name' => lang("Created"),                'class' => 'text-center'],
        );
        $data = array(
            "controller_name"         => $this->controller_name,
            "script"         => 'dashboard',
            "columns"        => $this->columns
        );
        $data['line_chart']=json_encode($this->main_model->lineChart2());
        $data['bar_chart']=json_encode($this->main_model->barChart());

        $this->db->select('t.cus_email,t.transaction_id,m.ids,m.id, m.uid, m.amount,m.transaction_id, m.status, m.type, m.created,m.currency');
        $this->db->join('temp_transaction t', 't.transaction_id = m.transaction_id', 'left');
        $this->db->from('general_transaction_logs m');
        $this->db->limit(10);
        $this->db->order_by('m.id', 'DESC');
        $data['items'] = $this->db->get()->result_array();


        $this->template->build($this->path_views . "/index", $data);
    }

    public function get_data($date='')
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $data=$this->main_model->breadboard_values();//Model->Method
        echo json_encode($data);
    }
}