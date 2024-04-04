<?php

//wp eval-file qa-process.php

require ABSPATH.'wp-load.php';

global $wpdb;

//1 Borramos los metas.

$sites = get_sites();
$plugins_to_activate = [
                          'dw-question-answer',
                          'bbpress'
                        ];

foreach ($sites as $site) {
    switch_to_blog($site->blog_id);

    foreach ($plugins_to_activate as $pluginName) {
        $site_param = '--url='.get_site_url();

        $command = 'wp plugin activate "'.$pluginName.'"  '.$site_param;
        echo $command.PHP_EOL;
        $output = shell_exec($command);
    }
}
