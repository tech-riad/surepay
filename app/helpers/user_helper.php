<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Get admin url
 * @param string slug to append (Optional)
 * @return url admin 
 */
if (!function_exists('admin_url')) {
    function admin_url($slug = "")
    {
        return PATH . 'admin/' . $slug;
    };
}

/**
 * Get client url
 * @param string slug to append (Optional)
 * @return url admin 
 */
if (!function_exists('client_url')) {
    function client_url($slug = "")
    {
        return PATH . 'user/' . $slug;
    };
}


/**
 * Is admin logged in
 * @return boolean
 */
if (!function_exists('is_admin_logged_in')) {
    function is_admin_logged_in()
    {
        if (session('sid')) {
            return true;
        }
        return false;
    }
}


/**
 * Is client logged in
 * @return boolean
 */
if (!function_exists('is_client_logged_in')) {
    function is_client_logged_in()
    {
        if (session('uid')) {
            return true;
        }
        return false;
    }
}

/**
 * @param string $role_type 
 * @return boolean 
 */
if(!function_exists('get_role')){
    function get_role($role_type = "", $id = ""){
        if (!session('uid')) {
            return false;
        }
        if(session('uid') && isset($GLOBALS['current_user'])){
            return true;
        }else{
            return false;
        }
    }
}

/**
 * @return array $data logged user information 
 */
if(!function_exists("current_logged_user")){
    function current_logged_user(){
        return $GLOBALS['current_user'];
    }
}


if(!function_exists("get_current_user_data")){
    function get_current_user_data($id = ""){
        if ($id == "") {
            $id = session("uid");
        }
        $CI = &get_instance();
        if(empty($CI->help_model)){
            $CI->load->model('model', 'help_model');
        }
        $user = $CI->help_model->get("*", USERS, ['id' => $id]);
        if(!empty($user)){
            return $user;
        }else{
            return false;
        }
    }
}
if(!function_exists("get_domain_data")){
    function get_domain_data($domain='',$id = ""){        
        $CI = &get_instance();
        if(empty($CI->help_model)){
            $CI->load->model('model', 'help_model');
        }
        $user = $CI->help_model->get("*", 'domain_whitelist', ['user_id' => $id,'domain'=>$domain]);
        if(!empty($user)){
            return $user;
        }else{
            return false;
        }
    }
}

/*----------  Get user price  ----------*/
if (!function_exists('get_user_price')) {
    function get_user_price($uid, $service) {
        $CI = &get_instance();
        if(empty($CI->help_model)){
            $CI->load->model('model', 'help_model');
        }
        $user_price = $CI->help_model->get('service_price', USERS_PRICE, ['uid' => $uid, 'service_id' => $service->id]);
        if (isset($user_price->service_price)) {
            $price = $user_price->service_price;
        }else{
            $price = $service->price;
        }
        return $price;
    }
}

