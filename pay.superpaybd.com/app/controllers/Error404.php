<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error404 extends CI_Controller {

	public function index()
	{
		$this->load->view('error');
	}

}

/* End of file 404.php */
/* Location: .//E/laragon/www/payment/app/controllers/404.php */