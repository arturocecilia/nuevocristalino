<?php
/*
Plugin Name: iolTranslator
Plugin URI: http://lente-intraocular.com/
Description: Declares a plugin that will load all the data needed for iols on activation.
Version: 1.0
Author: Arturo Cecilia
Author URI: http://www.andomed.com/
License: GPLv2
*/

// add admin menu
add_action('admin_menu', 'iolTranslator_menuF');

function iolTranslator_menuF() {   
   // add_menu_page('custom menu title', 'custom menu', 'add_users', 'custompage', '_custom_menu_page', null, 6); 
    add_submenu_page( 'tools.php','Title: Loading iol moVariables For tranlsation', 'iol .mo values translator generator','add_users', 'iol-moFiles-generator-tran', 'iolTranslatorDisplayF');
}




function iolTranslatorDisplayF() {
    //Aquí es donde vamos a poner todos los valores que hay que traducir.
    
    echo 'En este plugin tenemos todas las strings necesarias para la traducción, esto es así para que un sistema de scaneo las pueda detectar.<br /><br /><br />';
 
    include('iol-scaffold-moVariables.php');
}


/*-- Vamos a añadir lo Necesario para Localización */
function iol_translation_setup() {
    

    load_plugin_textdomain('iol-scaffold', false, dirname(plugin_basename(__FILE__)).'/languages/');//
    
    //echo 'The path¡¡1: <br />'.dirname(plugin_basename(__FILE__)). '/languages/    <br />';
/*    echo 'after setup theme en disparo <br />';
    echo _x('lente-intraocular','admin_display','iol'); 
    echo 'fin de afeter setup theme en disparo';*/
    //load_plugin_textdomain('iol-display', false, dirname(plugin_basename(__FILE__)) ); //. '/lang/'
    //load_plugin_textdomain('iol_taxonomias', false, dirname(plugin_basename(__FILE__)) . '/lang/');
} // end custom_theme_setup
add_action('after_setup_theme', 'iol_translation_setup');



?>