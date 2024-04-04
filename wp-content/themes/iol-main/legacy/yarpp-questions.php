<?php
/*
YARPP Template: Questions
Author: mitcho (Michael Yoshitaka Erlewine)
Description: A simple example YARPP template.
*/

?>

<?php if(have_posts()){?>


	<div class="leftmenutitlewrapper">
	<span class="priorleftmenutitle">&nbsp;</span>
<h3 id="yarppQuestions" class="yarppTitle">
<a href="<?php echo get_bloginfo( 'siteurl' ).'/'._x('preguntas-de-lentes-intraoculares-presbicia-y-cataratas','qa-slug','iol_theme').'/'; ?>"><span class="textTitle"><?php echo _x('Preguntas hechas al Oftalmólogo:','yarpp','iol_theme'); ?></span>
</a>
</h3>
<span class="afterleftmenutitle">&nbsp;</span>
</div>


<?php if (have_posts()):?>
<ol>
	<?php while (have_posts()) : the_post(); ?>
		<?php $question_post = get_post();
					$question_user = get_userdata($question_post->post_author);
		?>
	<li class="yarppQuestionsItems yarppItems">
		<a href="<?php get_the_permalink($topic_post->post_parent); ?>" rel="bookmark"><?php  echo get_the_title($question_post->post_parent);  ?></a>
	<span class="add-info"><?php echo $question_user->user_login; ?></span>
	</li>

	<?php endwhile; ?>
</ol>
<?php else: ?>
<p>No related posts.</p>
<?php endif; ?>

<?php }?>
