<?php


$menuSlugsToDelete = array(
                          'menu-mync',
                          'menu-mync-profile',
                          'menu-mync-myprofile',
                          'menu-myprofile',
                          'menu-myprofile-mync',
                          'menu-myprofile-professional'
);

$sites = get_sites();


foreach ($sites as $site) {
    switch_to_blog($site->blog_id);
    foreach ($menuSlugsToDelete as $menuSlug) {
        $deleted =   wp_delete_nav_menu($menuSlug);

        var_dump($deleted);
    }
}
