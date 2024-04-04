<?php

function processRegisterPostUserData($postData)
{
    $errors = [];

    if (empty($postData['user_login']) || empty($postData['user_email'])) {
        $errors[] = _x('tiene que aportar un email y nombre de usuario correctos', 'nc_login_registration', 'nc-login-registration');//'provide a user and email';
    }

    //En todos los procesos de registro vienen estas informaciones bien aportadas o iferidas.
    $user_login          = $postData['user_login'];
    $user_email          = $postData['user_email'];
    $user_pass           = $postData['user_pass'];
    $user_passcheck      = $postData['user_passcheck'];

    if (array_key_exists('user_country', $postData)) {
        $user_country        = $postData['user_country'];
    } else {
        $user_country = 'N/A';
    }

    if (array_key_exists('user_region', $postData)) {
        $user_region         = $postData['user_region'];
    } else {
        $user_region = 'N/A';
    }


    $p_preOrPost         = $postData['p_preOrPost'];
    $ncusertype          = $postData['ncusertype'];
    $privacy_agree       = $postData['privacy_agree'];
    $ncblogregistration  = $postData['ncblogregistration'];


    if (!array_key_exists('privacy_agree', $postData)) {
        $errors[] = _x('Tiene que aceptar la Política de Protección de Datos', 'nc_login_registration', 'nc-login-registration');
    }

    $p_sxInteres = sanitize_text_field($postData['p_sxInteres']);
    $user_login = sanitize_user($user_login);
    $user_email = apply_filters('user_registration_email', $user_email);

    if (!is_email($user_email)) {
        $errors[] = _x('email no válido', 'nc_login_registration', 'nc-login-registration');//'invalid e-mail';
    } elseif (email_exists($user_email)) {
        $errors[] = _x('el email aportado ya está en uso', 'nc_login_registration', 'nc-login-registration');//'this email is already registered';
    }

    if (empty($user_login) || !validate_username($user_login)) {
        $errors[] = _x('nombre de usuario no válido', 'nc_login_registration', 'nc-login-registration');//'invalid user name';
    } elseif (username_exists($user_login)) {
        $errors[] = _x('el nombre de usuario aportado ya está en uso', 'nc_login_registration', 'nc-login-registration');//'user name already exists';
    }



    if (empty($errors)) {
        $user_id = wp_create_user($user_login, $user_pass, $user_email);

        if (!$user_id) {
            return ['registration failed...'];
        } else {
            //update_user_option($user_id, 'default_password_nag', true, true);
            wp_new_user_notification($user_id);


            //Añadimos los nc_user_data.
            update_user_meta($user_id, 'p_sxInteres', $p_sxInteres);
            update_user_meta($user_id, 'p_preOrPost', $p_preOrPost);
            update_user_meta($user_id, 'ncusertype', $ncusertype);
            update_user_meta($user_id, 'user_country', $user_country);
            update_user_meta($user_id, 'user_region', $user_region);
            update_user_meta($user_id, 'privacy_agree', $privacy_agree);

            update_user_meta($user_id, 'ncuserstatus', 0);

            //Función propia definida.
            sendUserActivationEmail($user_id, $ncusertype);

            wp_set_auth_cookie($user_id);

            return 'success';
        }
    } else {
        return array(
                      'user_data' => $postData,
                      'errors' => $errors
                    );
    }
}
