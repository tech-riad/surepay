<?php

if (!function_exists('post_get')) {
    function post_get($name = "")
    {
        $CI = &get_instance();
        if ($name != "") {
            return $CI->input->post_get(trim($name));
        } else {
            return $CI->input->post_get();
        }
    }
}

if (!function_exists('get')) {
    function get($name = "")
    {
        $CI = &get_instance();
        $CI->load->library("security");
        $result = trim($CI->input->get($name));
        $result = $CI->security->xss_clean($result);
        $result = strip_tags($result);
        $result = html_entity_decode($result);
        $result = urldecode($result);
        $result = addslashes($result);
        return $result;
    }
}

if (!function_exists('post')) {
    function post($name = "")
    {
        $CI = &get_instance();
        if ($name != "") {
            $post = $CI->input->post($name);
            if (is_string($post)) {
                $result = trim($CI->input->post(trim($name)));
                $result = addslashes($result);
                $result = strip_tags($result);
            } else {
                $result = $post;
            }
            return $result;
        } else {
            return $CI->input->post();
        }
    }
}

function xss_clean($data){
    $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

    // Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do {
        // Remove really unwanted tags
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    } while ($old_data !== $data);

    // we are done...
    return $data;
}


if (!function_exists('get_secure')) {
    function get_secure($name = "")
    {
        $CI = &get_instance();
        return filter_input_xss($CI->input->get(trim($name)));
    }
}
if (!function_exists('ms')) {
    function ms($array,$exit=true)
    {
        print_r(json_encode($array));
        if ($exit) {
            exit(0);
        }
        
    }
}

if (!function_exists('load_404')) {
    function load_404()
    {
        $CI = &get_instance();
        return $CI->load->view("error.php");
    };
}



/**
 * @param string $status error/success
 * @param string $message
 * @return Print Message
 */
if (!function_exists('_validation')) {
    function _validation($status, $ms)
    {
        ms(['status' => $status, 'message' => $ms]);
    }
}




if (!function_exists("get_client_ip")) {
    function get_client_ip()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } else if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
            if (strstr($ip, ',')) {
                $tmp = explode(',', $ip);
                $ip = trim($tmp[0]);
            }
        } else {
            $ip = getenv('REMOTE_ADDR');
        }
        return $ip;
    }
}

if (!function_exists("info_client_ip")) {
    function info_client_ip()
    {
        $result = get_curl("https://timezoneapi.io/api/ip");

        $result = json_decode($result);
        if (!empty($result)) {
            return $result;
        }
        return false;
    }
}

if (!function_exists('calculateExpirationDate')) {
    function calculateExpirationDate($day)
    {
         $currentDate = new DateTime();
          $currentDate->modify('+'.$day.' days');
          $expirationDate = $currentDate->format('Y-m-d H:i:s');
          
          return $expirationDate;
    }
}
if (!function_exists('hasExpired')) {
    function hasExpired($expirationDateTime) {
      $currentDateTime = new DateTime();
      $expirationDateTimeObj = new DateTime($expirationDateTime);

      return $currentDateTime > $expirationDateTimeObj;
    }
}
if (!function_exists('ids')) {
    function ids()
    {
        $CI = &get_instance();
        return md5($CI->encryption->encrypt(time()));
    };
}

if (!function_exists('trxId')) {
    function trxId()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomLength = 5; // Length of the random string
        $timeLength = 5; // Length of the time portion

        $randomString = '';
        for ($i = 0; $i < $randomLength; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        $timePortion = substr(time(), -$timeLength);

        return $randomString . $timePortion;
    }
}

if (!function_exists('domainValidation')) {
    function domainValidation($domain,$uid='') {
        
        $CI = &get_instance();
        if(empty($CI->help_model)){
            $CI->load->model('model', 'help_model');
        }
        $available =0;
        
        $plans = $CI->help_model->fetch('*','users_plan',['uid'=>$uid],'','','','',true);
        $domains = $CI->help_model->fetch('*','domain_whitelist',['user_id'=>$uid,'status'=>1],'','','','',true);
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
            $active_domain_list[] = @$domains[$i]['domain'];
        }

        $index = array_search($domain, $active_domain_list);
        if ($index !== false) {
            return true;
        } 
        return false;
    }
}

if (!function_exists("now")) {
    function now()
    {
        date_default_timezone_set(date_default_timezone_get());
        return date("Y-m-d H:i:s");
    }
}

if ( ! function_exists('link_asset'))
    {
        function link_asset($url = '',$theme='', $type = 'text/css')
        {
            $CI =& get_instance();
            $link = '<link ';

            $link .= ' type="'.$type.'" ';
            
            if ($theme == '') {
                $theme = 'assets/';
            }

            if (preg_match('#^([a-z]+:)?//#i', $url))
            {
                $link .= 'href="'.$theme.$url.'" ';
            }
            else
            {
                $link .= 'href="'.$CI->config->base_url($theme.$url).'" ';
            }
            return $link." rel='stylesheet'/>\n";
        }
    }
