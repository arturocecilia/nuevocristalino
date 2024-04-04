<?php

require '../wp-content/plugins/mu-plugins/eloquent.php';

use \Illuminate\Database\Capsule\Manager as Capsule;
use \WPEloquent\Model\Post;
use App\Models\NcSiteGroup;

//require '../../wp-load.php';

/*
$posts = new WP_Query(array('post_type' => 'page'));

foreach ($posts->get_posts() as $post) {
    echo $post->ID.PHP_EOL;
}
*/
include('processes/deactivate-all-plugins.php');
/*

echo '1';
$ncsiteGroup = new NcSiteGroup();
echo '2';
$ncsiteGroup->main_site_id = 1;//$site->blog_id;
$ncsiteGroup->qa_site_id = 10;//$createdSite;
echo '3';
$ncsiteGroup->save();
*/

/*
$posts = Post::all();


$posts = Capsule::table('2_posts')->get();

$query = 'DELETE a,b,c
          FROM wp_posts a
          LEFT JOIN wp_term_relationships b
            ON (a.ID = b.object_id)
          LEFT JOIN wp_postmeta c
            ON (a.ID = c.post_id)
          WHERE a.post_type = "wpdmpro"';//opinion-doctor

Capsule::statement($query);*/
