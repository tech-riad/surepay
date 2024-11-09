<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_model extends MY_Model 
{

    protected $tb_users;
    protected $tb_main;
    protected $filter_accepted;
    protected $field_search_accepted;

    public function __construct()
    {
        parent::__construct();
        $this->controller_name = 'invoice';
        $this->tb_main     = INVOICE;
        $this->users     = USERS;

        $this->filter_accepted = array_keys(app_config('template')['status']);
        unset($this->filter_accepted['3']);
        $this->field_search_accepted = app_config('config')['search']['invoice'];

    }

    public function list_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'list-items') {
            $this->db->select('c.*,u.email');
            $this->db->where('user_id', session('uid'));
            $this->db->from($this->tb_main.' c'); 
            $this->db->join($this->users.' u', 'u.id = c.user_id', 'left');

            
            $this->db->order_by('c.id', 'DESC');
            

            $query = $this->db->get();
            $result = $query->result_array();
        }
        
        return $result;
    } 

    public function get_item($params = null, $option = null)
    {
        $result = null;
        if($option['task'] == 'get-item'){
            $result = $this->get("*", $this->tb_main, ['id' => $params['id']], '', '', true);
        }
        return $result;
    }

    public function count_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'count-items-group-by-status') {
            $this->db->select('count(id) as count, status');
            $this->db->where('user_id', session('uid'));
            $this->db->from($this->tb_main );
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
            $this->db->where('user_id', session('uid'));
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
            $item = $this->get("id, ids", $this->tb_main, ['id' => $params['id']]);
            if ($item) {
                $this->db->delete($this->tb_main, ["id" => $params['id'], 'user_id'=>session('uid')] );
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
            
                
        switch ($option['task']) {
                
            case 'add-item':
                $this->db->where('id', session('uid'));
                $user_email = $this->db->get(USERS)->row()->email;
                $data = [
                    "ids"                    =>ids(),
                    "customer_name"          => post("customer_name"),
                    "customer_number"          => post("customer_number"),
                    "customer_email"         => post("customer_email"),
                    "customer_address"       => post('customer_address'),
                    "customer_description"   => post('customer_description'),
                    "user_id"                => session('uid'),
                    "user_email"             => $user_email,
                    "customer_amount"        => post("customer_amount"),
                    "domain"                =>post("domain"),
                    "created"               =>post("created"),
                    "status"                => (int)post("status"),
                    "pay_status"                => (int)post("pay_status"),
                    'created' => now(),
                ];
                $this->db->insert($this->tb_main, $data);
                return ["status"  => "success", "message" => 'Added successfully'];
                break;

            case 'edit-item':
                $data = [
                    "customer_number"          => post("customer_number"),
                    "customer_name"          => post("customer_name"),
                    "customer_email"         => post("customer_email"),
                    "customer_address"       => post('customer_address'),
                    "customer_description"   => post('customer_description'),
                    "customer_amount"        => post("customer_amount"),
                    "domain"                =>post("domain"),
                    "created"               =>post("created"),
                    "status"                => (int)post("status"),
                    "pay_status"                => (int)post("pay_status"),
                ];
                $this->db->update($this->tb_main, $data, ["id" => post('id'), 'user_id'=>session('uid')]);
                return ["status"  => "success", "message" => 'Update successfully'];
                break;

            case 'change-status':
                $this->db->update($this->tb_main, ['status' => $params['status']], ["id" => $params['id']]);
                return ["status"  => "success", "message" => 'Update successfully'];
                break;

            case 'bulk-action': 
                if (in_array($params['type'], ['delete', 'deactive', 'active']) && empty($params['ids'])) {
                    return ["status"  => "error", "message" => 'Please choose at least one item'];
                }
                $arr_ids = convert_str_number_list_to_array($params['ids']);
                switch ($params['type']) {
                    case 'delete':
                        $this->db->where('user_id', session('uid'));
                        $this->db->where_in('ids', $arr_ids);
                        $this->db->delete($this->tb_main);

                        return ["status"  => "success", "message" => 'Delete successfully'];
                        break;
                    case 'deactive': 
                        // Category
                        $this->db->where('user_id', session('uid'));
                        $this->db->where_in('id', $arr_ids);
                        $this->db->update($this->tb_main, ['status' => 0]);
                        return ["status"  => "success", "message" => 'Update successfully'];
                        break;
                    case 'active':
                        //  Payment bonues
                        $this->db->where('user_id', session('uid'));
                        $this->db->where_in('id', $arr_ids);
                        $this->db->update($this->tb_main, ['status' => 1]);
                        return ["status"  => "success", "message" => 'Update successfully'];
                        break;
                }
                break;
        }
    }
}
