<?php

require ABSPATH.'/wp-content/plugins/mu-plugins/eloquent.php';
require ABSPATH.'/wp-load.php';

use App\Models\NcSiteGroup;
use App\Models\NcMenuSiteSync;

moveUrlPromsPagesToPromsSite();

function moveUrlPromsPagesToPromsSite($pageIds = [13725,13157,15223,14667,12628, 12629, 15231,14302,15228,15206,15229,15364,15371,15382,15383])//['es_ES','de_DE']
{
    global $wpdb;

    $sites = get_sites();

    foreach ($sites as $site) {
        switch_to_blog($site->blog_id);//$site->blog_id


        $sql = "
                SELECT distinct(post_id)
                FROM ".$wpdb->postmeta."
                  where post_id in
                  (SELECT object_id
                   FROM ".$wpdb->term_relationships."
			                where term_taxonomy_id in
					            (SELECT term_taxonomy_id
					             FROM ".$wpdb->term_taxonomy."
								        where taxonomy= 'nav_menu'
                      )
                    )
                    and post_id in
                (SELECT post_id
                 FROM ".$wpdb->postmeta."
	                where meta_value in(".join(',', $pageIds)."
                    ))" ;
        //12628, 12629, 15231,14302,15228,15206,15229,15364,15371,15382,15383,13171

        $post_ids = $wpdb->get_col($sql);//get_results


        foreach ($post_ids as $post_id) {
            $post_id = (int) $post_id;
            $postMetaToInsertArray = get_post_meta($post_id, '', true);

            $page_id = get_post_meta($post_id, '_menu_item_object_id', true);

            $oldUrl = get_permalink($page_id);

            if (strpos($oldUrl, get_site_url().'/proms/') === false) {
                $newUrl =   str_replace(get_site_url(), get_site_url().'/proms', $oldUrl);
            } else {
                $newUrl = $oldUrl;
            }
            update_post_meta($post_id, '_menu_item_type', 'custom');
            update_post_meta($post_id, '_menu_item_url', $newUrl);
            update_post_meta($post_id, '_menu_item_object_id', $post_id);
            update_post_meta($post_id, '_menu_item_object', 'custom');
        }
    }


//
}
