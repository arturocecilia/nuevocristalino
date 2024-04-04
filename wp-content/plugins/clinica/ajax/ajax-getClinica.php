<?php


function getClinica(){
	global $clinicaPluginDirectory;
	//Incluimos antes los botones.
			/*		echo '<div id="changeFilter">';
						echo '<button id="advLoader" type="radio" data-action="getAdvForm">Menœ Avanzado</button>';
    					echo '<button id="patientLoader"type="radio" data-action= "getPatientForm">Menœ Sencillo</button>';
					echo '</div>';
	*/


    //Vamos a analizar el valor con el que viene la variable page -> Es lo que nos va a escupir la funci—n paginate-links
    $page = array_key_exists('page',$_GET) ? $_GET['page'] : 1;//(get_query_var('page')) ? get_query_var('page') : 1; //$_GET['paged'] ? $_GET['paged'] : 1;  

    //Vemos tambiŽn el tipo de vista seleccionado por el usuario.
   

    if(isset($_GET['viewType'])){
    	$viewType = $_GET['viewType'];
    }else{
    	$viewType = 4;
    }

    
    if($viewType!= 'Grid'){
        $viewTypeNumber = $viewType;
	    $Grid=false;
    }else{
        $Grid= true;
        $viewTypeNumber = 12;
    }


	//A continuaci—n el c—digo de template de las respuestas del filtro.
	
	     echo '<div id="AjaxContainerFixer" style="min-height:200px;"><div id="IOL_Filtradas">'; //<div id="content" role="main"> 

   // echo $queryFilter->request;
   
   if(isset($_GET['clinicaTextName'])){
   	$clinicaTextName = $_GET['clinicaTextName'];	
   }else{
    $clinicaTextName ='';
   }
   
       $args = array(
       			 'post_type'=>_x('clinica','CustomPostType Name','clinica'),
                  'post_status' => 'publish',
                  'posts_per_page' => $viewTypeNumber,
                  'orderby'=> 'meta_value_num',
                  'order'=>'DESC',
                  'meta_key'=>'nivelPrefClinicaMD',
                  'paged' =>$page,
                  'clinicaTextName'=>$clinicaTextName
                  );
   
   //'meta_key' => 'title', 'meta_value' => 'mp', 'meta_compare' => 'like', 
   $queryGetClinica = new WP_Query( $args );
   
   
   //echo $queryGetIol->request;
   

    // The Loop -> Si lo hemos hecho OK, habremos podido meter la l—gica de arriba en pre_get_posts
    if ( $queryGetClinica->have_posts() ) {
	    while ( $queryGetClinica->have_posts() ) {
	    	$queryGetClinica->the_post();
            $id= get_the_id();
            //Empezamos con el marcado de cada p‡gina en particular.
				    
             if($Grid){   
          			   get_template_part( 'content-grid-clinica');
				}else{
					get_template_part( 'content-archive-clinica', get_post_format() );
				}       
			}

        }
     else {
            
        echo '<div class="NoIolWrapper">
              <div class="innerNoneIolWrapper">
              <div id="NoIolImg">
              <img src="'.content_url().'/uploads/2013/08/noencontrado.png" />
              </div>
              <div class="NoIol">
                <p class="mensNotTitle">'._x("No hay ninguna Clínica que cumpla con los criterios de filtrado actuales.","Filter_template","clinica_display").'</p>
                <p class="mensNotMessage">'._x("Proceda a realizar una nueva bœsqueda cambiando los criterios.","Filter_template","clinica_display").'</p>
              </div>
              <div style="clear:both;height:0px;">&nbsp;</div>
              </div>
              </div>';

    }

     //Procesamos la query string para quitar el par‡metro page en caso de que nos venga puesto.
     $qString = $_SERVER['QUERY_STRING'];
     //echo 'La qstring antes de nada'.$qString.'<br /><br /><br />';
     $qString = str_replace('?','',$qString);
     parse_str($qString,$aParams);//explode("&",$qString );        
     
     //print_r($aParams);
          
     if(array_key_exists ('page',$aParams)){
         unset($aParams['page']);
     } else{
         
     }
     $paramsUrl = array();
     //Hay que hacer un url_encode de los par‡metros.
     foreach($aParams as  $clave => $valor){
         $paramsUrl[$clave] = urlencode($valor);
     }


     //echo 'Estos son los par‡metrosÁÁ'.var_dump($aParams).'<br /><br /><br />';
     //echo 'Estos son los par‡metros coidficadosÁÁ'.var_dump($paramsUrl).'<br /><br /><br />';
     //Cerramos los dos divs.
     
     //Vamos a poner en este div todos los ids de los inputs que hay que deshabilitar
     /*Esto no ser‡ necesario, puesto que son condiciones desacopladas, o por filtro o por nombre
  	$cssUndefinedMetaDataSelector =  join(", ",$UndefinedMetaDataSelector);
    echo '<div id="inputSelectorsToDisable" style="display:none;">';
    echo $cssUndefinedMetaDataSelector;
    echo '</div>';
     */
      echo '</div></div>';

     $big=9999;
     
             //Añadimos la paginación al archive template.
        echo '<div style="clear:both; height:0px;">&nbsp;</div>';
        
        //No queremos mostrar toda una ristra de páginas porque puede romper la maquetación, como máximo 5.
        if($queryGetClinica->max_num_pages > 5){
        	$maxNumPages = 5;
        	}else{
       		 $maxNumPages =$queryGetClinica->max_num_pages; 
        	}
        
        //Añadimos la paginación bis.
        echo '<br><div id="PaginationWrapperBis"><div id="LinkPagesBis">'.paginate_links(array(
                                                         'total' => $maxNumPages,
                                                         'current' => max(1, $page),  
                                                         'prev_next' =>TRUE,
                                                         'base' => $base.'%_%',                  
                                                         'show_all' => TRUE,
                                                         'format' => '?page=%#%',//.$qString,
                                                         'prev_text'=>'<',
                                                         'next_text'=>'>',
                                                         'add_args' => $paramsUrl
                                                          )
                                                          ).'</div></div></br>';
     
     
     echo '<br><div id="PaginationWrapper"><div id="LinkPages">'.paginate_links(array(
                                                          'current' => max(1, $page),
                                                          'total' => $queryGetClinica->max_num_pages,
                                                          'format' => '?page=%#%',//.$qString,
                                                          'prev_next' =>TRUE,
                                                          'show_all' => TRUE,
                                                          'prev_text'=>'<',
                                                          'next_text'=>'>',
                                                          'add_args' => $paramsUrl)
                                                          ).'</div></div></br>';
                                                          
                                                          
                                                          
                                                          
                                                          
                                                          
/* Vamos a poner a continuaci—n la parte de la iolInfoPannel:-> Siempre se que se llame a AJAX de esta manera lo quitaremos en la primera parte del proceso de la respuesta. */


echo '
<div id="AJAXclinicaInfoPannel" class="draggable" style="display:none;">';
                if($clinicaTextName) 
                   {
                       echo '<div id="numLentes"> '._x("Hay &nbsp;","Filter_template","clinica-display").' '.$queryGetClinica->found_posts.' '._x("clínicas encontradas","Filter_template","clinica-display").'</div>';

                        echo '<div id="titleExplanation"> '._x("Las lentes mostradas cumplen las siguientes caracter’sticas:" ,"Filter_template","clinica-display").' </div>';
	                      
                        echo '<ul>';
                           
                        echo '<li><span class="auditVariableName">'._x("Su nombre contiene los caracteres: ","Filter_template","clinica-display").'</span><span class="auditVariableValue"><b>'.$clinicaTextName.'</b></span></li>';

                        echo '</ul>';
                                                
                   }
                   else{
                        echo _x('No hay ninguna restricción impuesta a las clínicas, se están mostrando todas las disponibles.','Filter_template','clinica_display');     
                   }
echo '</div>';

	//Fin del marcado de las respuestas del filtro.
	
		
	
	
	
	
	
	
	
	die();
}

?>