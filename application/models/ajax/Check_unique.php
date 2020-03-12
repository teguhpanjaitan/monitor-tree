<?php

class Check_unique extends CI_Model {
	
    public function exec() {
		$val = $this->input->get("value");
		$val = $this->db->escape_str($val);
		$table = $this->input->get("table");
		$table = $this->db->escape_str($table);
		$field = $this->input->get("field");
		$field = $this->db->escape_str($field);
		
		$this->db->select("*")->from($table)->where("$field = '$val'");
		$res = $this->db->get()->result_array();
		if(empty($res))
			return false;
		else
			return true;
    }
	
}
