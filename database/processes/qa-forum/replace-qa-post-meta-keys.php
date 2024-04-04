<?php


require ABSPATH.'/wp-load.php';



//dw qa metas
//_dwqa_status
//_dwqa_views
//_dwqa_votes
//_dwqa_answers_count
//_dwqa_followers
//_dwqa_answered_time

//wpmudev metas
//_answer_count
//_up_vote
//_down_vote
//_accepted_answer


if (!function_exists('replacePostMetaKeysInSites')) {
    include(ABSPATH.'database/processes/replace-post-meta-keys.php');
}



$sites = get_sites();
$meta_keys_to_replace = array(
                        '_answer_count' => '_dwqa_answers_count'
                        );

replacePostMetaKeysInSites($sites, $meta_keys_to_replace);
