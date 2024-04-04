<?php

$idsWhyRegisterQA =home_url( '/' ).'preguntas'; //13212
$idResultPostOp = 13157;
$idSugerIOL = 13152;
$idMiNuevoCristalino = 13168;
$idMisComunicaciones =13213;
$idMisConocimientos = 13169;//13171;


?>




<div id="whyregisterwrapper">

	<div id="whyIntroWrapper">
			<div id="whyIntroText"><?php echo _x('<span class="orange-text bold">Ventajas de registrarse</span> <span class="black-text bold">en NuevoCristalino</span>','calltoaction-home','iol_last'); ?></div>
			<div id="whyRegisterButton" class="calltobutton"><a href="<?php echo get_permalink(66); ?>"><?php echo _x('Registrarse','calltoaction-home','iol_last'); ?></a></div>
			<div style="clear:both;height:15px;">&nbsp;</div>
			<hr style="margin-top:0px;"/>
	</div>


	<ul class="whyregisterlist">
		<li class="whyregisterlistitem"><a href="<?php echo $idsWhyRegisterQA; ?>" id="whyqa"><span class="icon">&nbsp;</span><?php echo _x('Preguntarás tus dudas a <span class="bold">cirujanos colaboradores</span>','calltoaction-home','iol_last'); ?></a></li>



<li class="whyregisterlistitem"><a href="<?php echo get_permalink($idResultPostOp) ; ?>" id="whyrespostop"><span class="icon">&nbsp;</span><?php echo _x('Verás <span class="bold">resultados de usuarios operados</span> de tu cirugía','calltoaction-home','iol_last');?></a></li>

		<li class="whyregisterlistitem"><a href="<?php echo get_permalink($idMiNuevoCristalino); ?>" id="whyminc"><span class="icon">&nbsp;</span><?php echo _x('Verás <span class="bold">información seleccionada</span> para tí.','calltoaction-home','iol_last'); ?></a></li>
		<li class="whyregisterlistitem"><a href="<?php echo get_permalink($idMisComunicaciones);?>" id="whymiscom"><span class="icon">&nbsp;</span><?php echo _x('<span class="bold">Mientras que lo desees podrás recibir</span> información de interés para tu situación.','calltoaction-home','iol_last');?></a></li>
<li class="whyregisterlistitem"><a href="<?php echo get_permalink($idSugerIOL) ; ?>" id="whymilio"><span class="icon">&nbsp;</span><?php echo _x('Recibirás una <span class="bold">lista de lentes intraoculares </span> para tí.','calltoaction-home','iol_last'); ?></a></li>
		<li class="whyregisterlistitem"><a href="<?php echo get_permalink($idMisConocimientos); ?>" id="whymiscono"><span class="icon">&nbsp;</span><?php echo _x('Comprobarás si <span class="bold">sabes lo suficiente</span> para entender tu cirugía.','calltoaction-home','iol_last'); ?></a></li>
	</ul>

	<div style="clear:both; height:10px;">&nbsp;</div>

</div>
