<?php

//wp eval-file qa-process.php

require '../wp-load.php';


function replacePostMetaKeysInSites($sites, $meta_keys_to_replace)
{
    global $wpdb;

    foreach ($sites as $site) {
        switch_to_blog($site->blog_id);

        foreach ($meta_keys_to_replace as $old_metakey => $new_metakey) {
            $sql = 'UPDATE `'.$wpdb->postmeta.'` SET meta_key = REPLACE(meta_key,"'.$old_metakey.'","'.$new_metakey.'" ) WHERE meta_key="'.$old_metakey.'"';
            $wpdb->query($sql);
        }
    }
}
