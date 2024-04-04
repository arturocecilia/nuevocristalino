<?php
/*
 * Description: Este es el template para las páginas que no tienen menús
 */

get_header(); ?>


		<!-- IniLeft -->
        <div id="left-single-opinion-doctor">
        <!-- Ini Left -->
             <div class="postThumbnailDoctorSingle">    <?php the_post_thumbnail(); ?>         </div>

            <!-- Ahora el bloque con los links -->
        <div class="single-doctor-opinion-info">
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
		<!-- Fin Left -->
        </div>
		<!-- Fin Left -->



	<div id="primary" class="site-content-not-menus single-opinion-doctor"> <!-- primary-quienes lo dejamos en primary-->
        <div id="single-opinion-doctor">
        
        
        <div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content-opinion-doctor', 'page' ); ?>
				<?php /*comments_template( '', true );*/ ?>

             <!-- Queremos meter un H2 para el SEO con el nombre del Doctor -->
             
            <h2 class="sDr"><?php the_title(); ?></h2>
                
		</div><!-- #content -->
            </div>
	</div><!-- #primary -->


		<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>