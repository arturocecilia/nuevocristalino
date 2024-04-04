<?php get_header();//'qa' ?>

<div id="primary" class="site-content-qa">
<!-- Fin abrimos primary -->


<div class="title-qa-wrapper"><h1>Pregunta a los cirujanos</h1></div>



<div id="menu-foro">
      <?php  wp_nav_menu(array('theme_location'=>'Menu-cat-QA')); ?>
</div>

	<?php 
			//Mensaje para informar de que no se aceptan preguntas por el momneto.
			
			if(get_locale() == 'es_ES'){
				echo '<div>Sentimos comunicar que debido a que estamos trabajando en la actualización de la plataforma no podemos gestionar la contestación de las preguntas. </div>';
			}
		
		
	?>
		<?php if ( have_posts() ) : ?>

			<?php the_content(); ?>

		<?php endif;?>


			<!-- Aquí estaba el jaleo-->

<?php
//global $qa_general_settings;

//if ( isset( $qa_general_settings["page_layout"] ) && $qa_general_settings["page_layout"] !='content' )
	//get_sidebar( 'question' );
?>

</div>

<?php wp_reset_postdata(); ?>

<?php get_footer(); //'qa' ?>
