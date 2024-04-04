<?php

require '../wp-content/plugins/mu-plugins/eloquent.php';
require '../wp-load.php';

use App\Models\NcSiteGroup;
use \Illuminate\Database\Capsule\Manager as Capsule;

$pluginsSetup = Capsule::table('nc_network_plugin_setup')->get()->toArray();

$sites = NcSiteGroup::all();

foreach ($pluginsSetup as $pluginSetup) {
    $pluginSetup = (array)$pluginSetup;
    echo 'Procesando plugin: '.$pluginSetup['plugin_name'].PHP_EOL;
    if ($pluginSetup['network_activated']) {
        $pluginName = $pluginSetup['plugin_name'];
        $command = 'wp plugin activate --network "'.$pluginName.'"  ';
        echo $command.PHP_EOL;
        $output = shell_exec($command);
        echo $output.PHP_EOL;
        continue;
    }

    //A ver ahora como hago esto...
    foreach ($pluginSetup as $infoKey => $value) {
        if (in_array($infoKey, ['network_activated', 'plugin_name','id','created_at','updated_at'])) {
            continue;
        }
        echo 'el infoKey es: '.$infoKey.PHP_EOL;
        echo 'el value: '.$value.PHP_EOL;
        if ($value) {
            $siteKeySegments = explode('_', $infoKey);
            $group_site_key = $siteKeySegments[2].'_'.$siteKeySegments[3];
            $site_column_in_groupsites = $siteKeySegments[0].'_'.$siteKeySegments[1].'_id';

            echo 'Buscamos: '.$group_site_key.PHP_EOL;
            echo 'el id: '.$site_column_in_groupsites.PHP_EOL;


            $siteId = NcSiteGroup::where('group_site_key', $group_site_key)
                    ->first()
                    ->{$site_column_in_groupsites};
            echo 'En site: '.$siteId.' está activo el plugin: "'.$pluginSetup['plugin_name'].'", lo activamos'.PHP_EOL;

            switch_to_blog($siteId);

            $site_param = '--url='.get_site_url();

            $command = 'wp plugin activate "'.$pluginSetup['plugin_name'].'"  '.$site_param;
            echo $command.PHP_EOL;
            $output = shell_exec($command);
            echo $output;
        }
    }
}

/*
$themesSetup = Capsule::table('nc_network_theme_setup')->get()->toArray();

$sites = NcSiteGroup::all();

foreach ($themesSetup as $themeSetup) {
    $themeSetup = (array)$themeSetup;

    //A ver ahora como hago esto...
    foreach ($themeSetup as $infoKey => $value) {
        if (in_array($infoKey, ['theme_name','id','created_at','updated_at'])) {
            continue;
        }
        echo 'el infoKey es: '.$infoKey.PHP_EOL;
        echo 'el value: '.$value.PHP_EOL;
        if ($value) {
            $siteKeySegments = explode('_', $infoKey);
            $group_site_key = $siteKeySegments[2].'_'.$siteKeySegments[3];
            $site_column_in_groupsites = $siteKeySegments[0].'_'.$siteKeySegments[1].'_id';

            echo 'Buscamos: '.$group_site_key.PHP_EOL;
            echo 'el id: '.$site_column_in_groupsites.PHP_EOL;


            $siteId = NcSiteGroup::where('group_site_key', $group_site_key)
                    ->first()
                    ->{$site_column_in_groupsites};
            echo 'En site: '.$siteId.' está activo el theme, lo activamos'.PHP_EOL;

            switch_to_blog($siteId);

            $site_param = '--url='.get_site_url();

            $command = 'wp theme activate "'.$themeSetup['theme_name'].'"  '.$site_param;
            echo $command.PHP_EOL;
            $output = shell_exec($command);
        }
    }
}*/
