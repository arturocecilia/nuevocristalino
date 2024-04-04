<?php
/*
 * Template Name: Template Cataratas
 * Description: Este es el template para las páginas de cirugía de presbicia.
 */

get_header(); ?>

	<div id="primary" class="site-content-cirugia-presbicia template-cataratas">




        <!-- Aquí va el nuevo left -->

        <!-- Metemos aquí el lateral -->
        <div id="lateral-presbicia"  >

            <div id="submenu-lateral-presbicia" class="submenu-pages">

							<div class="leftmenutitlewrapper">
							<span class="priorleftmenutitle">&nbsp;</span>
        <h3><?php echo _x('CIRUGÍA DE CATARATAS','Template Cataratas','iol_theme'); ?></h3>
				<span class="afterleftmenutitle">&nbsp;</span>
	    </div>

				<div id="menu-cirugia-submenu">
        	<?php  wp_nav_menu(array('theme_location'=>'Menu-cataratas')); ?>
        </div>



                <?php
                 // Custom widget Area Start
                 if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('galeria1') ) : ?>
                <?php endif;

                // Custom widget Area End
                ?>


        </div>

              <!-- Metemos el widget con las faqs -->
             <?php
                    $permFaqCataract = get_permalink( 329 );
                ?>

             <div id="leftFaqsPresbicia" class="submenu-pages">
                   <?php  /*dynamic_sidebar( 'widget3-faqs-presbicia' );*/ ?>
                  <!-- Mejor lo hacemos sin widget por razones de localización -->

									<div class="leftmenutitlewrapper">
									<span class="priorleftmenutitle">&nbsp;</span>
								 <h3 class="title-faqs"><?php echo _x('Preguntas Frecuentes sobre Operación de Cataratas','Template Cirugia Ocular','iol_theme');?></h3>
								 <span class="afterleftmenutitle">&nbsp;</span>
				 	    </div>

										<ul>
                          <li><a data-hashidselector="#cat-meaning" href="<?php echo $permFaqCataract;?>"><?php echo  _x('¿Qué es exactamente catarata?','Template Cirugia Ocular','iol_theme');?></a></li>
                        <li><a data-hashidselector="#cat-aparec" href="<?php echo $permFaqCataract; ?>"><?php echo  _x('¿Cuándo aparece catarata?','Template Cirugia Ocular','iol_theme');?></a></li>
                        <li><a data-hashidselector="#cat-tto" href="<?php echo $permFaqCataract; ?>#"><?php echo  _x('¿Cómo es le tratamiento de catarata?','Template Cirugia Ocular','iol_theme');?></a></li>
                        <li><a data-hashidselector="#cat-necesx" href="<?php echo $permFaqCataract; ?>"><?php echo  _x('¿Cuando es necesaria la cirugía de catarata?','Template Cirugia Ocular','iol_theme');?></a></li>
                        <li><a data-hashidselector="#cat-comosx" href="<?php echo $permFaqCataract; ?>"><?php echo  _x('¿Cómo se hace una cirugía de catarata?','Template Cirugia Ocular','iol_theme');?></a></li>
                        <li><a data-hashidselector="#cat-dangersx" href="<?php echo $permFaqCataract; ?>"><?php echo  _x('¿Cómo de peligroso es una cirugía de catarata?','Template Cirugia Ocular','iol_theme');?></a></li>
                        <li><a data-hashidselector="#cat-gafasx" href="<?php echo $permFaqCataract; ?>"><?php echo  _x('¿Tengo que llevar las gafas después de la cirugía de catarata?','Template Cirugia Ocular','iol_theme');?></a></li>
                        <li><a data-hashidselector="#cat-premlio" href="<?php echo $permFaqCataract; ?>"><?php echo  _x('¿Como se puede conseguir las lentes premium con las funciones adicionales y cuanto las cuestan?','Template Cirugia Ocular','iol_theme');?></a></li>

                    </ul>

                </div>

								<?php
					         //Añadimos el full Yarpp Side.
					         include('nc-yarpp-full-side.php');

					      ?>

        </div>

<!-- <div id="leftWrapper">


</div>
-->


        <!-- Aquí acaba el nuevo left -->



		<div id="content" role="main">

			<!-- Pongo aquí el título y el menú en page.php en vez de en content-cirugia.php para que ocupe el 100%de la página -->
    	<div id="titulo-cirugias">
        	<header class="entry-header">
						<span class="preSxTitle">&nbsp;</span>
			<h1 class="entry-title">
				<?php the_title(); ?>
			</h1>
			</header>
        </div>


			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content-cirugia', 'page' ); ?>

           <?php /* if(current_user_can('manage_options')){ */ ?>

               <?php  include('suggested-clinics-page.php'); ?>

           <?php /* } */ ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->

        <!-- Aquí iba el old left -->

        <!-- Fin de donde iba el old left -->



            <!-- div auxiliar para localizar -->
        <div id="templatePresbicia" style="display: none;">&nbsp;</div>
    </div>
    <!-- Fin del lateral -->
	<!--</div> #primary  tras validación -->

<?php
	 if(get_locale() == 'de_DE'){
//	  echo '<div class="ebookpodcastvertical">';
	  	include('ebook-podcast.php');
//	  echo '</div>';
	  }
	  ?>    

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
