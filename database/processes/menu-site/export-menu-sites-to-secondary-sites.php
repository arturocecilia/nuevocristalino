<?php

require ABSPATH.'/wp-load.php';



if (!function_exists('exportImportMenuSiteToGroupSites')) {
    include(ABSPATH.'database/processes/menu-site/export-import-menu-site-to-groupsites.php');
}

exportImportMenuSiteToGroupSites(['es_ES','es_MX','es_CO','es_CL','de_DE','de_AT','en_GB','en_US','fr_FR']);
