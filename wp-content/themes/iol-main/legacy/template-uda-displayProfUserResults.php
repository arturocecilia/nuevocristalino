<?php
/*
 * Template Name: Template UDA Display ProfUserResults
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
  <span class="priorleftmenutitle"> </span>
    	<h2><?php echo _x('Tu Área Privada','intranet','iol_theme'); ?></h2>
      <span class="afterleftmenutitle"> </span>
</div>
        	<?php  wp_nav_menu(array('theme_location'=>'menu-myprofile-professional')); ?>

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
					$current_user_ai = wp_get_current_user();


							$sxInterests =  array('p_sxInteres_Cat','p_sxInteres_Cle','p_sxInteres_Icl','p_sxInteres_Other');





							echo '<br />';


  						echo '<p>'._x('A continuación le ponemos unos ejemplos de la visualización de información que puede tener configurada para usted.','template-uda-displayprofuserresults','iol_last').' </p>';

              echo '<p>'._x('Sin estar filtrados por clínica podrá decirnos que visualizaciones desea y se las configuraremos.','template-uda-displayprofuserresults','iol_last').'</p>';


							$resultToShow =
														array("p_sxOutcomeSat"=>array(
          																							"actualUserDataKey" => "p_sxInteres",
          																							"uMetaDataKeyFilter" => "p_sxInteres",
          																							"uMedataDataKeyValueExcluded" => [],//[],$sxInterestsToExclude
          																							"uDisplayNotTIntoAccount" => [],//$sxInterestsToExclude,
          																							"usersKeyValueExcluded" =>[],//$sxInterestsToExclude,
          																							"usersKeyValueIncludedOnly" => [],/*array(
          																																										"p_sxInteres"=> array($sxInteres)
          																																									// ),*/
          																							"title"=>""
          											 												)
          											  );

							echo uda_display_user_results($resultToShow);




					}else{

            echo '<br /><br /><p>'._x('Recuerda que has de estar registrado y haber iniciado sesión para poder ver los niveles de satisfacción de tu operación.','template-uda-displayprofuserresults','iol_last').'</p>';
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


<?php
/*
														array("p_sxOutcomeSat"=>array(
          																							"actualUserDataKey" => "p_sxOutcomeSat",
          																							"uMetaDataKeyFilter" => "p_sxOutcomeSat",
          																							"uMedataDataKeyValueExcluded" => [],
          																							"uDisplayNotTIntoAccount" => [],
          																							"usersKeyValueExcluded" => [],
          																							"usersKeyValueIncludedOnly" => array(
          																																										"p_sxInteres"=> array($sxInteres)
          																																									 ),
          																							"title"=>"Satisfacción en función de la op"
          											 												)
          											  );*/
?>
