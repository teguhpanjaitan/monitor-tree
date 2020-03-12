<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	function __construct() {
        parent::__construct();
		$this->load->model("dashboardModel","d");
		$this->load->model("global_model","gm");
    }
	
	public function index()
	{
		global $template;
		
		$data = array();
		$template->content = $this->load->view($template->theme."page/dashboard",$data,true);
	}
}
