<?php
/*
ESTE ES EL QUE SE UTILIZA EN EL REGISTRO DEL USUARIO¡¡¡ NO EL register-form.php¡¡¡



If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>

<?php
/*    global $blog_id;
    $current_blog_details = get_blog_details( array( 'blog_id' => $blog_id ) );
    */
?>

<h2><?php /* printf( _x( 'Tenga acceso a todos los servicios de %s en segundos','ms-signup-user-form','iol_theme' ), $current_blog_details->blogname );*/ ?></h2>


<?php

$socialLoginEnabled = array('es_CO','es_CL','es_MX','es_ES');
//vamos a ver como lo hacemos para que no salga duplicado
if(in_array(get_locale(),$socialLoginEnabled) && (!is_page(64))){
echo do_shortcode('[TheChamp-Login style="background-color:#fff;"]') ;
}


?>


<form id="setupform" method="post" action="<?php $template->the_action_url( 'register' ); ?>">
  <input type="hidden" name="action" value="register" />
	<input type="hidden" name="stage" value="validate-user-signup" />
	<?php do_action( 'signup_hidden_fields' ); ?>


<div class="built-in-signup-fields">

	<label for="user_name<?php $template->the_instance(); ?>"><?php echo _x( 'Nombre de Usuario / Nickname <b>(Elija uno que garantice su anonimato ¡¡ )</b>:','ms-signup-user-form','iol_theme' ); ?> &nbsp;</label>
	<?php if ( $errmsg = $errors->get_error_message( 'user_name' ) ) { ?>
		<p class="error"><?php echo $errmsg; ?></p>
	<?php } ?>

	<input name="user_name" type="text" id="user_name<?php $template->the_instance(); ?>" value="<?php echo esc_attr( $user_name ); ?>" maxlength="60" /><br />
	<span class="hint"><?php _e( '(Must be at least 4 characters, letters and numbers only.)' ); ?></span>

	<label for="user_email<?php $template->the_instance(); ?>"><?php _e( 'Email&nbsp;Address:' ); ?></label>
	<?php if ( $errmsg = $errors->get_error_message( 'user_email' ) ) { ?>
		<p class="error"><?php echo $errmsg; ?></p>
	<?php } ?>

	<input name="user_email" type="text" id="user_email<?php $template->the_instance(); ?>" value="<?php echo esc_attr( $user_email ); ?>" maxlength="200" /><br />
	<span class="hint"><?php _e( 'We send your registration email to this address. (Double-check your email address before continuing.)' ); ?></span>
	<?php if ( $errmsg = $errors->get_error_message( 'generic' ) ) { ?>
		<p class="error"><?php echo $errmsg; ?></p>
	<?php } ?>
</div> <!-- End built in signup fields-->



	<?php do_action( 'signup_extra_fields', $errors ); ?>

	<p>
	<?php if ( $active_signup == 'blog' ) { ?>
		<input id="signupblog<?php $template->the_instance(); ?>" type="hidden" name="signup_for" value="blog" />
	<?php } elseif ( $active_signup == 'user' ) { ?>
		<input id="signupblog<?php $template->the_instance(); ?>" type="hidden" name="signup_for" value="user" />
	<?php } else { ?>
		<input id="signupblog<?php $template->the_instance(); ?>" type="radio" name="signup_for" value="blog" <?php if ( ! isset( $_POST['signup_for'] ) || $_POST['signup_for'] == 'blog' ) { ?>checked="checked"<?php } ?> />
		<label class="checkbox" for="signupblog"><?php _e( 'Gimme a site!' ); ?></label>
		<br />
		<input id="signupuser<?php $template->the_instance(); ?>" type="radio" name="signup_for" value="user" <?php if ( isset( $_POST['signup_for'] ) && $_POST['signup_for'] == 'user' ) { ?>checked="checked"<?php } ?> />
		<label class="checkbox" for="signupuser"><?php _e( 'Just a username, please.' ); ?></label>
	<?php } ?>
	</p>






        <?php
            //Vamos a añadir los campos propios para el registro en este caso el check de la protección de datos y algunos comentarios.
            if ( $errmsg = $errors->get_error_message( 'conditions_not_accepted' ) ) { ?>

            <p class="error"><?php echo $errmsg; ?></p>
	      <?php   }?>

            <span id="messageCond" style="color: red; display: none; font-style: italic;"><?php echo _x('Antes de registrarse ha de aceptar las condiciones legales.','functions','iol_theme')?></span>
      <?php

            echo '<input type="checkbox" name="user_conditions" value="accepted">&nbsp;&nbsp;<span class="textConditons">'._x('He leído y acepto los términos y condiciones','ms-signup-user-form','iol_theme').'</span><br>';
if(get_locale()!= 'de_DE'){
            echo '<p class="spamMessage lowercase">'._x('Si pasados 20 segundos ve que no le llega el email, no olvide buscar también en la carpeta de correo SPAM.','ms-signup-user-form','iol_theme').'</p>';
           
            echo '<p class="spamMessage lowercase noGotoMain problem">'._x('Si tiene el más mínimo problema <a href="https://www.nuevocristalino.es/contactar-con-nuevocristalino/">contáctenos directamente</a>.','ms-signup-user-form','iol_theme').'</p>';
     
     } 
     
        ?>

<?php
      if(in_array(get_locale(),array('es_ES','es_MX','es_CO','es_CL'))){
        $send = 'Enviar datos básicos';
      }else{
        $send = 'Send';
      }

?>

	<p class="submit register"><input type="submit" name="submit" class="submit" value="<?php esc_attr_e( $send ); ?>" /></p>
</form>

<script>
    document.getElementById("setupform").onsubmit = function () {
        if(!this.user_conditions.checked) {

            jQuery('#messageCond').css('display','block');

        }
        return this.user_conditions.checked;
    }
</script>



<?php $template->the_action_links( array( 'register' => false ) ); ?>
