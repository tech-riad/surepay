<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staffs_model extends MY_Model 
{

    protected $tb_main;

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = STAFFS;
    }

    public function staffs($params = null, $option = null)
    {
        $result = null;
       
        
        $this->db->select('id,first_name, last_name, email');
        $this->db->from($this->tb_main);
        $this->db->order_by('id', 'desc');
        $this->db->limit($params['limit'], 0);
        $query = $this->db->get();
        $result = $query->result_array();
        
        return $result; 
    }


}
