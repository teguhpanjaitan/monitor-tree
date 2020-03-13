<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Point extends CI_Controller {
	
	function __construct() {
        parent::__construct();
		$this->load->model("crud");
		$this->load->model("treeModel","tm");
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
			$this->crud->tambah_data($post,$table);
		}
		else if($act == 'edit_data')
		{
			$post = $this->input->post();
			unset($post['act']);
			$table = $post['table'];
			unset($post['table']);
			$this->crud->update_data($post,$table);
		}
		else if($act == 'delete')
		{
			$id = $this->input->post("id");
			$table = $this->input->post("table");
			$this->crud->delete_data($id,$table);
		}

		$data['jenis_pohon'] = $this->tm->get_jenis();
		$template->content = $this->load->view($template->theme."page/point",$data,true);
	}
}
