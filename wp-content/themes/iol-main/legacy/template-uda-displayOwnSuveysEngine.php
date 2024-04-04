<?php
/*
 * Template Name: Template UDA DisplayOwnSurveysEngine
 * Description: Este es el template para mostrar los resultados de cada tipo de intervención.
*/


get_header(); ?>




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

				if(is_user_logged_in() && (isset($_POST['idClinic']) || isset($_POST['sxs_id']) )){

$usersKeyValueIncludedOnly = array();

///////////////////////////////////////////////////////////////////////////////////
/*
Vamos a definitir antes de todo las condiciones por si se están visualizando resultados filtrados por clínica dr.
*/

					$current_user_ai = wp_get_current_user();
          $uProfClinics = showClinicResultsAllowed($current_user_ai->ID);
          $idClinic = 0;
          $sxs_id = 0;
          $condition = '';
//Parte de la clínica
          if(isset($_POST["idClinic"]) && (in_array($_POST["idClinic"],$uProfClinics))){

                            $idClinic = $_POST["idClinic"];

                            $arrayClinicsToView = array(get_the_title($idClinic));
                            $arrayClinicsToViewiDS= array($idClinic);
                            echo '<br />';
                         echo '<div class="returnToClinicResults"><a href="'.get_permalink(15229).'">'._x('Volver a la página inicial de encuestas','template-uda-displayownsurveysengine','iol_last').'</a>  </div>';
          							 echo '<br /><p>'._x('Estimado usuario:','template-uda-displayownsurveysengine','iol_last').' <strong>'.$uName.'</strong>,<br />';

                         echo '<br />'._x('los datos que ve a continuación son de pacientes que han seleccionado la clínica:','template-uda-displayownsurveysengine','iol_last').' <strong>'.get_the_title($idClinic).'</strong> '._x('como lugar de la operación en el cuestionario postoperatorio.','template-uda-displayownsurveysengine','iol_last').'</p>';

                         //Vamos a aclarar que si la clínica tiene "clínicas hijos" los valores de los que hayan seleccionado estas se incluirán también en la visualización de los resultados.


                         $ClinicChildArgs = array('post_parent' => $idClinic, 'post_type' => _x('clinica','CustomPostType Name','clinica'));
                         $wpClinicChilds = new WP_Query($ClinicChildArgs);


                         if(count($wpClinicChilds->posts) > 0){
                              $ClinicChildsNames = wp_list_pluck($wpClinicChilds->posts, 'post_title');
                              $ClinicChildsIds = wp_list_pluck($wpClinicChilds->posts, 'ID');
                              //Añadimos el mensaje al profesional de las clínicas hijas que van a ser tomadas en cuenta.
                              echo '<p>'._x('Esta clínica tiene los siguientes centros asociados, los pacientes operados en los siguientes centros también se incluirán:','template-uda-displayownsurveysengine','iol_last').' </p>';
                              echo '<ul class="estilada" style="margin-left: 40px; margin-bottom: 20px;line-height: 1.5;">';
                              foreach($ClinicChildsNames as $clinicName){
                                echo '<li>'.$clinicName.'</li>';
                                }
                              echo '</ul>';


                              $arrayClinicsToView = array_merge($arrayClinicsToView,$ClinicChildsNames);
                              $arrayClinicsToViewiDS = array_merge($arrayClinicsToViewiDS,$ClinicChildsIds);
                              $arrayClinicsToView = $arrayClinicsToViewiDS;


                            }else{
                              //echo 'La clínica no tiene clinicas childs'=> No hay que ampliar el arrayClinicsToView
                            }

//El userkey que hace referencia a las clínicas en las que se han operado los pacientes es: "post_clinicSx"

$usersIncludedOnly = array("post_clinicSx"=> $arrayClinicsToView );
//
//var_dump($arrayClinicsToViewiDS);
echo '<br />';

$condition = 'where user_id in( select user_id
from wp_usermeta
            where meta_key = "post_clinicSx"
             and meta_value in('.implode(",",$arrayClinicsToViewiDS).'))'; //ARTURO quitado dobles comillas

             //echo $condition;

                          }
                          else{
$usersIncludedOnly = array();

                            if(isset($_POST["idClinic"])){
                              echo '<br /><br /><br /><p>'._x('Lo sentimos pero no tiene permisos para ver los resultados de esta clínica de manera diferenciada.','template-uda-displayownsurveysengine','io_last').'</p>';
                            }
                        }


