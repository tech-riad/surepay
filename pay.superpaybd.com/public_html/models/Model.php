<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends MY_Model {
	private $firebase_lib;

	public function __construct(){
		parent::__construct();
		$this->load->library("firebase");
		$this->firebase_lib = new firebase(FIREBASE_URL);
	}
	public function get_info_by_temp_ids($ids='')
	{
		
		$result ='';

		$tmp = $this->get('*',TMP_TRANSACTION,['ids'=>$ids,'status'=>0]);
		if (!empty($tmp)) {	
			$mer = $this->get('more_information',USERS,['id'=>$tmp->uid]);					
			$b_info = $this->get('*',DOMAIN,['domain'=>$tmp->host_name,'user_id'=>$tmp->uid]);	
			$fees = 0;
			if (!empty($b_info->fees_amount)) {
				if ($b_info->fees_type==0) {
					$fees = $b_info->fees_amount;
				}else{
					$fees = $b_info->fees_amount * $tmp->amount/100;
				}
			}
			$rate=1;
			if (!empty($mer->payment_setting) && get_value($mer->payment_setting,'currency_code')!='BDT') {
				$rate = 1/get_value($mer->payment_setting,'new_currecry_rate');
				if (get_value($mer->payment_setting,'is_auto_currency_convert')=='1') {
					$rate = 1/currency_converter(get_value($mer->payment_setting,'currency_code'))*currency_converter('BDT');
				}
			}


			$all_info = [
				'brand_id' => $b_info->id,
				'brand_logo' => !empty($b_info->brand_logo)?$b_info->brand_logo:get_value($mer->more_information,'business_logo'),
				'brand_name' => !empty($b_info->brand_name)?$b_info->brand_name:get_value($mer->more_information,'business_name'),
				'support_mail' => !empty($b_info->support_mail)?$b_info->support_mail:get_value($mer->more_information,'business_email'),
				'messenger_support' => $b_info->mobile_number,
				'whatsapp_number' => !empty($b_info->whatsapp_number)?$b_info->whatsapp_number:get_value($mer->more_information,'what_asap'),
				'fees_type' =>$b_info->fees_type==0?' BDT':' %',
				'fees_amount' =>$rate*$fees,
				'b_fees_amount' =>$fees,
				'amount' => $rate*$tmp->amount,
				'b_amount' => $tmp->amount,
				'total_amount' => ceil($rate*($tmp->amount+$fees)),
				'b_total_amount' => ceil($tmp->amount+$fees),
				'cus_name'=>$tmp->cus_name,
				'cus_email'=>$tmp->cus_email,
				'success_url'=>$tmp->success_url,
				'cancel_url'=>$tmp->cancel_url,
				'transaction_id'=>$tmp->transaction_id,
				'host_name' => $tmp->host_name,
				'tmp_ids' => $tmp->ids,
				'uid' => $tmp->uid,
				'currency'=>get_option('currency_code'),
			];	

			$this->db->select('*');
			$this->db->from('user_payment_settings');
			$this->db->where('uid', $tmp->uid);
			$this->db->where('status', 1);
			$this->db->where('t_type', 'mobile');
			
			$dat = $this->db->get()->result();
			$mobile_s = [];

			foreach ($dat as $key => $value) {
				if(get_value(get_value($value->params,'limit_brands'),$b_info->id)){
					$mobile_s[] = $value;
				}
			}


			$this->db->select('*');
			$this->db->from('user_payment_settings');
			$this->db->where('status', 1);
			$this->db->where('uid', $tmp->uid);
			$this->db->where('t_type', 'bank');

			$dat = $this->db->get()->result();
			$bank_s = [];

			foreach ($dat as $key => $value) {
				if(get_value(get_value($value->params,'limit_brands'),$b_info->id)){
					$bank_s[] = $value;
				}
			}
			
			$this->db->select('*');
			$this->db->from('user_payment_settings');
			$this->db->where('status', 1);
			$this->db->where('uid', $tmp->uid);
			$this->db->where('t_type', 'int_b');
			
			$dat = $this->db->get()->result();
			$int_b_s = [];

			foreach ($dat as $key => $value) {
				if(get_value(get_value($value->params,'limit_brands'),$b_info->id)){
					$int_b_s[] = $value;
				}
			}

			$data = array(
				'all_info' => $all_info,
				'mobile_s' =>$mobile_s,
				'bank_s'   =>$bank_s,
				'int_b_s'  =>$int_b_s,
				'rate'     =>$rate
			);
			$result = $data;
		}

		return $result;
	}

	public function firebase_task($method){
		$firebase_data = $this->firebase_lib->retrieve('messageBody');
		$firebase_data = json_decode($firebase_data, true);

		if (!empty($firebase_data)) {
		    foreach ($firebase_data as $key => $data) {
		        if (is_array($data) && !empty($data['message']) && !empty($data['address']) && !empty($data['uid']) ) {
		        	$messagess = strip_tags($data['message']);
		        	$address = $data['address'];
		        	$uid = $data['uid'];
		        	$messagess = trim(preg_replace('/\s+/', ' ', $messagess));
		        	$address = trim(preg_replace('/\s+/', ' ', $address));
		        	if(empty($this->get('message','firebase_data',['message'=>$messagess])) ){
		            	$data = array(
		            		'uid'     => $uid,
		            		'message' => $messagess,
		            		'address' => $address,
		            		'status'  =>'0',
		            		'created' =>now()
		            	);
		            	$this->db->insert('firebase_data', $data);
		            }
		        }
		        $this->firebase_lib->delete('messageBody',$key);

		    }
		}
		$tmp = $this->get_info_by_temp_ids(post('tmp_id'));

		if (empty($tmp)) {
			return ["status"  => "error","title"=>"Payment Failed", "message" => 'Payment is not valid!'];
		}
		$temp_amount = amount_format($tmp['all_info']['total_amount']);
		$transaction_id = post('transaction_id');

		// Assuming $temp_amount is declared outside the switch statement
		$address = '';
		switch ($method) {
		    case 'bkash':
		    	$address ='bkash';
		        $transactionid = 'TrxID ' . $transaction_id;
		        $cashin = "Cash In Tk " . $temp_amount;
		        $sendmoney = "You have received Tk " . $temp_amount;
		        break;
		    case 'nagad':
		    	$address ='NAGAD';
		        $transactionid = 'TxnID: ' . $transaction_id;
		        $cashin = "Amount: Tk " . $temp_amount;
		        $sendmoney = "Amount: Tk " . $temp_amount;
		        break;
		    case 'rocket':
		    	$address ='16216';
		        $cashin = "Your account has been successfully credited by Tk. " . $temp_amount;
		        $sendmoney = "Tk" . $temp_amount . " received";
		        $transactionid = 'TxnID:' . $transaction_id;
		        break;
		    case 'upay':
		    	$address ='upay';
		        $cashin = "Your account has been successfully credited by Tk. " . $temp_amount;
		        $sendmoney = "Tk" . $temp_amount . " received";
		        $transactionid = 'TxnID:' . $transaction_id;
		        break;
		    case 'cellfin':
		    	$address ='01730031864';
		        $cashin = /*"Cash In Tk " .*/ $temp_amount;
		        $sendmoney = /*"You have received Tk " .*/ $temp_amount;
		        $transactionid = /*'TrxID ' .*/ $transaction_id;
		        break;
		    case 'tap':
		    	$address ='tap';
		        $cashin = /*"Cash In Tk " .*/ $temp_amount;
		        $sendmoney = /*"You have received Tk " .*/ $temp_amount;
		        $transactionid = /*'TrxID ' .*/ $transaction_id;
		        break;
		    default:
		        return ["status"  => "error","title"=>"Payment Failed", "message" => 'Illegal Operation!'];
		        break;
		}
    

		$this->db->select('*');
		$this->db->from('firebase_data');
		$this->db->group_start();
		$this->db->like('message', $cashin);
		$this->db->or_like('message', $sendmoney);
		$this->db->group_end();
		$this->db->where('message LIKE', '%' . $transactionid . '%');
		$this->db->where('status', '0');
		$this->db->where('address', $address);
		$this->db->where('uid', session('uid'));
		$query = $this->db->get()->row();


		if (empty($query) || !empty($this->get('transaction_id',TRANSACTION_LOGS,['status'=>'0','transaction_id'=>$tmp['all_info']['transaction_id']])) ) {
			return ["status"  => "error","title"=>"Payment Failed", "message" => 'Transaction ID not matched!'];
		}
		$object = array(
			'tmp_id'   => post('tmp_id'),
			'status'   => 1,
			'type'     => $method
		);
		//array for transaction logs
		$this->db->update('firebase_data', $object,['id'=>$query->id]);

		return ["status"  => "success","title"=>"Payment Successful", "message" => 'Transaction ID mathed!','redirect'=> base_url('request/complete/'.$method.'/'.$this->encryption->encrypt_data(post('tmp_id') ))];
	}
	public function cronjob()
	{
		$firebase_data = $this->firebase_lib->retrieve('messageBody');
		$firebase_data = json_decode($firebase_data, true);

		if (!empty($firebase_data)) {
		    foreach ($firebase_data as $key => $data) {
		        if (is_array($data) && !empty($data['message']) && !empty($data['address']) && !empty($data['uid']) ) {
		        	$messagess = strip_tags($data['message']);
		        	$address = $data['address'];
		        	$uid = $data['uid'];
		        	$messagess = trim(preg_replace('/\s+/', ' ', $messagess));
		        	$address = trim(preg_replace('/\s+/', ' ', $address));
		        	if(empty($this->get('message','firebase_data',['message'=>$messagess])) ){
		            	$data = array(
		            		'uid'     => $uid,
		            		'message' => $messagess,
		            		'address' => $address,
		            		'status'  =>'0',
		            		'created' =>now()
		            	);
		            	$this->db->insert('firebase_data', $data);
		            }
		        }
		        $this->firebase_lib->delete('messageBody',$key);

		    }
		}
		//end firebase data update
		//
		//delete from firebase_data table
		$sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-3 days'));
		$this->db->where('created <', $sevenDaysAgo);
		$this->db->delete('firebase_data');
	}
} 

