<?php
/*
Plugin Name: User Analysis
Plugin URI: http://www.nuevocristalino.es/
Description: Declares a plugin that will help displaying user surgery outcomes
Version: 1.0
Author: Arturo Cecilia
Author URI: http://www.andomed.com/
License: GPLv2
*/



function user_display_functions(){
//if(current_user_can('manage_options')){

include( plugin_dir_path( __FILE__ ) . 'displayResults-getUserResults.php');

//Función ajax para obtener los resultados de las encuestas.
add_action( 'wp_ajax_getUserMetadata', 'getUserMetadata' );
add_action( 'wp_ajax_nopriv_getUserMetadata', 'getUserMetadata' ); // need this to serve non logged in users

//}

}

add_action( 'plugins_loaded', 'user_display_functions' );

function grab_uniqueKey_fromUserDataKeyValue($user_data_key_value){


	//Esta función estaba devolviendo vacío porque sólo busca en nc_userdata.
	//sabemos que si el $user_data_key_value es un valor numérico no tiene que ir a nc_userdata sino a get_post_title
	global $wpdb;

	if(is_numeric($user_data_key_value)){
		return get_the_title($user_data_key_value);
	}
	if($user_data_key_value =='-- '._x('Si no aparece el nombre de la IOL, Contáctenos por favor.','user-analysis','user-analysis').' --'){
		return _x('No especificado','user-analysis','user-analysis');
	}


	$udaTermKey = '';

	$qGKey = 'select nc_userdata.key as "key"
	 					from nc_userdata
   							 where nc_userdata.user_data_key_value ="'.$user_data_key_value.'"';


	$termKeyQ = $wpdb->get_results($qGKey);

	foreach($termKeyQ as $key){
			$udaTermKey = $key->key;
		}

		return $udaTermKey;

	}


		add_action( 'admin_menu', 'add_user_analysis_settings_page' );
	  add_action( 'admin_init', 'user_analysis_settings_page_init' );


