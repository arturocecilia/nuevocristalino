<?php
/*
 * Template Name: Template Archive Fabricante
 * Description: Este es el template para las p‡ginas de mis ojos.
*/

get_header(); ?>

	<section id="primary" class="site-content-fabri-archi">
		<div id="content" role="main">
       		<?php while ( have_posts() ) : the_post(); ?>
            <header class="archive-header">
            	<h1>the_title()</h1>
            </header><!-- .archive-header -->
            <div id="content-fabri">

       		
       		
       		
				<?php the_content(); ?>
		
			<?php endwhile; // end of the loop. ?>
            </div>

		<?php //if ( have_posts() ) : ?>
        

			<?php
			/* Start the Loop */
			//while ( have_posts() ) : the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				//get_template_part( 'content', get_post_format() );

			//endwhile;

			//twentytwelve_content_nav( 'nav-below' );
			?>

		<?php //else : ?>
			<?php //get_template_part( 'content', 'none' ); ?>
		<?php //endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->
    <div id="subfabri">
    	<?php
                 // Custom widget Area Start
                 if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('submenu-fabricantes') ) : ?>
                <?php endif;
                // Custom widget Area End
                ?>
    </div>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>