<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_pohon extends CI_Controller {
	
	function __construct() {
        parent::__construct();
		$this->load->model("crud");
		$this->load->model("global_model","gm");
		$this->load->model("treeModel", "tm");
    }
	
	public function index()
	{
		global $template;
		$act = $this->input->post("act");
		$act = empty($act)?$this->input->get("act"):$act;
		$id = $this->input->get("id");
		
		if($act == 'tambah_data')
		{
			$post = $this->input->post();
			unset($post['act']);
			$table = $post['table'];
			unset($post['table']);
			$post['name'] = strtolower($post['name']);
			$this->crud->tambah_data($post,$table);
		}
		else if($act == 'edit_data')
		{
			$post = $this->input->post();
			unset($post['act']);
			$table = $post['table'];
			unset($post['table']);
			$post['name'] = strtolower($post['name']);
			$this->crud->update_data($post,$table);
			$this->tm->recalculate_pohon_on_laju_tumbuh_changed($post['ID']);
		}
		else if($act == 'delete')
		{
			$id = $this->input->post("id");
			$table = $this->input->post("table");
			$this->crud->delete_data($id,$table);
		}
		$template->content = $this->load->view($template->theme."page/jenis_pohon",null,true);
	}
}