//Vamos a pooner los arrays en settings.


   function add_user_analysis_settings_page() //add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'User Analysis Settings Admin', //Settings Admin
            'User Analysis Settings', //My Settings
            'manage_options', //manage_options
            'user-analysis-setting-admin', //my-setting-admin
            'create_user_analysis_settings_admin_page' // array( $this, 'create_admin_page' )
        );
    }



	    /**
     * Options page callback
     */
    function create_user_analysis_settings_admin_page() //create_admin_page()
    {
        // Set class property
        $optionsAnalysis = get_option( 'user_analysis_option_name' );//my_option_name

      //var_dump($optionsAnalysis);

        ?>
        <div class="wrap">
            <h2>User Analysis Settings</h2>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'user_analysis_option_group' );   //my_option_group
                do_settings_sections( 'user-analysis-setting-admin' );		//my-setting-admin
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }


    	    /**
     * Register and add settings
     */
    function user_analysis_settings_page_init() //page_init
    {
        register_setting(
            'user_analysis_option_group', //my_option_group Option group
            'user_analysis_option_name', //my_option_name Option name
            'sanitize_user_analysis_settings' //sanitize Sanitize
        );

        add_settings_section(
            'user_analysis_setting_section_id', //setting_section_id ID
            'User Analysis Settings', //My Custom Settings Title
            'print_user_analysis_section_info', //print_section_info Callback
            'user-analysis-setting-admin' //my-setting-admin Page
        );

        add_settings_field(
            'array_fields_query_admin', //id_number ID
            'Array asociativo con la query para los usuarios de role admin', //ID Number Title
            'array_fields_query_admin_callback', //id_number_callback Callback
            'user-analysis-setting-admin', //my-setting-admin Page
            'user_analysis_setting_section_id' //setting_section_id Section
        );

        add_settings_field( /*-- Here will be the forms and sections that will be included in the registration form --*/
            'array_fields_query_suscriptor', //title
            'Array asociativo en formato JSON con las gráficas que verán los usuarios', //Title
            'array_fields_query_suscriptor_json_callback', //title_callback
            'user-analysis-setting-admin', //my-setting-admin
            'user_analysis_setting_section_id' //setting_section_id
        );


    }

   function print_user_analysis_section_info(){
    	echo 'El shortcode es: <strong>[display_user_data]</strong>';
    	echo 'La primera clave = es la variable que queremos visualizar (displayed), es un: "user_data_key"<br />';
    	echo 'actualUserDataKey => => Es el criterio de filtrado (filtrador-> LAS TABS) que vamos a utilizar para ver la primera clave, es un: "user_data_key"<br />';
    	echo '"uMetaDataKeyFilter" => es la "key" de la pregunta que da lugar al "actualUserDataKey" sirve para obtener todas las opciones de "user_data_key_value" para el filtrado.<br />';
    	echo '"uMetaDataKeyValueExcluded" => "user_data_key_value" excluidos del filtrado (este "user_data_key_value" es del user_data_key filtrador) serán los tabs que no apareceran<br />';
    	echo '"uDisplayNotTIntoAccount" => "user_data_key_value" de la primera clave que no se van a visualizar (este "user_data_key_value" es del user_data_key displayed)<br />';
    	echo '"usersKeyValueExcluded" =>usuarios excluidos de la visualización.<br />';
    	echo '"usersKeyValueIncludedOnly" => usuarios que se incluyen únicamente.<br /><br />';






    	}


    		  /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
 function sanitize_user_analysis_settings( $input ) //sanitize
    {
    	/*
        $new_input = array();

        if( isset( $input['array_fields_query_admin'] ) )
            $new_input['array_fields_query_admin'] = sanitize_text_field( $input['array_fields_query_admin'] );

        if( isset( $input['array_fields_query_suscriptor'] ) )
            $new_input['array_fields_query_suscriptor'] = sanitize_text_field( $input['array_fields_query_suscriptor'] );

        */


        return $input;
    }


        /**
     * Get the settings option array and print one of its values
     */
     function array_fields_query_admin_callback() //id_number_callback
    {
    		$optionsAnalysis =  get_option( 'user_analysis_option_name' );

        printf(
            '<textarea rows="15" cols="60" id="array_fields_query_admin" name="user_analysis_option_name[array_fields_query_admin]">%s</textarea> ',//id="id_number" name="my_option_name[id_number]"
            isset( $optionsAnalysis['array_fields_query_admin'] ) ? esc_attr( $optionsAnalysis['array_fields_query_admin']) : ''
        );
    }

        /**
     * Get the settings option array and print one of its values
     */
     function array_fields_query_suscriptor_json_callback()//title_callback
    {

    	    		$optionsAnalysis =  get_option( 'user_analysis_option_name' );
        printf(
            '<textarea rows="15" cols="60" id="array_fields_query_suscriptor" name="user_analysis_option_name[array_fields_query_suscriptor]"> %s </textarea>', //id="title" name="my_option_name[title]"
            isset( $optionsAnalysis['array_fields_query_suscriptor'] ) ? esc_attr( $optionsAnalysis['array_fields_query_suscriptor']) : ''
        );

        $nbsp = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo(
        '<br /><br /><br />Example:{<br />"p_sxInteres":{<br />
																	'.$nbsp.'"actualUserDataKey":"g_inEmailing",<br />
																	'.$nbsp.'"uMetaDataKeyFilter":"g_inEmailing",<br />
																	'.$nbsp.'"uMedataDataKeyValueExcluded": [],<br />
																	'.$nbsp.'"uDisplayNotTIntoAccount":[],<br />
																	'.$nbsp.'"usersKeyValueExcluded":[],<br />
																	'.$nbsp.'"usersKeyValueIncludedOnly":{<br />
					      									'.$nbsp.'"p_preOrPost":<br />
							   									'.$nbsp.'	'.$nbsp.'						  ["p_preOrPost_Post"]<br />
																	'.$nbsp.''.$nbsp.'							},<br />
																	'.$nbsp.'"title":"<div class="displayResultTitle">Título 1</div>"<br />
                									'.$nbsp.'},<br />

 									'.$nbsp.'"p_sxOutcomeSat":{<br />
 																		'.$nbsp.'"actualUserDataKey":"p_sxInteres",<br />
 																		'.$nbsp.'"uMetaDataKeyFilter":"p_sxInteres",<br />
 																		'.$nbsp.'"uMedataDataKeyValueExcluded":["p_sxInteres_Other"],<br />
 																		'.$nbsp.'"uDisplayNotTIntoAccount":[],<br />
 																		'.$nbsp.'"usersKeyValueExcluded":[],<br />
 																		'.$nbsp.'"title":"<div>Título 2</div>"}<br />
 																		'.$nbsp.'}<br />');

    }