/////////////////////////////////////////////////////////////////////////////////



  if(isset($_POST['sxs_id']) && ($_POST['sxs_id'] == $current_user->ID )){



                  $sxs_id = $_POST['sxs_id'];

                  echo '<br />';
                  echo '<p>'._x('A continuación le mostramos las encuestas de los pacientes que han sido operados por usted:','template-uda-displayownsurveysengine','iol_last').'  (<strong>'.$current_user->user_login.'</strong>). '._x('Son pacientes que han rellenado un form en su clínica o mediante un enlace enviado por usted.','template-uda-displayownsurveysengine','iol_last').'</p>';
                  echo '<p>'._x('Podemos prepararle la visualización de información que quiera, en cuanto tenga datos suficientes póngase en contacto con nostros y lo preparamos.','template-uda-displayownsurveysengine','iol_last').'</p>';

//Compruebo si se guarda como post_surgeonSx o sxs_id
  $usersIncludedOnly = array("post_surgeonSx"=> array($current_user->ID));//$arrayClinicsToView //array(get_the_title($idClinic)) //array(get_the_title($idClinic))
//

$condition = 'where user_id in( select user_id
from wp_usermeta
            where meta_key = "post_surgeonSx"
             and meta_value in("'.$sxs_id.'"))';
                   //echo uda_display_user_results($resultToShowOwnPatients);
                    //Ponemos ahora un ejemplo de Catquest.
                }else{
$usersIncludedOnly = array();

                  }







////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////





					echo '<br />';
					echo '<div id="engineformWrapper">';
					echo '<form id="display-engine-form" method="post">';

          //Al estar en la página de own results metemos la info pasada aquí:
          echo '<input type="hidden" name="idClinic" value="'.$idClinic.'" />';
          echo '<input type="hidden" name="sxs_id" value="'.$sxs_id.'" />';
						//Primer input: Selección del formulario que se quiere analizar.

						$user_manager_options = get_option( 'user_manager_option_name' );
						$idProfilePages = explode(',',$user_manager_options['ids_pages_profiles']) ;

						//$arrayFormPages = array_diff($idProfilePages, array(12644)); // LO VAMOS A PONER MANUAL YA QUE ESTÁN EN SYNC.
//Catquest(14667) -Navq(15223)