if (!function_exists('get_blocked_ip')) {
    function get_blocked_ip($ip)
    {
        $CI = &get_instance();
        if(empty($CI->help_model)){
            $CI->load->model('model', 'help_model');
        }
        $item = $CI->help_model->get('id', USER_BLOCK_IP, ['ip' => $ip]);

        if (!empty($item)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('get_active_plan')) {
    function get_active_plan($id)
    {
        
        $CI = &get_instance();
        if(empty($CI->help_model)){
            $CI->load->model('model', 'help_model');
        }
        $plan = $CI->help_model->get('id,expire', 'users_plan', ["plan_id" => $id,'uid'=>session('uid')],'id','desc');
        if (!empty($plan) && !hasExpired($plan->expire) ) {
            return $plan;
        }
        return false;
    }
}
if (!function_exists('get_expirydate_plan')) {
    function get_expirydate_plan($id)
    {
        
        $CI = &get_instance();
        if(empty($CI->help_model)){
            $CI->load->model('model', 'help_model');
        }
        $plan = $CI->help_model->get('id,expire', 'users_plan', ["plan_id" => $id,'uid'=>session('uid')],"id");
        return time_format($plan->expire);
    }
}

if (!function_exists('time_format')) {
    function time_format($dateTime)
    {
        $date = new DateTime($dateTime);
        return $date->format('j F, Y H:i:s A');
    }
}



if (!function_exists('canAddDomain')) {
    function canAddDomain($subscriptionPlans, $addedDomains) {
        $currentDate = time();
        $domain = count($addedDomains);
        $remainingDomains=0;
        $available =0;

        foreach ($subscriptionPlans as $plan) {
            $startDate = strtotime($plan['created']);
            $endDate = strtotime($plan['expire']);
            
            // Check if the current date is within the plan's validity period
            if ($currentDate >= $startDate && $currentDate <= $endDate) {
                $available+=$plan['website'] ; 
            }
        }
        $remainingDomains=$available-$domain;

        if ($remainingDomains > 0) {
            return true; // User can add a domain
        }
        
        return false; // User cannot add a domain
    }
}




if (!function_exists('domainValidation')) {
    function domainValidation($domain,$uid='') {
        if (empty($uid)) {
            $uid = session('uid');
        }
        $CI = &get_instance();
        if(empty($CI->help_model)){
            $CI->load->model('model', 'help_model');
        }
        $available =0;
        
        $plans = $CI->help_model->fetch('*','users_plan',['uid'=>$uid],'','','','',true);
        $domains = $CI->help_model->fetch('*',DOMAIN,['user_id'=>$uid,'status'=>1],'','','','',true);
        $active_domain_list=[];

        $currentDate = time();

        foreach ($plans as $key => $plan) {
            $startDate = strtotime($plan['created']);
            $endDate = strtotime($plan['expire']);
            
            // Check if the current date is within the plan's validity period
            if ($currentDate >= $startDate && $currentDate <= $endDate) {
                $available+=$plan['website'] ; 
            }
        }
        for($i=0;$i<$available;$i++){
            if (!empty($domains[$i])) {
                $active_domain_list[] = $domains[$i]['domain'];
            }
        } 
        $index = array_search($domain, $active_domain_list);
        if ($index !== false) {
            return true;
        } 
        return false;
    }
}

if (!function_exists('canAddDevice')) {
    function canAddDevice($subscriptionPlans, $addedDevices) {
        $currentDate = time();
        $device = count($addedDevices);
        $remainingDomains=0;
        $available =0;

        foreach ($subscriptionPlans as $plan) {
            $startDate = strtotime($plan['created']);
            $endDate = strtotime($plan['expire']);
            if ($plan['device']=='-1') {
                return true;
            }
            
            // Check if the current date is within the plan's validity period
            if ($currentDate >= $startDate && $currentDate <= $endDate) {
                $available+=$plan['device'] ; 
            }
        }
        $remainingDomains=$available-$device;

        if ($remainingDomains > 0) {
            return true; // User can add a device
        }
        
        return false; // User cannot add a device
    }
}
if (!function_exists('deviceValidation')) {
    function deviceValidation($device_key,$uid='') {
        if (empty($uid)) {
            $uid = session('uid');
        }
        $CI = &get_instance();
        if(empty($CI->help_model)){
            $CI->load->model('model', 'help_model');
        }
        $available =0;
        
        $plans = $CI->help_model->fetch('*','users_plan',['uid'=>$uid],'','','','',true);
        $devices = $CI->help_model->fetch('*','devices',['uid'=>$uid],'','','','',true);
        $active_device_list=[];

        $currentDate = time();

        foreach ($plans as $key => $plan) {
            $startDate = strtotime($plan['created']);
            $endDate = strtotime($plan['expire']);
            
            // Check if the current date is within the plan's validity period
            if ($currentDate >= $startDate && $currentDate <= $endDate) {
                if ($plan['device']=='-1') {
                    return true;
                }else{
                    $available+=$plan['device'] ;
                }
                 
            }
        }
        for($i=0;$i<$available;$i++){
            if (!empty($devices[$i])) {
                $active_device_list[] = $devices[$i]['device_key'];
            }
        } 
        $index = array_search($device_key, $active_device_list);
        if ($index !== false) {
            return true;
        } 
        return false;
    }
}