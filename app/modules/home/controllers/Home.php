<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'model');
        
    }
	
	public function index()
	{
		$data = [
            "payments"        => $this->model->list_items(null, ['task' => 'list-items-payments']),
            "items"        => $this->model->list_items(null, ['task' => 'list-items-faq']),
            "plans"        => $this->model->list_items(null, ['task' => 'list-items-plans']),
        ];
        $this->template->build('index', $data);
	}
    public function terms()
    {
        
        $this->template->build('terms');
    }
    public function privacy()
    {
        
        $this->template->build('privacy');
    }
	public function invoice($ids='') 
    {
        $this->params = ['ids' => $ids];        
        $item = $this->model->get_item($this->params, ['task' => 'get-item']);
        $data['items'] = $item;
         
        if (!empty($data['items'])) {
            $item_infor = $item['api_credentials'];

            $rate =1;
            

            $this->apikey=get_value($item_infor,'apikey');
            $this->clientkey=get_value($item_infor,'clientkey');
            $this->secretkey=get_value($item_infor,'secretkey');
            $this->hostname=$item['domain']; 
            $this->load->library("uniquepaybdapi");
            $this->payment_lib = new Uniquepaybdapi();

            
            //if get start payment to pay
            if (isset($_GET['start_payment'])) {
                
                $success_url = base_url('invoice/'.$ids."?complete=".$ids);
                $cancel_url = base_url('invoice/'.$ids);
 
                $data   = array(
                    "cus_name"          => $item['customer_name'],
                    "cus_email"         => $item['customer_email'],
                    "amount"            => $item['customer_amount'],
                    "success_url"       => $success_url,
                    "cancel_url"        => $cancel_url,
                );

                $header   = array(
                    "api"               => $this->apikey,
                    "secret"            => $this->secretkey,
                    "position"          => $this->hostname,
                    "url"               => PAYMENT_URL,
                );
                
                echo $response = $this->payment_lib->payment($data,$header);

            }elseif(isset($_GET['complete'])){
                $trxId = $_GET['transactionId'];
                $amount   = $_GET['paymentAmount'];

                $c_amount = $amount / $rate;

                $data   = array(
                    "transaction_id"        => $trxId,
                );

                $header   = array(
                    "api"               => $this->apikey,
                    "client"            => $this->clientkey,
                    "secret"            => $this->secretkey,
                    "position"          => $this->hostname,
                    "url"               => VERIFY_URL,
                );
                $this->db->where('ids', $ids);
                $this->db->set(['transaction_id'=>$trxId]);
                $this->db->update(INVOICE);


                $response = $this->payment_lib->payment($data,$header);
                $data = json_decode($response, true);
                
                $transaction = $this->model->get('*', TRANSACTION_LOGS, ['transaction_id' => $data['transaction_id'], 'status' => 1]);

                if (!$transaction){
                    redirect(base_url('invoice/'.$ids));
                }else{
                    $this->db->where('ids', $ids);
                    $this->db->set(['pay_status'=>1]);
                    $this->db->update(INVOICE);
                    redirect(base_url('invoice/'.$ids));
                }
            }else{               
                $this->load->view('invoice', $data);                
            }
        }else{
            show_404();
        }

    }
    public function refferal($ids){
        set_session('refferal_id', $ids);
        redirect (base_url('signup'));
    }
    public function connect_with_mobile_app()
    {
        $user_email = $this->input->get_post('user_email');
        $device_key = $this->input->get_post('device_key');
        $device_ip = $this->input->get_post('device_ip');

        if ($user_email && $device_key && $device_ip) {
            $uid = $this->model->get('id, uid, device_ip', 'devices', ['user_email' => $user_email, 'device_key' => $device_key]);

            if ($uid) {
                if(deviceValidation($device_key, $uid->uid)){
                    if (empty($uid->device_ip)) {
                        $data['device_ip'] = $device_ip;
                        $this->db->update('devices', $data, ['id' => $uid->id]);
                        ms(["status" => "1", "message" => $uid->uid]);
                    } elseif ($uid->device_ip == $device_ip) {
                        ms(["status" => "1", "message" => $uid->uid]);
                    } else {
                        ms(["status" => "3", "message" => 'Already connected with a device']);
                    }
                }else{
                    ms(["status" => "2", "message" => 'Your key is Expired']);
                }
            }
        }

        ms(['status' => '0', 'message' => 'Sorry! Failed to connect with the server']);
    }

}