if ( ! function_exists('script_asset')){
    function script_asset($src = '',$theme='', $type = 'text/javascript')
    {
        $CI =& get_instance();
        $script = '<script ';

        $script .= ' type="'.$type.'" ';
        
        if ($theme == '') {
            $theme = 'assets/';
        }

        if (preg_match('#^([a-z]+:)?//#i', $src))
        {
            $script .= 'src="'.$theme.$src.'" ';
        }
        else
        {
            $script .= 'src="'.$CI->config->base_url($theme.$src).'" ';
        }
        return $script."></script>\n";
    }
}
if (!function_exists('get_value')) {
    function get_value($dataJson, $key, $parseArray = false, $return = false)
    {
        if (is_string($dataJson)) {
            $dataJson = json_decode($dataJson);
        }

        if (is_object($dataJson)) {
            if (isset($dataJson->$key)) {
                if ($parseArray) {
                    return (array) $dataJson->$key;
                } else {
                    return $dataJson->$key;
                }
            }
        } else if (is_array($dataJson)) {
            if (isset($dataJson[$key])) {
                return $dataJson[$key];
            }
        } else {
            return $dataJson;
        }

        return $return;
    }
}

if (!function_exists('currency_converter')) {
    function currency_converter($currency = 'BDT')
    {
        $url = 'https://api.exchangerate-api.com/v4/latest/USD';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $res = json_encode(get_value($response,'rates'));

        return get_value($res,$currency);
    }
}

if (!function_exists("currency_format")) {
    function currency_format($number, $number_decimal = "", $decimalpoint = "", $separator = ""){
        $decimal = 2;

        if ($number_decimal == "") {
            $decimal = get_option('currency_decimal', 2);
        }

        if ($decimalpoint == "") {
            $decimalpoint = get_option('currency_decimal_separator', 'dot');
        }

        if ($separator == "") {
            $separator = get_option('currency_thousand_separator', 'comma');
        }
        
        switch ($decimalpoint) {
            case 'dot':
                $decimalpoint = '.';
                break;
            case 'comma':
                $decimalpoint = ',';
                break;
            default:
                $decimalpoint = ".";
                break;
        }

        switch ($separator) {
            case 'dot':
                $separator = '.';
                break;
            case 'comma':
                $separator = ',';
                break;
            default:
                $separator = ',';
                break;
        }
        $number = get_option('currency_symbol').number_format($number, $decimal, $decimalpoint, $separator);
        return $number;
    }
}
if (!function_exists('payment_logo')) {
    function payment_option($method='',$option='logo'){
        $CI = &get_instance();
        if(empty($CI->help_model)){
            $CI->load->model('model', 'help_model');
        }
        $gateway = $CI->help_model->get('*','payments',['type'=>$method])->params;
        $opt = get_value($gateway, 'option');


        return get_value($opt,$option);
    }
}
if (!function_exists('session')) {
    function session($input)
    {
        $CI = &get_instance();

        if ($input == 'uid' && session('uid_tmp')) {
            return session('uid_tmp');
        }
        return $CI->session->userdata($input);
    }
}

if (!function_exists('set_session')) {
    function set_session($name, $input)
    {
        $CI = &get_instance();
        return $CI->session->set_userdata($name, $input);
    }
}

if (!function_exists('unset_session')) {
    function unset_session($name)
    {
        $CI = &get_instance();
        return $CI->session->unset_userdata($name);
    }
}

if (!function_exists("get_upload_folder")) {
    function get_upload_folder()
    {
        $path = APPPATH . "../assets/uploads/user" . sha1(session("uid")) . "/";
        if (!file_exists($path)) {
            $uold = umask(0);
            mkdir($path, 0777);
            umask($uold);
            file_put_contents($path . "index.html", "<h1>404 Not Found</h1>");
        }
    }
}

if (!function_exists('get_link_file')) {
    function get_link_file($file_name)
    {
        return base_url("assets/uploads/user" . sha1(session("uid")) . "/" . $file_name);
    };
}
if (!function_exists('url_modifier')) {
    function url_modifier($user_input_url, $additional_params) {
        if (filter_var($user_input_url, FILTER_VALIDATE_URL)) {
            $url_components = parse_url($user_input_url);
            $path = isset($url_components['path']) ? $url_components['path'] : '';
            $query = isset($url_components['query']) ? $url_components['query'] : '';
            
            parse_str($query, $existing_query_array);
            $new_query_params = array_merge($existing_query_array, $additional_params);
            $new_query = http_build_query($new_query_params);

            $modified_url = $url_components['scheme'] . '://' . $url_components['host'] . $path;
            if (!empty($new_query)) {
                $modified_url .= '?' . $new_query;
            }
            return $modified_url;
        } else {
            return $user_input_url; // Invalid URL, handle the error appropriately
        }
    }
}

if (!function_exists('amount_format')) {
    function amount_format($value) {
        return number_format($value, 2, '.', ',');
    }
}