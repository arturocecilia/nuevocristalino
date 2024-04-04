<?php

require '../wp-load.php';

if (!function_exists('assignMenuLocationsInSites')) {
    include(ABSPATH.'database/processes/utils/assignMenuLocationsInSites.php');
}

$sites = get_sites();

$sitesIdsMenusLocations = [];
foreach ($sites as $site) {
    $sitesIdsMenusLocations[$site->blog_id] = array('menu-site'=>'primary');
}


assignMenuLocationsInSites($sitesIdsMenusLocations);
