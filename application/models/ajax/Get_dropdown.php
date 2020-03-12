<?php

class Get_dropdown extends CI_Model {
	
    public function exec() {
		$get = $this->input->get();
		$val = $get['val'];
		$val = $this->db->escape_str($val);
		$field = $get['field'];
		$field = $this->db->escape_str($field);
		$table = $get['table'];
		$table = $this->db->escape_str($table);
		
		$this->db->select("*")->from($table)->where("deleted","0")->where($field,$val);
		$res = $this->db->get()->result_array();
        return $res;
    }
	
}
