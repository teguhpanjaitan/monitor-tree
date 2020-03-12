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
		return array("login","logout","apps_api","konfirmasi");
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

if (!function_exists('fix_time_display'))
{
	function fix_time_display($datetime){
		$originalDate = $datetime;
		$newDate = date("d-m-Y H:i", strtotime($originalDate));
		return $newDate;
	}
}

if (!function_exists('romanic_number'))
{
	function romanic_number($integer, $upcase = true) 
	{ 
		$table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1); 
		$return = ''; 
		while($integer > 0) 
		{ 
			foreach($table as $rom=>$arb) 
			{ 
				if($integer >= $arb) 
				{ 
					$integer -= $arb; 
					$return .= $rom; 
					break; 
				} 
			} 
		} 

		return $return; 
	}
}
?>