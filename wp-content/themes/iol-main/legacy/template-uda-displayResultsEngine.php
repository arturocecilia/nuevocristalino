<?php
/*
 * Template Name: Template UDA DisplayResultsEngine
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

				if(is_user_logged_in()){






					echo '<br />';
					echo '<div id="engineformWrapper">';
					echo '<form id="display-engine-form" method="post">';

						//Primer input: Selección del formulario que se quiere analizar.

						$user_manager_options = get_option( 'user_manager_option_name' );
						$idProfilePages = explode(',',$user_manager_options['ids_pages_profiles']) ;

						//$arrayFormPages = array_diff($idProfilePages, array(12644)); // LO VAMOS A PONER MANUAL YA QUE ESTÁN EN SYNC.
//Catquest(14667) -Navq(15223)
            $arrayFormPages = array(14667,15223);

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
							echo '<label for="form-to-analyze">'._x('Seleccione el formulario que desea analizar:','template-uda-displayresultsengine','iol_last').'</label>';
						  echo '<select id="form-to-analyze" name="form-to-analyze" style="width:300px;">';
                  echo '<option> -- '._x('Seleccionar Cuestionario','template-uda-displayresultsengine','iol_last').' -- </option>';
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
						$postedKey = $_POST["field-to-analyze"];
						$postedKeyFilter = $_POST["field-to-analyze-filter"];

						//$qSearchFields = 'select user_data_key,'.get_locale().' from nc_userdata where form ="'.$postedForm.'" where user_data_key!="" ';
						$qSearchFieldsRadios = 'select `key`,'.get_locale().' as text from nc_userdata  where `key` in (SELECT parent FROM `nc_userdata` where parent != "" and form ="'.$postedForm.'" group by parent)';
						//Añadiremos los inputs en breve.

//echo $qSearchFieldsRadios;

						$qSearchFields = $qSearchFieldsRadios;


						//var_dump($qSearchFieldsRadios);

						$searchFields = $wpdb->get_results($qSearchFields);


							if(count($searchFields)){
								echo '<div class="floatFixer">&nbsp;</div>';
								echo '<div id="field-to-analyze-wrapper">';
								echo '<label for="field-to-analyze">'._x('Seleccione pregunta a analizar:','template-uda-displayresultsengine','iol_last').'</label>';
								echo '<select id="field-to-analyze" name="field-to-analyze" style="width:300px;">';
                    echo '<option>-- '._x('Seleccionar Pregunta','template-uda-displayresultsengine','iol_last').' --</option>';
                foreach($searchFields as $userkeydata){

									echo '<option value="'.$userkeydata->key.'" '.selected($userkeydata->key,$postedKey,false).'>'.$userkeydata->text.'</option>';

								}
								echo '</select>';
								echo '</div>';
						}



						//Tercer input selección de la variable de filtrado

						//$qSearchFields = 'select user_data_key,'.get_locale().' from nc_userdata where form ="'.$postedForm.'" where user_data_key!="" ';
						$qSearchFieldsRadios = 'select `key`,'.get_locale().' as text from nc_userdata  where `key` in (SELECT parent FROM `nc_userdata` where parent != "" and form ="'.$postedForm.'" group by parent)';
						//Añadiremos los inputs en breve.

						$qSearchFields = $qSearchFieldsRadios;


						//var_dump($qSearchFieldsRadios);

						$searchFields = $wpdb->get_results($qSearchFields);


							if(count($searchFields)){
								echo '<div class="floatFixer">&nbsp;</div>';
								echo '<div id="field-to-analyze-filter-wrapper">';
								echo '<label for="field-to-analyze-filter">'._x('Seleccione filtro:','template-uda-displayresultsengine','iol_last').'</label>';
								echo '<select id="field-to-analyze-filter" name="field-to-analyze-filter" style="width:300px;">';
								 	echo '<option value="no_filter"'.selected($userkeydata->key,$postedKeyFilter,false).'>-- '._x('Ningún filtro: Ver solo resultado de la pregunta','template-uda-displayresultsengine','iol_last').' --</option>';
								foreach($searchFields as $userkeydata){

									echo '<option value="'.$userkeydata->key.'" '.selected($userkeydata->key,$postedKeyFilter,false).'>'.$userkeydata->text.'</option>';

								}
								echo '</select>';
								echo '</div>';
						}


						echo '<br /><p>'._x('Para filtros más avanzados por ejemplo con exclusiones de pacientes, campos combinados por favor escríbanos un email.','template-uda-displayresultsengine','iol_last').'</p>';




					}



							$buttonText = _x('Visualizar','template-uda-displayresultsengine','iol_last');

							if(!$formDefined){
								//$buttonText = 'Seleccionar formulario';
                $button ='';
            }else{
                $button = '<input type="submit" value="'.$buttonText.'" />';
              }



						echo '<div class="floatFixer">&nbsp;</div>';
						echo $button;


					echo '</form>';


							echo '<script>jQuery("#form-to-analyze ").combobox({select:function(event,ui){jQuery("#display-engine-form").submit();}});</script>';
              echo '<script>jQuery("#field-to-analyze, #field-to-analyze-filter").combobox()</script>';

					echo '</div>';

					echo '<style> #primary.udaDisplayUserResults #display-engine-form .ui-widget-content,#primary.udaDisplayUserResults #display-fields-form .ui-widget-content{width:375px; max-width:90%;} </style>';


  ?>
          <script>
          //#submitOwnResultRequest
          //surgeryShowResultsLoader()
          jQuery('#display-engine-form').submit(function(event){
          var url = window.location;
          var formData =jQuery('#display-engine-form').serialize();
          /*console.log(formData);
          console.log(formData.indexOf('field-to-analyze'));
          //console.log(!formData.indexOf('field-to-analyze'));
          console.log(!formData.indexOf('field-to-analyze'));
          */
          if(!(formData.indexOf('field-to-analyze') >=0)){
            console.log('Por aquí pasa');
            return true;
          }else{

          jQuery.ajax({
              url: url,
              data: formData,
              type: 'post',
              beforeSend:function(){
                jQuery('#ownResultsWrapper').fadeTo('slow',0.2);
              },
              success: function(response){
                var responseNeat = jQuery(response).find('#ownResultsWrapper');
                console.log(responseNeat);
                jQuery('#ownResultsWrapper').html();
                jQuery('#ownResultsWrapper').empty();
                jQuery('#ownResultsWrapper').append(jQuery(responseNeat));
                //jQuery('#ownResultsWrapper').html();
              },
              complete: function(response){
                jQuery('#ownResultsWrapper').fadeTo('slow',1);
              //  var requestedResultObject = jQuery(response).find('#ownResultsWrapper');
              //  alert(requestedResultObject.text());

          surgeryShowResultsLoader();

            jQuery('#ownResultsWrapper').find('.resultsTest').removeClass('startsUgly');
              //    jQuery('#field-to-analyze-filter-wrapper').prepend(jQuery(requestedResultObject));
              }

          });


            event.preventDefault();
            }
          });

          </script>

