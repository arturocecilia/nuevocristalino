<?php



function send_user_activation($atts)
{
    global $wpdb,$current_user;

    if (array_key_exists('user', $_GET)) {
        if ($current_user->ID == $_GET['user']) {
            sendUserActivationEmail($current_user->ID);
            return 'se ha enviado un email de activación';
        }
    }
}
