<?php

require ABSPATH.'/wp-load.php';



if (!function_exists('exportMenuSiteToMainSites')) {
    include(ABSPATH.'database/processes/menu-site/export-import-menu-site-to-main-sites.php');
}
//$siteKeyFrom,$sitesKeysTo
exportMenuSiteToMainSites('es_ES', ['es_CL','en_GB','en_US','fr_FR']);//'es_CL',
exportMenuSiteToMainSites('de_DE', ['de_AT']);
