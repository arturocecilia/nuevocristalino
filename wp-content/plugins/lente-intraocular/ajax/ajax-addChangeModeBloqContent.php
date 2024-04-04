<?php 
function addChangeModeBloqContent(){
	
            //Lo anterior eran los valores por defecto. Queremos que el usuario perciba el concepto de "Versi—n".
            $langChange = substr(get_locale(),0,2);
            
            
            if($langChange =="es"){
            $mode 	= 'Modo';
            $pte	= 'Paciente';
            $prof	= 'Profesional';
            $chMode = 'Cambiar modo de Visualización:';
            $helpCM	= 'AYUDA BÚSQUEDA LENTES';      
            }
            
            if((get_locale() == 'en_GB') || ($langChange =="fr")){
            $mode 	= 'Mode';
            $pte	= 'Patient';
            $prof	= 'Professional';
            $chMode = 'Change Mode:';
            $helpCM	= 'IOL SEARCH HELP';
            }
            
            if(get_locale() == 'en_US'){
			$mode 	= 'Mode';
            $pte	= 'Patient';
            $prof	= 'Professional';
            $chMode = 'Change Mode:';
            $helpCM	= 'IOL SEARCH HELP';
            }
            if($langChange == 'de'){
			$mode 	= 'Modus';
            $pte	= 'Patient';
            $prof	= 'Augenarzt<br />Augenoptiker';
            $chMode = 'Wechsel Ansicht:';
            $helpCM	= 'HILFE IOL-SUCHE';
            }
            


if($_COOKIE['ncpatient']== 'ncpatient'){ //(($langChange =='es')||(get_locale() == 'en_GB')||(get_locale() == 'en_US'))
	
//La condición anterior no vale con sólo la presencia de la cookie
if(current_user_can('manage_options')){
	//echo 'El valor de la cookie ahora es: '.$_COOKIE['ncpatient'].'y cumple la condición de $_cooki';
}	
	
echo '<div class="contentModeBloq">';
echo '<a href="'.get_permalink(2838).'" id="changeModeHelp">';
echo $helpCM;
echo '</a>';
echo '<div class="changeModeIcons" >';
echo '<a href="#" id="changeModeLink" >';
//Ponemos span dentro del link de cambio y con sus propiedades simularemos que son links.

echo '<span class="changeVTitle">'.$chMode.'</span>';

echo '<span class="pteChangeVersion active">';

echo '<span class="modeSpan">';
echo $mode;
echo '</span>';


echo '<span class="modeSpanActive modePte">';
echo $pte;
echo '</span>';

echo '<span style="clear:both; height:0px;">&nbsp;</span>';
echo '</span>';
echo '<span class="profChangeVersion">';
echo '<span  class="modeSpan">';
echo $mode;
echo '</span>';

echo '<span class="modeSpanInactive modeProf">';
echo $prof;
echo '</span>';
echo '<span style="clear:both; height:0px;">&nbsp;</span>';
echo '</span>';


echo '<div style="clear:both;height:0px">&nbsp;</div>';
echo '</a>';

echo '<div style="clear:both; height:0px">&nbsp;</div>';
echo '</div>';
echo '</div>';

}

if( !($_COOKIE['ncpatient']== 'ncpatient') ){//(($langChange =='es')||(get_locale() == 'en_GB')||(get_locale() == 'en_US'))

echo '<div class="contentModeBloq">';
echo '<a href="'.get_permalink(2838).'" id="changeModeHelp">';
echo $helpCM;;
echo '</a>';
echo '<div class="changeModeIcons" >';
echo '<a href="#" id="changeModeLink" >';
//Ponemos span dentro del link de cambio y con sus propiedades simularemos que son links.

echo '<span class="changeVTitle">'.$chMode.'</span>';

echo '<span class="pteChangeVersion">';

echo '<span class="modeSpan">';
echo $mode;
echo '</span>';


echo '<span class="modeSpanInactive modePte">';
echo $pte;
echo '</span>';

echo '<span style="clear:both; height:0px;">&nbsp;</span>';
echo '</span>';
echo '<span class="profChangeVersion active">';
echo '<span  class="modeSpan">';
echo $mode;
echo '</span>';

echo '<span class="modeSpanActive modeProf">';
echo $prof;
echo '</span>';
echo '<span style="clear:both; height:0px;">&nbsp;</span>';
echo '</span>';


echo '<div style="clear:both;height:0px">&nbsp;</div>';
echo '</a>';

echo '<div style="clear:both; height:0px">&nbsp;</div>';
echo '</div>';
echo '</div>';
}




	die();
}?>