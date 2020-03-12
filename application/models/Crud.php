<?php

class Crud extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
		$this->load->model('usermodel',"um");
    }
	
	public function get_data($table = '',$w_col = '',$w_val = '') {
		
		$this->db->select("*")
			->from($table)
			->where("deleted","0");
		if(!empty($w_col))
			$this->db->where($w_col,$w_val);
		
		$res = $this->db->get()->result_array();
		return $res;
    }
	
	public function tambah_data($post,$table)
	{
		$date = date("Y-m-d H:i:s");
		$uid = $this->um->get_current_uid();
		if(empty($post['password']))
			unset($post['password']);
		if(isset($post['password']))
			$post['password'] = md5($post['password']);
		
		//check if column exist
		$res = $this->db->query("SHOW COLUMNS FROM `$table` LIKE 'created_by'")->result_array();
		if(count($res) > 0)
			$post['created_by'] = $uid;
		
		$res = $this->db->query("SHOW COLUMNS FROM `$table` LIKE 'modified_by'")->result_array();
		if(count($res) > 0)
			$post['modified_by'] = $uid;
		
		$res = $this->db->query("SHOW COLUMNS FROM `$table` LIKE 'created_on'")->result_array();
		if(count($res) > 0)
			$post['created_on'] = $date;
		
		$res = $this->db->query("SHOW COLUMNS FROM `$table` LIKE 'modified_on'")->result_array();
		if(count($res) > 0)
			$post['modified_on'] = $date;
		
		if(isset($post['MAX_FILE_SIZE']))
			unset($post['MAX_FILE_SIZE']);
		
		$this->db->insert($table,$post);
		$last_id = $this->db->insert_id();
		
		foreach($_FILES as $i => $val){
			
			//if file name is icon
			if($i == 'icon'){
				if(!empty($val['name'])){
					$target_file = FCPATH."images/icons/".$val['name'];
					if (!file_exists($target_file))
						move_uploaded_file($val["tmp_name"], $target_file);
					$this->db->where("id",$last_id);
					$this->db->update($table,array("icon" => $val['name']));
				}
			}
		}
		
		return $last_id;
	}
	
	public function update_data($post,$table)
	{
		$id = $post["ID"];
		unset($post['ID']);
		if(empty($post['password']))
			unset($post['password']);
		if(isset($post['password']))
			$post['password'] = md5($post['password']);
		$date = date("Y-m-d H:i:s");
		$uid = $this->um->get_current_uid();
		
		//check if column exist
		$res = $this->db->query("SHOW COLUMNS FROM `$table` LIKE 'modified_by'")->result_array();
		if(count($res) > 0)
			$post['modified_by'] = $uid;
		
		$res = $this->db->query("SHOW COLUMNS FROM `$table` LIKE 'modified_on'")->result_array();
		if(count($res) > 0)
			$post['modified_on'] = $date;
		
		if(isset($post['MAX_FILE_SIZE']))
			unset($post['MAX_FILE_SIZE']);
		
		$this->db->where("id",$id);
		$this->db->update($table,$post);
		
		foreach($_FILES as $i => $val){
			
			//if file name is icon
			if($i == 'icon'){
				if(!empty($val['name'])){
					//remove old icon
					$this->db->select("icon")->from($table)->where("id",$id);
					$icon = $this->db->get()->result_array();
					if($icon[0]['icon'] != 'flag.png')
						unlink(FCPATH."images/icons/".$icon[0]['icon']);
					
					$target_file = FCPATH."images/icons/".$val['name'];
					if (!file_exists($target_file))
						move_uploaded_file($val["tmp_name"], $target_file);
					$this->db->where("id",$id);
					$this->db->update($table,array("icon" => $val['name']));
				}
			}
		}
	}
	
	public function delete_data($id,$table,$selector = '')
	{
		if($selector == 'u')
			$data = array("active" => "0");
		else
			$data = array("deleted" => "1");
		
		$date = date("Y-m-d H:i:s");
		$uid = $this->um->get_current_uid();
		
		//check if column exist
		$res = $this->db->query("SHOW COLUMNS FROM `$table` LIKE 'modified_by'")->result_array();
		if(count($res) > 0)
			$data['modified_by'] = $uid;
		
		$res = $this->db->query("SHOW COLUMNS FROM `$table` LIKE 'modified_on'")->result_array();
		if(count($res) > 0)
			$data['modified_on'] = $date;
		
		$this->db->where("id = '$id'");
		$this->db->update($table,$data);
	}
}