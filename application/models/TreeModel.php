<?php

class TreeModel extends CI_Model
{
    private $tiangs;

    function __construct()
    {
        parent::__construct();
        $this->load_all_tiangs();
        $this->load->model("crud");
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
        $limit_pohon = get_tinggi_pohon_limit();

        $this->db->select("*")
            ->from("pohon")
            ->where("deleted", "0")
            ->where("tinggi >= $limit_pohon"); //pohon alert selalu diatas atau sama dengan 10 M

        return $this->db->get()->result_array();
    }

    public function get_downloaded_inspeksi_csv()
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

    public function get_downloaded_eksekusi_csv()
    {
        $this->db->select("e.id,p.tiang1,p.tiang2,e.metode_rintis,e.bentangan_pohon,e.tanggal_eksekusi,e.eksekusi_selanjutnya,jp.name as nama_jenis_pohon")
            ->from("eksekusi as e")
            ->join("pohon as p", "p.id = e.id_pohon", "left")
            ->join("jenis_pohon as jp", "jp.id = p.id_jenis_pohon", "left")
            ->where("e.deleted", "0");

        $results = $this->db->get()->result_array();

        $csv = '"ID/No";"Jenis Pohon";"Penyulang";"Alamat";"No Tiang 1";"No Tiang 2";"Metode Rintis";"Bentangan Pohon (M)";"Eksekusi Terakhir";"Eksekusi Selanjutnya"' . "\r\n";
        foreach ($results as $result) {
            $tanggal_eksekusi = (strpos($result['tanggal_eksekusi'], '0000') !== false) ? "-" : date("d-m-Y", strtotime($result['tanggal_eksekusi']));
            $eksekusi_selanjutnya = (strpos($result['eksekusi_selanjutnya'], '0000') !== false) ? "-" : date("d-m-Y", strtotime($result['eksekusi_selanjutnya']));

            $csv .= '"' . $result['id'] . '";';
            $csv .= '"' . $result['nama_jenis_pohon'] . '";';
            $csv .= '"' . $this->get_penyulang($result['tiang1']) . '";';
            $csv .= '"' . $this->get_tiang_alamat($result['tiang1']) . '";';
            $csv .= '"' . $result['tiang1'] . '";';
            $csv .= '"' . $result['tiang2'] . '";';
            $csv .= '"' . $result['metode_rintis'] . '";';
            $csv .= '"' . $result['bentangan_pohon'] . '";';
            $csv .= '"' . $tanggal_eksekusi . '";';
            $csv .= '"' . $eksekusi_selanjutnya . '";';
            $csv .= "\r\n";
        }

        return $csv;
    }

    public function recalculate_pohon_on_laju_tumbuh_changed($id_jenis_pohon = 0)
    {
        $this->db->select("p.*,jp.meter_per_month as laju_pertumbuhan")
            ->from("pohon p")
            ->join("jenis_pohon as jp", "jp.id = p.id_jenis_pohon", "left")
            ->where("p.id_jenis_pohon", $id_jenis_pohon)
            ->where("p.deleted", "0");
        $pohons = $this->db->get()->result_array();

        foreach ($pohons as $pohon) {
            $this->db->select("id,metode_rintis,tanggal_eksekusi")
                ->from("eksekusi")
                ->where("id_pohon", $pohon['id'])
                ->where("deleted", "0")
                ->order_by('tanggal_eksekusi', 'DESC');

            $eksekusi = $this->db->get()->result_array();

            if (count($eksekusi) == 0) {
                continue;
            } else {
                $eksekusi_selanjutnya = get_eksekusi_selanjutnya($eksekusi[0]['tanggal_eksekusi'], $pohon['laju_pertumbuhan'], $pohon['tinggi'], $eksekusi[0]['metode_rintis']);

                $data = [];
                $data['eksekusi_selanjutnya'] = $eksekusi_selanjutnya;
                $data['ID'] = $eksekusi[0]['id'];
                $this->crud->update_data($data, 'eksekusi');
            }
        }
    }

    public function get_pohon_from_inspeksi($id_inspeksi = 0)
    {
        $this->db->select("p.*")
            ->from("inspeksi i")
            ->join("pohon p", "p.id = i.id_pohon", "left")
            ->where("i.id", $id_inspeksi)
            ->where("i.deleted", "0");
        $query = $this->db->get();
        return $query->first_row();
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
        foreach ($this->tiangs as $tiang) {
            if ($no_tiang == $tiang[0]) {
                return $tiang[2];
            }
        }

        return "";
    }

    private function get_kode_tiang($no_tiang)
    {
        foreach ($this->tiangs as $tiang) {
            if ($no_tiang == $tiang[0]) {
                return $tiang[3];
            }
        }

        return "";
    }

    private function get_penyulang($no_tiang)
    {
        $kode_tiang = $this->get_kode_tiang($no_tiang);
        $kode_tiang = str_replace("TIANG ", "", $kode_tiang);
        $kode_tiang = explode("-", $kode_tiang);

        if (isset($kode_tiang[0])) {
            return $kode_tiang[0];
        } else {
            return "";
        }
    }
}
