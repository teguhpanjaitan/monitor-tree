<?php

class Tiang extends CI_Model
{

    public function exec()
    {
        $zoom = intval($_GET['zoom']);

        if ($zoom <= 15) {
            $zoom = 0;
        }

        $file = fopen("tiang.csv", "r");
        fgetcsv($file); //ignore first line

        if ($zoom == 0) {
            $final = [];
            $hantaranOld = "";
            $temp = [];
            $c = 0;
            $b = 0;
            while (!feof($file)) {
                $data = fgetcsv($file, 0, ';');

                if (!empty($data[2])) {
                    if ($data[2] != $hantaranOld) {
                        if ($c != 0) {
                            $targetKey = $c - round($b/2);
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

                //latitude part
                if ($data[5] >= $southWest[0] && $data[5] <= $northeEast[0]) {
                    if ($data[6] >= $southWest[1] && $data[6] <= $northeEast[1]) {
                        $final[] = $data;
                    }
                }
            }
        }

        return $final;
    }
}