add_shortcode( 'display_user_data', 'uda_display_user_results' );

function uda_display_user_results($data_to_display = null)
{
	global $wpdb;
	$count = 1;
	$output_user_data = '';

   $optionsForDisplay = get_option( 'user_analysis_option_name' );






		$premium_roles  = array('editor', 'administrator', 'author');
		$standard_roles = array('suscriptor');

		$user = wp_get_current_user();


		 if( array_intersect($premium_roles, $user->roles ) ) {
  				 //stuff here for allowed roles
  				 $arrayUMetaDataKeysOption =  $optionsForDisplay["array_fields_query_admin"];
		 }

		 if( array_intersect($standard_roles, $user->roles ) ) {
  				 //stuff here for allowed roles
  				 $arrayUMetaDataKeysOption =  $optionsForDisplay["array_fields_query_suscriptor"];
		 }

		 if($user->ID == 0){
		 	$output_user_data .= '<br /><br />'._x('Para poder ver la información ha de estar logeado','user-analysis','user-analysis').'<br />';
		}else{
			$output_user_data .= '';//<br /><br /><p>A continuación verá resultados que pueden serle de interés de acuerdo a su operación</p><br />
			}






   	$arrayUMetaDataKeys = json_decode(stripslashes($arrayUMetaDataKeysOption),TRUE);

     	if($data_to_display != null){


 	      $arrayUMetaDataKeys = $data_to_display;

	   	}



       $pathToTheme = get_theme_root_uri().'/iol/';

  		$idsToBeTabbed = '';

      foreach($arrayUMetaDataKeys as $uMetadataKey=>$values){//$uMetadataKey

				$idsToBeTabbed .= '#'.$uMetadataKey.',';//Parece pensado para pasarle varios arrays asociativos en la práctica le estamos pasando sólo uno.




			//vamos a sacar cada uno de los criterios de filtrado en función de el array definido.
			//Estamos generando la query.
			if(($values['uMetaDataKeyFilter'] != '') && ( $values['uMetaDataKeyFilter'] != 'no_filter') ){
						$exclusion = '';
						if(!empty($values['uMedataDataKeyValueExcluded'])){

								$exclusion .= 'AND nc_userdata.user_data_key_value not in ("'.implode("\",\"",$values['uMedataDataKeyValueExcluded']).'")';

							}

						//Ahora sacamos las tabs que vamos a tener en el mostrador de resultados.
						//es fácil si es de tipo radio pues sólo habrá que hacer una query a nc_user_data..

						$qCheck = 'select nc_userdata.input_type as tipo from nc_userdata where `key` = "'.$values["uMetaDataKeyFilter"].'"';



						$filterCheckType = $wpdb->get_col( $qCheck )[0];
						if($filterCheckType != 'input'){
									$qFilter = 'SELECT nc_userdata.user_data_key_value as filter, nc_userdata.key as valueKeyId FROM nc_userdata WHERE parent = "'.$values['uMetaDataKeyFilter'].'" '.$exclusion.' ';
									$filters =  $wpdb->get_results( $qFilter );


						}else{

							$ClinicsUQ = 'select clinic_id from nc_userprof_clinic where user_prof_id = "'.$user->ID.'"';
							$arrayClinicsU = $wpdb->get_col($ClinicsUQ);
							//var_dump($arrayClinicsU);
							$user_fields = array( $values['uMetaDataKeyFilter'] );


							$argsUsersInMeta = array(

								'meta_query' => array(
									'relation' => 'OR',
										array(
											'key'     => 'post_clinicSx',
											'value'   => array($arrayClinicsU),
								 			'operator' => '='
										),
										array(
											'key'     => 'post_surgeonSx',
											'value'   => array( $user->ID ),
											'operator'=> '='
										)
								),
								'fields' => 'ID',//$user_fields//'ID'//$user_fields
							 );

							 $usersWithMetaWPUQ = new WP_User_Query( $argsUsersInMeta );
							 $usersWithMeta =	$usersWithMetaWPUQ->get_results();

							 //var_dump($usersWithMeta);

							 //echo $values["uMetaDataKeyFilter"];
							 $strSelUID =join(",",$usersWithMeta);
	 					 	$selMetaUserDataValues = 'SELECT `meta_value` as filter, `meta_key` as valueKeyId FROM `wp_usermeta` WHERE `meta_key` = "'.$values["uMetaDataKeyFilter"].'" AND user_id in('.$strSelUID.') AND `meta_value` !="" group by `meta_value`,`meta_key`';
							 //echo $selMetaUserDataValues;

							 //Aquí si estamos hablando de clínica o lente sólo vamos a sacar los que tenemos bien identificados: con ID. lo hemos hecho con REGEXP "^[0-9]+$"

							 if(in_array($values["uMetaDataKeyFilter"], array('post_modelIOL','post_clinicSx'))){
$selMetaUserDataValues = 'SELECT `meta_value` as filter, `meta_key` as valueKeyId FROM `wp_usermeta` WHERE `meta_key` = "'.$values["uMetaDataKeyFilter"].'" AND user_id in('.$strSelUID.') AND `meta_value` !="" and `meta_value` REGEXP "^[0-9]+$" group by `meta_value`,`meta_key`';
//echo $selMetaUserDataValues.'  <br />Era esa!!';

							 }


							 $filters = $wpdb->get_results($selMetaUserDataValues);

							 //var_dump($filters);

						}


						//var_dump($filters);
				}else{
					$filters = null;//array('');

					/*if($values['uMetaDataKeyFilter'] == 'no-filter'){

						}*/


					}


				$dataUDisplayNotTIntoAccountAJson= '';
			//user_data_key_value del user_data_key displayed no tenidos en cuenta.
			if(!empty($values['uDisplayNotTIntoAccount'])){
					$uDisplayNotTIntoAccountAJson = json_encode($values['uDisplayNotTIntoAccount']);

					//var_dump($values['uDisplayNotTIntoAccount']);
					//var_dump($uDisplayNotTIntoAccountAJson);

					$dataUDisplayNotTIntoAccountAJson = 'data-dataudisplaynottintoaccount="'.htmlspecialchars($uDisplayNotTIntoAccountAJson, ENT_QUOTES, 'UTF-8').'"';

				}

			//sacamos la exclusión de usuarios con user_data_key y user_data_key_value determinados.
			if(!empty($values['usersKeyValueExcluded'])){

				//var_dump($values['usersKeyValueExcluded']);
				//ponerlo de  otra manera para que llegue al json encode en value pairs.
				$dataUsersKeyValueExcludedJson = json_encode($values['usersKeyValueExcluded']);

				//var_dump($dataUsersKeyValueExcludedJson);
				$dataUsersKeyValueExcluded = 'data-userskeyvalueexcluded="'.htmlspecialchars($dataUsersKeyValueExcludedJson, ENT_QUOTES, 'UTF-8').'"';

				}

			//Ahora el usersIncludedOnly
			if(!empty($values['usersKeyValueIncludedOnly'])){

				//var_dump($values['usersKeyValueExcluded']);
				//ponerlo de  otra manera para que llegue al json encode en value pairs.
				$dataUsersKeyValueIncludedOnlyJson = json_encode($values['usersKeyValueIncludedOnly']);

				//var_dump($dataUsersKeyValueExcludedJson);
				$userskeyvalueincludedonly = 'data-userskeyvalueincludedonly="'.htmlspecialchars($dataUsersKeyValueIncludedOnlyJson, ENT_QUOTES, 'UTF-8').'"';

				}



			if($values['title']){
				$output_user_data .= $values['title'];
				}








     $output_user_data .= '
     <div class="tabLabel"><span style="display:block; margin-right: 5px; float:left;"><img src="'.get_stylesheet_directory_uri().'/images/templates/lista.png" /></span>'.$arrayLabelTexts[$count-1].'</div>';

     //http://nuevocristalino.es/wp-content/themes/twentytwelve La parte de los resultados sólo la mostramos para la primera respuesta. Luego les decimos que si quieren verlo han de estar logeados.
     if ( is_user_logged_in() || $count == 1 ) {
     			//en el $id está la question o el userMetaData
          $output_user_data .= '<div class="resultsTest startsUgly">
        							<div id="'.$uMetadataKey.'">
            							<ul class="startsUgly">';

if(current_user_can('manage_options')){
	//var_dump($filters);
	}


if(!empty($filters)){
          foreach($filters as $filter){

//echo _x(grab_uniqueKey_fromUserDataKeyValue($filter->filter),"user_manager","user-manager").'viene de '.$filter->filter.'<br />';

          	$output_user_data .= '<li><a href="#tabs'.$count.'-'.$filter->filter.'" '.$dataUDisplayNotTIntoAccountAJson.' '.$dataUsersKeyValueExcluded.' '.$userskeyvalueincludedonly.' data-actualuserdatavalueid="'.$filter->valueKeyId.'" data-udafilterkey="'.$values['actualUserDataKey'].'">'._x(grab_uniqueKey_fromUserDataKeyValue($filter->filter),"user_manager","user-manager").'</a></li>';

          	}

          }else{

$output_user_data .= '<!-- Pasando por donde filter is null 1-->';
          	$output_user_data .= '<li><a href="#tabs'.$count.'-'.$uMetadataKey.'" '.$dataUDisplayNotTIntoAccountAJson.' '.$dataUsersKeyValueExcluded.' '.$userskeyvalueincludedonly.' data-actualuserdatavalueid="undefined" data-udafilterkey="undefined">'._x($uMetadataKey,"user_manager","user-manager").'</a></li>';
          	}

            $output_user_data .= '</ul>';

if(!empty($filters)){
              foreach($filters as $filter){

                $output_user_data .= '
                <div id="tabs'.$count.'-'.$filter->filter.'" class="panel" '.$dataUDisplayNotTIntoAccountAJson.' '.$dataUsersKeyValueExcluded.' '.$userskeyvalueincludedonly.' data-actualuserdatavalueid="'.$filter->valueKeyId.'" data-udafilterkey="'.$values['actualUserDataKey'].'">
                        <!-- <p>Monofocal Esférica</p> -->
                        <div id="ajaxResult'.$count.'-'.$filter->filter.'" class="grafico" style="width: 550px; height: 300px;"></div>
                        <div id="loading'.$count.'-'.$filter->filter.'" class="tabLoader">
                        <img src="'.$pathToTheme.'/images/newAjaxLoader.gif" title="" alt="" style="display:none;" />
                        </div>
                    </div>';
                }
}else{

$output_user_data .= '<!-- Pasando por donde filter is null 2-->';
	                $output_user_data .= '
                <div id="tabs'.$count.'-'.$uMetadataKey.'" class="panel" '.$dataUDisplayNotTIntoAccountAJson.' '.$dataUsersKeyValueExcluded.' '.$userskeyvalueincludedonly.' data-actualuserdatavalueid="undefined" data-udafilterkey="undefined">
                        <!-- <p>Monofocal Esférica</p> -->
                        <div id="ajaxResult'.$count.'-'.$uMetadataKey.'" class="grafico" style="width: 550px; height: 300px;"></div>
                        <div id="loading'.$count.'-'.$uMetadataKey.'" class="tabLoader">
                        <img src="'.$pathToTheme.'/images/newAjaxLoader.gif" title="" alt="" style="display:none;" />
                        </div>
                    </div>';




	}

$output_user_data .= '
        </div> </div>

   <!-- Final Tab Estándar -->';

     }
     else{
         $output_user_data .= '<span class="notLogedIn">'._x("Para ver el resultado a esta pregunta de los pacientes operados ha de hacer","Template PostOp Test Result text","iol_theme").' <a href="'.wp_login_url(get_page_link(get_the_ID())).'">login</a>.</span>';
     }
   $count = $count +1;
   }

   	if($idsToBeTabbed != ''){
   			$idsToBeTabbed = rtrim($idsToBeTabbed, ",");

   			//var_dump( $idsToBeTabbed );
   		}

     $output_user_data .= '<div class="idsToBeTabbed" data-idstobettabed="'.$idsToBeTabbed.'" style="display:none;">&nbsp;</div>';

     $output_user_data .= '<div class="templateUdaDisplayData">&nbsp;</div>';
     $output_user_data .= '<script type="text/javascript" src="https://www.google.com/jsapi"></script>';
     $output_user_data .= '<div id="visualization">&nbsp;</div>';


    return $output_user_data;

   }


