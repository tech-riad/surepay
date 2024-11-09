<?php
defined('BASEPATH') OR exit('No direct script access allowed');
(!class_exists('My_Controller'))?require_once(APPPATH.'core/My_Controller.php'):'';

class Request extends My_Controller {
	public $firebase_lib;
	public function __construct()
    {
        parent::__construct(); 
        $this->load->model('model','main_model');
    	define("BASE_SITE", get_option('main_site'));
        

    }
	public function payment($type='')
	{
		if (!in_array($type,['create','verify','woocommerce','android','payment_url'])) {
			ms(["status"  => "error", "message" => 'Invalid API request']);
		}
		if($type=='android'){
			if (!empty($info = $this->androidValidateAuthorization()) ) {
				if(!empty($_REQUEST['amount']) && is_numeric($_REQUEST['amount']) && !empty($_REQUEST['success_url']) && !empty($_REQUEST['cancel_url']) ){				
					$ids = ids();
				
					$data   = array(
						"ids"               => $ids,
						"uid"               => $info['user_id'],
						"cus_name" 		    => !empty($_REQUEST['cus_name'])?$_REQUEST['cus_name']:'Default Name',
						"cus_email"         => !empty($_REQUEST['cus_email'])?$_REQUEST['cus_email']:'default@gmail.com',
						"amount" 			=> $_REQUEST['amount'] ,
						"success_url" 		=> $_REQUEST['success_url'],
						"cancel_url" 		=> $_REQUEST['cancel_url'],
						"status"            => 0,
						"transaction_id"    => trxId(),
						"host_name"         => $info['host_name'],
						"created"           => now()

					);

					if($this->db->insert(TMP_TRANSACTION,$data)){
						echo '<script>window.location=" '.base_url("request/execute/".$ids).'"</script>';

					}
				}else{
					ms(["status"  => "error", "message" => 'Your request with Invalid Parameters.']);

				}
			}else{
				ms(["status"  => "error", "message" => 'Invalid API Response.']);
			}
		}


		if (!empty($info = $this->validateAuthorization()) ) {
			if ($type=='verify') {
				
				$trx = $this->main_model->get('cus_name,cus_email,amount,transaction_id,status',TMP_TRANSACTION,['transaction_id'=>$_REQUEST['transaction_id'],'status'=>1,'uid'=>$info['user_id'] ]);
				if (!empty($trx)) {
					ms(['cus_name'=>$trx->cus_name,'cus_email'=>$trx->cus_email,'amount'=>$trx->amount,'transaction_id'=>$trx->transaction_id,'status'=>'1','message'=>'success']);
				}
				ms(['status'=>'0','message'=>'failed']);

			}elseif ($type=='create') {
				if(!empty($_REQUEST['amount']) && is_numeric($_REQUEST['amount']) && !empty($_REQUEST['success_url']) && !empty($_REQUEST['cancel_url']) ){				
					$ids = ids();
				
					$data   = array(
						"ids"               => $ids,
						"uid"               => $info['user_id'],
						"cus_name" 		    => !empty($_REQUEST['cus_name'])?$_REQUEST['cus_name']:'Default Name',
						"cus_email"         => !empty($_REQUEST['cus_email'])?$_REQUEST['cus_email']:'default@gmail.com',
						"amount" 			=> $_REQUEST['amount'] ,
						"success_url" 		=> $_REQUEST['success_url'],
						"cancel_url" 		=> $_REQUEST['cancel_url'],
						"status"            => 0,
						"transaction_id"    => trxId(),
						"host_name"         => $info['host_name'],
						"created"           => now()

					);

					if($this->db->insert(TMP_TRANSACTION,$data)){
						echo '<script>window.location=" '.base_url("request/execute/".$ids).'"</script>';

					}
				}else{
					ms(["status"  => "error", "message" => 'Your request with Invalid Parameters.']);

				}

			}elseif($type=='woocommerce' || $type='payment_url'){
				if(!empty($_REQUEST['amount']) && is_numeric($_REQUEST['amount']) && !empty($_REQUEST['success_url']) && !empty($_REQUEST['cancel_url']) ){				
					$ids = ids();
				
					$data   = array(
						"ids"               => $ids,
						"uid"               => $info['user_id'],
						"cus_name" 		    => !empty($_REQUEST['cus_name'])?$_REQUEST['cus_name']:'Default Name',
						"cus_email"         => !empty($_REQUEST['cus_email'])?$_REQUEST['cus_email']:'default@gmail.com',
						"amount" 			=> $_REQUEST['amount'] ,
						"success_url" 		=> $_REQUEST['success_url'],
						"cancel_url" 		=> $_REQUEST['cancel_url'],
						"status"            => 0,
						"transaction_id"    => trxId(),
						"host_name"         => $info['host_name'],
						"created"           => now()

					);

					if($this->db->insert(TMP_TRANSACTION,$data)){
						ms(['status'=>'success','payment_url'=>base_url("request/execute/".$ids) ]);
					}
				}else{
					ms(["status"  => "error", "message" => 'Your request with Invalid Parameters.']);

				}
				
			}



		}else{
			ms(["status"  => "error", "message" => 'Invalid API Response.']);
		}

		
	}
	public function execute($ids='')
	{
		if (!empty($data = $this->main_model->get_info_by_temp_ids($ids))) {	
			set_session('tmp_ids',$ids);
			set_session('uid',$data['all_info']['uid']);

			$this->load->view('execute',$data);

		}else{
			ms(["status"  => "error", "message" => 'Invalid API Response']);
		}
	}

