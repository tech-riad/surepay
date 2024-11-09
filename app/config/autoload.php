<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array();

$autoload['libraries'] = ['parser','session','template','pagination', 'encryption', 'security', 'database', 'form_validation'];

$autoload['drivers'] = array();

$autoload['helper'] = array('html','app_array','currency','email','url','common','settings','form','language','cookie','user','app_template','form_template','file_manager','partials','validation');

$autoload['config'] = array('app_config');

$autoload['language'] = array();

$autoload['model'] = array();
