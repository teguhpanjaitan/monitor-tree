<?php

class Point extends CI_Model
{

    public function exec()
    {
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

        if ($col == "0") $col = "id";
        else if ($col == "1") $col = "nama_jenis_pohon";
        else if ($col == "2") $col = "tinggi";
        else if ($col == "3") $col = "limit_tinggi";
        else if ($col == "4") $col = "";
        else if ($col == "5") $col = "";

        $this->db->select("p.*,j.name as nama_jenis_pohon")
            ->from("point p")
            ->join("jenis_pohon j", "p.id_jenis_pohon = j.id", "left")
            ->limit($length, $start)
            ->where("p.deleted = '0'");

        if (!empty($col))
            $this->db->order_by($col, $dir);

        if (!empty($search['value'])) {
            $this->db->where("j.name LIKE '%$search[value]%'")
                ->or_where("p.segmen LIKE '%$search[value]%'");
        }

        $res = $this->db->get()->result_array();

        $this->db->select("COUNT(p.ID) as total")
            ->from("point p")
            ->join("jenis_pohon j", "p.id_jenis_pohon = j.id", "left")
            ->where("p.deleted = '0'");

        if (!empty($search['value'])) {
            $this->db->where("j.name LIKE '%$search[value]%'")
                ->or_where("p.segmen LIKE '%$search[value]%'");
        }

        $tot = $this->db->get()->result_array();

        $start_no = intval($start) + 1;
        $temp = array();
        foreach ($res as $val) {
            $pass_by['id'] = $val['id'];
            $button = $this->load->view($template->theme . "button/default", $pass_by, true);

            $t = array();
            $t[] = $start_no;
            $t[] = $val['nama_jenis_pohon'];
            $t[] = $val['segmen'];
            $t[] = $val['tinggi'] . " m";
            $t[] = "Tiang 1:<br>{$val['tiang1']}<br> Tiang 2:<br>{$val['tiang2']}";
            $t[] = $val['keterangan'];
            $t[] = !empty($val['image'])?"<a href='images/{$val['image']}' target='_blank'><img class='image' src='images/{$val['image']}' /></a>":"";
            $t[] = $button;
            $temp[] = $t;
            $start_no++;
        }
        $data = array("draw" => $get["draw"], "recordsTotal" => $tot[0]['total'], "recordsFiltered" => $tot[0]['total'], "data" => $temp);
        return $data;
    }
}
