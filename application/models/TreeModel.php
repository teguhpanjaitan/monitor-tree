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
            ->from("point")
            ->where("deleted", "0")
            ->where("tinggi >= limit_tinggi");

        return $this->db->get()->result_array();
    }
}
