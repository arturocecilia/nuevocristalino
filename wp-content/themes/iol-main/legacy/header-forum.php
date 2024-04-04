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
<meta charset="<?php bloginfo( 'charset' ); ?>" />
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

<script type="text/javascript" charset="utf-8">
//Función para dar propiedades a menú la url se correpnde con el link al que a te lleva.
jQuery(function() {
	
  jQuery('#menu-menu-blog li a').each(function() {
    if (jQuery(this).attr('href')  ===  location.href) {
	  jQuery(this).addClass('selected');
    }
  });
});  
//]]>
</script>

    <?php 
            global $wp;
            $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
            $pathAp = substr_count ( $current_url , "/")-2;
            $added = str_repeat("../",$pathAp);
        

         echo '<link rel="stylesheet" href="'.$added.'wp-content/themes/iol/fonts/fontsIE-'.get_locale().'.css"  type="text/css" media="all" />'; 
   ?>



<?php include ("gAnalytics.php");
	        if(get_locale() != 'de_DE'){
	        include('gAdsense.php'); 
	        }
	 		if( (get_locale() == 'es_CO') || (get_locale() == 'es_CL') || (get_locale() == 'es_MX') || (get_locale() == 'es_ES') ){
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
  js.src = "//connect.facebook.net/<?php echo get_locale();?>/sdk.js"; //#xfbml=1&version=v2.4
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

</script>
<!-- -->	
	
	

	<?php //ponemos aquí los links para cambio de versión si el dispositivo es más pequeño 
	

            $langChange = substr(get_locale(),0,2);
            
            $foro = _x('foro-de-lentes-intraoculares-presbicia-y-cataratas','foro-slug','iol_theme');
            if($langChange == "es"){
            	$mob 	= 'Versión Móvil';
            	$clas	= 'Versión Clásica'; 
            	$foro = 'foros-de-lentes-intraoculares-presbicia-y-cataratas';
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

    <div id="wrapper-header-foro">
    	<div id="wrapper-top-foro">
            <div id="top-header-foro">
            	<div id="logo-header-foro">
            		
            		
            		
            		
            		
            		
          			<a href="<?php echo get_bloginfo("url").'/'.$foro.'/'; ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/header/logo-forum-nc-<?php echo get_locale();?>.png" alt="<?php echo _x('Nuevo Cristalino','Site Name','iol_theme'); ?>"/></a>
                </div>
                <div id="widget-header-forum">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('menu-forum') ) : ?>  
      <?php endif; ?> 
                </div>
            </div>
        </div>
        <div id="wrapper-down-foro">
            <div id="menu-header-foro">
            	<?php  wp_nav_menu(array('theme_location'=>'Menu-forum')); ?>
            </div>
        </div>
    </div>

    
	<div id="page" class="hfeed site">
	<header id="masthead" class="site-header-foro" role="banner">
	</header><!-- #masthead -->

	<div id="main" class="wrapper">

        <div id="loadingGif"  class="loadingGeneral">
            <div id="loaderDiv"><img src="<?php echo get_stylesheet_directory_uri()."/images/ajax-loader-general.gif";  ?>" />
            </div>
        </div> 