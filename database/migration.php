<?php


require ABSPATH.'/wp-load.php';



//include('to-incremental-migration.php');
//Aditional setup tasks after bulk menu migratin and sites creation.
include('processes/deactivate-all-plugins.php');
include('processes/load-nc-network-setup-table.php');
include('processes/process-nc-network-setup.php');
include('processes/nc-setup-themes.php');
include('processes/assign-menu-site-to-primary-allsites.php');
//NO LO VOY A HACER POR EL MOMENTO => include('processes/delete-my-case-submenu.php');
//include('processes/modify-menu-page-targets.php');//Para mi Area Privada
include('processes/menu-site/move-promsurls-to-proms-site.php');
//Borramos las páginas en desuso.
include('processes/delete-obsolete-pages.php');
include('processes/delete-obsolete-menus.php');
