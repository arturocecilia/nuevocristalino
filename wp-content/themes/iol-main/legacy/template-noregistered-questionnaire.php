<?php
/*
 * Template Name: Template NoRegistered Questionnaire
 * Description: Este es el template para las páginas que no tienen menús
 */


//Esta página puede ser accedida desde fuera o desde dentro si es desde fuera habrá un GET si es desde dentro no lo habrá.



	get_header();
?>

<div class="submenu-pages simple-patient-form-data" style="clear:left;">
	<div>
<ul>
<li></li>
</ul>
</div>
</div>

	<div id="primary" class="site-content-page-template patient-form-data simple-patient-form-data"> <!-- primary-quienes lo dejamos en primary-->
        <div id="content" role="main">


			<?php while ( have_posts() ) : the_post(); ?>


				<?php get_template_part( 'content', 'page' ); ?>


				<?php /*comments_template( '', true );*/ ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->


	</div><!-- #primary -->

<?php get_footer(); ?>
