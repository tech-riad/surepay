<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model 
{
    protected $tb_main;

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = USERS;
    }

    public function get_item($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'get-item-current-admin') {
            $result = $this->get("id, ids, first_name, last_name, email, timezone, password,more_information", $this->tb_main, ['id' => session('uid')], '', '', true);
        }
        
        return $result;
    }

    public function save_item($params = null, $option = null)
    {
        switch ($option['task']) {
            case 'update-info-item':
                $data = array(
                    "first_name"   => post("first_name"),
                    "last_name"    => post("last_name"),
                    "avatar"       => post("avatar"),
                );
                $info = $this->get('more_information,id',$this->tb_main,['id'=>session('uid')])->more_information;


                $more_information = [
                    'business_name' => post('business_name'),
                    'business_email' => post('business_email'),
                    'business_logo' => post('business_logo'),
                    'website' => post('website'),
                ];
                $data['more_information'] = json_encode($more_information);

                $this->db->update($this->tb_main, $data, ["ids" => post('ids')]);
                return ["status"  => "success", "message" => 'Update successfully'];
                break;

            case 'change-pass-item':
                $data = [
                    'password' => $this->app_password_hash(post('password')),
                ];
                $this->db->update($this->tb_main, $data, ["ids" => post('ids')]);
                return ["status"  => "success", "message" => 'Password changed successfully!'];
                break;
        }
    }

    public function verify_admin_access($params = null, $option = null)
    {
        if ($option['task'] == 'check-admin-secret-key') {
            $item_admin = $this->get_item(null, ['task' => 'get-item-current-admin']);
            $check_secret_key   = $this->app_password_verify($params['secret_key'], $item_admin['password']);
            if ($check_secret_key) {
                return true;
            } else {
                return false;
            }
        }
    } 
    public function add_affiliate_bonus($uid,$amount){
        $user = $this->get('id, first_name, last_name, email, ref_id, balance, timezone', $this->tb_main, ["id" => $uid]);
        if (!empty($id = $user->ref_id)) {
            $this->db->where('uid', $id);
            $row_count = $this->db->count_all_results('affiliates');
            if (get_option('max_affiliate_time') >= $row_count ) {
                $affiliate_bonus_type = get_option('affiliate_bonus_type');
                $affiliate_bonus      = get_option('affiliate_bonus');

                if ($affiliate_bonus_type == 0) {
                    $bonus = $affiliate_bonus;
                }else{
                    $bonus = $amount * $affiliate_bonus / 100;
                }

                $data = array(
                    'uid'       => $id, 
                    'ref_id' => $uid,
                    'amount'    => $bonus,
                    'created'   =>now()
                );
                $this->db->insert('affiliates', $data);

                $this->db->where('id', $id);
                $this->db->set('balance', 'balance + ' . $bonus, false);
                $this->db->update(USERS);

                $message = "You have got tk ".$bonus." from referal program bouns";

                if ($this->db->affected_rows()) { 
                    //insert to transaction id
                    $data_item_tnx = [
                        "ids"            => ids(),
                        "uid"            => $id,
                        "type"           => 'Bonus',
                        "transaction_id" => trxId(),
                        "message"        => $message,
                        "amount"         => $bonus,
                        "created"        => now(),
                    ];
                    $this->db->insert(TRANSACTION_LOGS, $data_item_tnx);
                    return ["status"  => "success", "message" => 'Update successfully'];
                };

            }


        }
        return;

    }
}
