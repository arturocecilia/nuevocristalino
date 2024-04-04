<?php



function processProfileEditionPostUserData($postData)
{
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $errors = [];

    $user_data_props = array(
                      'ncusertype',
                      'user_login',
                      'user_email',
                      'p_preOrPost',
                      'p_sxInteres',
                      'user_country',
                      'user_region',
                      'privacy_agree'
                    );



    if (!($current_user instanceof WP_User)) {
        $errors[] = _x('Lo sentimos, tiene que hacer login', 'nc_login_registration', 'nc-login-registration');
    }

    if (!array_key_exists('privacy_agree', $postData)) {
        $errors[] = _x('Tiene que aceptar la Política de Protección de Datos', 'nc_login_registration', 'nc-login-registration');
    }

    foreach ($user_data_props as $user_prop) {
        if (array_key_exists($user_prop, $postData)) {
            $userDataPostedValues[$user_prop] =   $postData[$user_prop];
        }

        if (in_array($user_prop, ['user_login','user_email'])) {
            $userDataPostedValues[$user_prop] = $current_user->{$user_prop};
        }
    }


    if (empty($errors)) {
        foreach ($user_data_props as $user_prop) {
            update_user_meta($user_id, $user_prop, $userDataPostedValues[$user_prop], get_user_meta($user_id, $user_prop, true));
        }
        return 'success';
    } else {
        return array(
                      'user_data' => $userDataPostedValues,
                      'errors' => $errors
                    );
    }
}