	public function execute_payment($method='',$ids='')
	{
		$data = $this->main_model->get_info_by_temp_ids($ids);

		if (!empty(session('tmp_ids')) && !empty($tmp = $this->main_model->get_info_by_temp_ids($ids)) ) {

			$setting = json_decode(json_encode($this->main_model->get('*','user_payment_settings',['uid'=>$data['all_info']['uid'],'g_type'=>$method ])),true );
			if (!empty($setting)) {
				$active = get_value(get_value($setting,'params'),'active_payments');
				$act = [];
				if (!empty($active)) {
					foreach ($active as $key => $value) {
						if ($value=='1') {
							$act[] = $key;
						}
					}
				}

				if (!empty($act) && !$_GET['acc_tp']) {
					$data= array(
						'tmp'=>$tmp,
						'setting'=>$setting,
						'act'    =>$act,
					);
					if(count($act) == 1){
						foreach($act as $mb){
							$te = $this->custom_encryption->encrypt($mb);
							redirect(base_url('request/execute_payment/'.$setting['g_type'].'/'.$tmp['all_info']['tmp_ids'].'?acc_tp='.$te));
						}
					}
					$this->load->view('execute_prepare_payment',$data);
				}else{
					$data= array(
						'tmp'=>$tmp,
						'setting'=>$setting
					);
					$this->load->view('execute_payment',$data);
				}


			}else{
				ms(["status"  => "error", "message" => 'Invalid API Response']);
			}
			
		}else{
			ms(["status"  => "error", "message" => 'Invalid API Response']);
		}
		
	}
	public function save_payment($method){
		$this->form_validation->set_rules('transaction_id', 'Transaction ID', 'trim|required|xss_clean');
        if (!$this->form_validation->run()){
        	ms(["status"  => "error","title"=>"Error!", "message" => 'Transaction ID is Required']);
        }
        if(post('t_type')=='mobile'){
			$result = $this->main_model->firebase_task($method);
        }elseif(post('t_type')=='bank'){
        	$data = array(
        		'uid'     => session('uid'),
        		'tmp_id'  => session('tmp_ids'),
        		'files'   => post('transaction_id'),
        		'status'  => '0',
        		'type'    => $method,
        		'created' => now()
        	);
        	$this->db->insert('bank_transaction_logs', $data);

        	ms(["status"  => "success","title"=>"Payment Successful", "message" => 'Your Request is sent for review!','redirect'=> base_url('request/bank_complete/'.$method.'/'.$this->encryption->encrypt_data(post('tmp_id') ))]); 
        }
		
		ms($result);

	}

