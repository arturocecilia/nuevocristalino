<?php 
    
    /*
            $filtAvanzado = _x('Ver Filtros Avanzados para Oftalmólogos','Single Lente Intraocular','clinica_cpt_display');
            $filtSimple   = _x('Ver Filtros Simples para Pacientes','Single Lente Intraocular','clinica_cpt_display');
            
            //Lo anterior eran los valores por defecto. Queremos que el usuario perciba el concepto de "Versión".
            $langChange = substr(get_locale(),0,2);
            
            
            if($langChange =="es"){
            $filtAvanzado 	= "NuevoCristalino modo <strong>PACIENTE</strong> <BR />Cambiar a modo <i>Profesional</i>";
            $filtSimple		= "NuevoCristalino modo <strong>PROFESIONAL</strong> <BR />Cambiar a modo <i>Paciente</i>";
            echo '<style>#preButtonSetSingle #helpTitle a{top:2px !important;}</style>';
            
            }
            
                        if(get_locale() == 'en_GB'){
            $filtAvanzado 	= "NewLens is in <strong>PATIENT</strong> mode <BR />Change mode to <i>Professional</i>";
            $filtSimple		= "NewLens is in <strong>PROFESSIONAL</strong> mode <BR />Change mode to <i>Patient</i>";
            echo '<style> #preButtonSet #searchReset{top:-26px;} #helpTitle a{top:-53px !important;} </style>';
            }
            
            if(get_locale() == 'en_US'){
            $filtAvanzado 	= "MylefStyleLens is in <strong>PATIENT</strong> mode <BR />Change mode to <i>Professional</i>";
            $filtSimple		= "MylefStyleLens is in <strong>PROFESSIONAL</strong> mode <BR />Change mode to <i>Patient</i>";
            echo '<style> #preButtonSet #searchReset{top:-26px;} #helpTitle a{top:-53px !important;} </style>';
            }*/
            
            

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
            $prof	= 'Professional';
            $chMode = 'Change Mode:';
            }
           if($langChange == 'de'){
			$mode 	= 'Modus';
            $pte	= 'Patient';
            $prof	= 'Augenarzt<br />Augenoptiker';
            $chMode = 'Wechsel Ansicht:';
            $helpCM	= 'HILFE IOL-SUCHE';
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
}*/
/*
if (defined('DOING_AJAX') && DOING_AJAX && $getForm) { 
      if($paciente){
         $paciente = false;
         $profesional = true;
      	}else{
      	 $paciente = true;
      	 $profesional = false;
      	 
      	}
      } */     


if((($langChange =='es')||($langChange =='de')||(get_locale() == 'en_GB')||(get_locale() == 'en_US')) && ($paciente) ){

if(current_user_can('manage_options')){

}


echo '<div class="contentModeBloq">';
echo '<div class="changeModeIcons" >';
echo '<a data-action="getSingleAdvForm" href="#" id="changeModeLink" >';//getAdvForm
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

if((($langChange =='es')||($langChange =='de')||(get_locale() == 'en_GB')||(get_locale() == 'en_US')) && ($profesional)){


echo '<div class="contentModeBloq">';
echo '<div class="changeModeIcons" >';
echo '<a data-action="getSinglePatientForm" href="#" id="changeModeLink" >';//getPatientForm
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