<?php
global $user_ID, $post;
get_header();/*'qa'*/
?>

<!-- Abrimos primary -->
<div id="primary" class="site-content-qa">
<!-- Fin abrimos primary -->

<div class="title-qa-wrapper"><div><?php echo _x('Pregunta a los cirujanos', 'single-question', 'iol_last'); ?></div></div>



<div id="menu-foro">
      <?php  wp_nav_menu(array('theme_location'=>'Menu-cat-QA')); ?>
</div>




<div id="qa-page-wrapper">

	<div id="qa-content-wrapper">
	<?php do_action('qa_before_content', 'single-question'); ?>


	<?php the_qa_menu(); ?>

	<?php if (($user_ID == 0 && qa_visitor_can('read_questions')) || current_user_can('read_questions')) {
    ?>
	<?php wp_reset_postdata(); ?>
	<div id="single-question">

	<?php


    ?>
		<div class="header-single-question-container">
		<div class="<?php echo get_idImgSingleQA(get_the_ID());//idCatQ?>">&nbsp;</div>
			<div class="question-summary">

		<h1 ><?php the_title(); ?></h1>

		<div class="question-started">
			<?php the_qa_time(get_the_ID()); ?>
			<?php the_qa_user_link($post->post_author); ?>
			<div style="clear:both;height:0px;">&nbsp;</div>
			<?php the_question_tags('<div class="question-tags">', ' ', '</div>'); ?>
		</div>

		</div>

    <div class="qa-custom-separator">&nbsp;</div>
    <div class="question-stats">
      <?php do_action('qa_before_question_stats'); ?>
      <div class="qa-status-icon <?php echo (is_question_answered())?'qa-answered-icon':'qa-unanswered-icon'; ?>"></div>
      <?php the_question_score(); ?>
      <?php the_question_status(); ?>
      <?php do_action('qa_after_question_stats'); ?>
    </div>


		</div>
		<div style="height:0px; clear:both;">&nbsp;</div>
		<div id="single-question-container">
				<div class="preContentWrapper">
            <div id="autor">

							 <div class="qa-user-date"><?php the_qa_time(get_the_ID()); ?></div>
							 <div class="barravertical">&nbsp;</div>
							 <?php the_qa_author_box(get_the_ID()); ?>

            </div>

						<div class="questionCateg"><?php echo get_catQuestion(get_the_ID()); ?></div>
					</div>
            <div id="flecha"><hr /></div>
			<div id="question-body">
				<?php //the_question_tags( __( '', QA_TEXTDOMAIN ) . ' <span class="question-tags">', ' ', '</span>' );?>
				<div style="clear:both;height:10px;">&nbsp;</div>
				<span id="qa-lastaction"><?php _e('asked', QA_TEXTDOMAIN); ?> <?php the_qa_time(get_the_ID()); ?></span>
				<div id="question-content"><?php echo the_content('qa'); ?></div>

				<div class="question-meta">
					<?php do_action('qa_before_question_meta'); ?>

					<?php the_qa_action_links(get_the_ID()); ?>
					<?php //the_question_voting();?>

					<?php do_action('qa_after_question_meta'); ?>
				</div>
			</div>
		</div>
	</div>

 <?php
// Cambiamos el share por adwords.
//  include(get_stylesheet_directory() . '/share-nc.php');


    //include('adsense-unit-horizontal.php');
include('adsense-unit-responsive.php'); ?>











	<?php
} ?>

	<?php if (((($user_ID == 0 && qa_visitor_can('read_answers')) || current_user_can('read_answers'))) && is_question_answered()) {
    ?>
	<div id="answer-list">
		<?php do_action('qa_before_answers'); ?>
		<!-- Título -->
		<h2><?php the_answer_count(); ?></h2>
        <!-- toda la respuesta -->
        <div class="respuesta">

		<?php iol_answer_list(); ?>

 <?php
// Cambiamos el share por adwords.
//  include(get_stylesheet_directory() . '/share-nc.php');


    //include('adsense-unit-horizontal.php');
include('adsense-unit-responsive.php'); ?>

        </div>
		<?php do_action('qa_after_answers'); ?>
	</div>
	<?php
} ?>


	<?php if (($user_ID == 0 && qa_visitor_can('publish_answers')) || current_user_can('publish_answers')) {
    ?>

    <!--El formularo para poner una respuesta -->
	<div id="edit-answer">
		<?php do_action('qa_before_edit_answer'); ?>

		<h2><?php _e('Your Answer', QA_TEXTDOMAIN); ?></h2>
		<?php the_answer_form(); ?>

		<?php do_action('qa_after_edit_answer'); ?>
	</div>

	<?php
} ?>

		<?php
    //emailwarn para que chequeen la carpeta spam.
    if ((get_locale()=='es_ES') ||(get_locale()=='es_MX') || (get_locale()=='es_CO') || (get_locale()=='es_CL')) {
        echo '<div class="emailwarn">Por favor no olvide comprobar la carpeta spam de su email. Si necesitásemos más información de la aportada para contestar sus dudas, se la solicitaríamos vía email.</div>';
    }

    ?>



	<p><?php the_question_subscription(); ?></p>

	<?php do_action('qa_after_content', 'single-question'); ?>
	</div>

     <div id="block-qa">
    		<div id="login-qa">
            </div>
            <div id="widgetsqa">




	<?php
//		echo '<div style="height:70px;">&nbsp;</div>';
//		include('adsense-unit-lateral-cuadrado.php')
    ?>




 <?php
  include(get_stylesheet_directory() . '/facebook-like.php');
  ?>


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

    <?php
        //Añadimos el full Yarpp Side.
        include('nc-yarpp-full-side.php');
    ?>


    </div>

</div><!--#qa-page-wrapper-->
</div>

<!-- Cerramos el primary -->
</div>
<!-- Cierre de primary-->

<?php
//global $qa_general_settings;

//if ( isset( $qa_general_settings["page_layout"] ) && $qa_general_settings["page_layout"] !='content' )
    //get_sidebar( 'question' );
?>

<?php get_footer(); ?>
