<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Eksekusi extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("crud");
		$this->load->model("treeModel", "tm");
	}

	public function index()
	{
		global $template;
		$act = $this->input->post("act");
		$act = empty($act) ? $this->input->get("act") : $act;
		$id = $this->input->get("id");

		if ($act == 'tambah_data') {
		} else if ($act == 'edit_data') {
			$post = $this->input->post();
			unset($post['act']);
			$table = $post['table'];
			unset($post['table']);
			$tiang1 = $this->input->post("tiang1");
			$tiang2 = $this->input->post("tiang2");
			$temp = $this->get_pohon_position($tiang1, $tiang2);
			$post['latitude'] = $temp['latitude'];
			$post['longitude'] = $temp['longitude'];
			$post['segmen'] = $this->get_tiang_segmen($tiang1);
			$post['tinggi'] = $post['tinggi_pengukuran'];

			if (empty($post['tanggal_inspeksi'])) {
				$post['tanggal_inspeksi'] = date('Y-m-d H:i:s');
			}

			$this->crud->update_data($post, $table);
		} else if ($act == 'delete') {
			$id = $this->input->post("id");
			$table = $this->input->post("table");
			$this->crud->delete_data($id, $table);
		}

		$template->content = $this->load->view($template->theme . "page/eksekusi", $data, true);
	}

	public function create($id_inspeksi = 0)
	{
		$post = $this->input->post();
		unset($post['act']);
		$table = $post['table'];
		unset($post['table']);

		$tiang1 = $this->input->post("tiang1");
		$tiang2 = $this->input->post("tiang2");
		$temp = $this->get_pohon_position($tiang1, $tiang2);
		$post['latitude'] = $temp['latitude'];
		$post['longitude'] = $temp['longitude'];
		$post['segmen'] = $this->get_tiang_segmen($tiang1);
		$post['tinggi'] = $post['tinggi_pengukuran'];

		if (empty($post['tanggal_inspeksi'])) {
			$post['tanggal_inspeksi'] = date('Y-m-d H:i:s');
		}

		$this->crud->tambah_data($post, $table);
	}
}
