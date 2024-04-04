<?php

require '../wp-load.php';
require ABSPATH.'wp-content/plugins/mu-plugins/eloquent.php';
use \Illuminate\Database\Capsule\Manager as Capsule;

if (!function_exists('get_csv_data')) {
    include('utils.php');
}


//nc_network_plugin_setup
Capsule::table('nc_network_plugin_setup')->truncate();
$pluginSetup = get_csv_data(ABSPATH.'database/processes/setup/nc-network-plugin-setup.csv');
insert_csv_data($pluginSetup, 'nc_network_plugin_setup');

//nc_network_theme_setup
/*
$themeSetup = get_csv_data(ABSPATH.'database/processes/setup/nc-network-theme-setup.csv');
insert_csv_data($themeSetup, 'nc_network_theme_setup');
*/
