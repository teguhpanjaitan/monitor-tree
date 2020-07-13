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
		if ($act == 'import-inspeksi') {
			$this->tiangs = $this->load_tiang();
			$data = $this->import_inspeksi();
		} else if ($act == 'import-eksekusi') {
			$this->tiangs = $this->load_tiang();
			$data = $this->import_eksekusi();
		}

		$template->content = $this->load->view($template->theme . "page/bulk_import", $data, true);
	}

	private function import_inspeksi()
	{
		$return = ['errors' => ""];

		if (($handle = fopen($_FILES["file"]["tmp_name"], "r")) !== FALSE) {
			fgetcsv($handle, 1000, ";");
			$errors = [];

			while (($temp = fgetcsv($handle, 1000, ";")) !== FALSE) {
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

				$segmen = $this->get_segmen_by_tiang($temp[6]);

				if (empty($segmen)) {
					$errors[] = "Data no {$temp[0]} segmen atau koordinat lokasi tidak ditemukan";
					continue;
				}

				$dateTime = DateTime::createFromFormat('d/m/Y', $temp[8]);
				$tanggal_inspeksi = $dateTime->format('Y-m-d');

				$data = [];
				$data['id_jenis_pohon'] = $result_jenis_pohon['id'];
				$data['segmen'] = $segmen;
				$data['tinggi'] = $temp[9];
				$temp2 = $this->get_pohon_position($temp[6], $temp[7]);
				$data['latitude'] = $temp2['latitude'];
				$data['longitude'] = $temp2['longitude'];
				$data['tiang1'] = $temp[6];
				$data['tiang2'] = $temp[7];

				//check data if exist
				$this->db->select("*")
					->from("pohon")
					->where('tanggal_inspeksi',$tanggal_inspeksi)
					->where("tiang1", $temp[6])
					->where("tiang2", $temp[7])
					->where("deleted", 0);
				$result_pohon = $this->db->get()->result_array();

				$id_pohon = 0;
				if (count($result_pohon)) {
					$data['ID'] = $result_pohon[0]['id'];
					$this->crud->update_data($data, 'pohon');
					$id_pohon = $result_pohon[0]['id'];
				} else {
					$id_pohon = $this->crud->tambah_data($data, 'pohon');
				}

				$data = [];
				$data['id_pohon'] = $id_pohon;
				$data['tanggal_inspeksi'] = $tanggal_inspeksi;
				$data['tinggi_pengukuran'] = $temp[9];
				$data['jarak_hutm_terdekat'] = $temp[11];
				$data['rekomendasi_penanganan'] = strtolower($temp[12]);
				$data['ujung_pohon'] = $temp[13];
				$data['keterangan'] = isset($temp[14]) ? $temp[14] : "";

				//check data if exist
				$this->db->select("*")
					->from("inspeksi")
					->where("id_pohon", $id_pohon)
					->where("deleted", 0);
				$result_inspeksi = $this->db->get()->result_array();

				if (count($result_inspeksi)) {
					$data['ID'] = $result_inspeksi[0]['id'];
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

	private function import_eksekusi()
	{
		$return = ['errors' => ""];

		if (($handle = fopen($_FILES["file"]["tmp_name"], "r")) !== FALSE) {
			fgetcsv($handle, 1000, ";");
			$errors = [];

			while (($temp = fgetcsv($handle, 1000, ";")) !== FALSE) {
				if (empty($temp[1]) || $temp[1] == '0') {
					continue;
				}

				$this->db->select("p.*,jp.meter_per_month")
					->from("pohon as p")
					->join("jenis_pohon as jp", "p.id_jenis_pohon = jp.id", "left")
					->where("p.tiang1", $temp[4])
					->where("p.tiang2", $temp[5])
					->where("p.deleted", 0);

				$result_pohon = $this->db->get()->result_array();

				if (count($result_pohon) == 0) {
					continue;
				} else {
					$result_pohon = $result_pohon[0];
				}

				if (empty($temp[8])) {
					continue;
				}

				$dateTime = DateTime::createFromFormat('d/m/Y', $temp[8]);
				$tanggal_eksekusi = $dateTime->format('Y-m-d');

				$data = [];
				$data['id_pohon'] = $result_pohon['id'];
				$data['tanggal_eksekusi'] = $tanggal_eksekusi;
				$data['metode_rintis'] = strtolower($temp[6]);
				$data['bentangan_pohon'] = get_bentangan_pohon($temp[6],$result_pohon['tinggi']);
				$data['eksekusi_selanjutnya'] = get_eksekusi_selanjutnya($temp[8], $result_pohon['meter_per_month']);

				//check data if exist on eksekusi
				$this->db->select("e.*")
					->from("eksekusi e")
					->join("pohon p", "p.id = e.id_pohon", "left")
					->where("e.tanggal_eksekusi", $tanggal_eksekusi)
					->where("p.tiang1", $temp[4])
					->where("p.tiang2", $temp[5])
					->where("e.deleted", 0);
				$result_eksekusi = $this->db->get()->result_array();

				if (count($result_eksekusi)) {
					$data['ID'] = $result_eksekusi[0]['id'];
					$this->crud->update_data($data, 'eksekusi');
				} else {
					$this->crud->tambah_data($data, 'eksekusi');
				}

				//update tinggi pohon
				if (intval($result_pohon['tinggi']) > 0) {
					$data = [];
					$data['ID'] = $result_pohon['id'];

					if (strtolower($temp[6]) == 'rabas-rabas') {
						$data['tinggi'] = floatval($result_pohon['tinggi']) - 3;
					} else {
						$data['tinggi'] = 0;
					}

					$this->crud->update_data($data, 'pohon');
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
			$temp["number"] = $data[0];
			$temp["segment"] = $data[2];
			$temp["latitude"] = $data[5];
			$temp["logitude"] = $data[6];

			$tiangs[] = $temp;
		}

		return $tiangs;
	}

	private function get_segmen_by_tiang($tiang_number)
	{
		foreach ($this->tiangs as $tiang) {
			if ($tiang_number == $tiang['number']) {
				return $tiang['segment'];
			}
		}

		return '';
	}

	private function get_pohon_position($tiang1, $tiang2)
	{
		$file = fopen("tiang.csv", "r");
		fgetcsv($file); //ignore first line

		$tiang1_pos = [];
		$tiang2_pos = [];
		$position = ['latitude' => 0, 'longitude' => 0];
		$pos_t1 = false;
		$pos_t2 = false;

		//get both position
		while (!feof($file)) {
			$data = fgetcsv($file, 0, ';');

			$data[5] = str_replace(",", '.', $data[5]);
			$data[6] = str_replace(",", '.', $data[6]);

			if ($data[0] === $tiang1) {
				$tiang1_pos["latitude"] = floatval($data[5]);
				$tiang1_pos["longitude"] = floatval($data[6]);
				$pos_t1 = true;
			}

			if ($data[0] === $tiang2) {
				$tiang2_pos["latitude"] = floatval($data[5]);
				$tiang2_pos["longitude"] = floatval($data[6]);
				$pos_t2 = true;
			}

			if ($pos_t1 && $pos_t2) {
				break;
			}
		}

		//caculate mid point
		$dLon = deg2rad($tiang2_pos["longitude"] - $tiang1_pos["longitude"]);

		//convert to radians
		$lat1 = deg2rad($tiang1_pos["latitude"]);
		$lat2 = deg2rad($tiang2_pos["latitude"]);
		$lon1 = deg2rad($tiang1_pos["longitude"]);

		$Bx = cos($lat2) * cos($dLon);
		$By = cos($lat2) * sin($dLon);
		$position['latitude'] = rad2deg(atan2(sin($lat1) + sin($lat2), sqrt((cos($lat1) + $Bx) * (cos($lat1) + $Bx) + $By * $By)));
		$position['longitude'] = rad2deg($lon1 + atan2($By, cos($lat1) + $Bx));

		$position['latitude'] = round($position['latitude'], 10);
		$position['longitude'] = round($position['longitude'], 10);

		return $position;
	}
}
