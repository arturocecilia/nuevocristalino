<?php



function printUserStatusButton()
{
    global $wpdb,$current_user;

    $user = new WP_User($current_user->ID);

    if ($user->user_status) {
        return '<div class="activatedUserInfo">'._x('Estatus de usuario OK. Su usuario está activado', 'nc_login_registration', 'nc-login-registration').'</div>';
    } else {
        $resendActivationLinkPageWP = new WP_Query(
                                            array('pagename' => 'resend-activation-link')
                                          );

        $resendActivationLinkPage =     get_permalink($resendActivationLinkPageWP->posts[0]->ID);
        $resendActivationLinkPage .='?user='.$current_user->ID;

        $unactivatedUserMessage = '';
        $unactivatedUserMessage .= '<div class="unActivatedUserInfo">';
        $unactivatedUserMessage .= '<div class="unActivatedUserInfoMessage">'._x('No tiene activado el usuario. Recuerde que se le enviará un email de activación', 'nc_login_registration', 'nc-login-registration').'</div>';
        $unactivatedUserMessage .= '<a href="'.$resendActivationLinkPage.'">'._x('Reenvíar email con link de activación de usuario.', 'nc_login_registration', 'nc-login-registration').'</a>';
        $unactivatedUserMessage .= '</div>';

        return $unactivatedUserMessage;
    }
}
