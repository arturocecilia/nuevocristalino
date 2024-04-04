<?php get_header( 'qa' ); ?>

<div id="qa-page-wrapper">
	<div id="qa-content-wrapper">
	<?php do_action( 'qa_before_content', 'edit-answer' ); ?>

	<?php the_qa_menu(); ?>

	<?php wp_reset_postdata(); ?>

	<div id="answer-form">
		<h2><?php printf( __( 'Answer for %s', QA_TEXTDOMAIN ), get_question_link( $post->post_parent ) ); ?></h2>
		<?php the_answer_form(); ?>
	</div>

	<?php do_action( 'qa_after_content', 'edit-answer' ); ?>
	</div>
    <div id="block-qa">
    		<div id="login-qa">
            </div>
            <div id="widgetsqa">
            	<?php
                     // Custom widget Area Start
                     if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('qa') ) : ?>
                    <?php endif;
                    // Custom widget Area End
                    ?>
	
        	</div>
    </div>
</div><!--#qa-page-wrapper-->
</div>

<?php
global $qa_general_settings;

if ( isset( $qa_general_settings["page_layout"] ) && $qa_general_settings["page_layout"] !='content' )
	get_sidebar( 'question' );
?>

<?php get_footer( 'qa' ); ?>
