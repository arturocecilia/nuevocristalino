<?php
/*
 * Template Name: Template Preguntas Frecuentes
 * Description: Este es el template para las páginas de fqs o preguntas frecuentes.
 */

get_header(); ?>

	<div id="primary" class="site-content-page-template">
    	
    
		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php /* comments_template( '', true ); */ ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->
    
    <div id="subfaqs"class="submenu-pages">
    		<h2><?php echo _x('PREGUNTAS FRECUENTES','Template Preguntas Frecuentes','iol_theme'); ?></h2>
        	<?php  wp_nav_menu(array('theme_location'=>'menu-faqs')); ?>
    </div>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>