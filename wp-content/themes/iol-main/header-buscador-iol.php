<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title('|', true, 'right'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions.?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
<noscript>
  <style type="text/css">.startsUgly { display: block !important; }</style>
</noscript>
    <!--<script type="text/javascript" src="https://www.google.com/jsapi"></script>-->


    <?php
            global $wp;
            $current_url = add_query_arg($wp->query_string, '', home_url($wp->request));
            $pathAp = substr_count($current_url, "/")-2;
            $added = str_repeat("../", $pathAp);


         echo '<link rel="stylesheet" href="'.$added.'wp-content/themes/iol/fonts/fontsIE-'.get_locale().'.css"  type="text/css" media="all" />';
   ?>


<?php

  include("gAnalytics.php");

  include('gAdsense.php');

  include('hrefLang.php');

  ?>


</head>


<body <?php body_class(); ?> id="buscadorBody">

<div id="pageBuscadorIolWrapper" class="<?php echo get_locale();?>">
<div id="page" class="hfeed site">
      <div id="buscadorIolHeader">
		<!--Ini buscador back new -->
         <div id="buscadorIolBack">
            <a href="<?php echo get_site_url(); ?>" class="noGotoMain"><?php echo _x('Ir a Nuevo Cristalino', 'Buscador Iol', 'iol_theme'); ?> </a>
        </div>
        <!-- Fin buscador back new-->

        <div id="buscadorIolLogo">
            <span id="buscadorTitle">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/filtro-doctores-title-<?php echo get_locale();?>.jpg" alt="<?php echo _x('Nuevo Cristalino', 'Site Name', 'iol_theme'); ?>"/>
            </span>

            <span class="subtitle"><?php echo _x('FILTRO PARA DOCTORES', 'header-buscador-iol', 'iol_theme'); ?></span>
        </div>
        <!-- Antiguo buscador Back -->
        <!-- Fin Antiguo buscador Back -->

        <!-- A�adimos una l�nea que s�lo estar� visible en m�bil-->
    <div style="clear:both;height: 0px;">&nbsp;</div>
        <hr class="onlymobile" style="display:none;" />
    </div>
    <div style="clear:both;height: 0px;">&nbsp;</div>

    <div id="buscadorIol">
	<div id="main" class="wrapper">
