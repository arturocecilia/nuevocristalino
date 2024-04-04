<?php
/*
 * Template Name: Template Lentes Intraoculares
 * Description: Este es el template para las p‡ginas de tipos de lentes.
 */

get_header(); ?>


   <?php
    //if(current_user_can('manage_options')){
        echo '<div id="changeModeBloqTipoWrapper">';
        echo '<div id="changeModeBloq" class="tipoIol"><div class="contenidoMode">&nbsp;</div></div>';

        echo '&nbsp;</div>';
    //}

    ?>


    <div class="submenu-pages" style="clear:left;">

      <div class="leftmenutitlewrapper">
      <span class="priorleftmenutitle">&nbsp;</span>
    	<h2><?php echo _x('TIPOS DE IOL', 'Template Tipos Lente Intraocular', 'iol_theme'); ?></h2>
      <span class="afterleftmenutitle">&nbsp;</span>
    </div>
        	<?php  wp_nav_menu(array('theme_location'=>'menu-tipos-lentes')); ?>

    </div>



	<div id="primary" class="site-content-page-template tipos-lente-intraocular">


		<div id="content" role="main">
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part('content', 'page'); ?>
                <?php //A–adimos un link que nos lleve a la p‡gina de archive lentes intraoculares con la taxonom’a correspondiente.


                ?>
				<?php /* comments_template( '', true );*/ ?>

                    <!-- Link para edición -->
                <?php edit_post_link('edit', '<p>', '</p>'); ?>
			<?php endwhile; // end of the loop.?>

		<?php
        //Añadimos el callToQuestion
        //if(current_user_can('manage_options')){
            echo '<div id="callToQuestion"><div class="callToQuestionContenido">&nbsp;</div></div>';
        //}

        ?>


	<style>


#question-form > label img{
	display: inline;
	margin-top: 0px;
}

		/*-- Añadimos el stilo de los formularios insertados en páginas qa--*/
div.qatemplatebottom{
	margin-bottom: 50px;
}

div.qatemplatebottom #question-taxonomies{
	margin-top: 15px;
	margin-bottom: 15px;
	display: none;
}
div.qatemplatebottom #question-tags-label{
	padding-left: 20px;
}


div.qatemplatebottom .wp-editor-container textarea.wp-editor-area{
	height: 250px;
	width:98%;
}

div.qatemplatebottom .quicktags-toolbar {

  border: 1px solid #dedede;
}


div.qatemplatebottom  #question-title-td{
	width: 90%;
}
div.qatemplatebottom  #question-title{
	width: 400px;
  max-width: 90%;
}

div.qatitle span.nota{
	font-size:13px;
	text-transform: none;
}

div.qatemplatebottom.templatecx{
	width: 90%;
	margin-left: auto;
	margin-right: auto;
}



	</style>







 <?php
          //Vamos a añadir el formulario de pregunte al cirujano.

         if ((get_locale() == 'es_ES') || (get_locale() == 'es_MX') || (get_locale() == 'es_CL') || (get_locale() == 'es_CO')) {
             if (get_locale() == 'es_ES') {
                 $dominio = 'es';
             }
             if (get_locale() == 'es_MX') {
                 $dominio = 'mx';
             }
             if (get_locale() == 'es_CO') {
                 $dominio = 'co';
             }
             if (get_locale() == 'es_CL') {
                 $dominio = 'cl';
             } ?>





	 <?php
         }
      ?>








		</div><!-- #content -->



	</div><!-- #primary -->

    <!-- Aquí iba el left menu lo hemos subido para el responsive-->





    <div id="leftWrapper">






    <?php
        //Añadimos el full Yarpp Bottom.
        include('nc-yarpp-full-side.php');

    ?>
    </div>




<?php //get_sidebar();?>
<?php get_footer(); ?>
