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

            if (strpos(strtolower($data[3]), strtolower($search)) !== false) {
                $temp = array();
                $temp['id'] = $data[3];
                $temp['text'] = $data[3];
                $results[] = $temp;
            }
        }

        return ['results' => $results];
    }
}
