
<div id="right" class="filter-right right-archive-clinica">





  <h3><?php echo _x('BUSCAR CLÍNICAS','Right Archive Clinica','clinica_cpt_display');?> : </h3>           
  <form id="clinica_filter_form" method="get" action="<?php echo get_post_type_archive_link(_x('clinica','CustomPostType Name','clinica')); ?>">

     <input type="button" class="singleClinicSubmit" value="<?php echo _x('Realizar Filtrado','Right Archive Clinica','clinica_cpt_display');?>" onClick="archiveClinica_submit_me();" />
     
	<input name="action" type="hidden" value="clinica_filter_result" /> <!-- this puts the action the_ajax_hook into the serialized form -->

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
    <div id="accordionFilterSecond">
     <h3> <span class="title-filter"><?php echo _x('Ubicación/Características','Right Archive Clinica','clinica_cpt_display'); ?></span> 
     <span id="dragger-accordionFilterSecond" class="ui-icon ui-icon-arrow-4-diag startsUgly">&nbsp;</span>
     <span id="reseter-accordionFilterSecond" class="ui-icon ui-icon-refresh startsUgly">&nbsp;</span></h3>
     <div>

		<!-- Inicio Femto Sí / No -->

  <?php   
      //Vamos a sacar la femto faco de la clínica que nos venga dada por la query o el get.
      
       if( get_query_var( _x('femto-faco','taxo-name','clinica') )){
           
           $Result_femtoFaco = get_query_var(_x('femto-faco','taxo-name','clinica'));
        }
        else{
           $Result_femtoFaco = _x('femto-faco','taxo-name','clinica').'-se';
        }
     ?>
  <div class="ui-widget startsUgly">
  <label title=" Explicación de femto-faco" class="labelTitle"><?php echo _x('Disponibilidad de Láser de Femtosegundo (femto-faco):','Right Archive Clinica','clinica_cpt_display');?></label>
    <div id="femtoFacoFilter">
        <?php 
        $argsFemtoFaco = array('hide_empty'    => false );
        $femtoFacoS = get_terms(_x('femto-faco','taxo-name','clinica'), $argsFemtoFaco); 
        if  ($femtoFacoS) {
            foreach ($femtoFacoS as $femtoFaco ) {
            
               echo '<input type="radio" id="femtoFaco'.$femtoFaco->slug.'" '.checked($femtoFaco->slug, $Result_femtoFaco, false).' name ="'._x('femto-faco','taxo-name','clinica').'" value="'.$femtoFaco->slug.'" /><label for="femtoFaco'.$femtoFaco->slug.'">'.$femtoFaco->name.'</label>';
               
               }
           }
               
               echo '<input type="radio" id="femtoFacoDefault" '.checked(_x('femto-faco','taxo-name','clinica').'-se', $Result_femtoFaco, false).'  name ="'._x('femto-faco','taxo-name','clinica').'" value="'._x('femto-faco','taxo-name','clinica').'-se" /><label for="femtoFacoDefault">'._x('No','Filter_Template','clinica_display').'</label>';


       ?>       
    </div>
  </div>




		<!-- Fin Femto Sí / No -->


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
        </div>
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



