<?php

require '../wp-load.php';

function importContentToSite($importSlug, $blog_id_from, $blog_id_to, $relatedPlugins)
{
    switch_to_blog($blog_id_to);
    $file_param = ABSPATH.'database/processes/exports/'.$importSlug.'-exports/'.$blog_id_from.'.'.$importSlug.'.xml' ;//qa
    $site_param = '--url='.get_site_url();
    $authors_param = '--authors=create';//{site} qa
    $command = 'wp import '.$file_param.' '.$site_param.' '.$authors_param;
    echo $command.PHP_EOL;

    shell_exec('wp plugin activate wordpress-importer '.$site_param);

    foreach ($relatedPlugins as $relatedPlugin) {
        shell_exec('wp plugin activate '.$relatedPlugin.' '.$site_param);
    }

    $output = shell_exec($command);
    return $output;
}
