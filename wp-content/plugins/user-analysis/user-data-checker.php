<?php

  /*Queremos una función que haga un audit de la información que ha rellenado el usuario.
  *Los cuestionarios son los siguientes:
  *Perfil básico de Usuario
  *Perfil completo de Usuario
  *Información Preoperatoria
  *Información Postoperatoria.
  */
  /*
  addProfileBasicData
  addPatProfileBasicData
  qpls
  prols*/

 //Esta función que devuelve información sobre si se ha rellenado o no un formulario determinado.
 //La información que devuelve depende del tipo de mensaje que se haya pasado como argumento.

 add_shortcode( 'checkifuserhassavedform', 'checkIfUserHasSavedForm' );
 function checkIfUserHasSavedForm($atts){ //$keyform,$outputtype

  $attAux = shortcode_atts( array(
        																'keyform' => '',
        																'outputtype' => '',
        // ...etc
    ), $atts );


    $keyform = $attAux['keyform'];
    $outputtype = $attAux['outputtype'];


  $output = '';

 if((is_user_logged_in()) && (in_array(get_locale(),array('es_ES','es_MX','es_CL','es_CO','en_GB','en_US','fr_FR','de_DE','de_AT')))){

 	//echo 'running';

 global $wpdb;
 $cUserId = get_current_user_id();

 if($outputtype == 'sternAudit'){
 	$relevance = 'and `relevance` in ("compulsory","convenient")';
	}else{
		$relevance = '';
	}

	if(($outputtype == 'standardMessage')||($outputtype == 'class')){
		$notOptional = 'and `relevance` not in ("optional")';
	}else{
		$notOptional = '';
		}


 if(get_user_meta( $cUserId, 'ncusertype', TRUE )=='pat'){
 	$arrayForms = array(
 											"basicProfile" => array("addProfileBasicData","addPatProfileBasicData"),
 											"qpls" => array("qpls"),
 										  "prols" => array("prols")
 											);
 	}

 if(get_user_meta( $cUserId, 'ncusertype', TRUE )=='prof'){
 	$arrayForms = array(
 											"basicProfile" => array("addProfileBasicData","addProfProfileBasicData"),
 											"qpls" => array("qpls"),
 										  "prols" => array("prols")
 											);
 	}

 if((get_user_meta( $cUserId, 'ncusertype', TRUE ) != 'prof') && (get_user_meta( $cUserId, ncusertype, TRUE ) != 'pat')){
			//el usuario no ha puesto que tipo de usuario es...
 	}

  $titleForms = array(
 											"basicProfile" => _x('Perfil básico de usuario','user-data-checker','user-analysis-p'),
 											"qpls" => _x('Información preoperatoria','user-data-checker','user-analysis-p'),
 										  "prols" => _x('Información postoperatoria','user-data-checker','user-analysis-p')
 											);
  $idForms = array(
											"basicProfile" => 12644,
 											"qpls" => 12628,
 										  "prols" => 12629
  );


$queryGetUserMetadataKeys =	'SELECT `user_data_key`
 														 FROM `nc_userdata`
																	WHERE `form` in ("'.implode(",",$arrayForms[$keyform]).'")
    																'.$relevance.'
    																'.$notOptional.'
      															and `input_type` = "input"
      															and `record_type` not in("autofilled")
 														 UNION
 														 SELECT distinct(`user_data_key`)
 														 FROM `nc_userdata`
 																	WHERE parent in(
			  																					SELECT `key`
				  																				FROM `nc_userdata`
					  																					WHERE `form` in ("'.implode("\",\"",$arrayForms[$keyform]).'")
    				  																							'.$relevance.'
    				  																							'.$notOptional.'
        			  																						and `input_type` = "radio")';

$userMetadataKeys = $wpdb->get_col( $queryGetUserMetadataKeys);

$numTotalInputs = count($userMetadataKeys);

//var_dump($userMetadataKeys);

$arrayKeysOk = array();
$arrayKeysEmpty = array();



	$sum = 0;
	$fail = 0;
		foreach($userMetadataKeys as $ukey){

			if(get_user_meta( $cUserId, $ukey, TRUE ) != ''){
				$sum+=1;
						$arrayKeysOk[$ukey] = get_user_meta( $cUserId, $ukey, TRUE );

				}else{
							$arrayKeysEmpty[$ukey] = '';
							$fail +=1;
					}
			}


		//Con el sum >= 0 ya vemos si al menos ha hecho un salvado.
		if($sum > 0){


			if($outputtype == 'standardMessage'){
			//Ha rellenado parcialmente el formulario, hay algunos que no son considerados opcionales y que no han sido rellenados.
				if($sum < $numTotalInputs ){
					//$output .=  '<style>.completely-filled, .partial-filled{  background: GREEN;width: 90%;color:white; border-radius:3px;padding-top:4px;padding-bottom:4px;text-align:center;}</style>';
					$datosPorRellenar = $numTotalInputs - $sum;
					$output .=  '<div class="partial-filled"><p>'.sprintf(_x('Bien, has rellenado parcialmente el cuestionario <strong style="color:green">%s</strong>, si lo deseas puedes','user-data-checker','user-analysis-p'),$titleForms[$keyform]).' <a href="'.get_permalink($idForms[$keyform]).'">'.sprintf(_x('rellenar las %s preguntas restantes','user-data-checker','user-analysis-p'),$datosPorRellenar).'</a>, '._x('que son:','user-data-checker','user-analysis-p').'';
					$output .=  '';
					$output .=  '<ul>';
									 foreach($arrayKeysEmpty as $keyNotOk => $value){
					 								$output .=  '<li>Pregunta: '._x($keyNotOk,'user_manager','user-manager').'  </li>';
											}
					$output .=  '</ul>';
					$output .=  '</p></div>';
					}
					//Ha rellenado todas preguntas del formulario.
				 if($sum == $numTotalInputs ){
					$output .=  '<div class="completely-filled"><p>'._x('Genial, has rellenado satisfactoriamente el cuestionario:','user-data-checker','user-analysis-p').' <strong style="color:green;">'.$titleForms[$keyform].'</strong></p></div>';
					}

				}

				//


			if($outputtype == 'normalAudit'){
				$output .=  _x('Los siguientes campos se han rellenado correctamente:','user-data-checker','user-analysis-p').'<br />';
				foreach($arrayKeysOk as $keyOk => $valueOk){
					 $output .=  sprintf(_x('Campo : %1$s rellenado con valor: %2$s ','user-data-checker','user-analysis-p'),$keyOk,$valueOk).' <br />';
					}
				$output .=  _x('Los siguientes campos no se han rellenado:','user-data-checker','user-analysis-p').' <br />';
				 foreach($arrayKeysEmpty as $keyNotOk => $value){
					 $output .=  sprintf(_x('Campo : %s no rellenado.','user-data-checker','user-analysis-p'), $keyNotOk).' <br />';
					}

				}

			if($outputtype == 'class'){
				if($sum < $numTotalInputs ){
						$output .=  $keyform.'_partial_ok';
				}
				if($sum == $numTotalInputs ){
						$output .=  $keyform.'_complete_ok';
				}
			}

			}else{

						if($outputtype == 'class'){
									$output .=  $keyform.'_not_ok';
							}

					  if($outputtype == 'standardMessage'){
									$output .=  '<div class="quickMessage-notok">'._x('Vaya, vemos que no has rellenado el cuestionario:','user-data-checker','user-analysis-p').' <a href="'.get_permalink($idForms[$keyform]).'">'.$titleForms[$keyform].'</a></div>';
			 				}

				}

		//Para el stern audit.
		if($fail > 0){

			if($outputtype == 'sternAudit'){
				echo _x('Los siguientes campos se han rellenado correctamente:','user-data-checker','user-analysis-p').'<br />';
				foreach($arrayKeysOk as $keyOk => $valueOk){
					 $output .=  sprintf(_x('Campo : %1$s rellenado con valor: %2$s ','user-data-checker','user-analysis-p'),$keyOk,$valueOk).' <br />';
					}
				echo _x('Los siguientes campos no se han rellenado:','user-data-checker','user-analysis-p').' <br />';
				 foreach($arrayKeysEmpty as $keyNotOk => $value){
					 $output .=  sprintf(_x('Campo : %s no rellenado.','user-data-checker','user-analysis-p'), $keyNotOk).' <br />';
					}

				}


			}

    //Ahora vamos para el optselector-> Vamos a poner el mínimo en 5 respuestas.
    if($sum > 5){

	  if($outputtype == 'linkiollist'){
      $output .= '<div class="linkToIolProSelector"><a href="'.get_permalink(13214).'">'._x('Ir a ver mi lista de lentes intraoculares','user-data-checker','user-analysis-p').'</a></div>';
      }

    }else{

      if($outputtype == 'linkiollist'){
        $output .= '<div class="warn" style="color:red;">';
        $output .= _x('No ha rellenado el número de campos mínimos de:','user-data-checker','user-analysis-p').' <a href="'.get_permalink(12628).'">'._x('Información preoperatoria','user-data-checker','user-analysis-p').'</a>, '._x('como para poder mostrarle lentes intraoculares de acuerdo a su perfil','user-data-checker','user-analysis-p').'.';
        $output .= '</div>';
        }

    }


	}else{
		return $output;
		}

	return $output;
}

 add_shortcode( 'profilechecker', 'profileChecker' );
