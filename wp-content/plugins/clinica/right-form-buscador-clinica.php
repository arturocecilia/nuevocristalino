

<script>

//Adaptación de la función que genera el mapa para ser usada en el buscador por el filtro de la derecha.


function createMapAddMarquersBuscador(clinicas, cLatitude, cLongitude,action){

    firstLoad += 1;
    console.log('Esta función es createMapAddMarquersBuscador');
	
	if(!cLatitude || !cLongitude){
		cLatitude = getLatitude();
		cLongitude = getLongitude();
	}
	
	
	var divMapa=document.getElementById('divMapa');
	//capa para mostrar las coordenadas (definida tambien en el HTML)
	var divCoordenadas=document.getElementById('divCoordenadas');
			
	//creamos un objeto (para Google Maps) con las coordenadas obtenidas por el API de HTML5
	var objCoordenadasRef = new google.maps.LatLng(cLatitude,cLongitude); //userLatitude,userLongitude
		
	//opciones del mapa
	var objOpciones={
				mapTypeId:		google.maps.MapTypeId.ROADMAP,	//mapa de carretera
				zoom: 			5,								//acercamiento
				mapTypeControl:	true,							//mostrar controles para cambiar el tipo de mapa
				center: 		objCoordenadasRef					//centramos el mapa en las coordenadas obtenidas
			};
			
	//dibujamos el mapa de la ubicacion (en la capa divMapa)
	var objMapa=new google.maps.Map(divMapa,objOpciones);
	var markers = new Array();
	var clinicaCoord = new Array();

	//Anotamos la referencia sea esta la ubicación del usuario o la por defecto.
				markersRef = new google.maps.Marker({
														title:		'Ubicación de Referencia',//clinica,	//agregamos un tooltip al punto
														position:	objCoordenadasRef,//objCoordenadas,//clinicaCoord,
														map:		objMapa,//este es el mapa que anteriormente creamos
														icon: 		"https://maps.google.com/mapfiles/ms/icons/orange-dot.png",
														zIndex: 	0
																					});
														/*{
        														path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
        														strokeColor: "red",
        														scale: 3
        														},*/
							
			
	//Vamos a intentar añadir los marcadores de manera dinámica.
	jQuery("#infoClinicSearch").empty();
	
	
	if(action == 'getClinicsWithConds'){
		//Ocultamos la parte correponidente al resultado por ubicación.
		jQuery('#rightBuscadorClinicas div.resultLCom').fadeIn('600');
		jQuery('#rightBuscadorClinicas div.userGeoInfo').fadeOut('600');
	
		jQuery("#clinicCond").empty();
		var list = jQuery("#clinicCond").append('<ul></ul>').find('ul');
	
	}else{
	
			jQuery('#rightBuscadorClinicas div.userGeoInfo').fadeIn('600');
		    jQuery('#rightBuscadorClinicas div.resultLCom').fadeOut('600');			
	
			var list = jQuery("#infoClinicSearch").append('<ul></ul>').find('ul');
	}
	
	

	
		for(var clinica in clinicas){
           //Sólo pondremos en el mapa clínicas que sean "hijos" => DEPENDERÁ DEL PAÍS.... igual en uno no hay grupos ni filiales... sino que son sólo indep.



            //Aquí parece que es donde se mete la lista de clínicas.
            //Probamos sacando al parent.
            
            //Si es el la primera load sólo cargamos los padres en la lista.
            if (clinicas[clinica].apMaps != -1 ) {
            
                console.log('Clínica '+clinica+' tiene un apMaps de: '+clinicas[clinica].apMaps);
                console.log(clinicas[clinica].parent+'Metida');
                list.append('<li><a href="' + clinicas[clinica].link + '">' + clinica + '</a></li>');
            }


                //list.append('<li><a href="' + clinicas[clinica].link + '">' + clinica + '</a></li>');
                           			
				clinicaCoord[clinica] = new google.maps.LatLng(clinicas[clinica].latitud,clinicas[clinica].longitud);
			
				
				markers[clinica] = new google.maps.Marker({
							title:		clinica,//clinica,	//agregamos un tooltip al punto
							position:	clinicaCoord[clinica],//objCoordenadas,//clinicaCoord,
							map:		objMapa,//este es el mapa que anteriormente creamos
							icon: 		"https://maps.google.com/mapfiles/ms/icons/blue-dot.png",
							zIndex: 	2
							});
	//Vamos a rellenar la ul list con las clínicas seleccionadas.				
				


            
				
							
			}

	


			return;	

}







