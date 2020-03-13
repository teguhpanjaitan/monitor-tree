<?php

class User extends CI_Model {
	
    public function exec() {
		global $template;
		$get = $this->input->get();
        $length = $get['length'];
        $length = $this->db->escape_str($length);
        $start = $get['start'];
        $start = $this->db->escape_str($start);
        $col = $get['order'][0]['column'];
        $dir = $get['order'][0]['dir'];
        $dir = $this->db->escape_str($dir);
        $col = $this->db->escape_str($col);
		$search = $this->input->get('search');
		$search = $this->db->escape_str($search);
		
		if($col == "0") $col = "display_name";
		else if($col == "1") $col = "username";
		else if($col == "2") $col = "active";
		
		$this->db->select("u.*")
				->from("users as u")
				->limit($length,$start)
				->where("u.active",'1')
				->or_where("active",'0');
		
		if(!empty($col))
			$this->db->order_by($col,$dir);
		
		if(!empty($search['value']))
			$this->db->where("u.display_name LIKE '%$search[value]%'");
		
		$res = $this->db->get()->result_array();

		$this->db->select("COUNT(ID) as total")->from("users")->where("active",'1')->or_where("active",'0');
		if(!empty($search['value']))
			$this->db->where("display_name LIKE '%$search[value]%'");
        $tot = $this->db->get()->result_array();

        $temp = array();
        foreach($res as $val)
        {
			$pass_by['id'] = $val['ID'];
			$pass_by['active'] = $val['active'];
			$button = $this->load->view($template->theme."button/user", $pass_by, true);
			
            $t = array();
            $t[] = $val['display_name'];
            $t[] = $val['username'];
			$t[] = ($val['active'] == "1")?"Active":"Deleted";
            $t[] = $button;
            $temp[] = $t;
        }
        $data = array("draw"=>$get["draw"],"recordsTotal"=>$tot[0]['total'],"recordsFiltered"=>$tot[0]['total'],"data"=>$temp);
        return $data;
    }
	
}
