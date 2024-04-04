<?php

//Función ajax para obtener las IOLs por nombre.
add_action( 'wp_ajax_getLink', 'getLink' );
add_action( 'wp_ajax_nopriv_getLink', 'getLink' ); // need this to serve non logged in users




function getAllIOLs(){

	$iolArgs = array(
													'post_type'=> _x('lente-intraocular','CustomPostType Name','iol'),
													'posts_per_page' => -1,
													'orderby' => 'post_title',
													'order'=> 'ASC'
													);

	$iolQuery =  new WP_Query($iolArgs);

	$iolList = wp_list_pluck( $iolQuery->posts, 'ID' );//'ID'

	$iolListToReturn = array();


  foreach($iolList as $iolName){
  		array_push($iolListToReturn,$iolName);

  	}

		$iolUnspecified = 'Desconocida';

		//$clinicListToReturn = array_unshift($clinicListToReturn,$clinicUnspecified);

 //$clinicListToReturn = array_map(htmlentities,$clinicListToReturn);

	$iolListToReturn = [$iolUnspecified] + $iolListToReturn;


	return $iolListToReturn;

	}


function getLink(){

global $current_user;
global $wpdb;
$urlToReturn = '';

if(!isset($_GET["page_form_ID"])){
  return '<span>'._x('No ha seleccionado un formulario válido','ajax-link-generator','user-manager-p').'</span>';
}else{

$urlToReturn = get_permalink($_GET["page_form_ID"]).'?';

$clinic_id ='';
 if(isset($_GET["clinic_id"])){
	 $clinic_id = $_GET["clinic_id"];

 //$urlToReturn .= urlencode(base64_encode("clinic_id"));
 //$urlToReturn .= '='.urlencode(base64_encode($_GET["clinic_id"])).'&';
 }
$iol_id ='';
 if(isset($_GET["iol_id"])){
	 $iol_id = $_GET["iol_id"];
}


$u_email='';
if(isset($_GET["u_email"])){
	$u_email = $_GET["u_email"];
}

 	//		$urlToReturn .= urlencode(base64_encode("sxs_id"));
 	//		$urlToReturn .= '='.urlencode(base64_encode($current_user->ID)).'&';
			$sxs_id = $current_user->ID;

$wpdb->insert('questionnaires_sent', array(
							'sxs_id' => $sxs_id,
							'clinic_id' => $clinic_id,
							'iol_id' => $iol_id,
							'u_email' => $u_email
							));

$lastQuestionnaireID = $wpdb->insert_id;

$urlToReturn .= urlencode(base64_encode('idq')).'='.urlencode(base64_encode($lastQuestionnaireID));

}

echo $urlToReturn;

die();
}
?>