//Función que refresca el mapa con los datos del filtro de la derecha:
function archiveBuscadorClinica_submit_me(){

		console.log('archiveBuscadorClinica_submit_me ejecutada');
		
        var idsNotToProcess = new Array();
        console.log(jQuery("#clinica_filter_form").serialize());

        jQuery("#clinica_filter_form").serialize();

        //Si hay algún input con valor que contenga "-se" -> Fuera, a no ser que sea el de ubicación
        jQuery("#clinica_filter_form input, #clinica_filter_form select").each(function () {
                
        if ((this.value.substr(this.value.length - 3) == '-se' || jQuery(this).prop('disabled') == true) && (this.value.indexOf('ubicacion') == -1)) { 
           idsNotToProcess.push('#' + jQuery(this).attr('id'));
                   }
          });


        var selectorNotToProcess = idsNotToProcess.join(',');
         //alert(selectorNotToProcess);
        console.log('Selectores que no procesan: '.selectorNotToProcess);
        
        //Uno de los inputs era el action con la función wp_admin que le va a procesar.
        var data = jQuery("#clinica_filter_form input,#clinica_filter_form select").not(selectorNotToProcess).serialize();
 

 
 	 //Función que recoge las clínicas y updatea el mapa.
     jQuery.ajax({
        //dataType: "json",
        url: the_ajax_script.ajaxurl,
        data: data, //{ action: "getClinicsWithConds"},//hay que añadir los valores de los inputs.
        success: function (response) {

            var clinicas = jQuery.parseJSON(response);

            console.log('ajaxGetClinicasWithinCreateMap ejecutada');
            
            //La siguiente función recibe el array de clínicas del ajax y las representa (Específica para el array de buscdor)
            createMapAddMarquersBuscador(clinicas,null,null,'getClinicsWithConds')
           
        },
        complete: function (response) {
            //	alert('Función completada'+ response);
            jQuery('#divMapa').fadeTo('slow', 1);
			
            // var clinicas = jQuery.parseJSON(response);
			//console.log(clinicas);
			
			
            //updateGeocode();
        },
        beforeSend: function () {
            // Handle the beforeSend event
            //jQuery('#divMapa').html('<p>Loading :)</p>');//fadeOut('slow');
            jQuery('#divMapa').fadeTo('slow', 0.1);
        }
    });
    //Función que añade la información sobre el filtro derecho.
    
    
 
}

</script>




<div id="right" class="filter-right right-archive-clinica">

  <form id="clinica_filter_form" method="get" >

     
	<input name="action" type="hidden" value="getClinicsWithConds" /> <!-- this puts the action the_ajax_hook into the serialized form -->

