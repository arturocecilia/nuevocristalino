<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.


NO VALE DE NADAAAAA¡¡ Se está cogiendo el ms-signup-user-form¡¡¡

*/
?>
<div class="login" id="theme-my-login<?php $template->the_instance(); ?>">
    
	<?php /*$template->the_action_template_message( 'register' );*/ ?>
	<?php $template->the_errors(); ?>
	<form name="registerform" id="registerform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'register' ); ?>" method="post">
        	<p>
			<label for="user_login<?php $template->the_instance(); ?>"><?php _e( 'Username' ); ?></label>
			<input type="text" name="user_login" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_login' ); ?>" size="20" />
		</p>

		<p>
			<label for="user_email<?php $template->the_instance(); ?>"><?php _e( 'E-mail' ); ?></label>
			<input type="text" name="user_email" id="user_email<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_email' ); ?>" size="20" />
		</p>
		
		
<!-- Añadimos el tipo de usuario que es -->

        <p>
            <label for="nc_user_type<?php $template->the_instance(); ?>"><?php echo _x( 'Tipo de Usuario de NuevoCristalino','register-form','iol_theme'); ?><br />  
  
  <?php            
                      switch ($template->the_posted_value( 'nc_user_type' )){
                          case 'pat':
                                $pat = 'selected';
                          break;
                          
                          case 'prof':
                                $prof = 'selected';
                          break;
                          
                          default:
                                $other = 'selected';
                          break;

                      } ?>
  
  
  
  <select name="nc_user_type">
    <option value="<?php echo _x('Paciente','Functions','iol_theme'); ?>" <?php echo $pat;?> >
    <?php echo _x('Paciente','Functions','iol_theme'); ?>
    </option>
    
    <option value="<?php echo _x('Profesional','Functions','iol_theme'); ?>" <?php echo $prof;?> >
    <?php echo _x('Profesional','Functions','iol_theme'); ?>
    </option>
    
    <option value="<?php echo _x('Sin Especificar','Functions','iol_theme'); ?>" <?php echo $other; ?> ><?php echo _x('Sin Especificar','Functions','iol_theme'); ?></option>
  </select>

  			</label>
        </p>



<!-- Fin del campo tipo de usuario añadido -->		

		<?php do_action( 'register_form' ); ?>

		<p id="reg_passmail<?php $template->the_instance(); ?>"><?php echo apply_filters( 'tml_register_passmail_template_message', __( 'A password will be e-mailed to you.' ) ); ?></p>

		<p class="submit">
			<input type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="<?php esc_attr_e( 'Register' ); ?>" />
			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'register' ); ?>" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="action" value="register" />
		</p>
	</form>
	<?php $template->the_action_links( array( 'register' => false ) ); ?>
</div>
