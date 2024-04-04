<?php



function activateThemeInSite($site_id, $theme_name)
{
    switch_to_blog($site_id);

    $site_param = '--url='.get_site_url();

    $commandEnable = 'wp theme enable '.$theme_name ;
    $outputEnable = shell_exec($commandEnable);
    echo $outputEnable;

    $command = 'wp theme activate '.$theme_name.'  '.$site_param;
    echo $command.PHP_EOL;
    $output = shell_exec($command);
    echo $output.PHP_EOL;
}


function activateThemeInSites($siteIdThemeName)
{
    foreach ($siteIdThemeName as $siteId => $themeName) {
        activateThemeInSite($site_id, $theme_name);
    }
}
