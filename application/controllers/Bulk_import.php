<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bulk_import extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("crud");
		$this->load->model("global_model", "gm");
	}

	public function index()
	{
		global $template;
		$act = $this->input->post("act");
		$act = empty($act) ? $this->input->get("act") : $act;

		$data = [];
		if ($act == 'import') {
			$data = $this->import();
		}

		$template->content = $this->load->view($template->theme . "page/bulk_import", $data, true);
	}

	private function import()
	{
		$return = ['errors' => ""];

		if (($handle = fopen($_FILES["file"]["tmp_name"], "r")) !== FALSE) {
			fgetcsv($handle, 1000, ";");
			$errors = [];
			while (($temp = fgetcsv($handle, 1000, ";")) !== FALSE) {
				$data = [];

				$jenis_pohon = strtolower($temp[0]);
				$result = $this->crud->get_data("jenis_pohon", "name", $jenis_pohon);
				if (count($result) == 0) {
					$errors[] = "'$jenis_pohon' tidak ditemukan";
					continue;
				}

				//check data if exist
				$this->db->select("*")
					->from("point")
					->where("segmen", $temp[1])
					->where("latitude", $temp[5])
					->where("longitude", $temp[6]);
				$result2 = $this->db->get()->result_array();

				if (count($result2)) {
					$data['ID'] = $result2[0]['id'];
					$data['id_jenis_pohon'] = $result[0]['id'];
					$data['segmen'] = $temp[1];
					$data['tanggal'] = $temp[2];
					$data['tinggi_awal'] = $temp[3];
					$data['limit_tinggi'] = $temp[4];
					$data['tinggi'] = $data['tinggi_awal'];
					$this->crud->update_data($data, 'point');
				} else {
					$data['id_jenis_pohon'] = $result[0]['id'];
					$data['segmen'] = $temp[1];
					$data['tanggal'] = $temp[2];
					$data['tinggi_awal'] = $temp[3];
					$data['limit_tinggi'] = $temp[4];
					$data['latitude'] = $temp[5];
					$data['longitude'] = $temp[6];
					$data['tinggi'] = $data['tinggi_awal'];
					$this->crud->tambah_data($data, 'point');
				}
			}
			fclose($handle);
		} else {
			$errors[] = "Error ketika membuka file. Mohon periksa kembali file dalam bentuk csv atau lainnya";
		}

		$return['errors'] = $errors;
		return $return;
	}
}
