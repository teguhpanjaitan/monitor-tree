<?php

class Get_inspeksi extends CI_Model
{
    public function exec()
    {
        $get = $this->input->get();
        $id = $get['id'];
        $id = $this->db->escape_str($id);

        $this->db->select("i.*,p.tinggi,p.tiang1,p.tiang2,p.id_jenis_pohon")
            ->from('inspeksi as i')
            ->join("pohon as p", "p.id = i.id_pohon", "left")
            ->where("i.id", $id);
        $res = $this->db->get()->result_array();

        $temp = $res[0];
        return $temp;
    }
}
