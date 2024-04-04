<?php
/*
 * Template Name: Template Content Only
 * Description: Este es el template para las páginas de mis ojos.
*/

get_header(); ?>

 
    <div id="primary" class="site-content-page-template-ContentOnly">
    
 		<!-- Content de Inicio -->
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php echo the_title(); ?>
				
			<?php endwhile; // end of the loop. ?>
                       
            
		</div><!-- #content -->
	</div><!-- #primary -->


	<!-- Ahora el right -->
	    <div id="right" class="filter-right">
            
		<div id="changeFilter">
				<button id="advLoader" type="radio" data-action="getAdvForm"><?php echo _x('Menú Avanzado','modelos de iol template','iol_theme'); ?></button>
    			<button id="patientLoader"type="radio" data-action= "getPatientForm"><?php echo _x('Menú Sencillo','modelos de iol template','iol_theme'); ?></button>
		</div>
		
	        <?php 	include('iolPluginTemplates/right-archive-lente-intraocular.php'); ?>
	    </div>              
	
	<!-- Fin del right -->


<?php get_footer(); ?>