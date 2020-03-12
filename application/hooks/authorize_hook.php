<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authorize_hook{

    public function check_login(){
		global $CI;
        $CI =& get_instance();
		$c_url = uri_string();
		
		$exception = get_login_exception();
		foreach($exception as $val)
		{
			if(strpos($c_url, $val) !== false)
				return;
		}
		$CI->load->model("CheckLogin");
		$CI->CheckLogin->autorize();
    }
    
}