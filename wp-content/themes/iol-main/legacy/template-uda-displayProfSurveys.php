<?php
/*
 * Template Name: Template UDA Display Prof Surveys
 * Description: Este es el template para mostrar los resultados de cada tipo de intervención.
*/


get_header(); ?>


  <style>

  	.page-template-template-udm-profiles-leftMenu-php form#loginform{
  		margin-top:25px;
  		}

  	#primary.udaDisplayUserResults{
  		float:right;
  		width:74%;
  		}

  		#resultPosOpTitle.udaDisplayUserResultsTitle{
  		float:left;
  			}

  		#primary.udaDisplayUserResults .ui-widget-content,
  		#primary.udaDisplayUserResults .ui-widget-header{
  			border:1px solid #ddd;
  			}

  	div#content.site-content-testResult.udaDisplayUserResults{
  		width:99%;
  		}
  	div.site-content-testResult.udaDisplayUserResults div.tabLabel{
  		margin-top:10px;
  		}
  	div.displayResultTitle{
  		margin-top:25px;
  		font-size:13px;
  		}

  </style>


  <?php
  if(is_user_logged_in() ){
          //Classes en función de las características del usuario.
    $userSpecificClasses = '';
    $userSpecificClasses .= profileShowInfo(array('infotype'=>'usertype','outputtype'=>'literal')).' ';
    $userSpecificClasses .= profileShowInfo(array('infotype'=>'preorpost','outputtype'=>'literal')).' ';
    //Classes en función de si el usuario ha rellenado o no los forms.
    $userFormCompletion = '';
    $userFormCompletion .= checkIfUserHasSavedForm(array('keyform'=>'qpls','outputtype'=>'class')).' ';
    $userFormCompletion .= checkIfUserHasSavedForm(array('keyform'=>'prols','outputtype'=>'class')).' ';

    //Extraemos la info de si es paciente o profesional, en función de la misma el menú será diferente.
    $ncUserType = get_user_meta(get_current_user_id(),'ncusertype',true);

    if($ncUserType == 'prof'){
        $checkUser= 'prof';
        }else{
              $checkUser = 'pat';
        }
     //////

    }else{
    $userSpecificClasses = '';
    $userFormCompletion = '';
    $checkUser = 'pat';
    }

    $userLoggedClass = returnClassLogged();






  ?>













    <div class="submenu-pages <?php echo $userSpecificClasses.' '.$userFormCompletion.' '.$userLoggedClass; ?>" style="clear:left;">


      <div class="leftmenutitlewrapper">
      <span class="priorleftmenutitle">&nbsp;</span>
    	<h2><?php echo _x('Area de NuevoCristalino para Profesionales','intranet','iol_theme'); ?></h2>
      <span class="afterleftmenutitle">&nbsp;</span>
    </div>


        	<?php  wp_nav_menu(array('theme_location'=>'menu-myprofile-professional')); ?>
    <!--  <h2><?php echo _x('Mi perfil de usuario','intranet','iol_theme'); ?></h2>
        	<?php wp_nav_menu(array('theme_location'=>'menu-mync-myprofile')); ?>
-->
    </div>


	<div id="primary" class="postOpTestResults udaDisplayUserResults" >


<div id="resultPosOpTitle" class="udaDisplayUserResultsTitle">

<?php

		echo '<h1>';
		the_title();
		echo'</h1>';//'Mensaje de agradecimiento por haber rellenado el formulario';


?>
</div>



		<div id="content" class="site-content-testResult udaDisplayUserResults" role="main">


   			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content();


				//Vamos a crear la salida de info de acuerdo al perfil del usuario

				if(is_user_logged_in()){

					global $wpdb;
          global $current_user;

					$current_user_ai = wp_get_current_user();

if($current_user_ai->ID){

							$checkProf = $current_user_ai->ncusertype;

							if($checkProf != 'prof'){
								echo '<p>'._x('Usted no está logeado como usuario profesional, por favor proceda a editar su:','template-uda-displayprofsurveys','iol_last').' <a href="'.get_permalink(12644).'">'._x('información básica','template-uda-displayprofsurveys','iol_last').'</a> '._x('o póngase en contacto con nosotros.','template-uda-displayprofsurveys','iol_last').'</p>';
								}else{

							$uName = $current_user_ai->user_login;
							$sxInteres = $current_user_ai->p_sxInteres;
							$sxInterestsToExclude = array_diff($sxInterests, array($sxInteres));
							$uProfClinics = showClinicResultsAllowed($current_user_ai->ID);//$wpdb->get_col($qUProf);

							//Damos las opciones para que se dirijan a sus clínicas específicas.

							//$qUProf = 'select clinic_id from `nc_userprof_clinic` where `user_prof_id`="'.$current_user_ai->ID.'"';
					if(count($uProfClinics) == 0){
											echo '<br />';
											echo '<p>'._x('Estimado usuario:','template-uda-displayprofsurveys','iol_last').' <strong>'.$uName.'</strong> '._x('según la info aportada, usted no tiene permiso para ver las encuestas realizadas por una clínica.','template-uda-displayprofsurveys','iol_last').'</p>';
							}else{
											echo '<br />';
											echo '<p>'._x('Estimado usuario:','template-uda-displayprofsurveys','iol_last').' <strong>'.$uName.'</strong> '._x('según la info aportada, puedes ver las encuestas de las siguientes clínicas:','template-uda-displayprofsurveys','iol_last').'';
                      echo '<div class="clinicResultListWrapper">';
											foreach($uProfClinics as $idClinic){
                        //get_permalink()
                          echo '<form method="post" action="'.get_permalink(15229).'">';
                          echo '<input type="hidden" name="idClinic" value="'.$idClinic.'">';
													echo '<div class="linkToClinicResults"><input type="submit" value="'.get_the_title($idClinic).'" /></div>';
                          echo '</form>';
                        }
                      echo '</div>';

                      //También le damos la opción de ver sus propios pacientes obviamente.
                      echo '<p>'._x('En el siguiente link podrás ver las encuestas de los pacientes operados por usted:','template-uda-displayprofsurveys','iol_last').'</p>';
                      echo '<div class="clinicResultListWrapper">';
                        //get_the_ID() 15228
                          echo '<form method="post" action="'.get_permalink(15229).'">';
                          echo '<input type="hidden" name="sxs_id" value="'.$current_user->ID.'" />';
                          echo '<div class="linkToClinicResults"><input type="submit" value="'._x('Info rellenada por sus pacientes','template-uda-displayprofsurveys','iol_last').'" /></div>';
                          echo '</form>';
                      echo '</div>';
                    }
	}



				}
					}else{

            echo '<br /><br /><p>'._x('Recuerda que has de estar registrado y haber iniciado sesión para poder ver los niveles de satisfacción de tu operación.','template-uda-displayprofsurveys','iol_last').'</p>';
          }


					?>

		</div><!-- #content -->



    </div><!-- #primary -->

        <!-- Añadimos la opción de que haya comentarios -->

        <!-- Ponemos un div auxiliar para identificar -->
        <div style="height:0px;clear: both;" id="templatePostOp"> &nbsp;</div>


			<?php endwhile; // end of the loop. ?>



<?php /*get_sidebar();*/ ?>
<?php get_footer(); ?>
