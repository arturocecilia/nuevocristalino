<?php
/*
 * Template Name: Template udm profiles leftMenu
 * Description: Este es el template para las p‡ginas de tipos de lentes.
 */

get_header(); ?>


  <style>

  	.page-template-template-udm-profiles-leftMenu-php form#loginform{
  		margin-top:25px;
  		}

  		/* Los no logeados no pueden ver varios items	*/
.submenu-pages.not_logged #menu-menu-myprofile > li:nth-child(2) > ul > li:nth-child(1),
.submenu-pages.not_logged #menu-menu-myprofile > li:nth-child(1) > ul > li:nth-child(1),
.submenu-pages.not_logged #menu-menu-myprofile > li:nth-child(2) > ul > li:nth-child(2),
.submenu-pages.not_logged #menu-menu-myprofile > li:nth-child(1) > ul > li:nth-child(2),
.submenu-pages.not_logged #menu-menu-myprofile > li:nth-child(2) > ul > li:nth-child(3){
	display:none;
	}


  </style>

    <?php
    if (is_user_logged_in()) {
        //Classes en función de las características del usuario.
        $userSpecificClasses = '';
        $userSpecificClasses .= profileShowInfo(array('infotype'=>'usertype','outputtype'=>'literal')).' ';
        $userSpecificClasses .= profileShowInfo(array('infotype'=>'preorpost','outputtype'=>'literal')).' ';


        //Extraemos la info de si es paciente o profesional, en función de la misma el menú será diferente.
        $ncUserType = get_user_meta(get_current_user_id(), 'ncusertype', true);

        if ($ncUserType == 'prof') {
            $checkUser= 'prof';
        } else {
            $checkUser = 'pat';
        }
        //////
    } else {
        $userSpecificClasses = '';

        $checkUser = 'pat';
    }

      $userLoggedClass = returnClassLogged();






    ?>



<?php if ($checkUser == 'pat') {
        ?>

    <div class="submenu-pages <?php echo $userSpecificClasses.' '.$userLoggedClass; ?>" style="clear:left;">

      <div class="leftmenutitlewrapper">
      <span class="priorleftmenutitle">&nbsp;</span>
    	<h2><?php echo _x('Tu Área Personal', 'template-udm-profiles-leftmenu', 'iol_last'); ?></h2>
      <span class="afterleftmenutitle">&nbsp;</span>
    </div>
          <?php //Sólo va ha haber un menu-> Area Interna, por simplificar?>
        	<?php  //wp_nav_menu(array('theme_location'=>'menu-myprofile'));?>
        	<?php  wp_nav_menu(array('theme_location'=>'menu-mync')); ?>


    </div>
  <?php
    } ?>


 <?php if ($checkUser == 'prof') {
        ?>

    <div class="submenu-pages <?php echo $userSpecificClasses.' '.$userLoggedClass; ?>" style="clear:left;">

      <div class="leftmenutitlewrapper">
      <span class="priorleftmenutitle">&nbsp;</span>
    	<h2><?php echo _x('Area de NuevoCristalino para Profesionales', 'template-udm-profiles-leftmenu', 'iol_last'); //Cuestionarios?></h2>
      <span class="afterleftmenutitle">&nbsp;</span>
    </div>


        	<?php  wp_nav_menu(array('theme_location'=>'menu-myprofile-professional')); ?>
			

    </div>
  <?php
    } ?>


	<div id="primary" class="site-content-page-template udm-profiles-left-menu">


		<div id="content" role="main">
			<?php while (have_posts()) : the_post(); ?>

<?php
/*-- Si es la página inicial de info de perfil vamos a poner una versión alterntiva si el usuario está logeado y es profesional.--*/

if ((is_user_logged_in()) && (get_the_ID() == 13724) && ($checkUser == 'prof') && in_array(get_locale(), array('es_ES','es_MX','es_CO','es_CL'))) {
    $profilePresentForProf = true;
} else {
    $profilePresentForProf = false;
}

