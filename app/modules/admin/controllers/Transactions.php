<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Transactions extends My_AdminController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');

        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "transactions/";
        $this->params            = [];
        $this->columns     =  array(
            "id"         => ['name' => '#',                            'class' => 'text-center'],
            "email"   => ['name' => 'Usr Email',                            'class' => 'text-center'],
            "cus_email"   => ['name' => 'Cus Email',                    'class' => 'text-center'],
            "type"       => ['name' => lang('Payment_method'),         'class' => 'text-center'],
            "trxId"       => ['name' => 'Transaction_ID',         'class' => 'text-center'],
            "amount"     => ['name' => 'amount',    'class' => 'text-center'],
            "created"    => ['name' => lang("Created"),                'class' => 'text-center'],
        );
    }

    public function view_transaction($id='')
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $data['item'] = $this->main_model->get('*',TRANSACTION_LOGS,['id'=>$id]);
        $this->load->view($this->path_views . '/view', $data);
    }

}