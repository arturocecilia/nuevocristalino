<?php
/*
 * Template Name: Template User Profile
 * Description: Este es el template para la página de edición del perfil del usuario. Vemos que no tiene nada especial.
*/
get_header(); ?>

	<div id="primary" class="site-content-register">
		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>

				<?php /*comments_template( '', true );*/ ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->
    

    <div id="community" class="rightProfile">
    	<div id="blog" class="comm-block">
            <?php  //get_bloginfo( 'siteurl' ).'/'._x('blog-de-lentes-intraoculares-presbicia-y-cataratas','blog-slug','site')// 31 ?>
        	<a href="<?php echo get_permalink(31); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/comun/anuncio_blog.jpg" alt="Lentes Lio como solución a la presbicia." /></a>
        </div>
        <div id="ask-oft" class="comm-block">
        	<a href="<?php echo get_bloginfo( 'siteurl' ).'/'._x('preguntas-de-lentes-intraoculares-presbicia-y-cataratas','qa-slug','iol_theme').'/';  ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/comun/anuncio_qa.jpg" alt="Lentes Lio como solución a la presbicia." /></a>
        </div>
        <!--<div id="foro-com" class="comm-block">
        </div> -->
    </div>


<?php get_footer(); ?>