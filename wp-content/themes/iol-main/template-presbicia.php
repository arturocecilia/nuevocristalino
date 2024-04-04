<?php
/*
 * Template Name: Template Presbicia
 * Description: Este es el template para las páginas de cirugía de presbicia.
 */

get_header(); ?>



	<div id="primary" class="site-content-cirugia-presbicia">




  <!-- Inicio Nuevo Left -->

          <!-- Metemos aquí el lateral -->
        <div id="lateral-presbicia">
            <div id="submenu-lateral-presbicia" class="submenu-pages">
							<div class="leftmenutitlewrapper">
							<span class="priorleftmenutitle">&nbsp;</span>
        <h3><?php echo _x('CIRUGÍA DE PRESBICIA','Template Presbicia','iol_theme'); ?></h3>
				<span class="afterleftmenutitle">&nbsp;</span>
	    </div>

				<div id="menu-cirugia-submenu">
        	<?php  wp_nav_menu(array('theme_location'=>'Menu-presbicia')); ?>


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
                    $permFaqPresb = get_permalink( 331 );
                ?>

             <div id="leftFaqsPresbicia" class="submenu-pages">

							 <div class="leftmenutitlewrapper">
							 <span class="priorleftmenutitle">&nbsp;</span>
                        <h3 class="title-faqs"><?php echo _x('Preguntas Frecuentes sobre Presbicia','Template Presbicia','iol_theme');?></h3>
												<span class="afterleftmenutitle">&nbsp;</span>
			 				 	    </div>

						        <ul>
                        <li><a data-hashidselector="#presb-meaning" href="<?php echo $permFaqPresb;?>"><?php echo  _x('¿Que significa presbicia?','Template Presbicia','iol_theme');?></a></li>
                        <li><a data-hashidselector="#presb-tto" href="<?php echo $permFaqPresb; ?>"><?php echo  _x('¿Como es el tratamiento de la presbicia?','Template Presbicia','iol_theme');?></a></li>
                        <!-- <li><a data-hashidselector="#presb-exact-meaning" href="<?php /*echo $permFaqPresb;*/ ?>#"><?php /* echo  _x('¿Que significa exactamente Presbicia?','Template Presbicia','iol_theme');*/ ?></a></li> -->
                        <li><a data-hashidselector="#presb-symptoms" href="<?php echo $permFaqPresb; ?>"><?php echo  _x('¿Como puedo reconocer los síntomas de presbicia?','Template Presbicia','iol_theme');?></a></li>
                        <li><a data-hashidselector="#presb-pte-affect" href="<?php echo $permFaqPresb; ?>"><?php echo  _x('¿A quien afecta presbicia?','Template Presbicia','iol_theme');?></a></li>
                        <li><a data-hashidselector="#presb-tip-tto" href="<?php echo $permFaqPresb; ?>"><?php echo  _x('¿Que tipo de tratamiento es necesario? ¿Necesito gafas ó lentes de contacto especiales?','Template Presbicia','iol_theme');?></a></li>
                        <!-- <li><a data-hashidselector="#presb-perm-tto" href="<?php /*echo $permFaqPresb;*/ ?>"><?php/* echo  _x('¿Existe un tratamiento permanente de presbicia?','Template Presbicia','iol_theme'); */ ?></a></li> -->
                        <li><a data-hashidselector="#presb-correc" href="<?php echo $permFaqPresb; ?>"><?php echo  _x('¿Hay otros modos de la corrección de presbicia?','Template Presbicia','iol_theme');?></a></li>
                    </ul>

                </div>

    <?php
        //Añadimos el full Yarpp Side.
        include('nc-yarpp-full-side.php');

     ?>

        </div>

  <!-- Fin Nuevo left -->






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

<!-- Inicio Old Left -->

<!-- Fin old left -->



    <!-- div auxiliar para localizar -->
        <div id="templatePresbicia" style="display: none;">&nbsp;</div>
    </div>
    <!-- Fin del lateral -->

<?php
	 if(get_locale() == 'de_DE'){
//	  echo '<div class="ebookpodcastvertical">';
	  	include('ebook-podcast.php');
//	  echo '</div>';
	  }
	  ?>    


	</div><!-- #primary -->




<?php //get_sidebar(); ?>
<?php get_footer(); ?>
