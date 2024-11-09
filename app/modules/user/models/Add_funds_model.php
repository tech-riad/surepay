<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Add_funds_model extends MY_Model
{
    public $tb_users;
    public $tb_transaction_logs;
    public $tb_payments;
    public $module;
    public $module_icon;

    public function __construct()
    {
        parent::__construct();
        $this->tb_users            = USERS;
        $this->tb_transaction_logs = TRANSACTION_LOGS;
        $this->tb_payments         = PAYMENTS_METHOD;
    }

    // Add fund, bonus and send email
    public function add_funds_bonus_email($data_tnx, $payment_id = "")
    {
        if (!$data_tnx) {
            return false;
        }

        if (!isset($data_tnx->transaction_id)) {
            return false;
        }
        // Update Balance  and total spent
        $user = $this->model->get('id, first_name, last_name, email, ref_id, balance, timezone', $this->tb_users, ["id" => session('uid')]);
        
        if (!$user) {
            return false;
        }
        $new_funds = $data_tnx->amount;
        $new_balance = $user->balance + $new_funds;
        
        $user_update_data = [
            "balance" => $new_balance,
        ];
        $this->db->update($this->tb_users, $user_update_data, ["id" => session('uid')]);
        
        // affiliates
        if (get_option('is_addfund_bonus')==1) {
            if (get_option('min_affiliate_amount') <= $data_tnx->amount ) {
                $this->load->model('user_model');
                $this->user_model->add_affiliate_bonus(session('uid'), $data_tnx->amount);
            }
        }
        $user->pay_amount = $data_tnx->amount;
        
        /*----------  Send payment notification email  ----------*/
        if (get_option("is_payment_notice_email", '')) {
            $this->send_mail_payment_notification(['user' => $user]);
        }
        return true;
    }

    private function send_mail_payment_notification($data_pm_mail = "")
    {
        if ($data_pm_mail['user']) {

            $user = $data_pm_mail['user'];
            $subject = get_option('email_payment_notice_subject', '');
            $message = get_option('email_payment_notice_content', '');
            // get Merge Fields
            $merge_fields = [
                '{{user_firstname}}' => $user->first_name,
                '{{pay_amount}}' => $user->pay_amount
            ];
            $template = ['subject' => $subject, 'message' => $message, 'type' => 'default', 'merge_fields' => $merge_fields];
            $send_message = $this->model->send_mail_template($template, $user->id);

            if ($send_message) {
                ms(array(
                    'status' => 'error',
                    'message' => $send_message,
                ));
            }
            return true;
        } else {
            return false;
        }
    }


}
