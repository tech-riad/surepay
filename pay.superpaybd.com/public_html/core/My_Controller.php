<?php defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        # Set BD Timezone
        date_default_timezone_set(TIMEZONE);        
        define("BASE", str_replace("index.php/", "", base_url()));
    }
}
