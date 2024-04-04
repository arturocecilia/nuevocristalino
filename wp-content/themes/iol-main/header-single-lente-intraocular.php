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

      if (get_locale() != 'de_DE') {
          include('gAdsense.php');
      }

        include('hrefLang.php');



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
              <?php   foreach ($ncWPSitesCountry as $country) {
                     echo '<a href="'.$country[1].'">'; ?>
                    <span class="flag-<?php echo $country[0]; ?>" >&nbsp;</span><span class="country"><?php echo  $country[2]; ?></span></a>
            <?php
                 }  ?>
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
      <h1><?php echo _x('Todo sobre lentes intraoculares', 'Header', 'iol_theme');  ?></h1 ><!-- Cambiado desde mayúsculas -->
  </div>
  <!-- Fin logo -->



<?php
//Añadimos el loginform para que esté en todas las páginas

$args = array(
        'echo' => true,
        'redirect' => site_url($_SERVER['REQUEST_URI']),
        'form_id' => 'globalLoginForm',
        'label_username' => __('Username'),
        'label_password' => __('Password'),
        'label_remember' => __('Remember Me'),
        'label_log_in' => __('Log In'),
        'id_username' => 'user_login',
        'id_password' => 'user_pass',
        'id_remember' => 'rememberme',
        'id_submit' => 'wp-submit',
        'remember' => true,
        'value_username' => null,
        'value_remember' => false );


/*Vamos a meter aquí el div de why*/
if (0) { //$siteCountry == 'España' || $siteCountry == 'México' || $siteCountry == 'Colombia' || $siteCountry == 'Chile'
    echo '<div id="whyNC"><a href="'.get_permalink(8784).'">'._x('Soy Médico', 'Home Page', 'iol_theme').'</a></div>' /* '.get_the_title(8784).' */;
}
echo '<div id="loginStuff">';
//wp_login_form($args);
//A continuación función que te pone el logi-In o log out
//wp_loginout();
//Esta función sólo te pone el log-in

//Esta es la función que te pone el link de register.




//Vamos a tener dos opciones, o que esté logeado o que no lo esté:

if (is_user_logged_in()) {
    global $current_user;
    $idEditProfile = 70;

    if (in_array(get_locale(), array('es_ES','es_MX','es_CO','es_CL'))) {
        $idEditProfile = 13724;
    }

    wp_get_current_user();//get_currentuserinfo();
    //vamos a poner su nombre de usuario.
    echo '<div id="userName">';
    echo _x('Usuario', 'Header', 'iol_theme').': <span id="spanUserName">' . $current_user->user_login .'</span>' ;
    echo '</div>';
    //Ver/Editar perfil
    echo '<a href="';
    echo get_permalink($idEditProfile);                    /*echo get_edit_user_link();*/
    echo '">'._x('Editar Perfil', 'Header', 'iol_theme').'</a>';

    echo '&nbsp;&nbsp;';
    //Cerrar sesión
    echo '<a href="';
    echo wp_logout_url();
    echo '" title="Logout" class="noGotoMain">'._x('Cerrar Sesión', 'Header', 'iol_theme').'</a>';
} else {
    //Le damos la opción de hacer login o registrarse.

    $login_url_NC = wp_login_url();


    //LogIn
    echo '<a href="';
    echo $login_url_NC;
    echo '" title="Login">'._x('Login', 'Header', 'iol_theme').'&nbsp;|</a>';//Cambiado desde mayúsculas

    echo '&nbsp;';
    //Registrarse
    echo '<a href="';
    echo wp_registration_url();
    echo '" title="Register">'._x('Registrarse', 'Header', 'iol_theme').'</a>';//Cambiado desde mayúsculas




    echo '<div id="userName">';
    echo '<span id="spanNotUserName">'._x('No ha iniciado sesión', 'Header', 'iol_theme').'</span>' ; /*Usuario: <span id="spanUserName">' . $current_user->user_login .'</span>*/
    echo '</div>';
}

echo '</div>';
//Fin de loginStuff
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


<div id="page" class="hfeed site">

	<div id="main" class="wrapper single-lente-iol" itemscope itemtype="http://schema.org/Product">

        <div id="loadingGif"  class="loadingGeneral">
            <div id="loaderDiv"><img src="<?php echo get_stylesheet_directory_uri()."/images/ajax-loader-general.gif";  ?>" />
            </div>
        </div>
