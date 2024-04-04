<?php

require ABSPATH.'/wp-content/plugins/mu-plugins/eloquent.php';
require ABSPATH.'/wp-load.php';


use App\Models\NcSiteGroup;

if (!function_exists('activateThemeInSite')) {
    include(ABSPATH.'database/processes/utils/activateThemeInSite.php');
}


$ncsitegroups = NcSiteGroup::all();


$main_sites = [];
$qa_sites = [];
$forum_sites = [];
$proms_sites = [];

foreach ($ncsitegroups as $ncsitegroup) {
    $main_sites[$ncsitegroup->main_site_id] = 'iol-main';
    $qa_sites[$ncsitegroup->qa_site_id] = 'dw-qa';
    $forum_sites[$ncsitegroup->forum_site_id] = 'bbpress-forum';
    $proms_sites[$ncsitegroup->proms_site_id] = 'proms';
}

$groupsSites = [$main_sites,$qa_sites,$forum_sites,$proms_sites];

foreach ($groupsSites  as $sites) {
    foreach ($sites as $site_id => $theme_name) {
        activateThemeInSite($site_id, $theme_name);
    }
}