//Esta función devuelve los mensajes de los forms correspondientes (usando la función de arriba) en función del tipo de chequeo y de las características del usuario.
 function profileChecker($atts){



 	  $output = '';



 	 if((is_user_logged_in()) && (in_array(get_locale(),array('es_ES','es_MX','es_CL','es_CO','de_DE','de_AT','en_GB','en_US','fr_FR')))){

 	 	$cUserId = get_current_user_id();

 	 	$userType = get_user_meta($cUserId,'ncusertype',TRUE);
 	 	$userSx = get_user_meta($cUserId,'p_sxInteres',TRUE);
 	 	$userPreOrPost = get_user_meta($cUserId,'p_preOrPost',TRUE);

 	  $attAux = shortcode_atts( array(
        																'checktype' => '',
         // ...etc
     ), $atts );

 	 	$checktype = $attAux['checktype'];


 	 	if($checktype == 'medinfo'){

 	 		if($userPreOrPost == 'p_preOrPost_Pre'){

 	 			 $output .= checkIfUserHasSavedForm(array("keyform"=>"qpls","outputtype"=>"standardMessage"));

 	 			}

 	 		if($userPreOrPost == 'p_preOrPost_Post'){

 	 			 $output .= checkIfUserHasSavedForm(array("keyform"=>"prols","outputtype"=>"standardMessage"));
 	 			}


 	 		}

 	  if($checktype == 'basicinfo'){



 	  	if($userType == 'pat'){

 	  		 $output .= checkIfUserHasSavedForm(array("keyform"=>"basicProfile","outputtype"=>"standardMessage"));
 	  		}

 	  	}

    if($checktype == 'optlinkiollist'){
      $output .= checkIfUserHasSavedForm(array("keyform"=>"qpls","outputtype"=>"linkiollist"));
    }


 	}else{
 			if(in_array(get_locale(),array('es_ES','es_MX','es_CL','es_CO','de_DE','de_AT','en_GB','en_US','fr_FR'))){
 					$output .= '<div class="notloggedmessage"><p>'.sprintf(_x('Necesitas <a href="%s">iniciar sesión/logearte</a>.','user-data-checker','user-analysis-p'),get_permalink(64)).', '.sprintf(_x('Si no estás registrado puedes <a href="%s"> registrarte de forma gratuita. </a>','user-data-checker','user-analysis-p'),get_permalink(66)).'</p></div>';
 				}
 		}

 	return $output;

 	}

