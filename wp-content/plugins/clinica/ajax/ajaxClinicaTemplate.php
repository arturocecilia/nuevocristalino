<?php
    //Iniciamos el display de las LIO's  que han pasado el filtro.
    //Venimos de $queryFilter = new WP_Query( $args );

     echo '<div id="AjaxContainerFixer" style="min-height:200px;"><div id="IOL_Filtradas">'; //<div id="content" role="main"> 

   // echo $queryFilter->request;

    // The Loop -> Si lo hemos hecho OK, habremos podido meter la lógica de arriba en pre_get_posts
    if ( $clinicaQueryFilter->have_posts() ) {
	    while ( $clinicaQueryFilter->have_posts() ) {
	    	$clinicaQueryFilter->the_post();
            $id= get_the_id();
            //Empezamos con el marcado de cada página en particular.
            /*
		    echo '<div class="bloque-lente" style="border: 1px solid black; margin-bottom:10px; padding:7px;">';
            echo '<div class="featured-iol-image">'.get_the_post_thumbnail().'</div>';
            echo '<div class="iol-excerpt">'.get_the_excerpt().'</div>';
            echo '<div class="iol-link"><a href="'.get_permalink().'">'.get_the_title().'</a></div>';
            echo '<li>' . get_the_title() . '=>'.get_the_term_list($id, 'diseno-optica').'</li>';
	        echo '</div>';
       */
       
 				//get_template_part( 'content-archive-clinica', get_post_format() ); Vamos a hacerlo para que pille el grid
 				
 			 if($Grid){   
          			   get_template_part( 'content-grid-clinica');
				}else{
					get_template_part( 'content-archive-clinica', get_post_format() );
				} 


        }
    } else {
            
        echo '<div class="NoClinicaWrapper">
              <div class="innerNoneClinicaWrapper">
              <div id="NoIolImg">
                <img src="'.content_url().'/uploads/2013/08/noencontrado.png" />
              </div>
              <div class="NoClinica">
                <p class="mensNotTitle">'._x("No hay ninguna Clínica que cumpla con los criterios de filtrado actuales.","Filter_template","clinica_display").'</p>
                <p class="mensNotMessage">'._x("Proceda a realizar una nueva búsqueda cambiando los criterios.","Filter_template","clinica_display").'</p>
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
  	/*
  	$cssUndefinedMetaDataSelector =  join(", ",$UndefinedMetaDataSelector);
    echo '<div id="inputSelectorsToDisable" style="display:none;">';
    echo $cssUndefinedMetaDataSelector;
    echo '</div>';
     */
      echo '</div></div>';

     $big=9999;
     
       if($clinicaQueryFilter->max_num_pages > 5){
        	$maxNumPages = 5;
        	}else{
       		 $maxNumPages =$clinicaQueryFilter->max_num_pages; 
        	}
     echo '<br><div id="PaginationWrapperBis"><div id="LinkPagesBis">'.paginate_links(array(
                                                          'current' => max(1, $page),
                                                          'total' => $maxNumPages,
                                                          'format' => '?page=%#%',//.$qString,
                                                          'prev_next' =>TRUE,
                                                          'show_all' => TRUE,
                                                          'prev_text'=>'<',
                                                          'next_text'=>'>',
                                                          'add_args' => $paramsUrl)
                                                          ).'</div></div></br>';
                                                          
     echo '<br><div id="PaginationWrapper"><div id="LinkPages">'.paginate_links(array(
                                                          'current' => max(1, $page),
                                                          'total' => $clinicaQueryFilter->max_num_pages,
                                                          'format' => '?page=%#%',//.$qString,
                                                          'prev_next' =>TRUE,
                                                          'show_all' => TRUE,
                                                          'prev_text'=>'<',
                                                          'next_text'=>'>',
                                                          'add_args' => $paramsUrl)
                                                          ).'</div></div></br>';
                                                          
                                                          
/* Vamos a poner a continuación la parte de la iolInfoPannel:-> Siempre se que se llame a AJAX de esta manera lo quitaremos en la primera parte del proceso de la respuesta. */
echo '
<div id="AJAXclinicaInfoPannel" class="draggable" style="display:none;">';
                if(count($clinicaAudit)) 
                   {
                       echo '<div id="numLentes"> ';
                       //._x("Hay &nbsp;","Filter_template","clinica-display").' '.$clinicaQueryFilter->found_posts.' '._x("clínicas encontradas","Filter_template","clinica-display").
                       printf(_x('Hay &nbsp; %d clínicas encontradas','Archive Clinica','clinica_cpt_display'),$clinicaQueryFilter->found_posts);
                       echo '</div>';

                        echo '<div id="titleExplanation">  '._x('Las clínicas mostradas cumplen las siguientes características:','Archive Clinica','clinica_cpt_display').'</div>';
	                      
                        echo '<ul>';
                        foreach($clinicaAudit as $infoFilter){
                           
                            echo '<li><span class="auditVariableName">'.$infoFilter['text'].' </span><span class="auditVariableValue"> '.$infoFilter['value'].'</span></li>';

                        }
                        echo '</ul>';
                        
                   //Añadimos las variables que no se han especificado. -> El array not specified está cargado desde el rightform pero
                   //habrá que cargarlo desde el iolengine
                   echo '<br />';
                   echo '<div id="titleNotIncludedExplanation">'._x('Variables que no se han especificado:','Archive Clinica','clinica_cpt_display').'</div>';
                   echo '<ul>';
                   	foreach($clinicaNotEspecified as $NS){
                   		echo '<li><span class="notProvidedMens">'.$NS['mens'].'</span></li>';
                   	}
                   echo '</ul>';
                        
                   }
                   else{
                        echo _x("No hay ninguna restricción impuesta a las clínicas, se están mostrando todas las disponibles.","Filter_template","clinica-display");     
                   }
echo '</div>';
?>