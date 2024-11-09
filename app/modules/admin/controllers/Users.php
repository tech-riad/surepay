<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends My_AdminController
{

    private $tb_main = USERS;

    public function __construct()
    {
        if (!is_current_logged_staff()) redirect(admin_url('logout'));
        parent::__construct();
        $this->load->model(get_class($this) . '_model', 'main_model');

        $this->controller_name = strtolower(get_class($this));
        $this->controller_title = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views = "users";
        $this->params = [];
        $this->tb_main = USERS;
        $this->columns = array(
            "users" => ['name' => 'User Profile', 'class' => ''],
            "funds" => ['name' => 'Balance', 'class' => 'text-center'],
            "created" => ['name' => 'Created', 'class' => 'text-center'],
            "status" => ['name' => 'Status', 'class' => 'text-center'],
        );
        
    }

    public function sendEmailsToAllUsers() {
        $this->form_validation->set_rules('mail_subject', 'Mail subject', 'trim|required|xss_clean');
        $this->form_validation->set_rules('mail_body', 'Mail body', 'trim|required|xss_clean');
        if (!$this->form_validation->run()) {
            _validation('error', validation_errors());
        }

        $this->load->model('home/Queue_model');

        $allUserEmails = $this->main_model->get_item($this->params,['task'=>'get-all-item']);

        $success =0;
        $failed  =0;

        foreach ($allUserEmails as $email) {
            
            $mail_subject = post('mail_subject');
            $mail_subject = str_replace("{{user_firstname}}", $email->first_name, $mail_subject);
            $mail_subject = str_replace("{{user_lastname}}", $email->last_name, $mail_subject);
            $mail_subject = str_replace("{{email}}", $email->email, $mail_subject);
            $mail_subject = str_replace("{{balance}}", $email->balance, $mail_subject);

            $email_content = post('mail_body');
            $email_content = str_replace("{{user_firstname}}", $email->first_name, $email_content);
            $email_content = str_replace("{{user_lastname}}", $email->last_name, $email_content);
            $email_content = str_replace("{{email}}", $email->email, $email_content);
            $email_content = str_replace("{{balance}}", $email->balance, $email_content);
           
            $sent = $this->Queue_model->addTask('send_email', json_encode(['to' => $email->email, 'subject' => $mail_subject, 'message' => $email_content]));
            if ($sent) {
                $success++;
            }else{
                $failed++;
            }
        }

        ms(['status'=>'success','message'=>$success.' mail sent successfully and '. $failed.' mail failed']);
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

    // More details
    public function info($ids = null)
    {
        if (!$this->input->is_ajax_request()) {
            redirect(admin_url($this->controller_name));
        }

        $item = null;

        if ($ids !== null) {
            $this->params = ['ids' => $ids];
            $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
            $item_infor = $item['more_information'];
        }
        $data = array(
            "controller_name" => $this->controller_name,
            "item" => $item,
            "item_infor" => $item_infor,
        );
        $this->load->view($this->path_views . '/info', $data);
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

    // add_funds
    public function add_funds($ids = null)
    {
        if (!$this->input->is_ajax_request()) {
            redirect(admin_url($this->controller_name));
        }

        if ($this->input->post('ids')) {
            $this->form_validation->set_rules('payment_method', 'payment method', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount', 'amount', 'trim|required|validate_money|greater_than[0]|xss_clean');
            $this->form_validation->set_rules('secret_key', 'secret key', 'trim|required|xss_clean');
            $this->form_validation->set_rules('transaction_id', 'transaction id', 'trim|required|xss_clean');

            if (!$this->form_validation->run()) {
                _validation('error', validation_errors());
            }

            //Check item
            $item = $this->main_model->get_item(['ids' => post('ids')], ['task' => 'get-item']);
            if (!$item) {
                _validation('error', 'The account does not exists');
            }
            //Check secret key
            $this->load->model('admin_model');
            $is_valid_secret_key = $this->admin_model->verify_admin_access(['secret_key' => post('secret_key')], ['task' => 'check-admin-secret-key']);
            if ($is_valid_secret_key) {
                $response = $this->main_model->save_funds(['item' => $item], ['task' => 'add-funds']);
                ms($response);
            } else {
                _validation('error', 'The secret key is invalid.');
            }
        } else {
            $item = null;
            if ($ids !== null) {
                $this->params = ['ids' => $ids];
                $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
            }
            $this->load->model('payments_model');
            $items_payment = $this->payments_model->list_items(null, ['task' => 'user-list-items-add-funds']);

            $data = array(
                "controller_name" => $this->controller_name,
                "item" => $item,
                "items_payment" => $items_payment,
            );
            $this->load->view($this->path_views . '/add_funds', $data);
        }
    }

    // Set Password
    public function set_password($ids = null)
    {
        if (!$this->input->is_ajax_request()) {
            redirect(admin_url($this->controller_name));
        }

        if ($this->input->post('ids')) {
            $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|max_length[25]|xss_clean');
            $this->form_validation->set_rules('secret_key', 'secret key', 'trim|required|xss_clean');

            if (!$this->form_validation->run()) {
                _validation('error', validation_errors());
            }

            //Check item
            $item = $this->main_model->get_item(['ids' => post('ids')], ['task' => 'get-item']);
            if (!$item) {
                _validation('error', 'The account does not exists');
            }
            $this->load->model('admin_model');
            $is_valid_secret_key = $this->admin_model->verify_admin_access(['secret_key' => post('secret_key')], ['task' => 'check-admin-secret-key']);
            if ($is_valid_secret_key) {
                $response = $this->main_model->save_item(null, ['task' => 'set-password']);
                ms($response);
            } else {
                _validation('error', 'The secret key is invalid.');
            }
        } else {
            $item = null;
            if ($ids !== null) {
                $this->params = ['ids' => $ids];
                $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
            }
            $data = array(
                "controller_name" => $this->controller_name,
                "item" => $item,
            );
            $this->load->view($this->path_views . '/set_password', $data);
        }
    }

    // Send Mail
    public function mail($ids = null)
    {
        if (!$this->input->is_ajax_request()) {
            redirect(admin_url($this->controller_name));
        }

        if ($this->input->post('ids')) {
            $this->form_validation->set_rules('subject', 'subject', 'trim|required|min_length[6]|xss_clean');
            $this->form_validation->set_rules('message', 'message', 'trim|required|min_length[6]|xss_clean');
            $this->form_validation->set_rules('email_to', 'Receiving email', 'trim|required|xss_clean');

            if (!$this->form_validation->run()) {
                _validation('error', validation_errors());
            }

            //Check item
            $item = $this->main_model->get_item(['ids' => post('ids')], ['task' => 'get-item']);
            if (!$item) {
                _validation('error', 'The account does not exists');
            }
            $subject = get_option("website_name", "") . " - " . post('subject');
            $email_content = post('message');
            $check_email_issue = $this->main_model->send_email($subject, $email_content, $item['id'], false);
            if ($check_email_issue) {
                _validation('error', $check_email_issue);
            }

            ms(['status' => 'success', 'message' => 'The email has been successfully sent']);
        } else {
            $item = null;
            if ($ids !== null) {
                $this->params = ['ids' => $ids];
                $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
            }
            $data = array(
                "controller_name" => $this->controller_name,
                "item" => $item,
            );
            $this->load->view($this->path_views . '/send_mail', $data);
        }
    }


    public function view_user($ids = "")
    {
        if (!$this->input->is_ajax_request()) {redirect(admin_url('users/kyc'));}
        
        $this->params = ['ids' => $ids];
        $item = $this->main_model->get_item($this->params, ['task' => 'get-item']);
        if (empty($item)) {
            _validation('error', 'There was an error processing your request. Please try again later....');
        }

        set_session('uid', $item['id']);
        $data_session = array(
            'email' => $item['email'],
            'first_name' => $item['first_name'],
            'last_name' => $item['last_name'],
            'timezone' => $item['timezone'], 
        );
        /*----------  Insert User logs  ----------*/
        set_session('user_current_info', $data_session);
        if (session('uid')) {
            ms([
                'status' => 'success',
                'message' => 'Your request is being processed',
                'redirect_url' => client_url(),
                'new_page' => true,
            ]);
        }
    }

    public function activity()
    {
        $this->columns = array(
            "users" => ['name' => 'User Name', 'class' => ''],
            "email" => ['name' => 'Email', 'class' => 'text-center'],
            "type" => ['name' => 'Type', 'class' => 'text-center'],
            "ip" => ['name' => 'IP Address', 'class' => 'text-center'],
            "created" => ['name' => 'Created', 'class' => 'text-center'],
            "Action" => ['name' => 'Action', 'class' => 'text-center'],
        );
        $data = array(
            "params"              => $this->params,
            "controller_name"     => $this->controller_name,
            "columns"             => $this->columns,
            'items'               => $this->main_model->get_item($this->params, ['task' => 'get-user-ip'])
        );
        
        $this->template->build($this->path_views . '/activity', $data);
    }
    public function block($ids='')
    {
        $this->db->where('ids', $ids);
        $ip= $this->db->get(USER_LOGS)->row()->ip;
        if (!empty($ip)) {
            if (get_blocked_ip($ip)) {         

                $this->db->where('ip', $ip);
                $this->db->delete(USER_BLOCK_IP);
            }else{
                $data['ip']= $ip;
                $this->db->insert(USER_BLOCK_IP, $data);
            }

            redirect(admin_url('users/activity'));

        }else{
            show_404();
        }        

    }
    

    public function kyc()
    {
        $items = $this->main_model->get_item($this->params, ['task' => 'get-kyc']);
        $data = array(
            "items" => $items,
        );

        $this->template->build($this->path_views . "/kyc", $data);
    }
    public function view_files($id=''){
        if (!$this->input->is_ajax_request()) {redirect(admin_url('users/kyc'));}
        $this->params = ['ids'=>$id];
        $item = $this->main_model->get_item($this->params,['task' => 'get-user-kyc']);
        
        if (!empty(post('k_status'))) {
            $update_rows = array('status' => post('k_status'));
            $this->db->where('ids', $id );
            $this->db->update('kyc', $update_rows);

            $this->params = ['user_id'=>$item['user_id']];
            $response = $this->main_model->save_item($this->params, ['task' => 'save-user-kyc']);
            ms($response);
        }else{
            $update_rows = array('status' => '1');
            $this->db->where('ids', $id );
            $this->db->update('kyc', $update_rows);

            $data['item']=$item; 
            $data['req']='admin_file_read';
            $data['controller_name'] = $this->controller_name;


            $this->load->view('layouts/common/modal/files_reader',$data);            
        }


    }
}
