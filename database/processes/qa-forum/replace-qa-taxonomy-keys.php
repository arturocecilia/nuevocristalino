<?php


require ABSPATH.'wp-load.php';


//dw taxonomies
//dwqa-question_category
//dwqa-question_tag

//wpmudev taxonomies
//question_category
//question_tag

if (!function_exists('replaceTaxonomyKeysInSites')) {
    include(ABSPATH.'database/processes/replace-taxonomy-keys.php');
}



$sites = get_sites();
$taxonomy_keys_to_replace = array(
                        'question_category' => 'dwqa-question_category',
                        'question_tag' => 'dwqa-question_tag'
                        );

replaceTaxonomyKeysInSites($sites, $taxonomy_keys_to_replace);
