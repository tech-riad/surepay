<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Settings extends My_UserController {

    public function __construct(){
        parent::__construct();
        $this->load->model(get_class($this).'_model', 'main_model');
         
        $this->controller_name   = strtolower(get_class($this));
        $this->controller_title  = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views        = "settings";
        $this->params            = [];
    }

    public function index($tab = "",$type="mobile"){
        $path              = APPPATH.'./modules/user/views/settings/elements';
        $elements = get_name_of_files_in_dir($path, ['.php']);
       
        if (!in_array($tab, $elements) || $tab == "") { $tab = 'api_credentials'; } 
        
        $data2 = [];
        
        
        $data2 = array(
            'payment_settings' =>$this->main_model->get('*','user_payment_settings',['uid'=>session('uid'), 'g_type'=>$tab ])
        );

        if ($tab =='domain_whitelist') {
            $items = $this->main_model->get_item($this->params, ['task' => 'get-domain']);

            $this->columns = array(
                "domain" => ['name' => 'Domain', 'class' => ''],
                "ip" => ['name' => 'IP', 'class' => 'text-center'],
                "status" => ['name' => 'Status', 'class' => 'text-center'],
            );

            $data2 = array(
                "items" => $items,
                "columns"=>$this->columns
            );
        }
        if ($tab =='devices') {
            $items = $this->main_model->get_item($this->params, ['task' => 'get-device']);

            $this->columns = array(
                "devices" => ['name' => 'Device Name', 'class' => ''],
                "created" => ['name' => 'created at', 'class' => ''],
            );

            $data2 = array(
                "items" => $items,
                "columns"=>$this->columns
            );
        } 

        $brands = $this->main_model->get_item($this->params, ['task' => 'get-domain-object']);
        $items_payment = $this->main_model->get_item($this->params, ['task' => 'active-list-items']);

        $data = array(
            "module" => get_class($this),
            "controller_name"   => $this->controller_name,
            "tab"               => $tab,
            "items_payment"     => $items_payment,
            "brands"            => $brands,
        );
        $this->template->build( $this->path_views . '/index', array_merge($data2,$data));
 
    }

    public function update($id = null){
        
        $item = null;
        if ($id !== null) {
            $this->params = ['id' => $id];
            $item = $this->main_model->get_item($this->params, ['task' => 'get-user-domain']);
        } 
        $data = array(
            "controller_name"   => $this->controller_name,
            "item"              => $item,
        );
        $this->load->view($this->path_views . '/update', $data);
    }
    public function add_device($id = null){
        
        if (!$this->input->is_ajax_request()) redirect(client_url($this->controller_name));
        $item = null;
        
        $data = array(
            "controller_name"   => $this->controller_name,
            "item"              => $item,
        );
        $this->load->view($this->path_views . '/add_device', $data);
    }

    public function store($tab='')
    {
        if (!$this->input->is_ajax_request()) redirect(client_url($this->controller_name));

        if (post('type')=='domain_whitelist') {
            if (!empty($id=post('id'))) {
                $this->form_validation->set_rules('domain', 'Domain name', 'xss_clean|trim|required|is_valid_domain'.'|edit_unique_domain[domain_whitelist.domain.'.$id.']');
            }else{
                $this->form_validation->set_rules('domain', 'Domain name', 'xss_clean|trim|required|is_valid_domain|is_unique[domain_whitelist.domain]');
            }
            if (!$this->form_validation->run()) {
                _validation('error', validation_errors());
            } 
            
            $response = $this->main_model->save_item($this->params, ['task' => post('type')]);
            ms($response);
        }
        if ($tab == 'api_credentials') {
            $response = $this->main_model->save_item($this->params, ['task' => 'api_credentials']);
            ms($response);

        }
        if (post('type')=='devices') {
            $this->form_validation->set_rules('device_name', 'Device name', 'xss_clean|trim|required');
            if (!$this->form_validation->run()) {
                _validation('error', validation_errors());
            }
            $response = $this->main_model->save_item($this->params, ['task' => 'devices']);
            ms($response);

        }

        if ($tab=='bkash' || $tab=='nagad' || $tab=='rocket' || $tab=='cellfin' || $tab=='upay' ) {
            $name = array_keys($_POST);
            $data1 = []; 
            foreach($name as $n){
                $data1[$n] = post($n);
            }
            
            $data['params'] = json_encode($data1);
            $data['g_type'] = $tab;
            $data['t_type'] = 'mobile';
            $data['status'] = post('status');

            if (!empty($this->main_model->get('*','user_payment_settings',['g_type'=>$tab, 'uid'=>session('uid')] )) ) {
                $this->db->update('user_payment_settings', $data, ['g_type'=>$tab,"uid" => session('uid')]);
            }else{
                $data['uid'] = session('uid');
                $this->db->insert('user_payment_settings', $data);
            }

        }
        if ($tab=='abbank' || $tab=='citybank' || $tab=='basia' || $tab=='bbrac' || $tab=='ific' || $tab=='jamuna' || $tab=='sonali' || $tab=='dbbl' || $tab=='ebl' || $tab=='ibl' || $tab=='basic'  ) {
            $this->form_validation->set_rules('bank_account_name', 'Account Name', 'required|xss_clean');
            $this->form_validation->set_rules('bank_account_number', 'Account Number', 'required|xss_clean');
            $this->form_validation->set_rules('bank_account_branch_name', 'Brach Name', 'required|xss_clean');
            $this->form_validation->set_rules('bank_account_routing_number', 'Brach Routing Number', 'required|xss_clean');
            if (!$this->form_validation->run()) {
                _validation('error', validation_errors());
            }
            $name = array_keys($_POST);
            $data1 = []; 
            foreach($name as $n){
                $data1[$n] = post($n);
            }
            $data['params'] = json_encode($data1);
            $data['g_type'] = $tab;
            $data['t_type'] = 'bank';
            $data['status'] = post('status');

            if (!empty($this->main_model->get('*','user_payment_settings',['g_type'=>$tab, 'uid'=>session('uid')] )) ) {
                $this->db->update('user_payment_settings', $data, ['g_type'=>$tab,"uid" => session('uid')]);
            }else{
                $data['uid'] = session('uid');
                $this->db->insert('user_payment_settings', $data);
            }

        }
        if ($tab=='paypal' || $tab=='binance' || $tab=='dbbl_mastercard' || $tab=='2checkout') {
            $name = array_keys($_POST);
            $data1 = []; 
            foreach($name as $n){
                $data1[$n] = post($n); 
            }
            
            $data['params'] = json_encode($data1);
            $data['g_type'] = $tab;
            $data['t_type'] = 'int_b';
            $data['status'] = post('status');

            if (!empty($this->main_model->get('*','user_payment_settings',['g_type'=>$tab, 'uid'=>session('uid')] )) ) {
                $this->db->update('user_payment_settings', $data, ['g_type'=>$tab,"uid" => session('uid')]);
            }else{
                $data['uid'] = session('uid');
                $this->db->insert('user_payment_settings', $data);
            }

        }

        ms(["status"  => "success", "message" => lang($tab.' settings updated successfully')]);
    }
}  