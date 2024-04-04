<?php

                        //Lo anterior eran los valores por defecto. Queremos que el usuario perciba el concepto de "Versi—n".
            $langChange = substr(get_locale(),0,2);
            
            
            if($langChange =="es"){
            $mode 	= 'Modo';
            $pte	= 'Paciente';
            $prof	= 'Profesional';
            $chMode = 'Cambiar modo de Visualización:';
            $helpCM	= 'AYUDA BÚSQUEDA LENTES';      
            }
            
            if(get_locale() == 'en_GB'){
            $mode 	= 'Mode';
            $pte	= 'Patient';
            $prof	= 'Professional';
            $chMode = 'Change Mode:';
            }
            
            if(get_locale() == 'en_US'){
			$mode 	= 'Mode';
            $pte	= 'Patient';
            $prof	= 'Eye Professional';
            $chMode = 'Change Mode:';
            }
           if($langChange == 'de'){
			$mode 	= 'Modus';
            $pte	= 'Patient';
            $prof	= 'Augenarzt<br />Augenoptiker';
            $chMode = 'Wechsel Ansicht:';
            $helpCM	= 'HILFE IOL-SUCHE';
            }
            
//Nos podemos definir esta variable antes del include no?

if(current_user_can('manage_options')){
	//echo 'El valor de $paciente es: '.$paciente;
}


if(!isset($paciente)){

if(current_user_can('manage_options')){
	//echo 'El valor de $paciente era null';
}


$paciente    = $_COOKIE['ncpatient'];
} else{
$paciente;
}


if($paciente){
	$profesional = FALSE;
		}else{
				$profesional = TRUE;
	}
            
//En el caso de las peticiones ajax la cookie se pone cuando se ha remplazado el contenido con éxito con lo que es al contrario
/*
if($_GET['getform']){
	$getForm = TRUE;
	if(current_user_can('manage_options')){
	//echo 'SIIIIII';
	}
}
*/
/*
if (defined('DOING_AJAX') && DOING_AJAX && $getForm) {  
      if($paciente){
         $paciente = false;
         $profesional = true;
      	}else{
      	 $paciente = true;
      	 $profesional = false;
      	 
      	}
      }      
*/

if( $paciente ){//(($langChange =='es')||(get_locale() == 'en_GB')||(get_locale() == 'en_US')) && (

if(current_user_can('manage_options')){
 //echo 'Cargando modo paciente';
}


echo '<div class="contentModeBloq">';
echo '<div class="changeModeIcons" >';
echo '<a data-action="getAdvForm" href="#" id="changeModeLink" >';
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

if( $profesional ){//(($langChange =='es')||(get_locale() == 'en_GB')||(get_locale() == 'en_US')) && 

if(current_user_can('manage_options')){
 //echo 'Cargando modo profesional';
}


echo '<div class="contentModeBloq">';
echo '<div class="changeModeIcons" >';
echo '<a data-action="getPatientForm" href="#" id="changeModeLink" >';
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

?>