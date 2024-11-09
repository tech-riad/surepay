<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Plans extends My_AdminController {

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');
        if (!is_current_logged_staff()) redirect(admin_url('logout'));
        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "plans";
        $this->params            = [];
        $this->columns     =  array(
            "name"             => ['name' => 'Plan Name',    'class' => ''],
            "website"         => ['name' => 'Website', 'class' => 'text-center'],
            "device"         => ['name' => 'Device', 'class' => 'text-center'],
            "price"         => ['name' => 'Price', 'class' => 'text-center'],
            "sort"         => ['name' => 'sort', 'class' => 'text-center'],
            "status"           => ['name' => 'Status',  'class' => 'text-center'],
        );
    }
    public function user_plan(){
        $this->db->select('us.email,p.name,u.*');
        $this->db->from('users_plan u');
        $this->db->join('plans p', 'p.id = u.plan_id', 'left');
        $this->db->join('general_users us', 'us.id = u.uid', 'left');
        $this->db->order_by('u.id', 'desc');

        $data['items'] = $this->db->get()->result_array();

        $this->template->build($this->path_views . "/user_plan", $data);
    }
 
    // Edit form
    public function update($id = null){
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $item = null;
        if ($id !== null) {
            $this->params = ['id' => $id];
            $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
        }
        $data = array(
            "controller_name"   => $this->controller_name,
            "item"              => $item,
        );
        $this->load->view($this->path_views . '/update', $data);
    }
    public function edit_user_plan($id = null){
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $item = null;
        if ($id !== null) {
            $this->params = ['id' => $id];
            $item = $this->main_model->get_item($this->params, ['task' => 'get-user-item']);
        }
        $data = array(
            "controller_name"   => $this->controller_name,
            "item"              => $item,
        );
        $this->load->view($this->path_views . '/edit_user_plan', $data);
    }
    public function user_plan_update()
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $this->form_validation->set_rules('device', 'Device Number', 'trim|required|xss_clean');
        $this->form_validation->set_rules('website', 'Website Number', 'trim|required|xss_clean');
        $this->form_validation->set_rules('duration', 'Duration', 'trim|required|xss_clean');

        if (!$this->form_validation->run()) _validation('error', validation_errors());
        if (post('duration')>0) {
            $expire =  calculateExpirationDate(post('duration'),post('expire'));
        }else{
            $expire =  post('expire');
        }
        $data_plan = array(
            "website"           => post('website'),
            "device"           => post('device'),
            "expire"            => $expire,
        );
        $this->db->update('users_plan', $data_plan, ["id" => post('id')]);
        if ($this->db->affected_rows() > 0) {
           ms(["status"  => "success", "message" => 'Update successfully']);
        } else {
            ms(["status"  => "error", "message" => 'Failed to update successfully']);
        }

    }

    public function store(){
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        
        $this->form_validation->set_rules('name', 'Package Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('device', 'Device Number', 'trim|required|xss_clean|is_numeric');
        $this->form_validation->set_rules('price', 'Offer Price', 'trim|required|xss_clean');
        $this->form_validation->set_rules('pre_price', 'Regular Price', 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]|xss_clean');
        $this->form_validation->set_rules('duration', 'Duration', 'trim|required');
        $this->form_validation->set_rules('duration_type', 'Duration type', 'trim|required');

        if (!$this->form_validation->run()) _validation('error', validation_errors());
        if (!empty(post('id'))) {
            $task = 'edit-item';
        }else{
            $task = 'add-item';
        }

        $response = $this->main_model->save_item( $this->params, ['task' => $task]);
        ms($response);
    }
    public function change_sort($id = "")
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        $params = [
            'id'        => $id,
            'sort'      => (int)post('sort'),
        ];
        $response = $this->main_model->save_item($params, ['task' => 'change-sort']);
        ms($response);
    }
    public function sortplans()
    {
        if (!$this->input->is_ajax_request()) redirect(admin_url($this->controller_name));
        foreach (post('sort') as $key => $value) {
            $params = [
                'id'        => $value,
                'sort'      => (int)($key+1),
            ];
            $response = $this->main_model->save_item($params, ['task' => 'change-sort-all']);
        }
        ms(["status"  => "success", "message" => 'Update successfully']);
    }
}