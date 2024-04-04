<?php get_header( 'qa' ); ?>

<div id="qa-page-wrapper">
    <div id="qa-content-wrapper">
    <?php do_action( 'qa_before_content', 'edit-question' ); ?>

    <?php the_qa_menu(); ?>

    <div id="edit-question">
    <?php the_question_form(); ?>
    </div>
	<?php 
	//emailwarn para que chequeen la carpeta spam.
	if((get_locale()=='es_ES') ||(get_locale()=='es_MX') || (get_locale()=='es_CO') || (get_locale()=='es_CL')   ){
		echo '<div class="emailwarn">Por favor no olvide comprobar la carpeta spam de su email, por si necesitásemos más información de la aportada para contestar sus dudas.</div>';
	}
		
	?>
	
	
	
    <?php do_action( 'qa_after_content', 'edit-question' ); ?>
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
//global $qa_general_settings;

//if ( isset( $qa_general_settings["page_layout"] ) && $qa_general_settings["page_layout"] !='content' )
	//get_sidebar( 'question' );
?>

<?php get_footer( 'qa' ); ?>
