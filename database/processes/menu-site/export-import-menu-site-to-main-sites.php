<?php

require ABSPATH.'/wp-content/plugins/mu-plugins/eloquent.php';
require ABSPATH.'/wp-load.php';

use App\Models\NcSiteGroup;
use App\Models\NcMenuSiteSync;
use App\Models\NcMenuSiteMainSiteSync;

if (!function_exists('processTranslator')) {
    include(ABSPATH.'database/processes/process-translator.php');
}

function exportMenuSiteToMainSites($siteKeyFrom, $sitesKeysTo, $menuSlug, $menuSlug='menu-site')
{
    global $wpdb;

    $groupSiteRoot = NcSiteGroup::where('group_site_key', $siteKeyFrom)
                                ->first();// 'es_ES'

    switch_to_blog($groupSiteRoot->main_site_id);

    $sql =  "SELECT object_id
                   FROM ".$wpdb->term_relationships."
                      where term_taxonomy_id in
                      (SELECT term_taxonomy_id
                       FROM ".$wpdb->term_taxonomy."
                           where taxonomy= 'nav_menu'
                           and term_id IN
                           (SELECT term_id
                            FROM ".$wpdb->terms."
                                  where slug = '".$menuSlug."'))";
    //echo PHP_EOL.$sql.PHP_EOL;
    $post_ids = $wpdb->get_col($sql);



    $sitesTargetsIds =  NcSiteGroup::whereIn('group_site_key', $sitesKeysTo)//['en_GB','en_US','fr_FR']
                                 ->get()
                                 ->pluck('main_site_id');
    $fabricanteConvert = array(
                            'en_GB' => 'manufacturer',
                            'en_US' => 'manufacturer',
                            'fr_FR' => 'fabricant',
                            'es_CL' => 'fabricante'
                            );

    foreach ($post_ids as $post_id) {
        switch_to_blog($groupSiteRoot->main_site_id);
        $post_id = (int) $post_id;


        $mainSiteLocale = get_blog_option($groupSiteRoot->main_site_id, 'WPLANG');
        $menuitem = new NcMenuSiteMainSiteSync();

        $menuitem->{$mainSiteLocale.'_id'} = $post_id;

        $postDataToUpdate =  get_post($post_id);
        $postMetaToUpdate= [];
        $postMetaToUpdateArray = get_post_meta($post_id, '', true);

        foreach ($postMetaToUpdateArray as $metaArrayKey => $arrayValue) {
            $postMetaToUpdate[$metaArrayKey] = maybe_unserialize($arrayValue[0]);
        }


        foreach ($sitesTargetsIds as $siteTargetId) {
            switch_to_blog($siteTargetId);
            $siteLocale = get_blog_option($siteTargetId, 'WPLANG');
            $postNewMenuItem = get_post($post_id);


            if ($postMetaToUpdate['_menu_item_object'] == 'fabricante') {
                $postMetaToUpdate['_menu_item_object'] = $fabricanteConvert[$siteLocale];
            }


            if ($postNewMenuItem && $postNewMenuItem->post_type == 'dumb-cpt') {
                echo 'El item de menu es: '.$postDataToUpdate->post_title.PHP_EOL;

                $menuitem->{$siteLocale.'_id'} = $post_id;

                wp_set_object_terms($post_id, 'menu-site', 'nav_menu');

                foreach ($postMetaToUpdate as $metaKey => $value) {
                    update_post_meta($post_id, $metaKey, $value);
                }

                wp_update_post(
                              array(
                                    'ID' =>$post_id,
                                    'post_title' => processTranslator($postDataToUpdate->post_title, $siteLocale),
                                    'post_name' =>  $postDataToUpdate->post_name,
                                    'post_type' => 'nav_menu_item',
                                    'menu_order' =>$postDataToUpdate->menu_order,
                                    'post_status' => 'publish'
                                  )
                                );
            } else {
                if ($postNewMenuItem) {
                    echo 'Había un post con ese id y no era de post_type: cpt_dumb'.PHP_EOL;
                }
                //hay que crear uno nuevo.
                echo 'PROBLEMA EN EL ITEM DE MENU: '.$post_id.PHP_EOL;
                echo $postDataToUpdate->post_title.PHP_EOL;
                echo 'HABRÁ QUE CREAR UNO NUEVO';


                $newMenuItem = wp_insert_post(
                              array(
//                                    'ID' =>$post_id,
                                    'post_title' => processTranslator($postDataToUpdate->post_title, $siteLocale),
                                    'post_name' =>  $postDataToUpdate->post_name,
                                    'post_type' => 'nav_menu_item',
                                    'menu_order' =>$postDataToUpdate->menu_order,
                                    'post_status' => 'publish'
                                  )
                                );
                echo 'nuevo menuitem creado: '.$newMenuItem.PHP_EOL;
                var_dump(
                  array(
//                                    'ID' =>$post_id,
                        'post_title' => processTranslator($postDataToUpdate->post_title, $siteLocale),
                        'post_name' =>  $postDataToUpdate->post_name,
                        'post_type' => 'nav_menu_item',
                                                            'menu_order' =>$postDataToUpdate->menu_order,
                        'post_status' => 'publish'
                      )

                );

                $menuitem->{$siteLocale.'_id'} = $newMenuItem;

                wp_set_object_terms($newMenuItem, 'menu-site', 'nav_menu');

                foreach ($postMetaToUpdate as $metaKey => $value) {
                    update_post_meta($newMenuItem, $metaKey, $value);
                }
            }
        }
        $menuitem->save();
    }

    //Ahora hay que actualizar los parents :)


    foreach ($post_ids as $post_id) {
        switch_to_blog($groupSiteRoot->main_site_id);
        $post_id = (int) $post_id;

        $mainSiteLocale = get_blog_option($groupSiteRoot->main_site_id, 'WPLANG');
        $postMetaToUpdateArray = get_post_meta($post_id, '', true);

        foreach ($postMetaToUpdateArray as $metaArrayKey => $arrayValue) {
            $postMetaToUpdate[$metaArrayKey] = maybe_unserialize($arrayValue[0]);
        }

        $postMenuItemParent = $postMetaToUpdate['_menu_item_menu_item_parent'];

        $menuItem = NcMenuSiteMainSiteSync::where($mainSiteLocale.'_id', $post_id)->first();
        $parentMenuItem = NcMenuSiteMainSiteSync::where($mainSiteLocale.'_id', $postMenuItemParent)->first();


        if ($parentMenuItem !=0) {
            echo $menuItem->id.' ->'.$parentMenuItem->id.PHP_EOL;

            foreach ($sitesTargetsIds as $siteTargetId) {
                switch_to_blog($siteTargetId);

                $siteLocale = get_blog_option($siteTargetId, 'WPLANG');

                $menuItemRelId = $menuItem->{$siteLocale.'_id'};
                $parentRelMenuItemID = $parentMenuItem->{$siteLocale.'_id'};
                if ($parentRelMenuItemID!=$parentMenuItem->id) {
                    echo 'CAMBIO DE PARENT'.PHP_EOL;
                    echo $menuItemRelId.' - '.$parentRelMenuItemID.PHP_EOL;
                }
                update_post_meta($menuItemRelId, '_menu_item_menu_item_parent', $parentRelMenuItemID);
            }
        }
    }
}


/*
                //set_post_type($post_id, 'nav_menu_item');//$postDataToUpdate->post_type
*/
