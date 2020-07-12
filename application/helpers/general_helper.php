<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_href'))
{
	function get_href($param = '')
	{
		global $CI;
        $CI->load->helper('url');
		return base_url($param);
	}
}

if (!function_exists('get_login_exception'))
{
	function get_login_exception()
	{
		return array("login","logout");
	}
}

if (!function_exists('get_username'))
{
	function get_username()
	{
		global $CI;
		$credential = $CI->session->userdata('credential');
		$tmp = json_decode($credential);
		return $tmp->username;
	}
}

if (!function_exists('get_display_name'))
{
	function get_display_name()
	{
		global $CI;
		$credential = $CI->session->userdata('credential');
		$tmp = json_decode($credential);
		return $tmp->display_name;
	}
}

if (!function_exists('get_tinggi_pohon_limit'))
{
	function get_tinggi_pohon_limit()
	{
		return 10;
	}
}
?>