<?php
/*
Template Name: Template	 QA
*/
?>

<?php
get_header();
?>

	<div id="primary" class="site-content-help helpTemplate">
		<div id="content" role="main">
            <div class="helpWrapper">
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part('content', 'page'); ?>
			<?php endwhile; // end of the loop.?>
            </div>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php  get_sidebar(); ?>
<?php get_footer(); ?>
