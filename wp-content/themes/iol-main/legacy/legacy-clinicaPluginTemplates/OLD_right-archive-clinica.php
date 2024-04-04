
<div id="right" class="filter-right">





  <h3>BUSCAR CLÍNICAS:</h3>           
  <form id="clinica_filter_form" method="get" action="<?php echo get_post_type_archive_link('clinica'); ?>">

     <input type="button" class="singleClinicSubmit" value="Realizar Filtrado" onClick="archiveClinica_submit_me();" />
     
	<input name="action" type="hidden" value="clinica_filter_result" /> <!-- this puts the action the_ajax_hook into the serialized form -->

<!-- Inicio SelectList viewType-->
<!-- Aquí no queremos que haya opciones de visualización -->
<!-- Fin SelectList viewType-->
  
  <!-- Fin selectlist con el tipo de vista -->


   <!-- En el siguiente accordion: Ubicación y datos adicionales de la clínica -->
    <div id="accordionFilterSecond">
     <h3><span class="title-filter"> <?php echo _x('Ubicación/Características','Filter_Template','clinica_display'); ?> </span>
     <span id="dragger-accordionFilterSecond" class="ui-icon ui-icon-arrow-4-diag startsUgly">&nbsp;</span>
     <span id="reseter-accordionFilterSecond" class="ui-icon ui-icon-refresh startsUgly">&nbsp;</span></h3>
     <div>

     <?php   
     
     //posibilidad-de-financiacion
     //seguros
     //cirugia-intraocular-bilateral
     //posibilidad-de-hospitalizacion
     //quirofanos-propios
     //laser-propio

	$Result_equipClinArray = array();
      
     if(array_key_exists('posibilidad-de-financiacion',$_GET) or 
        array_key_exists('seguros',$_GET) or 
        array_key_exists('cirugia-intraocular-bilateral',$_GET) or 
        array_key_exists('posibilidad-de-hospitalizacion',$_GET) or
        array_key_exists('quirofanos-propios',$_GET) or
        array_key_exists('laser-propio',$_GET)
     	)
      {
        if(array_key_exists('posibilidad-de-financiacion',$_GET)){ 
            $Result_mInfClinArray[] = $_GET['posibilidad-de-financiacion'];
        }
        if(array_key_exists('seguros',$_GET)){ 
            $Result_mInfClinArray[] = $_GET['seguros'];
        }
        
        if(array_key_exists('cirugia-intraocular-bilateral',$_GET)){ 
            $Result_mInfClinArray[] = $_GET['cirugia-intraocular-bilateral'];
        }
        if(array_key_exists('posibilidad-de-hospitalizacion',$_GET)){ 
            $Result_mInfClinArray[] = $_GET['posibilidad-de-hospitalizacion'];
        }
        if(array_key_exists('quirofanos-propios',$_GET)){ 
            $Result_mInfClinArray[] = $_GET['quirofanos-propios'];
        }
        
        if(array_key_exists('laser-propio',$_GET)){ 
            $Result_mInfClinArray[] = $_GET['laser-propio'];
        }    
      }
     else{
           $Result_mInfClinArray[] = "mas-info-clinica-se";
     }
     ?>
    
    <!-- Fin de más información sobre la clínica-->
    
    
     <div class="ui-widget startsUgly" id="mas-info-clinica">
  <label class="cliniBSetTitle"><?php echo _x('Datos adicionales de la clínica','Filter_Template','clinica_display');?></label>
    <div id="tipoMInfFilter">
        <?php 
        $mInfClinS = get_terms('mas-info-clinica'); 
        if  ($mInfClinS) {
            foreach ($mInfClinS as $taxonomyValue ) {
                //Check del primer término de la taxonomía.
                if($taxonomyValue->slug == _x('posibilidad-de-financiacion','taxo-mas-info-value-slug','clinica'))
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
                if($taxonomyValue->slug == _x('seguros','taxo-mas-info-value-slug','clinica'))
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
                if($taxonomyValue->slug == _x('cirugia-intraocular-bilateral','taxo-mas-info-value-slug','clinica'))
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
                if($taxonomyValue->slug == _x('posibilidad-de-hospitalizacion','taxo-mas-info-value-slug','clinica'))
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
                if($taxonomyValue->slug == _x('quirofanos-propios','taxo-mas-info-value-slug','clinica'))
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
                if($taxonomyValue->slug == _x('laser-propio','taxo-mas-info-value-slug','clinica'))
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
	              echo '<input type="checkbox" checked="checked" id="masInfoDefault" name ="mas-info-clinica-se" value="mas-info-clinica-se" /><label for="masInfoDefault">'._x('Sin Especificar','filter_template','clinica').'</label>';                  
                }else{
                      echo '<input type="checkbox" id="masInfoDefault" name ="mas-info-clinica-se" value="mas-info-clinica-se" /><label for="masInfoDefault">'._x('Sin Especificar','filter_template','clinica').'</label>';  

                }
        }

       ?>       
    </div>
  </div>
         <!-- Fin datos adicionales de la clínica-->

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
         
         $comAutos = get_terms( array('ubicacion'), array( 'parent' => 0 , 'hide_empty'=> 0 ) );
         

		if (array_key_exists('ubicacion-child',$_GET)){
           
	        $provinciaTermSlug = $_GET['ubicacion-child'];
        }
         else{
             $provinciaTermSlug = "ubicacion-child-se";
         }   
         
         //no veo el sentido de limitar la provincia de inicio.
         $provincesInScope = get_terms( array('ubicacion'), array('hierarchical'=> FALSE, 'hide_empty'=> 0 ));

     ?>

        <!-- Inicio de Ubicacion: Comunidad Autónoma -> Son 2 comboboxes: La primera de términos padre y la segunda de términos hijo... lo suyo sería que apareciesen sólo los términos hijos del seleccionado-->
        <div class="ui-widget startsUgly">
        <label  class="cliniBSetTitle"><?php echo _x('Comunidad Autónoma:','Filter_Template','iol_display');?></label>
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
       	               echo '<option selected="selected" value = "ubicacion-parent-se" id="comAutoDefault">'._x('Sin Especificar','Filter_Template','iol_display').'</option>';
                }else{
                	echo '<option value ="ubicacion-parent-se">Sin Especificar</option>';
                }    
            }            
         ?>
        </select>
        </div>
         <!-- Fin de Ubicacion Comunidad Autónoma -->

         <!-- Inicio Provincia-->
        <div class="ui-widget startsUgly" id="provincia">
        <label  class="cliniBSetTitle"><?php echo _x('Provincia:','Filter_Template','iol_display');?></label>
        <select id="combobox-ubicacion-child" name="ubicacion-child">
        <?php
        if  ($provincesInScope) {
               echo '<option value = "ubicacion-parent-se" id="comAutoDefault">'._x('Sin Especificar','Filter_Template','iol_display').'</option>';
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
                echo '<option selected="selected" value = "ubicacion-child-se">Sin Especificar </option>';
                }else{
                echo '<option value = "ubicacion-child-se">Sin Especificar </option>';
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
     <h3> <span class="title-filter"><?php echo _x('Características básicas','Filter_Template','clinica_display'); ?> </span>
     <span id="dragger-accordionFilterSimple" class="ui-icon ui-icon-arrow-4-diag startsUgly">&nbsp;</span>
     <span id="reseter-accordionFilterSimple" class="ui-icon ui-icon-refresh startsUgly">&nbsp;</span>
     </h3>
     <div>
  <!-- Número de Cirugías de la clínica -->
  <?php
     //Vamos a ver el tipo de lente que nos viene
        if (array_key_exists('numero-cirugias-intraoculares',$_GET)){
           
	        $Result_numSx = $_GET['numero-cirugias-intraoculares'];
            //echo $Result_Tipo;
        }
         else{
             //$UndefinedTaxonomyDataSelector[] = 'select[name="tipo-lente-intraocular"]';
             $Result_numSx = "numero-cirugias-intraoculares-se";
         }
     ?>
     
  <div class="ui-widget startsUgly">
    <label class="cliniBSetTitle"><?php echo _x('Número de cirugías Intraoculares al año realizadas en la clínica','Filter_Template','clinica_display');?></label>
    <div id="numSxFilter">
        <?php 
        $numSxIntraS = get_terms(_x('numero-cirugias-intraoculares','taxo-name','clinica')); 
        if  ($numSxIntraS) {
            foreach ($numSxIntraS as $taxonomyValue ) {
                //Check del primer término de la taxonomía.
                if($taxonomyValue->slug == _x('menos-de-300-al-ano','taxo-torici-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_numSx)
                    {
                     echo '<input type="radio" id="menos300" checked="checked" name ="numero-cirugias-intraoculares" value="'.$taxonomyValue->slug.'" /><label for="menos300">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="menos300" name ="numero-cirugias-intraoculares" value = "'.$taxonomyValue->slug.'" /><label for="menos300">'.$taxonomyValue->name.'</label>';  
                    }
                 }

                //Check del segundo término de la taxonomía.
                if($taxonomyValue->slug == _x('entre-300-y-800-al-ano','taxo-torici-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_numSx)
                    {
                     echo '<input type="radio" id="entre300y800" checked="checked" name ="numero-cirugias-intraoculares" value="'.$taxonomyValue->slug.'" /><label for="entre300y800">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="entre300y800" name ="numero-cirugias-intraoculares" value = "'.$taxonomyValue->slug.'" /><label for="entre300y800">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('mas-de-800-al-año','taxo-torici-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_numSx)
                    {
                     echo '<input type="radio" id="mas800" checked="checked" name ="numero-cirugias-intraoculares" value="'.$taxonomyValue->slug.'" /><label for="mas800">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="mas800" name ="numero-cirugias-intraoculares" value = "'.$taxonomyValue->slug.'" /><label for="mas800">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                }
                if($Result_numSx == 'numero-cirugias-intraoculares-se'){
              echo '<input type="radio" id="numSxDefault" checked ="checked" name ="numero-cirugias-intraoculares" value="numero-cirugias-intraoculares-se" /><label for="numSxDefault">'._x('Sin Especificar','filter_template','clinica').'</label>';  
                }
                else{
              echo '<input type="radio" id="numSxDefault" name ="numero-cirugias-intraoculares" value="numero-cirugias-intraoculares-se" /><label for="numSxDefault">'._x('Sin Especificar','filter_template','clinica').'</label>';  }
        }

       ?>       
    </div>
  </div>
    <!-- Pregunta Tipo de cirugías -->
  <?php
     //Vamos a ver el tipo de lente que nos viene
        if (array_key_exists('tipo-operaciones-intraoculares',$_GET)){
           
	        $Result_tipoOp = $_GET['tipo-operaciones-intraoculares'];
            //echo $Result_Tipo;
        }
         else{
             //$UndefinedTaxonomyDataSelector[] = 'select[name="tipo-lente-intraocular"]';
             $Result_tipoOp = "tipo-operaciones-intraoculares-se";
         }
     ?>
    
     <div class="ui-widget startsUgly">
  <label  class="cliniBSetTitle"><?php echo _x('Tipos de operaciones intraoculares','Filter_Template','clinica_display');?></label>
    <div id="tipoOpFilter">
        <?php 
        $tipoOpIntraS = get_terms('tipo-operaciones-intraoculares'); 
        if  ($tipoOpIntraS) {
            foreach ($tipoOpIntraS as $taxonomyValue ) {
                //Check del primer término de la taxonomía.
                if($taxonomyValue->slug == _x('cataratas-remplazo-de-cristalino','taxo-tipo-cirugia-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_tipoOp)
                    {
                     echo '<input type="radio" id="catReCris" checked="checked" name ="tipo-operaciones-intraoculares" value="'.$taxonomyValue->slug.'" /><label for="catReCris">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="catReCris" name ="tipo-operaciones-intraoculares" value = "'.$taxonomyValue->slug.'" /><label for="catReCris">'.$taxonomyValue->name.'</label>';  
                    }
                 }

                //Check del segundo término de la taxonomía.
                if($taxonomyValue->slug == _x('lentes-faquicas','taxo-tipo-cirugia-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_tipoOp)
                    {
                     echo '<input type="radio" id="lentFaq" checked="checked" name ="tipo-operaciones-intraoculares" value="'.$taxonomyValue->slug.'" /><label for="lentFaq">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="lentFaq" name ="tipo-operaciones-intraoculares" value = "'.$taxonomyValue->slug.'" /><label for="lentFaq">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('refractiva-laser','taxo-tipo-cirugia-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_tipoOp)
                    {
                     echo '<input type="radio" id="refLas" checked="checked" name ="tipo-operaciones-intraoculares" value="'.$taxonomyValue->slug.'" /><label for="refLas">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="refLas" name ="tipo-operaciones-intraoculares" value = "'.$taxonomyValue->slug.'" /><label for="refLas">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                }
                if($Result_tipoOp == 'tipo-operaciones-intraoculares-se' ){
                echo '<input type="radio" id="tipOpDef" checked="checked" name ="tipo-operaciones-intraoculares" value="tipo-operaciones-intraoculares-se" /><label for="tipOpDef">'._x('Sin Especificar','filter_template','clinica').'</label>'; 
                }
                else{
                   echo '<input type="radio" id="tipOpDef" name ="tipo-operaciones-intraoculares" value="tipo-operaciones-intraoculares-se" /><label for="tipOpDef">'._x('Sin Especificar','filter_template','clinica').'</label>';  }

        }

       ?>       
    </div>
  </div>

    <!-- Pregunta Tipo de implante -->
  <?php
     //Vamos a ver el tipo de lente que nos viene
        if (array_key_exists('tipo-de-implante',$_GET)){
           
	        $Result_tipoImpl = $_GET['tipo-de-implante'];
        }
         else{
             $Result_tipoImpl = "tipo-de-implante-se";
         }
     ?>
    
     <div class="ui-widget startsUgly">
  <label class="cliniBSetTitle"><?php echo _x('Tipos de IOLs','Filter_Template','clinica_display');?></label>
    <div id="tipoIOLFilter">
        <?php 
        $tipoOpIntraS = get_terms('tipo-de-implante'); 
        if  ($tipoOpIntraS) {
            foreach ($tipoOpIntraS as $taxonomyValue ) {
                //Check del primer término de la taxonomía.
                if($taxonomyValue->slug == _x('lentes-multifocales','taxo-tipo-iol-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_tipoImpl)
                    {
                     echo '<input type="radio" id="lenMult" checked="checked" name ="tipo-de-implante" value="'.$taxonomyValue->slug.'" /><label for="lenMult">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="lenMult" name ="tipo-de-implante" value = "'.$taxonomyValue->slug.'" /><label for="lenMult">'.$taxonomyValue->name.'</label>';  
                    }
                 }

                //Check del segundo término de la taxonomía.
                if($taxonomyValue->slug == _x('lentes-toricas','taxo-tipo-iol-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_tipoImpl)
                    {
                     echo '<input type="radio" id="lentTor" checked="checked" name ="tipo-de-implante" value="'.$taxonomyValue->slug.'" /><label for="lentTor">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="lentTor" name ="tipo-de-implante" value = "'.$taxonomyValue->slug.'" /><label for="lentTor">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('lentes-acomodativas','taxo-tipo-iol-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_tipoImpl)
                    {
                     echo '<input type="radio" id="lentAco" checked="checked" name ="tipo-de-implante" value="'.$taxonomyValue->slug.'" /><label for="lentAco">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="lentAco" name ="tipo-de-implante" value = "'.$taxonomyValue->slug.'" /><label for="lentAco">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('monovision','taxo-tipo-iol-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_tipoImpl)
                    {
                     echo '<input type="radio" id="monov" checked="checked" name ="tipo-de-implante" value="'.$taxonomyValue->slug.'" /><label for="monov">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="monov" name ="tipo-de-implante" value = "'.$taxonomyValue->slug.'" /><label for="monov">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('lentes-ajustables-por-luz','taxo-tipo-iol-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_tipoImpl)
                    {
                     echo '<input type="radio" id="lal" checked="checked" name ="tipo-de-implante" value="'.$taxonomyValue->slug.'" /><label for="lal">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="lal" name ="tipo-de-implante" value = "'.$taxonomyValue->slug.'" /><label for="lal">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('lentes-de-filtro-azul','taxo-tipo-iol-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_tipoImpl)
                    {
                     echo '<input type="radio" id="lentFA" checked="checked" name ="tipo-de-implante" value="'.$taxonomyValue->slug.'" /><label for="lentFA">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="lentFA" name ="tipo-de-implante" value = "'.$taxonomyValue->slug.'" /><label for="lentFA">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('lentes-asfericas','taxo-tipo-iol-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_tipoImpl)
                    {
                     echo '<input type="radio" id="lentAsf" checked="checked" name ="tipo-de-implante" value="'.$taxonomyValue->slug.'" /><label for="lentAsf">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="lentAsf" name ="tipo-de-implante" value = "'.$taxonomyValue->slug.'" /><label for="lentAsf">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                }
                if($Result_tipoImpl=='tipo-de-implante-se'){
                echo '<input type="radio" id="tipoImpDefault"  checked="checked" name ="tipo-de-implante" value="tipo-de-implante-se" /><label for="tipoImpDefault">Sin Especificar</label>';
                }
                else{
                echo '<input type="radio" id="tipoImpDefault" name ="tipo-de-implante" value="tipo-de-implante-se" /><label for="tipoImpDefault">Sin Especificar</label>';
                }
               
        /*echo '<input type="radio" id="tipoImpDefault" name ="tipo-de-implante" value = "'.$taxonomyValue->slug.'" /><label for="tipoImpDefault">'.$taxonomyValue->name.'</label>';*/
        }

       ?>       
    </div>
  </div>
   <!-- Fin tipo de LIO's-->
   
    
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
      
     if(array_key_exists('faco-microincision',$_GET) or 
        array_key_exists('femto-faco',$_GET) or 
        array_key_exists('biometros',$_GET) or 
        array_key_exists('iol-master',$_GET) or
        array_key_exists('lenstar',$_GET)
     	)
      {
        if(array_key_exists('faco-microincision',$_GET)){ 
            $Result_equipClinArray[] = $_GET['faco-microincision'];
        }
        if(array_key_exists('femto-faco',$_GET)){ 
            $Result_equipClinArray[] = $_GET['femto-faco'];
        }
        
        if(array_key_exists('biometros',$_GET)){ 
            $Result_equipClinArray[] = $_GET['biometros'];
        }
        if(array_key_exists('iol-master',$_GET)){ 
            $Result_equipClinArray[] = $_GET['iol-master'];
        }
        if(array_key_exists('lenstar',$_GET)){ 
            $Result_equipClinArray[] = $_GET['lenstar'];
        }  
      }
     else{
           $Result_equipClinArray[] = "equipamiento-clinica-se";
     }
     
     //faco-microincision
     //femto-faco
     //biometros
     //iol-master
     //lenstar
     //$Result_equipClin
     
     
     ?>
    
    
    
     <div class="ui-widget startsUgly">
  <label  class="cliniBSetTitle"><?php echo _x('Equipos de la clínica','Filter_Template','clinica_display');?></label>
    <div id="tipoIOLFilter">
        <?php 
        $equipClinS = get_terms('equipamiento-clinica', array('hide_empty'=>0)); 
        if  ($equipClinS) {
            foreach ($equipClinS as $taxonomyValue ) {
                //Check del primer término de la taxonomía.
                if($taxonomyValue->slug == _x('faco-microincision','taxo-equipamiento-value-slug','clinica'))
                {
                 if(in_array($taxonomyValue->slug,$Result_equipClinArray))//mucho mejor esta manera de llevar a cabo la comparación.
                    {
                     echo '<input type="checkbox" id="facoMicro" checked="checked" name ="equipamiento-clinica" value="'.$taxonomyValue->slug.'" /><label for="facoMicro">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="facoMicro" name ="equipamiento-clinica" value = "'.$taxonomyValue->slug.'" /><label for="facoMicro">'.$taxonomyValue->name.'</label>';  
                    }
                 }

                //Check del segundo término de la taxonomía.
                if($taxonomyValue->slug == _x('femto-faco','taxo-equipamiento-value-slug','clinica'))
                {
                 if(in_array($taxonomyValue->slug,$Result_equipClinArray))
                    {
                     echo '<input type="checkbox" id="femtoFaco" checked="checked" name ="equipamiento-clinica" value="'.$taxonomyValue->slug.'" /><label for="femtoFaco">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="femtoFaco" name ="equipamiento-clinica" value = "'.$taxonomyValue->slug.'" /><label for="femtoFaco">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('biometros','taxo-equipamiento-value-slug','clinica'))
                {
                 if(in_array($taxonomyValue->slug,$Result_equipClinArray))
                    {
                     echo '<input type="checkbox" id="biome" checked="checked" name ="equipamiento-clinica" value="'.$taxonomyValue->slug.'" /><label for="biome">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="biome" name ="equipamiento-clinica" value = "'.$taxonomyValue->slug.'" /><label for="biome">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('iol-master','taxo-equipamiento-value-slug','clinica'))
                {
                 if(in_array($taxonomyValue->slug,$Result_equipClinArray))
                    {
                     echo '<input type="checkbox" id="iolM" checked="checked" name ="equipamiento-clinica" value="'.$taxonomyValue->slug.'" /><label for="iolM">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="iolM" name ="equipamiento-clinica" value = "'.$taxonomyValue->slug.'" /><label for="iolM">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('lenstar','taxo-equipamiento-value-slug','clinica'))
                {
                 if(in_array($taxonomyValue->slug,$Result_equipClinArray))
                    {
                     echo '<input type="checkbox" id="lenst" checked="checked" name ="equipamiento-clinica" value="'.$taxonomyValue->slug.'" /><label for="lenst">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="lenst" name ="equipamiento-clinica" value = "'.$taxonomyValue->slug.'" /><label for="lenst">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                }
                if(in_array('equipamiento-clinica-se',$Result_equipClinArray)){
                echo '<input type="checkbox" id="tipoEquipDefault" checked="checked" name ="equipamiento-clinica" value="equipamiento-clinica-se" /><label for="tipoEquipDefault">'._x('Sin Especificar','filter_template','clinica').'</label>'; 
                }
                else{
                echo '<input type="checkbox" id="tipoEquipDefault" name ="equipamiento-clinica" value="equipamiento-clinica-se" /><label for="tipoEquipDefault">'._x('Sin Especificar','filter_template','clinica').'</label>'; 
                } 
        }

       ?>       
    </div>
  </div>
   <!-- FIN Equipamiento-->

  </div>
     </div>     	
   </form>

</div>	