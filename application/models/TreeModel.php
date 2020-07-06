<?php

class TreeModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_jenis()
    {
        $this->db->select("*")
            ->from("jenis_pohon")
            ->where("deleted", "0");

        return $this->db->get()->result();
    }

    public function get_pohon_alert()
    {
        $this->db->select("*")
            ->from("pohon")
            ->where("deleted", "0")
            ->where("tinggi >= 10"); //pohon alert selalu diatas atau sama dengan 10 M

        return $this->db->get()->result_array();
    }

    public function get_downloaded_csv()
    {
        $this->db->select("jp.name as jenis_pohon,p.*")
            ->from("inspeksi as p")
            ->join("jenis_pohon as jp","jp.id = p.id_jenis_pohon","left")
            ->where("p.deleted", "0");
        
        $results = $this->db->get()->result_array();
        

        $csv = '"Jenis Pohon";"Segmen";"Tinggi (M)";"Tiang 1";"Tiang 2";"Bentangan Pohon (M)";"Penanganan Pohon";"Keterangan"' . "\r\n";
        foreach ($results as $result){
            $csv .= '"' . $result['jenis_pohon'] . '";';
            $csv .= '"' . $result['segmen'] . '";';
            $csv .= '"' . $result['tinggi'] . '";';
            $csv .= '"' . $result['tiang1'] . '";';
            $csv .= '"' . $result['tiang2'] . '";';
            $csv .= '"' . $result['bentangan'] . '";';
            $csv .= '"' . $result['penanganan'] . '";';
            $csv .= '"' . $result['keterangan'] . '"';
            $csv .= "\r\n";
        }

        return $csv;
    }
}
