<?php 

function addCallToQuestion(){

$strLangCallToQuestion = substr(get_locale(),0,2);


if($strLangCallToQuestion == 'es' && $_COOKIE['ncpatient']){
	echo '<div class="contenidoCallToQuestion">';
	echo '<div class="callToTitle">¿Hay algo que no entienda?¿Tiene dudas sobre su operación?</div>';
	echo 'Si tiene cualquier duda en relación con su lente intraocular o con su cirugía de cataratas o presbicia (o intraocular corrigiendo otro defecto ), por favor no dude en <a style="font-style:italic;" href="'.get_bloginfo('url').'/'._x('preguntas-de-lentes-intraoculares-presbicia-y-cataratas','qa-slug','iol_theme').'">Preguntarnos</a>.<br /><br />';
	echo  'Le recordamos que la elección de la lente intraocular condiciona sus resultados visuales tras la cirugía, infórmese adecuadamente para poder comprender con más facilidad las recomendaciones de su oftalmólogo para su caso particular.';
	
	echo '</div>';
}
	die();
}

?>