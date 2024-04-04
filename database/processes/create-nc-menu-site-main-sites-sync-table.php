<?php

require '../wp-load.php';

global $wpdb;
$table_name = 'nc_menu_site_main_site_sync';
$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  es_ES_id bigint(20),
  en_GB_id bigint(20),
  en_US_id bigint(20),
  fr_FR_id bigint(20),
  es_MX_id bigint(20),
  es_CL_id bigint(20),
  es_CO_id bigint(20),
  de_DE_id bigint(20),
  de_AT_id bigint(20),
  created_at timestamp,
  updated_at timestamp,
  PRIMARY KEY  (id)
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);
