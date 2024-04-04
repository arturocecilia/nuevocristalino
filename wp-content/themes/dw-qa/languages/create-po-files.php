<?php
require ABSPATH.'wp-load.php';

//$csv = array_map('str_getcsv', file(ABSPATH.'wp-content/plugins/nc-login-registration/languages/nc-login-registration.csv'));

if (!function_exists('create_po_from_csv')) {
    include(ABSPATH.'wp-content/plugins/nc-sync/cli/create-po-from-csv.php');
}


$fileFrom = ABSPATH.'wp-content/themes/dw-qa/languages/dw-qa.csv';
$directoryTo = ABSPATH.'wp-content/themes/dw-qa/languages/';

create_po_from_csv($fileFrom, $directoryTo, 'dw-qa', true);
