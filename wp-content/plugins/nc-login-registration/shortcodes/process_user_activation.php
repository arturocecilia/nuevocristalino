<?php


function process_user_activation($atts)
{
    global $wpdb,$current_user;


    if (array_key_exists('key', $_GET) && array_key_exists('user', $_GET)) {
        if ($current_user->ID) {
            $user = new WP_User($current_user->ID);

            if ($_GET['user'] != $current_user->ID) {
                $responseUnmatchedUsers = '';
                $responseUnmatchedUsers .= '<div>'._x('El usuario con el que está logueado y el usuario que corresponde al link de activación no coinciden').'</div>';
                return $responseUnmatchedUsers;
            }


            if ($user->user_status) {
                $responseUserAlreadyActivated = '';
                $responseUserAlreadyActivated .='<div>'._x('Su usuario ya ha sido activado', 'nc_login_registration', 'nc-login-registration').'</div>';
                return $responseUserAlreadyActivated;
            }
        }


        $user_activation_key = $_GET['key'];
        $user_id = $_GET['user'];

        $activation = $wpdb->update(
                                    'wp_users', //table name
                                    array( 'user_status' => 1   ),
                                    array(
                                      'ID' => $_GET['user'], //where clause
                                      'user_activation_key'=>$_GET['key'] //where clause
                                    ),
                                    array( '%d'  )
                                  );
        if ($activation == 1) {
            $responseSuccess = '';
            $responseSuccess .= '<div>'._x('Su usuario se ha activado satisfactoriamente', 'nc_login_registration', 'nc-login-registration').'</div>';
            return $responseSuccess;
        } else {
            $responseError = '';
            $responseError .= '<div>'._x('Lo sentimos mucho, no hemos podido activar su usuario', 'nc_login_registration', 'nc-login-registration').'</div>';
            return $responseError;
        }
    }
}
