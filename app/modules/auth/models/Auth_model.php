<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends MY_Model {
	
	public function add_affiliate_bonus($uid,$bonus){
        $user = $this->get('id, first_name, last_name, email, ref_id, balance, timezone', USERS, ["id" => $uid]);
        if (!empty($id = $user->ref_id)) {
            $this->db->where('uid', $id);
                        
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

            $message = "You have got tk ".$bonus." from referal programs SignUp bouns";

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
        return;

    }
}

/* End of file Auth_model.php */
/* Location: .//E/laragon/www/gateway-3/app/modules/auth/models/Auth_model.php */