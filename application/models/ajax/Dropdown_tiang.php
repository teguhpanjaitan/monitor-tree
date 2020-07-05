<?php
class Dropdown_tiang extends CI_Model
{
    public function exec()
    {
        $search = $_GET['q'];
        $file = fopen("tiang.csv", "r");
        fgetcsv($file); //ignore first line

        $results = array();
        while (!feof($file)) {
            $data = fgetcsv($file, 0, ';');

            if (strpos(strtolower($data[0]), strtolower($search)) !== false) {
                $temp = array();
                $temp['id'] = $data[0];
                $temp['text'] = $data[0] . " - " . $data[3];
                $results[] = $temp;
            }
        }

        return ['results' => $results];
    }
}
