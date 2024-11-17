<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends MY_Model 
{

    protected $tb_main;
    protected $filter_accepted;
    protected $field_search_accepted;

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = USERS;
        $this->tb_transaction_logs = TRANSACTION_LOGS;

        $this->filter_accepted = array_keys(app_config('template')['status']);
        unset($this->filter_accepted['3']);
        $this->field_search_accepted = app_config('config')['search']['users'];
    }

    public function list_items($params = null, $option = null)
    {
        $result = null;
       
        if ($option['task'] == 'list-items') {
            $this->db->select('id, ids, first_name, last_name,email,phone, balance,more_information, history_ip, status, created_at');
            $this->db->from($this->tb_main);

            // filter
            if ($params['filter']['status'] != 3 && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('status', $params['filter']['status']);
            }
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $this->db->like($params['search']['field'], $params['search']['query']); 
            }

            $this->db->order_by('id', 'DESC');
            if ($params['pagination']['limit'] != "" && $params['pagination']['start'] >= 0) {
                $this->db->limit($params['pagination']['limit'], $params['pagination']['start']);
            }

            $query = $this->db->get();
            $result = $query->result_array();
        }
        
        if ($option['task'] == 'export-list-items') {
            $result = $this->fetch('id, first_name, last_name, email,phone, timezone, balance, status, created_at', $this->tb_main);
        }

        if ($option['task'] == 'user-price-list-items') {
            $this->db->select('up.id, up.uid, up.service_id, up.service_price');
            $this->db->select('s.name, s.original_price, s.price');
            $this->db->from($this->tb_services." s");
            $this->db->join($this->tb_users_price." up", "s.id = up.service_id", 'left');
            $this->db->where('up.uid', $params['uid']);
            $this->db->order_by('up.id', 'ASC');
            $query = $this->db->get();
            $result = $query->result_array();
        }
        if ($option['task'] == 'admin-list-items-on-invoice') {
            $result = $this->fetch("ids,id, email", $this->tb_main, [], '', '', true);
        }

        if ($option['task'] == 'items-last-users') {
            $this->db->select('id, ids, first_name, last_name, email,phone, balance, history_ip, status, created_at');
            $this->db->from($this->tb_main);
            $this->db->order_by('id', 'desc');
            $this->db->limit($params['limit'], 0);
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return $result; 
    }

    public function get_item($params = null, $option = null)
    {
        $result = null;
        if($option['task'] == 'get-all-item'){
            $result = $this->fetch("*", $this->tb_main, '', '', '', true);
        }
        
        if($option['task'] == 'get-item'){
            $result = $this->get("id, ids, first_name, last_name, timezone,phone, email, balance, history_ip, more_information, status, created_at", $this->tb_main, ['ids' => $params['ids']], '', '', true);
        }

        
        if($option['task'] == 'get-user-ip'){
            $this->db->select('u.id, u.email, u.first_name,u.last_name, g.*');
            $this->db->from('general_user_logs g');
            $this->db->join(USERS.' u', 'u.id = g.uid', 'left');
            $this->db->order_by('g.id', 'desc');
            $result = $this->db->get()->result_array();
        }
        if($option['task'] == 'get-kyc'){
            $this->db->select('u.first_name,u.last_name,u.email,u.ids,k.*');
            $this->db->from('kyc k');
            $this->db->join(USERS.' u', 'u.id = k.user_id', 'left');
            $this->db->order_by('k.id', 'desc');
            $result = $this->db->get()->result_array();
        }
        if ($option['task'] == 'get-user-kyc') {
            $result = $this->get('params,ids,user_id','kyc',['ids'=>$params['ids']],'', '', true);
        }

        return $result;
    }

    public function count_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'count-items-group-by-status') {
            $this->db->select('count(id) as count, status');
            $this->db->from($this->tb_main);
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $this->db->like($params['search']['field'], $params['search']['query']); 
            }

            $this->db->order_by('status', 'DESC');
            $this->db->group_by('status');
            $query = $this->db->get();
            $result = $query->result_array();
        }

        // Count items for pagination
        if ($option['task'] == 'count-items-for-pagination') {
            $this->db->select('id');
            $this->db->from($this->tb_main);
            if ($params['filter']['status'] != 3 && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('status', $params['filter']['status']);
            }
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        if($i == 1){
                            $this->db->like($column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like($column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $this->db->like($params['search']['field'], $params['search']['query']); 
            }
            $query = $this->db->get();
            $result = $query->num_rows();
        }
        return $result;
    }

    public function delete_item($params = null, $option = null)
    {
        $result = [];
        if($option['task'] == 'delete-item'){
            $item = $this->get("id, ids", $this->tb_main, ['ids' => $params['id']]);
            if ($item) {
                $this->db->where('id !=1');
                $this->db->delete($this->tb_main, ["ids" => $params['id']]);
                $result = [
                    'status' => 'success',
                    'message' => 'Deleted successfully',
                    "ids"     => $item->ids,
                ];
            }else{
                $result = [
                    'status' => 'error',
                    'message' => 'There was an error processing your request. Please try again later',
                ];
            }
        }
        return $result;
    }

    public function save_item($params = null, $option = null)
    {
        if (in_array($option['task'], ['add-item', 'edit-item'])) {
            $data = array(
                "first_name"   => post("first_name"),
                "last_name"    => post("last_name"),
                "email"        => post("email"),
                "status"       => (int)post("status"),
                "reset_key"    => ids(),
            );
        }
        switch ($option['task']) {
             
            case 'add-item':
                $more_information = [
                    'business_name' => '',
                    'business_email' => '',
                    'business_logo' => '',
                    'website' => '',
                ];
                
                $api_credentials = [
                    'apikey' => create_random_string_key(13),
                    'secretkey' => create_random_string_key(8, 'number'),
                ];
                
                $data = [
                    "ids"               => ids(),
                    "first_name"        => post("first_name"),
                    "last_name"         => post("last_name"),
                    "email"             => post("email"),
                    "phone"             => post("phone"),
                    "otp"               => rand(100000, 999999),
                    "otp_expiry"        => date("Y-m-d H:i:s", strtotime("+5 minutes")),
                    'phone_varified_at' => now(),
                    "password"          => $this->app_password_hash(post('password')),
                    "status"            => (int)post("status"),
                    "more_information"  => json_encode($more_information),
                    "api_credentials"   => json_encode($api_credentials),
                ];
            
                $this->db->insert($this->tb_main, $data);
            
                if ($this->db->affected_rows() > 0) {
                    return ["status" => "success", "message" => 'Added successfully'];
                } else {
                    return ["status" => "error", "message" => 'Failed to add record.'];
                }
            
                break;
            
                case 'edit-item':
                    $data = [
                        "first_name"        => post("first_name"),
                        "last_name"         => post("last_name"),
                        "email"             => post("email"),
                        "phone"             => post("phone"), 
                        "status"            => (int)post("status"),
                    ];
                    
                   
                    $data = array_filter($data, function ($value) {
                        return $value !== null;
                    });
            
                    $this->db->update($this->tb_main, $data, ["ids" => post('ids')]);
            
                    if ($this->db->affected_rows() > 0) {
                        return ["status" => "success", "message" => 'Updated successfully'];
                    } else {
                        return ["status" => "error", "message" => 'Failed to update record or no changes detected.'];
                    }
                    break;

            case 'edit-item-information':
                $more_information = [
                    'business_name' => post('business_name'),
                    'business_email' => post('business_email'),
                    'business_logo' => post('business_logo'),
                    'website' => post('website'),
                ];
                $data['more_information'] = json_encode($more_information);
                $this->db->update($this->tb_main, $data, ["ids" => post('ids')]);
                return ["status"  => "success", "message" => 'Updated successfully'];
                break;

            case 'change-status':
                $this->db->update($this->tb_main, ['status' => $params['status']], ["ids" => $params['id']]);
                return ["status"  => "success", "message" => 'Updated successfully'];
                break;

            case 'set-password':
                $data = [
                    'password' => $this->app_password_hash(post('password')),
                ];
                $this->db->update($this->tb_main, $data, ["ids" => post('ids')]);
                return ["status"  => "success", "message" => 'Password changed successfully!'];
                break;
            case 'save-user-kyc':
                if (post('k_status')=='3') {
                    $info = get_current_user_data($params['user_id'])->more_information;
                    $more_information = [
                        'business_name' => get_value($info,'business_name'),
                        'business_email' => get_value($info,'business_email'),
                        'business_logo' => get_value($info,'business_logo'),
                        'website' => get_value($info,'website'),
                    ];

                    $data['more_information'] = json_encode($more_information);  
                    $this->db->update($this->tb_main, $data, ["id" => $params['user_id']]);
                    return ["status"  => "success", "message" => 'User KYC verified successfully'];
                    break;                  
                }else{
                    $info = get_current_user_data($params['user_id'])->more_information;
                    $more_information = [
                        'business_name' => get_value($info,'business_name'),
                        'business_email' => get_value($info,'business_email'),
                        'business_logo' => get_value($info,'business_logo'),
                        'website' => get_value($info,'website'),
                    ];

                    $data['more_information'] = json_encode($more_information);  
                    $this->db->update($this->tb_main, $data, ["id" => $params['user_id']]);
                    return ["status"  => "success", "message" => 'KYC is Cancelled'];
                    break; 
                }
                

            case 'bulk-action':
                if (in_array($params['type'], ['delete', 'deactive', 'active']) && empty($params['ids'])) {
                    return ["status"  => "error", "message" => 'Please choose at least one item'];
                }
                $arr_ids = convert_str_number_list_to_array($params['ids']);
                switch ($params['type']) {
                    case 'delete':
                        $this->db->where_in('ids', $arr_ids);
                        $this->db->where('id !=1');
                        $this->db->delete($this->tb_main);

                        return ["status"  => "success", "message" => 'Delete successfully'];
                        break;
                    case 'deactive':
                        // Category
                        $this->db->where_in('ids', $arr_ids);
                        $this->db->update($this->tb_main, ['status' => 0]);

                        return ["status"  => "success", "message" => 'Update successfully'];
                        break;
                    case 'active':
                        $this->db->where_in('ids', $arr_ids);
                        $this->db->update($this->tb_main, ['status' => 1]);

                        return ["status"  => "success", "message" => 'Update successfully'];
                        break;
                }
                break;
        }
    }

    public function save_funds($params = null, $option = null)
    {
        if ($option['task'] == 'add-funds') {
            // Update balance to user
            if (post('type')=='add') {
                $data_item = [
                    'balance' => $params['item']['balance'] + (double)post('amount'),
                ];
                $message = 'Balance added by Admin and transaction_id:'.post('transaction_id');
            }else{
                $data_item = [
                    'balance' => $params['item']['balance'] - (double)post('amount'),
                ];  
                $message = 'Balance deducted by Admin and transaction_id:'.post('transaction_id');              
            }
            
            $this->db->update($this->tb_main, $data_item, ['ids' => post('ids')]);
            if ($this->db->affected_rows()) { 
                //insert to transaction id
                $data_item_tnx = [
                    "ids"            => ids(),
                    "uid"            => $params['item']['id'],
                    "type"           => post('payment_method'),
                    "transaction_id" => trxId(),
                    "message"        => $message,
                    "amount"         => (double)post('amount'),
                    "created"        => now(),
                ];
                $this->db->insert($this->tb_transaction_logs, $data_item_tnx);
                return ["status"  => "success", "message" => 'Update successfully'];
            };
            
        }
        if ($option['task'] == 'edit-funds') {
            $data_item = [
                'balance' => (double)post('new_balance'),
            ];
            $this->db->update($this->tb_main, $data_item, ['ids' => post('ids')]);
            if ($this->db->affected_rows()) {
                return ["status"  => "success", "message" => 'Update successfully'];
            };
        }
    }

}
