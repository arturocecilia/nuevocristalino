<?php

require '../wp-load.php';

global $wpdb;
$table_name = 'nc_sync';
$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  post_type varchar(255) NOT NULL,
  es_ES bigint(20),
  es_MX bigint(20),
  es_CL bigint(20),
  es_CO bigint(20),
  en_GB bigint(20),
  en_US bigint(20),
  de_DE bigint(20),
  de_AT bigint(20),
  fr_FR bigint(20),
  es_ES_status tinyint(1),
  es_MX_status tinyint(1),
  es_CL_status tinyint(1),
  es_CO_status tinyint(1),
  en_GB_status tinyint(1),
  en_US_status tinyint(1),
  de_DE_status tinyint(1),
  de_AT_status tinyint(1),
  fr_FR_status tinyint(1),
  created_at timestamp,
  updated_at timestamp,
  PRIMARY KEY  (id)
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);
