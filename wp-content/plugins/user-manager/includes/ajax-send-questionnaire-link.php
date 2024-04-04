<?php

//Función ajax para obtener las IOLs por nombre.
add_action( 'wp_ajax_sendLink', 'sendLink' );
add_action( 'wp_ajax_nopriv_sendLink', 'sendLink' ); // need this to serve non logged in users


function sendLink(){

if( (!isset($_GET["u_email"])) || ($_GET["u_email"] == '')  ){

  echo _x('No ha rellenado la dirección de email de envío.','ajax-send-questionnaire-link','user-manager-p');
  wp_die();
}
//Si ha llegado hasta aquí es que el email era correcto.
$validEmail = $_GET["u_email"];

if (!filter_var($validEmail, FILTER_VALIDATE_EMAIL)) {
  echo _x('El email introducido no es correcto','ajax-send-questionnaire-link','user-manager-p');
  wp_die();
}

if( (!isset($_GET["linkToBeSent"])) || ($_GET["linkToBeSent"] == '')  ){
  echo _x('No ha generado el link correctamente','ajax-send-questionnaire-link','user-manager-p');
  wp_die();
}
$validLink = $_GET["linkToBeSent"];

//Si ha llegado hasta aquí es que tanto la dirección de email como el link son correctos.
//Empezamos con la función wp_mail

$mailTo = $validEmail;

$mailSubect = _x('Cuestionario de satisfacción de Cirugía Ocular','ajax-send-questionnaire-link','user-manager-p');

$mailMessage  = _x('Estimado paciente, en el siguiente link:','ajax-send-questionnaire-link','user-manager-p')."\n\n";
$mailMessage .=  $validLink."\n\n";
$mailMessage .= _x('podrá rellenar información sobre su visión actual.','ajax-send-questionnaire-link','user-manager-p')."\n\n";
$mailMessage .= _x('Muchas gracias por su colaboración.','ajax-send-questionnaire-link','user-manager-p');

if(wp_mail( $validEmail , $mailSubect, $mailMessage )){
  echo _x('El email se ha enviado correctamente','ajax-send-questionnaire-link','user-manager-p');
}else{
  echo _x('El email no se ha podido enviar con éxito, proceda a enviar el link manualmente','ajax-send-questionnaire-link','user-manager-p');
}
wp_die();




}?>
