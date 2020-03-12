<?php

class Check_unique_not_id extends CI_Model {
	
    public function exec() {
		$val = $this->input->get("value");
		$val = $this->db->escape_str($val);
		$table = $this->input->get("table");
		$table = $this->db->escape_str($table);
		$field = $this->input->get("field");
		$field = $this->db->escape_str($field);
		$id = $this->input->get("id");
		$id = $this->db->escape_str($id);
		
		$this->db->select("*")->from($table)->where("$field = '$val' AND ID != '$id'");
		$res = $this->db->get()->result_array();
		if(empty($res))
			return false;
		else
			return true;
    }
	
}
