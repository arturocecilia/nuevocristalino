<?php

//wp eval-file qa-process.php

require '../wp-load.php';

global $wpdb;

//1 Borramos los metas.

$sites = get_sites();
$plugins_to_deactivate = [
                          'bbpress',
                          'custom-contact-forms',
                          'download-manager',
                          'jquery-mega-menu',
                          'jquery-vertical-accordion-menu',
                          'clinica',
                          'fabricante',
                          'lente-intraocular',
                          'opinion-doctor',
                          'proveedor',
                          'posts-to-posts',
                          'recently-registered',
                          'w3-total-cache',
                          'wordfence',
                          'wp-user-avatar',
                          'yarpp-for-bbpress',
                          'yet-another-related-posts-plugin',
                          'wordpress-seo'
                        ];

foreach ($sites as $site) {
    switch_to_blog($site->blog_id);

//    foreach ($plugins_to_activate as $pluginName) {
    $site_param = '--url='.get_site_url();

    $command = 'wp plugin deactivate --all --network';//'"'.$pluginName.'"  ';//.$site_param;
    echo $command.PHP_EOL;
    $output = shell_exec($command);
    $command = 'wp plugin deactivate --all '.$site_param;
    $output = shell_exec($command);
    echo $output.PHP_EOL;
//    }
}
