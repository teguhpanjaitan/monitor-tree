<?php

class Jenis_pohon extends CI_Model {
	
    public function exec() {
		global $template;
		// $this->load->model("global_model","gm");
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
		
		if($col == "0") $col = "id";
        else if($col == "1") $col = "name";
        else if($col == "2") $col = "meter_per_month";
		
		$this->db->select("*")
				->from("jenis_pohon")
				->limit($length,$start)
				->where("deleted = '0'");
		
		if(!empty($col))
			$this->db->order_by($col,$dir);
		
		if(!empty($search['value']))
			$this->db->where("name LIKE '%$search[value]%'");
		
		$res = $this->db->get()->result_array();
		
		$this->db->select("COUNT(ID) as total")->from("jenis_pohon")->where("deleted = '0'");
		if(!empty($search['value']))
			$this->db->where("name LIKE '%$search[value]%'");
		
        $tot = $this->db->get()->result_array();

        $temp = array();
        foreach($res as $val)
        {
			$pass_by['id'] = $val['id'];
			$button = $this->load->view($template->theme."button/default", $pass_by, true);
			
            $t = array();
            $t[] = $val['id'];
            $t[] = $val['name'];
            $t[] = $val['meter_per_month'];
            $t[] = $button;
            $temp[] = $t;
        }
        $data = array("draw"=>$get["draw"],"recordsTotal"=>$tot[0]['total'],"recordsFiltered"=>$tot[0]['total'],"data"=>$temp);
        return $data;
    }
	
}
