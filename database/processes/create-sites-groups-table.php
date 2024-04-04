<?php

require '../wp-load.php';

global $wpdb;
$table_name = 'nc_sites_groups';
$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  main_site_id mediumint(9) NOT NULL,
  qa_site_id mediumint(9),
  forum_site_id mediumint(9),
  proms_site_id mediumint(9),
  group_site_key text,
  created_at timestamp,
  updated_at timestamp,
  PRIMARY KEY  (id)
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);
