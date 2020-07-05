<?php

class Tiang extends CI_Model
{
    function __construct()
	{
		parent::__construct();
		$this->load->model("treeModel","dm");
    }
    
    public function exec()
    {
        $zoom = intval($_GET['zoom']);

        if ($zoom <= 15) {
            $zoom = 0;
        }

        $file = fopen("tiang.csv", "r");
        fgetcsv($file); //ignore first line

        $segment_alerts = [];
        $pohon_alert = $this->dm->get_pohon_alert();
        foreach($pohon_alert as $pohon){
            $segment_alerts[strtolower($pohon['segmen'])][] = $pohon;
        }

        if ($zoom == 0) {
            $final = [];
            $hantaranOld = "";
            $temp = [];
            $c = 0;
            $b = 0;
            while (!feof($file)) {
                $data = fgetcsv($file, 0, ';');

                $data[5] = str_replace(",",".",$data[5]);
                $data[5] = floatval($data[5]);
                $data[6] = str_replace(",",".",$data[6]);
                $data[6] = floatval($data[6]);

                if (!empty($data[2])) {
                    if ($data[2] != $hantaranOld) {
                        if ($c != 0) {
                            $targetKey = $c - round($b / 2);

                            if(!empty($segment_alerts[strtolower($temp[$targetKey][2])])){
                                $temp[$targetKey][count($temp[$targetKey])] = true;
                            }
                            else{
                                $temp[$targetKey][count($temp[$targetKey])] = false;
                            }
                            $final[] = $temp[$targetKey];
                            $b = 0;
                        }
                    }

                    $b++;
                    $c++;
                    $temp[] = $data;
                    $hantaranOld = $data[2];
                }
            }
        } else {
            $southWest = $this->input->get("southwest");
            $northeEast = $this->input->get("northeast");

            if (empty($southWest) || empty($northeEast)) {
                return "";
            }

            $southWest = explode(";", $southWest);
            $northeEast = explode(";", $northeEast);

            while (!feof($file)) {
                $data = fgetcsv($file, 0, ';');

                if(empty($data[0])){
                    continue;
                }
                
                //latitude part
                $data[5] = str_replace(",",".",$data[5]);
                $data[5] = floatval($data[5]);
                $data[6] = str_replace(",",".",$data[6]);
                $data[6] = floatval($data[6]);
                
                if ($data[5] >= $southWest[0] && $data[5] <= $northeEast[0]) {
                    if ($data[6] >= $southWest[1] && $data[6] <= $northeEast[1]) {
                        if(!empty($segment_alerts[strtolower($data[2])])){
                            $data[count($data)] = true;
                        }
                        else{
                            $data[count($data)] = false;
                        }

                        $final[] = $data;
                    }
                }
            }
        }

        return $final;
    }
}
