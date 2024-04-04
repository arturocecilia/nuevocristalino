<?php



function create_form_login($atts)
{
    $homeUrl = get_home_url();
    $defaults = array(
          'echo' => true,
          // Default 'redirect' value takes the user back to the request URI.
          'redirect' => $homeUrl,//( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
          'form_id' => 'loginform',
          'label_username' => __('Username or Email Address'),
          'label_password' => __('Password'),
          'label_remember' => __('Remember Me'),
          'label_log_in' => __('Log In'),
          'id_username' => 'user_login',
          'id_password' => 'user_pass',
          'id_remember' => 'rememberme',
          'id_submit' => 'wp-submit',
          'remember' => true,
          'value_username' => '',
          // Set 'value_remember' to true to default the "Remember me" checkbox to checked.
          'value_remember' => false,
      );

    $login_form = '<div>';
    $login_form .= '<div style="clear:both;"></div>';
    $login_form .= wp_login_form($defaults);//home_url()
    $login_form .= '<div style="clear:both;"></div>';
    $login_form .='</div>';
    return $login_form;//array('redirect' => home_url())
}
