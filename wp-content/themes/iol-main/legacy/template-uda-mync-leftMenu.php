<?php
/*
 * Template Name: Template uda MyNC LeftMenu
 * Description: Este es el template para las p‡ginas de tipos de lentes.
 */

get_header(); ?>


  <style>

  	.page-template-template-udm-profiles-leftMenu-php form#loginform{
  		margin-top:25px;
  		}

  	div.linkToIolProSelector a{
    background: #ffa82d;
    color: #fff;
    width: 320px;
    font-weight: bold;
    font-size: 14px;
    padding-top: 5px;
    padding-bottom: 5px;
    display: block;
    text-align: center;
    text-decoration: none;
    margin-left: auto;
    margin-right: auto;
    padding-left: 20px;
    padding-right: 20px;
    border-radius: 3px;
    border: 1px solid #d2d2d2;
}

  </style>

  <?php
  if(is_user_logged_in() ){
          //Classes en función de las características del usuario.
    $userSpecificClasses = '';
    $userSpecificClasses .= profileShowInfo(array('infotype'=>'usertype','outputtype'=>'literal')).' ';
    $userSpecificClasses .= profileShowInfo(array('infotype'=>'preorpost','outputtype'=>'literal')).' ';

    }else{
    $userSpecificClasses = '';
    $userFormCompletion = '';
    }

    $userLoggedClass = returnClassLogged();
  ?>








    <div class="submenu-pages <?php echo $userSpecificClasses.' '.$userFormCompletion.' '.$userLoggedClass; ?>" style="clear:left;">


      <div class="leftmenutitlewrapper">
      <span class="priorleftmenutitle">&nbsp;</span>
    	<h2><?php echo _x('Tu Área Personal','intranet','iol_theme'); ?></h2>
      <span class="afterleftmenutitle">&nbsp;</span>
    </div>


        	<?php  wp_nav_menu(array('theme_location'=>'menu-mync')); ?>

<!--  De momento lo quito porque confunde más que aporta
      <h2><?php echo _x('Mi perfil de usuario','intranet','iol_theme'); ?></h2>
        	<?php wp_nav_menu(array('theme_location'=>'menu-mync-myprofile')); ?>
-->
    </div>




	<div id="primary" class="site-content-page-template udm-profiles-left-menu mync">


		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
                <?php //A–adimos un link que nos lleve a la p‡gina de archive lentes intraoculares con la taxonom’a correspondiente.


                ?>
				<?php /* comments_template( '', true );*/ ?>

                    <!-- Link para edición -->
                <?php edit_post_link('edit', '<p>', '</p>'); ?>
			<?php endwhile; // end of the loop. ?>









		</div><!-- #content -->



	</div><!-- #primary -->

    <!-- Aquí iba el left menu lo hemos subido para el responsive-->



<?php //get_sidebar(); ?>
<?php get_footer(); ?>
