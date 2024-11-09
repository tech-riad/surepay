<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Uniquepaybd extends MX_Controller
{
	public $tb_users;
	public $tb_transaction_logs;
	public $tb_payments;
	public $payment_type;
	public $payment_id;
	public $currency_code;
	public $payment_lib;
	public $apikey;
	public $clientkey;
	public $secretkey;
	public $hostname;
	public $convert_rate;
	public $take_fee_from_user;

	public function __construct($payment = "")
	{
		parent::__construct(); 
		$this->load->model('add_funds_model', 'model');

		$this->tb_users            = USERS;
		$this->payment_type	       = 'walletmaxpay';
		$this->tb_transaction_logs = TRANSACTION_LOGS;
		$this->tb_payments         = PAYMENTS_METHOD;
		$this->currency_code       = get_option("currency_code", "BDT");
		if ($this->currency_code == "") {
			$this->currency_code = 'BDT';
		}
		if (!$payment) {
			$payment = $this->model->get('id, type, name, params', $this->tb_payments, ['type' => $this->payment_type]);
		}		


		
		$user = $this->model->get('api_credentials,id', USERS, ['id' => 1]);

		$this->payment_id = $payment->id;
		$params  = $user->api_credentials;

		// options
		$this->apikey          		    = get_value($params, 'apikey');
		$this->clientkey       		    = get_value($params, 'clientkey');
		$this->secretkey       		    = get_value($params, 'secretkey');
		$this->hostname       		    = $this->model->get('domain,id,user_id', DOMAIN, ['user_id' => 1])->domain;

		$this->convert_rate       		= !empty(get_option('new_currecry_rate'))?(float)get_option('new_currecry_rate'):1;
 
		$this->load->library("uniquepaybdapi");

		$this->payment_lib = new Uniquepaybdapi();
	} 

	public function index()
	{
		redirect(cn("add_funds"));
	}

	/**
	 *
	 * Create payment
	 *
	 */
	public function create_payment($data_payment = "")
	{

		_is_ajax($data_payment['module']);
		$amount = $data_payment['amount'];
        
		if (!$amount) {
			_validation('error', lang('There_was_an_error_processing_your_request_Please_try_again_later2'));
		}
		

		if (!$this->apikey || !$this->secretkey || !$this->hostname) {
			_validation('error', lang('this_payment_is_not_active_please_choose_another_payment_or_contact_us_for_more_detail'));
		}
		
		
		$users  = session('user_current_info');
		$unique_id = uniqid();
		set_session('unique_id', $unique_id);
		
		$full_name = $users['first_name'] . $users['last_name'];
		
		
		$amount = $amount * $this->convert_rate;
		
	    $cus_name = (isset($full_name)) ? $full_name : 'John Doe';
	    $cus_email = $users['email'];
	    $success_url = client_url("uniquepaybd/complete?unique_i=$unique_id");
	    $cancel_url = client_url("add_funds/unsuccess");
	  

		 
		$data   = array(
			"cus_name" 		    => (isset($full_name)) ? $full_name : 'John Doe',
			"cus_email"         => $users['email'],
			"amount" 			=> $amount ,
			"success_url" 		=> $success_url,
			"cancel_url" 		=> $cancel_url,
		);

		$header   = array(
		    "api"               => $this->apikey,
		    "secret"            => $this->secretkey,
		    "position"          => $this->hostname,
			"url" 		        => PAYMENT_URL,
		); 


		$response = $this->payment_lib->payment($data,$header);
		echo $response;

	} 

	/**
	 *
	 * Call Execute payment after creating payment
	 *
	 */
	public function complete()
	{
		if (!empty(session('unique_id')) && session('unique_id')==$_GET['unique_i']) {
			unset_session('unique_id');
		
			$trxId = $_GET['transactionId'];

			$data   = array(
				"transaction_id" 		=> $trxId,
			);

			$header   = array(
			    "api"               => $this->apikey,
			    "client"            => $this->clientkey,
			    "secret"            => $this->secretkey,
			    "position"          => $this->hostname,
				"url" 		        => VERIFY_URL,
			);


			$response = $this->payment_lib->payment($data,$header);

			$data = json_decode($response, true);


			if ($data['status']==1) {
			
				$transaction = $this->model->get('*', 'general_transaction_logs', ['transaction_id' => $data['transaction_id'], 'status' => 1]);
				if (!empty($transaction)) {
					$this->model->add_funds_bonus_email($transaction, $this->payment_id);			
					redirect(client_url("add_funds/success?transactionId=".$trxId));
				}
				
			}
		}
		
		redirect(client_url("add_funds/unsuccess"));
		
	}
}
