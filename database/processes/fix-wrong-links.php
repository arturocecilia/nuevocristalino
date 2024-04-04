<?php


require ABSPATH.'/wp-content/plugins/mu-plugins/eloquent.php';
require ABSPATH.'/wp-load.php';

global $wpdb;


$sites = get_sites();


foreach ($sites as $site) {
    if ($site->blog_id != 1) {
        $tableName =   'wp_'.$site->blog_id.'_redirection_logs';
    } else {
        $tableName =   'wp_redirection_logs';
    }
    $wrongUrls = $capsule->table($tableName)
                         ->get();

    switch_to_blog($site->blog_id);

    $siteUrl  = get_site_url();


    foreach ($wrongUrls as $wrongUrl) {
        $url = $wrongUrl->url;
        $sent_to = $wrongUrl->sent_to;

        if (strpos($sent_to, $siteUrl) !== false) {
        } else {
            $sent_to =   $siteUrl.$wrongUrl->sent_to;
        }


        if (strpos($url, $siteUrl) !== false) {
        } else {
            $url = $siteUrl.$wrongUrl->url;
        }


        $updateQuery = 'update '.$wpdb->posts.'
                        set post_content = REPLACE(post_content,"'.$url.'","'.$sent_to.'")';
        echo $updateQuery.PHP_EOL;
        //  $wpdb->query($updateQuery);
    }
}
