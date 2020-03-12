<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function index()
	{
		global $template;
		$this->load->view($template->theme."page/login");
	}
	
	public function check_credential() {
		$this->load->model("CheckLogin","c");
		$ret = $this->c->check_credentials();
		if($ret['status'] == true)
			redirect(get_href());
		else
		{
			$dt = urlencode(base64_encode(json_encode($ret)));
			redirect(get_href("login?dt=$dt"));
		}
    }
}
