<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perintah extends CI_Controller {
	
	function __construct() {
        parent::__construct();
		$this->load->model("crud");
    }
	
	public function index()
	{
		global $template;
		$act = $this->input->post("act");
		if($act == 'edit_data')
		{
			$post = $this->input->post();
			unset($post['act']);
			$table = $post['table'];
			unset($post['table']);
			$this->crud->update_data($post,$table);
		}
		else if($act == 'delete')
		{
			$id = $this->input->post("ID");
			$table = $this->input->post("table");
			$this->crud->delete_data($id,$table);
		}

		$template->content = $this->load->view($template->theme."page/perintah",null,true);
	}
	
}
