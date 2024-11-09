<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Add_funds extends My_UserController
{
    public $tb_users;
    public $tb_transaction_logs;
    public $tb_payments;
    public $module;
    public $module_icon;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(get_class($this) . '_model', 'model');
        $this->module                       = get_class($this);
        $this->tb_users                     = USERS;
        $this->path_views                   = "add_funds";
        $this->tb_transaction_logs          = TRANSACTION_LOGS;
        $this->tb_payments                  = PAYMENTS_METHOD;
    }

    public function index()
    {
        if (!$this->input->is_ajax_request()) redirect(client_url($this->controller_name));

        /*----------  Get Payment Gate Way for user  ----------*/
        $payments = $this->model->get('type, name, id, params', $this->tb_payments, ['status' => 1,'id'=>1], 'sort', 'ASC');
        
        $data = array(
            "module"          => get_class($this),
            "payments"        => $payments,
            "currency_code"   => get_option("currency_code", 'BDT'),
            "currency_symbol" => get_option("currency_symbol", '৳'),
        );
        $this->load->view($this->path_views . "/index", $data);

    }
    
    public function process()
    {
        _is_ajax($this->module);
        $payment_id     = (int)post("payment_id");
        
        $amount         = (double)post("amount");
        $agree = post("agree");
        if ($amount == "") {
            ms(array(
                "status" => "error",
                "message" => lang("amount_is_required"),
            ));
        }

        if ($amount < 0) {
            ms(array(
                "status" => "error",
                "message" => lang("amount_must_be_greater_than_zero"),
            ));
        }

        /*----------  Check payment method  ----------*/
        $payment = $this->model->get('id, type, name, params', $this->tb_payments, ['id' => $payment_id]);
        if (!$payment) {
            _validation('error', lang('There_was_an_error_processing_your_request_Please_try_again_later'));
        }

        $min_payment = get_value($payment->params, 'min');
        $max_payment = get_value($payment->params, 'max');

        if ($amount < $min_payment) {
            _validation('error', lang("minimum_amount_is") . " " . $min_payment);
        }

        if ($max_payment > 0 && $amount > $max_payment) {
            _validation('error', 'Maximal amount is' . " " . $max_payment);
        }

        if (!$agree) {
            _validation('error', lang("you_must_confirm_to_the_conditions_before_paying"));
        } 

        $data_payment = array(
            "module" => get_class($this),
            "amount" => $amount,
        );
        require_once 'Uniquepaybd.php';
        $payment_module = new Uniquepaybd($payment);
        $payment_module->create_payment($data_payment);

    } 

    public function success() 
    {
        $transaction_id = $_GET['transactionId'];
        $transaction = $this->model->get("*", 'temp_transaction',['transaction_id'=>$transaction_id]);
       
        if (!empty($transaction)) {
            $data = array(
                "module" => get_class($this),
                "transaction" => $transaction,
            );
            $this->template->build($this->path_views . "/payment_successfully", $data);

        } else {
            redirect(cn("add_funds"));
        }
    }

    public function unsuccess()
    {
        $data = array(
            "module" => get_class($this),
        );
        $this->template->build($this->path_views . "/payment_unsuccessfully", $data);
    }
}
