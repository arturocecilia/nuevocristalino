<?php
	
$eslang = array('es_ES','es_MX','es_CL','es_CO');	
	
	if(in_array(get_locale(), $eslang)){
		
		$podcast1= 'Escucha nuestro podcast';
		$podcast2= 'y encuentra la solución';
		$podcast3= 'a tus dudas';
		
		$podcastId = 17400;
		$podcastperma = get_permalink($podcastId);
		$podcastpermadownload = $podcastperma.'?wpdmdl='.$podcastId;
		/**/
		$ebook1 = 'Descárgate el ebook';
		$ebook2 = 'con toda la información que necesitas';
		
		if(get_locale() == 'es_ES'){
			$ebookId = 17834;
		}
		
		if(get_locale() == 'es_MX'){
			$ebookId = 18022;
		}

		if(get_locale() == 'es_CL'){
			$ebookId = 18028;
		}

		if(get_locale() == 'es_CO'){
			$ebookId = 18025;
		}


		
		$ebookperma = get_permalink($ebookId);
		$ebookpermaDownload = $ebookperma.'/?wpdmdl='.$ebookId;
		
	
//		$messageTitle = "You have to be logged-in to download this content";
		$messageTitle = "Tiene que haber iniciado sesión para descargar este contenido.";
//		$registerLinkIni ='If you are not registered, remembre you can';
		$registerLinkIni ='Si no está registrado, recuerde que puede';
//		$registerLinkText = 'register for free';
		$registerLinkText = 'registrarse de forma gratuita.';
				
//		$loggedLinkIni = 'If you already have your own user, please do';
		$loggedLinkIni = 'Si ya tiene su propio usuario, por favor';
//		$loggedLinkText = 'login';
		$loggedLinkText = 'inicie sesión';
	}
	
	if(get_locale() == 'de_DE'){
		
		$podcast1= 'Hören Sie unseren Podcast';
		$podcast2= 'und erfahren Sie mehr über';
		$podcast3= 'den Grauen Star.';
		
		$podcastId = 17400;
		$podcastperma = get_permalink($podcastId);
		$podcastpermadownload = $podcastperma.'?wpdmdl='.$podcastId;
		
		/**/
		$ebook1 = 'Ganz neu können sie jetzt unser ebook';
		$ebook2 = 'mit unfangreicher Information herunterladen.';
		$ebookId = 17395;
		$ebookperma = get_permalink($ebookId);
		$ebookpermaDownload = $ebookperma.'?wpdmdl='.$ebookId;
		
		$registerPageUrl = get_permalink(66);
		$loginPageUrl = get_permalink(64);
		//"You have to be logged-in to download this content";
		$messageTitle = 'Sie müssen eingeloggt sein, um den Inhalt laden zu können. ';
		//'If you are not registered, remembre you can';
		$registerLinkIni ='Falls Sie noch nicht registriert sind, ';
		//register for free
		$registerLinkText = 'Sie können sich hier kostenfrei anmelden.';
		 
		//If you already have your own user, please do
		$loggedLinkIni = 'Falls Sie sich schon registriert haben,';
		//login
		$loggedLinkText = 'loggen Sie sich bitte ein.';	
	}	
	
	
