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
 * Plugin Name:       nc-user-manager
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



 /* Funciones que irán desapareciendo herencia de nc-user-manager y nc-user-analysis */
 function user_info_class()
 {
     $userTypeClass = profileShowInfo(array( 'infotype' => 'usertype','outputtype' => 'literal'));



     $preOrPostClass =  profileShowInfo(array( 'infotype' => 'preorpost','outputtype' => 'literal'));
     $sxInteresClass = profileShowInfo(array( 'infotype' => 'sxinteres','outputtype' => 'literal'));


     echo ' '.$userTypeClass.' '.$preOrPostClass.' '.$sxInteresClass.' ';
 }



 add_shortcode('profileshowinfo', 'profileShowInfo');
 function profileShowInfo($atts)
 {
     $attAux = shortcode_atts(array(
                                        'infotype' => '',
                                        'outputtype' => '',
        // ...etc
    ), $atts);

     $infotype =  $attAux['infotype'];
     $outputtype = $attAux['outputtype'];


     $output = '';



     if ((is_user_logged_in())) {
         $cUserId = get_current_user_id();

         $userType = get_user_meta($cUserId, 'ncusertype', true);
         $userSx = get_user_meta($cUserId, 'p_sxInteres', true);
         $userPreOrPost = get_user_meta($cUserId, 'p_preOrPost', true);

         if ($infotype == 'usertype') {
             if ($outputtype == 'literal') {
                 $output .= $userType;
                 return $output;
             }
         }

         if ($infotype == 'sxinteres') {
             if ($outputtype == 'literal') {
                 $output .= $userSx;
                 return $output;
             }
         }

         if ($infotype == 'preorpost') {
             if ($outputtype == 'literal') {
                 $output .= $userPreOrPost;
                 return $output;
             }
         }

         if ($infotype == 'generaluserinfo') {
             if ($outputtype == 'generaldescription') {
                 $output .= '<p>';
                 $output .= '<ul class="estilada">';
                 $output .= '<li>'._x('Tu tipo de usuario de NuevoCristalino es:', 'user-data-checker', 'user-analysis-p').' <strong>'._x($userType, 'user_manager', 'user-manager').'</strong>.</li>';
                 $output .= '<li>'._x('Tu cirugía de interés principal es:', 'user-data-checker', 'user-analysis-p').' <strong>'._x($userSx, 'user_manager', 'user-manager').'</strong>.</li>';
                 $output .= '<li>'._x('En relación al momento de la operación:', 'user-data-checker', 'user-analysis-p').' <strong>'._x($userPreOrPost, 'user_manager', 'user-manager').'</strong>.</li>';
                 $output .= '</ul>';
                 $output .= '</p>';

                 return $output;
             }
         }
     } else {
         //Con literal nos referíamos al valor del userkeyvalue en sí.
         if ($outputtype != 'literal') {
             $output .= '<div class="notloggedmessage"><p>'._x('Necesitas iniciar sesión/logearte. Si no estás registrado puedes', 'user-data-checker', 'user-analysis-p').' <a href="'.get_permalink(66).'">'._x('registrarte de forma gratuita', 'user-data-checker', 'user-analysis-p').'</a></p></div>';
         }
     }




     return $output;
 }




 //Función para poner que el usuario no está logueado.

 function returnClassLogged()
 {
     $output = '';
     if (!is_user_logged_in()) {
         $output = 'not_logged';
     } else {
         $output = 'logged_in';
     }

     return $output;
 }
