<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends MY_Model {
	public function __construct(){
		parent::__construct();
	}
	public function list_items($params = null, $option = null,$id="")
    {
        $result = null;
                
        if ($option['task'] == 'list-items-blogs') {
            $this->db->select('*');
            $this->db->from('general_blogs');
            $this->db->where("(created < '".NOW."')");
            $this->db->where('status', 1);
            $this->db->order_by('created', 'DESC');
            $query = $this->db->get();
            $result = $query->result_array();
        }
        if ($option['task'] == 'list-items-payments') {
            $this->db->select('params');
            $this->db->from('payments');
            $this->db->where('status', 1);
            $query = $this->db->get();
            $result = $query->result_array();
        }
        if ($option['task'] == 'list-items-blog') {
            $this->db->select('*');
            $this->db->from('general_blogs');
            $this->db->where("(created < '".NOW."')");
            $this->db->where('status', 1);
            $this->db->where('id', $id);
            $this->db->order_by('created', 'DESC');
            $query = $this->db->get();
            $result = $query->result_array();
        }
        
        if ($option['task'] == 'list-items-faq') {
            $result = $this->fetch("*", 'faqs', ['status' => 1], 'sort', 'ASC', '', '', true);
        }
        if ($option['task'] == 'list-items-plans') {
            $result = $this->fetch("*", 'plans', ['status' => 1], 'sort', 'ASC', '', '', true);
        }

        return $result;
    }
    public function get_item($params = null, $option = null)
    {
        $result = null;
        if($option['task'] == 'get-item'){
            $this->db->select('i.*, u.id, u.more_information,u.api_credentials,i.domain,i.customer_name,i.customer_email');
            $this->db->from(INVOICE.' i');
            $this->db->where('i.ids', $params['ids']);
            $this->db->where('i.status', 1);
            $this->db->join(USERS.' u', 'u.id = i.user_id', 'left');
            
            $result = $this->db->get()->row_array();
        }
        return $result;
    }

}
