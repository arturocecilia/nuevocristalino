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
<meta charset="<?php bloginfo( 'charset' );?>"/>
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
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
            $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
            $pathAp = substr_count ( $current_url , "/")-2;
            $added = str_repeat("../",$pathAp);

         echo '<link rel="stylesheet" href="'.$added.'wp-content/themes/iol/fonts/fontsIE-'.get_locale().'.css"  type="text/css" media="all" />';
   ?>


<?php

        global $ncWPSitesCountry;
        global $siteCountry;




        include ("gAnalytics.php");
        if(get_locale() != 'de_DE'){
        include('gAdsense.php');
        }
        
        		if( (get_locale() == 'es_CO') || (get_locale() == 'es_CL') || (get_locale() == 'es_MX') || (get_locale() == 'es_ES') ){
			include('gAdsense-adverts');
		}
        
        include ('hrefLang.php');



 ?>





</head>


<body <?php body_class(); ?> id="buscadorBody">

<div id="pageBuscadorClinicaWrapper" class="<?php echo get_locale();?>">

	<?php //ponemos aqu’ los links para cambio de versi—n si el dispositivo es m‡s peque–o


            $langChange = substr(get_locale(),0,2);


            if($langChange == "es"){
            	$mob 	= 'Versión Móvil';
            	$clas	= 'Versión Clásica';

            }
            if($langChange == "de"){
               	$mob 	= 'Mobile';
            	$clas	= 'Classic';
            }
            if($langChange == "en"){
               	$mob 	= 'Mobile';
            	$clas	= 'Classic';
                      }
            if($langChange == "fr"){
               	$mob 	= 'Mobile';
            	$clas	= 'Classic';
                }


	?>
	<div id="versionSwitcher">
	<a id="mobileChanger" href="#"><?php echo $mob;?></a>
	&nbsp;| &nbsp;
	<a id="classicChanger" href="#"><?php echo $clas;?></a>
	</div>



    <div id="top-header" class="buscador-clinicas-header">
         <!-- Ini HeaderWrapper -->
            <div id="headerWrapper">
                <!-- Ini HeaderRelative -->
            <div id="headerRelative">












<!-- Ini Logo-->
        <div id="logo">
            <a href="<?php echo get_home_url(); ?>" class="noGotoMain">
             <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/header/logotipo-nuevo-cristalino-<?php echo get_locale(); ?>.png" alt="<?php echo _x('Ir a Nuevo Cristalino','alt home','iol_theme'); ?>"/>
            </a>

     </div>
<!-- Fin logo -->
     <div id="buscadorTitle"><?php echo _x('BUSCADOR DE CLÍNICAS PARA OPERACIÓN CON LENTE INTRAOCULAR','header-clinicas','iol_last'); ?></div>
     <!-- volver a nuevocristalino-->


     <div id="backFromClinics">
     <a href="<?php echo get_home_url(); ?>" class="noGotoMain">
     	Volver a NuevoCristalino
     </a>

     </div>



     </div>

        <div style="clear: both;height: 0px;">&nbsp;</div>
        <!-- Fin HeaderRelative -->
            </div>
        <!-- Fin HeaderWrapper -->
    </div>






<div id="page" class="hfeed site">

	<div id="main" class="wrapper">

        <div id="loadingGif" class="loadingGeneral">
            <div id="loaderDiv"><img src="<?php echo get_stylesheet_directory_uri()."/images/ajax-loader-general.gif";  ?>" />
            </div>
        </div>