	public function auto_payment($method){
		if (!$this->input->is_ajax_request()) {redirect(base_url());}
		$ids = $this->encryption->encrypt_data(post('id'));
		echo base_url('request/complete/'.$method.'/'.$ids);
	}
	public function payment_failed($ids)
	{
		$tmp = $this->main_model->get_info_by_temp_ids($ids);
		$data = array(
			'business_name'   		=> @$tmp['all_info']['brand_name'],
			'business_logo'   		=> @$tmp['all_info']['brand_logo'],
			'temp_method_id'  		=> "",
			'temp_success_url'		=> @$tmp['all_info']['success_url'],
			'temp_failed_url' 		=> @$tmp['all_info']['cancel_url'],
			'temp_transaction_id'   => @$tmp['all_info']['transaction_id'],
			'temp_amount' 			=> @$tmp['all_info']['amount'],
			'fees_amount'           => @$tmp['all_info']['fees_amount'],

		);

		$this->load->view('failed_payment', $data);
	}
	public function auto_payment_failed($method,$ids){
		$tmp = $this->main_model->get_info_by_temp_ids($ids);
		$data = array(
			'business_name'   		=> $tmp['all_info']['brand_name'],
			'business_logo'   		=> $tmp['all_info']['brand_logo'],
			'temp_method_id'  		=> $method,
			'temp_success_url'		=> $tmp['all_info']['success_url'],
			'temp_failed_url' 		=> $tmp['all_info']['cancel_url'],
			'temp_transaction_id'   => $tmp['all_info']['transaction_id'],
			'temp_amount' 			=> $tmp['all_info']['amount'],
			'fees_amount'           => $tmp['all_info']['fees_amount'],

		);

		$this->load->view('failed_payment', $data);	

	}

	public function complete($method='',$ids='')
	{
		$ids = $this->encryption->decrypt_data($ids);
		
		if (!empty($ids) && !empty($tmp = $this->main_model->get_info_by_temp_ids($ids))) {
			
			$query = $this->main_model->get('message,type','firebase_data',['tmp_id'=>$ids]);
			
			if (!empty($query) && !empty($query->message)) {
				$message = $query->message;
			}else{
				$message = 'Taka '.$tmp['all_info']['total_amount']. ' has been added by '.$method.' TrxID '.$tmp['all_info']['transaction_id'];
			}
			
			$data = array(
				'ids' => ids(),
				'uid' => $tmp['all_info']['uid'],
				'type'=> $method,
				'transaction_id'=>$tmp['all_info']['transaction_id'],
				'message' => $message,
				'amount'=>$tmp['all_info']['total_amount'],
				'currency'=>$tmp['all_info']['currency'],
				'status' =>1,
				'created' => now()
			);
			$this->db->delete('firebase_data', ['tmp_id'=>$ids]);

			$this->db->trans_start(); // Start the transaction
			$this->db->insert(TRANSACTION_LOGS, $data);
			$this->db->update(TMP_TRANSACTION, ['status' => 1], ['ids' => $ids]);
			$this->db->trans_complete(); // Complete the transaction

			$data = array(
				'p_type'                  => 'mobile',
				'business_name'   		=> $tmp['all_info']['brand_name'],
				'business_logo'   		=> $tmp['all_info']['brand_logo'],
				'temp_method_id'  		=> $method,
				'temp_success_url'		=> url_modifier($tmp['all_info']['success_url'],['transactionId' =>$tmp['all_info']['transaction_id'],'paid_by'=>$method ,'paymentAmount'=>$tmp['all_info']['amount'],'paymentFee'=>$tmp['all_info']['fees_amount'],'success'=>'1']),
				'temp_failed_url' 		=> url_modifier($tmp['all_info']['cancel_url'],['transactionId' =>$tmp['all_info']['transaction_id'] ,'paymentAmount'=>$tmp['all_info']['amount'],'paymentFee'=>$tmp['all_info']['fees_amount'],'success'=>'0']),
				'temp_transaction_id'   => $tmp['all_info']['transaction_id'],
				'temp_amount' 			=> $tmp['all_info']['amount'],
				'fees_amount'           => $tmp['all_info']['fees_amount'],

			);

			if ($this->db->trans_status() === FALSE) {
			    $this->load->view('failed_payment', $data);
			} else {
			    $this->load->view('success_payment', $data);
			}


		}else{load_404();}
		
	}
	public function bank_complete($method='',$ids='')
	{
		$ids = $this->encryption->decrypt_data($ids);
		
		if (!empty($ids) && !empty($tmp = $this->main_model->get_info_by_temp_ids($ids))) {
			
			
			$message = 'Taka '.$tmp['all_info']['total_amount']. ' has been added by '.$method.' TrxID '.$tmp['all_info']['transaction_id'];
			
			
			$data = array(
				'ids' => ids(),
				'uid' => $tmp['all_info']['uid'],
				'type'=> $method,
				'transaction_id'=>$tmp['all_info']['transaction_id'],
				'message' => $message,
				'amount'=>$tmp['all_info']['total_amount'],
				'currency'=>$tmp['all_info']['currency'],
				'status' =>0,
				'created' => now()
			);
			$this->db->trans_start(); // Start the transaction
			$this->db->insert(TRANSACTION_LOGS, $data);
			$this->db->update(TMP_TRANSACTION, ['status' => 0], ['ids' => $ids]);
			$this->db->trans_complete(); // Complete the transaction

			$data = array(
				'p_type'                => 'bank',
				'business_name'   		=> $tmp['all_info']['brand_name'],
				'business_logo'   		=> $tmp['all_info']['brand_logo'],
				'temp_method_id'  		=> $method,
				'temp_success_url'		=> url_modifier($tmp['all_info']['success_url'],['transactionId' =>$tmp['all_info']['transaction_id'] ,'paymentAmount'=>$tmp['all_info']['amount'],'paymentFee'=>$tmp['all_info']['fees_amount'],'success'=>'1']),
				'temp_failed_url' 		=> url_modifier($tmp['all_info']['cancel_url'],['transactionId' =>$tmp['all_info']['transaction_id'] ,'paymentAmount'=>$tmp['all_info']['amount'],'paymentFee'=>$tmp['all_info']['fees_amount'],'success'=>'0']),
				'temp_transaction_id'   => $tmp['all_info']['transaction_id'],
				'temp_amount' 			=> $tmp['all_info']['amount'],
				'fees_amount'           => $tmp['all_info']['fees_amount'],
 
			);		

			if ($this->db->trans_status() === FALSE) {
			    $this->load->view('failed_payment', $data);
			} else {
			    $this->load->view('success_payment', $data);
			}


		}else{load_404();}
		
	}

