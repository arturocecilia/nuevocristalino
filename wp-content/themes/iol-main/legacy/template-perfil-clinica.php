<?php
/*
 * Template Name: Template Perfil Clinica
 * Description: Este es el template para las p‡ginas de mis ojos.
*/

get_header(); ?>

<style>
    .clinic-profile .customcontactform label {
        font-weight: normal;
        margin-bottom: 6px;
        color: #003B61;
        /*font-family:*/ 
    }
    .clinic-profile .customcontactform{
        border: 1px solid #EDEDED; /*#cccccc*/
        max-width: none;
        padding-bottom: 50px;
        padding-left: 30px;
        padding-top: 20px;
        width: 85%;
        background: none repeat scroll 0 0 #FCFCFC;
        margin-left: 5%;
        }

    .clinic-profile .customcontactform div {
        margin-top: 20px;
    }
    
    .clinic-profile form.customcontactform .submit {
        background: linear-gradient(to bottom, #FEA336 69%, #FF8C03 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
        border: 1px solid #FEA336;
        color: #FFFFFF;
        padding: 5px 30px;
        margin-left: 42%;
        margin-bottom: 20px;
        width: 150px;
        margin-top: 35px;
    }
    
    .clinic-profile .customcontactform input,  .clinic-profile .customcontactform textarea{
    display: block;
    margin-left: 100px;
    }
    .clinic-profile .customcontactform input {
        width: 295px;
    }
    .clinic-profile .customcontactform textarea {
        width: 500px;
    }
    textarea.explicClinic {
        height: 350px !important;
    }
    .clinic-profile .customcontactform input[type="file"] {
        color: grey;
    }
    
</style>



	<div id="primary" class="site-content-not-menus clinic-profile"> <!-- primary-quienes lo dejamos en primary-->
        <div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php /*comments_template( '', true );*/ ?>
			<?php endwhile; // end of the loop. ?>

          <?php //Metemos un poco de validación client side   ?>
 

 
          

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer('perfilclinica'); ?>