//Función para mostrar información sobre los datos que ha dado el usuario
 add_shortcode( 'profileshowinfo', 'profileShowInfo' );
function profileShowInfo($atts){

	  $attAux = shortcode_atts( array(
        																'infotype' => '',
        																'outputtype' => '',
        // ...etc
    ), $atts );

    $infotype =  $attAux['infotype'];
    $outputtype = $attAux['outputtype'];


      $output = '';



 if((is_user_logged_in()) && (in_array(get_locale(),array('es_ES','es_MX','es_CL','es_CO','de_DE','de_AT','en_GB','en_US', 'fr_FR'))) ){






 	 	$cUserId = get_current_user_id();

 	 	$userType = get_user_meta($cUserId,'ncusertype',TRUE);
 	 	$userSx = get_user_meta($cUserId,'p_sxInteres',TRUE);
 	 	$userPreOrPost = get_user_meta($cUserId,'p_preOrPost',TRUE);

 					if($infotype == 'usertype'){
 								if($outputtype == 'literal'){
 											$output .= $userType;
 											return $output;
 									}
 						}

 					if($infotype == 'sxinteres'){
 								if($outputtype == 'literal'){
 											$output .= $userSx;
 											return $output;
 								}
			 		}

 					if($infotype == 'preorpost'){
 								if($outputtype == 'literal'){
								 			$output .= $userPreOrPost;
 											return $output;
 								}
 					}

 					if($infotype == 'generaluserinfo'){
 								if($outputtype == 'generaldescription'){
 									    $output .= '<p>';
 									    $output .= '<ul class="estilada">';
 											$output .= '<li>'._x('Tu tipo de usuario de NuevoCristalino es:','user-data-checker','user-analysis-p').' <strong>'._x($userType,'user_manager','user-manager').'</strong>.</li>';
 											$output .= '<li>'._x('Tu cirugía de interés principal es:','user-data-checker','user-analysis-p').' <strong>'._x($userSx,'user_manager','user-manager').'</strong>.</li>';
 											$output .= '<li>'._x('En relación al momento de la operación:','user-data-checker','user-analysis-p').' <strong>'._x($userPreOrPost,'user_manager','user-manager').'</strong>.</li>';
 											$output .= '</ul>';
 											$output .= '</p>';

 											return $output;
 									}


 						}



 	}else{
    //Con literal nos referíamos al valor del userkeyvalue en sí.
 		if($outputtype != 'literal'){
		 		if(in_array(get_locale(),array('es_ES','es_MX','es_CO','es_CL','en_GB','en_US','de_DE','de_AT','fr_FR'))){
 					$output .= '<div class="notloggedmessage"><p>'._x('Necesitas iniciar sesión/logearte. Si no estás registrado puedes','user-data-checker','user-analysis-p').' <a href="'.get_permalink(66).'">'._x('registrarte de forma gratuita','user-data-checker','user-analysis-p').'</a></p></div>';
 				}

 				}
 		}




	return $output;

	}




