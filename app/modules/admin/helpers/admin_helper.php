<?php
defined('BASEPATH') or exit('No direct script access allowed');


if (!function_exists("current_logged_staff")) {
    function current_logged_staff()
    {
        return $GLOBALS['current_staff'];
    }
}


if (!function_exists('is_current_logged_staff')) {
	function is_current_logged_staff()
    {
        if (session('sid') && $GLOBALS['current_staff'] != null &&  $GLOBALS['current_staff']->id == session('sid')) {
            return true;
        }
		return false;
	}
}

