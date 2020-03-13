<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	function __construct() {
        parent::__construct();
		$this->load->model("usermodel","u");
		$this->load->model("global_model","gm");
		$this->load->model("crud");
    }
	
	public function index()
	{
		global $template;
		$act = $this->input->post("act");

		if($act == 'tambah_data')
		{
			$post = $this->input->post();
			unset($post['act']);
			$table = $post['table'];
			unset($post['table']);
			$class_access = $post['class_user_access'];
			unset($post['class_user_access']);
			$id = $this->crud->tambah_data($post,$table);
			// $this->um->save_class_access($id,$class_access);
		}
		else if($act == 'edit_data')
		{
			$post = $this->input->post();
			unset($post['act']);
			$table = $post['table'];
			unset($post['table']);
			$class_access = $post['class_user_access'];
			unset($post['class_user_access']);
			$this->crud->update_data($post,$table);
			// $this->um->save_class_access($post['ID'],$class_access);
		}
		else if($act == 'delete')
		{
			$id = $this->input->post("ID");
			$table = $this->input->post("table");
			$this->crud->delete_data($id,$table,"u");
		}
		$data['levels'] = $this->gm->get_all_data("desc_level");
		$template->content = $this->load->view($template->theme."page/user",$data,true);
	}
	
	public function activate()
	{
		global $template;
		$id = $this->input->get("id");
		$this->db->select("*")->from("users")
					->where("ID",$id)
					->where("active","0");
		$res = $this->db->get()->result_array();
		if(!empty($res)){
			$data = array("active" => "1");
			$this->db->where("ID",$id);
			$this->db->update("users",$data);
		}
		$data['levels'] = $this->gm->get_all_data("desc_level");
		$template->content = $this->load->view($template->theme."page/user",$data,true);
	}
}
