<?php

//wp eval-file qa-process.php

//include(ABSPATH.'export-post-types-of-sites.php');



//dwqa-question
//dwqa-answer

//answer
//question

if (!function_exists('exportPostTypesOfSites')) {
    include(ABSPATH.'database/processes/export-post-types-of-sites.php');
}



$posttypes_to_export = ['dwqa-question','dwqa-answer'];//,'nav_menu_item'
$exportNameSlug = 'qa';
$relatedPlugins = ['dw-question-answer'];
$sites = get_sites();

exportPostTypesOfSites($posttypes_to_export, $exportNameSlug, $sites, $relatedPlugins);

$posttypes_to_export = ['forum','reply','topic'];//,'nav_menu_item'
$exportNameSlug = 'forum';
$relatedPlugins = ['bbpress'];

exportPostTypesOfSites($posttypes_to_export, $exportNameSlug, $sites, $relatedPlugins);
