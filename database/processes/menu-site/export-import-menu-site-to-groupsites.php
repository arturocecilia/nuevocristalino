<?php

require ABSPATH.'/wp-content/plugins/mu-plugins/eloquent.php';
require ABSPATH.'/wp-load.php';

use App\Models\NcSiteGroup;
use App\Models\NcMenuSiteSync;

function exportImportMenuSiteToGroupSites($groupSiteKeys)//['es_ES','de_DE']
{
    global $wpdb;

    $groupSites = NcSiteGroup::whereIn('group_site_key', $groupSiteKeys)->get();//all();//->pluck('main_site_id');// get_sites();



    foreach ($groupSites as $groupSite) {
        switch_to_blog($groupSite->main_site_id);//$site->blog_id


        $sql = "SELECT object_id
            FROM ".$wpdb->term_relationships."
			           where term_taxonomy_id in
					        (SELECT term_taxonomy_id
					         FROM ".$wpdb->term_taxonomy."
								        where taxonomy= 'nav_menu'
								                and term_id IN
										                (SELECT term_id
										                 FROM ".$wpdb->terms."
													                where slug = 'menu-site')
                                                    )" ;

        $post_ids = $wpdb->get_col($sql);//get_results

        $relGroupSites = array(
                            'qa_site' => $groupSite->qa_site_id,
                            'forum_site' => $groupSite->forum_site_id,
                            'proms_site' => $groupSite->proms_site_id
                          );

        foreach ($post_ids as $post_id) {
            switch_to_blog($groupSite->main_site_id);//$site->blog_id
            $menuItemSynched = new NcMenuSiteSync();
            $menuItemSynched->site_group_id = $groupSite->id;
            $menuItemSynched->main_site_menu_item_id = $post_id;

            $post_id = (int) $post_id;
            $postDataToInsert = (array) get_post($post_id);
            $postMetaToInsert= [];
            $postMetaToInsertArray = get_post_meta($post_id, '', true);

            foreach ($postMetaToInsertArray as $metaArrayKey => $arrayValue) {
                $postMetaToInsert[$metaArrayKey] = maybe_unserialize($arrayValue[0]);
            }


            $postDataToInsert['ID'] = 0;
            echo 'Insertando post: '.$post_id.PHP_EOL;

            //$menuItemParent = $postMetaToInsert['_menu_item_menu_item_parent'] ;
            $postMetaToInsert['_menu_item_menu_item_parent'] = 0;

            if (array_key_exists('_menu_item_type', $postMetaToInsert)) {
                if ($postMetaToInsert['_menu_item_type'] != 'custom') {
                    $postMetaToInsert['_menu_item_type'] = 'custom';
                    echo 'El object id al que estaba referido era: '.$postMetaToInsert['_menu_item_object_id'].PHP_EOL;
                    var_dump($postMetaToInsert['_menu_item_object_id']);
                    echo 'El permalink por lo tanto: '.get_permalink($postMetaToInsert['_menu_item_object_id']).PHP_EOL;
                    $postMetaToInsert['_menu_item_url'] = get_permalink($postMetaToInsert['_menu_item_object_id']);
                    echo 'Url asignada: '.$postMetaToInsert['_menu_item_url'].PHP_EOL;
                    //$postMetaToInsert['_menu_item_object_id'] = $post_id;
                    $postMetaToInsert['_menu_item_object'] = 'custom';
                }
            }
            $postDataToInsert['meta_input'] = $postMetaToInsert;
            //  $postDataToInsert['tax_input'] = array('nav_menu' => 'menu-site');

            foreach ($relGroupSites as $siteTypeKey => $relSiteId) {
                echo 'relSite: '.$relSiteId.PHP_EOL;
                switch_to_blog($relSiteId);

                $insertedPost = wp_insert_post($postDataToInsert, true);
                if (is_wp_error($insertedPost)) {
                    var_dump($insertedPost);
                } else {
                    update_post_meta($insertedPost, '_menu_item_object_id', $insertedPost);

                    wp_set_object_terms($insertedPost, 'menu-site', 'nav_menu');

                    echo 'Insertado post: '.$insertedPost.PHP_EOL;

                    $menuItemSynched->{$siteTypeKey.'_menu_item_id'} = $insertedPost;

                    $menuItemSynched->save();

                    //Vamos ahora con el tema de
                }
            }
        }

        //Vamos ahora con la jerarquía
        foreach ($post_ids as $post_id) {
            switch_to_blog($groupSite->main_site_id);
            $post_id = (int) $post_id;
            $postMetaToInsert= [];
            $postMetaToInsertArray = get_post_meta($post_id, '', true);

            foreach ($postMetaToInsertArray as $metaArrayKey => $arrayValue) {
                $postMetaToInsert[$metaArrayKey] = maybe_unserialize($arrayValue[0]);
            }

            echo 'Añadiendo jerarquía a post: '.$post_id.PHP_EOL;

            $menuItemParent = $postMetaToInsert['_menu_item_menu_item_parent'] ;
            echo 'El post Parent es: '.$menuItemParent.PHP_EOL;

            $menuItemSync =  NcMenuSiteSync::where('main_site_menu_item_id', $post_id)
                                          ->where('site_group_id', $groupSite->id)
                                          ->first();
            echo 'Menu Item Sync: '.$menuItemSync->id.PHP_EOL;
            $menuItemParentFound=null;
            if ($menuItemParent!=0 && $menuItemParent!='') {
                $menuItemParentFound =  NcMenuSiteSync::where('main_site_menu_item_id', $menuItemParent)
                                                      ->where('site_group_id', $groupSite->id)
                                                      ->first();
            }

            foreach ($relGroupSites as $siteTypeKey => $relSiteId) {
                echo 'relSite: '.$relSiteId.PHP_EOL;
                switch_to_blog($relSiteId);
                if ($menuItemParentFound) {
                    $thisSiteMenuParentItemId =   $menuItemParentFound->{$siteTypeKey.'_menu_item_id'};
                    //Vamos ahora con el tema de
                    echo 'El padre ya estaba cargado en sync: '.$menuItemParentFound->id.PHP_EOL;
                } else {
                    $thisSiteMenuParentItemId=0;
                }
                $menuItemSyncItemId = $menuItemSync->{$siteTypeKey.'_menu_item_id'};

                update_post_meta($menuItemSyncItemId, '_menu_item_menu_item_parent', $thisSiteMenuParentItemId);
            }
        }
    }


//
}
