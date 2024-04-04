<?php
/*
YARPP Template: Forums
Author: mitcho (Michael Yoshitaka Erlewine)
Description: A simple example YARPP template.
*/


	
	
	$relatedTopics = new WP_Query(
									array(
											'post_type' => 'topic',
											'posts_per_page' => 5									
										)
	);
	
	
	if($relatedTopics->have_posts()){?>


<div class="leftmenutitlewrapper">
<span class="priorleftmenutitle">&nbsp;</span>
<h3 id="yarppForum" class="yarppTitle">
	<a href="<?php echo get_bloginfo( 'siteurl' ).'/'._x('foro-de-lentes-intraoculares-presbicia-y-cataratas','foro-slug','iol_theme').'/'; ?>">
		<?php echo _x('Hilos relacionados en el Foro','yarpp','iol_theme'); ?>
		</a></h3>

<span class="afterleftmenutitle">&nbsp;</span>
</div>

<ol>
	<?php foreach($relatedTopics->posts as $topic_post) {?>
		
	<li class="yarppForumItems yarppItems">
		<a href="<?php the_permalink() ?>" rel="bookmark"><?php echo $topic_post->post_title; ?></a>
		<a href="<?php get_the_permalink($topic_post->post_parent); ?>" class="add-info" rel="bookmark"><?php echo get_the_title($topic_post->post_parent); ?></a>
	</li>
<?php } ?>
</ol>



<?php  }?>
