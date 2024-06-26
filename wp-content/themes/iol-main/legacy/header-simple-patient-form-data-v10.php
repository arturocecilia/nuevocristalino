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
    /*
            global $wp;
            $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
            $pathAp = substr_count ( $current_url , "/")-2;
            $added = str_repeat("../",$pathAp);

         echo '<link rel="stylesheet" href="'.$added.'wp-content/themes/iol/fonts/fontsIE-'.get_locale().'.css"  type="text/css" media="all" />';*/
   ?>


<?php

        global $ncWPSitesCountry;
        global $siteCountry;




        include ("gAnalytics.php");

        include ('hrefLang.php');



 ?>


<style>

#v10 #primary{
  width: 100%;
  padding-left: 0px;
  padding-right: 0px;
}

.swMain ul.anchor li a{

  width: 205px;
}
#top-header-menu ul li a{
  margin-top: 4px;
}

#top-header,#footer-wrap {
    background-color: #f2f2f2;
  }
#top-header-menu ul li a, #wsIcon a,div.iolInfoInClinic{
  color:#888888;
}
footer[role="contentinfo"] a{
  color: #0395c1 !important;
  font-family: Roboto-Medium;
  font-size: 17px;
}

footer[role="contentinfo"]{
  border-bottom: 2px solid #FFFFFF;/*888888*/
  padding-bottom: 13px;
}

span.edit-link{
  display: none;
}

body.page-template-template-v10questionnaire #primary #content h1
{
color:#808080;/*509cbe;/*#3399ff;*/
background: none;
padding-left: 5px;
font-size: 25px !important;
}

.swMain ul.anchor li a.selected,.swMain .buttonNext{
  background: #ffa33c;
}
.swMain ul.anchor li a.done{
  color:#3399ff;/*#509cbe;*/
}

div.sIntroWrapper{
  margin-top: 50px;
  margin-bottom: 50px;
  max-width: 96%;
  margin-left: auto;
  margin-right: auto;
}

body.page-template-template-v10questionnaire ul li{
  font-size: 18px;
      font-family: Roboto-Medium;
      margin-top: 15px;
}

#wizard.swMain{
  margin-bottom: 130px;
}

/* inputs */
/*left con floatFixer*/
.question_bloq.left label{
  float: left;
  width: 20%;
}

.question_bloq.left{
  width: 96% !important;
  margin-left: auto !important;
  margin-right: auto!important;
  padding-bottom: 5px !important;
  padding-top: 15px !important;
}
#wizard.swMain div.stepContainer > div.content .question_bloq.grey{
    background: #e2e2e2 !important;
    min-height: 0px !important;
    border: 1px solid #4d4d4d !important;
    padding-right: 0px;
    padding-left: 0px;
    margin-right: auto !important;
    margin-left: 2% !important;
}

.question_bloq.grey span.title_question{
  font-family: 'Roboto-Bold' !important;
  font-size: 18px !important;
}

div.question_bloq.grey div.question_number{
  background: #ffffff;
  margin-top: 14px;
  color:#003967;
}
.question_bloq.grey div.input_wrapper{
  float: left;
  width: 50%;
}


#id_inputs_post_GradGlasNeed img{

}


@media (max-width: 640px){


h2.patform-title{
  display: none;
}


  #wizard.swMain div.stepContainer > div.content .question_bloq.grey{
      margin-right: auto !important;
      margin-left: auto !important;
  }




  .question_bloq.left{
    float: none !important;
    clear: both !important;
    margin-left: 0px !important;
    margin-right: 0px !important;
  }

  .question_bloq.left label{
    /*float: none !important;
    clear: both !important;*/
    width: auto !important;
    margin-bottom: 5px !important;
    min-height: 10px;
  }
div.question_bloq.left  div.question_number{
  margin-left: 10px !important;
  margin-right: 10px !important;
}
.question_bloq.grey div.input_wrapper{
  width: 100%;
text-align: center;
margin-bottom: 17px;

}


}
</style>


</head>


