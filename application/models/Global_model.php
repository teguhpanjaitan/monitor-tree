<?php

class Global_model extends CI_Model {
	
	public function delete_where_id($table){
		$id = $this->input->post("id");
		$data = array("deleted" => "1");
		$this->db->where("ID = '$id'");
		$this->db->update($table,$data);
	}
	
	public function get_class_access($uid = ''){
		$this->db->select("cl.name as class_name")
				->from("class_user_access as ca")
				->join("class_list as cl","cl.ID = ca.id_class","left")
				->where("ca.id_user = '$uid' AND ca.deleted = '0'");
		$ret = $this->db->get()->result_array();
		if(count($ret) == 0)
			return false;
		
		$tmp = array();
		foreach($ret as $val)
		{
			$tmp[] = $val['class_name'];
		}
		return $tmp;
	}
	
	public function get_all_data($table)
	{

		$this->db->select("*")->from($table)->where("deleted = '0'");
		return $this->db->get()->result_array();
	}
	
	public function get_all_data_where_column($column,$id,$table)
	{
		$this->db->select("*")->from($table)->where("deleted","0")->where($column,$id);
		return $this->db->get()->result_array();
	}
	
	public function get_all_data_where($id,$table)
	{
		$this->db->select("*")->from($table)->where("deleted = '0' AND ID = '$id'");
		return $this->db->get()->result_array();
	}
	
}
