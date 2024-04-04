<?php
require ABSPATH.'wp-load.php';

//$csv = array_map('str_getcsv', file(ABSPATH.'wp-content/plugins/nc-login-registration/languages/nc-login-registration.csv'));

if (!function_exists('create_po_from_csv')) {
    include(ABSPATH.'wp-content/plugins/nc-sync/cli/create-po-from-csv.php');
}

$file = ABSPATH.'wp-content/plugins/nc-login-registration/languages/nc-login-registration.csv';
$directoryTo = ABSPATH.'wp-content/plugins/nc-login-registration/languages/';

create_po_from_csv($file, $directoryTo, 'nc-login-registration', false);
