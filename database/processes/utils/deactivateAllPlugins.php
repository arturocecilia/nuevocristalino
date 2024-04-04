<?php


function deactivateAllPlugins($sites)
{
    foreach ($sites as $site) {
        switch_to_blog($site->blog_id);

        $site_param = '--url='.get_site_url();

        $command = 'wp plugin deactivate --all --network';
        echo $command.PHP_EOL;
        $output = shell_exec($command);
        $command = 'wp plugin deactivate --all '.$site_param;
        $output = shell_exec($command);
        echo $output.PHP_EOL;
    }
}
