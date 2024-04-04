<?php




function sendUserActivationEmail($user_id)
{
    global $wpdb;


    $user = new WP_User($user_id);

    $user_email = $user->user_email;
    $ncusertype = get_user_meta($user_id, 'ncusertype', true);

    $code = sha1($user_id . time());

    $wpdb->update(
        'wp_users', //table name
            array( 'user_activation_key' => $code    ),
            array( 'ID' =>    $user_id ),
            array( '%s'   )
        );


    $activatePageId = get_page_by_path('activate-user')->ID;

    $activation_link = add_query_arg(array( 'key' => $code, 'user' => $user_id ), get_permalink($activatePageId));


    //Este email es de Activación => activation

    $emailUserType = ($ncusertype == 'prof') ? 'professional' :'patient';


    $activationEmailHeaderArgs = array(
                            'name' => 'header-activate-'.$emailUserType.'-user', //patient
                            'post_type' => 'email-content'
                              );

    $contentEmailActivationHeaderWP = new WP_Query($activationEmailHeaderArgs);

    $contentEmailActivation = $contentEmailActivationHeaderWP->posts[0]->post_content;

    $contentEmailActivation .=  PHP_EOL.$activation_link.PHP_EOL;

    $activationEmailFooterArgs = array(
                            'name' => 'footer-activate-'.$emailUserType.'-user',//patient
                            'post_type' => 'email-content'
                              );


    $contentEmailActivationFooterWP = new WP_Query($activationEmailFooterArgs);

    $contentEmailActivation .= $contentEmailActivationFooterWP->posts[0]->post_content;


    //Subject
    $subject = '';
    $subject = get_bloginfo('name').': '._x('Email de activación de usuario', 'nc_login_registration', 'nc-login-registration');
    //Content

    wp_mail($user_email, $subject, $contentEmailActivation);
}
