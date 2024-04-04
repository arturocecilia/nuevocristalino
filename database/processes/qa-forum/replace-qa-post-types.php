<?php

//wp eval-file qa-process.php

require ABSPATH.'wp-load.php';


//dw cpts
//dwqa-question
//dwqa-answer

//wpmudev cpts
//answer
//question

if (!function_exists('replaceCptsInSites')) {
    include(ABSPATH.'database/processes/replace-post-types.php');
}




$sites = get_sites();
$posttype_to_replace = array(
                        'answer' => 'dwqa-answer',
                        'question' => 'dwqa-question'
                        );

 replaceCptsInSites($sites, $posttype_to_replace);
