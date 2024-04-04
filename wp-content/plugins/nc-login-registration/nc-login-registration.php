<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.nuevocristalino.es
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       nc-login-registration
 * Plugin URI:        http://www.andomed.com/
 * Description:       This plugin adds functinality for addition and management of user data.
 * Version:           1.0.0
 * Author:            Arturo Cecilia
 * Author URI:        http://www.andomed.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */


/*
  FIELDS:

'user_login'
'user_email'
'privacy_agree'
'ncblogregistration'
'user_country'
'user_region'
'ncusertype'
'p_preOrPost'
'p_sxInteres'

*/

//Actions
include(ABSPATH.'wp-content/plugins/nc-login-registration/includes/sendUserActivationEmail.php');

//Display
include(ABSPATH.'wp-content/plugins/nc-login-registration/includes/printNCFormatedInput.php');
include(ABSPATH.'wp-content/plugins/nc-login-registration/includes/printNCRgpd.php');
include(ABSPATH.'wp-content/plugins/nc-login-registration/includes/printPostProcessErrors.php');
include(ABSPATH.'wp-content/plugins/nc-login-registration/includes/printUserStatusButton.php');
//Process
include(ABSPATH.'wp-content/plugins/nc-login-registration/includes/processRegisterPostUserData.php');
include(ABSPATH.'wp-content/plugins/nc-login-registration/includes/processProfileEditionPostUserData.php');
//shortcodeFunctins
include(ABSPATH.'wp-content/plugins/nc-login-registration/shortcodes/create_quick_form_signup.php');
include(ABSPATH.'wp-content/plugins/nc-login-registration/shortcodes/create_form_signup.php');
include(ABSPATH.'wp-content/plugins/nc-login-registration/shortcodes/create_form_edit_profile.php');
include(ABSPATH.'wp-content/plugins/nc-login-registration/shortcodes/create_form_login.php');
include(ABSPATH.'wp-content/plugins/nc-login-registration/shortcodes/send_user_activation.php');


include(ABSPATH.'wp-content/plugins/nc-login-registration/shortcodes/process_user_activation.php');

 //Adding to Hooks
add_shortcode('quick_form_signup', 'create_quick_form_signup');
add_shortcode('form_signup', 'create_form_signup');
add_shortcode('form_edit_profile', 'create_form_edit_profile');
add_shortcode('form_login', 'create_form_login');
add_shortcode('activate_user', 'process_user_activation');

add_shortcode('resend_activation_link', 'send_user_activation');

//La traducción.

add_action('plugins_loaded', 'n_login_registration_load_textdomain');
/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function n_login_registration_load_textdomain()
{
    load_plugin_textdomain('nc-login-registration', false, basename(dirname(__FILE__)) . '/languages');
}
