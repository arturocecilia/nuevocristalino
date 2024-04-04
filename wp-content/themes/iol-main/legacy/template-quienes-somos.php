<?php
/*
 * Template Name: Template Quienes Somos
 * Description: Este es el template para las páginas de cirugía de presbicia.
 */

get_header(); ?>

	<div id="primary" class="site-content lista-quienes-somos"> <!-- primary-quienes lo dejamos en primary-->
		<div id="content-quienes" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php /* comments_template( '', true ); */ ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
        <div id="contacto">
        	<h2><?php echo _x('CONTACTE CON NUEVO CRISTALINO', 'Template Quienes Somos','iol_theme'); ?></h2>
            <div id="contact-info">
            	<h3><?php echo _x('NUEVO CRISTALINO EUROPA:', 'Template Quienes Somos','iol_theme'); ?></h3>
                <p class="descripcion">Andomed SL</p>
                <p class="dire">C/Doctor Molines 12, 4-2 </p>
                <p class="dire">AD 500 Andorra la Vella </p>
                <p class="dire"><!-- Tel.: +34 686 92 35 43--></p>
                <p class="dire"><!-- Fax: +34 91 388 19 42 --></p>
                <p class="dire"><?php echo _x('info@nuevocristalino.com','Template Quienes Somos','iol_theme'); ?></p>
     <p class="dire">
     <?php /* echo _x('publicidad@nuevocristalino.com','Template Quienes Somos','iol_theme');*/ ?>
     </p>
                
                <div id="follow">
                	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/content/simbol-facebook.png" />
                    <p><?php echo _x('Síguenos en twitter','Template Quienes Somos','iol_theme'); ?></p>
                    <div style="clear:both;">&nbsp;</div>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/content/simbol-twitter.png" />
                    <p><?php echo _x('Síguenos en facebook','Template Quienes Somos','iol_theme'); ?></p>
                    <div style="clear:both;">&nbsp;</div>
                </div>
                
               
            </div>
                        <?php if($rgpe = false) { ?>
            <div id="contact-form">
	            
            <?php    
            switch (get_locale()) {
					case 'es_ES':
							$idFormQuienes = 11190;
						break;
				    case 'es_CL':
							$idFormQuienes = 11729;
						break;
				    case 'es_MX':
							$idFormQuienes = 11408;
						break;
				    case 'es_CO':
							$idFormQuienes = 11801;
						break;
				    case 'en_GB':
							$idFormQuienes = 11583;
						break;
				    case 'en_US':
							$idFormQuienes = 11479;
						break;
				    case 'de_DE':
							$idFormQuienes = 11527;
						break;									
				    case 'de_AT':
							$idFormQuienes = 11682;
						break;
				    case 'fr_FR':
							$idFormQuienes = 11637;
						break;
					default:
							$idFormQuienes = 11190;					
				} 
			
			
			 if ( function_exists( 'ccf_output_form' ) ) {
	        	
						ccf_output_form( $idFormQuienes );
						}
			?>
            
            
            
            </div>
                <?php } ?>
        </div>
	</div><!-- #primary -->

<?php get_footer(); ?>