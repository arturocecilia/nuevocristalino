<?php
/**
 /*Template Name: Template Cookies
 *
 */

get_header(); ?>

	<div id="primary" class="site-content page">
		<div id="content" role="main" class="cookies">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php /*comments_template( '', true );*/ ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php /* get_sidebar();*/ ?>
<?php get_footer(); ?>