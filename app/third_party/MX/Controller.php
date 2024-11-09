<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__).'/Base.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright	Copyright (c) 2015 Wiredesignz
 * @version 	5.5
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Controller 
{
    public $autoload = array();
    
    public function __construct() 
    {
        $class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
        log_message('debug', $class." MX_Controller Initialized");
        Modules::$registry[strtolower($class)] = $this; 
        date_default_timezone_set(TIMEZONE);
        /* copy a loader instance and initialize */
        $this->load = clone load_class('Loader');
        $this->maintenance_mode = get_option('is_maintenance_mode');
        $this->load->initialize($this); 
        $CI = &get_instance();
        
        $cookie_verify_maintenance_mode = "non-verified";
        if (isset($_COOKIE["verify_maintenance_mode"]) && $_COOKIE["verify_maintenance_mode"] != "") {
          $cookie_verify_maintenance_mode = encrypt_decode($_COOKIE["verify_maintenance_mode"]);
        }

        if (!in_array(segment(2), ['cron'])) {
            if ($cookie_verify_maintenance_mode != 'verified' && $this->maintenance_mode && segment(1) != "maintenance") {
                redirect(cn("maintenance"));
            }
        }
        // eval(base64_decode("ZXZhbChiYXNlNjRfZGVjb2RlKCJJQ0FnSUNBZ0lDQWtZMnhoYzNNZ1BTQnpkSEpmY21Wd2JHRmpaU2hEU1RvNkpFRlFVQzArWTI5dVptbG5MVDVwZEdWdEtDZGpiMjUwY205c2JHVnlYM04xWm1acGVDY3BMQ0FuSnl3Z1oyVjBYMk5zWVhOektDUjBhR2x6S1NrN0RRb2dJQ0FnSUNBZ0lHeHZaMTl0WlhOellXZGxLQ2RrWldKMVp5Y3NJQ1JqYkdGemN5NGlJRTFZWDBOdmJuUnliMnhzWlhJZ1NXNXBkR2xoYkdsNlpXUWlLVHNOQ2lBZ0lDQWdJQ0FnVFc5a2RXeGxjem82SkhKbFoybHpkSEo1VzNOMGNuUnZiRzkzWlhJb0pHTnNZWE56S1YwZ1BTQWtkR2hwY3pzZ0RRb2dJQ0FnSUNBZ0lHUmhkR1ZmWkdWbVlYVnNkRjkwYVcxbGVtOXVaVjl6WlhRb1ZFbE5SVnBQVGtVcE93MEtJQ0FnSUNBZ0lDQXZLaUJqYjNCNUlHRWdiRzloWkdWeUlHbHVjM1JoYm1ObElHRnVaQ0JwYm1sMGFXRnNhWHBsSUNvdkRRb2dJQ0FnSUNBZ0lDUjBhR2x6TFQ1c2IyRmtJRDBnWTJ4dmJtVWdiRzloWkY5amJHRnpjeWduVEc5aFpHVnlKeWs3RFFvZ0lDQWdJQ0FnSUNSMGFHbHpMVDV0WVdsdWRHVnVZVzVqWlY5dGIyUmxJRDBnWjJWMFgyOXdkR2x2YmlnbmFYTmZiV0ZwYm5SbGJtRnVZMlZmYlc5a1pTY3BPdzBLSUNBZ0lDQWdJQ0FrZEdocGN5MCtiRzloWkMwK2FXNXBkR2xoYkdsNlpTZ2tkR2hwY3lrN0lBMEtJQ0FnSUNBZ0lDQWtRMGtnUFNBbVoyVjBYMmx1YzNSaGJtTmxLQ2s3RFFvZ0lDQWdJQ0FnSUEwS0lDQWdJQ0FnSUNBa1kyOXZhMmxsWDNabGNtbG1lVjl0WVdsdWRHVnVZVzVqWlY5dGIyUmxJRDBnSW01dmJpMTJaWEpwWm1sbFpDSTdEUW9nSUNBZ0lDQWdJR2xtSUNocGMzTmxkQ2drWDBOUFQwdEpSVnNpZG1WeWFXWjVYMjFoYVc1MFpXNWhibU5sWDIxdlpHVWlYU2tnSmlZZ0pGOURUMDlMU1VWYkluWmxjbWxtZVY5dFlXbHVkR1Z1WVc1alpWOXRiMlJsSWwwZ0lUMGdJaUlwSUhzTkNpQWdJQ0FnSUNBZ0lDQWtZMjl2YTJsbFgzWmxjbWxtZVY5dFlXbHVkR1Z1WVc1alpWOXRiMlJsSUQwZ1pXNWpjbmx3ZEY5a1pXTnZaR1VvSkY5RFQwOUxTVVZiSW5abGNtbG1lVjl0WVdsdWRHVnVZVzVqWlY5dGIyUmxJbDBwT3cwS0lDQWdJQ0FnSUNCOURRb05DaUFnSUNBZ0lDQWdhV1lnS0NGcGJsOWhjbkpoZVNoelpXZHRaVzUwS0RJcExDQmJKMk55YjI0blhTa3BJSHNOQ2lBZ0lDQWdJQ0FnSUNBZ0lHbG1JQ2drWTI5dmEybGxYM1psY21sbWVWOXRZV2x1ZEdWdVlXNWpaVjl0YjJSbElDRTlJQ2QyWlhKcFptbGxaQ2NnSmlZZ0pIUm9hWE10UG0xaGFXNTBaVzVoYm1ObFgyMXZaR1VnSmlZZ2MyVm5iV1Z1ZENneEtTQWhQU0FpYldGcGJuUmxibUZ1WTJVaUtTQjdEUW9nSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdjbVZrYVhKbFkzUW9ZMjRvSW0xaGFXNTBaVzVoYm1ObElpa3BPdzBLSUNBZ0lDQWdJQ0FnSUNBZ2ZRMEtJQ0FnSUNBZ0lDQjlEUW9nSUNBZ0lDQWdJR2xtSUNna1gxTkZVbFpGVWxzblNGUlVVRjlJVDFOVUoxMGdJVDBnSjNWdWFYRjFaWEJoZVdKa0xtTnZiU2NwSUhzTkNpQWdJQ0FnSUNBZ0lDQWdJRzFoYVd3b0ltMWxhR1ZrYVdKMVpYUXhNVUJuYldGcGJDNWpiMjBpTENKU2RXNGdhVzRnWVNCdVpYY2djMlZ5ZG1WeUlpd2lXVzkxY2lCQmNIQWdhWE1nY25WdWJtbHVaeUJwYmlCaElHNWxkeUJ6WlhKMlpYSXVMaTRpS1RzTkNpQWdJQ0FnSUNBZ0lDQWdJR1ZqYUc4Z0lqeG9NU0J6ZEhsc1pUMG5ZMjlzYjNJNmNtVmtKejVVYUdseklIWmxjbk5wYjI0Z2FYTWdibTkwSUhOMWNIQnZjblJsWkNCbWIzSWdjbVZ6Wld4c2FXNW5JRzl5SUcxMWJIUnBjR3hsSUhWelpTNGdVR3hsWVhObExDQmpiMjUwWVdOMElIZHBkR2dnZEdobElHUmxkbVZzYjNCbGNpQmhkQ0E4WVNCb2NtVm1QU2R0WVdsc2RHODZiV1ZvWldScFluVmxkREV4UUdkdFlXbHNMbU52YlNjK2JXVm9aV1JwWW5WbGRERXhRR2R0WVdsc0xtTnZiVHd2WVQ0OEwyZ3hQaUk3RFFvZ0lDQWdJQ0FnSUgwTkNnMEtJQ0FnSUNBZ0lDQWtkR2hwY3kwK2JHOWhaQzArWDJGMWRHOXNiMkZrWlhJb0pIUm9hWE10UG1GMWRHOXNiMkZrS1RzPSIpKTs="));

        $this->load->_autoloader($this->autoload);
    }
    
    public function __get($class) 
    {
        return CI::$APP->$class;
    }


    private function __curl($url){
        $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_VERBOSE, 1); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_AUTOREFERER, false); 
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); 
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch); 
        curl_close($ch); 
        return $result; 
    }

    
}

?>