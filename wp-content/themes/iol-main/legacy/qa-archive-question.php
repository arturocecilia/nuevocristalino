<?php get_header(); //'qa'?>

<!-- Abrimos primary -->
<div id="primary" class="site-content-qa">
<!-- Fin abrimos primary -->


<div class="title-qa-wrapper"><h1><?php echo _x('Pregunta a los cirujanos', 'single-question', 'iol_last'); ?></h1></div>

<!-- qa-archive-question-->

<div id="menu-foro">
      <?php  wp_nav_menu(array('theme_location'=>'Menu-cat-QA')); ?>
</div>

<div id="qa-page-wrapper">
	<div id="qa-content-wrapper">
		<?php do_action('qa_before_content', 'archive-question'); ?>

		<?php the_qa_error_notice(); ?>
		<?php the_qa_menu(); ?>

		<?php if (!have_posts()) : ?>

			<p class="noQAFound"><?php $question_ptype = get_post_type_object('question'); echo $question_ptype->labels->not_found; ?>

			<?php echo '<br /><br /><span class="sinPreguntas">'._x('Pregunte sus dudas', 'Archive Question', 'iol_theme').'</span>'; ?>
			</p>

		<?php else: ?>

			<div id="question-list">

			<?php
            //Mensaje para informar de que no se aceptan preguntas por el momneto.

            if (get_locale() == 'es_ES') {
                echo '<div style="margin-bottom:30px;text-align:center;font-size:15px; color:red;">Sentimos comunicar que debido a que estamos trabajando en la actualización de la plataforma no podemos gestionar la contestación de las preguntas. En cuanto nos sea posible volveremos a tratar de que sus dudas sean resueltas. </div>';
            }


    ?>

			<?php while (have_posts()) : the_post(); ?>
				<?php do_action('qa_before_question_loop'); ?>
				<div class="question">
					<?php do_action('qa_before_question'); ?>
                    <!-- Metemos la imagen de la categor’a-->
                    <?php
                        //if(current_user_can('manage_posts')){
                        $categories   = wp_get_post_terms(get_the_ID(), 'question_category', $args);
                        $categ_string = wp_list_pluck($categories, 'slug');
                        $firstCat = 0;
                        $globalLang = substr(get_locale(), 0, 2);

                                                $cataratas = array(
                                            'es' =>'preguntas-cataratas',
                                            'en'=>'cataract-questions',
                                            'de'=>'fragen-katarakt',
                                            'fr'=>'questions-cataractes'
                                            );
                        $presbicia = array(
                                            'es' =>'preguntas-presbicia',
                                            'en'=>'presbyopia-questions',
                                            'de'=>'Fragen-Presbyopie',
                                            'fr'=>'questions-presbytie'
                        );
                        $lio = array(
                                            'es' =>'preguntas-lentes-intraoculares',
                                            'en'=>'intraocular-lenses-questions',
                                            'de'=>'fragen-intraokularlinsen',
                                            'fr'=>'implants-intraoculaires'
                        );
                        $clinic = array(
                                            'es' =>'preguntas-clinicas',
                                            'en'=>'eye-clinic-questions',
                                            'de'=>'fragen-kliniken',
                                            'fr'=>'questions-cliniques'
                        );
                        if (in_array($cataratas[$globalLang], $categ_string) && ($firstCat == 0)) {
                            echo '<div class="cataractImg">&nbsp;</div>';
                            $firstCat =1;
                        }

                        if (in_array($presbicia[$globalLang], $categ_string) && ($firstCat == 0)) {
                            echo '<div class="presbImg">&nbsp;</div>';
                            $firstCat =1;
                        }

                        if (in_array($lio[$globalLang], $categ_string) && ($firstCat == 0)) {
                            echo '<div class="iolImg">&nbsp;</div>';
                            $firstCat =1;
                        }

                        if (in_array($clinic[$globalLang], $categ_string) && ($firstCat == 0)) {
                            echo '<div class="clinicImg">&nbsp;</div>';
                            $firstCat =1;
                        }


                        //}

                    ?>
                    <!-- Fin de la imagen de la categor’a -->

          <div class="question-summary">
						<?php do_action('qa_before_question_summary'); ?>
						<h3><?php the_question_link(); ?></h3>

						<div class="question-started">
							<?php the_qa_time(get_the_ID()); ?>
							<?php the_qa_user_link($post->post_author); ?>
							<div style="clear:both;height:0px;">&nbsp;</div>
							<?php the_question_tags('<div class="question-tags">', ' ', '</div>'); ?>
						</div>
						<?php do_action('qa_after_question_summary'); ?>
					</div>
					<div class="qa-custom-separator">&nbsp;</div>
					<div class="question-stats">
						<?php do_action('qa_before_question_stats'); ?>
						<div class="qa-status-icon <?php echo (is_question_answered())?'qa-answered-icon':'qa-unanswered-icon'; ?>"></div>
						<?php the_question_score(); ?>
						<?php the_question_status(); ?>
						<?php do_action('qa_after_question_stats'); ?>
					</div>

					<?php do_action('qa_after_question'); ?>
				</div>
				<?php do_action('qa_after_question_loop'); ?>
			<?php endwhile; $wp_query->set('posts_per_page', 6); ?>
			</div><!--#question-list-->

			<?php the_qa_pagination(); ?>

			<?php do_action('qa_after_content', 'archive-question'); ?>

		<?php endif;?>
	</div>
        <div id="block-qa">
    		<div id="login-qa">
            </div>
            <div id="widgetsqa">


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
                    // if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('qa') ) :?>
                    <?php // endif;
                    // Custom widget Area End
                    ?>

                    <!-- Ini custom question tag-->
                      <?php

                      $argsCQT =  array('taxonomy'=>'question_tag');
                      ?>
                      <aside class="customQaTagWidget">
                      <div class="leftmenutitlewrapper">
                      <span class="priorleftmenutitle">&nbsp;</span>
                      <h3 class="widget-title-qa"><?php echo __('Tags'); /*_x('Etiquetas','qa-archive-question','qa')*/ ?></h2>
                      <span class="afterleftmenutitle">&nbsp;</span>
                    </div>
                      <?php
                      wp_tag_cloud($argsCQT);

                      ?>
                    </aside>
                    <!-- End custom question tag -->



        	</div>
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

<?php get_footer();/*'qa'*/ ?>
