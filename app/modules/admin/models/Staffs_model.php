<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staffs_model extends MY_Model 
{

    protected $tb_main;
    protected $filter_accepted;
    protected $field_search_accepted;

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = STAFFS;

        
        $this->filter_accepted = array_keys(app_config('template')['status']);
        unset($this->filter_accepted['3']);
        $this->field_search_accepted = app_config('config')['search']['staffs'];
    }



    public function list_items($params = null, $option = null)
    {
        $result = null;
       
        if ($option['task'] == 'list-items') {
            $this->db->select('id,first_name, last_name, email,timezone,status');
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
            case 'change-status':
                $this->db->update($this->tb_main, ['status' => $params['status']], ["id" => $params['id']]);
                if ($this->db->affected_rows() > 0) {
                    return ["status"  => "success", "message" => 'Updated successfully'];
                } else {
                    return ["status"  => "error", "message" => 'Update failed'];
                }

                case 'add-item':
                    $login_type = 'create_by_' . current_logged_staff()->first_name;
                    $data = [
                        "ids"               => ids(),
                        "first_name"        => post("first_name"),
                        "last_name"         => post("last_name"),
                        "email"             => post("email"),
                        "password"          => $this->app_password_hash(post('password')),
                        "status"            => (int)post("status"),
                        "role_id"           => 1,
                        "admin"             => 1,
                        "login_type"        => $login_type,
                        "timezone"          => date_default_timezone_get(),
                        "settings"          => 0,
                        "created"           => now(),
                    ];
                
                    $this->db->insert($this->tb_main, $data);
                
                    if ($this->db->affected_rows() > 0) {
                        return ["status" => "success", "message" => 'Added successfully'];
                    } else {
                        return ["status" => "error", "message" => 'Failed to add record.'];
                    }
                
                    break;

            
        }
    }


   




}
