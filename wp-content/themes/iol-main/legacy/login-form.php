<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.

*/
//load_plugin_textdomain('theme-my-login' , get_site_url() . 'wp-content/plugins/theme-my-login/languages/');

?>
<div class="login" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php $template->the_action_template_message( 'login' ); ?>
	<?php $template->the_errors(); ?>
	<form name="loginform" id="loginform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'login' ); ?>" method="post">
		<p>
<!--
			<label for="user_login<?php $template->the_instance(); ?>"><?php _e( 'Username' ); ?></label>
			<input type="text" name="log" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'log' ); ?>" size="20" />
-->

<label for="user_login<?php $template->the_instance(); ?>"><?php
	if ( 'username' == $theme_my_login->get_option( 'login_type' ) ) {
		_e( 'Username' ); //, 'theme-my-login'
	} elseif ( 'email' == $theme_my_login->get_option( 'login_type' ) ) {
		_e( 'E-mail', 'theme-my-login' );
	} else {
		if((get_locale()=='es_ES')||(get_locale()=='es_MX')||(get_locale()=='es_CL')||(get_locale()=='es_CO')){
			
		echo 'Nombre de usuario o Email';
		
		}else{
			_e( 'Username or E-mail', 'theme-my-login' );
			}
	
	}
?></label>
<input type="text" name="log" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'log' ); ?>" size="20" />



		</p>
		<p>
			<label for="user_pass<?php $template->the_instance(); ?>"><?php _e( 'Password' ); ?></label>
			<input type="password" name="pwd" id="user_pass<?php $template->the_instance(); ?>" class="input" value="" size="20" />
		</p>

		<?php  do_action( 'login_form' ); ?>

		<p class="forgetmenot">
			<input name="rememberme" type="checkbox" id="rememberme<?php $template->the_instance(); ?>" value="forever" />
			<label for="rememberme<?php $template->the_instance(); ?>"><?php esc_attr_e( 'Remember Me' ); ?></label>
		</p>
		<p class="submit">
			<input type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="<?php esc_attr_e( 'Log In' ); ?>" />

            <?php /*-- VAMOS A PROGRAMAR DIRECTAMENTE AQUÍ NUESTROS REDIRECCIONAMIENTOS --*/ ?>

            <?php
            /*-- Cogemos la url en la que está el widget y lo sustituimos por el valor del redirect_to punto :) --*/
/*
                    $actual_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                    if (false !== strpos($actual_url,'login')) {
                        ?>
                        <input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'login' ) ?>" />
                     <?php
                     } else {
                       echo '<input type="hidden" name="redirect_to" value="'.$actual_url.'" />';
                        }
*/
             ?>

	    <input type="hidden" name="test" value="" />

    	<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'login' ); ?>" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="action" value="login" />
		</p>
	</form>

	<?php $template->the_action_links( array( 'login' => false ) ); ?>

</div>
