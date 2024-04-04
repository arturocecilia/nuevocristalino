<?php

//El path a a la función de inicio es: includes/ms-functions.php
/**
 * Notify user of signup success.
 *
 * This is the notification function used when no new site has
 * been requested.
 *
 * Filter 'wpmu_signup_user_notification' to bypass this function or
 * replace it with your own notification behavior.
 *
 * Filter 'wpmu_signup_user_notification_email' and
 * 'wpmu_signup_user_notification_subject' to change the content
 * and subject line of the email sent to newly registered users.
 *
 * @since MU
 *
 * @param string $user       The user's login name.
 * @param string $user_email The user's email address.
 * @param string $key        The activation key created in wpmu_signup_user()
 * @param array  $meta       By default, an empty array.
 * @return bool
 */


 add_filter( 'wpmu_signup_user_notification', 'Test_nc_signup_user_notification', 10, 4 );


function Test_nc_signup_user_notification( $user, $user_email, $key, $meta = array() ) {

  // Send email with activation link.
	$admin_email = get_site_option( 'admin_email' );
	if ( $admin_email == '' )
		$admin_email = 'support@' . $_SERVER['SERVER_NAME'];
	$from_name = get_site_option( 'site_name' ) == '' ? 'WordPress' : esc_html( get_site_option( 'site_name' ) );
	$message_headers = "From: \"{$from_name}\" <{$admin_email}>\n" . "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n";
	$message = sprintf(
		/**
		 * Filter the content of the notification email for new user sign-up.
		 *
		 * Content should be formatted for transmission via wp_mail().
		 *
		 * @since MU
		 *
		 * @param string $content    Content of the notification email.
		 * @param string $user       User login name.
		 * @param string $user_email User email address.
		 * @param string $key        Activation key created in wpmu_signup_user().
		 * @param array  $meta       Signup meta data.
		 */
		apply_filters( 'wpmu_signup_user_notification_email',
			__( "To activate your user, please click the following link:\n\n%s\n\nAfter you activate, you will receive *another email* with your login." ),
			$user, $user_email, $key, $meta
		),
		site_url( "wp-activate.php?key=$key" )
	);
	// TODO: Don't hard code activation link.
	$subject = sprintf(
		/**
		 * Filter the subject of the notification email of new user signup.
		 *
		 * @since MU
		 *
		 * @param string $subject    Subject of the notification email.
		 * @param string $user       User login name.
		 * @param string $user_email User email address.
		 * @param string $key        Activation key created in wpmu_signup_user().
		 * @param array  $meta       Signup meta data.
		 */
		apply_filters( 'wpmu_signup_user_notification_subject',
			__( '[%1$s] Activate %2$s' ),
			$user, $user_email, $key, $meta
		),
		$from_name,
		$user
	);

	wp_mail( $user_email, wp_specialchars_decode( $subject ), $message, $message_headers );
	return false; //Para que no envíe 2 emails.

}
?>