	private function validateAuthorization() {
	    $headers   = getallheaders();
	    $requiredHeaders = [
	    	'app-key','secret-key','host-name'
	    ];
	    foreach ($requiredHeaders as $header) {
		    if (!array_key_exists($header, $headers)) {
		        return false;
		    }
		}

    	$appkey       = $headers['app-key'];
    	$clientsecret = $headers['secret-key'];
    	$hostname     = $headers['host-name'];

        $this->db->select('id,api_credentials');
		$this->db->from(USERS);
		$this->db->where('JSON_EXTRACT(api_credentials, "$.apikey") =', $appkey);
		$this->db->where('JSON_EXTRACT(api_credentials, "$.secretkey") =', $clientsecret);
		$query = $this->db->get();
		$result = $query->row();
		
		if (!empty($result) && domainValidation($hostname,$result->id)) {
			return array('user_id'=>$result->id, 'host_name'=>$hostname);		  		
		}

	    return FALSE;
	}
	private function androidValidateAuthorization() {
		if(!isset($_REQUEST['app_key'])||!isset($_REQUEST['secret_key'])||!isset($_REQUEST['host_name'])  ){
    		return FALSE;
    	}
    	$appkey       = $_REQUEST['app_key'];
    	$clientsecret = $_REQUEST['secret_key'];
    	$hostname     = $_REQUEST['host_name'];

        $this->db->select('id,api_credentials');
		$this->db->from(USERS);
		$this->db->where('JSON_EXTRACT(api_credentials, "$.apikey") =', $appkey);
		$this->db->where('JSON_EXTRACT(api_credentials, "$.secretkey") =', $clientsecret);
		$query = $this->db->get();
		$result = $query->row();
		
		if (!empty($result) && domainValidation($hostname,$result->id)) {
			return array('user_id'=>$result->id, 'host_name'=>$hostname);		  		
		}

	    return FALSE;
	}
    public function cronjob()
	{
		$this->main_model->cronjob();
	}
    

}

