<?php




//Vamos a customizar lo anterior en base a los applyfilters que usa...

add_filter( 'wpmu_signup_user_notification_subject', 'my_activation_subject', 10, 4 );

function my_activation_subject( $text ) {

//Here is where to input the new subject for the activation email:


if(in_array(get_locale(),array('es_ES','es_MX','es_CL','es_CO','de_DE','de_AT','en_GB','en_US','fr_FR'))){
  return _x('Comprobación de tu email (Activación de cuenta de NuevoCristalino)','user-email-manager','user-manager-p');
}

return 'Customize me: Your account needs activation.';
}



// Finally we hook into the email itself and run a function to modify the message.

add_filter('wpmu_signup_user_notification_email', 'my_custom_email_message', 10, 4);

function my_custom_email_message($message, $user, $user_email, $key) {

//Here is the new message:

$message ='';

if(in_array(get_locale(),array('es_ES','es_MX','es_CL','es_CO','en_GB','en_US','de_DE','de_AT','fr_FR'))){

global $wpdb;
$message = '';
$relatedOp = '';
$qDetectQuickReg = $wpdb->prepare( 'SELECT count(*) FROM {$wpdb->signups} WHERE `meta` like "%ncsignup_alternative%" and user_login = %s ',$user); //`wp_signups`
$isQuickReg = $wpdb->get_var($qDetectQuickReg);

$qDetectNonRegForm = $wpdb->prepare( 'SELECT count(*) FROM {$wpdb->signups} WHERE `meta` like "%noregq_check_form%" and user_login = %s ',$user); //`wp_signups`
$isNonRegForm = $wpdb->get_var($qDetectNonRegForm);



//var_dump($qDetectQuickReg);
$qIsCat = $wpdb->prepare( 'SELECT count(*) FROM {$wpdb->signups} WHERE  `meta` like "%p_sxInteres_Cat%" and user_login = %s ',$user);
$isCat = $wpdb->get_var($qIsCat);

if($isCat){
  $relatedOp = _x('Vemos que está relacionada con la operación de cataratas.','user-email-manager','user-manager-p');
}

$qIsCle = $wpdb->prepare( 'SELECT count(*) FROM {$wpdb->signups} WHERE `meta` like "%p_sxInteres_Cle%" and user_login = %s ',$user);
$isCle = $wpdb->get_var($qIsCle);
if(!$isCat && $isCle){
    $relatedOp = _x('Vemos que está relacionada con la operación de cristalino transparente.','user-email-manager','user-manager-p');
}
$qIsIcl = $wpdb->prepare( 'SELECT count(*) FROM {$wpdb->signups} WHERE  `meta` like "%p_sxInteres_Icl%" and user_login = %s ',$user);
$isIcl = $wpdb->get_var($qIsIcl);
if(!$isCat && !isCle && $isIcl){
      $relatedOp = _x('Vemos que está relacionada con la operación con lente ICL.','user-email-manager','user-manager-p');
}


$qIsOther = $wpdb->prepare( 'SELECT count(*) FROM {$wpdb->signups} WHERE  `meta` like "%p_sxInteres_Other%" and user_login = %s ',$user);
$isOther = $wpdb->get_var($qIsOther);


if($isQuickReg){
  $message .= _x("Estimado usuario, hemos recibido su solicitud de información.","user-email-manager","user-manager-p" )."  ".$relatedOp." \n\n";
  $message .= _x("En breve, un miembro del equipo de NuevoCristalino procederá a contactarte vía email para ver en que puede asistirte.","user-email-manager","user-manager-p" )." \n\n";
  $message .= _x("Solo por si deseas tener una cuenta para poder aprovechar todas las ventajas de NuevoCristalino (ver resultados de su operación en otros pacientes, preguntar a cirujanos, etc), te hemos generado un usuario:","user-email-manager","user-manager-p" )." \n\n";
  $message .= "   ".$user." \n\n";

}else{
  $message .= _x("Estimado usuario",'user-email-manager','user-manager-p')."  ".$user.",\n\n";
  $message .= _x("hemos recibido el cuestionario con tus datos básicos.",'user-email-manager','user-manager-p')."  \n\n";
}

$message .= sprintf(__(( "Para activar tu cuenta sólo tienes que clickear en el siguiente link:\n\n   %s\n\nDespués ya podrás acceder a tu área privada, preguntar a los cirujanos etc.\n\n" ),
$user, $user_email, $key, $meta),site_url( "wp-activate.php?key=$key" ));//site_url( "?page=gf_activation&key=$key" )
if($isQuickReg){
  $message .= _x("Si no deseas tener un usuario, ignora este mensaje. Si no lo activas, se borrará automáticamente.",'user-email-manager','user-manager-p')." \n\n";
}
  $message .= "\n\n "._x("Con cualquier duda, contáctenos a este email.",'user-email-manager','user-manager-p');

}else{
  $message .= sprintf(__(( "To activate your new account, please click the following link:\n\n%s\n\n After you activate you will be able to log in.\n\n" ),
  $user, $user_email, $key, $meta),site_url( "wp-activate.php?key=$key" ));//site_url( "?page=gf_activation&key=$key" )

}

//Mensaje específico para los que han rellenado el formulario postop.
if($isNonRegForm){
$message = _x("Necesitamos que clickees el link que te ponemos a continuación para que la encuesta que rellenaste pase a ser tenida en cuenta.",'user-email-manager','user-manager-p')." \n\n";
$message .=_x("En nombre de todos los pacientes que están valorando operarse desde el equpo de NuevoCristalino te damos las gracias.",'user-email-manager','user-manager-p')." \n\n";
$message .=_x("Para validar el formulario rellenado sólo tienes que clickear en este link:",'user-email-manager','user-manager-p');
$message .= sprintf(__(( "\n\n   %s\n\n" ),
$user, $user_email, $key, $meta),site_url( "wp-activate.php?key=$key" ));
$message .=_x("Gracias por tu tiempo.",'user-email-manager','user-manager-p');
$message .= "\n\n";
}


return $message;

}

