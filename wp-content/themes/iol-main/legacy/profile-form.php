<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<div class="login profile" id="theme-my-login<?php $template->the_instance(); ?>">

	<?php $template->the_action_template_message( 'profile' ); ?>
	<?php $template->the_errors(); ?>
	<form id="your-profile" action="<?php $template->the_action_url( 'profile' ); ?>" method="post">
		<?php wp_nonce_field( 'update-user_' . $current_user->ID ); ?>
		<p>
			<input type="hidden" name="from" value="profile" />
			<input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>" />
		</p>

		<h3><?php _e( 'Personal Options' ); ?></h3>

		<table class="form-table">
		<?php do_action( 'personal_options', $profileuser ); ?>
		</table>


		<?php do_action( 'profile_personal_options', $profileuser ); ?>

<div id="editaccwrapper">

		<h3><?php _e( 'Name' ); ?></h3>

		<table class="form-table">
		<tr>
			<th><label for="user_login"><?php _e( 'Username' ); ?></label></th>
			<td><input type="text" name="user_login" id="user_login" value="<?php echo esc_attr( $profileuser->user_login ); ?>" disabled="disabled" class="regular-text" /> <span class="description"><?php _e( 'Your username cannot be changed.', 'theme-my-login' ); ?></span></td>
		</tr>

		<tr>
			<th><label for="first_name"><?php _e( 'First Name' ); ?></label></th>
			<td><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $profileuser->first_name ); ?>" class="regular-text" /></td>
		</tr>

		<tr>
			<th><label for="last_name"><?php _e( 'Last Name' ); ?></label></th>
			<td><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $profileuser->last_name ); ?>" class="regular-text" /></td>
		</tr>

		<tr>
			<th><label for="nickname"><?php _e( 'Nickname' ); ?> <span class="description"><?php _e( '(required)' ); ?></span></label></th>
			<td><input type="text" name="nickname" id="nickname" value="<?php echo esc_attr( $profileuser->nickname ); ?>" class="regular-text" /></td>
		</tr>

		<tr>
			<th><label for="display_name"><?php _e( 'Display name publicly as' ); ?></label></th>
			<td>
				<select name="display_name" id="display_name">
				<?php
					$public_display = array();
					$public_display['display_nickname']  = $profileuser->nickname;
					$public_display['display_username']  = $profileuser->user_login;

					if ( ! empty( $profileuser->first_name ) )
						$public_display['display_firstname'] = $profileuser->first_name;

					if ( ! empty( $profileuser->last_name ) )
						$public_display['display_lastname'] = $profileuser->last_name;

					if ( ! empty( $profileuser->first_name ) && ! empty( $profileuser->last_name ) ) {
						$public_display['display_firstlast'] = $profileuser->first_name . ' ' . $profileuser->last_name;
						$public_display['display_lastfirst'] = $profileuser->last_name . ' ' . $profileuser->first_name;
					}

					if ( ! in_array( $profileuser->display_name, $public_display ) )// Only add this if it isn't duplicated elsewhere
						$public_display = array( 'display_displayname' => $profileuser->display_name ) + $public_display;

					$public_display = array_map( 'trim', $public_display );
					$public_display = array_unique( $public_display );

					foreach ( $public_display as $id => $item ) {
				?>
					<option <?php selected( $profileuser->display_name, $item ); ?>><?php echo $item; ?></option>
				<?php
					}
				?>
				</select>
			</td>
		</tr>
		</table>

		<h3><?php _e( 'Contact Info' ); ?></h3>

		<table class="form-table">
		<tr>
			<th><label for="email"><?php _e( 'E-mail' ); ?> <span class="description"><?php _e( '(required)' ); ?></span></label></th>
			<td><input type="text" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ); ?>" class="regular-text" /></td>
		</tr>

		<!-- New Email stuff-->
		<?php
		$new_email = get_option( $current_user->ID . '_new_email' );
		if ( $new_email && $new_email['newemail'] != $current_user->user_email ) : ?>
		<div class="updated inline">
		<p><?php
			printf(
				__( 'There is a pending change of your e-mail to %1$s. <a href="%2$s">Cancel</a>', 'theme-my-login' ),
				'<code>' . $new_email['newemail'] . '</code>',
				esc_url( self_admin_url( 'profile.php?dismiss=' . $current_user->ID . '_new_email' ) )
		); ?></p>
		</div>
		<?php endif; ?>

		<!-- End New email stuff-->


	   <!-- TAMBI�N QUITAMOS LO DEL WEBSITE.
		<tr>
			<th><label for="url"><?php _e( 'Website' ); ?></label></th>
			<td><input type="text" name="url" id="url" value="<?php echo esc_attr( $profileuser->user_url ); ?>" class="regular-text code" /></td>
		</tr>
    -->
		<?php
			foreach ( _wp_get_user_contactmethods() as $name => $desc ) {
		?>
		<tr>
			<th><label for="<?php echo $name; ?>"><?php echo apply_filters( 'user_'.$name.'_label', $desc ); ?></label></th>
			<td><input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_attr( $profileuser->$name ); ?>" class="regular-text" /></td>
		</tr>
		<?php
			}
		?>
		</table>

		<h3><?php _e( 'New Password', 'theme-my-login' );/*_e( 'About Yourself' );*/ ?></h3>

		<table class="form-table">

		<!-- <tr> LO VOY A QUITAR, VAMOS A INTENTAR SIMPLIFICAR Y QUITAR TODO LO QUE NO APORTE VALOR.
			<th><label for="description"><?php _e( 'Biographical Info' ); ?></label></th>
			<td><textarea name="description" id="description" rows="5" cols="30"><?php echo esc_html( $profileuser->description ); ?></textarea><br />
			<span class="description"><?php _e( 'Share a little biographical information to fill out your profile. This may be shown publicly.' ); ?></span></td>
		</tr>
		  -->

		<?php
		$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );



		if ( $show_password_fields ) :
		?>
		<tr id="password" class="user-pass1-wrap">
			<th><label for="pass1">
					<?php _e( 'New Password', 'theme-my-login' ); ?>
					<?php
									if(in_array(get_locale(),array('es_ES','es_MX','es_CO','es_CL'))){
											echo '<span style="font-style: italic;font-size: 12px;line-height: 1.4;display: block;padding-bottom: 15px;padding-right: 15px;">Puede sustituir la contraseña generada por la que desee. Una vez realizado guarde el perfil y el cambio se habrá efectuado.</span>';
											}
					?>
					</label>
				</th>
			<td>
				<input class="hidden" value=" " /><!-- #24364 workaround -->
				<button type="button" class="button button-secondary wp-generate-pw hide-if-no-js"><?php _e( 'Generate Password', 'theme-my-login' ); ?></button>
				<div class="wp-pwd hide-if-js">
					<span class="password-input-wrapper">
						<input type="password" name="pass1" id="pass1" class="regular-text" value="" autocomplete="off" data-pw="<?php echo esc_attr( wp_generate_password( 24 ) ); ?>" aria-describedby="pass-strength-result" />
					</span>
					<div style="display:none" id="pass-strength-result" aria-live="polite"></div>
					<button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Hide password', 'theme-my-login' ); ?>">
						<span class="dashicons dashicons-hidden"></span>
						<span class="text"><?php _e( 'Hide', 'theme-my-login' ); ?></span>
					</button>
					<button type="button" class="button button-secondary wp-cancel-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Cancel password change', 'theme-my-login' ); ?>">
						<span class="text"><?php _e( 'Cancel', 'theme-my-login' ); ?></span>
					</button>
				</div>
			</td>
		</tr>
		<tr class="user-pass2-wrap hide-if-js">
			<th scope="row"><label for="pass2"><?php _e( 'Repeat New Password', 'theme-my-login' ); ?></label></th>
			<td>
			<input name="pass2" type="password" id="pass2" class="regular-text" value="" autocomplete="off" />
			<p class="description"><?php _e( 'Type your new password again.', 'theme-my-login' ); ?></p>
			</td>
		</tr>
		<tr class="pw-weak">
			<th><?php _e( 'Confirm Password', 'theme-my-login' ); ?></th>
			<td>
				<label>
					<input type="checkbox" name="pw_weak" class="pw-checkbox" />
					<?php _e( 'Confirm use of weak password', 'theme-my-login' ); ?>
				</label>
			</td>
		</tr>
		<?php endif; ?>
		</table>


</div>

		<?php do_action( 'show_user_profile', $profileuser ); ?>





		<p class="submit">
			<input type="hidden" name="action" value="profile" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
			<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Update Profile' ); ?>" name="submit" />
		</p>
	</form>
</div>
