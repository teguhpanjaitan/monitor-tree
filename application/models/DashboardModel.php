<?php

class DashboardModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function count_pohon()
    {
        $this->db->select("count(id) as count")
            ->from("point")
            ->where("deleted", "0");

        $res = $this->db->get()->row();
        return $res->count;
    }

    public function count_pohon_alert()
    {
        $this->db->select("count(id) as count")
            ->from("point")
            ->where("deleted", "0")
            ->where("tinggi >= limit_tinggi");

        $res = $this->db->get()->row();
        return $res->count;
    }
}
