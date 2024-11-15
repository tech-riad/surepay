<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['signin'] = 'auth/signin';
$route['signup'] = 'auth/signup';
$route['verify'] = 'auth/verify';
$route['invoice/(:any)'] = 'home/invoice/$1';

//fileupload
$route['upload_files']            = 'admin/file_manager/upload_files'; 
$route['upload_all_files']        = 'admin/file_manager/upload_all_files'; 

// admin
$route['tickets/(:num)']          = 'tickets/view/$1';
$route['admin']                   = 'admin/login';
$route['admin/settings/store']    = 'admin/settings/store';
$route['admin/settings/(:any)']   = 'admin/settings/index/$1';

//user routes
$route['terms']                   = 'home/terms';
$route['refferal/(:any)'] = 'home/refferal/$1';
$route['privacy-policy']                   = 'home/privacy';

$route['user/invoice/add'] = 'user/invoice/update';
$route['user/settings/update']   = 'user/settings/update';
$route['user/settings/add_device']   = 'user/settings/add_device';
$route['user/settings/store']   = 'user/settings/store';
$route['user/settings/(:any)']   = 'user/settings/index/$1';
