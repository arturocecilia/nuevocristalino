<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class User_Manager_UserData {


	//array of Key => Value pair arrays: array(array(form=>'',section=>'');
	private $forms;



	public function __construct( $form_sections ) {

		$this->forms = $form_sections;

	}

   public function get_user_data_form_this_object($userData){

				return $this->get_user_data_form($userData,$this->forms);
}



///////////////////////////////////////////////////////////////
//Función principal del plugin que renderiza el formulario solicitado incluyendo los datos del usuario sobreescritos por los posteados.
//Si no se le pasa usuario se limita a renderizar el fomulario-sección solicitado incluyendo valores si han sido posteados y si no vacío.
//Esta función no crea ningún usuario ni llama a otra para salvar o cambiar información de usuario.
///////////////////////////////////////////////////////////////

public function get_user_data_form($userData,$forms_sections){

global $wpdb;

$html ='';
$errors = NULL;
$errmsg_ref = '';
$defaulted = array(); //place de default info (if defaulted or not) in the correpondent key

//Primero checkear que $userData  no es un objeto del tipo WP_Error de serlo cargamos los errores en errors.
if(is_a($userData,'WP_Error')){
					$errors = $userData->errors;
   			}
//Si userData es un objeto WP_User y su ID es válido.
if(is_a($userData,'WP_User') && ($userData->ID != 0)){
	$userID = $userData->ID;
	$currentUserMetadata = get_user_meta($userID);
  $currentUserMetadataArray = array_map( function( $a ){ return $a[0]; }, $currentUserMetadata );
  }else{
	$userID = NULL;
	$currentUserMetadataArray = array("");
   }

if (!empty($_POST)){
 //Si hay valores $_POSTeados pisamos los user metadata con ese user_data_key por los valores posteados.
 $currentUserMetadataArray = array_merge($currentUserMetadataArray,$_POST);
 $info_fields = array('user_data_key','relevance');
 $wp_error = new WP_Error();
 $this->user_manager_wp_error_validation($wp_error,$forms_sections,$info_fields);
 $errors = $wp_error->errors;
}
//ya tenemos en $currentUserMetadataArray todos los datos del usuario pasado como param cargado o posteados.

//Cargamos todos los registros de esos form_sections.
$nc_userdata = $this->get_user_inputs_labels_in_form_section($forms_sections);
//Cargas lass question_key //Razón de existencia de esta columna, puedes tener varios input type question dentro de la misma question_key.
//Porque son una subpregunta, ejemplo QIRC.
$nc_userdata_questions = $this->get_user_form_info_in_form_section($forms_sections,'question_key');
//Cargas todas las user_data_key
$nc_user_data_keys = $this->get_user_form_info_in_form_section($forms_sections,'user_data_key');
//Tip: la función get_user_form_info_in_form_section tiene un group by
$num_questions = count($nc_userdata_questions);



$question_count = 0;
$question_countForAdded = 0;
$array_inputs_set_record_types = array('value_st_first','value_st_set','value_st_set','value_st_last');

foreach ( $nc_userdata as $question_user_data ){

 $visibility_class ='';
 $condition = '';
 $addedQuestionClass = '';
 $selection = '';
 $defaulted[$question_user_data->key] = $selection;

//INI Check custom_categories
//Aquí vamos a incluir el check de la categoría del input junto con el custom_categories
//Recormdamos que el campo category identifica el registro como custom de distintos tipos.
//Si el usuario tiene ese custom asignado le aparecerá si no, no.
 if($question_user_data->category != ''){
    $nc_userdata_custom_category = json_decode($question_user_data->category,true);
    $idClinicGet = '';
    $idSurgeonGet = '';
		//El usuario puede trabajar en varias clínicas -> Si hay get pillamos el GET si no lo hay pillamos DEFAULTS.
		if(!empty($_GET)){
				$getDecoded = array();
				foreach($_GET as $key=>$value){
						if(urldecode(base64_decode($key)) == 'idq'){
							$IDQ = urldecode(base64_decode($value));
							}
				    }
	  $qGetDecodedValues = 'SELECT * FROM `questionnaires_sent` WHERE id='.$IDQ.' ';
	  $getDecoded = $wpdb->get_row($qGetDecodedValues,ARRAY_A );
		$idClinicGet = $getDecoded['clinic_id'];
		$idSurgeonGet = $getDecoded['sxs_id'];
		}
    //si no se ha pasado idq tenemos que ver si hay un usuario logueado y ver sus custom.
    if(is_user_logged_in() ){
	    if(get_user_meta(get_current_user_id(),'ncusertype', true) == 'prof'){
 			 if( ($idClinicGet == '' ) && ( $idSurgeonGet == '' ) ){ //Si el usuario está logueado y no se han pasado correctamente los GET => Pillamos los defaults.
				$get_defaultsCustomQuery =  'SELECT * FROM nc_userprof_clinic WHERE default_value = 1 and user_prof_id = '.get_current_user_id().' ';//'.get_current_user_id().'
				$get_defaultsCustom =  $wpdb->get_row($get_defaultsCustomQuery);
		   }
	   }
    }

//Sacamos el campo custom desde los valores pasados por el GET.
		if(($idClinicGet != '') && ($idSurgeonGet!='')){
			$get_defaultsCustomQuery =  'SELECT * FROM nc_userprof_clinic WHERE user_prof_id = '.$idSurgeonGet.' and clinic_id= '.$idClinicGet.' ';//'.get_current_user_id().'
			$get_defaultsCustom =  $wpdb->get_row($get_defaultsCustomQuery);
		}
//Independientemente de que hayan llegado por el idq del get o por el hecho de ser un usuario prof logeado, sacamos las custom_categories
	if($get_defaultsCustom->custom_categories){
			$defaultUserCustomCategories = json_decode($get_defaultsCustom->custom_categories,true);
			$customCategoryUserMatch = count(array_intersect($nc_userdata_custom_category,$defaultUserCustomCategories));
		}

	if($customCategoryUserMatch){
	//No hacemos nada porque hay intersect=> seguimos con la función.
		}else{
	//Saltamos al siguiente registro de la tabla=> no se tiene que mostrar el registro.
		continue;
		}

}
//FIN Check custom_categories

//INI Check condition
//Ejemplos de condition: [{"ncusertype":"pat","p_preOrPost":"p_preOrPost_Pre"}] // [{"default_selected":"selected"}]

if($question_user_data->condition !=''){
	$condition = 'data-condition="'.htmlentities(json_encode($question_user_data->condition), ENT_QUOTES, 'UTF-8').'"';
	$condition_dataRude = json_decode($question_user_data->condition, true);
	$condition_data = call_user_func_array('array_merge', $condition_dataRude);
	//1-default_selected
	//2-key -> value pair que de darse hace que su class sea visible




	//vamos ha hacer el merge de condition_data para que no sólo pille la primera propiedad.

	foreach($condition_data as $key=>$value){//$condition_data[0]
		//Primero chequeamos que está visible por defecto.
		if(($userID == NULL) && ($key == 'default_selected')){ //Tenemos que estar seguros de que el usuario no es null.
				$selection = 'checked="checked"'; //Tal y como está puesto sólo vale para input radios... con un if sobre el input_type lo podríamos ampliar a selects.
				$defaulted[$question_user_data->key] = $selection;//it must be key and not user_data_key as it is suposed to be a
				}else{
							$selection = '';
							$defaulted[$question_user_data->key] = $selection;
							}
	//Chequeamos contra currentUserMetadataArray que se cumple la condición y en función de ello
	//mostramos o no.
	//Si pusiésemos más de una sólo se chequearía la última condición.
	if((in_array($key,$nc_user_data_keys)) && ($key != 'not_empty' ) && ($key != 'or_condition' ) ){//veo que se podía poner una condición not_empty:"user_data_key"

			if($currentUserMetadataArray[$key] == $value){
							$visibility_class = "visible";//si se da la condición es que está visible
				}else{
							$visibility_class = "hidden";
				}
	}

	if($key == 'not_empty'){
			if($currentUserMetadataArray[$value] != ''){
					$visibility_class = "visible";//si se da la condición es que está visible
				}else{
					$visibility_class = "hidden";
				}
	 }




	 	if($key == 'or_condition'){

	//		if(current_user_can('manage_options')){
			$or_condition = $value;

			$or_condition_Array = call_user_func_array('array_merge', $or_condition);
			$or_condition_count = 0;

			foreach ($or_condition_Array as $key => $arrayValues) {
				foreach ($arrayValues as $value) {
					if($currentUserMetadataArray[$key] == $value){
						$or_condition_count = $or_condition_count + 1;
						}
				  }
			}


			if($or_condition_count > 0){
				$visibility_class = "visible";
			}else{
				$visibility_class = "hidden";
			}
		 //}
		}

//INI condition not_be
	 	if($key == 'not_be'){

			$not_be = $value;

			$not_be_Array = call_user_func_array('array_merge', $or_condition);
			$not_be_count = 0;

			foreach ($not_be_Array as $key => $arrayValues) {
				foreach ($arrayValues as $value) {
					if($currentUserMetadataArray[$key] == $value){
						$not_be_count = $not_be_count + 1;
						}
				  }
			}

			if($not_be_count > 0){
				$visibility_class = "hidden";
			}else{
				$visibility_class = "visible";
			}
		}
//FIN condition not_be



	}
}
//FIN Check condición.



//INI WIZARD Primer paso
//Tip: El problema es que los headers del wizard tienen que ir al principio.
if(($question_user_data->html_info != '') && (strpos($question_user_data->html_info, 'wizard-header') !== false) ){
	//Si lo pones así y el wizard no está en la primera posición dentro de html_info, no funciona.
  //$htmlInfoW = json_decode($question_user_data->html_info, TRUE)[0]['wizard-header'];

$htmlInfoRude = json_decode($question_user_data->html_info, true);//[0] [0]
$htmlInfo = call_user_func_array('array_merge', $htmlInfoRude);
$htmlInfoW = $htmlInfo['wizard-header'];


	$html .= '<div id="wizard" class="swMain">';
	$html .= '<ul class="anchor">';

 foreach($htmlInfoW as $key=>$value){
				 $html .= '<li><a href="#'.$key.'">';
				 $html .= '<label class="stepNumber">'.$value["Numero"].'</label>';
				 $html .= '<span class="stepDesc">'.$value["Titulo"];//.'<br />'
				 $html .= '<small>'.$value["Subtitulo"].'</small></span>';
				 $html .= '</a></li>';
							 }
	 $html .= '</ul>';
	 $html .= '<div id="step-1">';
 }

//ahora identificamos un inicio de sección.
  if(($question_user_data->html_info != '') && (strpos($question_user_data->html_info, 'wizard-section-ini') !== false) ){


//Si lo pones así y el wizard no está en la primera posición dentro de html_info, no funciona.
//$idSection = json_decode($question_user_data->html_info,true)[0]['wizard-section-ini'];

$htmlInfoRude = json_decode($question_user_data->html_info, true);//[0] [0]
$htmlInfo = call_user_func_array('array_merge', $htmlInfoRude);
$idSection = $htmlInfo['wizard-section-ini'];


							 $html .= '</div>';
							 $html .= '<div id="'.$idSection.'">';
						 }
 $endOfSection = false;
 $endOfWizard = false;

 if(($question_user_data->html_info != '') && (strpos($question_user_data->html_info, 'wizard-end') !== false) ){
						 	$endOfWizard = true;
						 }
//FIN WIZARD primer paso.

//Habrá que finetunear todos estos accesos a html info y fusionarlos para mayor legibilidad.
$questionType = false;
//INI cambio por ser subquestion en numeración y marcado.
if(($question_user_data->html_info != '') && ($question_user_data->record_type == 'question') ){
	$htmlInfoRude = json_decode($question_user_data->html_info, true);//[0] [0]
	$htmlInfo = call_user_func_array('array_merge', $htmlInfoRude);

	if(array_key_exists('questionType',$htmlInfo)){
		$questionType = $htmlInfo["questionType"];



	}else{
		$questionType = false;
	}

}

//FIN cambio por ser subquestoin en numeración y marcado.


//INI ADDITIONAL EXPLA.
if(($question_user_data->html_info != '') && (strpos($question_user_data->html_info, 'explanation') !== false) ){


//Adaptamos el siguiente html info.
		//$htmlInfo = json_decode($question_user_data->html_info, true)[0];
		$htmlInfoRude = json_decode($question_user_data->html_info, true);//[0] [0]
		$htmlInfo = call_user_func_array('array_merge', $htmlInfoRude);

 		if(array_key_exists('explanation',$htmlInfo)){
			$explanation = $htmlInfo["explanation"];
			}
	   $explanationInput = '<span class="form-explanation">'.$explanation.'</span>';
	}else{
		 $explanationInput ='';
  }
//FIN ADDITIONAL EXPLA

//INI ADDITIONAL class
$additionalClass ='';
if(($question_user_data->html_info != '') && (strpos($question_user_data->html_info, 'additionalClass') !== false) ){
//Adaptamos el siguiente html info.
		//$htmlInfo = json_decode($question_user_data->html_info, true)[0];
		$htmlInfoRude = json_decode($question_user_data->html_info, true);//[0] [0]
		$htmlInfo = call_user_func_array('array_merge', $htmlInfoRude);

 		if(array_key_exists('additionalClass',$htmlInfo)){
			$additionalClass = $htmlInfo["additionalClass"];
			}
	}
//FIN ADDITIONAL CLASS

//INI add floatFixer
$addFloatFixer ='';
if(($question_user_data->html_info != '') && (strpos($question_user_data->html_info, 'addFloatFixer') !== false) ){
//Adaptamos el siguiente html info.
		//$htmlInfo = json_decode($question_user_data->html_info, true)[0];
		$htmlInfoRude = json_decode($question_user_data->html_info, true);//[0] [0]
		$htmlInfo = call_user_func_array('array_merge', $htmlInfoRude);

 		if(array_key_exists('addFloatFixer',$htmlInfo)){
			$addFloatFixer = '<div class="floatFixer"></div>';//$htmlInfo["addFloatFixer"];
			}
	}
//FIN add floatFixer

// Metemos aquí las traducciones.

$compulsory = 'Esta información es obligatoria';
$optional =  '- Opcional';
$convenient = ' - Conveniente responder';

if(get_locale() == 'de_DE'){
	$compulsory = 'Required';
	$optional 	=  'Optional';
	$convenient = 'Convenient';
}


//INI Info Optional or Compulsory.
if($question_user_data->relevance != ''){
 	if($question_user_data->relevance == 'compulsory'){
		 $relevance = '<span class="compulsory">'.$compulsory.'</span>';
		 $relevanceClass= 'compulsory';
		 $relevanceClassLocator = 'compulsoryLocator';
		}
	if($question_user_data->relevance == 'optional'){
		 $relevance = '<span class="optional">'.$optional.'</span>';
		 $relevanceClass= 'optional';
		 $relvanceClassLocator = 'optionalLocator';
		 }
	if($question_user_data->relevance == 'convenient'){
	 	 $relevance = '<span class="optional">'.$convenient.'</span>'; //''
		 $relevanceClass= 'convenient';//''
		 $relvanceClassLocator = 'convenientLocator';//''
		 }
 }else{
  			$relevance ='';
				$relevanceClass= '';
				$relevanceClassLocator= '';
 }
//FIN Info Optional or Compulsory.



//Cargamos en este array si el registro sólo es texto.
	$title_labels = array('question','set-title');


//INI Lógica para la numeración
	if($num_questions > $question_count){// Si hay más preguntas que question count.
				if($question_user_data->question_key == $nc_userdata_questions[$question_count]){//las which: info adicional comparten question_key con el select asociado: no están cargadas en nc_userdata_questions.
					//en $nc_userdata_questions tienes un array con las questionkeys que hay en el formulario=> Hay que dar un "status" especial a las wich para diferencialas.
						$question_number_display = true;
						$question_count = 1+ $question_count;
					}else{
						$question_number_display = false;
						if(($question_user_data->input_type == 'input') && ($question_user_data->condition != '') && (strpos($question_user_data->key,'Which')!== false) ){
							$addedQuestionClass ='addedquestion'; //va ha hacer también de check
						}
					}
		 }
//FIN lógica para la numeración.

//INI variables de marcado para selects si son comboboxes o barratings
$toCombobox = 'toCombobox';
$inputSelectQuestonInputClass ='toCombobox';

if(($question_user_data->record_type == 'question') &&  ($question_user_data->input_type == 'select')){
					if($question_user_data->html_info != ''){
						//Arreglamos este htmlInfo
						//$htmlInfo = json_decode($question_user_data->html_info, true)[0];
						$htmlInfoRude = json_decode($question_user_data->html_info, true);//[0] [0]
			  		$htmlInfo = call_user_func_array('array_merge', $htmlInfoRude);

						if(array_key_exists('shape_inputs',$htmlInfo)){
								$shape = $htmlInfo["shape_inputs"];
								if($shape =='barrating'){
									$inputSelectQuestonInputClass = 'barrating';
									$toCombobox = 'barrating';
								  }
								}
							}
		}
//FIN variables auxiliares para selects

//INI del RecordType text_only

if(($question_user_data->record_type == 'text_only')){
	$html .= _x($question_user_data->key,'user_manager','user-manager');
}

//FIN del RecordType text_only





//INI del html del coreForm.

//INI Si es question de input radio.
if(($question_user_data->record_type == 'question') &&  ($question_user_data->input_type == 'radio') && (!$questionType) ){//in_array($question_user_data->record_type,$title_labels)
		$html.= '<div class="question_bloq input_radio_checkbox '.$additionalClass.' '.$visibility_class.'" '.$condition.'  id="id_bloq_'.$question_user_data->question_key.'">';
    if($question_number_display){
     	 $html .= '<div class="question_number">'.$question_count.'</div>';
    	}
		$html.= '<div class="question_wrapper" id="id_wrapper_'.$question_user_data->key.'">';

		$shape = 'vertical';
		//ponemos ahora un par de variables que son necesarias por los distintos estilos de los inputs.
		$inputRadQuestonInputClass='';
		$inputRadioClass = '';
		$labelRadioClass='';
		$placeholderExplaInputShape ='';
		$shapeFloatFixer ='';

  	if($question_user_data->html_info != ''){//En el caso del select estas variables de estilo las hemos definido arriba.


			//$htmlInfo = json_decode($question_user_data->html_info, true)[0];
			 $htmlInfoRude = json_decode($question_user_data->html_info, true);//[0] [0]
  		 $htmlInfo = call_user_func_array('array_merge', $htmlInfoRude);

			if(array_key_exists('shape_inputs',$htmlInfo)){
  				$shape = $htmlInfo["shape_inputs"];
					if($shape =='stars'){
						$inputRadQuestonInputClass='stars';
						$inputRadioClass = 'star';
						$labelRadioClass= 'star';
						$placeholderExplaInputShape = '<div class="starexpla">No contestada todavía.</div>';
						$shapeFloatFixer = '<div class="floatFixer">&nbsp;</div>';
				 }

				if($shape =='sliderbar'){
						$inputRadQuestonInputClass = 'sliderbar';
				}

				if($shape =='images'){
				 		$inputRadQuestonInputClass = 'images';
				}

			 }
		 }
							$html.= '<div class="question_title udm_question_label " id="id_title_'.$question_user_data->question_key.'"><span class="title_question">'._x($question_user_data->key,'user_manager','user-manager').'</span><span data-relevance="'.$question_user_data->question_key.'">'.$relevance.'</span></div>'; //$question_user_data->es_ES
							$html.= '<div class="inputs_wrapper">';
							$html.= '<div class="question_inputs '.$relevanceClassLocator.' '.$inputRadQuestonInputClass.'" data-locator="'.$question_user_data->question_key.'" id="id_inputs_'.$question_user_data->key.'" data-buttonset="'.$shape.'">';
							continue;
}
//FIN de si es question de input radio.



// Ini question_type = subquestion   Aquí vamos a cargar la subquestion, nos va venir dada por un question_type en htmlInfo.


if(($question_user_data->record_type == 'question') &&  ($question_user_data->input_type == 'radio') && $questionType){//in_array($question_user_data->record_type,$title_labels)


//Sustituimos $question_user_data->question_key por $question_user_data->key para no tener ids duplicados.
		$html.= '<div class="'.$questionType.' '.$additionalClass.' question_bloq input_radio_checkbox '.$visibility_class.'" '.$condition.'  id="id_bloq_'.$question_user_data->key.'">';

		$html.= '<div class="question_wrapper" id="id_wrapper_'.$question_user_data->key.'">';

		$shape = 'vertical';
		//ponemos ahora un par de variables que son necesarias por los distintos estilos de los inputs.
		$inputRadQuestonInputClass='';
		$inputRadioClass = '';
		$labelRadioClass='';
		$placeholderExplaInputShape ='';
		$shapeFloatFixer ='';

  	if($question_user_data->html_info != ''){//En el caso del select estas variables de estilo las hemos definido arriba.


			//$htmlInfo = json_decode($question_user_data->html_info, true)[0];
			 $htmlInfoRude = json_decode($question_user_data->html_info, true);//[0] [0]
  		 $htmlInfo = call_user_func_array('array_merge', $htmlInfoRude);

			if(array_key_exists('shape_inputs',$htmlInfo)){
  				$shape = $htmlInfo["shape_inputs"];
					if($shape =='stars'){
						$inputRadQuestonInputClass='stars';
						$inputRadioClass = 'star';
						$labelRadioClass= 'star';
						$placeholderExplaInputShape = '<div class="starexpla">No contestada todavía.</div>';
						$shapeFloatFixer = '<div class="floatFixer">&nbsp;</div>';
				 }

				if($shape =='sliderbar'){
						$inputRadQuestonInputClass = 'sliderbar';
				}

				if($shape =='images'){
				 		$inputRadQuestonInputClass = 'images';
				}

			 }
		 }
							$html.= '<div class="question_title udm_question_label " id="id_title_'.$question_user_data->question_key.'"><span class="title_question">'._x($question_user_data->key,'user_manager','user-manager').'</span><span data-relevance="'.$question_user_data->question_key.'">'.$relevance.'</span></div>'; //$question_user_data->es_ES
							$html.= '<div class="inputs_wrapper">';
							$html.= '<div class="question_inputs '.$relevanceClassLocator.' '.$inputRadQuestonInputClass.'" data-locator="'.$question_user_data->question_key.'" id="id_inputs_'.$question_user_data->key.'" data-buttonset="'.$shape.'">';
							continue;
}


//Fin questionType subquestion








//INI marcado para el record_type question del select
if(($question_user_data->record_type == 'question') && ($question_user_data->input_type == 'select')){//in_array($question_user_data->record_type,$title_labels)
	$html.= '<div class="question_bloq input_select  '.$additionalClass.'  '.$visibility_class.'" '.$condition.'  id="id_bloq_'.$question_user_data->question_key.'">';
  if($question_number_display){
  	$html .= '<div class="question_number">'.$question_count.'</div>';
	}
  $html.= '<div class="question_wrapper" id="id_wrapper_'.$question_user_data->key.'">';
	$html.= '<div class="question_title udm_question_label " id="id_title_'.$question_user_data->question_key.'"><span class="title_question">'._x($question_user_data->key,'user_manager','user-manager').'</span><span data-relevance="'.$question_user_data->question_key.'">'.$relevance.'</span></div>'; //$question_user_data->es_ES
	$html.= '<div class="inputs_wrapper">';
	$html.= '<div class="question_inputs '.$relevanceClassLocator.' '.$inputSelectQuestonInputClass.'" data-locator="'.$question_user_data->question_key.'" id="id_inputs_'.$question_user_data->key.'">';
	continue;
}
//FIN del marcado para el recordtype question del select



//INI input set title.
if($question_user_data->record_type == 'set-title'){//in_array($question_user_data->record_type,$title_labels)
	$html.= '<div class="comun_question_set '.$additionalClass.'  '.$visibility_class.'" '.$condition.'  id="id_question_bloq_'.$question_user_data->question_key.'">';//añadimos $condition
  if($question_number_display){
   	 $html .= '<div class="question_number">'.$question_count.'</div>';
		}
	$html.= '<div class="question_set_title udm_question_label" id="id_title_'.$question_user_data->question_key.'">'._x($question_user_data->key,'user_manager','user-manager').'</div>'; //$question_user_data->es_ES
	$html.= '<div class="inputs_wrapper">';
	continue;
	}
//FIN input set title

//INI comun question, pregunta intro para una serie de preguntas posteriores
if($question_user_data->record_type == 'comun-question'){
	$html.= '<div class="comun_question_bloq '.$additionalClass.'"  '.$condition.' id="id_question_bloq_'.$question_user_data->question_key.'">';
	$html.= '<div class="question_comun_title" id="id_title_'.$question_user_data->question_key.'">'._x($question_user_data->key,'user_manager','user-manager').'</div>'; //$question_user_data->es_ES
	continue;
	}
//FIN común question

//INI CARGAMOS EL VALOR en userMetaValue DESDE currentUserMetadataArray, si no, en blanco.
if(array_key_exists ($question_user_data->user_data_key,$currentUserMetadataArray)){
///////////INI: Adaptación del valor si viene como ID////////////////
if(in_array($question_user_data->user_data_key,array('post_clinicSx','post_modelIOL'))){//el valor tanto en post como en userdata va con esas claves
 	 if(is_numeric($currentUserMetadataArray[$question_user_data->user_data_key])){
			 $userMetaValue = get_the_title($currentUserMetadataArray[$question_user_data->user_data_key]);
			 }else{
			  $userMetaValue = $currentUserMetadataArray[$question_user_data->user_data_key];
			 }
		}else{
					$userMetaValue = $currentUserMetadataArray[$question_user_data->user_data_key];
		}
	///////////FIN: Adaptación del valor si viene como ID//////////////////
}else{
			$userMetaValue ='';
			}
//FIN carga del valor en userMetaValue DESDE currentUserMetadataArray.


				//We add the error if this function is called from sign_up.
//INI ADD errors, añadimos el error al marcado, nos ha podido venir desdel chequeo del post o como WP_Error en lugar de usuario.
if ( (isset($errors[$question_user_data->user_data_key][0])) && ($question_user_data->user_data_key != $errmsg_ref)) {
            $errmsg = $errors[$question_user_data->user_data_key][0];
            $htmlError = '<div class="udm_error">'.$errmsg.'</div>';
            $errmsg_ref = $question_user_data->user_data_key;
    			}else{
    				$htmlError = '';
    				}
//FIN ADD errors.


//INI inputs que no son sólo texto.
switch ($question_user_data->input_type){
	case 'input':
	$isTextArea = false;
  //Variables para marcado si es input.
	if($question_user_data->html_info != ''){
  	 $htmlInfoRude = json_decode($question_user_data->html_info, true);//[0] [0]
 		 $htmlInfo = call_user_func_array('array_merge', $htmlInfoRude);

		 if(array_key_exists('textarea',$htmlInfo)){
				    		$isTextArea = true;
				    		}
		 if(array_key_exists('hidden',$htmlInfo)){
				    		$isHidden = true;
				    		}
//También nos interesa saber si es un input con info usando placeholder.
		if(array_key_exists('placeholder',$htmlInfo)){
								$placeholder = true;
							}else{
								$placeholder = false;
							}
//vamos a ver si el guidednamevar está definido para los casos de record_type=>guided
 	  if(array_key_exists('guidednamevar',$htmlInfo)){
							 $guidednamevar = $htmlInfo['guidednamevar'];
							 $forceID = true;
							 }
	}else{
				$isTextArea = false;
				$isHidden = false;
				$guidednamevar = false;
				$forceID = false;
				}

//INI si es un input normal
if((!in_array($question_user_data->record_type,$array_inputs_set_record_types)) && (!in_array($question_user_data->record_type, array( 'autofilled','autogenerated','guided','assigned','form','checkbox','current_url' )))){
	 $html.= '<div class="question_bloq input_text '.$additionalClass.' '.$visibility_class.' '.$addedQuestionClass.'" '.$condition.' id="id_bloq_'.$question_user_data->question_key.'">';
	 if($question_number_display){
	  	$html .= '<div class="question_number">'.$question_count.'</div>';
	  	}
	if($addedQuestionClass !=''){
		  $question_countForAdded = $question_count -1;
	  	$html .= '<div class="question_number_added">'.$question_countForAdded.' - 1</div>';
			}
	 $html.= '<div class="question_wrapper" '.$condition.' id="id_wrapper_'.$question_user_data->key.'">';//añadimos $condition
	 $html.= '<label class="udm_question_label"><span class="title_question">'._x($question_user_data->key,'user_manager','user-manager').'</span>	<span class="'.$relevanceClass.'" data-relevance="'.$question_user_data->question_key.'">'.$relevance.'</span></label>';
	 $html.= '<div class="input_wrapper '.$relevanceClassLocator.'" data-locator="'.$question_user_data->question_key.'" >';
	 if(!$isTextArea){

			if($placeholder){
  			 $placeholderInfo = 'placeholder="'._x($question_user_data->key,'user_manager','user-manager').'"';
				}else{
							$placeholderInfo ='';
				}
	  	$html.= '<input type="text"  id="input_'.$question_user_data->user_data_key.'" '.$placeholderInfo.' name="'.$question_user_data->user_data_key.'" value="'.$userMetaValue.'" />';
			$html.= $explanationInput;
	  }else{
	  	$html.= '<textarea  id="input_'.$question_user_data->user_data_key.'" '.$placeholderInfo.' name="'.$question_user_data->user_data_key.'">'.$userMetaValue.'</textarea>';
	  	$html.= $explanationInput;
	  }

		$html.= '</div>';
	  $html.= $htmlError;

		/*-- Adding floatFixer--*/
		$html.= '<!-- Añadiendo floatFixer-->';
		$html.= $addFloatFixer;
		/*-- End Adding floatFixer-- */

	  $html.= '</div>';//closing question_wrapper

	  $html.= '</div>';//closing bloq

		/*if($question_user_data->record_type == 'value_st_last'){
	  	//Closing the div opened in the set-title
	  	$html.= '</div>';
	  	$html.= '</div>';//closing bloq
	  }*/

}
//FIN si es un input normal.

	  				//if the input is part of a set of inputs.

//INI input dentro de un set de inputs
if((in_array($question_user_data->record_type,$array_inputs_set_record_types))&& (!in_array($question_user_data->record_type, array( 'autofilled','autogenerated','guided','assigned','form','checkbox', 'current_url' )))){
		$html.= '<div class="question_wrapper '.$additionalClass.'" '.$condition.' id="id_wrapper_'.$question_user_data->key.'">';
		$html.= '<label>'._x($question_user_data->key,'user_manager','user-manager').'</label>';
	  if(!$isTextArea){
				if($placeholder){
					 $placeholderInfo = 'placeholder="'._x($question_user_data->key,'user_manager','user-manager').'"';
					}else{
					 $placeholderInfo ='';
					}

	  $html.= '<input type="text" id="input_'.$question_user_data->user_data_key.'" '.$placeholderInfo.' name="'.$question_user_data->user_data_key.'" value="'.$userMetaValue.'" />';
	  $html.= $explanationInput;
	  }else{
  	$html.= '<textarea type="text" id="input_'.$question_user_data->user_data_key.'" name="'.$question_user_data->user_data_key.'">'.$userMetaValue.'</textarea>';
	  $html.= $explanationInput;
	  }
	  $html.= '</div>';//closing question_wrapper

		if($question_user_data->record_type == 'value_st_last'){
	  //Closing the div opened in the set-title
	  $html.= '</div>';//closing inputs_wrapper
	  $html.= '</div>';//closing set
	  }
}
//FIN input dentro de un set de inputs

//INI input de tipo autofilled (Por ejemplo la fecha de guardado del formulario)
if($question_user_data->record_type == 'autofilled'){
 	if($isHidden){
		$html.= '<input type="hidden"  id="input_'.$question_user_data->user_data_key.'" name="'.$question_user_data->user_data_key.'" value="'.date("d.m.y, g:i a").'" />';
		}else{
		$html.= '<input type="text"  id="input_'.$question_user_data->user_data_key.'" name="'.$question_user_data->user_data_key.'" value="'.date("d.m.y, g:i a").'" />';
		}
}
//FIN input de tipo autofilled



//INI input autogenerated (por ejemplo el nombre de usuario(¿Cuando?) es autogenerado)
if($question_user_data->record_type == 'autogenerated'){
	if($isHidden){
		 $html.= '<input type="hidden"  id="'.$question_user_data->user_data_key.'" name="'.$question_user_data->user_data_key.'" value="'.$userMetaValue.'" />';
   	}else{
   	$html.= '<input type="text"  id="'.$question_user_data->user_data_key.'" name="'.$question_user_data->user_data_key.'" value="'.$userMetaValue.'" />';
   	}
}
//FIN input autogenerated

//INI input assigned.
if($question_user_data->record_type == 'assigned'){
	if($isHidden){
		 $html.= '<input type="hidden"  id="'.$question_user_data->user_data_key.'" name="'.$question_user_data->user_data_key.'" value="'.$question_user_data->user_data_key_value.'" />';
	}else{
		$html.= '<input type="text"  id="'.$question_user_data->user_data_key.'" name="'.$question_user_data->user_data_key.'" value="'.$question_user_data->user_data_key_value.'" />';
	}
}
//FIN input assigned.

//INI currentUrl

//INI input assigned.
if($question_user_data->record_type == 'current_url'){

	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	if($isHidden){
		 $html.= '<input type="hidden"  id="'.$question_user_data->user_data_key.'" name="'.$question_user_data->user_data_key.'" value="'.$actual_link.'" />';
	}else{
		$html.= '<input type="text"  id="'.$question_user_data->user_data_key.'" name="'.$question_user_data->user_data_key.'" value="'.$actual_link.'" />';
	}
}
//FIN input assigned.


//FIN currentURL



//INI input type form TIP: Notar lo de htmlspecialchars va a ir un jsonstring con un object the formsections.
if($question_user_data->record_type == 'form'){
		if($isHidden){
			 $html.= '<input type="hidden"  id="'.$question_user_data->user_data_key.'" name="'.$question_user_data->user_data_key.'" value="'.htmlspecialchars($question_user_data->user_data_key_value).'" />';
			}else{
			 $html.= '<input type="text"  id="'.$question_user_data->user_data_key.'" name="'.$question_user_data->user_data_key.'" value="'.htmlspecialchars($question_user_data->user_data_key_value).'" />';
			}
}
//INI input type form

//INI input de campo checkbox.
if($question_user_data->record_type == 'checkbox'){
				//$html.= '<input type="text"  id="'.$question_user_data->user_data_key.'" name="'.$question_user_data->user_data_key.'" value="'.htmlspecialchars($question_user_data->user_data_key_value).'" />';
				$html .='<label class="checkbox"><input type="checkbox" id="'.$question_user_data->user_data_key.'" name="'.$question_user_data->user_data_key.'" value="'.$question_user_data->user_data_key.'">'._x($question_user_data->key,'user_manager','user-manager').'</label>';
				$html.= $explanationInput;
			}
//FIN input de campo checkbox.


//INI input de tipo guided
if($question_user_data->record_type == 'guided'){ //si es guided es hidden si no, sería suggested.
	if($isHidden){
		//VAMOS A HACER EL DECODE DE LA URL + query a questionaires
		if(!empty($_GET)){
			$getDecoded = array();
			foreach($_GET as $key=>$value){
				if(urldecode(base64_decode($key)) == 'idq'){
						$IDQ = urldecode(base64_decode($value));
					}
				}
				$qGetDecodedValues = 'SELECT * FROM `questionnaires_sent` WHERE id='.$IDQ.' ';
				$getDecoded = $wpdb->get_row($qGetDecodedValues,ARRAY_A );
			}else{
				$getDecoded = array();
			}
	if(isset($getDecoded[$guidednamevar])){
	$guidedvarvalueID = $getDecoded[$guidednamevar];
		if (!$forceID) {
		 $guidedvarvalue = get_the_title($guidedvarvalueID);
	 }else {
		 $guidedvarvalue = $guidedvarvalueID;
	 }
	}else{
		$guidedvarvalue = FALSE;
	}
//El default si hay logged in user con id en nc_user_prof_clinic y no hay get.
if(!$guidedvarvalue){
	//Chequeamos que el usuario esté logueado.
	if(is_user_logged_in() ){
		//Chequeamos que el usuario logeado es profesional
		if(get_user_meta(get_current_user_id(),'ncusertype', true) == 'prof'){
			//Chequeamos que el usuario logeado está en la tabla nc_userprof_clinic (si se trata de la variable sxs_id )
			if(($question_user_data->user_data_key) == 'post_surgeonSx'){
					$guidedvarvalue = get_current_user_id();
			}else {
					$get_defaultsQuery =  'SELECT * FROM nc_userprof_clinic WHERE default_value = 1 and user_prof_id = '.get_current_user_id().' ';//'.get_current_user_id().'
					$get_defaults =  $wpdb->get_row($get_defaultsQuery);
					if($get_defaults != NULL){
						$guidedvarvalue =  $get_defaults->$guidednamevar;
					}
		  	}
  		}
 	  }
 }
 $html.= '<input type="hidden"  id="'.$question_user_data->user_data_key.'" name="'.$question_user_data->user_data_key.'" value="'.$guidedvarvalue.'" />';
}else{
	$html.= '<input type="text"  id="'.$question_user_data->user_data_key.'" name="'.$question_user_data->user_data_key.'" value="'.$guidedvarvalue.'" />';
	}
}
//FIN input de tipo guided
break;


case 'radio':

//FIN setting para imágenes en input radio.
$imageStyle = '';
$labelText =_x($question_user_data->key,'user_manager','user-manager');
if($question_user_data->html_info != ''){
	$htmlInfoRude = json_decode($question_user_data->html_info, true);//[0] [0]
	$htmlInfo = call_user_func_array('array_merge', $htmlInfoRude);
	if(array_key_exists('image',$htmlInfo)){
		$imageUrl = 'url(&quot;'.plugin_dir_url( __FILE__ ).'css/images/'.$htmlInfo["image"].'&quot;)';
		$imageStyle = 'style ="background-image:'.$imageUrl.'" ';
		$labelText =_x($question_user_data->key,'user_manager','user-manager');//O nada depende de lo que se quiera.
	}
}
//FIN setting para imágenes en input radio.

$html.= '<input type="radio" class="'.$inputRadioClass.'" '.$defaulted[$question_user_data->key].' id="input_'.$question_user_data->key.'" name="'.$question_user_data->user_data_key.'" value="'.$question_user_data->user_data_key_value.'" '.checked($question_user_data->user_data_key_value,$userMetaValue,false).' />';
$html.= '<label for="input_'.$question_user_data->key.'" '.$imageStyle.' class="'.$labelRadioClass.'">'.$labelText.'</label>';

if(($question_user_data->record_type == 'result_last_radio')||($question_user_data->record_type == 'result_last_radio_last_question')){
		$html.= '</div>';//closiing inputs
		/////Aquí pondremos el placeholder de las estresllas.
		$html.= $placeholderExplaInputShape;
		$html.= $shapeFloatFixer;
		$html.= '</div>';//closing inputs_wrapper
		$html.= $htmlError;
		/*-- Adding floatFixer--*/
		$html.= '<!-- Añadiendo floatFixer-->';
		$html.= $addFloatFixer;
		/*-- End Adding floatFixer-- */
		$html.= '</div>';//closing wrapper

		$html.= '</div>';//closing bloq
}

if($question_user_data->record_type == 'result_last_radio_last_question'){
		$html.= '</div>';//closing comun_question_bloq
}
break;

case 'select':
	if(($question_user_data->record_type == 'result_first_select')){
			$html.= '<select name="'.$question_user_data->user_data_key.'" id="select_'.$question_user_data->parent.'" class="'.$toCombobox.'">';
				}
			$html.= '<option  name="'.$question_user_data->user_data_key.'" value="'.$question_user_data->user_data_key_value.'" '.selected($question_user_data->user_data_key_value,$userMetaValue,false).'>'._x($question_user_data->key,'user_manager','user-manager').'</option>';
	if(($question_user_data->record_type == 'result_last_select')||($question_user_data->record_type == 'result_last_select_last_question')){
			$html.= '</select>';
			$html.= '</div>';//closiing inputs
			$html.= '</div>';//closing inputs_wrapper
			$html.= $htmlError;
			/*-- Adding floatFixer--*/
			$html.= '<!-- Añadiendo floatFixer-->';
			$html.= $addFloatFixer;
			/*-- End Adding floatFixer-- */
			$html.= '</div>';//closing wrapper

			$html.= '</div>';//closing bloq
			}
	if($question_user_data->record_type == 'result_last_select_last_question'){
	  					$html.= '</div>';//closing comun_question_bloq
	  					}
break;

if($endOfWizard){
	$html .= '</div>';
	$html .= '</div>';
}

	} //Fin del switch input type
}//Fin del foreach que recorre los registros.
	return $html;
}


////////////////////////////////////////////////////////////////////////////////
//Función que hace uso de get_user_data_form para mostrar la info del usuario que se pasa como argumneto.
//Se utiliza en los hooks: show_user_profile y edit_user_profile
////////////////////////////////////////////////////////////////////////////////
public function display_user_data_form_this_object($userData){ //este user data es un array de errores cuando:signup_extra_fields
   		$profile_form = $this->get_user_data_form_this_object($userData);
	   	echo $profile_form;
   	}

////////////////////////////////////////////////////////////////////////////////
//Función que se utilizar para añadir user metadata en la tabla wp_signup.
//Está hookeada al filter: add_signup_meta
//El hook anterior sólo se dispara en el wpmu_signup_user que tiene lugar por defecto.
//No en los que ponemos nosotros.
//TIP: El problema es que se ha instanciado un objeto register_form que es el que se le pasa actualmnete para que chequee y añada los campos al signup...
//con lo que si los campos que deseas que se añadan al signup no están en el objeto registerform que ha servido para la instanciación, no los vas a tener..
//Hay por lo tanto que hacer un if y cambiar el chequeo de los userkeys al form que se esté utilizando para el signup y no el que se ha utilizado para el objeto.
////////////////////////////////////////////////////////////////////////////////
public function save_register_user_data_this_object($user){
			return $this->save_register_user_data_form($user,$this->forms);
}


public function save_register_user_data_form($user,$forms_sections){
	global $wpdb;
			$nc_register_meta = array();
//Antes queríamos hacer un chequeo con la presencia de una key en el $_POST y añadir más valores al nc_register_meta.
//Pero vimos que no era necesario porque add_signup_meta no se ejecuta siempre que se llama a wpmu_signup_user
			$nc_user_fields = $this->get_user_fields_in_form_section($forms_sections);
			foreach($nc_user_fields as $user_field){
					 if ( isset( $_POST[$user_field] ) ) {
							$nc_register_meta[$user_field] = $_POST[$user_field];
					}
				}
			$user['nc_register_meta'] = $nc_register_meta;
		return $user;
		}


/////////////////////////////////////////////////////////////////////////
// No veo hookeada esta función
//////////////////////////////////////////////////////////////////////////
public function create_save_update_user_data_form_this_object($userID){
			$this->create_save_update_user_data_form($userID,$this->forms);
  			}

/////////////////////////////////////////////////////////////////////////////////
//Función que recibe un userID y un forms_sections, si el userID es 0 crea el usuario
//poniendo el nombre en función de un input de record_type = form que tiene que estar en el formulario.
//luego pasa a actualizar los user_data_keys del form_sections contra el $_POST
//sobre el usuario recien creado o que tiene el userID pasado.
//Función llamada en un $_POST.
/////////////////////////////////////////////////////////////////////////////////

public function create_save_update_user_data_form($userID,$forms_sections){

global $wpdb;

$nc_user_fields = $this->get_user_fields_in_form_section($forms_sections);
//Si la función es llamada con userID = 0 es que quieren que también creemos el usuario
//además de actualizar los user_data_keys contra el $_POST
if($userID == 0){
   $refUName = $forms_sections[0]['form'];//Al poner esto ya estamos asumiendo que hay un input de record_type = form
   $usernameRude = $refUName.'_'.rand(0,99999);
   $passwd = 'nc_albacea';
   $userID = wp_create_user ($usernameRude, $passwd);
   if(is_wp_error($userID)){ //Hay una probabilidad entre 100.000 de que ocurra esto.
			if(isset($userID->errors['existing_user_login'])){
						$userID = get_userdatabylogin($usernameRude)->ID;
				}
			}
		$_POST['user_login'] =   $usernameRude;
		$_POST['nc_user_form_id'] = $userID;//Creamos un identificador para el usuario por si luego quisiese editar algo. => El id de usuario y punto, se trata de un form sin registro.
		}else {
		  $userInCliniPost = get_userdatabylogin($_POST['user_login']);
		  $userID = $userInCliniPost->ID;
			$_POST['nc_user_form_id'] = $userID;//Creamos un identificador para el usuario por si luego quisiese editar algo. => El id de usuario y punto, se trata de un form sin registro.
		}
//Ya hemos creado el usuario si nos viene con id=0, o lo hemos identificado gracias al 'nc_user_form_id'
//Ahora procedemos con la actualización/guardado del metadata que está definido en el form_section contra el $_POST
foreach($nc_user_fields as $user_field){
	if ( isset( $_POST[$user_field] ) ) {
	///////INI modficación para gestión de IDvsNames///////////
	 if(in_array($user_field,array("post_modelIOL","post_clinicSx"))){
		  if($user_field == 'post_modelIOL'){
			 	 $idEqInputA = get_page_by_title( $_POST[$user_field],  ARRAY_N, _x('lente-intraocular','CustomPostType Name','iol') );
			 	 }
  		if($user_field == 'post_clinicSx'){
			 	 $idEqInputA = get_page_by_title( $_POST[$user_field],  ARRAY_N, _x('clinica','CustomPostType Name','clinica') );
			 	 }
			if(is_numeric($idEqInputA[0])){
				 update_user_meta( $userID, $user_field, $idEqInputA[0] );
				 }else{
					 update_user_meta( $userID, $user_field, $_POST[$user_field] );
				 }
	  }else{
		  update_user_meta( $userID, $user_field, $_POST[$user_field] );
		 }
	///////FIN modficación para gestión de IDvsNames///////////
 	}
 }
}
////////////////////////////////////////////////////////////////////
//Función hookeada a: personal_options_update y a edit_user_profile_update
//al utilizar el register form object por esta razón sólo se veían esos pocos campos al hacer el edit user.
/////////////////////////////////////////////////////////////////////
public function save_update_user_data_form_this_object($userID){
			$this->save_update_user_data_form($userID,$this->forms);
			}


//Function for saving/updating the metadata of a form-section.
////////////////////////////////////////////////////////////////////
//Función que guarda/actualiza los metadatos de un usuario dado.
//Se le pasa un objeto form section y parsea sus claves contra el $_POST object
///////////////////////////////////////////////////////////////////////
public function save_update_user_data_form($userID,$forms_sections){
global $wpdb;

$nc_user_fields = $this->get_user_fields_in_form_section($forms_sections);

foreach($nc_user_fields as $user_field){
	if ( isset( $_POST[$user_field] ) ) {
			///////INI modficación para gestión de IDvsNames///////////
		 if(in_array($user_field,array("post_modelIOL","post_clinicSx"))){
			 if($user_field == 'post_modelIOL'){
				 $idEqInputA = get_page_by_title( $_POST[$user_field],  ARRAY_N, _x('lente-intraocular','CustomPostType Name','iol') );
				 }
			 if($user_field == 'post_clinicSx'){
				 $idEqInputA = get_page_by_title( $_POST[$user_field],  ARRAY_N, _x('clinica','CustomPostType Name','clinica') );
				 }
			 if(is_numeric($idEqInputA[0])){
				 update_user_meta( $userID, $user_field, $idEqInputA[0] );
				 }else{
				 update_user_meta( $userID, $user_field, $_POST[$user_field] );
				 }
			 }else{
			 update_user_meta( $userID, $user_field, $_POST[$user_field] );
			 }
				///////FIN modficación para gestión de IDvsNames///////////
    }
 }
}


////////////////////////////////////////////////////////////////////////////////
//función para guardar/actualizar los user_data_key del form que hay en una página.
//tener en cuenta que esta función no recibe form_sections, las coge del metadato de la página.
//Tira también de settings para saber las páginas donde hay forms de usuario.
//Sólo funciona con usuarios logueados y hace uso de save_update_user_data_form
//pasándole el userID del usuario logueado y el form_sections del metadato de la página.
//El setting de ids de páginas de perfil es: ids_pages_profiles
////////////////////////////////////////////////////////////////////////////////
public function save_update_user_data_form_pages(){

if( is_user_logged_in()){

 global $current_user;
 global $post;

 $userID= $current_user->ID;
 $pageID = (string)$post->ID;

 $user_manager_options = get_option( 'user_manager_option_name' );
 $idProfilePages = explode(',',$user_manager_options['ids_pages_profiles']); //Cogemos los IDs de páginas con forms de usuario.

if(in_array($pageID,$idProfilePages) && ! empty($_POST)){ // estos ids los vamos a coger de los settings del plugin
   $json_string_forms = get_post_meta($post->ID,'forms_sections',true);//Cojemos los form_sections del metadato de la página.
	 $thispage_form_sections = $this->json_to_forms_sections($json_string_forms);

	 $page_form_udpate_errors = new WP_Error();
	 $this->user_manager_wp_error_validation($page_form_udpate_errors, $thispage_form_sections,$info_fields = array('user_data_key','relevance'));

	 if(count($page_form_udpate_errors->errors) == 0){
			$this->save_update_user_data_form($userID, $thispage_form_sections);
			return true;
			}else{
			return false;
			}
	}
 }
}

/////////////////////////////////////////////////////////////////////////////////
//función que crea un usuario y guarda los metadatos del form.
//La creación guardado de datos lo realiza llamando a create_save_update_user_data_form
//los forms los coge del metadato de la página.
//si se dispara o no, lo coge del array de ids que está en el setting: ids_pages_inclinicpostopdata
//Esta función está hookeada a WP
////////////////////////////////////////////////////////////////////////////////

public function create_save_update_user_data_form_pages(){
global $post;

$pageID = (string)$post->ID;

$user_manager_options = get_option( 'user_manager_option_name' );
$idInClinicPostOpPages = explode(',',$user_manager_options['ids_pages_inclinicpostopdata']) ;

if(in_array($pageID,$idInClinicPostOpPages) && ! empty($_POST)){ //Ya estamos posteando los resultados. Estos ids los vamos a coger de los settings del plugin
//si es la primera vez que se postea el user_login está vacío y el usuario no se ha creado. Si no es la primera ya hay user_login.
  if(isset($_POST['user_login'])&&($_POST['user_login']=='')){
     $userID = 0;
   }else{
    $userPData = get_userdatabylogin($_POST['user_login']);
    $userID = $userPData->ID;
  }

  $json_string_forms = get_post_meta($post->ID,'forms_sections',true);
  $thispage_form_sections = $this->json_to_forms_sections($json_string_forms);
  $page_form_udpate_errors = new WP_Error();
  $this->user_manager_wp_error_validation($page_form_udpate_errors, $thispage_form_sections,$info_fields = array('user_data_key','relevance'));
  if(count($page_form_udpate_errors->errors) == 0){
      $this->create_save_update_user_data_form($userID, $thispage_form_sections);
			return true;
      }else{
      return false;
      }
  }
}


      /*-- Fin de nuestra función twekeada --*/


		//function for updating the user_metadata with the signup keys added in the registration
		//hookeada como no podia ser de otro modo a wpmu_activate_user


//////////////////////////////////////////////////////////////////////////////
//Función definida para saltar con el hook filter wpmu_activate_user
//al recibir el $meta identifica el nc_register_meta y lo recorre creando
//el user_metadata con las user_data_keys
//////////////////////////////////////////////////////////////////////////////
public function custom_register_new_user_meta(  $user_id, $email, $meta ) {

 if ( count($meta['nc_register_meta']) ) {
	// loop through array of custom meta fields
  foreach ( $meta['nc_register_meta'] as $key => $value ) {
	// and set each one as a meta field
	///////INI modficación para gestión de IDvsNames///////////
	if(in_array($key,array("post_modelIOL","post_clinicSx"))){
		if($key == 'post_modelIOL'){
			 $idEqInputA = get_page_by_title( $value,  ARRAY_N, _x('lente-intraocular','CustomPostType Name','iol') );
			 }
		if($key == 'post_clinicSx'){
			$idEqInputA = get_page_by_title( $value,  ARRAY_N, _x('clinica','CustomPostType Name','clinica') );
			 }

		if(is_numeric($idEqInputA[0])){
			update_user_meta( $user_id, $key, $idEqInputA[0] );
			}else{
			update_user_meta( $user_id, $key, $value );
			}
	}else{
				update_user_meta( $user_id, $key, $value );
	}
  ///////FIN modficación para gestión de IDvsNames///////////
	 }
 }
}

////////////////////////////////////////////////////////////////////////////////
//función que devuelve el user_data_key de los form_sections del objeto instanciado
////////////////////////////////////////////////////////////////////////////////
private function get_user_fields_in_form_section($forms_sections){ //$this->forms
				return $this->get_user_form_info_in_form_section($forms_sections,'user_data_key' );//$nc_form_section_fields;
}

////////////////////////////////////////////////////////////////////////////////
//función que hace una query a los form_sections y que devuelve la lista de valores
//únicos del campo(columna) solicitado.
////////////////////////////////////////////////////////////////////////////////
public function get_user_form_info_in_form_section($forms_sections,$info_key){

global $wpdb;

$nc_form_section_fields = array();
if(count($forms_sections)){
	foreach($forms_sections as $form_section){
		if($form_section['section'] != NULL){
   			$condSection = "and section='".$form_section['section']."'";
   			}else{
   				$condSection ='';
   			}
 $nc_form_section_fields_temp = $wpdb->get_col(
																						"SELECT `".$info_key."`
																						 FROM  nc_userdata
																										where `form` = '".$form_section['form']."'
																												and `user_data_key` !=''
																												".$condSection."
    																										group by `form`,`section`,`".$info_key."`
    																										order by `id`"
																						   );
 $nc_form_section_fields = array_merge($nc_form_section_fields,$nc_form_section_fields_temp);
		}
 }
return $nc_form_section_fields;
}




////////////////////////////////////////////////////////////////////////////////
//función que te devuelve las user_data_key junto con los valores que desees para
//los forms sections que pases.
//Esta función es utilizada al parecer por el chequeador de errores.
/////////////////////////////////////////////////////////////////////////////////
public function get_user_fields_info_in_form_section($forms_sections,$array_info = NULL){ //$this->forms

global $wpdb;

$nc_form_section_info_fields = array();
if(count($array_info) > 0){
 	 $query_array_info = 	','.implode(',',$array_info);
	}else{
	 $query_array_info='';
	}
if($forms_sections != NULL){
	foreach($forms_sections as $form_section){
		if($form_section['section'] != NULL){
  		 $condSection = "and section='".$form_section['section']."'";
   		}else{
   		 $condSection ='';
   		}
	  $nc_form_section_fields_info_temp = $wpdb->get_results(
																													"SELECT `user_data_key`".$query_array_info."
																													 FROM  nc_userdata
																														where `form` = '".$form_section['form']."'
																																	and `user_data_key` !=''
																																	".$condSection."
    																															group by `form`,`section`,`user_data_key`".$query_array_info." "
																						);
	  $nc_form_section_info_fields = array_merge($nc_form_section_info_fields,$nc_form_section_fields_info_temp);
	 }
	}else{
				$nc_form_section_fields_info_temp = $wpdb->get_results(
																													"SELECT `user_data_key`".$query_array_info."
																													 FROM  nc_userdata
																														where 1=1
																																	and `user_data_key` !=''
    																															group by `form`,`section`,`user_data_key`".$query_array_info." "
																						);
				$nc_form_section_info_fields = $nc_form_section_fields_info_temp;
				}
 return $nc_form_section_info_fields;
}


		//function for getting all the user_inputs (and titles) within the form.


////////////////////////////////////////////////////////////////////////////////
//función para obtener todos los registros (tanto inputs como títulos) de los
//form sections pasados.
////////////////////////////////////////////////////////////////////////////////
private function get_user_inputs_labels_in_form_section($array_form_sections){

global $wpdb;


$nc_userdata = array();
if(count($array_form_sections)){

	foreach($array_form_sections as $form_section){
		$condSection = '';
   	if($form_section['section'] != ''){




   			$condSection = "and section='".$form_section["section"]."'";
   			}
   		$form_user_data_query = "	SELECT `id`,`form`,`section`,`user_role`,`category`,`html_info`,`question_key`,`input_type`,`record_type`,
																									 `key`,`parent`,`condition`,`user_data_key`,`user_data_key_value`,`relevance`
																						FROM nc_userdata
																									WHERE form = '".$form_section['form']."'
																									".$condSection." ";//,`es_ES`



   		$nc_userdata_temp = $wpdb->get_results($form_user_data_query);
   		$nc_userdata = array_merge($nc_userdata,$nc_userdata_temp);
   	}
 }
 return $nc_userdata;
}




////////////////////////////////////////////////////////////////////////////////
//Esta función se usa para validar el signup. Igual que en el caso de add_signup_meta
//no sabemos cuando se dispara este filter...Si siempre, o solo cuando WP hace el
//built in signup.
public function user_manager_signup_validation_this_object($arguments){
					$argumens = $this->user_manager_signup_validation($arguments, $this->forms);
					return $arguments;
					}

					//We have to do the same with the update profile option.

					//This action hook is only worth for stoping edition. You will not be able to get WP_Error object from the edit profile or show profile hooks.
					public function user_manager_edit_profile_validation_this_object($errors, $update, $user){
						//$errors->add('demo_error',__('This is a demo error, and will halt profile save'));
						//We are going to add more specific

							//we are going to put forms_sections

							$this->user_manager_wp_error_validation($errors, NULL, array('user_data_key','relevance'));

						}



////////////////////////////////////////////////////////////////////////////////
//Función para añadir la validación, la variable $arguments tiene que tener una clave errors.
////////////////////////////////////////////////////////////////////////////////
public function user_manager_signup_validation($arguments,$forms_sections)
			{
				$info_fields = array('user_data_key','relevance');
				$errors = $arguments['errors'];
				$this->user_manager_wp_error_validation($errors,$forms_sections,$info_fields);
    return $arguments;
			}





////////////////////////////////////////////////////////////////////////////////
//función core de validación, pilla como parámetro un objeto WP_Error y los form_sections a analizar.
//valida contra el $_POST object.
//Tip: aquí tenemos el siguiente problema con el checkbox. Cuando el checkbox no está seleccionado, no postea el name del checkbox.
public function user_manager_wp_error_validation($ncWP_Error, $forms_sections,$info_fields = array('user_data_key','relevance')){

$fields_info_to_validate = $this->get_user_fields_info_in_form_section($forms_sections,$info_fields); //$this->forms

foreach($fields_info_to_validate as $field_info_object){
	if(isset($_POST[$field_info_object->user_data_key]) && ($field_info_object->relevance!='')){
			switch ($field_info_object->relevance){
							case 'compulsory':
									if( empty( $_POST[$field_info_object->user_data_key] ) ){
												$ncWP_Error->add( $field_info_object->user_data_key, '('.$field_info_object->user_data_key.')1 Recuerde que la siguiente información es obligatoria');//'Recuerde que '.$field_info_object->user_data_key.' es un campo obligatorio. <br />'
										}
							break;
						  case 'compulsory_email':
									 if( empty( $_POST[$field_info_object->user_data_key] ) ){
											 $ncWP_Error->add( $field_info_object->user_data_key, '('.$field_info_object->user_data_key.') 2 Recuerde que la siguiente información es obligatoria');//'Recuerde que '.$field_info_object->user_data_key.' es un campo obligatorio. <br />'
											 }
									 if (!filter_var($_POST[$field_info_object->user_data_key], FILTER_VALIDATE_EMAIL)) {
											 $ncWP_Error->add( $field_info_object->user_data_key, 'Dirección de email inválida');
											 }
			 				break;
				}
	}
	//Ahora vamos a hacer el check de que el user_key_name correspondiente al checkbox tenía que estar aquí.
	if(!isset($_POST[$field_info_object->user_data_key]) && ($field_info_object->relevance == 'compulsory')){
			if($field_info_object->user_data_key != "privacy_agree"){ //Temporal ARTURO
											$ncWP_Error->add( $field_info_object->user_data_key, '('.$field_info_object->user_data_key.')3 Recuerde que la siguiente información es obligatoria');//'Recuerde que '.$field_info_object->user_data_key.' es un campo obligatorio. <br />'
			}
 	 }
 }
return $ncWP_Error;
}









   	//function for custom user_data_form validation.


   	//function for custom user_data_form output
   	//This function will be outputing a form containing all the inputs comprised in an array of associative arrays with form and section info.


////////////////////////////////////////////////////////////////////////////////
//Función que hace display y validación de form_sections para un usuario que está
//logueado no hace guardado/actualización registro alguno... Esto hace suponer que
//que se usa en conjunción con los save_update_user_data_form_pages y create_save_update_user_data_form_pages
////////////////////////////////////////////////////////////////////////////////
function generate_custom_user_data_form_shortcode($atts){

global $current_user;
extract(shortcode_atts( array(
															'forms_sections' => '', //[{"form": "form1_name","section": "sectionform1_name"}, {"form": "form2_name","section": "sectionform2_name"},.....]
        											'attr_2' => 'attribute 2 default',
    													), $atts ));

$forms_sections_to_generate = $this->json_to_forms_sections($forms_sections);

if (!is_user_logged_in() ) {
	return ;
	}
//vamos a poner aquí la validación del update.
if(!empty($_POST)){
	 $this_form_errors = new WP_Error();
	 $this->user_manager_wp_error_validation($this_form_errors, $forms_sections_to_generate,$info_fields = array('user_data_key','relevance'));
	 if(count($this_form_errors->errors) > 0){
			echo '<div class="error">No se ha podido llevar a cabo la actualización...<br />En rojo los campos que lo han impedido.<br /> Si no rellena un valor correcto se mantendrán los valores anteriores.</div>';
   }else{
		 echo '<div class="correct">La actualización se ha realizado correctamente</div>';
		}
 }

$user_meta_form = '';
//Vamos a poner un ID  al form correspondiente.
if( $forms_sections_to_generate[0]["form"]){
		$form_ref = $forms_sections_to_generate[0]["form"];
	}else{
		$form_ref = '';
	}
	$user_meta_form .= '<form id="'.$form_ref.'" class="user-manager-form" action="'.get_permalink().'" method="POST">';
  $user_meta_form .= $this->get_user_data_form($current_user,$forms_sections_to_generate);
  $user_meta_form .= '<input type="submit" value="Save/Guardar"/>';
	$user_meta_form .= '</form>';
return $user_meta_form;
}

/*-- Este es el shortcode para crear el usuario si no está creado y para meter los datos. --*/

/////////////////////////////////////////////////////////////////////////////////
//Este es el shortcode para hacer display y la validación de los forms_sections
//pasados como atributo.
//Nota: no hace guardado alguno de info y tampoco veo que procese el GET...
//Está aguas abajo del WP con lo que puede identificar que el user_login ya está puesto.
/////////////////////////////////////////////////////////////////////////////////
function create_and_generate_custom_user_data_form_shortcode($atts){

$current_user = null;

if( isset($_POST['user_login'])&&($_POST['user_login']=='') ){
  }else{
    $current_user= get_user_by('user_login',$_POST['user_login']);
  }
extract(shortcode_atts( array(
                              'forms_sections' => '',
                              'attr_2' => 'attribute 2 default',
                             ), $atts ));

$forms_sections_to_generate = $this->json_to_forms_sections($forms_sections);

if (!is_user_logged_in() && empty($_POST) && empty($_GET)) {
		//si el usuario no está logueado y no está posteando ni tiene valores en el GET es que no debería estar aquí.
		$notStandard = '<p style="color:red;">Sentimos decirle que este formulario no está disponible en estos momentos:</p>';
		$notStandard .= '<ul><li>Recuerde que si está en una clínica un profesional habrá de haberse logueado previamente.</li>';
		$notStandard .= '<li>Si usted es un paciente que está rellenando este formulario, póngase en contacto con el profesional que le ha enviado el link.</li></ul>';
		return $notStandard;
    	}

if(!is_user_logged_in() && empty($_POST) ) { //Si no, sólo con link no se salva.
  $user_meta_form = '';
  //Vamos a poner un ID  del form correspondiente.
  if($forms_sections_to_generate[0]["form"]){
    $form_ref = $forms_sections_to_generate[0]["form"];
    }else{
      $form_ref = '';
    }

  $user_meta_form .= '<form id="'.$form_ref.'" class="user-manager-form" action="'.get_permalink().'" method="POST">';
  $user_meta_form .= $this->get_user_data_form($current_user,$forms_sections_to_generate);
  $user_meta_form .= '<input type="submit" value="Save/Guardar"/>';
  $user_meta_form .= '</form>';

  return $user_meta_form;
}

//vamos a poner aquí la validación del update.
if(!empty($_POST)){
//aquí en teoría ya habrá saltado el wp y tendremos el user creado independientemente de que haya llenado o no correctamente los campos.
//la questión es podemos añadir desde el wp hook valores al $_POST ?

$this_form_errors = new WP_Error();
$this->user_manager_wp_error_validation($this_form_errors, $forms_sections_to_generate,$info_fields = array('user_data_key','relevance'));

if(count($this_form_errors->errors) > 0){
  echo '<div class="error">No se ha podido llevar a cabo la actualización...<br />En rojo los campos que lo han impedido.<br /> Si no rellena un valor correcto se mantendrán los valores anteriores.</div>';
}else{
			if(!(empty($_POST)) && (isset($_POST['nc_user_form_id']))){
					$id_Form = $_POST['nc_user_form_id'];
				 }else{
							 $id_Form = 'today';
							}
					//aquí pondremos un mensaje tipo, alvo que quiera editar algo etc...
          echo '<div class="correct-single-patient-form">El cuestionario se ha rellenado correctamente. Gracias, ya puede salir del website. <br /> El id del cuestionario es: '.$id_Form.'</div>';

					echo '<div class="button-patient-form-wrapper">';
					echo '<div class="patient-form-ok"><button>Ok</button></div>';
					echo '<div class="patient-form-edit"><button>Un momento quiero cambiar una respuesta! </button></div>';
					echo '</div>';

					echo '<div class="patient-form-message">Salvo que haga click en el botón de cambio de respuesta este formulario se bloqueará en <span class="segs"> </span> segundos</div>';

					echo '<script>';
					echo 'function replacer(){jQuery("form.user-manager-form").html("<div class=\"patient-form-bloqued\">Cuestionario guardado correctamente, Gracias!!</div>");}';
					echo 'jQuery(document).ready(function(){var counter = 15;stop = 0;';
					echo 'var interval = setInterval(function() {counter--;jQuery("span.segs").html(counter);';
				  echo 'if ((counter == 0) && (stop == 0)){replacer(); jQuery("div.patient-form-message,.form-progress-bar").remove();}';
					echo 'if(stop !=0 ){ clearInterval(interval);jQuery("div.patient-form-message,.form-progress-bar").remove();}}';
					echo ', 1000);});';
					echo 'jQuery("div.patient-form-ok button").on("click",function(){ jQuery("div.patient-form-message, p.introTest").remove();replacer();});';
					echo 'jQuery("div.patient-form-edit button").on("click",function(){ stop = 1;jQuery("div.patient-form-message").remove();});';
					echo '</script>';
    }
}

$user_meta_form = '';

  //Vamos a poner un ID  del form correspondiente.
if( $forms_sections_to_generate[0]["form"]){
   $form_ref = $forms_sections_to_generate[0]["form"];
  }else{
    $form_ref = '';
    }

$user_meta_form .= '<form id="'.$form_ref.'" class="user-manager-form" action="'.get_permalink().'" method="POST">';
$user_meta_form .= $this->get_user_data_form($current_user,$forms_sections_to_generate);
$user_meta_form .= '<input type="submit" value="Save/Guardar"/>';
$user_meta_form .= '</form>';

return $user_meta_form;
}






function only_show_sx_defaults($atts){
global $current_user;
global $wpdb;
$htmlShow = '';
	if(is_user_logged_in()){
		$idUserToShow = $current_user->ID;
		$qShow = 'SELECT * FROM `nc_userprof_clinic` WHERE `user_prof_id` = '.$idUserToShow.' and default_value=1';
		$showResult = $wpdb->get_row($qShow);

		if(count($showResult)){
				$htmlShow .= '<ul>';
			if($showResult->clinic_id){

				$htmlShow .= '<li>Clínica asignada: <a href="'.get_permalink($showResult->clinic_id).'" class="noGotoMain">'.get_the_title($showResult->clinic_id).'</a>. </li>';
			}
			if($showResult->iol_id){

				$htmlShow .= '<li>Lente intraocular asignada: <a href="'.get_permalink($showResult->iol_id).'" class="noGotoMain">'.get_the_title($showResult->iol_id).'</a>.</li>';
			}

			$htmlShow .= '</ul>';
		}

	}

	return $htmlShow;

}







////////////////////////////////////////////////////////////////////////////////
//////Función para cambiar los valores por defecto.
////////////////////////////////////////////////////////////////////////////////




function only_change_sx_defaults($atts){

	global $current_user;
	global $wpdb;


//
if(is_user_logged_in() && ($current_user->ncusertype == 'prof')){
$htmlLink .= '<div id="change-defaults-wrapper">';
$htmlLink .= '<form id="change_sx_defaults" method="POST">';
$htmlLink .= '<label>Seleccione de sus centros, a cual quiere que se asigne:</label>';
//////////////////////////////////////////////////////////////////////////////////


$qGetUClinics = 'SELECT `clinic_id` FROM `nc_userprof_clinic` WHERE `user_prof_id` = '.$current_user->ID;
$clinics = $wpdb->get_col($qGetUClinics);

//Ahora pondremos por defecto la que está seleccionada por defecto.
$qDefaultUClinic = 'SELECT `clinic_id` FROM `nc_userprof_clinic` WHERE `user_prof_id` = '.$current_user->ID.' and default_value=1';
$defaultUClinic = $wpdb->get_var($qDefaultUClinic);



		if(!count($clinics)){
							$htmlLink .= 'Usted no tiene centros asignados, póngase en contacto con nosotros.';
			}else{
							$htmlLink .= '<select id="clinic_id" name="clinic_id">';
						foreach($clinics as $clinicID){
							$htmlLink .= '<option value="'.$clinicID.'" '.selected($defaultUClinic,$clinicID, false).'>'.get_the_title($clinicID).'</option>';
						}
						$htmlLink .= '</select>';
					}



/////////////////////////////////////////////////////////////////////////////////





$htmlLink .= '<br />';
$htmlLink .= '<label>Seleccione la lente implantada</label>';

$iolList = getAllIOLs();

$qDefaultUIol = 'SELECT `iol_id` FROM `nc_userprof_clinic` WHERE `user_prof_id` = '.$current_user->ID.' and default_value=1';
$defaultUIol = $wpdb->get_var($qDefaultUIol);
//var_dump($defaultUIol);


$htmlLink .= '<select id="linkgen_iol_id" name="iol_id">';
foreach ($iolList as $iol) {
//var_dump(selected($defaultUIol,$iol, false));
	$htmlLink .= '<option value="'.$iol.'" '.selected($defaultUIol,$iol, false).'>'.get_the_title($iol).'</option>';
}
$htmlLink .= '</select>';


//$htmlLink .= '<input type="text" id="linkgen_iol_id" name="iol_id" />';


////////////////////////////////////////////////////////////////////////////////////

$htmlLink .= '<input type="hidden" name="post_surgeonSx" value="'.$current_user->ID.'"/>';



//////////////////////////////////////////////////////////////////////////////////////

$htmlLink .= '<br />';


$htmlLink .= '<input type="submit" value="Guardar cambios" />';


$htmlLink .= '</form>';
$htmlLink .= '</div>';







}else{

$htmlLink .= 'Tiene que hacer login y ser un ususario de tipo profesional para poder editar su configuración.<br />';
$htmlLink .= 'Para que le aparezcan clínicas asociadas a su usuario tenemos que identificarle por seguridad.<br />';
$htmlLink .= 'Si quiere dar de alta una clínica para la obtención de datos póngase en contacto con nosotros<br />';

}








return $htmlLink;
}


///////////////////////////////////////////////////////////////////////////////////
function only_update_sx_defaults(){

	global $current_user;
	global $wpdb;

$htmlInfoUpdate = '';


if(is_user_logged_in() && ($current_user->ncusertype == 'prof')){
	if(!empty($_POST)){


$clinic_id = '';
$clinic_id = $_POST["clinic_id"];

//Empezamos por la clínica -> Es la que marca el default value en primera instancia.
if((isset($_POST["clinic_id"])) &&($clinic_id !='')){
			$qGetUClinics = 'SELECT `clinic_id` FROM `nc_userprof_clinic` WHERE `user_prof_id` = '.$current_user->ID;
			$clinics = $wpdb->get_col($qGetUClinics);

			if(!in_array($clinic_id, $clinics)){
					$htmlInfoUpdate .= 'Lo sentimos no hemos podido poner la clínica solicitada como clínica por defecto para su formularios "en clínica". <br />';
					$htmlInfoUpdate .= 'Vuelva a intentarlo, si el error persiste, póngase en contacto con nostros por favor';
				}else{
							//primero ponemos los default value del profesional a 0
							$qResetDefaultClinic = 'UPDATE `nc_userprof_clinic` SET  `default_value` = 0 where  `user_prof_id` = '.$current_user->ID.' ';
							//echo $qResetDefaultClinic;
							$wpdb->query($qResetDefaultClinic);
							//Luego ponemos el default value = 1 en la clínica correspondiente.
							$qUpdateClinic = 'UPDATE `nc_userprof_clinic` SET  `default_value` = 1 where  `user_prof_id` = '.$current_user->ID.' and `clinic_id` ='.$clinic_id.' ';
							//$htmlInfoUpdate.= $qUpdateClinic;
							//echo $qUpdateClinic;
							$wpdb->query($qUpdateClinic);
						}

}
//Ahora la lente => ponemos donde esté default value 1 el id de la lente y ya está
$iol_id = '';
$iol_id = $_POST["iol_id"];

if((isset($_POST["iol_id"])) &&($iol_id != '')){

	$qSetDefaultIol = 'UPDATE `nc_userprof_clinic` SET  `iol_id` = '.$iol_id.' where  `user_prof_id` = '.$current_user->ID.' and `default_value` = 1';

	//$htmlInfoUpdate.=$qSetDefaultIol;
	//echo $qSetDefaultIol;
	$wpdb->query($qSetDefaultIol);
	//Luego ponemos el default value = 1 en la clínica correspondiente.



}


return $htmlInfoUpdate;


	}
}

}
/////////////////////////////////////////////////////////////////////////////////////


function only_show_available_forms($atts){


	global $current_user;

	$htmlLink = '';
		if((is_user_logged_in()) && ($current_user->ncusertype == 'prof')){


			//Sacamos los formularios del setting.
			$user_manager_options = get_option( 'user_manager_option_name' );
			$idFormPages = explode(',',$user_manager_options['ids_pages_inclinicpostopdata']) ;

					if(!count($idFormPages)){

										$htmlLink .= 'No hay formularios preconfigurados, póngase en contacto con nosotros.';
						}else{


										$htmlLink .= '<ul class="estilada" id="info_page_patientform_id" >';
									foreach($idFormPages as $formPageID){
										$htmlLink .= '<li>'.get_the_title($formPageID).'</li>';
									}
									$htmlLink .= '</ul>';
								}
		}

		return $htmlLink;

}



/*-- --*/





   	public function json_to_forms_sections($forms_sections_string){
   		$parent = array('(',')');
			$brackets = array('[',']');
			$forms_sections_aux = str_replace($parent,$brackets,$forms_sections_string);
			return json_decode( $forms_sections_aux, true );
   		}

   	//Vamos con las funciones para poner el custom field data en las páginas de perfil.
   	/**
 		* Adds a box to the main column on the Post and Page edit screens.
 		*/
		function user_manager_add_meta_box() {

	$screens = array( 'page' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'user-manager-page-metadata',
			__( 'Forms & Sections in this page', 'user-manager' ),
			array($this,'user_manager_meta_box_callback'),
			$screen
		);
	}
		}


		/**
 		* Prints the box content.
 		*
 		* @param WP_Post $post The object for the current post/page.
 		*/
		function user_manager_meta_box_callback( $post ) {

			// Add a nonce field so we can check for it later.
			wp_nonce_field( 'user_data_save_meta_box_data', 'user_data_meta_box_nonce' );

			/*
	 		* Use get_post_meta() to retrieve an existing value
	 		* from the database and use the value for the form.
	 		*/
			$value = get_post_meta( $post->ID, 'forms_sections', true );

			echo '<label for="myplugin_new_field">';
			_e( 'Fill in JSON format the forms & sections you are going to include in this page.', 'myplugin_textdomain' );
			echo '</label> ';
		echo '<input type="text" id="user_data_forms_sections" name="forms_sections" value="' . esc_attr( $value ) . '" size="25" />';
		}

		/**
 		* When the post is saved, saves our custom data.
 		*
 		* @param int $post_id The ID of the post being saved.
 		*/
		function user_manager_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['user_data_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['user_data_meta_box_nonce'], 'user_data_save_meta_box_data' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.
	if ( ! isset( $_POST['forms_sections'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['forms_sections'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'forms_sections', $my_data );
		}

////////////////////////////////////////////////////////////////////////////////
//Función que hace output de formularios/secciones pasados como atributos.
//Cuando está posteado:
//	1- Crea un nombre de usuario con Rand(0,999)
//  2- Si está el input de user_data_key: ncsignup_alternative (de record_type= form)
//		 te hace signup del usuario metiendo en el array de metadatos los valores de los
//		 user_data_keys del form que esté definido en el campo user_data_key_value de
//		 ncsignup_alternative.
//  TIP: Para reutilizar esta función lo que haremos será que como attributo hay
//  que  pasar el user_data_key que contiene en su user_data_key_value el form con los
//	valores a cargar en el user_metadata
//	Funciones utilizadas:
//		- get_user_data_form
//		- get_user_fields_in_form_section
//	  - user_manager_wp_error_validation
////////////////////////////////////////////////////////////////////////////////
function create_quick_form_signup($atts){

$current_user = NULL;
//En el  home los atributos son: forms_sections=\'({\"form\":\"ncquicksignup_general\",\"section\":\"general\"})
$shortAtts = shortcode_atts( array(
                              		'forms_sections' => '',
																	'key_record_type_form' => 'ncsignup_alternative',//attr_2
                              		), $atts );
$user_meta_form = '';
$forms_sections_to_generate = $this->json_to_forms_sections($shortAtts['forms_sections']);
$key_record_type_form = $shortAtts['key_record_type_form'];

//$form_ref es el ID de referencia para el form.
if( $forms_sections_to_generate[0]["form"]){
      $form_ref = $forms_sections_to_generate[0]["form"];
   }else{
        	$form_ref = '';
   }
//$formUrl es la url del formulario
if(is_home()){
			 $formUrl = get_home_url();
				}else{
  		 $formUrl = get_permalink();
				}

$user_meta_form .= '<form id="'.$form_ref.'" class="user-manager-form" action="'.$formUrl.'" method="POST">';
//llamamos a get_user_data_form con $current_user = NULL
//Tip: La función get_user_data_form procesa información tanto del user como del $_POST.
$user_meta_form .= $this->get_user_data_form($current_user,$forms_sections_to_generate);
$user_meta_form .= '<input type="submit" disabled="true" value="'._x('Enviar','class-user-manager-userdata','user-manager-p').'"/>';
$user_meta_form .= '</form>';

//Ahora la validación de los datos  posteados.
if(!empty($_POST)){
//aquí en teoría ya habrá saltado el wp y tendremos el user creado independientemente de que haya llenado o no correctamente los campos.
//la questión es podemos añadir desde el wp hook valores al $_POST ?
 $this_form_errors = new WP_Error();
 $this->user_manager_wp_error_validation($this_form_errors, $forms_sections_to_generate,$info_fields = array('user_data_key','relevance'));

 if(count($this_form_errors->errors) > 0){
    $user_meta_form .= '<div class="error">'._x('No se ha podido enviar la información, por favor, compruebe que los campos están rellenadas y la política de privacidad aceptada.','class-user-manager-userdata','user-manager-p').'<br /></div>';
    }else{
			//A continuación vamos a hacer el signup del usuario en base al first_name Posteado.
			//Tenemos que crear un user_name on the fly: vamos a utilizar su nombre y añadirle un número aleatorio de 3 cifras (luego se va a poder loguear con el email en cualquier caso).
			$postedName = $_POST['first_name'];
			$userName = $postedName.rand(0,999);
			//Chequeamos la presencia del input "ncsignup_alternative" con record_type = form.
			//El user_data_key_value es [{"form":"ncquicksignup_general","section":"general"}]
			if(isset( $_POST[$key_record_type_form] ) ){//"ncsignup_alternative"=> ESTO HAY QUE AMPLIARLO A OTROS FORMS...pendiente
				//si está el valor anterior sabemos que se está posteando este form que requeriere un signup alternativo.
				//Hay que coger los user_fields del form utilizado (Posteado), no los del que se ha utilizado para instanciar la clase, es uno alternativo.
				$ncsignup_alternative_forms_sections =  json_decode(stripcslashes($_POST[$key_record_type_form]),true);//'ncsignup_alternative'
				$nc_user_fields = $this->get_user_fields_in_form_section($ncsignup_alternative_forms_sections);
			 }
 			 $userMeta = array();
			 //Recorremos los user_data_key que hay en el formulario y los cargamos en el array asociativo de metadatos $userMeta
			 foreach($nc_user_fields as $user_field){
				 if ( isset( $_POST[$user_field] ) ) {
							$nc_register_meta[$user_field] = $_POST[$user_field];
						}
				 }
			 $userMeta['nc_register_meta'] = $nc_register_meta;
			 //hacemos el signup con el $username generado automáticamente, el email Posteado y los metadatos cargados en $usermeta.
			 wpmu_signup_user( $userName, $_POST['user_email'],$userMeta);

			 $user_meta_formOK = '<div class="quickMensOk">';
			 $user_meta_formOK .= _x('La información se ha envíado correctamente. Tendrá un email con el siguiente paso para recibir la ayuda que necesite antes de su operación.','class-user-manager-userdata','user-manager-p');
			 $user_meta_formOK .= '<span>'._x('Saludos,<br /> el equipo de NuevoCristalino.','class-user-manager-userdata','user-manager-p').'</span>';
			 $user_meta_formOK .= '</div>';

			 $user_meta_form = $user_meta_formOK;
      }
  }
  return $user_meta_form;
}


//Vamos a meter aquí toda la lógica del cuestionario para no registrados.
// 1- Sabemos que es un post-op.
	//Tenemos que meter otro de lasik...
	//De momento cataratas (Catquest con tipo, modelo de lente más clínica)
	//CLE con el Postoperatorio de NC
	//ICL no tenemos  por el momento.
//Input con preguna de que te has operado if post sacando un shortcode differente.

/////////////////////////////////////////////////////////////////////////////////
//Función para permitir a usuarios no registrados crear un form.
//se crea un usuario al vuelo, es necesario un input reg_type = form con los form_sections
//los user_data_key se cargarán en el nc_register_meta de siempre y luego se pasarán
//a user_meta en la activación de la cuente.
//El hecho de tener el input form de clave noregq_check_form (pasada como atributo)
//hace que no haga falta que no se necesite una función en el wp.
////////////////////////////////////////////////////////////////////////////////
function create_noreg_form_signup($atts){

$current_user = NULL;
$shortAtts = shortcode_atts( array(
																		'forms_sections' => '',
																		'noregq_check_form' => 'noregq_check_form',
																		), $atts );
$user_meta_form = '';
$forms_sections_to_generate = $this->json_to_forms_sections($shortAtts['forms_sections']);
$noregq_check_form = $shortAtts['noregq_check_form'];

//Vamos a poner un ID  del form correspondiente.
if( $forms_sections_to_generate[0]["form"]){
	$form_ref = $forms_sections_to_generate[0]["form"];
}else{
	$form_ref = '';
}

if(is_home()){
		$formUrl = get_home_url();
}else{
		$formUrl = get_permalink();
}

$user_meta_form .= '<form id="'.$form_ref.'" class="user-manager-form" action="'.$formUrl.'" method="POST">';
$user_meta_form .= $this->get_user_data_form($current_user,$forms_sections_to_generate);
$user_meta_form .= '<input type="submit" value="'._x('Enviar','class-user-manager-userdata','user-manager-p').'"/>';
$user_meta_form .= '</form>';

//vamos a poner aquí la validación del update.
//Queremos estar seguros no sólo de que es POST sino de que lo que se está posteando ya es el form con los datos.
if(!empty($_POST) && !empty($_POST[$noregq_check_form])){ //noregq_check_form va a ser el key CLAVE puesto que nos va a permitir identificar la naturaleza non registered del  questionario
//aquí en teoría ya habrá saltado el wp y tendremos el user creado independientemente de que haya llenado o no correctamente los campos.
//la questión es podemos añadir desde el wp hook valores al $_POST ?

$this_form_errors = new WP_Error();
$this->user_manager_wp_error_validation($this_form_errors, $forms_sections_to_generate,$info_fields = array('user_data_key','relevance'));

if(count($this_form_errors->errors) > 0){
	$user_meta_form .= '<div class="error">'._x('No se ha podido enviar la información, por favor, compruebe que los campos están rellenadas y la política de privacidad aceptada.','class-user-manager-userdata','user-manager-p').'<br /></div>';
	}else{
	//aquí vamos a hacer el signup del usuario.
	//Es el único custom signup que tenemos hecho.
	//Tenemos que crear un user_name on the fly: vamos a utilizar su nombre y añadirle un número aleatorio de 3 cifras (luego se va a poder loguear con el email en cualquier caso).
	$postedEmail = $_POST['user_email'];
	$parts = explode("@", $postedEmail);
	$postedEmailName = $parts[0];
	$userName = $postedEmailName.rand(0,999);
	//visto lo visto hay que añadir el meta object aquí..Aquí no habrá hook wp leyendo el metadata con el form de los valores a guardar.
	//lo haremos todo aquí, la pregunta es como evitar que el usuario vuelva a hacer post.
	if(isset( $_POST[$noregq_check_form] ) ){ //"noregq_check_form"Ahora no será ncsignup_alternative sino: noregq_check_form
	//si está el valor anterior sabemos que no se está haciendo el signup correctamnete.
	//hay que coger los user_fields del form utilizado porque no los del que se ha utilizado para instanciar la clase, es uno alternativo.
		$ncsignup_alternative_forms_sections =  json_decode(stripcslashes($_POST[$noregq_check_form]),true);//antes estaba 'noregq_check_form' pero lo queremos dejar abierto
		$nc_user_fields = $this->get_user_fields_in_form_section($ncsignup_alternative_forms_sections);
	}
	$userMeta = array();
	foreach($nc_user_fields as $user_field){
		 if ( isset( $_POST[$user_field] ) ) {
				$nc_register_meta[$user_field] = $_POST[$user_field];
				}
		 }
	$userMeta['nc_register_meta'] = $nc_register_meta;
	wpmu_signup_user( $userName, $_POST['user_email'],$userMeta);

	$user_meta_formOK = '<div class="quickMensOk">';
	$user_meta_formOK .= _x('MUCHAS  GRACIAS POR HABER RELLENADO EL CUESTIONARIO DE SATISFACCIÓN','class-user-manager-userdata','user-manager-p');
	$user_meta_formOK .= _x('La información se ha envíado correctamente. Tendrá un email con el siguiente paso para recibir la ayuda que necesite antes de su operación.','class-user-manager-userdata','user-manager-p');
	$user_meta_formOK .= '<span>'._x('Saludos,<br /> el equipo de NuevoCristalino.','class-user-manager-userdata','user-manager-p').'</span>';
	$user_meta_formOK .= '</div>';

	$user_meta_form = $user_meta_formOK;
				//fin del script
	}
}
return $user_meta_form;

}





////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////














//vamos a crear ahora la función que genera el link para el form.

function create_link_to_patientform_generator($atts){

	global $current_user;
  global $wpdb;

	extract(shortcode_atts( array(
																					'forms_sections' => '', //[{"form": "form1_name","section": "sectionform1_name"},
																																	// {"form": "form2_name","section": "sectionform2_name"},.....]
																					'attr_2' => 'attribute 2 default',
																					), $atts ));

//Texto identificador de usuario profesional.

//Input para ofrecer registro//Anonimo

//Input con el form que quiere incluir.
//Input select con las clínicas que tiene asociadas.
//Input select con las lentes intraoculares. //Esta parte sí que tendrá lógica fuera de aquí.

//div con borde y padding donde dentro esté un link.
$htmlLink = '<div id="link-generator-wrapper">';
if(is_user_logged_in() && ($current_user->ncusertype == 'prof')){

$htmlLink .= '<label>'._x('Seleccione el formulario que quiere sea rellenado:','class-user-manager-userdata','user-manager-p').'</label>';
///////////////////////////////////////////////////////////////////////////////////


//Sacamos los formularios del setting.
$user_manager_options = get_option( 'user_manager_option_name' );
$idFormPages = explode(',',$user_manager_options['ids_pages_inclinicpostopdata']) ;


		if(!count($idFormPages)){

							$htmlLink .= _x('No hay formularios preconfigurados, póngase en contacto con nosotros.','class-user-manager-userdata','user-manager-p');
			}else{


							$htmlLink .= '<select id="page_patientform_id" name="page_patientform_id">';
						foreach($idFormPages as $formPageID){
							$htmlLink .= '<option value="'.$formPageID.'">'.get_the_title($formPageID).'</option>';
						}
						$htmlLink .= '</select>';
					}


}else{

	echo _x('Usted no está logueado como usuario profesional, sentimos decirle que no tiene acceso a este área. Con cualquier duda póngase en contacto con nosotros.','class-user-manager-userdata','user-manager-p').' <br />';
}


/////////////////////////////////////////////////////////////////////////////////////
$htmlLink .= '<br />';

if(is_user_logged_in() && ($current_user->ncusertype == 'prof')){
$htmlLink .= '<label>'._x('Seleccione de sus centros, a cual quiere que se asigne:','class-user-manager-userdata','user-manager-p').'</label>';
//////////////////////////////////////////////////////////////////////////////////


$qGetUClinics = 'SELECT `clinic_id` FROM `nc_userprof_clinic` WHERE `user_prof_id` = '.$current_user->ID;
$clinics = $wpdb->get_col($qGetUClinics);

		if(!count($clinics)){
							$htmlLink .= _x('Usted no tiene centros asignados, póngase en contacto con nosotros.','class-user-manager-userdata','user-manager-p');
			}else{
							$htmlLink .= '<select id="clinic_id" name="clinic_id">';
						foreach($clinics as $clinicID){
							$htmlLink .= '<option value="'.$clinicID.'">'.get_the_title($clinicID).'</option>';
						}
						$htmlLink .= '</select>';
					}


}else{

	echo _x('Usted no tiene centros asignados, póngase en contacto con nosotros.','class-user-manager-userdata','user-manager-p').' <br />';
}
/////////////////////////////////////////////////////////////////////////////////


if(is_user_logged_in() && ($current_user->ncusertype == 'prof')){


$htmlLink .= '<br />';
$htmlLink .= '<label>'._x('Seleccione la lente implantada','class-user-manager-userdata','user-manager-p').'</label>';

$iolList = getAllIOLs();

$htmlLink .= '<select id="linkgen_iol_id">';
foreach ($iolList as $iol) {
	$htmlLink .= '<option value="'.$iol.'">'.get_the_title($iol).'</option>';
}
$htmlLink .= '</select>';


////////////////////////////////////////////////////////////////////////////
$htmlLink .= '<br />';
$htmlLink .= '<label for="u_email">'._x('Incluya si lo desea el email del paciente (No es obligatorio, podrá utilizarlo para enviarle el link)','class-user-manager-userdata','user-manager-p').'</label>';
$htmlLink .= '<input type="text" id="u_email" name="u_email" />';
$htmlLink .= '<br />';

////////////////////////////////////////////////////////////////////////////////////

$htmlLink .= '<input type="hidden" name="post_surgeonSx" value="'.$current_user->ID.'"/>';



//////////////////////////////////////////////////////////////////////////////////////

$htmlLink .= '<br />';


$htmlLink .= '<button id="generateLink">'._x('Generar el Enlace','class-user-manager-userdata','user-manager-p').'</button>';


$htmlLink .= '<div id="generatedLink-wrapper">';

$htmlLink .= _x('Todavía no has generado el enlace para el paciente','class-user-manager-userdata','user-manager-p');

$htmlLink .= '</div>';

$htmlLink .= '</div>';


//Vamos a añadir a continuación la posibilidad de enviar por email el link anterior.

$htmlLink .= '<br />';

$htmlLink .= '<p>'._x('Enviar un email con el enlace a la dirección aportada:','class-user-manager-userdata','user-manager-p').' </p>';

$htmlLink .= '<button id="sendLink">'._x('Enviar el enlace por email a la dirección aportada.','class-user-manager-userdata','user-manager-p').' </button>';

$htmlLink .= '<br />';

}

return $htmlLink;

}






}



//echo do_shortcode("[TheChamp-Login]");
