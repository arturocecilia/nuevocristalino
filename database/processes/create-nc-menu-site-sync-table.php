<?php

require '../wp-load.php';

global $wpdb;
$table_name = 'nc_menu_site_sync';
$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  site_group_id bigint(20),
  main_site_menu_item_id bigint(20),
  qa_site_menu_item_id bigint(20),
  forum_site_menu_item_id bigint(20),
  proms_site_menu_item_id bigint(20),
  created_at timestamp,
  updated_at timestamp,
  PRIMARY KEY  (id)
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);
