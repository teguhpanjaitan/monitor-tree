<?php

class Inspeksi extends CI_Model
{

    public function exec()
    {
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

        if ($col == "0") $col = "i.id";
        else if ($col == "1") $col = "tanggal_inspeksi";
        else if ($col == "2") $col = "nama_jenis_pohon";
        else if ($col == "3") $col = "";
        else if ($col == "4") $col = "tinggi_pengukuran";
        else if ($col == "5") $col = "jarak_hutm_terdekat";
        else if ($col == "6") $col = "rekomendasi_penanganan";
        else if ($col == "7") $col = "ujung_pohon";
        else if ($col == "8") $col = "keterangan";
        else if ($col == "9") $col = "";
        else $col = "";

        $this->db->select("p.*,i.*,j.name as nama_jenis_pohon")
            ->from("inspeksi i")
            ->join("pohon p", "p.id = i.id_pohon", "left")
            ->join("jenis_pohon j", "p.id_jenis_pohon = j.id", "left")
            ->limit($length, $start)
            ->where("p.deleted = '0'");

        if (!empty($col))
            $this->db->order_by($col, $dir);

        if (!empty($search['value'])) {
            $this->db->where("j.name LIKE '%$search[value]%'")
                ->or_where("p.segmen LIKE '%$search[value]%'")
                ->or_where("p.tiang1 LIKE '%$search[value]%'")
                ->or_where("p.tiang2 LIKE '%$search[value]%'");
        }

        $res = $this->db->get()->result_array();

        $this->db->select("COUNT(i.ID) as total")
            ->from("inspeksi i")
            ->join("pohon p", "p.id = i.id_pohon", "left")
            ->join("jenis_pohon j", "p.id_jenis_pohon = j.id", "left")
            ->where("i.deleted = '0'");

        if (!empty($search['value'])) {
            $this->db->where("j.name LIKE '%$search[value]%'")
                ->or_where("p.segmen LIKE '%$search[value]%'")
                ->or_where("p.tiang1 LIKE '%$search[value]%'")
                ->or_where("p.tiang2 LIKE '%$search[value]%'");
        }

        $tot = $this->db->get()->result_array();

        $temp = array();
        foreach ($res as $val) {
            $pass_by['id'] = $val['id'];
            $button = $this->load->view($template->theme . "button/inspeksi", $pass_by, true);

            $t = array();
            $t[] = $val['id'];
            $t[] = date("d-m-Y", strtotime($val['tanggal_inspeksi']));
            $t[] = $val['nama_jenis_pohon'];
            $t[] = "Tiang 1: {$val['tiang1']}<br>Tiang 2: {$val['tiang2']}";
            $t[] = ($val['tinggi_pengukuran'] == 0) ? "" : $val['tinggi_pengukuran'] . " M";
            $t[] = ($val['jarak_hutm_terdekat'] == 0) ? "" : $val['jarak_hutm_terdekat'] . " M";
            $t[] = $val['rekomendasi_penanganan'];
            $t[] = $val['ujung_pohon'];
            $t[] = $val['keterangan'];
            $t[] = !empty($val['image']) ? "<a href='images/{$val['image']}' target='_blank'><img class='image' src='images/{$val['image']}' /></a>" : "";
            $t[] = $button;
            $temp[] = $t;
        }
        $data = array("draw" => $get["draw"], "recordsTotal" => $tot[0]['total'], "recordsFiltered" => $tot[0]['total'], "data" => $temp);
        return $data;
    }
}
