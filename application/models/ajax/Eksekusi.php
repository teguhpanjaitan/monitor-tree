<?php

class Eksekusi extends CI_Model
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

        if ($col == "0") $col = "id";
        else if ($col == "1") $col = "nama_jenis_pohon";
        else if ($col == "2") $col = "";
        else if ($col == "3") $col = "metode_rintis";
        else if ($col == "4") $col = "bentangan_pohon";
        else if ($col == "5") $col = "tanggal_eksekusi";
        else if ($col == "6") $col = "eksekusi_selanjutnya";
        else $col = "";

        $this->db->select("e.*,j.name as nama_jenis_pohon")
            ->from("eksekusi e")
            ->join("inspeksi i", "i.id = e.id_inspeksi", "left")
            ->join("jenis_pohon j", "i.id_jenis_pohon = j.id", "left")
            ->limit($length, $start)
            ->where("e.deleted = '0'");

        if (!empty($col))
            $this->db->order_by($col, $dir);

        if (!empty($search['value'])) {
            $this->db->where("j.name LIKE '%$search[value]%'")
                ->or_where("i.tiang1 LIKE '%$search[value]%'")
                ->or_where("i.tiang2 LIKE '%$search[value]%'");
        }

        $res = $this->db->get()->result_array();

        $this->db->select("COUNT(e.ID) as total")
            ->from("eksekusi e")
            ->join("inspeksi i", "i.id = e.id_inspeksi", "left")
            ->join("jenis_pohon j", "i.id_jenis_pohon = j.id", "left")
            ->where("e.deleted = '0'");

        if (!empty($search['value'])) {
            $this->db->where("j.name LIKE '%$search[value]%'")
                ->or_where("i.tiang1 LIKE '%$search[value]%'")
                ->or_where("i.tiang2 LIKE '%$search[value]%'");
        }

        $tot = $this->db->get()->result_array();

        $temp = array();
        foreach ($res as $val) {
            $pass_by['id'] = $val['id'];
            $button = $this->load->view($template->theme . "button/default", $pass_by, true);

            $t = array();
            $t[] = $val['id'];
            $t[] = $val['nama_jenis_pohon'];
            $t[] = "Tiang 1:<br>{$val['tiang1']}<br> Tiang 2:<br>{$val['tiang2']}";
            $t[] = $val['metode_rintis'];
            $t[] = ($val['bentangan_pohon'] == 0) ? "" : $val['bentangan_pohon'] . " M";
            $t[] = date("d-m-Y", strtotime($val['tanggal_eksekusi']));
            $t[] = date("d-m-Y", strtotime($val['eksekusi_selanjutnya']));
            $t[] = $val['keterangan'];
            $t[] = $button;
            $temp[] = $t;
        }
        $data = array("draw" => $get["draw"], "recordsTotal" => $tot[0]['total'], "recordsFiltered" => $tot[0]['total'], "data" => $temp);
        return $data;
    }
}
