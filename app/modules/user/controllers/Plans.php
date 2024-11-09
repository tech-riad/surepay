<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Plans extends My_UserController {

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');
         
        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "plans";
        $this->params            = [];
    }

    public function index()
    {
                
        $data['plans'] = $this->main_model->get_item($this->params, ['task' => 'get-items']);
        
        
        $this->template->build($this->path_views . "/index", $data);
    }

    public function my_plan(){
        $data['items'] = $this->main_model->get_item($this->params, ['task' => 'get-active-item']);
        $this->template->build($this->path_views . "/my_plans", $data);
    }

    public function buy($id='')
    {
        if (!$this->input->is_ajax_request()) redirect(client_url($this->controller_name));
        $item = null;
        if ($id !== null) {
            $this->params = ['id' => $id];
            $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
        }
        $data = array(
            "controller_name"   => $this->controller_name,
            "item"              => $item,
        );
        $this->load->view($this->path_views . '/buy', $data);
    }
    public function store()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(client_url($this->controller_name));
        }
        $this->form_validation->set_rules('id', 'id', 'trim|required|xss_clean');
        $this->form_validation->set_rules('price', 'price', 'trim|required|xss_clean');
        
        if (!$this->form_validation->run()) {
            _validation('error', validation_errors());
        }
        $this->params = ['id' => post('id')];
        $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
        if (empty($item)) {
            _validation('error', 'Something went wrong!');
        }

        //if multiple free 
        $this->params = ['plan_id' => post('id')];
        $free = $this->main_model->get_item($this->params, ['task' => 'get-user-free']);
        if (post('id')==1 && !empty($free)) {
            _validation('error', 'You cannot buy a free plan for multiple time!');
        }
        $user_balance =  $this->main_model->get('balance',USERS,['id'=>session('uid')])->balance;

        
        //code for plan buy 
        $discount = 0;
        if (!empty($coupon = post('coupon'))) {
            $this->params = ['coupon' => $coupon];
            $coupons = $this->main_model->get_item($this->params, ['task' => 'get-coupon']);
            if (!empty($coupons) ){
                if ($coupons->type==0) {
                    $discount = $coupons->price;                                        
                }else{
                    $discount = $item['price']*$coupons->price/100;
                }
                if ($item['price']-$discount <= 0) {
                    _validation('error', $discount.'Plan price is less than coupon price');
                }
                                    
            }else{
                _validation('error', 'Coupon is not valid');
            }
            
        }

        $final_price = abs($item['price']-$discount);

        if ($final_price > get_current_user_data()->balance ) {
           _validation('error', 'Your balance is low!!! Please add funds');
        }
        
        $message = "Your purchase of plan ".$item['name'].' for'. get_option('currency_symbol').$item['price'].' taka with a discount of '. get_option('currency_symbol').$discount.' is successful';

        $data_tnx_log = array(
            "ids"               => ids(),
            "uid"               => session("uid"),
            "type"              => 'Account',
            "transaction_id"    => trxId(),
            "amount"            => $final_price,
            "message"           => $message,
            "status"            => 1,
            "created"           => now(),
        );
        $this->db->insert('general_transaction_logs', $data_tnx_log);

        switch ($item['duration_type']) {
            case '1':
                $duration = $item['duration'];
                break;
            case '2':
                $duration = $item['duration']*30;
                break;
            case '3':
                $duration = $item['duration']*365;
                break;
            default:
                $duration = $item['duration'];
                break;
        }


        $new_balance = $user_balance-$final_price;

        $this->db->where('id', session('uid'));
        $this->db->set('balance', 'balance - ' . $final_price, false);
        $this->db->update(USERS);

        
        if ($discount > 0) {
            $this->db->set('used', 'used+1', FALSE);
            $this->db->where('code', $coupon);
            $this->db->update('coupons');
        }

        if($user_plan=get_active_plan(post('id'))){
            
            $data_plan = array(
                "uid"               => session("uid"),
                "plan_id"           => post('id'),
                "price"             => $final_price,
                "website"           => $item['website'],
                "device"           => $item['device'],
                "expire"            => calculateExpirationDate($duration,$user_plan->expire),
                "created"           => $user_plan->expire,
            );            
        }else{
            $data_plan = array(
                "uid"               => session("uid"),
                "plan_id"           => post('id'),
                "price"             => $final_price,
                "website"           => $item['website'],
                "device"           => $item['device'],
                "expire"            => calculateExpirationDate($duration),
                "created"           => now(),
            );
            
        }

        $this->db->insert('users_plan', $data_plan);        


        $message = "New plan plan (".$item['name'].') for'. get_option('currency_symbol').$item['price'].' taka with a discount of '. get_option('currency_symbol').$discount.' is successfully added';

        $this->params = ['message' => $message, 'amount'=>$final_price];
        $this->main_model->save_item($this->params,['task'=>'send-mail']);


        ms([
            'status' => 'success',
            'message' => 'Your request is being processed',
            'redirect_url' => client_url(),
        ]);
        

    }
}  