if((get_current_user_id() == 3) || (get_current_user_id() == 271)){
  $arrayFormPages = array(14667,15223,15375);
}else{
            $arrayFormPages = array(14667,15223);
}
						//cogemos los section keys de cada página.
						$arrayKeyForms =  array();


							foreach($arrayFormPages as $value){

											$meta = get_post_meta($value, 'forms_sections')[0];

										 $parent = array('(',')');
										$brackets = array('[',']');
									  $forms_sections_aux = str_replace($parent,$brackets,$meta);
										$forms_sections = json_decode( $forms_sections_aux, true );


                    //var_dump(json_decode($meta,true));
										$arrayKeyForms[$forms_sections[1]["form"]] = get_the_title($value);//[0]
                    //NOTA, El primer form tiene sólo unos campos asignados, hay que quedarse con el segundo de esas páginas que es el principal.

								}


						if((!empty($_POST)) && ($_POST["form-to-analyze"] != '')){
							$formBeingAnalized = $_POST["form-to-analyze"];
							$formDefined = TRUE;
						}else{
							$formBeingAnalized ='';
							$formDefined = FALSE;
							}

						if(count($arrayKeyForms)){
							echo '<div id="form-to-analyze-wrapper">';
							echo '<label for="form-to-analyze">'._x('Formulario cuyas encuestas desea visualizar:','template-uda-displayownsurveysengine','iol_last').'</label>';
						  echo '<select id="form-to-analyze" name="form-to-analyze" style="width:300px;">';
                  echo '<option> -- '._x('Seleccionar Cuestionario','template-uda-displayownsurveysengine','iol_last').' -- </option>';
							foreach($arrayKeyForms as $key=>$value){
									echo '<option value="'.$key.'" '.selected($formBeingAnalized,$key,false).'>'.$value.'</option>';
								}
							 echo '</select>';
							 echo '</div>';
							}





						//si no está posteado el formulario ni siguiera mostramos los campos.
						if( $formDefined ){//(!empty($_POST)) && ($_POST['form-to-analyze'] != '' )


						//Segundo input: selección del de la variable que se quiere ver.



						global $wpdb;


						$postedForm = $_POST["form-to-analyze"];
						$postedPatientId = $_POST["patient-id"];

            //Cruzamos los forms con los keyFormIdentifiers:
            $arrayFormId = array("catques9sf" => "ncreg_catq",
                                  "navq"      => "ncreg_navq",
                                  "formV10"   => "ncreg_v10"
                                );//ncreg_v10

            $formId = $arrayFormId[$postedForm];

            $qFindUsers = 'SELECT user_id FROM `wp_usermeta` WHERE meta_key = "'.$formId.'"';
            $usersWithForm = $wpdb->get_results($qFindUsers);

            $qFindUsersWithFormHid = 'SELECT user_id,meta_value FROM `wp_usermeta` WHERE user_id in (SELECT user_id FROM `wp_usermeta` WHERE meta_key = "'.$formId.'") and meta_key = "ncreg_pdata_hisid"';
            $usersWithFormHID = $wpdb->get_results($qFindUsersWithFormHid);

            $qUsersWithForm = 'select *
from
              (select a.user_id,COALESCE(b.meta_value, "IDPaciente") as IDPaciente
              from
                    (SELECT user_id FROM `wp_usermeta` WHERE meta_key = "'.$formId.'") a
                    left join
                    (SELECT user_id,meta_value
                      FROM `wp_usermeta`
                        WHERE meta_key = "ncreg_pdata_hisid" and
                        user_id in
                        (SELECT user_id FROM `wp_usermeta` WHERE meta_key = "'.$formId.'")) b
                        on a.user_id = b.user_id) c
                        '.$condition.'';
            $usersWithForm = $wpdb->get_results($qUsersWithForm);




            $numberOfPatients = count($usersWithForm);



								echo '<div class="floatFixer">&nbsp;</div>';
echo '<br /><p style="font-size:13px;font-style:italic;">'._x('Se han encontrado:','','').' <strong>'.$numberOfPatients.' '._x('pacientes','template-uda-displayownsurveysengine','iol_last').'</strong> '._x('con el cuestionario seleccionado rellenado.','template-uda-displayownsurveysengine','iol_last').'</p>';
								echo '<div class="floatFixer">&nbsp;</div>';
						//$qSearchFields = 'select user_data_key,'.get_locale().' from nc_userdata where form ="'.$postedForm.'" where user_data_key!="" ';

							if(count($usersWithForm)){
								echo '<div class="floatFixer">&nbsp;</div>';
								echo '<div id="field-to-analyze-wrapper">';
								echo '<label for="field-to-analyze">'._x('Paciente cuya encuesta desea ver:','template-uda-displayownsurveysengine','iol_last').'</label>';
								echo '<select id="field-to-analyze" name="patient-id" style="width:300px;">';
                    echo '<option value="no_patient">-- '._x('Seleccionar Paciente','','').' --</option>';
                foreach($usersWithForm as $userkeydata){

									echo '<option value="'.$userkeydata->user_id.'" '.selected($userkeydata->user_id,$postedPatientId,false).'>'.$userkeydata->IDPaciente.'</option>';

								}
								echo '</select>';
								echo '</div>';
						}



						//Tercer input selección de la variable de filtrado

						echo '<div class="floatFixer">&nbsp;</div>';
						echo '<br /><p>'._x('Para visualizaciones de encuestas más avanzadas, por favor escríbanos un email.','template-uda-displayownsurveysengine','iol_last').'</p>';


					}



							$buttonText = _x('Visualizar encuesta del paciente','template-uda-displayownsurveysengine','iol_last');

							if(!$formDefined){
								//$buttonText = 'Seleccionar formulario';
                $button ='';
            }else{



                $button = '<input type="submit" value="'.$buttonText.'" />';
              }


?>
<script>


function shownOwnSurveys(){

}


jQuery('#display-engine-form').submit(function(event){

ajax = jQuery("#field-to-analyze-wrapper").length;

if(!ajax){
  return true;
}

if(jQuery("#field-to-analyze").val() == 'no_patient'){

  jQuery('#survey-result-wrapper').html('<div class="noPatientSurvey">'._x('Tiene que seleccionar un paciente','template-uda-displayownsurveysengine','iol_last').'</div>');
  return false;
}

var url = window.location;
var formData =jQuery('#display-engine-form').serialize();




if(!(formData.indexOf('patient-id') >=0)){
  console.log('Por aquí pasa');
  return true;
}else{

jQuery.ajax({
    url: url,
    data: formData,
    type: 'post',
    beforeSend:function(){
      jQuery('#survey-result-wrapper').fadeTo('slow',0.2);
    },
    success: function(response){
      var responseNeat = jQuery(response).find('#survey-result-wrapper');
      console.log(responseNeat);
      jQuery('#survey-result-wrapper').html();
      jQuery('#survey-result-wrapper').empty();
      jQuery('#survey-result-wrapper').append(jQuery(responseNeat));
      //jQuery('#ownResultsWrapper').html();
    },
    complete: function(response){
      	    scrollToElement(jQuery('#survey-result-wrapper'));
            jQuery('#survey-result-wrapper').fadeTo('slow',1);
    //  var requestedResultObject = jQuery(response).find('#ownResultsWrapper');
    //  alert(requestedResultObject.text());

//surgeryShowResultsLoader();


    //    jQuery('#field-to-analyze-filter-wrapper').prepend(jQuery(requestedResultObject));
    }

});


  event.preventDefault();
  }
});


