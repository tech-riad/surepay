<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends My_UserController {
    private $tb_main;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(get_class($this) . '_model', 'main_model');
        $this->controller_name = strtolower(get_class($this));
        $this->controller_title = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views = 'profile';
        $this->params = [];
        $this->tb_main = USERS;
    }
	public function index()
	{
		if (is_client_logged_in()) {
			redirect(client_url('dashboard'));
		}
		redirect(base_url('signin'));		
	}

    
    public function profile()
    {
        $item = $this->main_model->get("avatar,id, status, ids, email, password, first_name, last_name, more_information, timezone", $this->tb_main, ['id' => session('uid')], '', '', true);
        $data = array(
            "controller_name" => $this->controller_name,
            "item" => $item,
        );
        $this->template->build($this->path_views.'/profile', $data);
    }
    public function refferal()
    {
        $this->template->build($this->path_views.'/refferal');
    }

    public function store() 
    { 
        if (!$this->input->is_ajax_request()) {
            redirect(client_url($this->controller_name));
        }

        if ($this->input->post('store_type') == 'update_info') { 
            $task = 'update-info-item';
            $this->form_validation->set_rules('first_name', 'first name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('last_name', 'last name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('business_name', 'business name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('business_email', 'business email', 'trim|valid_email|required|xss_clean');
            $this->form_validation->set_rules('website', 'Website', 'trim|required|is_valid_domain');
            
        }

        if ($this->input->post('store_type') == 'change_pass') {
            $task = 'change-pass-item';

            $this->form_validation->set_rules('old_password', 'old password', 'trim|required|min_length[6]|max_length[25]|xss_clean');
            $this->form_validation->set_rules('password', 'new password', 'trim|required|min_length[6]|max_length[25]|differs[old_password]|xss_clean');
            $this->form_validation->set_rules('confirm_password', 'confirm password', 'trim|required|min_length[6]|max_length[25]|matches[password]|xss_clean');
            //Check secret key
            $is_valid_secret_key = $this->main_model->verify_admin_access(['secret_key' => post('old_password')], ['task' => 'check-admin-secret-key']);
            if (!$is_valid_secret_key) {
                _validation('error', 'The old password you entered does not match your existing password');
            }
        }
        if (!$this->form_validation->run()) {
            _validation('error', validation_errors());
        }

        $response = $this->main_model->save_item($this->params, ['task' => $task]);
        ms($response);
    }

	public function logout()
    {
        unset_session("uid"); 
        unset_session("user_current_info");
        delete_cookie("sessionData");

        // $this->session->sess_destroy();
        if (get_option("is_maintenance_mode")) {
            delete_cookie("verify_maintenance_mode");
        }
        $this->session->set_flashdata('message',array('message'=>'Logout successfully','status'=>'success'));

        redirect(cn('signin'));
    }

}

/* End of file User.php */
/* Location: .//E/laragon/www/gateway-3/app/modules/user/controllers/User.php */
