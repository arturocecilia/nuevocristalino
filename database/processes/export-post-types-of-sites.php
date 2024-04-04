<?php

require '../wp-load.php';

function exportPostTypesOfSites($posttypes_to_export, $exportNameSlug, $sites, $relatedPlugins)
{
    foreach ($sites as $site) {
        switch_to_blog($site->blog_id);
        $dir_param = '--dir='.ABSPATH.'database/processes/exports/'.$exportNameSlug.'-exports/' ;//qa
        $post_type_param = '--post_type='.join(',', $posttypes_to_export);//dwqa-question,dwqa-answer
        $site_param = '--url='.get_site_url();
        $file_name = '--filename_format='.$site->blog_id.'.'.$exportNameSlug.'.xml';//{site} qa

        foreach ($relatedPlugins as $pluginName) {
            $commandPluginActivate = 'wp plugin activate "'.$pluginName.'"  '.$site_param;
            echo $commandPluginActivate.PHP_EOL;
            $output = shell_exec($commandPluginActivate);
        }


        $command = 'wp export '.$post_type_param.' '.$site_param.' '.$file_name.' '.$dir_param;
        echo $command.PHP_EOL;
        $output = shell_exec($command);
    }
}