?>

				<?php
            if (!$profilePresentForProf) {
                get_template_part('content', 'page');
            } else {
                $current_userProf = wp_get_current_user();
                $current_userProfID = $current_userProf->ID;
                $relatedMainClinic =  get_user_meta($current_userProfID, 'o_userProfRelatedClinic', true);//$current_userProf,'',''
                //Mensaje clínica principal
                if ($relatedMainClinic != '') {
                    $relatedMainClinicMens = _x('Su clínica principal asociada es:', 'template-udm-profiles-leftmenu', 'iol_last').'<strong>'.$relatedMainClinic.'</strong>';
                } else {
                    $relatedMainClinicMens = _x('No tiene clínica principal asociada', 'template-udm-profiles-leftmenu', 'iol_last');
                }
                ////Check de la clínica principal en la que trabaja el Dr.
                $relatedClinic = get_page_by_title($relatedMainClinic, OBJECT, _x('clinica', 'CustomPostType Name', 'clinica'));
                if ($relatedClinic) {
                    $relatedMainClinicMensInfo = sprintf(_x('Enhorabuena vemos que: <strong> %1$s </strong> está dada de alta. Puede ver el <a href="%2$s">perfil de la clínica </a>.', 'template-udm-profiles-leftmenu', 'iol_last'), $relatedClinic->post_title, get_permalink($relatedClinic->ID));
                } else {
                    $relatedMainClinicMensInfo = _x('Vemos que su clínica no está dada de alta, si desea hacerlo contáctenos.', 'template-udm-profiles-leftmenu', 'iol_last');
                }


                //Mensaje permiso para ver clínicas.
                $clinicsPermisionAllowed = showClinicResultsAllowed($current_userProfID);

                $clinicsPermisionAllowedMens = '';

                if (count($clinicsPermisionAllowed) > 0) {
                    $clinicsPermisionAllowedMens .='<p>'.sprintf(_x('Estimado usuario: <strong> %s </strong> según la info aportada, puedes ver los datos asociados a las siguientes clínicas:', 'template-udm-profiles-leftmenu', 'iol_last'), $current_userProf->user_login);
                    $clinicsPermisionAllowedMens .='<ul class="estilada">';
                    foreach ($clinicsPermisionAllowed as $idClinic) {
                        $clinicsPermisionAllowedMens .='<li>';
                        $clinicsPermisionAllowedMens .= '<span>'._x('Ver resultados de:', 'template-udm-profiles-leftmenu', 'iol_last').' </span><a href="'.get_permalink(14302).'/?idClinic='.$idClinic.'">'.get_the_title($idClinic).'</a>';
                        $clinicsPermisionAllowedMens .= '</li>';
                    }
                    $clinicsPermisionAllowedMens .='</ul>';
                } else {
                    $clinicsPermisionAllowedMens .='<p>'.sprintf(_x('Estimado usuario: <strong> %s </strong> según la info aportada, usted no tiene permiso para ver resultados específicos de ninguna clínica.', 'template-udm-profiles-leftmenu', 'iol_last'), $current_userProf->user_login);
                    $clinicsPermisionAllowedMens .='<p>'._x('Recuerde que para ver los resultados no basta con rellenar el campo de clínica, tiene que ponerse en contacto con nosotros. Usted o algún responsable de su clínica.', 'template-udm-profiles-leftmenu', 'iol_last').'</p>';
                } ?>

              <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            		<header class="entry-header">
            			<h1 class="entry-title"><?php the_title(); ?></h1>
            		</header>

            		<div class="entry-content">

            			<?php //the_content();

                    echo '<p>'.sprintf(_x('Estimado usuario: %s, usted está logeado como usuario de tipo profesional.', 'template-udm-profiles-leftmenu', 'iol_last'), $current_userProf->user_login). sprinf(_x('Recuerde que puede cambiarlo en cualquier momento en la <a href="%s"> página de perfil básico</a>', 'template-udm-profiles-leftmenu', 'iol_last'), get_permalink(12644)).'</p>';
                echo '<ul class="estilada">';
                echo '<li>'.$relatedMainClinicMens.'</li>';
                echo '<li>'.$relatedMainClinicMensInfo.'</li>';
                echo '</ul>';
                //Ahora la lista de clínicas con permisos.
                echo $clinicsPermisionAllowedMens; ?>


            			<?php wp_link_pages(array( 'before' => '<div class="page-links">' . __('Pages:', 'twentytwelve'), 'after' => '</div>' )); ?>
            		</div><!-- .entry-content -->
            		<footer class="entry-meta">
            		</footer><!-- .entry-meta -->
             			<?php edit_post_link(__('Edit', 'twentytwelve'), '<span class="edit-link">', '</span>'); ?>
            	</article><!-- #post -->


<?php
            }

              ?>



				<?php /* comments_template( '', true );*/ ?>

                    <!-- Link para edición -->
                <?php edit_post_link('edit', '<p>', '</p>'); ?>
			<?php endwhile; // end of the loop.?>









		</div><!-- #content -->



	</div><!-- #primary -->

    <!-- Aquí iba el left menu lo hemos subido para el responsive-->



<?php //get_sidebar();?>
<?php get_footer(); ?>
