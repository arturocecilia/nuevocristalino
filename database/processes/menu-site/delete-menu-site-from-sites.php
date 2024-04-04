<?php

require ABSPATH.'/wp-content/plugins/mu-plugins/eloquent.php';
require ABSPATH.'/wp-load.php';

use App\Models\NcSiteGroup;
use App\Models\NcMenuSiteSync;

$mainSitesToDelMenuIds = NcSiteGroup::whereIn('group_site_key', ['en_GB', 'en_US', 'fr_FR','de_AT'])
                             ->get()
                             ->pluck('main_site_id');


foreach ($mainSitesToDelMenuIds as $siteid) {
    switch_to_blog($siteid);
    echo 'new_site: '.$siteid.PHP_EOL;
    $menuItemsQuery = new WP_Query(
                                  array(
                                        'posts_per_page' => -1,
                                        'post_type' => 'nav_menu_item',
                                        'tax_query' => array(
                                          array(
                                                 'taxonomy' => 'nav_menu',
                                                 'terms' => 'menu-site',
                                                 'field' => 'slug'
                                              )
                                                            )
                                         )
                                   );

    $menuitems =   $menuItemsQuery->posts;


    foreach ($menuitems as $menuitem) {
        wp_delete_post($menuitem->ID, true);
//        echo $menuitem->ID.PHP_EOL;
    }
}
