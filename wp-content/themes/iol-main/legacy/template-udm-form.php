<?php
/*
 * Template Name: Template User Data Manger Form
 * Description: Este es el template para las páginas que no tienen menús
 */

get_header(); ?>

	<div id="primary" class="primary-udm udm-content"> <!-- primary-quienes lo dejamos en primary-->
        <div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->



	</div><!-- #primary -->
	
	
		<!-- ini Right -->
		<div id="right" class="right-udm">
			

			<!-- Ini Temporal right-->
			 	<div id="bloq-post-right1">
        <h3><?php echo _x('VER ESTADÍSTICAS DE RESULTADOS:','Template PostOp Test','iol_theme'); ?></h3>
        <a href="<?php echo get_permalink( 2881 ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/comun/post-results-<?php echo get_locale(); ?>.png" alt="<?php echo _x('Estadísticas de los resultados del test post-operatorio','alt template post op','iol_theme'); ?>" /></a>
    </div>
    
    <div id="bloq-post-right2">
    	<h3><?php echo _x('CONTACTE CON NOSOTROS:','Template PostOp Test','iol_theme'); ?></h3>
        <div id="contact-post">
        <?php if (function_exists('serveCustomContactForm')) { serveCustomContactForm(5); } ?>
        </div>
    </div>
    <div id="bloq-post-right3">
    	<a href="<?php echo get_permalink(227); ?>"><img src= "<?php echo get_stylesheet_directory_uri(); ?>/images/comun/test_iol-<?php echo get_locale(); ?>.jpg" alt="<?php echo _x('Realice el test para averiguar qué lente intraocular es más adecuada para usted.','alt template post op','iol_theme'); ?>" /></a>
        <a href="<?php echo get_bloginfo('url')._x('preguntas-de-lentes-intraoculares-presbicia-y-cataratas','qa-slug','iol_theme'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/comun/ad-qa-<?php echo get_locale(); ?>.jpg" alt="<?php echo _x('Pregunte sus dudas al cirujano refractivo','alt template post op','iol_theme'); ?>" /></a>
    </div>
			<!-- Fin temporal right-->






			
		</div>
  <!-- Fin Right -->

<?php get_footer(); ?>