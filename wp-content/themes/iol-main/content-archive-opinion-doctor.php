<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
			<?php if ( is_single() ) : ?>
			<!-- <h1 class="entry-title"><?php the_title(); ?></h1> -->
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php endif; // is_single() ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
            <div class="postThumbnail">    <?php the_post_thumbnail(); ?>         </div>
			<?php /*the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) );*/ ?>
            <?php the_excerpt(); ?>
            <?php /*wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) );*/ ?>
		</div><!-- .entry-content -->
        
        <!-- Ahora el bloque con los links -->
        <div class="doctor-opinion-info">
            <?php 
                  $clinica1D    = get_post_meta( get_the_ID(), 'clinica1D', TRUE ); 
                  $clinica2D    = get_post_meta( get_the_ID(), 'clinica2D', TRUE );
                  $ciudad1D     = get_post_meta( get_the_ID(), 'ciudad1D', TRUE ); 
                  $ciudad2D     = get_post_meta( get_the_ID(), 'ciudad2D', TRUE );
                  $webClinica1D = get_post_meta( get_the_ID(), 'webClinica1D',  TRUE ); 
                  $webClinica2D = get_post_meta( get_the_ID(), 'webClinica2D', TRUE );
          
            echo '<div class="clinic1">';
            if(! empty($clinica1D)){
                    echo '<span class="clinica1"><a href="'.$webClinica1D.'">'.$clinica1D.'</a></span>';
            }  
            if(! empty($ciudad1D)){
                    echo '<span class="ciudad1">'.$ciudad1D.'</span>';
            }
            echo '</div>';
            echo '<div class="clinic2">';
            if(! empty($clinica2D)){
                    echo '<span class="clinica2"><a href="'.$webClinica2D.'">'.$clinica2D.'</a></span>';
            }
            if(! empty($ciudad2D)){
                    echo '<span class="clinica1">'.$ciudad2D.'</span>';
            }
            echo '</div>';
            
            
            ?>

        </div>
         <!-- Fin del bloque de links -->
		<footer class="entry-meta">

			
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
