<?php


//SHORTCODE related: form_signup
function create_form_signup($atts)
{
    $user_data = array(
                        'ncusertype'      => '',
                        'user_login'       => '',
                        'user_pass'       => '',
                        'user_passcheck'  => '',
                        'user_email'      => '',
                        'p_preOrPost'     => '',
                        'p_sxInteres'     => '',
                        'user_country'    => '',
                        'user_region'     => ''
                      );

    $signup_form ='';

    $arraySxOptions = array(
                           'p_sxInteres_Cat'    =>  _x('Operación de Cataratas', 'nc_login_registration', 'nc-login-registration'),
                           'p_sxInteres_Cle'    =>  _x('Operación de cristalino sin catarata', 'nc_login_registration', 'nc-login-registration'),
                           'p_sxInteres_Icl'    =>  _x('Operación con ICL', 'nc_login_registration', 'nc-login-registration'),
                           'p_sxInteres_Other'  =>  _x('Otra Operación', 'nc_login_registration', 'nc-login-registration')
                         );

    $arrayCountryOptions = array(
                                'spain'     =>    _x('España', 'nc_login_registration', 'nc-login-registration'),
                                'mexico'    =>    _x('Méjico', 'nc_login_registration', 'nc-login-registration'),
                                'chile'     =>    _x('Chile', 'nc_login_registration', 'nc-login-registration'),
                                'colombia'  =>    _x('Colombia', 'nc_login_registration', 'nc-login-registration'),
                                'eeuu'      =>    _x('Estados Unidos', 'nc_login_registration', 'nc-login-registration'),
                                'uk'        =>    _x('Gran Bretaña', 'nc_login_registration', 'nc-login-registration'),
                                'germany'   =>    _x('Alemania', 'nc_login_registration', 'nc-login-registration'),
                                'austria'   =>    _x('Austria', 'nc_login_registration', 'nc-login-registration'),
                                'other'     =>    _x('Otro', 'nc_login_registration', 'nc-login-registration')
                              );

    if (is_home()) {
        $formUrl = get_home_url();
    } else {
        $formUrl = get_permalink();
    }


    //Antes de nada veo si se ha realizado ya un proceso de registro.
    if (!empty($_GET)) {
        if (array_key_exists('registration', $_GET)) {
            $message_ok = '';

            $message_ok = '<div class="quickMensOk">';
            $message_ok .= _x('Su usuario se ha creado correctamente. Habrá recibido un email para activar el usuario. De no ver el email en su bandeja de entrada no olvide chequear la carpeta spam.', 'nc_login_registration', 'nc-login-registration');
            $message_ok .= '<span>'._x('Saludos del equipo de NuevoCristalino.', 'nc_login_registration', 'nc-login-registration').'</span>';
            $message_ok .= '</div>';

            return $message_ok;
        }
    }

    //Veo si se han posteado datos y los proceso.
    if (!empty($_POST)) {
        $postProcess = processRegisterPostUserData($_POST);


        if ($postProcess == 'success') {
            header("Location: " . $_SERVER['REQUEST_URI'].'?registration=success');
        } else {
            $errors = $postProcess['errors'];
            $user_data = $postProcess['user_data'];

            $signup_form .= printPostProcessErrors($errors);
        }
    }

    $signup_form .= '<form id="nc_signup"  action="'.$formUrl.'" method="POST" class="user-manager-form">';

    $signup_form .= printNCFormatedInput('radio', 'ncusertype', '', '', '', 'Tipo de usuario del sistema', true, array('pat' => 'Paciente','prof'=>'Profesional'));

    $signup_form .= printNCFormatedInput('text', 'user_login', $user_data['user_login'], 'Nombre de Usuario', '', 'Nombre de Usuario', true);
    $signup_form .= printNCFormatedInput('text', 'user_email', $user_data['user_email'], 'Email', '', 'Email', true);
    $signup_form .= printNCFormatedInput('password', 'user_pass', $user_data['user_pass'], 'Contraseña', 'half-left', 'Contraseña', true);
    $signup_form .= printNCFormatedInput('password', 'user_passcheck', $user_data['user_passcheck'], 'Repita Contraseña', 'half-right', 'Repita Contraseña', true);
    $signup_form .= '<div style="clear:both;">&nbsp;</div>';

    $signup_form .= printNCFormatedInput('select', 'user_country', $user_data['user_country'], 'País relacionado con la cirugía', '', false, true, $arrayCountryOptions);
    $signup_form .= printNCFormatedInput('text', 'user_region', $user_data['user_region'], 'Región', '', 'Región', true);

    $signup_form .= printNCFormatedInput('radio', 'p_preOrPost', $user_data['p_preOrPost'], '', '', '¿Te has operado ya?', true, array('p_preOrPost_Pre' => 'Todavía no me he operado','p_preOrPost_Post'=>'Ya me he operado'));
    $signup_form .= printNCFormatedInput('select', 'p_sxInteres', $user_data['p_sxInteres'], 'Operación en la que estás interesado', '', false, true, $arraySxOptions);

    $signup_form .= printNCRgpd();

    $signup_form .= '<input type="hidden" name="ncblogregistration" value="'.get_current_blog_id().'" />';

    $signup_form .= '<input type="submit"  value="'._x('Enviar', 'nc_login_registration', 'nc-login-registration').'" style="width:200px;margin-left:auto;margin-right:auto;"/>';
    $signup_form .= '</form>';

    return $signup_form;
}
