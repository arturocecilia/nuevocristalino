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

<script type="text/javascript" charset="utf-8">
//Función para dar propiedades a menú la url se correpnde con el link al que a te lleva.
jQuery(function() {

  jQuery('#menu-menu-cat-qa li a').each(function() {
	console.log('click detectado');
		if (jQuery(this).attr('href')  ===  location.href) {

	  jQuery(this).addClass('selected');
	}else{
		jQuery(this).removeClass('selected');
	}
  });
});
//]]>
</script>


    <?php
            global $wp;
            $current_url = add_query_arg($wp->query_string, '', home_url($wp->request));
            $pathAp = substr_count($current_url, "/")-2;
            $added = str_repeat("../", $pathAp);


         echo '<link rel="stylesheet" href="'.$added.'wp-content/themes/iol/fonts/fontsIE-'.get_locale().'.css"  type="text/css" media="all" />';
   ?>

<?php include("gAnalytics.php");
            if (get_locale() != 'de_DE') {
                include('gAdsense.php');
            }
            if ((get_locale() == 'es_CO') || (get_locale() == 'es_CL') || (get_locale() == 'es_MX') || (get_locale() == 'es_ES')) {
                include('gAdsense-adverts');
            }

            ?>

</head>

<body <?php body_class(); ?>  id="<?php echo get_locale();?>">


<!-- AÑADIMOS EL Código de facebook -->
<div id="fb-root"></div>
<script>

window.fbAsyncInit = function() {
    FB.init({
      appId      : '1815818898644520',
      xfbml      : true,
      version    : 'v2.4'
    });
  };

	(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/<?php echo get_locale();?>/sdk.js"; //es_ES    #xfbml=1&version=v2.4
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

</script>
<!-- -->




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

    <div id="top-header-qa">
    	<div id="wrapper-header-qa">

          <div id="menu-foro">
          	<?php  wp_nav_menu(array('theme_location'=>'Menu-QA')); ?>
          </div>
      	</div>
    </div>

    <div id="raya"></div>

	<div id="page" class="hfeed site">

	<!-- Metemos el menú de categorías -->
	<?php if (1) { //current_user_can('manage_options')
        echo   '<div id="menu-foro">';
        wp_nav_menu(array('theme_location'=>'Menu-cat-QA'));
        echo '</div>';
    } ?>
    <div style="height:0px;clear:both;">&nbsp;</div>
	<!-- Fin del Menu de categorías -->

	<header id="masthead" class="site-header-foro" role="banner">
    <div id="logo-foro">
          	<a href="<?php echo get_bloginfo('url')."/"._x('preguntas-de-lentes-intraoculares-presbicia-y-cataratas', 'qa-slug', 'iol_theme').'/'; ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/qa/logo-qa-nc-<?php echo get_locale();  ?>.png" alt="logo <?php echo _x('Nuevo Cristalino', 'Site Name', 'iol_theme'); ?>"/></a>
          </div>
	</header><!-- #masthead -->

	<div id="main" class="wrapper">

        <div id="loadingGif"  class="loadingGeneral">
            <div id="loaderDiv"><img src="<?php echo get_stylesheet_directory_uri()."/images/ajax-loader-general.gif";  ?>" />
            </div>
        </div>