if(is_user_logged_in()){

	$refreshHomePage = 'location.href=url;console.log(url);';
			
	$jspodcastHref = ' location.href="'.$podcastpermadownload.'";return false;';
	$jspodcastTrackingEvent = "ga('send', 'event', 'Podcast', 'Download Success', window.location.href, '0');";
			
	$jsfunctionpodcast = 'jQuery(".inline.podcast").on("click", function(){'.$jspodcastTrackingEvent.$jspodcastHref.'});';

	$jsebookHref = 'location.href="'.$ebookpermaDownload.'";return false;';
	$jsebookTrackingEvent = "ga('send', 'event', 'Ebook', 'Download Success',window.location.href, '0');";

	$jsfunctionebook = 'jQuery(".inline.ebook").on("click", function(){'.$jsebookTrackingEvent.$jsebookHref.'});'; 
	
	}else{
	$nonLoggedPodcastTrack = "ga('send', 'event', 'Podcast', 'Download Try',window.location.href, '0'); console.log('ga enviado');";
	$jsfunctionPodcastTrackingNonLogged ='jQuery(".inline.podcast").on("click",function(){'.$nonLoggedPodcastTrack.'});';
		
	$nonLoggedEbookTrack = "ga('send', 'event', 'Ebook', 'Download Try', window.location.href, '0'); console.log('ga enviado');";
	$jsfunctionEbookTrackingNonLogged ='jQuery(".inline.ebook").on("click",function(){'.$nonLoggedEbookTrack.'});';
		
		
		$jsfunctionpodcast = 'jQuery(".inline.podcast").colorbox({inline:true, padding:"30px"});'; //, width:"50%"
		$jsfunctionebook = 'jQuery(".inline.ebook").colorbox({inline:true, padding:"30px"});'; //, width:"50%"
	}
	
?>

<script>

	jQuery(document).ready(function(){
		

		
		<?php echo $jsfunctionPodcastTrackingNonLogged; ?>
		<?php echo $jsfunctionEbookTrackingNonLogged; ?>
		
		<?php echo $jsfunctionpodcast;?>
		<?php echo $jsfunctionebook;?>	
	
	});
</script>

<?php  
	//echo do_shortcode('[wpdm_direct_link id=17395 link_label="nothing"]');
	 ?>
<div class="only-ebook">
	<div class="podcastebookWrapper">
	<!--
	<a href="#inline_contentpodcast" class="inline podcast noGotoMain" >
	<div class="podcastbanner-home  <?php echo get_locale(); ?>"  ?>
		<div class="blackpodcasttext">	<?php 	echo $podcast1; ?></div>
	    <div class="blackpodcasttext">	<?php 	echo $podcast2; ?></div>
  	    <div class="orangepodcasttext">	<?php 	echo $podcast3; ?></div>  	
	</div>
	</a>
	-->
	<!-- -->
	<a href="#inline_contentebook" class="inline ebook noGotoMain">
	<div class="ebookbanner-home  es"> <!-- <?php echo get_locale(); ?>  onclick="<?php echo $onclickebook;?>" -->
		<div class="blackebooktext">	<?php 	echo $ebook1; ?></div>
	    <div class="orangeebooktext">	<?php 	echo $ebook2; ?></div>
	</div>
	</a>
	<div style="clear:both;"></div>
</div>
</div>


		<!-- This contains the hidden content for inline calls -->
<div style='display:none'>
	<div id='inline_contentpodcast' style='padding:10px; background:#fff;'>
	<p><strong style="color:#ffb347;"><?php echo $messageTitle; ?></strong></p>
	<br />
	<p> <?php echo $registerLinkIni; ?> <a class="noGotoMain" href="<?php echo $registerPageUrl; ?>"><?php echo $registerLinkText;?></a></p>
	<br />
	<p><?php echo $loggedLinkIni; ?> <a class="noGotoMain" href="<?php echo $loginPageUrl;?>"><?php echo $loggedLinkText;?></a>.</p>
			
	</div>
</div>

<div style='display:none'>
	<div id='inline_contentebook' style='padding:10px; background:#fff;'>
	<p><strong style="color:#ffb347;"><?php echo $messageTitle; ?></strong></p>
	<br />
	<p> <?php echo $registerLinkIni; ?> <a class="noGotoMain" href="<?php echo $registerPageUrl; ?>"><?php echo $registerLinkText;?></a></p>
	<br />
	<p><?php echo $loggedLinkIni; ?> <a class="noGotoMain" href="<?php echo $loginPageUrl;?>"><?php echo $loggedLinkText;?></a>.</p>
	</div>
</div>	
	
	
	
	