//función que aprovechando profileShowInfo nos devuelva información sobre el usuario paciente.
function user_info_class(){

  $userTypeClass = profileShowInfo(array( 'infotype' => 'usertype','outputtype' => 'literal'));



  $preOrPostClass =  profileShowInfo(array( 'infotype' => 'preorpost','outputtype' => 'literal'));
  $sxInteresClass = profileShowInfo(array( 'infotype' => 'sxinteres','outputtype' => 'literal'));


  echo ' '.$userTypeClass.' '.$preOrPostClass.' '.$sxInteresClass.' ';

}


//Función para poner que el usuario no está logueado.

function returnClassLogged(){
	$output = '';
	if(!is_user_logged_in() ){
		$output = 'not_logged';
	}else{
		$output = 'logged_in';
		}

		return $output;

	}




/*Este para las páginas: Mi perfil de nuevocristalino e Información sobre mis ojos*/

//standardMessage => Te dice cuantos campos de los no-opcionales has rellenado, si lo has rellenado todos

//normalAudit => Te informa de los campos rellenos y los no rellenos.

/**/
//sternAudit => Ve si hay inputs convenient o compulsory no rellenos.

/*Este dentro de la etiqueta clase de content*/
//class => te pone el nombre simplificado  del form más _ok y not ok, para poder dar estilo.
//echo 'dsfffffffffffff';
//checkIfUserHasSavedForm("basicProfile","quickMessage");//"normalaudit"
//echo checkIfUserHasSavedForm(array("keyform" =>"prols","outputtype"=>"standardMessage"));
//checkIfUserHasSavedForm("prols","quickMessage");

//echo profileChecker(array("checktype" => 'medinfo'));


//echo profileShowInfo(array('infotype'=>'usertype','outputtype'=>'literal')); //preorpost,sxinteres,usertype
?>
