<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = TRANSACTION_LOGS;
        $this->filter_accepted = array_keys(app_config('template')['status']);
        unset($this->filter_accepted['3']);
        $this->field_search_accepted = app_config('config')['search']['transactions'];

    }

    public function list_items($params = null, $option = null)
    {
        $result = null;
        if ($option['task'] == 'list-items') {
            $this->db->select('t.cus_email,t.transaction_id,m.ids,m.id, m.uid, m.amount,m.transaction_id, m.status, m.type, m.created,m.currency');
            $this->db->join('temp_transaction t', 't.transaction_id = m.transaction_id', 'left');
            $this->db->from($this->tb_main.' m');
            $this->db->where('m.uid', session('uid'));
            $this->db->order_by('m.id', 'DESC');
            
            $query = $this->db->get();
            $result = $query->result_array();
        }
        if ($option['task'] == 'bank-list-items') {
            $this->db->select('t.cus_email,t.transaction_id,m.id, m.uid, m.amount,m.transaction_id, m.status, m.type,m.currency,mt.*');
            $this->db->from('bank_transaction_logs mt');
            $this->db->join('temp_transaction t', 't.ids=mt.tmp_id', 'left');
            $this->db->join('general_transaction_logs m', 't.transaction_id = m.transaction_id', 'left');
            $this->db->where('m.uid', session('uid'));
            $this->db->order_by('m.id', 'DESC');
            
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return $result;
    }

    public function count_items($params = null, $option = null)
    {
        $result = null;
        // Count items for pagination
        if ($option['task'] == 'count-items-for-pagination') {
            $this->db->select('t.cus_email,t.transaction_id,m.ids,m.id, m.uid, m.amount,m.transaction_id, m.status, m.type, m.created');
            $this->db->join('temp_transaction t', 't.transaction_id = m.transaction_id', 'left');
            $this->db->from($this->tb_main.' m');
            $this->db->where('m.uid', session('uid'));
            $this->db->order_by('m.id', 'DESC');
            // filter
            if ($params['filter']['status'] != 3 && in_array($params['filter']['status'], $this->filter_accepted)) {
                $this->db->where('m.status', $params['filter']['status']);
            }
            //Search
            if ($params['search']['field'] === 'all') {
                $i = 1;
                foreach ($this->field_search_accepted as $column) {
                    if ($column != 'all') {
                        if($i == 1){
                            $this->db->like('m.'.$column, $params['search']['query']); 
                        }elseif ($i > 1) {
                            $this->db->or_like('m.'.$column, $params['search']['query']); 
                        }
                        $i++;
                    }
                }
                $this->db->or_like('t.cus_email', $params['search']['query']); 

            }elseif (in_array($params['search']['field'], $this->field_search_accepted) && $params['search']['query'] != "") {
                $this->db->like('m.'.$params['search']['field'], $params['search']['query']); 
            }
            $query = $this->db->get();
            $result = $query->num_rows();
        }
        if ($option['task'] == 'count-items-group-by-status') {
            $this->db->select('count(id) as count, status');
            $this->db->from($this->tb_main );
            $this->db->where('uid', session('uid'));

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
            }elseif ($params['search']['query'] != "") {
                $this->db->like($params['search']['field'], $params['search']['query']); 
            }

            $this->db->order_by('status', 'DESC');
            $this->db->group_by('status');
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return $result;
    }
    

}
