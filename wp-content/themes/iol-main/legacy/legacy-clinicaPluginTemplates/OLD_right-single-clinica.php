
<div id="right" class="filter-right">


  <h3>BUSCAR CLÍNICAS:</h3>           
  <form id="clinica_filter_form" method="get" action="<?php echo get_post_type_archive_link('clinica'); ?>">


 <div id="accordionFilterSimple">
     <h3> <span class="title-filter"><?php echo _x('Características básicas','Filter_Template','clinica_display'); ?></span> </h3>
     <div>
<!-- Número de cirugías de la clínica: VARIABLE DICOTÓMICA que referencia la presencia de un valor de taxonomía. -->
  <?php   

      //Vamos a sacar el número de cirugías de la clínica.
        $numSxIntra = get_the_terms( $post->ID,'numero-cirugias-intraoculares');
						
        if ( $numSxIntra && ! is_wp_error( $numSxIntra ) ){            
        	$taxo_numSxIntra = array();
    	    foreach ( $numSxIntra as $term ) {
	    	    $taxo_numSxIntra[] = $term->slug;
	        }						
	        $Result_numSx = join("", $taxo_numSxIntra);
        }
        else{
            $Result_numSx = '';
                    }
     ?>
  <div class="ui-widget">
    <label class="cliniBSetTitle"><?php echo _x('Número de cirugías Intraoculares al año realizadas en la clínica','Filter_Template','clinica_display');?><br /><br /></label>
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
              echo '<input type="radio" id="numSxDefault" name ="numero-cirugias-intraoculares" value="numero-cirugias-intraoculares-se" /><label for="numSxDefault">'._x('Sin Especificar','filter_template','clinica').'</label>';  
        }

       ?>       
    </div>
  </div>
    <!-- Pregunta Tipo de cirugías -->
    <?php
        //Vamos a sacar el número de cirugías de la clínica.
        $tipoOpIntra = get_the_terms( $post->ID, 'tipo-operaciones-intraoculares' );
						
        if ( $tipoOpIntra && ! is_wp_error( $tipoOpIntra ) ){            
        	$taxo_tipoOpIntra = array();
    	    foreach ( $tipoOpIntra as $term ) {
	    	    $taxo_tipoOpIntra[] = $term->slug;
	        }						
	        $Result_tipoOp = join("", $taxo_tipoOpIntra);
        }
        else{
            $Result_tipoOp = '';
                    }
    ?>
     <div class="ui-widget">
  <br /><label  class="cliniBSetTitle"><?php echo _x('Tipos de operaciones intraoculares','Filter_Template','clinica_display');?><br /><br /></label>
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
              echo '<input type="radio" id="tipOpDef" name ="tipo-operaciones-intraoculares" value="tipo-operaciones-intraoculares-se" /><label for="tipOpDef">'._x('Sin Especificar','filter_template','clinica').'</label>';  
        }

       ?>       
    </div>
  </div>

   <!-- Fin tipo de cirugías -->

   <!-- Inicio tipo de LIO's-->
    <?php
        //Vamos a sacar el número de cirugías de la clínica.
        $tipoImpl = get_the_terms( $post->ID, 'tipo-de-implante' );
						
        if ( $tipoImpl && ! is_wp_error( $tipoImpl ) ){            
        	$taxo_tipoImpl = array();
    	    foreach ( $tipoImpl as $term ) {
	    	    $taxo_tipoImpl[] = $term->slug;
	        }						
	        $Result_tipoImpl = join("", $taxo_tipoImpl);
        }
        else{
            $Result_tipoImpl = '';
                    }
    ?>
     <div class="ui-widget">
  <br /><label class="cliniBSetTitle"><?php echo _x('Tipos de IOLs','Filter_Template','clinica_display');?><br /><br /></label>
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
              echo '<input type="radio" id="tipoImpDefault" name ="tipo-de-implante" value="tipo-de-implante-se" /><label for="tipoImpDefault">Sin Especificar</label>'; 
        /*echo '<input type="radio" id="tipoImpDefault" name ="tipo-de-implante" value = "'.$taxonomyValue->slug.'" /><label for="tipoImpDefault">'.$taxonomyValue->name.'</label>';*/
        }

       ?>       
    </div>
  </div>
   <!-- Fin tipo de LIO's-->
   
   <!-- Inicio Equipamiento-->
       <?php
        //Vamos a sacar el número de cirugías de la clínica.
        $equipClin = get_the_terms( $post->ID, 'equipamiento-clinica' );
						
        if ( $equipClin && ! is_wp_error( $equipClin ) ){            
        	$taxo_equipClin = array();
    	    foreach ( $equipClin as $term ) {
	    	    $taxo_equipClin[] = $term->slug;
	        }						
	        $Result_equipClin = join("", $taxo_equipClin);
        }
        else{
            $Result_equipClin = '';
                    }
    ?>
     <div class="ui-widget">
  <br /><label  class="cliniBSetTitle"><?php echo _x('Equipos de la clínica','Filter_Template','clinica_display');?><br /><br /></label>
    <div id="tipoIOLFilter">
        <?php 
        $equipClinS = get_terms('equipamiento-clinica'); 
        if  ($equipClinS) {
            foreach ($equipClinS as $taxonomyValue ) {
                //Check del primer término de la taxonomía.
                if($taxonomyValue->slug == _x('faco-microincision','taxo-equipamiento-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_equipClin)
                    {
                     echo '<input type="radio" id="facoMicro" checked="checked" name ="equipamiento-clinica" value="'.$taxonomyValue->slug.'" /><label for="facoMicro">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="facoMicro" name ="equipamiento-clinica" value = "'.$taxonomyValue->slug.'" /><label for="facoMicro">'.$taxonomyValue->name.'</label>';  
                    }
                 }

                //Check del segundo término de la taxonomía.
                if($taxonomyValue->slug == _x('femto-faco','taxo-equipamiento-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_equipClin)
                    {
                     echo '<input type="radio" id="femtoFaco" checked="checked" name ="equipamiento-clinica" value="'.$taxonomyValue->slug.'" /><label for="femtoFaco">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="femtoFaco" name ="equipamiento-clinica" value = "'.$taxonomyValue->slug.'" /><label for="femtoFaco">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('biometros','taxo-equipamiento-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_equipClin)
                    {
                     echo '<input type="radio" id="biome" checked="checked" name ="equipamiento-clinica" value="'.$taxonomyValue->slug.'" /><label for="biome">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="biome" name ="equipamiento-clinica" value = "'.$taxonomyValue->slug.'" /><label for="biome">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('iol-master','taxo-equipamiento-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_equipClin)
                    {
                     echo '<input type="radio" id="iolM" checked="checked" name ="equipamiento-clinica" value="'.$taxonomyValue->slug.'" /><label for="iolM">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="iolM" name ="equipamiento-clinica" value = "'.$taxonomyValue->slug.'" /><label for="iolM">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('lenstar','taxo-equipamiento-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_equipClin)
                    {
                     echo '<input type="radio" id="lenst" checked="checked" name ="equipamiento-clinica" value="'.$taxonomyValue->slug.'" /><label for="lenst">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="lenst" name ="equipamiento-clinica" value = "'.$taxonomyValue->slug.'" /><label for="lenst">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                }
              echo '<input type="radio" id="tipoEquipDefault" name ="equipamiento-clinica" value="equipamiento-clinica-se" /><label for="tipoEquipDefault">'._x('Sin Especificar','filter_template','clinica').'</label>';  
        }

       ?>       
    </div>
  </div>
   <!-- FIN Equipamiento-->

  </div>
     </div>

   <!-- En el siguiente accordion: Ubicación y datos adicionales de la clínica -->
    <div id="accordionFilterSecond">
     <h3> <span class="title-filter"><?php echo _x('Ubicación y Características Adicionales','Filter_Template','clinica_display'); ?></span> </h3>
     <div>
         <!-- Datos adicionales de la Clínica -->
               <?php
        //Vamos a sacar el número de cirugías de la clínica.
        $mInfClin = get_the_terms( $post->ID, 'mas-info-clinica' );
						
        if ( $mInfClin && ! is_wp_error( $mInfClin ) ){            
        	$taxo_mInfClin = array();
    	    foreach ( $mInfClin as $term ) {
	    	    $taxo_mInfClin[] = $term->slug;
	        }						
	        $Result_mInfClin = join("", $taxo_mInfClin);
        }
        else{
            $Result_mInfClin = '';
                    }
    ?>
     <div class="ui-widget">
  <br /><label class="cliniBSetTitle"><?php echo _x('Datos adicionales de la clínica','Filter_Template','clinica_display');?><br /><br /></label>
    <div id="tipoMInfFilter">
        <?php 
        $mInfClinS = get_terms('mas-info-clinica'); 
        if  ($mInfClinS) {
            foreach ($mInfClinS as $taxonomyValue ) {
                //Check del primer término de la taxonomía.
                if($taxonomyValue->slug == _x('posibilidad-de-financiacion','taxo-mas-info-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_mInfClin)
                    {
                     echo '<input type="radio" id="posFinan" checked="checked" name ="mas-info-clinica" value="'.$taxonomyValue->slug.'" /><label for="posFinan">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="posFinan" name ="mas-info-clinica" value = "'.$taxonomyValue->slug.'" /><label for="posFinan">'.$taxonomyValue->name.'</label>';  
                    }
                 }

                //Check del segundo término de la taxonomía.
                if($taxonomyValue->slug == _x('seguros','taxo-mas-info-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_mInfClin)
                    {
                     echo '<input type="radio" id="seguros" checked="checked" name ="mas-info-clinica" value="'.$taxonomyValue->slug.'" /><label for="seguros">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="seguros" name ="mas-info-clinica" value = "'.$taxonomyValue->slug.'" /><label for="seguros">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('cirugia-intraocular-bilateral','taxo-mas-info-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_mInfClin)
                    {
                     echo '<input type="radio" id="cirubi" checked="checked" name ="mas-info-clinica" value="'.$taxonomyValue->slug.'" /><label for="cirubi">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="cirubi" name ="mas-info-clinica" value = "'.$taxonomyValue->slug.'" /><label for="cirubi">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('posibilidad-de-hospitalizacion','taxo-mas-info-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_mInfClin)
                    {
                     echo '<input type="radio" id="posHos" checked="checked" name ="mas-info-clinica" value="'.$taxonomyValue->slug.'" /><label for="posHos">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="posHos" name ="mas-info-clinica" value = "'.$taxonomyValue->slug.'" /><label for="posHos">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('quirofanos-propios','taxo-mas-info-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_equipClin)
                    {
                     echo '<input type="radio" id="quiPro" checked="checked" name ="mas-info-clinica" value="'.$taxonomyValue->slug.'" /><label for="quiPro">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="quiPro" name ="mas-info-clinica" value = "'.$taxonomyValue->slug.'" /><label for="quiPro">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('laser-propio','taxo-mas-info-value-slug','clinica'))
                {
                 if($taxonomyValue->slug == $Result_equipClin)
                    {
                     echo '<input type="radio" id="laPro" checked="checked" name ="mas-info-clinica" value="'.$taxonomyValue->slug.'" /><label for="laPro">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="laPro" name ="mas-info-clinica" value = "'.$taxonomyValue->slug.'" /><label for="laPro">'.$taxonomyValue->name.'</label>';  
                    }
                 }

                }
              echo '<input type="radio" id="masInfoDefault" name ="mas-info-clinica" value=""mas-info-clinica-se" /><label for="masInfoDefault">'._x('Sin Especificar','filter_template','clinica').'</label>';  
        }

       ?>       
    </div>
  </div>
         <!-- Fin datos adicionales de la clínica-->

             <?php
         //Vamos a poner a sacar el tipo de lente que es (Recordemos que hemos establecido una clasificación jerárquica).
         $provinciaTerm = array_shift(array_values(get_the_terms( $post->ID, 'ubicacion' )));			 
         $provinciaTermSlug = $provinciaTerm->slug;
         $comAutos = get_terms( array('ubicacion'), array( 'parent' => 0 , 'hide_empty'=> 0 ) ); 
         $comAuto = get_term_by('id',$provinciaTerm->parent,'ubicacion');
         $comAutoSlug = $comAuto->slug;
         $comAutoId = $comAuto->term_id;
         //$provinces =  get_terms( array('ubicacion'), array('hierarchical'=> FALSE, 'hide_empty'=> 0));
         $provincesInScope = get_terms( array('ubicacion'), array('hierarchical'=> FALSE, 'hide_empty'=> 0, 'parent'=>$comAutoId ));

     ?>

        <!-- Inicio de Ubicacion: Comunidad Autónoma -> Son 2 comboboxes: La primera de términos padre y la segunda de términos hijo... lo suyo sería que apareciesen sólo los términos hijos del seleccionado-->
        <div class="ui-widget">
        <br /><label  class="cliniBSetTitle"><?php echo _x('Comunidad Autónoma:','Filter_Template','iol_display');?> <br /><br /></label>
        <select id="combobox-ubicacion-parent" name="ubicacion-parent">
        <?php
        if  ($comAutos) {
               echo '<option value = "ubicacion-parent-se" id="comAutoDefault">'._x('Sin Especificar','Filter_Template','iol_display').'</option>';
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
            }            
         ?>
        </select>
        </div>
         <!-- Fin de Ubicacion Comunidad Autónoma -->

         <!-- Inicio Provincia-->
        <div class="ui-widget" id="provincia">
        <br /><label  class="cliniBSetTitle"><?php echo _x('Provincia:','Filter_Template','iol_display');?> <br /><br /></label>
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
            }            
         ?>
        </select>
        </div>
         <!-- Fin Provincia -->

     </div>
    </div>
   <!-- Fin del segundo accordion -->


   <input type="button" class="singleClinicSubmit" value="Buscar Clínicas" onClick="singleClinic_submit_me();" />     	
   </form>

</div>	