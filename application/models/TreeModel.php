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
}
