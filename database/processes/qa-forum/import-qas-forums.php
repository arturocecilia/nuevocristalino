<?php

require '../wp-content/plugins/mu-plugins/eloquent.php';
require '../wp-load.php';

use App\Models\NcSiteGroup;

if (!function_exists('importContentToSite')) {
    include(ABSPATH.'database/processes/import-content-to-site.php');
}



// importContentToSite($importSlug, $blog_id)

$ncsitesgroups = NcSiteGroup::all();

foreach ($ncsitesgroups as $ncsite) {
    echo    importContentToSite('qa', $ncsite->main_site_id, $ncsite->qa_site_id, ['dw-question-answer']).PHP_EOL;
    echo    importContentToSite('forum', $ncsite->main_site_id, $ncsite->forum_site_id, ['bbpress']).PHP_EOL;
}