// add the filter
add_filter( 'update_welcome_user_email', 'filter_update_welcome_user_email', 10, 4 );

function filter_update_welcome_user_email( $welcome_email, $user_id, $password, $meta ) {
global $wpdb;

    // make filter magic happen here...
    if(in_array(get_locale(),array('es_ES','es_MX','es_CO','es_CL','de_DE','de_AT','fr_FR','en_GB','en_US'))){
      //$welcome_email .= 'Mensaje de Nuevo+';
      //Vamos a personalizar el email de bienvenida. Meteremos la información obligatoria: user_email, user_login link to loging page and password.
      //Y además añadiremos info sobre: preOrpost, SxType, InteresType.


      $user =  get_user_by('ID', $user_id);
      $user_name =  $user->user_login;

//No sé por qué pero estos valores no parecen estar todavía asignados al usuario...

      $pre_or_post = get_user_meta($user_id, 'p_preOrPost',true);
      $sxInteres = get_user_meta($user_id, 'p_sxInteres',true);
      $tobeContacted = get_user_meta($user_id, 'p_interestToBeContacted',true);
      $aux_opText ='';
//Recurrimos por lo tanto a hacer consulta a la columna de meta de wpsignup.

//PARTE DE PREOP/POSTOP.

$qIsPre = $wpdb->prepare( 'SELECT count(*) FROM {$wpdb->signups} WHERE  `meta` like "%p_preOrPost_Pre%" and user_login = %s ',$user_name);
$isPre = $wpdb->get_var($qIsPre);

if($isPre){
  $pre_or_post = "p_preOrPost_Pre";
}

$qIsPost = $wpdb->prepare( 'SELECT count(*) FROM {$wpdb->signups} WHERE  `meta` like "%p_preOrPost_Post%" and user_login = %s ',$user_name);
$isPost = $wpdb->get_var($qIsPost);

if($isPost){
  $pre_or_post = "p_preOrPost_Post";
}



//PARTE DE CIRUGÍAS
$qIsCat = $wpdb->prepare( 'SELECT count(*) FROM {$wpdb->signups} WHERE  `meta` like "%p_sxInteres_Cat%" and user_login = %s ',$user_name);
$isCat = $wpdb->get_var($qIsCat);

if($isCat){
  $aux_opText = _x('de Cataratas','user-email-manager','user-manager-p');
}

$qIsCle = $wpdb->prepare( 'SELECT count(*) FROM {$wpdb->signups} WHERE `meta` like "%p_sxInteres_Cle%" and user_login = %s ',$user_name);
$isCle = $wpdb->get_var($qIsCle);
if(!$isCat && $isCle){
    $aux_opText = _x('de Cristalino transparente','user-email-manager','user-manager-p');
}
$qIsIcl = $wpdb->prepare( 'SELECT count(*) FROM {$wpdb->signups} WHERE  `meta` like "%p_sxInteres_Icl%" and user_login = %s ',$user_name);
$isIcl = $wpdb->get_var($qIsIcl);
if(!$isCat && !isCle && $isIcl){
      $aux_opText = _x('con lente ICL','user-email-manager','user-manager-p');
}



//

      $welcome_email ='';


      $welcome_email .= _x("Estimado usuario","user-email-manager","user-manager-p")." ".$user_name.", \n\n";
      $welcome_email .= _x("Tu cuenta de usuario en NuevoCristalino ya está configurada, puedes acceder con las siguientes credenciales:","user-email-manager","user-manager-p")."  \n\n";

      //Ahora metemos la información de acceso.
      $welcome_email .= _x("Usuario:","user-email-manager","user-manager-p")." ".$user_name."\n\n";
      $welcome_email .= _x("Clave/Contraseña:","user-email-manager","user-manager-p")." ".$password."\n\n";
      $welcome_email .= get_permalink(64)."\n\n"; //64 es el id de la página de login.
      //Ahora metemos los datos personalizados con if en función de la info aportada.

//$welcome_email.= 'TU INTERÉS ES: '.$sxInteres.'el user id es:'.$user_id;
//$welcome_email.= 'eL PREOP ES: '.$pre_or_post;


      //Recogemos la operación para sugerencia posterior de links.
      if($sxInteres && ($sxInteres != '') ){

        if($sxInteres == 'p_sxInteres_Cat'){
          $aux_opText = _x('de Cataratas','user-email-manager','user-manager-p');
        }

        if($sxInteres == 'p_sxInteres_Cle'){
          $aux_opText = _x('de Cristalino transparente','user-email-manager','user-manager-p');
        }

        if($sxInteres == 'p_sxInteres_Icl'){
          $aux_opText = _x('con lente ICL','user-email-manager','user-manager-p');
        }

      }

      //Notas sobre la operación y sugerencia de forms.
      if($pre_or_post && ($pre_or_post != '') ){
        if($pre_or_post == 'p_preOrPost_Pre'){
          $welcome_email.= sprintf(_x("Vemos que todavía no te has operado %s, si quieres, puedes rellenar tu información de antes de la operación:","user-email-manager","user-manager-p"),$aux_opText)."  \n\n";
          $welcome_email.= "\n\n".get_permalink(12628)."\n\n";
          $welcome_email.= "\n\n"._x("Te permitirá obtener un listado de lentes idóneas, dará más datos al cirujano que vaya a contestar tus dudas, tendrás contenidos más personlizados etc.","user-email-manager","user-manager-p")."\n\n";
        }

        if($pre_or_post == 'p_preOrPost_Post'){
          $welcome_email.= sprintf(_x("Vemos que todavía ya te has operado %s, si quieres, ayudarías a otros pacientes si rellenas el cuestionario de satisfacción tras la operación:","user-email-manager","user-manager-p"),$aux_opText)."  \n\n";
          $welcome_email.= "\n\n".get_permalink(12629)."\n\n";
          $welcome_email.= "\n\n "._x("Muchas gracias!!","user-email-manager","user-manager-p")."\n\n";
        }


      }




    }
    return $welcome_email;
}




