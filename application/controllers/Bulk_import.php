<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bulk_import extends CI_Controller
{
	private $tiangs;

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
			$this->tiangs = $this->load_tiang();
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

				if (empty($temp[1]) || $temp[1] == '0') {
					continue;
				}

				$jenis_pohon = strtolower($temp[1]);
				$result_jenis_pohon = $this->crud->get_data("jenis_pohon", "name", $jenis_pohon);

				if (count($result_jenis_pohon) == 0) {
					$jenis = [];
					$jenis['name'] = $jenis_pohon;
					$jenis['deleted'] = 0;
					$this->crud->tambah_data($jenis, 'jenis_pohon');
					$result_jenis_pohon = $this->crud->get_data("jenis_pohon", "name", $jenis_pohon);
				}

				$result_jenis_pohon = $result_jenis_pohon[0];

				//check data if exist
				$this->db->select("*")
					->from("inspeksi")
					->where("tiang1", $temp[4])
					->where("tiang2", $temp[5]);
				$result2 = $this->db->get()->result_array();

				$location = $this->get_location_by_tiang($temp[4]);
				$segmen = $this->get_segmen_by_tiang($temp[4]);

				if (empty($segmen) || count($location) == 0) {
					$errors[] = "Data no {$temp[0]} segmen atau koordinat lokasi tidak ditemukan";
					continue;
				}

				$dateTime = DateTime::createFromFormat('d/m/Y', $temp[8]);
				$tanggal_inspeksi = $dateTime->format('Y-m-d');

				$data['id_jenis_pohon'] = $result_jenis_pohon['id'];
				$data['segmen'] = $segmen;
				$data['tanggal_inspeksi'] = $tanggal_inspeksi;
				$data['tinggi_pengukuran'] = $temp[9];
				$data['tinggi'] = $temp[9];
				$data['latitude'] = $location[0];
				$data['longitude'] = $location[1];
				$data['tiang1'] = $temp[4];
				$data['tiang2'] = $temp[5];
				$data['jarak_hutm_terdekat'] = $temp[11];
				$data['rekomendasi_penanganan'] = $temp[12];
				$data['ujung_pohon'] = $temp[13];
				$data['keterangan'] = isset($temp[14]) ? $temp[14] : "";

				if (count($result2)) {
					$data['ID'] = $result2[0]['id'];
					$this->crud->update_data($data, 'inspeksi');
				} else {
					$this->crud->tambah_data($data, 'inspeksi');
				}
			}
			fclose($handle);
		} else {
			$errors[] = "Error ketika membuka file. Mohon periksa kembali file dalam bentuk csv atau lainnya";
		}

		$return['errors'] = $errors;
		return $return;
	}

	private function load_tiang()
	{
		$file = fopen("tiang.csv", "r");
		fgetcsv($file); //ignore first line

		$tiangs = [];
		while (!feof($file)) {
			$temp = [];
			$data = fgetcsv($file, 0, ';');
			$data[5] = str_replace(",", '.', $data[5]);
			$data[6] = str_replace(",", '.', $data[6]);

			$temp["name"] = $data[3];
			$temp["segment"] = $data[2];
			$temp["latitude"] = $data[5];
			$temp["logitude"] = $data[6];

			$tiangs[] = $temp;
		}

		return $tiangs;
	}

	private function get_segmen_by_tiang($tiang_name)
	{
		foreach ($this->tiangs as $tiang) {
			if ($tiang_name == $tiang['name']) {
				return $tiang['segment'];
			}
		}

		return '';
	}

	private function get_location_by_tiang($tiang_name)
	{
		foreach ($this->tiangs as $tiang) {
			if ($tiang_name == $tiang['name']) {
				return [$tiang['latitude'], $tiang['logitude']];
			}
		}

		return [];
	}
}
