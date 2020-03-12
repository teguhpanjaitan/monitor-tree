<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map extends CI_Controller {
	
	function __construct() {
        parent::__construct();
		$this->load->model("global_model","gm");
		$this->load->model("crud");
    }
	
	public function index()
	{
		global $template;
		$act = $this->input->post("act");
		if($act == 'perintahkan')
		{
			$post = $this->input->post();
			unset($post['act']);
			$table = $post['table'];
			unset($post['table']);
			$this->crud->tambah_data($post,$table);
		}
		
		$data = [];
		$template->content = $this->load->view($template->theme."page/map",$data,true);
	}
	
}
