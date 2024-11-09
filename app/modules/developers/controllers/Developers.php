<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Developers extends MX_Controller {
	
	public function index()
	{
		$this->template->set_layout('docs');
        $this->template->build('docs');
	}
}