/*-- Fin shortocde definition--*/
/*
if(current_user_can('manage_options')){
	echo 'Sí que funciona correctamente';
	}*/

function my_special_function() {
/* if ( current_user_can( 'manage_options' ) ){

}*/

  include('user-tests-knowledge-info.php');
  // do your thing
  include('user-data-checker.php');
}
add_action( 'setup_theme', 'my_special_function' ); //plugins_loaded



//Función que dado un id de usuario te devuelve las clínicas cuyos resultados de pacientes puede ver.

function showClinicResultsAllowed($id_ProfUser){
	global $wpdb;
	$thisBlogId = get_current_blog_id();

	$qUProf = 'select clinic_id from `nc_userprof_clinic` where `user_prof_id`="'.$id_ProfUser.'" and blog_id="'.$thisBlogId.'"';
	$uProfClinics = $wpdb->get_col($qUProf);

	return $uProfClinics;
	}

//Ahora el shortcode para guardar las selecciones de resultados de los drs.

add_shortcode( 'display_user_selected_data', 'uda_display_user_selected_results' );

function uda_display_user_selected_results($data_to_display = null){
	global $current_user;
	global $wpdb;

	$arraysWithDispSels = array();

	$userLResultsID = $current_user->ID;
		if(is_user_logged_in()){ //Chequeo de que está logueado.
			if(get_user_meta($userLResultsID,'ncusertype',true) == 'prof'){//Chequeo de que el usuario está logueado como profesional.

					$dispSelectedQ =  'SELECT * FROM `nc_displayresults` where nc_userprof_id='.$userLResultsID.' ';

					$dispSelected = $wpdb->get_results($dispSelectedQ);

							//var_dump($dispSelected);
				foreach ($dispSelected as $display) {


array_push($arraysWithDispSels,
					 array($display->var_measured => array(
												"actualUserDataKey" => $display->actualUserDataKey,
												"uMetaDataKeyFilter" => $display->uMetaDataKeyFilter,
												"uMedataDataKeyValueExcluded" => explode (",",
																																			$display->uMedataDataKeyValueExcluded
																																		//  "p_sxInteres_Other"
																																	), //[],
												"uDisplayNotTIntoAccount" => explode(",",
																																			$display->uDisplayNotTIntoAccount
																																	),//$sxInterestsToExclude,
												"usersKeyValueExcluded" =>explode(",",
																																			$display->usersKeyValueExcluded
																											//		"p_sxInteres"=> array('p_sxInteres_Other')
																											),//$sxInterestsToExclude,
												"usersKeyValueIncludedOnly" => array(
																															"post_surgeonSx"=> array($current_user->ID)//$arrayClinicsToView //array(get_the_title($idClinic)) //array(get_the_title($idClinic))
																																																						 ),
												"title"=>$display->title
																																				)

																									));





							}

							foreach ($arraysWithDispSels as $selectionResult) {

								echo uda_display_user_results($selectionResult);
							}

							//var_dump($arraysWithDispSels);

			}
		}


}





?>
