<?php

class Get_all_tree extends CI_Model
{

	public function exec()
	{
		$this->db->select("jp.name as jenis_pohon,p.*")
			->from("pohon as p")
			->join("jenis_pohon as jp", "jp.id = p.id_jenis_pohon", "left")
			->where("p.deleted", "0");
		$ret = $this->db->get()->result_array();

		foreach ($ret as $key => $val) {
			$temp = [];
			
			$temp['latitude'] = $val['latitude'];
			$temp['longitude'] = $val['longitude'];
			$temp['jenis_pohon'] = $val['jenis_pohon'];
			$temp['tinggi'] = $val['tinggi'];
			$temp['segmen'] = $val['segmen'];
			$temp['image'] = empty($val['image']) ? '' : $val['image'];
			$ret[$key] = $temp;
		}
		return $ret;
	}
}
