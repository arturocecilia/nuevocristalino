<?php get_header(); //'qa'

 ?>



<!-- Abrimos primary -->
<div id="primary" class="site-content-qa">
<!-- Fin abrimos primary -->


<div class="title-qa-wrapper"><h1><?php echo _x('Pregunta a los cirujanos', 'page-ask-question', 'iol_last'); ?></h1></div>



<div id="menu-foro">
      <?php  wp_nav_menu(array('theme_location'=>'Menu-cat-QA')); ?>
</div>




<div id="qa-page-wrapper">



    <div id="qa-content-wrapper">
    <?php do_action('qa_before_content', 'ask-question'); ?>

    <?php the_qa_menu(); ?>

    <div id="ask-question">


	<?php
            //Mensaje para informar de que no se aceptan preguntas por el momneto.

            if (get_locale() == 'es_ES') {
                echo '<div style="margin-bottom:30px;text-align:center;font-size:15px; color:red;">Sentimos comunicar que debido a que estamos trabajando en la actualización de la plataforma no podemos gestionar la contestación de las preguntas. En cuanto nos sea posible volveremos a tratar de que sus dudas sean resueltas. </div>';
            }


    ?>


    <?php the_question_form(); ?>
    </div>

    <?php do_action('qa_after_content', 'ask-question'); ?>
    </div>

    <div id="block-qa">
    		<div id="login-qa">
            </div>
            <div id="widgetsqa">

	                <!-- añadimos el widget-surgeons.php-->
					<?php
                        //include(get_stylesheet_directory() . '/widget-surgeons.php')
                        ?>
					<!-- Fin añadido widget -->


	                <!-- Añadimos el de ventajas de registro-->

        <?php
                    if ((!is_user_logged_in()) || (current_user_can('manage_options'))) {
                        //	include(get_stylesheet_directory() . '/widget-advregister.php');
                    }
            ?>
    <!-- Fin del de ventajas de registro -->



            	<?php
                     // Custom widget Area Start
                     if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('qa')) : ?>
                    <?php endif;
                    // Custom widget Area End
                    ?>

        	</div>
    </div>
</div><!--#qa-page-wrapper-->
</div>



<!-- Nuestro del redesig iol-last -->

<!-- Cerramos el primary -->
</div>
<!-- Cierre de primary-->


<!-- fin del nuestro -->



<?php
//global $qa_general_settings;

//if ( isset( $qa_general_settings["page_layout"] ) && $qa_general_settings["page_layout"] !='content' )
    //get_sidebar( 'question' );
?>
<style>
	  .tmce-active .quicktags-toolbar{
	  display: block !important;
	      background: #f0f0f0;
  }

#qa-page-wrapper .wp-media-buttons{
	display:none;
	}
	#question-title{
	border: 1px solid #ccc;
    background-color: #fff;
    width: 98%;
    margin-left: auto;
    margin-right: auto;
    display: block;
    }

	#question-category, #question-tags{
		display:none;
		}

	#iframe#question_content_ifr{
		max-width:99% !important;
		}

#qa-page-wrapper	.wp-editor-tabs{
	text-align:right;}

</style>
<?php get_footer();  // 'qa'

?>
