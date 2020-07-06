<?php

class TreeModel extends CI_Model
{
    private $tiangs;

    function __construct()
    {
        parent::__construct();
        $this->load_all_tiangs();
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
        $this->db->select("jp.name as jenis_pohon,i.*,p.*")
            ->from("inspeksi as i")
            ->join("pohon as p", "p.id = i.id_pohon", "left")
            ->join("jenis_pohon as jp", "jp.id = p.id_jenis_pohon", "left")
            ->where("i.deleted", "0");

        $results = $this->db->get()->result_array();

        $csv = '"ID/No";"Jenis Pohon";"Alamat";"Penyulang";"Location 1";"Location 2";"No Tiang 1";"No Tiang 2";"Tanggal Inspeksi";"Tinggi Pengukuran";"Limit Tinggi (M)";"Posisi Pohon dari hutm terdekat (M)";"rekomendasi metode rintis";"Posisi ujung pohon/dahan"' . "\r\n";
        foreach ($results as $result) {
            $csv .= '"' . $result['id'] . '";';
            $csv .= '"' . $result['jenis_pohon'] . '";';
            $csv .= '"' . $this->get_tiang_alamat($result['tiang1']) . '";';
            $csv .= '"' . $this->get_penyulang($result['tiang1']) . '";';
            $csv .= '"' . $this->get_kode_tiang($result['tiang1']) . '";';
            $csv .= '"' . $this->get_kode_tiang($result['tiang2']) . '";';
            $csv .= '"' . $result['tiang1'] . '";';
            $csv .= '"' . $result['tiang2'] . '";';
            $csv .= '"' . date("m/d/Y", strtotime($result['tanggal_inspeksi'])) . '";';
            $csv .= '"' . $result['tinggi_pengukuran'] . '";';
            $csv .= '"";';                                              //Limit tinggi
            $csv .= '"' . $result['jarak_hutm_terdekat'] . '";';
            $csv .= '"' . $result['rekomendasi_penanganan'] . '";';
            $csv .= '"' . $result['ujung_pohon'] . '";';
            $csv .= "\r\n";
        }

        return $csv;
    }

    private function load_all_tiangs()
	{
		$file = fopen("tiang.csv", "r");
		fgetcsv($file); //ignore first line

		$this->tiangs = [];
		while (!feof($file)) {
            $data = fgetcsv($file, 0, ';');

			$this->tiangs[] = $data;
		}
    }

    private function get_tiang_alamat($no_tiang)
    {
        foreach($this->tiangs as $tiang){
            if($no_tiang == $tiang[0]){
                return $tiang[2];
            }
        }

        return "";
    }

    private function get_kode_tiang($no_tiang)
    {
        foreach($this->tiangs as $tiang){
            if($no_tiang == $tiang[0]){
                return $tiang[3];
            }
        }

        return "";
    }
    
    private function get_penyulang($no_tiang){
        $kode_tiang = $this->get_kode_tiang($no_tiang);
        $kode_tiang = str_replace("TIANG ", "", $kode_tiang);
        $kode_tiang = explode("-", $kode_tiang);

        if(isset($kode_tiang[0])){
            return $kode_tiang[0];
        }
        else{
            return "";
        }
    }
}
