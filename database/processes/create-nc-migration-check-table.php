<?php

require ABSPATH.'/wp-load.php';

global $wpdb;
$table_name = 'nc_migration_check';
$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  blog_id bigint(20),
  post_id bigint(20),
  post_type  varchar(255) NOT NULL,
  status_code_ini  mediumint(9),
  status_code_target  mediumint(9),
  url  varchar(550) NOT NULL,
  created_at timestamp,
  updated_at timestamp,
  PRIMARY KEY  (id)
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);
