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

if (!function_exists("now")) {
    function now()
    {
        date_default_timezone_set(date_default_timezone_get());
        return date("Y-m-d H:i:s");
    }
}

// Convert time zone for user.
if (!function_exists('convert_timezone')) {
    function convert_timezone($datetime, $case,$uid='')
    {
        $zonesystem = date_default_timezone_get();

        if ($uid != '') {
            $zoneuser = get_user_timezone($uid);
        } else {
            if (isset($_SESSION['staff_current_info']['timezone']) && $_SESSION['staff_current_info']['timezone'] != '') {
                $zoneuser = $_SESSION['staff_current_info']['timezone'];
            }else{
                $zoneuser = current_logged_user()->timezone;
            }
        }
        switch ($case) {
            case 'user':
                $currentTZ = new DateTimeZone($zonesystem);
                $newTZ = new DateTimeZone($zoneuser);
                break;

            case 'system':
                $currentTZ = new DateTimeZone($zoneuser);
                $newTZ = new DateTimeZone($zonesystem);
                break;
        }

        $date = new DateTime($datetime, $currentTZ);
        $date->setTimezone($newTZ);
        return $date->format('Y-m-d H:i:s');
    }
}

//Get User's timezone, return zone
if (!function_exists("get_user_timezone")) {
    function get_user_timezone($uid = null)
    {
        if (!empty($uid)) {
            $userZone = get_field(USERS, ['id' => $uid], 'timezone');
            if (!empty($userZone)) {
                return $userZone;
            }
        }
        return false;
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
if (!function_exists('trxId')) {
    function trxId()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomLength = 6; // Length of the random string
        $timeLength = 6; // Length of the time portion

        $randomString = '';
        for ($i = 0; $i < $randomLength; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        $timePortion = substr(time(), -$timeLength);

        return $randomString . $timePortion;
    }
}
if (!function_exists('get_avatar')) {
    function get_avatar($url = "",$type='admin',$id='')
    {

        if ($type == "user") {
            $id = empty($id)?session("uid"):$id; 
            $CI = &get_instance();
            if(empty($CI->help_model)){
                $CI->load->model('model', 'help_model');
            }
            $user = $CI->help_model->get("avatar", USERS, ['id' => $id]);
            $url= $user->avatar;

        }elseif($type == "admin") {
            $id = empty($id)?session("sid"):$id; 
            $CI = &get_instance();
            if(empty($CI->help_model)){
                $CI->load->model('model', 'help_model');
            }
            if (empty($id)) {$id=1; }
            $user = $CI->help_model->get("avatar", STAFFS, ['id' => $id]);
            $url= $user->avatar;
        }
        if(!empty($url)  && file_exists(APPPATH.'../'.$url)){
            return base_url($url);
        }
        return base_url('assets/images/avatars/profile-image-'.rand(1, 4).'.png');
    }
}
if (!function_exists('URLIsValid')) {
    function URLIsValid($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return $httpCode !== 404;
    }
}
if (!function_exists('esc')) {
    function esc($data, $context = 'html', $encoding = null)
    {
        if (is_array($data)) {
            foreach ($data as &$value) {
                $value = esc($value, $context);
            }
        }

        if (is_string($data)) {
            $context = strtolower($context);

            // Provide a way to NOT escape data since
            // this could be called automatically by
            // the View library.
            if (empty($context) || $context === 'raw') {
                return $data;
            }

            if (!in_array($context, ['html', 'js', 'css', 'url', 'attr'], true)) {
                throw new InvalidArgumentException('Invalid escape context provided.');
            }

            $method = $context === 'attr' ? 'escapeHtmlAttr' : 'escape' . ucfirst($context);

            static $escaper;
            $CI = &get_instance();
            $CI->load->library('Escaper');
            if (!$escaper) {
                $escaper = new Escaper($encoding);
            }

            if ($encoding && $escaper->getEncoding() !== $encoding) {
                $escaper = new Escaper($encoding);
            }

            $data = $escaper->{$method}($data);
        }

        return $data;
    }
}

function xss_clean($data)
{
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

if (!function_exists('get_secure')) {
    function get_secure($name = "")
    {
        $CI = &get_instance();
        return filter_input_xss($CI->input->get(trim($name)));
    }
}


if (!function_exists('get_random_value')) {
    function get_random_value($data)
    {
        if (is_array($data) && !empty($data)) {
            $index = array_rand($data);
            return $data[$index];
        } else {
            return false;
        }
    }
}

if (!function_exists('get_random_values')) {
    function get_random_values($data, $limit)
    {
        if (is_array($data) && !empty($data)) {
            shuffle($data);
            if (count($data) < $limit) {
                $limit = count($data);
            }

            return array_slice($data, 0, $limit);
        } else {
            return false;
        }
    }
}

if (!function_exists('specialchar_decode')) {
    function specialchar_decode($input)
    {
        $input = str_replace("\\'", "'", $input);
        $input = str_replace('\"', '"', $input);
        $input = htmlspecialchars_decode($input, ENT_QUOTES);
        return $input;
    }
}

if (!function_exists('filter_input_xss')) {
    function filter_input_xss($input)
    {
        $input = htmlspecialchars($input, ENT_QUOTES);
        return $input;
    }
}

if (!function_exists('ms')) {
    function ms($array)
    {
        print_r(json_encode($array));
        exit(0);
    }
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


if (!function_exists('ids')) {
    function ids()
    {
        $CI = &get_instance();
        return md5($CI->encryption->encrypt(time()));
    };
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

if (!function_exists('encrypt_encode')) {
    function encrypt_encode($text)
    {
        $CI = &get_instance();
        return $CI->encryption->encrypt($text);
    };
}

if (!function_exists('encrypt_decode')) {
    function encrypt_decode($key)
    {
        $CI = &get_instance();
        return $CI->encryption->decrypt($key);
    };
}

if (!function_exists('segment')) {
    function segment($index)
    {
        $CI = &get_instance();
        return $CI->uri->segment($index);
    }
}

if (!function_exists('cn')) {
    function cn($module = "")
    {
        return PATH . $module;
    };
}

if (!function_exists('load_404')) {
    function load_404()
    {
        $CI = &get_instance();
        return $CI->load->view("layouts/404.php");
    };
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

function get_location_info_by_ip($ip_address)
{
    $result = (object) array();
    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip_address));
    if ($ip_data && $ip_data->geoplugin_countryName != null) {
        $result->country = $ip_data->geoplugin_countryName;
        $result->timezone = $ip_data->geoplugin_timezone;
        $result->city = $ip_data->geoplugin_city;
    } else {
        $result->country = 'Unknown';
        $result->timezone = 'Unknown';
        $result->city = 'Unknown';
    }
    return $result;
}

if (!function_exists("get_curl")) {
    function get_curl($url)
    {
        $user_agent = 'Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48b Safari/419.3';

        $headers = array
            (
            'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: en-US,fr;q=0.8;q=0.6,en;q=0.4,ar;q=0.2',
            'Accept-Encoding: gzip,deflate',
            'Accept-Charset: utf-8;q=0.7,*;q=0.7',
            'cookie:datr=; locale=en_US; sb=; pl=n; lu=gA; c_user=; xs=; act=; presence=',
        );

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_REFERER, base_url());

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}

if (!function_exists("create_random_api_key")) {
    function create_random_string_key($length = "",$type='')
    {
        if ($length == "") {
            $length = 32;
        }
        if ($type=='number') {
            $characters = '0123456789';
        }else{
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists("get_field")) {
    function get_field($table, $where = array(), $field)
    {
        $CI = &get_instance();

        if (empty($CI->help_model)) {
            $CI->load->model('model', 'help_model');
        }
        $item = $CI->help_model->get($field, $table, $where);
        if (!empty($item) && isset($item->$field)) {
            return $item->$field;
        } else {
            return false;
        }
    }
}

if (!function_exists("ticket_status_array")) {
    function ticket_status_array()
    {
        $data = array('new', 'pending', 'closed');
        return $data;
    }
}

if (!function_exists("ticket_status_title")) {
    function ticket_status_title($key)
    {
        switch ($key) {
            case 'new':
                return lang('New');
                break;
            case 'pending':
                return lang('Pending');
                break;

            case 'closed':
                return lang('Closed');
                break;

            case 'answered':
                return lang('Answered');
                break;

        }
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
        return $path;
    }
}
if (!function_exists("get_upload_url")) {
    function get_upload_url($url)
    {
        $path = "assets/uploads/user" . sha1(session("uid")) . "/".$url;
        
        return $path;
    }
}




if (!function_exists('truncate_string')) {
    function truncate_string($string = "", $max_length = 50, $ellipsis = "...", $trim = true)
    {
        $max_length = (int) $max_length;
        if ($max_length < 1) {
            $max_length = 50;
        }

        if (!is_string($string)) {
            $string = "";
        }

        if ($trim) {
            $string = trim($string);
        }

        if (!is_string($ellipsis)) {
            $ellipsis = "...";
        }

        $string_length = mb_strlen($string);
        $ellipsis_length = mb_strlen($ellipsis);
        if ($string_length > $max_length) {
            if ($ellipsis_length >= $max_length) {
                $string = mb_substr($ellipsis, 0, $max_length);
            } else {
                $string = mb_substr($string, 0, $max_length - $ellipsis_length)
                    . $ellipsis;
            }
        }

        return $string;
    }
}

if (!function_exists("get_random_time")) {
    function get_random_time($type = "")
    {
        $rand_time = rand(600, 1200);
        if ($type == "api") {
            $rand_time = rand(14400, 28000);
        }
        return $rand_time;
    }
}
// check is_ajax_request or not
if (!function_exists('_is_ajax')) {
    function _is_ajax($module_request = "")
    {
        $CI = &get_instance();
        if (!$CI->input->is_ajax_request()) {
            if ($module_request != "") {
                redirect(cn($module_request));
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}


if (!function_exists("save_web_image")) {
    function save_web_image($url = "",$filename='')
    {
        if ($filename=='') {
            $filename = create_random_string_key(10).'.jpg';
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $image_data = curl_exec($ch);
        curl_close($ch);



        if ($image_data === false) {
            return;
        }
        $destination_folder = get_upload_folder(); // Replace with your desired folder path

        // Create the folder if it doesn't exist
        if (!is_dir($destination_folder)) {
            mkdir($destination_folder, 0755, true);
        }

        // Save the image
        $filepath = $destination_folder . $filename;
        file_put_contents($filepath, $image_data);

        // Check if the image was saved successfully
        if (file_exists($filepath)) {
            return get_upload_url($filename);
        }
        return;


    }
}


if (!function_exists('amount')) {
    function amount($number = 0)
    {
        $result = '৳ '.$number.' BDT';
        return $result;
    }
}

if (!function_exists('calculateExpirationDate')) {
    function calculateExpirationDate($day, $expire = '')
    {
        $currentDate = new DateTime($expire);
        if (!$currentDate || $currentDate < new DateTime()) {
            $currentDate = new DateTime();
        }
        $currentDate->modify('+' . $day . ' days');
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
if (!function_exists('arrayLike')) {
    function arrayLike($pattern, $array) {
        $matches = [];

        foreach ($array as $key => $value) {
            if (stripos($value, $pattern) !== false) {
                $matches[$key] = $value;
            }
        }

        return $matches;
    }
}


if (!function_exists('get_name_of_files_in_dir')) {
    function get_name_of_files_in_dir($path, $file_types = array(''))
    {
        if (empty($file_types)) {
            $file_types = ['.php'];
        }
        $name_of_files = [];
        if ($path != "" && is_dir($path)) {
            $dir = new DirectoryIterator($path);
            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot()) {
                    foreach ($file_types as $key => $row) {
                        if (strrpos($fileinfo->getFilename(), $row)) {
                            $name_of_files[] = basename($fileinfo->getFilename(), $row);
                        }
                    }
                }
            }
        }
        return $name_of_files;
    }
}
if (!function_exists('get_current_url')) {
    function get_current_url()
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if ($url == "") {
            $url = segment(1);
        }
        return $url;
    }
}

if (!function_exists('get_count')) {
    function get_count($table, $where = "", $sum = "")
    {
        $CI = &get_instance();

        if ($sum !== "") {
            $CI->db->select_sum($sum);
        }

        if ($where !== "") {
            $CI->db->where($where);
        }

        $query = $CI->db->get($table);

        // If a specific column is summed, return the sum value
        if ($sum !== "") {
            $result = $query->row();
            return $result->$sum;
        }

        // If no specific column is summed, return the number of rows
        return $query->num_rows();
    }
}
