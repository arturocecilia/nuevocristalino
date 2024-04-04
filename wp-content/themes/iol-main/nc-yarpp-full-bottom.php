<?php

?>


<div id="yarppBottomWrapper">
<div id="blockYarpp1">

<?php
//Primero la query del FORUM.
yarpp_related(array(
	'post_type' => array('topic'),
	'show_pass_post' => false, // show password-protected posts
	'past_only' => false, // show only posts which were published before the reference post
	'exclude' => array(), // a list of term_taxonomy_ids. entities with any of these terms will be excluded from consideration.
	'recent' => false, // to limit to entries published recently, set to something like '15 day', '20 week', or '12 month'.
	'weight' => array(
		'body' => 1,
		'title' => 2, // larger weights mean this criteria will be weighted more heavily
		'tax' => array(
			'post_tag' => 1,
		)
	),
	'threshold' => 1,
	'template' => 'yarpp-forums.php', // either the name of a file in your active theme or the boolean false to use the builtin template
	'limit' => 5, // maximum number of results
	'order' => 'score DESC'
),
$post->ID, // second argument: (optional) the post ID. If not included, it will use the current post.
true); // third argument: (optional) true to echo the HTML block; false to return it
?>
    </div>
    <div id="blockYarpp2">
<?php
    //Tercero la de los Posts
yarpp_related(array(
	'post_type' => array('post'),
	'show_pass_post' => false, // show password-protected posts
	'past_only' => false, // show only posts which were published before the reference post
	'exclude' => array(), // a list of term_taxonomy_ids. entities with any of these terms will be excluded from consideration.
	'recent' => false, // to limit to entries published recently, set to something like '15 day', '20 week', or '12 month'.
	'weight' => array(
		'body' => 1,
		'title' => 2, // larger weights mean this criteria will be weighted more heavily
		'tax' => array(
			'post_tag' => 1,
		)
	),
	'threshold' => 1,
	'template' => 'yarpp-posts.php', // either the name of a file in your active theme or the boolean false to use the builtin template
	'limit' => 5, // maximum number of results
	'order' => 'score DESC'
),
$post->ID, // second argument: (optional) the post ID. If not included, it will use the current post.
true); // third argument: (optional) true to echo the HTML block; false to return it

?>
</div>

    <div id="blockYarpp3">
<?php
//Segundo la query del Q&A
yarpp_related(array(
	'post_type' => array('question'),
	'show_pass_post' => false, // show password-protected posts
	'past_only' => false, // show only posts which were published before the reference post
	'exclude' => array(), // a list of term_taxonomy_ids. entities with any of these terms will be excluded from consideration.
	'recent' => false, // to limit to entries published recently, set to something like '15 day', '20 week', or '12 month'.
	'weight' => array(
		'body' => 1,
		'title' => 2, // larger weights mean this criteria will be weighted more heavily
		'tax' => array(
			'post_tag' => 1,
		)
	),
	'threshold' => 1,
	'template' => 'yarpp-questions.php', // either the name of a file in your active theme or the boolean false to use the builtin template
	'limit' => 5, // maximum number of results
	'order' => 'score DESC'
),
$post->ID, // second argument: (optional) the post ID. If not included, it will use the current post.
true); // third argument: (optional) true to echo the HTML block; false to return it
?>
</div>
<div id="blockYarpp4">
<?php
//Tercero la de los contenidos => Página
yarpp_related(array(
	'post_type' => array('page'),
	'show_pass_post' => false, // show password-protected posts
	'past_only' => false, // show only posts which were published before the reference post
	'exclude' => array(), // a list of term_taxonomy_ids. entities with any of these terms will be excluded from consideration.
	'recent' => false, // to limit to entries published recently, set to something like '15 day', '20 week', or '12 month'.
	'weight' => array(
		'body' => 1,
		'title' => 2, // larger weights mean this criteria will be weighted more heavily
		'tax' => array(
			'post_tag' => 1,
		)
	),
	'threshold' => 1,
	'template' => 'yarpp-pages.php', // either the name of a file in your active theme or the boolean false to use the builtin template
	'limit' => 5, // maximum number of results
	'order' => 'score DESC'
),
$post->ID, // second argument: (optional) the post ID. If not included, it will use the current post.
true); // third argument: (optional) true to echo the HTML block; false to return it
?>
</div>
</div>