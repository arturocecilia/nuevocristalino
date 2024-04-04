<?php


function getIol(){
	global $iolPluginDirectory;
	//Incluimos antes los botones.
			/*		echo '<div id="changeFilter">';
						echo '<button id="advLoader" type="radio" data-action="getAdvForm">Menú Avanzado</button>';
    					echo '<button id="patientLoader"type="radio" data-action= "getPatientForm">Menú Sencillo</button>';
					echo '</div>';
	*/


    //Vamos a analizar el valor con el que viene la variable page -> Es lo que nos va a escupir la función paginate-links
    $page = array_key_exists('page',$_GET) ? $_GET['page'] : 1;//(get_query_var('page')) ? get_query_var('page') : 1; //$_GET['paged'] ? $_GET['paged'] : 1;  

    //Vemos también el tipo de vista seleccionado por el usuario.
   

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


	//A continuación el código de template de las respuestas del filtro.
	
	     echo '<div id="AjaxContainerFixer" style="min-height:200px;"><div id="IOL_Filtradas">'; //<div id="content" role="main"> 

   // echo $queryFilter->request;
   
   if(isset($_GET['iolTextName'])){
   	$iolTextName = $_GET['iolTextName'];	
   }else{
    $iolTextName ='';
   }
   
       $args = array(
       			 'post_type'=>_x('lente-intraocular','CustomPostType Name','iol'),
                  'post_status' => 'publish',
                  'posts_per_page' => $viewTypeNumber,
                  'orderby'=> 'meta_value_num',
                  'order'=>'DESC',
                  'meta_key'=>'nivelPrefLenteMD',
                  'paged' =>$page,
                  'iolTextName'=>$iolTextName,
                  'tax_query' => array(
        								array(
  												'taxonomy'=> _x('estatus-comercial','taxo-name','iol'),
                               					'terms'   => array(_x('retirada','taxo-value-slug','iol-scaffold'),_x('en-estudio','taxo-value-slug','iol-scaffold')), //$adiciones_filter,//array('alta'),
                               'field' => 'slug',
                               'operator' => 'NOT IN'        )
    )
                  
                  );
   
   //'meta_key' => 'title', 'meta_value' => 'mp', 'meta_compare' => 'like', 
   $queryGetIol = new WP_Query( $args );
   
   
   //echo $queryGetIol->request;
   

    // The Loop -> Si lo hemos hecho OK, habremos podido meter la lógica de arriba en pre_get_posts
    if ( $queryGetIol->have_posts() ) {
	    while ( $queryGetIol->have_posts() ) {
	    	$queryGetIol->the_post();
            $id= get_the_id();
            //Empezamos con el marcado de cada página en particular.
				    
             if($Grid){   
          			   get_template_part( 'content-grid-lente-intraocular');
				}else{
					get_template_part( 'content-archive-lente-intraocular', get_post_format() );
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
                <p class="mensNotTitle">No hay ninguna Lente Intraocular con los criterios de filtrado actuales.</p>
                <p class="mensNotMessage">Proceda a realizar una nueva búsqueda cambiando los criterios.</p>
              </div>
              <div style="clear:both;height:0px;">&nbsp;</div>
              </div>
              </div>';

    }

     //Procesamos la query string para quitar el parámetro page en caso de que nos venga puesto.
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
     //Hay que hacer un url_encode de los parámetros.
     foreach($aParams as  $clave => $valor){
         $paramsUrl[$clave] = urlencode($valor);
     }


     //echo 'Estos son los parámetros¡¡'.var_dump($aParams).'<br /><br /><br />';
     //echo 'Estos son los parámetros coidficados¡¡'.var_dump($paramsUrl).'<br /><br /><br />';
     //Cerramos los dos divs.
     
     //Vamos a poner en este div todos los ids de los inputs que hay que deshabilitar
     /*Esto no será necesario, puesto que son condiciones desacopladas, o por filtro o por nombre
  	$cssUndefinedMetaDataSelector =  join(", ",$UndefinedMetaDataSelector);
    echo '<div id="inputSelectorsToDisable" style="display:none;">';
    echo $cssUndefinedMetaDataSelector;
    echo '</div>';
     */
      echo '</div></div>';

     $big=9999;
     
        //No queremos mostrar toda una ristra de páginas porque puede romper la maquetación, como máximo 5.
        if($queryGetIol->max_num_pages > 6){
        	$maxNumPages = 6;
        	}else{
       		 $maxNumPages =$queryGetIol->max_num_pages; 
        	}
     
     echo '<br><div id="PaginationWrapper"><div id="LinkPages">'.paginate_links(array(
                                                          'current' => max(1, $page),
                                                          'total' => $queryGetIol->max_num_pages,
                                                          'format' => '?page=%#%',//.$qString,
                                                          'prev_next' =>TRUE,
                                                          'show_all' => TRUE,
                                                          'prev_text'=>'<',
                                                          'next_text'=>'>',
                                                          'add_args' => $paramsUrl)
                                                          ).'</div></div></br>';
                                                          
     echo '<div id="PaginationWrapperBis"><div id="LinkPagesBis"  class="archiveLenteIntraocularAjaxer">'.paginate_links(array(
                                                         'current' => $currentPage,
                                                         'base' => $base.'%_%',
                                                         'total' => $maxNumPages,
                                                         'prev_next' =>TRUE,
                                                         'show_all' => TRUE,
                                                         'format' => '/page/%#%/',//'/?page=%#%',//'/page/%#%',//'/?page=%#%',
                                                         'prev_text'=>'<',
                                                         'next_text'=>'>',
                                                         'add_args' => $aParams
                                                          )
                                                          ).'</div></div></br>';                                                     
                                                          
/* Vamos a poner a continuación la parte de la iolInfoPannel:-> Siempre se que se llame a AJAX de esta manera lo quitaremos en la primera parte del proceso de la respuesta. */


echo '
<div id="AJAXiolInfoPannel" class="draggable" style="display:none;">';
                if($iolTextName) 
                   {
                       echo '<div id="numLentes"> Hay &nbsp;'.$queryGetIol->found_posts.' lentes encontradas</div>';

                        echo '<div id="titleExplanation"> Las lentes mostradas cumplen las siguientes características:</div>';
	                      
                        echo '<ul>';
                           
                        echo '<li><span class="auditVariableName">Su nombre contiene los caracteres: </span><span class="auditVariableValue"><b>'.$iolTextName.'</b></span></li>';

                        echo '</ul>';
                                                
                   }
                   else{
                        echo 'No hay ninguna restricción impuesta a las lentes, se están mostrando todas las disponibles.';     
                   }
echo '</div>';

	//Fin del marcado de las respuestas del filtro.
	
		
	
	
	
	
	
	
	
	die();
}

?>