<!-- Inicio SelectList viewType-->
  <?php
     //Vamos a ver el tipo de lente que nos viene
       if (array_key_exists('viewType',$_GET)){
	        $Result_viewType = $_GET["viewType"];
        }
         else{
             //Aquí ponemos el número de elementos mostrados por defecto.
             $Result_viewType = 4;
         }
     ?>
  <div class="ui-widget startsUgly" id="comboViewTypeClinic">
  <span id="titleViewTypeClinic"><?php echo _x('Vista:','Right Archive Clinica','clinica_cpt_display'); ?></span>
  <select id="comboboxViewType" name="viewType">
  <?php     
       //Vamos a darle a elegir entre las siguintes opciones:
       $viewTypeList = array("Grid",2,3,4,5,6,7,8,9,10);

        foreach ($viewTypeList as $viewType ) {
              //echo 'A ver'.$taxonomy->slug.'   '.$Result_TipoLente.'<br />';
               if($viewType == $Result_viewType)
                  {
                   echo '<option selected="selected" value = "' . $viewType . '">' . $viewType . '</option>';   
                   }
               else{
                    echo '<option value = "' . $viewType . '">' . $viewType . '</option>';                  
                   }
           }    
  ?>
  </select>
  </div>
  
  <!-- Fin selectlist con el tipo de vista -->


   <!-- En el siguiente accordion: Ubicación y datos adicionales de la clínica -->
    <!-- <div id="accordionFilterSecond"> -->
    <!-- <h3> <span class="title-filter"><?php echo _x('Ubicación/Características','Right Archive Clinica','clinica_cpt_display'); ?></span> 
     <span id="dragger-accordionFilterSecond" class="ui-icon ui-icon-arrow-4-diag startsUgly">&nbsp;</span>
     <span id="reseter-accordionFilterSecond" class="ui-icon ui-icon-refresh startsUgly">&nbsp;</span></h3> -->
     <div>


		<!-- Inicio Input de Lente Linkeada -->
		<?php 
		if (array_key_exists('lente-implantada',$_GET) || get_query_var( _x('lente-implantada','param-name','clinica') )){
           
	        $Result_lente_implantada = $_GET[ _x('lente-implantada','param-name','clinica') ];
        }
        else{
        	$Result_lente_implantada = _x('lente-implantada','param-name','clinica').'-se';	
        }
        
        //Necesitamos cargar en una variable todas las lentes que "se implantan en clinicas".
        
        $argsLentesImplantadas = array('post_type' => _x('lente-intraocular','CustomPostType Name','iol'),
        							   _x('implantada-en-clinicas','taxo-name','iol') => _x('disponible','taxo-value-slug','iol-scaffold' )
                                       );
        $lentesImplantadas = new WP_Query($argsLentesImplantadas);
        
        if(current_user_can('manage_options')){
          //  var_dump($lentesImplantadas->request);
          //  echo _x('implantada-en-clinicas','taxo-name','iol');  
          //  echo '<br>'._x('disponible','taxo-value-name','iol-scaffold').'<br>';
              
        }

		?>

        <div class="ui-widget startsUgly" id="lensClinics">
        <label  class="cliniBSetTitle"><?php echo _x('Lente Intraocular de Interés:','Right Archive Clinica','clinica_cpt_display');?></label>
        <select id="combobox-lensClinics" name="<?php echo _x('lente-implantada','param-name','clinica'); ?>">
        <?php
        if  ($lentesImplantadas) {
        
        echo '<option value = "0" '.selected($Result_lente_implantada, _x('lente-implantada','param-name','clinica').'-se', false ).'>'._x('Sin Especificar','Right Archive Clinica','clinica_cpt_display').'</option>'; 
        
          while ( $lentesImplantadas->have_posts() ) : $lentesImplantadas->the_post();
          
          echo '<option value = "' . get_the_ID() . '" '.selected($Result_lente_implantada,get_the_ID(), false).'>' . get_the_title() . '</option>';
                    
         endwhile;

        } 
         
         	        
         
         ?>
        
        </select>
   <!--     </div> -->
         <!-- Fin lente linkeada -->
		
		
		
		
		
		<!-- Fin de Input de Lente Linkeada -->



            <?php
         //Vamos a poner a sacar el tipo de lente que es (Recordemos que hemos establecido una clasificación jerárquica).
        /* $provinciaTerm = array_shift(array_values(get_the_terms( $post->ID, 'ubicacion' )));			 
         $provinciaTermSlug = $provinciaTerm->slug;
         
         $comAuto = get_term_by('id',$provinciaTerm->parent,'ubicacion');
         $comAutoSlug = $comAuto->slug;
         $comAutoId = $comAuto->term_id;
         //$provinces =  get_terms( array('ubicacion'), array('hierarchical'=> FALSE, 'hide_empty'=> 0));
         $provincesInScope = get_terms( array('ubicacion'), array('hierarchical'=> FALSE, 'hide_empty'=> 0, 'parent'=>$comAutoId ));*/

		if (array_key_exists('ubicacion-parent',$_GET)){
           
	        $comAutoSlug = $_GET['ubicacion-parent'];
        }
         else{
             $comAutoSlug = "ubicacion-parent-se";
         }
         
         $comAutos = get_terms( array(_x('ubicacion','taxo-name','clinica')), array( 'parent' => 0 , 'hide_empty'=> 0 ) );// , 'hide_empty'=> 0
         $comAutosIds = wp_list_pluck($comAutos,'term_id');
         if(current_user_can('manage_options')){
             //var_dump($comAutosIds);
         }

		if (array_key_exists('ubicacion-child',$_GET)){
           
	        $provinciaTermSlug = $_GET['ubicacion-child'];
        }
         else{
             $provinciaTermSlug = "ubicacion-child-se";
         }   
         
         //no veo el sentido de limitar la provincia de inicio.
         $provincesInScope = get_terms( array(_x('ubicacion','taxo-name','clinica')), array('hierarchical'=> FALSE, 'exclude' => $comAutosIds )); //, 'hide_empty'=> 0
        if(current_user_can('manage_options')){
             //var_dump($provincesInScope);
         }
     ?>

        <!-- Inicio de Ubicacion: Comunidad Autónoma -> Son 2 comboboxes: La primera de términos padre y la segunda de términos hijo... lo suyo sería que apareciesen sólo los términos hijos del seleccionado-->
        <div id="ubicacionParent" class="ui-widget startsUgly">
        <label  class="cliniBSetTitle"><?php echo _x('Comunidad Autónoma:','Right Archive Clinica','clinica_cpt_display');?></label>
        <select id="combobox-ubicacion-parent" name="ubicacion-parent">
        <?php
        if  ($comAutos) {

             foreach ($comAutos as $taxonomy ) {
                  // echo $taxonomy.'   '.$Result_Tipo;
              if($taxonomy->slug == $comAutoSlug)
                      {
                       echo '<option selected="selected" value = "' . $taxonomy->slug . '">' . $taxonomy->name . '</option>';   
                       }
                else{
                        echo '<option value = "' . $taxonomy->slug . '">' . $taxonomy->name . '</option>';                  
                       }
                }
                
                if($comAutoSlug == "ubicacion-parent-se"){
       	               echo '<option selected="selected" value = "ubicacion-parent-se" id="comAutoDefault">'._x('Sin Especificar','Right Archive Clinica','clinica_cpt_display').'</option>';
                }else{
                	echo '<option value ="ubicacion-parent-se">'._x("Sin Especificar","Right Archive Clinica","clinica_cpt_display").'</option>';
                }    
            }            
         ?>
        </select>
        </div>
         <!-- Fin de Ubicacion Comunidad Autónoma -->

         <!-- Inicio Provincia-->
        <div class="ui-widget startsUgly" id="provincia">
        <label  class="cliniBSetTitle"><?php echo _x('Provincia:','Filter_Template','clinica_display');?></label>
        <select id="combobox-ubicacion-child" name="ubicacion-child">
        <?php
        if  ($provincesInScope) {
               echo '<option value = "ubicacion-parent-se" id="comAutoDefaultSe">'._x('Sin Especificar','Right Archive Clinica','clinica_cpt_display').'</option>'; //Se añadido a id por validación.
             foreach ($provincesInScope as $taxonomy ) {
                 
                   if($taxonomy->slug == $provinciaTermSlug)
                      {
                       echo '<option selected="selected" value = "' . $taxonomy->slug . '">' . $taxonomy->name . '</option>';   
                       }
                else{
                        echo '<option value = "' . $taxonomy->slug . '">' . $taxonomy->name . '</option>';                  
                       }
                }
                if($provinciaTermSlug == "ubicacion-child-se"){
                echo '<option selected="selected" value = "ubicacion-child-se">'._x("Sin Especificar","Right Archive Clinica","clinica_cpt_display").'</option>';
                }else{
                echo '<option value = "ubicacion-child-se">'._x("Sin Especificar","Right Archive Clinica","clinica_cpt_display").'</option>';
                }    
            }            
         ?>
        </select>
        </div>
         <!-- Fin Provincia -->
   








     </div>
    </div>
   <!-- Fin del segundo accordion -->


     <input type="button" class="buscadorClinicSubmit" value="<?php echo _x('Realizar Filtrado','Right Archive Clinica','clinica_cpt_display');?>" onClick="archiveBuscadorClinica_submit_me();" />




<!-- Inicio del Primer Accordion -->

  
<!-- Fin SelectList con el tipo de vista-->   	
   </form>




    <?php
        echo '<!-- Incluido -->';
        //Añadimos el full Yarpp Bottom.
        echo '<br />';
        //include( ABSPATH . 'wp-content/themes/iol/nc-yarpp-full-side.php');

    ?>


</div>	