<!-- Inicio del Primer Accordion -->

  
<!-- Fin SelectList con el tipo de vista-->


 <div id="accordionFilterSimple">
     <h3> <span class="title-filter"><?php echo _x('Características básicas','Right Archive Clinica','clinica_cpt_display'); ?> </span>
     <span id="dragger-accordionFilterSimple" class="ui-icon ui-icon-arrow-4-diag startsUgly">&nbsp;</span>
     <span id="reseter-accordionFilterSimple" class="ui-icon ui-icon-refresh startsUgly">&nbsp;</span>
     </h3>
     <div>
     
     
         <!-- Fin de más información sobre la clínica-->
          
     <?php   
     
     //posibilidad-de-financiacion
     //seguros
     //cirugia-intraocular-bilateral
     //posibilidad-de-hospitalizacion
     //quirofanos-propios
     //laser-propio

	$Result_equipClinArray = array();
      
     if(array_key_exists(_x('posibilidad-de-financiacion','taxo-value-slug','clinica-scaffold'),$_GET) or 
        array_key_exists(_x('cirugia-intraocular-bilateral','taxo-value-slug','clinica-scaffold'),$_GET) or 
        array_key_exists(_x('posibilidad-de-hospitalizacion','taxo-value-slug','clinica-scaffold'),$_GET) or
        array_key_exists(_x('quirofanos-propios','taxo-value-slug','clinica-scaffold'),$_GET) or
        array_key_exists(_x('laser-propio','taxo-value-slug','clinica-scaffold'),$_GET)
     	)
      {
        if(array_key_exists(_x('posibilidad-de-financiacion','taxo-value-slug','clinica-scaffold'),$_GET)){ 
            $Result_mInfClinArray[] = $_GET[_x('posibilidad-de-financiacion','taxo-value-slug','clinica-scaffold')];
        }
        if(array_key_exists(_x('seguros','taxo-value-slug','clinica-scaffold'),$_GET)){ 
            $Result_mInfClinArray[] = $_GET[_x('seguros','taxo-value-slug','clinica-scaffold')];
        }
        
        if(array_key_exists(_x('cirugia-intraocular-bilateral','taxo-value-slug','clinica-scaffold'),$_GET)){ 
            $Result_mInfClinArray[] = $_GET[_x('cirugia-intraocular-bilateral','taxo-value-slug','clinica-scaffold')];
        }
        if(array_key_exists(_x('posibilidad-de-hospitalizacion','taxo-value-slug','clinica-scaffold'),$_GET)){ 
            $Result_mInfClinArray[] = $_GET[_x('posibilidad-de-hospitalizacion','taxo-value-slug','clinica-scaffold')];
        }
        if(array_key_exists(_x('quirofanos-propios','taxo-value-slug','clinica-scaffold'),$_GET)){ 
            $Result_mInfClinArray[] = $_GET[_x('quirofanos-propios','taxo-value-slug','clinica-scaffold')];
        }
        
        if(array_key_exists(_x('laser-propio','taxo-value-slug','clinica-scaffold'),$_GET)){ 
            $Result_mInfClinArray[] = $_GET[_x('laser-propio','taxo-value-slug','clinica-scaffold')];
        }    
      }
     else{
           $Result_mInfClinArray[] = _x('mas-info-clinica','taxo-name','clinica')."-se";
     }

     ?>
          
     <div class="ui-widget startsUgly" id="mas-info-clinica">
  <label class="cliniBSetTitle"><?php echo _x('Datos adicionales de la clínica','Right Archive Clinica','clinica_cpt_display');?></label>
    
         <div id="tipoMInfFilter">
        <?php 
        $mInfClinS = get_terms(_x('mas-info-clinica','taxo-name','clinica'), array('hide_empty' => 0 )); 
        
        if  ($mInfClinS) {
            foreach ($mInfClinS as $taxonomyValue ) {
                //Check del primer término de la taxonomía.
                if($taxonomyValue->slug == _x('posibilidad-de-financiacion','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug,$Result_mInfClinArray))
                    {
                     echo '<input type="checkbox" id="posFinan" checked="checked" name ="'.$taxonomyValue->slug.'" value="'.$taxonomyValue->slug.'" /><label for="posFinan">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="posFinan" name ="'.$taxonomyValue->slug.'" value = "'.$taxonomyValue->slug.'" /><label for="posFinan">'.$taxonomyValue->name.'</label>';  
                    }
                 }

                //Check del segundo término de la taxonomía.
                if($taxonomyValue->slug == _x('seguros','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug,$Result_mInfClinArray))
                    {
                     echo '<input type="checkbox" id="seguros" checked="checked" name ="'.$taxonomyValue->slug.'" value="'.$taxonomyValue->slug.'" /><label for="seguros">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="seguros" name ="'.$taxonomyValue->slug.'" value = "'.$taxonomyValue->slug.'" /><label for="seguros">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('cirugia-intraocular-bilateral','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug,$Result_mInfClinArray))
                    {
                     echo '<input type="checkbox" id="cirubi" checked="checked" name ="'.$taxonomyValue->slug.'" value="'.$taxonomyValue->slug.'" /><label for="cirubi">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="cirubi" name ="'.$taxonomyValue->slug.'" value = "'.$taxonomyValue->slug.'" /><label for="cirubi">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('posibilidad-de-hospitalizacion','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug,$Result_mInfClinArray))
                    {
                     echo '<input type="checkbox" id="posHos" checked="checked" name ="'.$taxonomyValue->slug.'" value="'.$taxonomyValue->slug.'" /><label for="posHos">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="posHos" name ="'.$taxonomyValue->slug.'" value = "'.$taxonomyValue->slug.'" /><label for="posHos">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('quirofanos-propios','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug,$Result_mInfClinArray))
                    {
                     echo '<input type="checkbox" id="quiPro" checked="checked" name ="'.$taxonomyValue->slug.'" value="'.$taxonomyValue->slug.'" /><label for="quiPro">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="quiPro" name ="'.$taxonomyValue->slug.'" value = "'.$taxonomyValue->slug.'" /><label for="quiPro">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('laser-propio','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug,$Result_mInfClinArray))
                    {
                     echo '<input type="checkbox" id="laPro" checked="checked" name ="'.$taxonomyValue->slug.'" value="'.$taxonomyValue->slug.'" /><label for="laPro">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="laPro" name ="'.$taxonomyValue->slug.'" value = "'.$taxonomyValue->slug.'" /><label for="laPro">'.$taxonomyValue->name.'</label>';  
                    }
                 }

                }
                if(in_array('mas-info-clinica-se',$Result_mInfClinArray)){
	              echo '<input type="checkbox" checked="checked" id="masInfoDefault" name ="'._x('mas-info-clinica','taxo-name','clinica').'-se" value="'._x('mas-info-clinica','taxo-name','clinica').'-se" /><label for="masInfoDefault">'._x('Sin Especificar','Right Archive Clinica','clinica_cpt_display').'</label>';                  
                }else{
                      echo '<input type="checkbox" id="masInfoDefault" name ="'._x('mas-info-clinica','taxo-name','clinica').'-se" value="'._x('mas-info-clinica','taxo-name','clinica').'-se" /><label for="masInfoDefault">'._x('Sin Especificar','Right Archive Clinica','clinica_cpt_display').'</label>';  

                }
        }

       ?>       
    </div>
  </div>
         <!-- Fin datos adicionales de la clínica-->

   
    
          <!-- Button Group con los filtros -->

     <?php   
     
      //Al ser el grupo de botones de equipamiento de la clínica de type checkbox el name no es común y hay que
      //ir realizando la comprobación uno por uno.
     //faco-microincision
     //femto-faco
     //biometros
     //iol-master
     //lenstar

	$Result_equipClinArray = array();
      
     if(array_key_exists(_x('faco-microincision','taxo-value-slug','clinica-scaffold'),$_GET) or 
        array_key_exists(_x('femto-faco','taxo-value-slug','clinica-scaffold'),$_GET) or 
        array_key_exists(_x('biometros','taxo-value-slug','clinica-scaffold'),$_GET) or 
        array_key_exists(_x('iol-master','taxo-value-slug','clinica-scaffold'),$_GET) or
        array_key_exists(_x('lenstar','taxo-value-slug','clinica-scaffold'),$_GET)
     	)
      {
        if(array_key_exists(_x('faco-microincision','taxo-value-slug','clinica-scaffold'),$_GET)){ 
            $Result_equipClinArray[] = $_GET[_x('faco-microincision','taxo-value-slug','clinica-scaffold')];
        }
        if(array_key_exists(_x('femto-faco','taxo-value-slug','clinica-scaffold'),$_GET)){ 
            $Result_equipClinArray[] = $_GET[_x('femto-faco','taxo-value-slug','clinica-scaffold')];
        }
        
        if(array_key_exists(_x('biometros','taxo-value-slug','clinica-scaffold'),$_GET)){ 
            $Result_equipClinArray[] = $_GET[_x('biometros','taxo-value-slug','clinica-scaffold')];
        }
        if(array_key_exists(_x('iol-master','taxo-value-slug','clinica-scaffold'),$_GET)){ 
            $Result_equipClinArray[] = $_GET[_x('iol-master','taxo-value-slug','clinica-scaffold')];
        }
        if(array_key_exists(_x('lenstar','taxo-value-slug','clinica-scaffold'),$_GET)){ 
            $Result_equipClinArray[] = $_GET[_x('lenstar','taxo-value-slug','clinica-scaffold')];
        }  
      }
     else{
           $Result_equipClinArray[] = _x('equipamiento-clinica','taxo-name','clinica')."-se";
     }
     
     //faco-microincision
     //femto-faco
     //biometros
     //iol-master
     //lenstar
     //$Result_equipClin
     
     
     ?>
    
    
    
     <div class="ui-widget startsUgly">
  <label  class="cliniBSetTitle"><?php echo _x('Equipos de la clínica','Right Archive Clinica','clinica_cpt_display');?></label>
    <div id="tipoIOLFilter">
        <?php 
        $equipClinS = get_terms(_x('equipamiento-clinica','taxo-name','clinica'), array('hide_empty' => 0)); 
        if  ($equipClinS) {
            foreach ($equipClinS as $taxonomyValue ) {
                //Check del primer término de la taxonomía.
                if($taxonomyValue->slug == _x('faco-microincision','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug,$Result_equipClinArray))//mucho mejor esta manera de llevar a cabo la comparación.
                    {
                     echo '<input type="checkbox" id="facoMicro" checked="checked" name ="'._x('equipamiento-clinica','taxo-name','clinica').'" value="'.$taxonomyValue->slug.'" /><label for="facoMicro">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="facoMicro" name ="'._x('equipamiento-clinica','taxo-name','clinica').'" value = "'.$taxonomyValue->slug.'" /><label for="facoMicro">'.$taxonomyValue->name.'</label>';  
                    }
                 }

                //Check del segundo término de la taxonomía.
                if($taxonomyValue->slug == _x('femto-faco','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug,$Result_equipClinArray))
                    {
                     echo '<input type="checkbox" id="femtoFaco" checked="checked" name ="'._x('equipamiento-clinica','taxo-name','clinica').'" value="'.$taxonomyValue->slug.'" /><label for="femtoFaco">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="femtoFaco" name ="'._x('equipamiento-clinica','taxo-name','clinica').'" value = "'.$taxonomyValue->slug.'" /><label for="femtoFaco">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('iol-master','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug,$Result_equipClinArray))
                    {
                     echo '<input type="checkbox" id="iolM" checked="checked" name ="'._x('equipamiento-clinica','taxo-name','clinica').'" value="'.$taxonomyValue->slug.'" /><label for="iolM">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="iolM" name ="'._x('equipamiento-clinica','taxo-name','clinica').'" value = "'.$taxonomyValue->slug.'" /><label for="iolM">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('lenstar','taxo-value-slug','clinica'))
                {
                 if(in_array($taxonomyValue->slug,$Result_equipClinArray))
                    {
                     echo '<input type="checkbox" id="lenst" checked="checked" name ="'._x('equipamiento-clinica','taxo-name','clinica').'" value="'.$taxonomyValue->slug.'" /><label for="lenst">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="lenst" name ="'._x('equipamiento-clinica','taxo-name','clinica').'" value = "'.$taxonomyValue->slug.'" /><label for="lenst">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                }
                if(in_array(_x('equipamiento-clinica','taxo-name','clinica').'-se',$Result_equipClinArray)){
                echo '<input type="checkbox" id="tipoEquipDefault" checked="checked" name ="'._x('equipamiento-clinica','taxo-name','clinica').'" value="'._x('equipamiento-clinica','taxo-name','clinica').'-se" /><label for="tipoEquipDefault">'._x('Sin Especificar','Right Archive Clinica','clinica_cpt_display').'</label>'; 
                }
                else{
                echo '<input type="checkbox" id="tipoEquipDefault" name ="equipamiento-clinica" value="'._x('equipamiento-clinica','taxo-name','clinica').'-se" /><label for="tipoEquipDefault">'._x('Sin Especificar','Right Archive Clinica','clinica_cpt_display').'</label>'; 
                } 
        }

       ?>       
    </div>
  </div>
   <!-- FIN Equipamiento-->
   
   
   <!-- Ini seguros Vamos con los seguros -->
   
               <?php

		if (array_key_exists(_x('seguros','taxo-name','clinica'),$_GET)){  
    	    $seguroSlug = $_GET[_x('seguros','taxo-name','clinica')];
        }
         else{
             $seguroSlug = _x('seguros','taxo-name','clinica').'-se';
         }
         
         $segurosValues = get_terms( array(_x('seguros','taxo-name','clinica')), array( 'parent' => 0 , 'hide_empty'=> 0 ) );
         
     ?>

        <!-- Inicio de Ubicacion: Comunidad Autónoma -> Son 2 comboboxes: La primera de términos padre y la segunda de términos hijo... lo suyo sería que apareciesen sólo los términos hijos del seleccionado-->
        <div id="seguros" class="ui-widget startsUgly">
        <label  class="cliniBSetTitle"><?php echo _x('Seguros:','Right Archive Clinica','clinica_cpt_display');?></label>
        <select id="combobox-seguros" name="seguros">
        <?php
        if  ($segurosValues) {
        
           	 echo '<option '.selected($seguroSlug,_x('seguros','taxo-name','clinica').'-se',false).' value = "'._x('seguros','taxo-name','clinica').'-se'.'" id="segurosDefault">'._x('Sin Especificar','Right Archive Clinica','clinica_cpt_display').'</option>';

          foreach ($segurosValues as $seguro ) {
                 echo '<option '.selected($seguro->slug,$seguroSlug,false).' value = "' . $seguro->slug . '">' . $seguro->name . '</option>';   
     	    		}
 
            }            
         ?>
        </select>
        </div>
         <!-- Fin de Seguros -->
   
   	
   	
   			<!-- Ini: Posibilidad de Financiación -->

  <?php   
      
       if( get_query_var( _x('financiacion','taxo-name','clinica') )){
           
           $Result_financiacion = get_query_var(_x('financiacion','taxo-name','clinica'));
        }
        else{
           $Result_financiacion = _x('financiacion','taxo-name','clinica').'-se';
        }
     ?>
  <div class="ui-widget startsUgly">
  <label title=" Explicación de posibilidad de financiación" class="labelTitle"><?php echo _x('Posibilidad de Financiación:','Right Archive Clinica','clinica_cpt_display');?></label>
    <div id="financiacionFilter"> <!-- femtoFaco -->
        <?php 
        $argsFinanciacion = array('hide_empty'    => false );
        $financiacionS = get_terms(_x('financiacion','taxo-name','clinica'), $argsFemtoFaco); 
        if  ($financiacionS) {
            foreach ($financiacionS as $financiacion ) {
            
echo '<input type="radio" id="financiacion'.$financiacion->slug.'" '.checked($financiacion->slug, $Result_financiacion, false).' name ="'._x('financiacion','taxo-name','clinica').'" value="'.$financiacion->slug.'" /><label for="financiacion'.$financiacion->slug.'">'.$financiacion->name.'</label>';
               }
           }
               
               echo '<input type="radio" id="financiacionDefault" '.checked(_x('financiacion','taxo-name','clinica').'-se', $Result_financiacion, false).'  name ="'._x('financiacion','taxo-name','clinica').'" value="'._x('financiacion','taxo-name','clinica').'-se" /><label for="financiacionDefault">'._x('No','Right Archive Clinica','clinica_cpt_display').'</label>';


       ?>       
    </div>
  </div>




		<!-- Fin: Posibilidad de Financiación -->

   	
   	

  </div>
     </div>     	
   </form>




    <?php
        echo '<!-- Incluido -->';
        //Añadimos el full Yarpp Bottom.
        echo '<br />';
        include( ABSPATH . 'wp-content/themes/iol/nc-yarpp-full-side.php');

    ?>


</div>	