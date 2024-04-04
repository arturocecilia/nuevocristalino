<?php


require '../wp-load.php';

function replaceCptsInSites($sites, $posttype_to_replace)
{
    global $wpdb;
    foreach ($sites as $site) {
        switch_to_blog($site->blog_id);

        foreach ($posttype_to_replace as $old_posttype => $new_posttype) {
            //echo get_site_url().' - '.$wpdb->postmeta.PHP_EOL;
            $sql = 'UPDATE `'.$wpdb->posts.'` SET post_type = REPLACE(post_type,"'.$old_posttype.'","'.$new_posttype.'" ) WHERE post_type="'.$old_posttype.'"';

            $wpdb->query($sql);
        }
    }
}
