<?php
defined('BASEPATH') or exit('No direct script access allowed');

class The_pohon extends CI_Controller
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

		if ($act == 'delete') {
			$id = $this->input->post("id");
			$table = $this->input->post("table");
			$this->crud->delete_data($id, $table);
		}

		$data['jenis_pohon'] = $this->tm->get_jenis();
		$data['tiangs'] = $this->get_tiangs();
		$template->content = $this->load->view($template->theme . "page/pohon", $data, true);
	}

	private function get_tiangs()
	{
		$file = fopen("tiang.csv", "r");
		fgetcsv($file); //ignore first line

		$tiangs = [];
		while (!feof($file)) {
			$temp = [];
			$data = fgetcsv($file, 0, ';');
			$temp["nama"] = $data[3];

			$tiangs[] = $temp;
		}

		return $tiangs;
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

	private function get_tiang_segmen($name)
	{
		$file = fopen("tiang.csv", "r");
		fgetcsv($file); //ignore first line

		$segmen = "";
		while (!feof($file)) {
			$data = fgetcsv($file, 0, ';');

			if ($data[3] === $name) {
				$segmen = $data[2];
				break;
			}
		}

		return $segmen;
	}
}
