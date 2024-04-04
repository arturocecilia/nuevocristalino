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
<meta charset="<?php bloginfo('charset');?>"/>
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

        global $ncWPSitesCountry;
        global $siteCountry;

        include("gAnalytics.php");


        include('gAdsense.php');

        include('hrefLang.php');

        $sCount = get_locale();

        switch ($sCount) {

            case 'es_ES':
                $siteCountry = 'España';
                unset($ncWPSitesCountry[0]);
            break;
            case 'es_MX':
                $siteCountry = 'México';
                unset($ncWPSitesCountry[1]);
            break;
            case 'en_GB':
                $siteCountry = 'United Kingdom';
                unset($ncWPSitesCountry[2]);
            break;
            case 'de_DE':
                $siteCountry = 'Deutschland';
                unset($ncWPSitesCountry[3]);
            break;
            case 'es_CO':
                   $siteCountry = 'Colombia';
                unset($ncWPSitesCountry[4]);
            break;

            case 'fr_FR':
                  $siteCountry = 'France';
                unset($ncWPSitesCountry[5]);
            break;

            case 'es_CL':
                  $siteCountry = 'Chile';
                unset($ncWPSitesCountry[6]);
            break;

            case 'de_AT':
                  $siteCountry = 'Österreich';
                unset($ncWPSitesCountry[7]);
            break;

            case 'en_US':
                  $siteCountry = 'United States';
                unset($ncWPSitesCountry[8]);
            break;

        }


 ?>





</head>


<body <?php body_class(); ?> id="<?php echo get_locale();?>">

	<?php //ponemos aquí los links para cambio de versión si el dispositivo es más pequeño


            $langChange = substr(get_locale(), 0, 2);


            if ($langChange == "es") {
                $mob 	= 'Versión Móvil';
                $clas	= 'Versión Clásica';
            }
            if ($langChange == "de") {
                $mob 	= 'Mobile';
                $clas	= 'Classic';
            }
            if ($langChange == "en") {
                $mob 	= 'Mobile';
                $clas	= 'Classic';
            }
            if ($langChange == "fr") {
                $mob 	= 'Mobile';
                $clas	= 'Classic';
            }


    ?>
	<div id="versionSwitcher">
	<a id="mobileChanger" href="#"><?php echo $mob;?></a>
	&nbsp;| &nbsp;
	<a id="classicChanger" href="#"><?php echo $clas;?></a>
	</div>



    <div id="top-header">
         <!-- Ini HeaderWrapper -->
            <div id="top-header-wrapper">
                <!-- Ini HeaderRelative -->
            <div id="top-header-menu">


              <!-- Ini iconosWrapper -->

                 <?php
                        wp_nav_menu(array('menu' => 'top-menu','theme_location' => 'top-menu'));
                 ?>

                 <!-- Fin IconosWrapper -->

        </div>


        <div id="wsIcon">
        <a class="noGotoMain" id="siteShower" href="#">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/header/country-<?php echo get_locale();?>.png" alt="<?php echo $siteCountry; ?>"/>
          <span><?php echo $siteCountry; ?></span>
          <img class="flechaSites" src="<?php echo get_stylesheet_directory_uri(); ?>/images/header/flecha.png" alt="<?php echo _x('NuevoCristalino en el Mundo', 'alt header', 'iol_theme'); ?>"/>
          <span class="floatFixer">&nbsp;</span>
        </a>
      </div>


        <div id="top-header-countries">

          <div id="countrySitesList">
              <?php   foreach ($ncWPSitesCountry as $country) {
                     echo '<a href="'.$country[1].'">'; ?>
                    <span class="flag-<?php echo $country[0]; ?>" >&nbsp;</span><span class="country"><?php echo  $country[2]; ?></span></a>
            <?php
                 }  ?>
</div>

<span class="floatFixer">&nbsp;</span>
          </div>


  </div>


    </div>




<!-- -->

<!-- Ini IconosLoginHeader -->
<div id="main-header">

<div id="main-header-wrapper">

  <!-- Ini Logo-->
  <div id="logo">
      <a href="<?php echo get_home_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/header/logotipo-nuevo-cristalino-<?php echo get_locale(); ?>.png" alt="<?php echo _x('Ir a Nuevo Cristalino', 'alt home', 'iol_theme'); ?>"/></a>
      <span><?php echo _x('Todo sobre lentes intraoculares', 'Header', 'iol_theme');  ?></span ><!-- Cambiado desde mayúsculas -->
  </div>
  <!-- Fin logo -->



<?php
//Añadimos el loginform para que esté en todas las páginas

include('header-forum-login.php');


?>

<!-- Fin iconosLoginHeader -->

<!-- Fin iconosLoginHeader -->
<!-- Fin Iconos Login Header -->











<!-- INI Old Position Iconos Login Header -->

<!-- FIN Old PositionIconos Login Header -->



<div id="menu-site">
    <div id="menu-main" class="startsUgly">
      <?php
      //Metemos el icono de menú para versión móvil.
 echo '<div style="display:none;" id="menu-icon"><span class="iconMenuText">Menu</span> &nbsp;<img src="'.get_stylesheet_directory_uri().'/images/comun/icono-menu-movil.png" /></div>';

       // No todos los móviles pillan ese caracter <span style="font-size:30px;">&#9776;</span>&nbsp;</div>';

      ?>


  <?php
          wp_nav_menu(array('menu' => 'menu-site','theme_location' => 'primary'));
        ?>
    </div>
    <!-- Redesign stuff -->
   <!--  <div id="menu-shadow" class="startsUgly">
      <img alt="shadow" src="<?php echo get_stylesheet_directory_uri(); ?>/images/header/sombra.png"/>
    </div>-->
    <!-- End Redesign stuff -->
</div>

  <div class="floatFixer">&nbsp;</div>

</div>


<!-- Fin HeaderRelative -->
    </div>
<!-- Fin HeaderWrapper -->




<!-- -->




<?php

if (is_home()) {
    $is_home_class= 'is-home';
} else {
    $is_home_class = '';
}

//Vamos a meter la info sobre si el modo interaction está activo.
$interaction = false;
$interactionClass ='';
$alterClass = '';

$arrayNewDesignSites =  array('es_ES','es_MX','es_CO','es_CL','de_DE','de_AT','en_GB','en_US','fr_FR');

if (in_array(get_locale(), $arrayNewDesignSites)) {//current_user_can('manage_options')
    $interaction = true;
}

if ($interaction) {
    $interactionClass = 'interaction';
} else {
    $interactionClass = '';
}


if (rand(0, 1)) {
    $alterClass = 'alter';
} else {
    $alterClass = '';
}
$_SESSION['alter'] = $alterClass;
?>



<div id="page" class="hfeed site <?php echo $is_home_class; ?> <?php echo user_info_class(); ?> <?php echo $interactionClass.' '.$alterClass; ?>">

<?php




  if (is_page_template(array('template-presbicia.php','template-cataratas.php','template-cirugia-ocular.php'))) {
      ?>

<!-- Sacamos de dentro de prmary el menu-->
<div class="fullMenuWrapper">
<div id="menu-cirugia">
	<?php  wp_nav_menu(array('theme_location'=>'menu-cirugia')); ?>
  <div class="floatFixer">&nbsp;</div>
</div>
</div>
<div class="floatFixer">&nbsp;</div>
<!-- -->

<?php
  } ?>



	<div id="main" class="wrapper">

        <div id="loadingGif" class="loadingGeneral">
            <div id="loaderDiv"><img src="<?php echo get_stylesheet_directory_uri()."/images/ajax-loader-general.gif";  ?>" />
            </div>
        </div>
