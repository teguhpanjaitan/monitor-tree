<?php

class Get_items extends CI_Model {
	
    public function exec() {
		$get = $this->input->get();
		$id = $get['id'];
		$id = $this->db->escape_str($id);
		$table = $get['table'];
		$table = $this->db->escape_str($table);
		
		$q = "SELECT * FROM `$table` WHERE `ID` = '$id'";
        $res = $this->db->query($q)->result_array();

        $temp = $res[0];
        return $temp;
    }
	
}
