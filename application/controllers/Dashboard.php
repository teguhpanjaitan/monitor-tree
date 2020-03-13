<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	function __construct() {
        parent::__construct();
		$this->load->model("dashboardModel","dm");
		$this->load->model("global_model","gm");
    }
	
	public function index()
	{
		global $template;
		
		$data = [];
		$data['pohon'] = $this->dm->count_pohon();
		$data['pohon_alert'] = $this->dm->count_pohon_alert();
		$template->content = $this->load->view($template->theme."page/dashboard",$data,true);
	}
}
