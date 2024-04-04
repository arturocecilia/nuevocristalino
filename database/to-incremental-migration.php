<?php


require ABSPATH.'/wp-load.php';



//STEP -1
echo 'INI STEP 0'.PHP_EOL;
include('processes/deactivate-all-plugins.php');
//Sites Split
echo 'INI STEP 1'.PHP_EOL;
include('processes/create-sites-groups-table.php');
echo 'INI STEP 1.2'.PHP_EOL;
include('processes/create-sites-groups.php');


//network setup
echo 'INI STEP 2'.PHP_EOL;
include('processes/create-nc-network-plugin-setup-table.php');
echo 'INI STEP 2.1'.PHP_EOL;
include('processes/create-nc-network-theme-setup-table.php');
echo 'INI STEP 2.2'.PHP_EOL;
include('processes/load-nc-network-setup-table.php');


//ncsync ini.
echo 'INI STEP 3'.PHP_EOL;
include('processes/create-nc-sync-table.php');
echo 'INI STEP 3.1'.PHP_EOL;
include('processes/load-nc-sync-table.php');


//clean

echo 'INI STEP 4'.PHP_EOL;
include('processes/delete-post-metas.php');

//STEP -2
//qa forum import-export
echo 'INI STEP 5'.PHP_EOL;
include('processes/qa-forum-proms-process.php');


//STEP -3
echo 'INI STEP 6'.PHP_EOL;
include('processes/create-nc-menu-site-sync-table.php');




echo 'INI STEP 6.1'.PHP_EOL;
include('processes/menu-site/delete-menu-site-from-sites.php');


echo 'INI STEP 6.2'.PHP_EOL;
include('processes/deactivate-all-plugins.php');


echo 'INI STEP 6.3'.PHP_EOL;
include('processes/create-nc-menu-site-main-sites-sync-table.php');
include('processes/menu-site/export-menu-sites-new-menu-site.php');


echo 'INI STEP 6.4'.PHP_EOL;
include('processes/menu-site/export-menu-sites-to-secondary-sites.php');

echo 'INI STEP 7'.PHP_EOL;
include('processes/delete-post-types.php');

//ini setup
echo 'INI STEP 8'.PHP_EOL;
include('processes/process-nc-network-setup.php');