<body <?php body_class(); ?> id="<?php echo 'v10'; get_locale()?>">

	<?php //ponemos aquí los links para cambio de versión si el dispositivo es más pequeño


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


  <div id="top-header">
       <!-- Ini HeaderWrapper -->
          <div id="top-header-wrapper">
              <!-- Ini HeaderRelative -->
          <div id="top-header-menu">


            <!-- Ini iconosWrapper -->

               <?php
                      wp_nav_menu( array('menu' => 'top-menu-simple-patient-form') );
               ?>

               <!-- Fin IconosWrapper -->

               <?php
               //Primero cargamos el logged y luego el $_GET

               $iolSelected= 'Ninguna';
               $idClinicGet ='';
               $idSurgeonGet='';

               if(!empty($_GET)){


              $getDecoded = array();
             	foreach($_GET as $key=>$value){

             	if(urldecode(base64_decode($key)) == 'idq'){
             		$IDQ = urldecode(base64_decode($value));
             	}

             	}

             	$qGetDecodedValues = 'SELECT * FROM `questionnaires_sent` WHERE id='.$IDQ.' ';
             	$getDecoded = $wpdb->get_row($qGetDecodedValues,ARRAY_A );




                $iolSelected = get_the_title($getDecoded['iol_id']);
                echo '<!-- En el get: '.$getDecoded['iol_id'].'-->';
                $idClinicGet = $getDecoded['clinic_id'];
          			$idSurgeonGet = $getDecoded['sxs_id'];

               }else{
                $getDecoded = array();
               }


//Esta parte habrá que meterla en una función en algún momento.


////Sacamos el campo custom desde los valores pasados por el POST.
if(is_user_logged_in() ){
	//Chequeamos que el usuario logeado es profesional
	if(get_user_meta(get_current_user_id(),'ncusertype', true) == 'prof'){
		//Chequeamos que el usuario logeado está en la tabla nc_userprof_clinic (si se trata de la variable sxs_id )

		//Tenemos que ver si la variable post_clinicSx viene el get.

		if( ($idClinicGet == '' ) && ( $idSurgeonGet == '' ) ){ //Si el usuario está logueado y no se han pasado correctamente los GET => Pillamos los defaults.


			$get_defaultsCustomQuery =  'SELECT * FROM nc_userprof_clinic WHERE default_value = 1 and user_prof_id = '.get_current_user_id().' ';//'.get_current_user_id().'
			$get_defaultsCustom =  $wpdb->get_row($get_defaultsCustomQuery,ARRAY_A);
      $getDecoded =$get_defaultsCustom;
		}
	}
}






//fin de la parte a meter en función



               if($get_defaultsCustom){
                 $iolSelected = get_the_title($getDecoded['iol_id']);
                 echo '<!-- Logged IOL: '.$getDecoded['iol_id'].'-->';
                 echo '<!-- Logged Clinic: '.$getDecoded['clinic_id'].'-->';
               }



      echo '<div class="iolInfoInClinic">Lente Intraocular seleccionada: <span style="font-family:Roboto-Bold">'.$iolSelected.'</span></div>';





               ?>





      </div>




</div>


  </div>




<!-- -->

<!-- Ini IconosLoginHeader -->
<div id="main-header" class="simple-form">

<div id="main-header-wrapper">

  <!-- Ini Logo-->
  <div id="logo" class="simple-patient-form">

   <?php



  $thumbnail = get_the_post_thumbnail($getDecoded['clinic_id']);



 echo $thumbnail;




    ?>
<!--       <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/header/logotipo-nuevo-cristalino-<?php echo get_locale(); ?>.png" alt="<?php echo _x('Ir a Nuevo Cristalino','alt home','iol_theme'); ?>"/>
<h1><?php //echo _x('Transparencia en cirugía intraocular','Header','iol_theme');  ?></h1 >
-->

  </div>
  <!-- Fin logo -->




<!-- Fin iconosLoginHeader -->

<!-- Fin iconosLoginHeader -->
<!-- Fin Iconos Login Header -->











<!-- INI Old Position Iconos Login Header -->

<!-- FIN Old PositionIconos Login Header -->





        <h2 class="patform-title">Satisfacción de pacientes tras la Cirugía Intraocular</h2>

    <!-- Redesign stuff -->
   <!--  <div id="menu-shadow" class="startsUgly">
      <img alt="shadow" src="<?php echo get_stylesheet_directory_uri(); ?>/images/header/sombra.png"/>
    </div>-->
    <!-- End Redesign stuff -->


  <div class="floatFixer">&nbsp;</div>

</div>


<!-- Fin HeaderRelative -->
    </div>
<!-- Fin HeaderWrapper -->









<!-- -->




















<?php if(is_home()){
  $is_home_class= 'is-home';
}else{
  $is_home_class = '';
} ?>
<div id="page" class="hfeed site <?php echo $is_home_class; ?>">

<?php
  if(is_page_template( array('template-presbicia.php','template-cataratas.php','template-cirugia-ocular.php'))){
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

<?php } ?>



	<div id="main" class="wrapper">

        <div id="loadingGif" class="loadingGeneral">
            <div id="loaderDiv"><img src="<?php echo get_stylesheet_directory_uri()."/images/ajax-loader-general.gif";  ?>" />
            </div>
        </div>
