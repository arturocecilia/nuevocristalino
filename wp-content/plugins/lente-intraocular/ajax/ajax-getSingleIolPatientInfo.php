<?php 
function getSingleIolPatientInfo(){
	
	//echo 'Function ejectuada';
	
$strLangSingleIOL = substr(get_locale(),0,2);	

if($strLangSingleIOL =='es'){
echo '<div id="fullSingleIolPatientInfo" class="pteDisplay">';
echo '<h3 class="blue">Recuerde que los <span style="color:#FEA63C;">Resultados de la Operación</span> dependen directamente de la <span style="color:#FEA63C;">Elección de la Lente Intraocular.</span></h3>';
echo '<br />';
echo '<div id="iolPatientIolInfoWrapper">';
echo '<div id="leftPatientIolInfoWrapper">';
echo '<span class="firstPoint">';
echo '<span style="color:#003B61;">1 -&nbsp;</span> Por favor no dude en <a style="text-decoration:none;" href="'. get_bloginfo('url').'/'._x('preguntas-de-lentes-intraoculares-presbicia-y-cataratas','qa-slug','iol_theme').'">preguntar</a> a nuestros cirujanos colaboradores sobre esta lente y sobre cualquier otra duda que tenga en relación con su operación.';
echo '<br /><br />';
echo '&nbsp;&nbsp;Si lo prefiere mándenos un email y se la publicaremos nosotros de manera anónima.';
echo '</span>';
echo '</div>';

echo '<div id="rightPatientIolInfoWrapper">';
echo '<span class="secondPoint">';
echo '<span style="color:#003B61;">2 -&nbsp;</span>Vea la <a style="text-decoration:none;" href="'.get_permalink(9638).'">Lista Simplificada de Modelos de lente Intraocular para Pacientes</a> que se van a operar de cataratas o presbicia. ';
echo '</span>';
echo '<span class="thirdPoint">';
echo '<span style="color:#003B61;">3 -&nbsp;</span>Ya puede conocer los <a style="text-decoration:none;" href="'. get_bloginfo('url').'/lente-intraocular/tipo-lente/lente-premium/">principales modelos de lente intraocular premium</a> disponibles en el mercado.';
echo '</span>';
echo '</div>';
echo '<div style="height:0px; clear:both;">&nbsp;</div>';
echo '</div>';
echo '<div style="height:0px; clear:both;">&nbsp;</div>';
echo '</div>';
}

	die();
}?>