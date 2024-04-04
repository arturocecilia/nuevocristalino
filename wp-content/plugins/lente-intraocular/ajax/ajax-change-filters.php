<?php


function getPatientForm(){
	global $iolPluginDirectory;
	//Incluimos antes los botones.
	
	//include($iolPluginDirectory.'change-version-getFilters.php');	
					echo '<div id="changeFilter">';
                        						
                        echo '<a data-action="getAdvForm" href="#" >';
                        
                        //echo 'AYUDA BÚSQUEDA LENTES';
                        //.$filtAvanzado.
                        include(ABSPATH . 'wp-content/plugins/lente-intraocular/change-version-template-modelos-iol.php');	
                        echo '</a>';
					//'Ver Filtros Avanzados para Oftalmólogos','Single Lente Intraocular','clinica_cpt_display'

                    echo '</div>';
	
	include( $iolPluginDirectory . 'archive-patient-form.php');
	die();
}

function getAdvForm(){

	global $iolPluginDirectory;
	//Incluimos antes los botones.
	
//	include($iolPluginDirectory.'change-version-getFilters.php');
	
	if(current_user_can('manage_options')){
		//echo 'Por aquí viene';
	}
	
	
					echo '<div id="changeFilter">';

                   		echo '<a data-action="getPatientForm" href="#" >';
                        //echo 'AYUDA BÚSQUEDA LENTES';
                   		//.$filtSimple.
                   		include(ABSPATH . 'wp-content/plugins/lente-intraocular/change-version-template-modelos-iol.php');	
                   		
                   		echo '</a>';

						/*echo '<button id="advLoader" type="radio" data-action="getAdvForm">Menú Avanzado</button>';
    					echo '<button id="patientLoader"type="radio" data-action= "getPatientForm">Menú Sencillo</button>';*/
					
                    echo '</div>';

	include($iolPluginDirectory . 'right-archive-lente-intraocular.php');
	die();
}


//Le pasaremos un parámetro dentro de la cadena queryString. postId
//redefiniremos la variable $post
function getSinglePatientForm(){
	global $iolPluginDirectory;
	
	//Cogemos el id del post y 'pisamos' la variable $post.
	if(array_key_exists('postId',$_GET)){
		$postId = $_GET['postId'];
		$post = get_post($postId);
	}
	
//		include($iolPluginDirectory.'change-version-getFilters.php');
	
	//Incluimos antes los botones.
					echo '<div id="changeFilter">';

                                           echo '<a data-action="getSingleAdvForm" href="#" >';//
                                           //.$filtAvanzado.
                                           include(ABSPATH . 'wp-content/plugins/lente-intraocular/change-version-single-iol.php');	

                                           
                                           echo '</a>';
                                           //Ver Filtros Avanzados para Oftalmólogos


                    echo '</div>';
	
	include( $iolPluginDirectory . 'single-patient-form.php');
	die();
}

function getSingleAdvForm(){

	global $iolPluginDirectory;
	
	//Cogemos el id del post y 'pisamos' la variable $post.
	if(array_key_exists('postId',$_GET)){
		$postId = $_GET['postId'];
		$post = get_post($postId);
	}
	
		//	include($iolPluginDirectory.'change-version-getFilters.php');
	
	//Incluimos antes los botones.
					echo '<div id="changeFilter">';
                        echo '<a data-action="getSinglePatientForm" href="#" >';
                        //.$filtSimple.
                        include(ABSPATH . 'wp-content/plugins/lente-intraocular/change-version-template-modelos-iol.php');	

                        echo '</a>';
                        //Ver Filtros Simples para Pacientes 
					
                    echo '</div>';

	include($iolPluginDirectory . 'right-single-lente-intraocular.php');
	die();
}

?>