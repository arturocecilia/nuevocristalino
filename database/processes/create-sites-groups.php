<?php
require ABSPATH.'/wp-content/plugins/mu-plugins/eloquent.php';
require ABSPATH.'/wp-load.php';

use App\Models\NcSiteGroup;

global $wpdb;


$sites = get_sites();

foreach ($sites as $site) {
    switch_to_blog($site->blog_id);

    $siteLocale = get_blog_option($site->blog_id, 'WPLANG');
    $lang = substr($siteLocale, 0, 2);

    $blogDetails = get_blog_details($site->blog_id);

    $user_id = 3;


    $meta = [];

    switch ($lang) {
      case 'es':
        $qaSlug = 'pregunte-al-cirujano';
        $qaTitle = 'Pregunte al Cirujano';

        $forumSlug = 'foro';
        $forumTitle = 'Foro';

        $promsSlug = 'proms';
        $promsTitle = 'Proms';



      break;

      case 'en':
        $qaSlug = 'ask-the-surgeon';
        $qaTitle = 'Ask the Surgeon';

        $forumSlug = 'forum';
        $forumTitle = 'Forum';

        $promsSlug = 'proms';
        $promsTitle = 'Proms';

      break;

      case 'de':
        $qaSlug = 'german-surgeon';
        $qaTitle = 'German the Surgeon';

        $forumSlug = 'forum';
        $forumTitle = 'Forum';

        $promsSlug = 'proms';
        $promsTitle = 'Proms';

      break;

      case 'fr':
        $qaSlug = 'french-surgeon';
        $qaTitle = 'French the Surgeon';

        $forumSlug = 'forum';
        $forumTitle = 'Forum';

        $promsSlug = 'proms';
        $promsTitle = 'Proms';

      break;

      default:
        // code...
      break;
    }



    $createdQaSite = wpmu_create_blog($blogDetails->domain, '/'.$qaSlug, $qaTitle, $user_id, $meta);
    $createdForumSite = wpmu_create_blog($blogDetails->domain, '/'.$forumSlug, $forumTitle, $user_id, $meta);
    $createdPromsSite = wpmu_create_blog($blogDetails->domain, '/'.$promsSlug, $promsTitle, $user_id, $meta);
    //update_blog_details($createdSite, array( 'path' => $slug));



    $ncsiteGroup = new NcSiteGroup();

    $ncsiteGroup->main_site_id = $site->blog_id;
    $ncsiteGroup->qa_site_id = $createdQaSite;
    $ncsiteGroup->forum_site_id = $createdForumSite;
    $ncsiteGroup->proms_site_id = $createdPromsSite;

    $ncsiteGroup->group_site_key = $siteLocale;//$blogDetails->domain;

    $ncsiteGroup->save();
}


/*

$slugAntiDup = $slug.$siteLocale;

$site_param = '--url='.get_site_url();
$slug = '--slug='.$slug;
$command = 'wp site create '.$slug.' --porcelain '.$site_param;

//Aquí vendrán más operaciones.
$updateDomainQuery = 'UPDATE `wp_blogs` SET `domain`="'.$domain.'" WHERE `blog_id`= '.$createdSite;

    $domain = $blogDetails->domain;
echo $updateDomainQuery.PHP_EOL;

$wpdb->query($updateDomainQuery);


*/
