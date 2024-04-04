<?php
/*
 * Template Name: Template Cirugía Ocular
 * Description: Este es el template para las páginas de cirugía.
 */

get_header(); ?>

	<div id="primary" class="site-content-cirugia-presbicia">





				<!-- Metemos aquí el lateral -->
            <div id="lateral-presbicia">
            <?php
              /* A día de hoy no tenemos vídeos luego se pondrán donde convenga
            <div id="lateral-videos">

                <div id="video">
            	<h3><?php /*echo _x('VIDEOS RELACIONADOS','Template Cirugia Ocular','iol_theme'); ?></h3>
                <img src="<?php bloginfo('template_directory'); ?>/images/content/video.jpg" />
            </div>
            */
            ?>
             <div id="galeria">

                <div id="thums">
            	<!--<img class="imgal" src="<?php //bloginfo('template_directory'); ?>/images/content/thum1.jpg"/>
                <img src="<?php //bloginfo('template_directory'); ?>/images/content/thum2.jpg"/>
                <img class="imgal" src="<?php //bloginfo('template_directory'); ?>/images/content/thum3.jpg"/>
                <img src="<?php //bloginfo('template_directory'); ?>/images/content/thum4.jpg"/> -->
                <?php
                 // Custom widget Area Start
                 if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('galeria1') ) : ?>
                <?php endif;
                // Custom widget Area End
                ?>

                </div>
            </div>

     <?php
        //Añadimos el full Yarpp Side.
        include('nc-yarpp-full-side.php');

     ?>

            </div>




		<div id="content" role="main">


			<!-- Pongo aquí el título y el menú en page.php en vez de en content-cirugia.php para que ocupe el 100%de la página -->
			<div id="titulo-cirugias">
					<header class="entry-header">
						<span class="preSxTitle">&nbsp;</span>
			<h1 class="entry-title"><?php the_title(); ?></h1>
						</header>
				</div>


			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content-cirugia', 'page' ); ?>

           <?php /* if(current_user_can('manage_options')){ */ ?>

               <?php  include('suggested-clinics-page.php'); ?>

           <?php /* } */ ?>



				<?php/* comments_template( '', true );*/ ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->



        </div>


            <!-- Fin Faqs -->

    </div>
        <!-- div auxiliar para detectar template -->
        <div id="templateCirugiaOcular" style="display: none;">&nbsp;</div>
        <!-- Fin del lateral -->
	</div><!-- #primary -->



<?php //get_sidebar(); ?>
<?php get_footer(); ?>