<?php





////////////////////////////////////////


							echo '<br />';
echo '<div  id="ownResultsWrapper">';
if(isset($_POST['form-to-analyze']) && ($_POST['form-to-analyze'] !='') && isset($_POST['field-to-analyze']) && ($_POST['field-to-analyze'] !='')){



//								echo $postedKey;

					$resultToShowSelected = array();




					$resultToShowSelected[$postedKey] =array(
          																							"actualUserDataKey" => $postedKeyFilter,
          																							"uMetaDataKeyFilter" => $postedKeyFilter,//$postedKey
          																							"uMedataDataKeyValueExcluded" => [],//[],$sxInterestsToExclude
          																							"uDisplayNotTIntoAccount" => [],//$sxInterestsToExclude,
          																							"usersKeyValueExcluded" =>[],//$sxInterestsToExclude,
          																							"usersKeyValueIncludedOnly" => [],/*array(
          																																										"p_sxInteres"=> array($sxInteres)
          																																									// ),*/
          																							"title"=>""
          											 												);


							echo uda_display_user_results($resultToShowSelected);

}
echo '</div>';
/////////////////////////////////////////////////////////


					}else{

            echo '<br /><br /><p>'._x('Recuerda que has de estar registrado y haber iniciado sesión para poder ver los niveles de satisfacción de tus operaciones.','template-uda-displayresultsengine','iol_last').'</p>';
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
