<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends MY_Model 
{
    protected $tb_main;

    public function __construct()
    {
        parent::__construct();
        $this->tb_main     = 'payments';
    }

    public function get_item($params = null, $option = null)
    {
        $result=[];
        
        if ($option['task'] == 'active-list-items') {
            $this->db->where('id != 1');
            $result = $this->fetch("*", $this->tb_main, ['status' => 1], 'sort', 'asc', true);
        }
        if($option['task'] == 'get-domain'){
            $this->db->where('user_id', session('uid'));
            $result = $this->db->get(DOMAIN)->result_array();
        }
        if($option['task'] == 'get-domain-object'){
            $this->db->where('user_id', session('uid'));
            $result = $this->db->get(DOMAIN)->result();
        }
        if($option['task'] == 'get-device'){
            $this->db->where('uid', session('uid'));
            $result = $this->db->get('devices')->result_array();
        }
        if($option['task'] == 'get-user-domain'){
            $result = $this->get("*", DOMAIN, ['id' => $params['id']], '', '', true);
        }

        return $result;
    }
    public function save_item($params = null, $option = null)
    {
        
        switch ($option['task']) {
            case 'change-status':
                $this->db->update($this->tb_main, ['status' => $params['status']], ["id" => $params['id']]);
                return ["status"  => "success", "message" => 'Update successfully'];
                break;
            
            case 'api_credentials':
                $api_credentials = [
                    'apikey' => create_random_string_key(23),
                    'secretkey' => create_random_string_key(8,'number'),
                ];
                $data['api_credentials'] = json_encode($api_credentials);

                $this->db->update(USERS, $data, ["id" => session('uid')]);
                return ["status"  => "success", "message" => 'API credentials Updated successfully'];
                break;
            case 'devices':
                $plans = $this->fetch('*','users_plan',['uid'=>session('uid')],'','','','',true);
                $devices = $this->fetch('*','devices',['uid'=>session('uid')],'','','','',true);
                if (!canAddDevice($plans,$devices)) {
                        return ["status"  => "error", "message" => 'Device reaches maximum limit! Upgrade your Subscription'];
                        break;
                    }
                $data =[
                    'uid'=>session('uid'),
                    'user_email'=> get_current_user_data()->email ,
                    'device_name' =>post('device_name'),
                    'device_key' =>create_random_string_key(32)
                ];                
                

                $this->db->insert('devices', $data);
                return ["status"  => "success", "message" => 'Device added successfully'];
                break;

            case 'domain_whitelist':
                $plans = $this->fetch('*','users_plan',['uid'=>session('uid')],'','','','',true);
                $domains = $this->fetch('*',DOMAIN,['user_id'=>session('uid')],'','','','',true);
                if (!empty($id = post('id'))) {
                    $data = array(
                        'status'            => (int)post('status'),
                        'ip'                => get_client_ip(),
                        'brand_name'        =>post('brand_name'),
                        'brand_logo'        =>post('brand_logo'),
                        'mobile_number'     =>post('mobile_number'),
                        'whatsapp_number'   =>post('whatsapp_number'),
                        'support_mail'      =>post('support_mail'),
                        'fees_type'         =>post('fees_type'),
                        'fees_amount'       =>post('fees_amount'),
                    );
                    $this->db->update(DOMAIN, $data, ['id'=> $id,"user_id" => session('uid')]);
                    return ["status"  => "success", "message" => 'Domain Updated successfully'];
                    break;                    
                }else{
                    if (!canAddDomain($plans,$domains)) {
                        return ["status"  => "error", "message" => 'Domain reaches maximum limit! Upgrade your Subscription'];
                        break;
                    }
                    $data = [
                        'domain'            => post('domain'),
                        'user_id'           =>session('uid'),
                        'ip'                => get_client_ip(),
                        'status'            => (int)post('status'),
                        'ip'                => get_client_ip(),
                        'brand_name'        =>post('brand_name'),
                        'brand_logo'        =>post('brand_logo'),
                        'mobile_number' =>post('mobile_number'),
                        'whatsapp_number'   =>post('whatsapp_number'),
                        'support_mail'      =>post('support_mail'),
                        'fees_type'         =>post('fees_type'),
                        'fees_amount'       =>post('fees_amount'),
                    ];
                    $this->db->insert(DOMAIN, $data);
                    return ["status"  => "success", "message" => 'Domain Added successfully'];
                    break; 

                }

            
        }
    }

    
}
