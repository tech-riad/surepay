<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Transactions extends My_UserController {

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
            "type"       => ['name' => lang('method'),         'class' => 'text-center'],
            "cus_email"       => ['name' => lang('Customer Email'),         'class' => 'text-center'],
            "trxId"       => ['name' => 'Trx_ID',         'class' => 'text-center'],
            "amount"     => ['name' => 'amount',    'class' => 'text-center'],
            "status"    => ['name' => lang("status"),        'class' => 'text-center'],
            "created"    => ['name' => lang("Created"),                'class' => 'text-center'],
        );
    }
    public function bank_transactions()
    {
    	$items = $this->main_model->list_items($this->params, ['task' => 'bank-list-items']);
    	$data = array(
            "controller_name"     => $this->controller_name,
            "params"              => $this->params,
            "columns"             => $this->columns,
            "items"               => $items,
        );
    	$this->template->build($this->path_views . '/index', $data);
    }
    public function view_transaction($id='')
    {
        $this->db->select('t.cus_email,t.cus_name,t.transaction_id,m.ids,m.id, m.message,m.uid, m.amount,m.transaction_id, m.status, m.type, m.created,m.currency');
        $this->db->join('temp_transaction t', 't.transaction_id = m.transaction_id', 'left');
        $this->db->from('general_transaction_logs m');
        $this->db->where('m.transaction_id', $id);
        $data['item'] = $this->db->get()->row();
        
        $this->template->build($this->path_views . '/view', $data); 
    }
    public function add_manual_sms()
    {
        if (!$this->input->is_ajax_request()) redirect(client_url($this->controller_name));

        if (empty(post('add_m'))) {
            $this->load->view($this->path_views . '/add_manual_sms');

        }else{
            $this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');
            $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
            if (!$this->form_validation->run()) _validation('error', validation_errors());

            $data = array(
                'uid'     => session('uid'),
                'message' => post('message'),
                'address' => post('address'),
                'status'  =>'0',
                'created' =>now()
            );
            $this->db->insert('firebase_data', $data);
            if ($this->db->affected_rows() > 0) {
               ms(["status"  => "success", "message" => 'Added successfully']);
            } else {
                ms(["status"  => "error", "message" => 'Failed to add']);
            }
        }
    }
    public function view_bank_transaction($id='')
    {
        $data['tmp_item'] = $this->main_model->get('ids,transaction_id','temp_transaction',['transaction_id'=>$id]);
        $data['item'] = $this->main_model->get('*','bank_transaction_logs',['tmp_id'=>$data['tmp_item']->ids]);
        $data['id']=$id;

        if (!empty($status = post('k_status'))) {
            if ($status==1) {
                $this->db->update('bank_transaction_logs', ['status'=>1],['tmp_id'=>$data['tmp_item']->ids]);
                $this->db->update('temp_transaction', ['status'=>1],['transaction_id'=>$id]);
            }else{
                $this->db->update('bank_transaction_logs', ['status'=>-1],['tmp_id'=>$data['tmp_item']->ids]);
                $this->db->update('temp_transaction', ['status'=>0],['transaction_id'=>$id]);
            }

            $update_rows = array('status' => post('k_status'));
            $this->db->where('transaction_id', $id );
            $this->db->update('general_transaction_logs', $update_rows);
            ms(['status'=>'success','message'=>strtoupper($data['item']->type).' status updated successfully']);
        }else{
            $data['controller_name'] = $this->controller_name;
            $this->template->build($this->path_views . '/bank_view', $data);
        }
        
    }

}