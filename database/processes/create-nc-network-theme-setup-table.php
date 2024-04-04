<?php

require '../wp-load.php';

global $wpdb;
$table_name = 'nc_network_theme_setup';
$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  theme_name varchar(255) NOT NULL,
  main_site_es_ES tinyint(1),
  main_site_es_MX tinyint(1),
  main_site_es_CL tinyint(1),
  main_site_es_CO tinyint(1),
  main_site_en_GB tinyint(1),
  main_site_en_US tinyint(1),
  main_site_de_DE tinyint(1),
  main_site_de_AT tinyint(1),
  main_site_fr_FR tinyint(1),
  qa_site_es_ES tinyint(1),
  qa_site_es_MX tinyint(1),
  qa_site_es_CL tinyint(1),
  qa_site_es_CO tinyint(1),
  qa_site_en_GB tinyint(1),
  qa_site_en_US tinyint(1),
  qa_site_de_DE tinyint(1),
  qa_site_de_AT tinyint(1),
  qa_site_fr_FR tinyint(1),
  forum_site_es_ES tinyint(1),
  forum_site_es_MX tinyint(1),
  forum_site_es_CL tinyint(1),
  forum_site_es_CO tinyint(1),
  forum_site_en_GB tinyint(1),
  forum_site_en_US tinyint(1),
  forum_site_de_DE tinyint(1),
  forum_site_de_AT tinyint(1),
  forum_site_fr_FR tinyint(1),
  created_at timestamp,
  updated_at timestamp,
  PRIMARY KEY  (id)
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);
