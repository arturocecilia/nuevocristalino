<?php

//wp eval-file qa-process.php

require '../wp-load.php';

global $wpdb;

//1 Borramos los metas.

$sites = get_sites();
$post_types_to_delete = [
                        'dumb-cpt'
                        ];

foreach ($sites as $site) {
    switch_to_blog($site->blog_id);

    foreach ($post_types_to_delete as $post_type) {
        $sql = 'DELETE a,b,c
                FROM '.$wpdb->posts.' a
                LEFT JOIN '.$wpdb->term_relationships.' b
                    ON (a.ID = b.object_id)
                LEFT JOIN '.$wpdb->postmeta.' c
                    ON (a.ID = c.post_id)
                WHERE a.post_type = "'.$post_type.'"';
        $wpdb->query($sql);
    }
}