</script>
<?php

						echo '<div class="floatFixer">&nbsp;</div>';
						echo $button;


					echo '</form>';


							echo '<script>jQuery("#form-to-analyze ").combobox({select:function(event,ui){jQuery("#field-to-analyze-wrapper").remove();jQuery("#display-engine-form").submit();}});</script>';
              echo '<script>jQuery("#field-to-analyze, #field-to-analyze-filter").combobox()</script>';

					echo '</div>';

					echo '<style> #primary.udaDisplayUserResults #display-engine-form .ui-widget-content,#primary.udaDisplayUserResults #display-fields-form .ui-widget-content{width:375px; max-width:90%;} </style>';




////////////////////////////////////////


							echo '<br />';
 echo '<div id="survey-result-wrapper">';
if(isset($_POST['form-to-analyze']) && ($_POST['form-to-analyze'] !='') && isset($_POST['patient-id']) && ($_POST['patient-id'] !='no_patient')){


  if($postedPatientId && $postedForm){

    echo '<h3 class="surveys">Mostrando encuesta ID: '.$_POST['patient-id'].'</h3>';

//Tenemos que hacer dos cosas.
//Primero traducir los ids de clínica, lente, cirujano. -> Dentro de la función showcleandata
//Traducir el post form to analyze into formsections array.

$formSectionsAvailable = array();
$formSectionsAvailable["catques9sf"] = $formSections = array(
                                                              array("form" =>"ncreg_postdata_id_basicCatQ",
                                                                    "section" => "" ),
                                                              array("form" =>"catques9sf",
                                                                    "section" => "" )
                                                                  );
$formSectionsAvailable["navq"] = $formSections = array(
                                                       array("form" =>"ncreg_postdata_id_navQ",
                                                             "section" => "" ),
                                                       array("form" =>"navq",
                                                             "section" => "" )
                                                            );
//Añadimos el formV10
$formSectionsAvailable["formV10"] = $formSections = array(
                                                       array("form" =>"ncreg_postdata_id_formV10",
                                                             "section" => "" ),
                                                       array("form" =>"formV10",
                                                             "section" => "" )
                                                            );




$formSections = $formSectionsAvailable[$_POST['form-to-analyze']];



$cl = new User_Manager_Show_User_Data();
$cl->show_clean_user_survey($_POST['patient-id'],$formSections,get_locale());



  }




}
echo '</div>';
/////////////////////////////////////////////////////////


					}else{

            echo '<br /><br /><p>'._x('Recuerde que has de estar registrado y haber iniciado sesión para poder ver sus resultados los de su clínica.,','template-uda-displayownsurveysengine','iol_last').'</p>';
            echo '<p>'._x('Una vez logueado diríjase a la página:','template-uda-displayownsurveysengine','iol_last').' <a href="'.get_permalink(14302).'">'._x('Seleccionar visualización de mis resultados','template-uda-displayownsurveysengine','iol_last').'</a> '._x('para ver los resultados que tiene a su disposición','template-uda-displayownsurveysengine','iol_last').'.</p>';
            echo '<br /><p>'._x('Como siempre con cualquier duda, contáctenos.','template-uda-displayownsurveysengine','iol_last').'</p>';
          }

							echo '<br />';
              echo '<br />';
              echo '<br />';
					?>

		</div><!-- #content -->



    </div><!-- #primary -->

        <!-- Añadimos la opción de que haya comentarios -->

        <!-- Ponemos un div auxiliar para identificar -->
        <div style="height:0px;clear: both;" id="templatePostOp"> &nbsp;</div>


			<?php endwhile; // end of the loop. ?>



<?php /*get_sidebar();*/ ?>
<?php get_footer(); ?>
