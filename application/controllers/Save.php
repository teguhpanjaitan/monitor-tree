<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Save extends CI_Controller {
	
	public function index()
	{
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$data['name'] = $actual_link;
		$this->db->insert("url",$data);
	}
	
}
