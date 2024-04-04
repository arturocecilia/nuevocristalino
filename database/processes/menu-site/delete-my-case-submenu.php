<?php



global $wpdb;
$sites = get_sites();


$siteMenuItemParent = array('es_ES' => 4,
                            'es_MX' => 14863,
                            'es_CO' => 15092,
                            'en_GB' => 4,
                            'en_US' => 4,
                            'fr_FR' => 4,
                            'de_DE' => 16111,
                            'de_AT' => 16111);

foreach ($sites as $site) {
    switch_to_blog($site->blog_id);

    $siteLocale = get_blog_option($site->blog_id, 'WPLANG');

    $menuItemTitle = get_the_title($siteMenuItemParent[$siteLocale]);


    $sql = 'SELECT ID
        FROM '.$wpdb->posts.'
         where post_type = "nav_menu_item"
         and post_title = "'.$menuItemTitle.'"';

    $menuParentId =  $wpdb->get_var($sql);

    if (!$menuParentId) {
        continue;
    }
    $sql =
        'SELECT post_id
         FROM '.$wpdb->postmeta.'
	       where meta_key = "_menu_item_menu_item_parent" and
		           meta_value in (
                              SELECT post_id
                              FROM '.$wpdb->postmeta.'
                              where meta_key = "_menu_item_menu_item_parent" and
			                          meta_value = '.$menuParentId.')
                UNION
        SELECT post_id
        FROM '.$wpdb->postmeta.'
        where meta_key = "_menu_item_menu_item_parent" and
			     meta_value = '.$menuParentId;

    $postsToDelete = $wpdb->get_col($sql);
    $postsToDelete = array_merge($postsToDelete, [$siteMenuItemParent[$siteLocale]]);

    $sql = 'DELETE a,b,c
            FROM '.$wpdb->posts.' a
                LEFT JOIN '.$wpdb->term_relationships.' b
                ON (a.ID = b.object_id)
                LEFT JOIN '.$wpdb->postmeta.' c
                ON (a.ID = c.post_id)
                WHERE a.ID IN ('.join(',', $postsToDelete).')';

    echo 'ejecutando: '.PHP_EOL.$sql.PHP_EOL;
    $wpdb->query($sql);
}
