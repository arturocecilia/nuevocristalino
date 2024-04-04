<?php

//wp eval-file qa-process.php

require '../wp-load.php';

function replaceTaxonomyKeysInSites($sites, $taxonomy_keys_to_replace)
{
    global $wpdb;

    foreach ($sites as $site) {
        switch_to_blog($site->blog_id);

        foreach ($taxonomy_keys_to_replace as $old_taxonomy => $new_taxonomy) {
            //echo get_site_url().' - '.$wpdb->postmeta.PHP_EOL;
            $sql = 'UPDATE `'.$wpdb->term_taxonomy.'` SET taxonomy = REPLACE(taxonomy,"'.$old_taxonomy.'","'.$new_taxonomy.'" ) WHERE taxonomy="'.$old_taxonomy.'"';

            $wpdb->query($sql);
        }
    }
}
