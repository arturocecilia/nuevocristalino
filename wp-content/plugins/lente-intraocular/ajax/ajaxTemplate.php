<?php
echo '<!DOCTYPE html>';

    //Iniciamos el display de las LIO's  que han pasado el filtro.
    //Venimos de $queryFilter = new WP_Query( $args );

     echo '<div id="AjaxContainerFixer" style="min-height:200px;"><div id="IOL_Filtradas">'; //<div id="content" role="main"> 

   // echo $queryFilter->request;

    // The Loop -> Si lo hemos hecho OK, habremos podido meter la lógica de arriba en pre_get_posts
    if ( $queryFilter->have_posts() ) {
	    while ( $queryFilter->have_posts() ) {
	    	$queryFilter->the_post();
            $id= get_the_id();
            //Empezamos con el marcado de cada página en particular.
				    
             if($Grid){   
                    if($buscador){
                       get_template_part( 'content-grid-lente-intraocular-buscador-iol');
                        }else{
          			       get_template_part( 'content-grid-lente-intraocular');
				    }
                }else{
				  
                  if($buscador){
                	    get_template_part( 'content-archive-lente-intraocular-buscador-iol' ); //, get_post_format()                    
                  }
                      else{
                	    get_template_part( 'content-archive-lente-intraocular' ); //, get_post_format()
				    }
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
                <p class="mensNotTitle">'._x("No hay ninguna Lente Intraocular con los criterios de filtrado actuales.","Archive Lente Intraocular","iol_cpt_display").'</p>
                <p class="mensNotMessage">'._x("Proceda a realizar una nueva búsqueda cambiando los criterios.","Archive Lente Intraocular","iol_cpt_display").'</p>
              </div>
              <div style="clear:both;height:0px;">&nbsp;</div>
              </div>
              </div>';

    }

     //Procesamos la query string para quitar el parámetro page en caso de que nos venga puesto.
     $qString = $_SERVER['QUERY_STRING'];
  
 /*    if(current_user_can('manage_options')){
     	var_dump($qString);
     	echo admin_url('admin-ajax.php');
     
     } */
     //echo 'La qstring antes de nada'.$qString.'<br /><br /><br />';
     $qString = str_replace('?','',$qString);
     parse_str($qString,$aParams);//explode("&",$qString );        
     
     //print_r($aParams);
          
/*     if(current_user_can('manage_options')){
      var_dump($aParams);
     }     
  */        
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
  	$cssUndefinedMetaDataSelector =  join(", ",$UndefinedMetaDataSelector);
    echo '<div id="inputSelectorsToDisable" style="display:none;">';
    echo $cssUndefinedMetaDataSelector;
    echo '</div>';
     
      echo '</div></div>';

     $big=9999;
     
       if($queryFilter->max_num_pages > 7){
        	$maxNumPages = 7;
        	}else{
       		 $maxNumPages =$queryFilter->max_num_pages; 
        	}
     
     
     echo '<br><div id="PaginationWrapper"><div id="LinkPages">'.paginate_links(array(
                                                          'current' => max(1, $page),
                                                          'total' => $queryFilter->max_num_pages,
                                                          'format' => '?page=%#%',//.$qString,
                                                          'prev_next' =>TRUE,
                                                          'show_all' => TRUE,
                                                          'prev_text'=>'<',
                                                          'next_text'=>'>',
                                                          'add_args' => $paramsUrl)
                                                          ).'</div></div></br>';
                                                          
                                                          
     //Vamos a poner un paginationBis y lo colocamos con position relative.
     echo '<br><div id="PaginationWrapperBis"><div id="LinkPagesBis">'.paginate_links(array(
                                                          'current' => max(1, $page),
                                                          'total' => $maxNumPages,
                                                          'format' => '?page=%#%',//.$qString,
                                                          'prev_next' =>TRUE,
                                                          'show_all' => FALSE,
                                                          'end_size'=>'1',
                                                          'mid_size'=>'1',
                                                          'prev_text'=>'<',
                                                          'next_text'=>'>',
                                                          'add_args' => $paramsUrl)
                                                          ).'</div></div>';

     
                                                          
                                                          
/* Vamos a poner a continuación la parte de la iolInfoPannel:-> Siempre se que se llame a AJAX de esta manera lo quitaremos en la primera parte del proceso de la respuesta. */
echo '
<div id="AJAXiolInfoPannel" class="draggable" style="display:none;">';
                if(count($iolAudit)) 
                   {
                       echo '<div id="numLentes"> ';
                       printf(_x("Hay &nbsp; %d lentes encontradas","Archive Lente Intraocular","iol_cpt_display"),$queryFilter->found_posts);
                       echo '</div>';
                       //_x("Hay &nbsp;   ","Filter_Template","iol_cpt_display")_x("lentes encontradas","Archive Lente Intraocular","iol_cpt_display") .$queryFilter->found_posts.
                        echo '<div id="titleExplanation"> '. _x("Las lentes mostradas cumplen las siguientes características:","Archive Lente Intraocular","iol_cpt_display"). '</div>';
	                      
                        echo '<ul>';
                        foreach($iolAudit as $infoFilter){
                           
                            echo '<li><span class="auditVariableName">'.$infoFilter['text'].'</span> <span class="auditVariableValue">'.$infoFilter['value'].'</span></li>';

                        }
                        echo '</ul>';
                        
                   //Añadimos las variables que no se han especificado. -> El array not specified está cargado desde el rightform pero
                   //habrá que cargarlo desde el iolengine
                   echo '<br />';
                   echo '<div id="titleNotIncludedExplanation">'. _x("Variables que no se han especificado:","Archive Lente Intraocular","iol_cpt_display"). '</div>';
                   echo '<ul>';
                   	foreach($NotEspecified as $NS){
                   		echo '<li><span class="notProvidedMens">'.$NS['mens'].'</span></li>';
                   	}
                   echo '</ul>';
                        
                   }
                   else{
                        echo _x("No hay ninguna restricción impuesta a las lentes, se están mostrando todas las disponibles.","Archive Lente Intraocular","iol_cpt_display");     
                   }
echo '</div>';

?>