<?php

require '../wp-content/plugins/mu-plugins/eloquent.php';
require '../wp-load.php';

use App\Models\NcSiteGroup;
use \Illuminate\Database\Capsule\Manager as Capsule;

function get_csv_data($path_to_file)
{
    $array_data = [];
    $csv = array_map('str_getcsv', file($path_to_file));

    for ($i=1; $i<count($csv);$i++) {
        $rowData = [];
        for ($j=0; $j<count($csv[0]); $j++) {
            $rowData[$csv[0][$j]] = $csv[$i][$j];//($csv[$i][$j] == '') ? null : $csv[$i][$j];
        }
        $array_data[] = $rowData;
    }

    return $array_data;
}

function insert_csv_data($csv_array_data, $table)
{
    foreach ($csv_array_data as $array_data) {
        Capsule::table($table)->insert($array_data);
    }
}
