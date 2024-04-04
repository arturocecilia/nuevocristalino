<?php
/*
YARPP Template: Posts
Author: mitcho (Michael Yoshitaka Erlewine)
Description: A simple example YARPP template.
*/

?>

<?php if(have_posts()){?>


	<div class="leftmenutitlewrapper">
	<span class="priorleftmenutitle">&nbsp;</span>
<h3 id="yarppQuestions" class="yarppTitle"><?php echo _x('Posts Relacionados:','yarpp','iol_theme'); ?></h3>
<span class="afterleftmenutitle">&nbsp;</span>
</div>



<?php if (have_posts()):?>
<ol>
	<?php while (have_posts()) : the_post(); ?>
	<li class="yarppPostsItems yarppItems"><?php the_post_thumbnail(); ?><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a><!-- (<?php the_score(); ?>)--></li>
	<?php endwhile; ?>
</ol>
<?php else: ?>
<p>No related posts.</p>
<?php endif; ?>
<?php }?>
