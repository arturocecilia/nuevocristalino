<?php
/*
 * Template Name: Template Explicacion Basica Pacientes
 * Description: Este es el template para las páginas de cirugía. Tipos de Lente Intraocular
 */

get_header(); ?>

    <div id="left-explicacion-lio" class="menu-left submenu-pages">
        <div id="left-exp-wrapper">


          <div class="leftmenutitlewrapper">
          <span class="priorleftmenutitle">&nbsp;</span>
      <h2><?php echo _x('EXPLICACIONES SOBRE:','Template Explicacion Basica Pacientes','iol_theme'); ?></h2>
          <span class="afterleftmenutitle">&nbsp;</span>
        </div>







        <?php  wp_nav_menu(array('theme_location'=>'menu-explicacion-tipos-lio')); ?>
       </div>
    </div>

    <div id="primary" class="site-content-tipos-de-lentes">
    	<!-- Pongo aquí el título y el menú en page.php en vez de en content-cirugia.php para que ocupe el 100%de la página -->
   <!--  	<div id="titulo">
            <header class="entry-header">
			<h1 class="entry-title">
				<?php the_title(); ?>
			</h1>
            </header>
        </div>
    -->
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; // end of the loop. ?>



   <?php
   //Creamos un div auxiliar que nos permita identificar el template  a diferencia del archive.
   echo '<div id ="tipoIolTemplate" style="display:none;">&nbsp;</div>';
   ?>


		</div><!-- #content -->

        <!-- Fin del lateral -->
	</div><!-- #primary -->
    <div id="right" class="filter-right patient-filter page-patient template-explicacion-basica-pacientes">
    <?php /*include('iolPluginTemplates/OLD-patient-form.php');*/ ?>
    <?php    include(ABSPATH . 'wp-content/plugins/lente-intraocular/archive-patient-form.php'); ?>

    <?php
        //Añadimos el full Yarpp Side.
        include('nc-yarpp-full-side.php');

    ?>

    <div id="imagenesTiposIol">
        <!--<p>Imágenes añadidas</p> -->
    </div>

    </div>



<?php //get_sidebar(); ?>
<?php get_footer(); ?>
