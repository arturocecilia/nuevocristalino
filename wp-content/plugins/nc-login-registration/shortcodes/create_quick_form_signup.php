<?php

//SHORTCODE related: quick_form_signup
function create_quick_form_signup($atts)
{
    //En el  home los atributos son: forms_sections=\'({\"form\":\"ncquicksignup_general\",\"section\":\"general\"})
    $shortAtts = shortcode_atts(array(
                                      'display' => 'home',
                                      'email_confirmation' => 'false',
                                      ), $atts);

    //$formUrl es la url del formulario
    if (is_home()) {
        $formUrl = get_home_url();
    } else {
        $formUrl = get_permalink();
    }

    $signup_form ='';
    $user_data = array(
                        'user_login'       => '',
                        'user_pass'       => '',
                        'user_passcheck'  => '',
                        'user_email'      => '',
                        'p_sxInteres'     => '',
                        'user_country'    => '',
                        'user_region'     => ''
                      );

    $arraySxOptions = array(
                           'p_sxInteres_Cat'   => _x('Operación de Cataratas', 'nc_login_registration', 'nc-login-registration'),
                           'p_sxInteres_Cle'   => _x('Operación de cristalino sin catarata', 'nc_login_registration', 'nc-login-registration'),
                           'p_sxInteres_Icl'   => _x('Operación con ICL', 'nc_login_registration', 'nc-login-registration'),
                           'p_sxInteres_Other' => _x('Otra Operación', 'nc_login_registration', 'nc-login-registration')
                         );

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




    $signup_form .= '<form id="ncquicksignup_general" class="user-manager-form" action="'.$formUrl.'" method="POST">';

    $signup_form .= printNCFormatedInput('text', 'user_login', $user_data['user_login'], 'Nombre de Usuario');
    $signup_form .= printNCFormatedInput('text', 'user_email', $user_data['user_email'], 'Email');

    $signup_form .= printNCFormatedInput('password', 'user_pass', $user_data['user_pass'], 'Contraseña', 'half-left');
    $signup_form .= printNCFormatedInput('password', 'user_passcheck', $user_data['user_passcheck'], 'Repita Contraseña', 'half-right');
    $signup_form .= printNCFormatedInput('select', 'p_sxInteres', $user_data['p_sxInteres'], 'Operación en la que estás interesado', '', false, false, $arraySxOptions);

    $signup_form .= printNCRgpd();

    //Doy por sentado la siguiente información => Tengo que cambiar el título.
    $signup_form .= '<input type="hidden" name="p_preOrPost" value="p_preOrPost_Pre" />';
    $signup_form .= '<input type="hidden" name="ncusertype" value="pat" />';
    $signup_form .= '<input type="hidden" name="ncblogregistration" value="'.get_current_blog_id().'" />';

    $signup_form .= '<input type="submit"  value="'._x('Enviar', 'nc_login_registration', 'nc-login-registration').'"/>';
    $signup_form .= '</form>';

    return $signup_form;
}
