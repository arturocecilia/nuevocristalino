<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Twelve already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>


	<section id="primary" class="site-content archive-opiniones">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title">
                   <?php echo _x('Comentarios de Doctores sobre Cataratas, Presbicia y Lentes Intraoculares','Archive Opinion Doctor','miscelaneous_cpt_display'); ?>
                </h1>
			</header><!-- .archive-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part( 'content-archive-opinion-doctor', get_post_format() );

			endwhile;

			twentytwelve_content_nav( 'nav-below' );
            ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	


    </section><!-- #primary -->

    <!-- Ponemos links a los otros doctores -->
        <div id="left-opiniones">
        <!-- Aquí vamos a poner una ristra con todos los links -->
        <div class="titleOpiniones">
               <?php echo _x('Listado de especialistas en Cataratas y Presbicia','Archive Opinion Doctor','miscelaneous_cpt_display'); ?>
        </div>
        <ul>
        <?php /* Ponemos el contenido para dado un fabricante sacar sus lentes */
            $args = array(
	                      'post_type' => _x('opinion-doctor','CustomPostType Name','opinion-doctor')
             );
			$the_doctors = new WP_Query( $args );

			// The Loop
			while ( $the_doctors->have_posts() ) : $the_doctors->the_post();
					echo '<li><a href="'.get_permalink().'">';
                    echo get_the_title();
                    echo '</a>';
                    
                    $clinica1D    = get_post_meta( get_the_ID(), 'clinica1D', TRUE ); 
                    $clinica2D    = get_post_meta( get_the_ID(), 'clinica2D', TRUE );
                    
                    echo '<span class="listDoctorClinics">'.$clinica1D.'</span><span class="listDoctorClinics">'.$clinica2D.'</span>';
                
                    echo '</li><br />';
			endwhile; 
        ?> 
        </ul>  
                    
        </div>


<?php /*get_sidebar();*/ ?>
<?php get_footer(); ?>