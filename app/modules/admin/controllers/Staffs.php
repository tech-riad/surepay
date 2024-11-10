<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Staffs extends My_AdminController {
    private $tb_main = STAFFS;

    public function __construct()
    {
        if (!is_current_logged_staff()) redirect(admin_url('logout'));
        parent::__construct();
        $this->load->model(get_class($this) . '_model', 'main_model');

        $this->controller_name = strtolower(get_class($this));
        $this->controller_title = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views = "staffs";
        $this->params = [];
        $this->tb_main = USERS;
        $this->columns = array(
            "staffs" => ['name' => 'Staff Profile', 'class' => ''],
            "timezone" => ['name' => 'Time Zone', 'class' => 'text-center'],
            "created" => ['name' => 'Created', 'class' => 'text-center'],
            "status" => ['name' => 'Status', 'class' => 'text-center'],
        );
        
    }

    public function store()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(admin_url($this->controller_name));
        }

        $this->form_validation->set_rules('first_name', 'first name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('last_name', 'last name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', 'status', 'trim|required|in_list[0,1]|xss_clean');
        $ids = post('ids');
        $email_unique = "|edit_unique[$this->tb_main.email.$ids]";
        if ($ids) {
            if (post('store_type') != 'user_information') {
                $task = 'edit-item';
            } else {
                $task = 'edit-item-information';
            }
        } else {
            $task = 'add-item';
            $email_unique = "|is_unique[$this->tb_main.email]";
            $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|max_length[25]|xss_clean');
        }
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean' . $email_unique, [
            'is_unique' => 'The email already exists.',
        ]);
        if (!$this->form_validation->run() && in_array($task, ['add-item', 'edit-item'])) {
            _validation('error', validation_errors());
        }

        $response = $this->main_model->save_item($this->params, ['task' => $task]);
        ms($response);
    }

    // Edit Users
    public function update($ids = null)
    {
        $item = null;
        $item_infor =null;
        $this->load->model('payments_model');
        $items_payment = $this->payments_model->list_items('', ['task' => 'admin-active-list-items']);

        if ($ids !== null) {
            $this->params = ['ids' => $ids];
            $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
            $item_infor = $item['more_information'];
        }
        $data = array(
            "controller_name" => $this->controller_name,
            "item" => $item,
            "items_payment" => $items_payment,
            "item_infor" => $item_infor,
        );
        if (!$this->input->is_ajax_request()) {
            $this->template->build($this->path_views . "/update", $data);
        }else{
            $this->load->view($this->path_views . '/update', $data);
        }
    }

}