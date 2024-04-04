<?php

//wp eval-file qa-process.php

require '../wp-load.php';

global $wpdb;

//1 Borramos los metas.

$sites = get_sites();
$meta_keys_to_delete = [
                        'es_ES',
                        'es_MX',
                        'es_CO',
                        'es_CL',
                        'en_GB',
                        'en_UK',//residual
                        'en_US',
                        'de_DE',
                        'de_AT',
                        'fr_FR'
                        ];

foreach ($sites as $site) {
    switch_to_blog($site->blog_id);

    foreach ($meta_keys_to_delete as $metakey) {
        //Borramos los metas to delete
        //echo get_site_url().' - '.$wpdb->postmeta.PHP_EOL;
        $sql = 'DELETE FROM `'.$wpdb->postmeta.'` WHERE meta_key = "'.$metakey.'"';
        $wpdb->query($sql);
    }
}
