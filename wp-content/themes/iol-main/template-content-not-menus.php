<?php
/*
 * Template Name: Template Content Not Menus
 * Description: Este es el template para las páginas que no tienen menús
 */

get_header(); ?>

	<div id="primary" class="site-content-not-menus"> <!-- primary-quienes lo dejamos en primary-->
        <div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php /*comments_template( '', true );*/ ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->

    <?php
        //Añadimos el full Yarpp Bottom.
        include('nc-yarpp-full-bottom.php');

    ?>

	</div><!-- #primary -->

<?php get_footer(); ?>