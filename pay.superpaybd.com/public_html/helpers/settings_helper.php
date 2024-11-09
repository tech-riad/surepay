<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

if (!function_exists("get_option")) {
    function get_option($key, $value = "")
    {
        // check data from $GLOBALS
        if (isset($GLOBALS['app_settings'][$key])) {
            return $GLOBALS['app_settings'][$key];
        }
        $CI = &get_instance();

        if (empty($CI->help_model)) {
            $CI->load->model('model', 'help_model');
        }
        $option = $CI->help_model->get("value", OPTIONS, "name = '{$key}'");
        if (empty($option)) {
            $CI->db->insert(OPTIONS, array("name" => $key, "value" => $value));
            return $value;
        } else {
            return $option->value;
        }
    }
}