/*
add_filter( 'wpmu_welcome_user_notification', 'bbg_wpmu_welcome_user_notification', 10, 3 );

function bbg_wpmu_welcome_user_notification($user_id, $password, $meta = '') {
    global $current_site;

    $welcome_email = get_site_option( 'welcome_user_email' );

    $user = new WP_User($user_id);

    $welcome_email = apply_filters( 'update_welcome_user_email', $welcome_email, $user_id, $password, $meta);

    // Get the current blog name
    $blogname = get_option( 'blogname' );
    $welcome_email = str_replace( 'SITE_NAME', $blogname, $welcome_email );

    $welcome_email = str_replace( 'USERNAME', $user->user_login, $welcome_email );
    $welcome_email = str_replace( 'PASSWORD', $password, $welcome_email );
    $welcome_email = str_replace( 'LOGINLINK', wp_login_url(), $welcome_email );

    $admin_email = get_site_option( 'admin_email' );

    if ( $admin_email == '' )
         $admin_email = 'support@' . $_SERVER['SERVER_NAME'];

    $from_name = get_site_option( 'site_name' ) == '' ? 'WordPress' : esc_html( get_site_option( 'site_name' ) );
    $message_headers = "From: \"{$from_name}\" <{$admin_email}>\n" . "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n";
    $message = $welcome_email;

    $subject = apply_filters( 'update_welcome_user_subject', sprintf(__('New %1$s User: %2$s'), $blogname, $user->user_login) );
    wp_mail($user->user_email, $subject, $message, $message_headers);

    return false; // make sure wpmu_welcome_user_notification() doesn't keep running
}

*/




 ?>
