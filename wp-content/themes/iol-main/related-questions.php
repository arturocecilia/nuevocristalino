<?php
/*
YARPP Template: Questions
Author: mitcho (Michael Yoshitaka Erlewine)
Description: A simple example YARPP template.
*/

	$relatedQuestions = new WP_Query(
									array(
											'post_type' => 'dwqa-question',
											'posts_per_page' => 5									
										)
	);
	

	
	if($relatedQuestions->have_posts()){?>


	<div class="leftmenutitlewrapper">
	<span class="priorleftmenutitle">&nbsp;</span>
<h3 id="yarppQuestions" class="yarppTitle">
<a href="<?php echo get_bloginfo( 'siteurl' ).'/'._x('preguntas-de-lentes-intraoculares-presbicia-y-cataratas','qa-slug','iol_theme').'/'; ?>"><span class="textTitle"><?php echo _x('Preguntas hechas al Oftalmólogo:','yarpp','iol_theme'); ?></span>
</a>
</h3>
<span class="afterleftmenutitle">&nbsp;</span>
</div>



<ol>
	<?php foreach($relatedQuestions->posts as $question_post) {?>
		<?php 
					$question_user = get_userdata($question_post->post_author);
		?>
	<li class="yarppQuestionsItems yarppItems">
		<a href="<?php get_the_permalink($question_post->post_parent); ?>" rel="bookmark"><?php  echo get_the_title($question_post->post_parent);  ?></a>
	<span class="add-info"><?php echo $question_user->user_login; ?></span>
	</li>

	<?php } ?>
</ol>


<?php }?>
