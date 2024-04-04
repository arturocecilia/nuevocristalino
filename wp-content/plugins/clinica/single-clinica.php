<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>



     <?php /* include('left-clinica.php'); No hay left en el single post type clínica.*/ ?>


   <div id="primary" class= "site-content-single single-clinica" itemscope itemtype="http://schema.org/Organization">
		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
             
				<?php  include('content-clinica.php'); ?>
				
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary2  -->

    <?php include('right-single-clinica.php'); ?>
   <?php 
   //Vamos a poner un div que nos sirva de referencia para la url. --> No hace falta, estará ya en el action del form.
   /*echo '<div id="archiveClinicaUrl">';
   echo   
   echo '</div>';
   */
   ?>

<?php get_footer('clinica'); ?>
