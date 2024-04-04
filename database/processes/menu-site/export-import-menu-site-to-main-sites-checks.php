<?php

require ABSPATH.'/wp-content/plugins/mu-plugins/eloquent.php';
require ABSPATH.'/wp-load.php';

use App\Models\NcSiteGroup;
use App\Models\NcMenuSiteSync;

global $wpdb;



$groupSiteRoot = NcSiteGroup::where('group_site_key', 'es_ES')
                            ->first();

switch_to_blog($groupSiteRoot->main_site_id);

$sqlTargets =  "SELECT meta_value
         FROM ".$wpdb->postmeta."
         where meta_key ='_menu_item_object_id'
         and post_id IN
         (SELECT object_id
         FROM ".$wpdb->term_relationships."
			      where term_taxonomy_id in
					       (SELECT term_taxonomy_id
					        FROM ".$wpdb->term_taxonomy."
								       where taxonomy= 'nav_menu'
								               and term_id IN
										              (SELECT term_id
										               FROM ".$wpdb->terms."
													                where slug = 'menu-site')))";


$sqlMenuItems =  "(SELECT object_id
                   FROM ".$wpdb->term_relationships."
                      where term_taxonomy_id in
                      (SELECT term_taxonomy_id
                       FROM ".$wpdb->term_taxonomy."
                           where taxonomy= 'nav_menu'
                           and term_id IN
                           (SELECT term_id
                            FROM ".$wpdb->terms."
                                  where slug = 'menu-site')))";

$sql = $sqlMenuItems;//$sqlTargets
    $post_ids = $wpdb->get_col($sql);



$sitesTargetsIds =  NcSiteGroup::whereIn('group_site_key', ['en_GB','en_US','fr_FR'])
                                 ->get()
                                 ->pluck('main_site_id');


    foreach ($post_ids as $post_id) {
        //Primero pillamos el data del post que tiene que existir.
        //Esto es sólo para chequear los posts destino no para crear el menu-site.
        //De hecho es un chequeo.
        switch_to_blog($groupSiteRoot->main_site_id);
        $post_id = (int) $post_id;
        $postDataCheck =  get_post($post_id);
        if (!$postDataCheck) {
            echo 'el post: '.$post_id.' no existía en es_ES. '.PHP_EOL;
            continue;
        }
        $post_type = $postDataCheck->post_type;
        $post_title= $postDataCheck->post_title;
        $post_name= $postDataCheck->post_name;


        foreach ($sitesTargetsIds as $siteTargetId) {
            switch_to_blog($siteTargetId);
            //echo 'Verifying in site: '.$siteTargetId.PHP_EOL;
            if ($post = get_post($post_id)) {
                if ($post->post_type != $post_type) {
                    echo 'Chequear!!!!! '.$post_id.PHP_EOL;

                    echo $post->post_type.' - '.$post_type.PHP_EOL;

                    if ($post->post_type == 'dumb-cpt') {
                        echo 'TODO OK'.PHP_EOL;
                    }//fabricant -manufacturer.vs fabricante.
                }
            } else {
                echo 'No había sincronismo en post: '.$post_id.PHP_EOL;
                echo 'Hay que crear '.$post_type.PHP_EOL;
                echo 'title: '.$post_title.PHP_EOL;
            }
        }




//
    }
