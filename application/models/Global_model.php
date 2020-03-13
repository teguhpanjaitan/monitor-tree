<?php

class Global_model extends CI_Model {
	
	public function delete_where_id($table){
		$id = $this->input->post("id");
		$data = array("deleted" => "1");
		$this->db->where("ID = '$id'");
		$this->db->update($table,$data);
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
