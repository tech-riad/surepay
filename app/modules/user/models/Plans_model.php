<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plans_model extends MY_Model 
{
    protected $tb_main;

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = 'plans';
        $this->tb_staff = STAFFS;

    }

    public function get_item($params = null, $option = null)
    {
        $result=[];
        if ($option['task'] == 'get-items') {
            $this->db->select('*');
            $this->db->where('status', 1);
            $this->db->from($this->tb_main);
            $this->db->order_by('sort', 'asc');
            $query = $this->db->get();
            $result = $query->result_array();
        } 
        if($option['task'] == 'get-item'){
            $result = $this->get("*", $this->tb_main, ['id' => $params['id']], '', '', true);
        }
        
        if($option['task'] == 'get-active-item'){
            $this->db->select('p.name,u.*');
            $this->db->from('users_plan u');
            $this->db->join('plans p', 'p.id = u.plan_id', 'left');
            $this->db->where('u.uid', session('uid'));
            $this->db->order_by('u.id', 'desc');

            $result = $this->db->get()->result_array();
        }
        if($option['task'] == 'get-coupon'){ 
            $this->db->select('*');
            $this->db->where('code', $params['coupon']);
            $this->db->where('status', 1);
            $this->db->where('times > used');
            $this->db->where('start_date <= cast((now()) as date)');
            $this->db->where('end_date >= cast((now()) as date)');
            $result = $this->db->get('coupons')->row();
        }
        if ($option['task'] == 'get-user-free') {
            $result = $this->get("*", 'users_plan', ['plan_id' => 1, 'uid'=>session('uid')], '', '', true);
        }

        return $result;
    }

    public function save_item($params = null, $option = null)
    { 
        $result = null;
        
        if ($option = 'send-mail') {
            if (get_option('is_plan_bonus')==1) {
                if (get_option('min_affiliate_amount') <= $params['amount'] ) {
                    $this->load->model('user_model');
                    $this->user_model->add_affiliate_bonus(session('uid'), $params['amount']);
                }
            }
            
            if (get_option('is_order_notice_email')==1) {
                $author = $_SESSION['user_current_info']['first_name'] . ' ' . $_SESSION['user_current_info']['last_name'];

                $mail_params = [
                    'template' => [
                        'subject' => "{{website_name}}" . " - new plan",
                        'message' => $params['message'],
                        'type' => 'default',
                    ],
                    'from_email_data' => [
                        'from_email' => $_SESSION['user_current_info']['email'],
                        'from_email_name' => $author,
                    ],
                ];
                $this->send_notice_mail($mail_params);
            }
            return ["status" => "success", "message" => lang("Update_successfully")];
        }
        return $result;
    }

    private function send_notice_mail($params = [], $option = [])
    {
        $staff_mail = $this->get("id, email", $this->tb_staff, [], "id", "ASC")->email;
        $user_mail = $this->get("id, email", USERS, ['id'=>session('uid')])->email;
        
        $send_message = $this->send_mail_template($params['template'], $staff_mail, $params['from_email_data']);
        $send_message = $this->send_mail_template($params['template'], $user_mail);
        if ($send_message) {
            return ["status" => "error", "message" => $send_message];
        } 
    }
    
    
}
