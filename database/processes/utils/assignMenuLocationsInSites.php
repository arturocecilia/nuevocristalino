<?php



/*
  array(
        site_id => array(menu => menu_location),
        site_id2 = >array()
        );

*/



function assignMenuLocationsInSites($sitesIdsMenusLocations)
{
    //$ wp menu location assign primary-menu primary
    //$sites = array_keys($sitesIdsMenusLocations);

    foreach ($sitesIdsMenusLocations as $site_id => $menuMmenuLocations) {
        switch_to_blog($site_id);
        foreach ($menuMmenuLocations as $menu => $menuLocation) {
            $site_param = '--url='.get_site_url();

            echo $site_id.' - '.$menu.' - '.$menuLocation.PHP_EOL;

            $command = 'wp menu location assign '.$menu.' '.$menuLocation.' '.$site_param;
            echo $command.PHP_EOL;
            $output = shell_exec($command);
            echo $output.PHP_EOL;
        }
    }
}
