
<?php 
     echo '  <script>
  jQuery(function() {
    jQuery( document ).tooltip();
  });
  </script>';


	//Variable array donde pondremos los ids de los inputs de las taxonomías y metadatos que la lente no tiene defenidas.
	$UndefinedTaxonomyDataSelector = array();
	$UndefinedMetaDataSelector = array();
		
?>



   <!-- Prueba para saber si la added_query_var puede coincidir con un taxo_slug -->
  <h2> <?php echo _x('BUSCAR LENTES INTRAOCULARES:','Right Single Lente Intraocular','iol_cpt_display'); ?></h2>      
  <form id="iol_filter_form" method="get" action="<?php echo get_post_type_archive_link(_x('lente-intraocular','CustomPostType Name','iol')); ?>"> <?php /*?pt=no*/ ?>

   <input type="button" value="<?php echo _x('Realizar Filtrado','Right Archive Lente Intraocular','iol_cpt_display'); ?>" class="submitSingle" onClick="single_submit_me();" />    

 <!-- <input name="action"  type="hidden" value="filter_result" /> --> <!-- this puts the action the_ajax_hook into the serialized form -->

<!-- Vamos a añadir este hidden input para llevar a cabo la paginación -->
  <!-- <input id="pagina" name="pt" type="hidden" value="no" /> Quitamos cualquier referencia a pt -->

  <!-- Inicio del Filtro de usuarios normales-->
 <div id="simpleAccordionFilter">
     <h3> <span class="title-filter"><?php echo _x('Características Generales','Right Single Lente Intraocular','iol_cpt_display'); ?> </span></h3>
     <div>
        <!-- Combo con el Tipo de lente Intraocular -->
  <?php
     //Vamos a poner a sacar el tipo de lente que es (Recordemos que hemos establecido una clasificación jerárquica).
     //Vamos a hacer exclusiones de términos que no concuerden con los valores esperados para esta taxonomía en en el right single form.
       
       //Sacamos los ids de los términos hijo de la pseudofáquica.

       $pseudoFaqTaxValue = _x('pseudofaquica','taxo-value-slug','iol-scaffold');
       $tipoIolTaxName = _x('tipo-lente-intraocular','taxo-name','iol');

       $pseudoTerm = get_term_by('slug', $pseudoFaqTaxValue   , $tipoIolTaxName );
       $exclPseudoChildTerms = get_terms($tipoIolTaxName, array('child_of'=>$pseudoTerm->term_id));
       
       $exclPseudoChildTermsIds = wp_list_pluck($exclPseudoChildTerms,'term_id');


        $tipoLente = get_the_terms( $post->ID, $tipoIolTaxName );
		//$tipoLente = get_terms('id',$post->ID, array('exclude'=>$exclPseudoChildTermsIds));
        				
        if ( $tipoLente && ! is_wp_error( $tipoLente ) ){
            
        	$taxo_tipoLente = array();
    	    foreach ( $tipoLente as $term ) {
                if(in_array($term->term_id,$exclPseudoChildTermsIds) ){
	    	    
                //echo $term->slug.' Estaba en la lista<BR />';
                }
                else{
                  //  echo $term->slug.' No estaba en la lista <br />';
                    $taxo_tipoLente[] = $term->slug;
                }
	        }						
	        $Result_tipoLente = join("", $taxo_tipoLente);
        }
        else {
            $Result_tipoLente ="";
            //Metemos el id del input del tipo de lente.
            $UndefinedTaxonomyDataSelector[] = 'select[name="'.$tipoIolTaxName.'"]';
        }
       //echo 'Este es el resultado del tipo de letne|'.$Result_tipoLente.'|';
       $tiposLente = get_terms( $tipoIolTaxName, array('hide_empty' => 0,'exclude'=>$exclPseudoChildTermsIds,'orderby'=>'none' ) ); //,,array('hide_empty' => 0) 'exclude'=>$exclPseudoChildTermsIds
       //echo 'Mostramos la variable tiposLente|'.var_dump(wp_list_pluck($tiposLente,'slug')).'|';

     ?>

  <div class="ui-widget startsUgly">
  <label class="labelTitleFirst"><?php echo _x('Tipo de Lente Intraocular:','Right Single Lente Intraocular','iol_cpt_display');?></label>
  <select id="comboboxTipoLente" name="<?php echo _x('tipo-lente-intraocular','taxo-name','iol'); ?>">
  <?php
      //Extraemos el tipo que tiene la lente.
       $tiposLente = get_terms( $tipoIolTaxName, array('hide_empty' => 0,'exclude'=>$exclPseudoChildTermsIds ) ); //,,array('hide_empty' => 0) 'exclude'=>$exclPseudoChildTermsIds 
       if  ($tiposLente) {
            echo '<option value = "'.$tipoIolTaxName.'-se" id="diseOpticDefault">'._x('Sin Especificar','Filter_Template','iol_display').'</option>';         
           foreach ($tiposLente as $taxonomy ) {
              // echo $taxonomy.'   '.$Result_Tipo;
               if($taxonomy->slug == $Result_tipoLente)
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
  <!-- Fin del tipo de Lente Intraocular -->
     
     
     
  <!-- Combo con el Tipo de Lente -->
  <?php
     //Vamos a poner a sacar el tipo de lente que es (Recordemos que hemos establecido una clasificación jerárquica).
        
        $diseOpticTaxoName =_x('diseno-optica','taxo-name','iol');

        $tipo = get_the_terms( $post->ID, $diseOpticTaxoName ) ;
						
        if ( $tipo && ! is_wp_error( $tipo ) ){
            
        	$taxo_tipo = array();
    	    foreach ( $tipo as $term ) {
	    	    $taxo_tipo[] = $term->slug;
	        }						
	        $Result_Tipo = join("", $taxo_tipo);
        }else{
            //Metemos el id del input del diseño de óptica.
            $UndefinedTaxonomyDataSelector[] = 'select[name="'.$diseOpticTaxoName.'"]';
        }
       //echo $Result_Tipo;
     ?>

  <div class="ui-widget startsUgly">
  <label  class="labelTitle"><?php echo _x('Diseño de Óptica:','Right Single Lente Intraocular','iol_cpt_display');?></label>
  <select id="comboboxTipo" name="<?php echo _x('diseno-optica','taxo-name','iol'); ?>">
  <?php
      //Extraemos el tipo que tiene la lente.
       $tipos = get_terms( $diseOpticTaxoName ,array('hide_empty' => 0) ); 
       if  ($tipos) {
           echo '<option value = "'.$diseOpticTaxoName.'-se" id="diseOpticDefault">'._x('Sin Especificar','Right Single Lente Intraocular','iol_cpt_display').'</option>';
           foreach ($tipos as $taxonomy ) {
              // echo $taxonomy.'   '.$Result_Tipo;
               if($taxonomy->slug == $Result_Tipo)
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
  
  <!-- Toricidad de la Lente -->
  <?php   
      //Vamos a sacar la toricidad de lente.

        $toricityTaxoName = _x('toricidad', 'taxo-name','iol');

        $toricidad = get_the_terms( $post->ID, $toricityTaxoName  );
						
        if ( $toricidad && ! is_wp_error( $toricidad ) ){            
        	$taxo_toraci = array();
    	    foreach ( $toricidad as $term ) {
	    	    $taxo_toraci[] = $term->slug;
	        }						
	        $Result_toricidad = join("", $taxo_toraci);
        }
        else{
        	 //Metemos el id del input del diseño de óptica.
            $UndefinedTaxonomyDataSelector[] = 'input[name="'.$toricityTaxoName.'"]';
            $Result_toricidad = _x('toricidad','taxo-name','iol').'-se';//'';
                    }
     ?>
         
  <div class="ui-widget startsUgly">
  <label  class="labelTitle"><?php echo _x('Toricidad de la Lente:','Right Single Lente Intraocular','iol_cpt_display');?></label>
    <div id="toricidadFilter">
        <?php 
        $toricidades = get_terms($toricityTaxoName,array('hide_empty' => 0)); 
        if  ($toricidades) {
            foreach ($toricidades as $taxonomyTor ) {

                if($taxonomyTor->slug == _x('torica','taxo-value-slug','iol-scaffold'))
                {
                 if($taxonomyTor->slug == $Result_toricidad)
                    {
                     echo '<input type="radio" id="Toric" checked="checked" name ="'.$toricityTaxoName.'" value="'.$taxonomyTor->slug.'" /><label for="Toric">'._x('Tórica','taxo-value-name','iol-scaffold').'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="Toric" name ="'.$toricityTaxoName.'" value = "'.$taxonomyTor->slug.'" /><label for="Toric">'._x('Tórica','taxo-value-name','iol-scaffold').'</label>';  
                    }
                 }
                 if($taxonomyTor->slug != _x('torica','taxo-value-slug','iol-scaffold'))
                    {
                     if($taxonomyTor->slug == $Result_toricidad)
                       {
                         echo '<input type="radio" id="NoToric" checked="checked" name ="'.$toricityTaxoName.'" value="'.$taxonomyTor->slug.'" /><label for="NoToric">'._x('No Tórica','taxo-value-name','iol-scaffold').'</label>';
                       }
                      else{
                          
                         echo '<input type="radio" id="NoToric" name ="'.$toricityTaxoName.'" value="'.$taxonomyTor->slug.'"/><label for="NoToric">'._x('No Tórica','taxo-value-name','iol-scaffold').'</label>';
                       }
                    }
                }
              echo '<input type="radio" id="toricidadFilterDefault" name ="'.$toricityTaxoName.'" value="'.$toricityTaxoName.'-se" /><label for="toricidadFilterDefault">'._x('S/E','Filter_Template','iol_cpt_display').'</label>';  
        }

       ?>       
    </div>
  </div>




      <!-- Button Group con los filtros -->

     <?php   
      //Vamos a poner a mostrar en grupo de botones los filtros que lleva la lente.

        $filtersTaxoName = _x('filtros','taxo-name','iol');

        $filtros = get_the_terms( $post->ID, $filtersTaxoName );
						
        if ( $filtros && ! is_wp_error( $filtros ) ){            
        	$taxo_filtro = array();
    	    foreach ( $filtros as $term ) {
	    	    $taxo_filtro[] = $term->slug;
	        }						
	        $Result_filtros = join("", $taxo_filtro);
        }
        else{
            $UndefinedTaxonomyDataSelector[] = '#filtrosFilter input';
            $Result_filtros = '';
        }
     ?>
  <div class="ui-widget startsUgly">
  <label  class="labelTitle"><?php echo _x('Filtros de la Lente:','Right Single Lente Intraocular','iol_cpt_display'); ?></label>
    <div id="filtrosFilter">
        <?php 

        $luzUltraTaxoSlug = _x("luz-ultravioleta","taxo-value-slug","iol-scaffold");
        $luzAzulTaxoSlug = _x('luz-azul','taxo-value-slug','iol-scaffold');

        $filtros = get_terms($filtersTaxoName, array('hide_empty' => 0)); 
        if  ($filtros) {
            foreach ($filtros as $taxonomyFiltr ) {
                if($taxonomyFiltr->slug == $luzUltraTaxoSlug){
                       if($taxonomyFiltr->slug == $Result_filtros)
                           {
                             echo '<input type="checkbox" id="UV" checked="checked"  name="'.$luzUltraTaxoSlug.'" value='.$taxonomyFiltr->slug.' /><label for="UV">'._x('UV','taxo-filtros-value','iol').'</label>';
                           }
                       else{
                             echo '<input type="checkbox" id="UV" name="'.$luzUltraTaxoSlug.'" value='.$taxonomyFiltr->slug.' /><label for="UV">'._x('UV','taxo-filtros-value','iol').'</label>';      
                           }
                       }
                 if($taxonomyFiltr->slug == $luzAzulTaxoSlug){
                       if($taxonomyFiltr->slug == $Result_filtros)
                           {
                             echo '<input type="checkbox" id="LuzAzul" checked="checked"  name="'.$luzAzulTaxoSlug.'" value='.$taxonomyFiltr->slug.' /><label for="LuzAzul">'._x('Luz Azul','taxo-value-name','iol-scaffold').'</label>'; //taxo-filtros-value
                           }
                       else{
                             echo '<input type="checkbox" id="LuzAzul"  name="'.$luzAzulTaxoSlug.'" value='.$taxonomyFiltr->slug.' /><label for="LuzAzul">'._x('Luz Azul','taxo-value-name','iol-scaffold').'</label>';
                           }
                       }
                   }
              //Si éste está seleccionado, no habrá filtro => le ponemos valor S/E, para identificar los valores y no mandarlos.
              echo '<input type="checkbox" id="filtrosFilterDefault" name="'.$filtersTaxoName.'-se" value ="'.$filtersTaxoName.'-se" /><label for="filtrosFilterDefault">'._x('S/E','Filter_Template','iol_display').'</label>';  
            }
            
       ?>       
    </div>
  </div>


  <!-- Slider con el Rango de Adiciones -->
  <?php 
  //Tenemos que extraer el valor de la adición de cerca. 
        
      $addCercaTaxoName = _x('adicion-cerca','taxo-name','iol');


        $add = get_the_terms( $post->ID, $addCercaTaxoName );
					
        if ( $add && ! is_wp_error( $add ) ){
        	$taxo_add = array();
    	    foreach ( $add as $term ) {
	    	    $taxo_add[] = $term->slug;
	        }						
	        $Result_Add = join("", $taxo_add);
            }
            else{
   	            $UndefinedMetaDataSelector[] = '#amount-add';
                $Result_Add = '0';
            }
            //Calculamos ahora los valores a mostrar por el slider asociado.
            if( $Result_Add == '0')
            {
                $minf_add = 0;
                $msup_add = 5;
            }
             else{
                 $msup_add = strval(floatval($Result_Add) );//0.25
                 $minf_add = strval(floatval($Result_Add) );//- 0.25
             }
  ?>
  
     <?php 
      //Almacenamos los valores del slider en sendas variables javascript.
        echo '<script>';
            echo 'var rangeAddMinfAdd ='.$minf_add.';'; 
            echo 'var rangeAddMsupAdd ='.$msup_add.';'; 
        echo '</script>';
        ?>

  <div class="ui-widget startsUgly">
  <label for="amount"  class="labelTitle"><?php echo _x('Multifocalidad - Presbicia:','Right Single Lente Intraocular','iol_cpt_display'); ?></label>
  <button id="addDisabler">adicion Disabler</button>
  <input type="text" id="amount-add" style="border: 0; " name="adicion-cercaTV" />
  <div id="slider-range-add"></div>

  </div>

  <!-- Combo con el fabricante -->
   <!-- Combo con el Fabricante -->
    <?php
     //Vamos a poner a sacar el fabricante de lente que es (Recordemos que hemos establecido una clasificación jerárquica).
        
       $fabLenteTaxoName = _x('fabricante-lente','taxo-name','iol');

        $fabricante = get_the_terms( $post->ID, $fabLenteTaxoName );
						
        if ( $fabricante && ! is_wp_error( $fabricante ) ){
            
        	$taxo_fabri = array();
    	    foreach ( $fabricante as $term ) {
	    	    $taxo_fabri[] = $term->slug;
	        }						
	        $Result_Fabricante = join("", $taxo_fabri);
        }
        else{
        	$NotEsficied='El fabricante';
            $UndefinedTaxonomyDataSelector[] = 'select[name="'.$fabLenteTaxoName.'"]';
            $Result_Fabricante = '';
        }
     ?>    


  <div class="ui-widget startsUgly">
  <label  class="labelTitle"><?php echo _x('Fabricante:','Right Single Lente Intraocular','iol_cpt_display'); ?></label>
  <select id="comboboxFabricante" name="<?php echo _x('fabricante-lente','taxo-name','iol'); ?>">
  <?php
       //Notamos que $Result_Fabricante ya viene obtenido del Left Panel.
       $fabricantes = get_terms($fabLenteTaxoName); 
       if  ($fabricantes) {
             echo '<option value = "'.$fabLenteTaxoName.'-se">'._x('Sin Especificar','Right Single Lente Intraocular','iol_cpt_display').'</option>';
              foreach ($fabricantes  as $fabricante ) 
              {   
                if ($fabricante->slug == $Result_Fabricante)
                  {
                   echo '<option value = "' . $fabricante->slug . '" selected="selected">' . $fabricante->name . '</option>';
                  }
                    else{
                         echo '<option value = "' . $fabricante->slug . '">' . $fabricante->name . '</option>';
                         }
              }
       }  
  ?>
   </select>
   </div>    
  
     </div>
      </div>
  <!-- Fin del Filtro de usuarios normales-->

  <!-- PROCEDEMOS AHORA CON FILTRO AVANZADO -->

  <div id="advancedAccordionFilter">
        <h3><span class="title-filter"><?php echo _x('Bordes, Material, Hápticos...','Right Archive Lente Intraocular','iol_cpt_display');?></span></h3>
        <div>
           <!-- Magnitudes del filtro avanzado -->
           <div class="spanH4Wrapper startsUgly">
            <span id="spanAdvFilDisabler" class="startsUgly"><?php echo _x('No aplicar estos filtros:','Right Archive Lente Intraocular','iol_cpt_display'); ?> </span> <button id="advancedFiltersDisabler"> Advanced Filters Disabler </button>
            <span style=" clear: both; height: 4px;"  class="startsUgly"></span> 
            <span id="spanAdvFilEnabler"  class="startsUgly"><?php echo _x('Aplicar estos filtros:','Right Archive Lente Intraocular','iol_cpt_display'); ?></span> <button id="advancedFiltersEnabler">Advanced Filters Enabler</button> 
            <span style=" clear: both;"  class="startsUgly"></span>
            <div style="clear: both;height: 0px;">&nbsp;</div>
          </div>
                   

            <!-- 3 Bordes Cuadrados -->
            <?php
            
            $bcuadTaxoName = _x('bordes-cuadrados','taxo-name','iol');     
            $bcuadTaxoSlug = _x('bordes-cuadrados','taxo-slug','iol');

            $bCuadrados = get_the_terms( $post->ID, $bcuadTaxoName );
						
                if ( $bCuadrados && ! is_wp_error( $bCuadrados ) ){            
            	     $taxo_cuad = array();
    	             foreach ( $bCuadrados as $term ) {
	    	                   $taxo_cuad[] = $term->slug;
	                 }						
	                 $Result_bcuad = join("", $taxo_cuad);
                }
                else{
                    $UndefinedTaxonomyDataSelector[] = 'input[name="'.$bcuadTaxoName.'"]';
                    $Result_bcuad ='';
                }
            ?>
  <div class="ui-widget startsUgly">
  <label title="" class="labelTitleFirst" ><?php echo _x('Bordes Cuadrados:','Right Single Lente Intraocular','iol_cpt_display'); ?></label>
    <div id="bordeCuadFilter">
        <?php 
        $bCuadrados = get_terms($bcuadTaxoName, array('hide_empty' => 0));


        if  ($bCuadrados) {
            foreach ($bCuadrados as $taxonomyTBCuad ) {

                if($taxonomyTBCuad->slug == _x('si','taxo-value-slug','iol-scaffold'))
                {
                    
                 if($taxonomyTBCuad->slug == $Result_bcuad)
                    {
                     echo '<input type="radio" id="BCuadSi" name="'.$bcuadTaxoSlug.'" checked="checked" value="'.$taxonomyTBCuad->slug.'" /><label for="BCuadSi">'._x('Sí','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="BCuadSi" name="'.$bcuadTaxoSlug.'" value="'.$taxonomyTBCuad->slug.'"/><label for="BCuadSi">'._x('Sí','Right Single Lente Intraocular','iol_cpt_display').'</label>';  
                    }
                 }
                 if($taxonomyTBCuad->slug != _x('si','taxo-value-slug','iol-scaffold'))
                    {
                     if($taxonomyTBCuad->slug == $Result_bcuad)
                       {
                         echo '<input type="radio" id="BCuadNo" checked="checked" name="'.$bcuadTaxoSlug.'" value="'.$taxonomyTBCuad->slug.'" /><label for="BCuadNo">'._x('No','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                       }
                      else{
                         echo '<input type="radio" id="BCuadNo" name="'.$bcuadTaxoSlug.'" value="'.$taxonomyTBCuad->slug.'" /><label for="BCuadNo">'._x('No','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                       }
                    }
                }
                 echo '<input type="radio" id="BCuadSE" name="'.$bcuadTaxoSlug.'" value="'.$bcuadTaxoSlug.'-se" /><label for="BCuadSE">'._x('S/E','Right Single Lente Intraocular','iol_cpt_display').'</label>';  
        } 
       ?>       
    </div>
  </div>

            <!-- Fin 3 Bordes Cuadrados -->

            <!-- 5 Principio Óptico-->
           <?php
                            
            $ppOpticoTaxoName = _x('principio-optico','taxo-name','iol');            

            $ppOptico = get_the_terms( $post->ID, $ppOpticoTaxoName );
						
                if ( $ppOptico && ! is_wp_error( $ppOptico ) ){            
            	     $taxo_ppo = array();
    	             foreach ( $ppOptico as $term ) {
	    	                   $taxo_ppo[] = $term->slug;
	                 }						
	                 $Result_ppo = join("", $taxo_ppo);
                }
                else {
                    $UndefinedTaxonomyDataSelector[] = '#ppOpticoFilter input';
                    $Result_ppo='';
                }
            ?>
  <div class="ui-widget startsUgly">
  <label  class="labelTitle"><?php echo _x('Principio Óptico:','Right Single Lente Intraocular','iol_cpt_display'); ?></label>
    <div id="ppOpticoFilter">
        <?php 
        $ppOpticos = get_terms($ppOpticoTaxoName);

        $refrTaxoValueName  = _x('refractiva','taxo-value-name','iol-scaffold');
        $refrTaxoValueSlug = _x('refractiva','taxo-value-slug','iol-scaffold');

        $difrTaxoValueSlug = _x('difractiva','taxo-value-slug','iol-scaffold');

        $mixtaTaxoValueSlug = _x('mixta','taxo-value-slug','iol-scaffold');

        if  ($ppOpticos) {
            foreach ($ppOpticos as $taxonomypOpt ) {

                if($taxonomypOpt->slug == $refrTaxoValueSlug)
                {
                    
                 if($taxonomypOpt->slug == $Result_ppo)
                    {
                     echo '<input type="checkbox" id="pRefractiva" checked="checked" name="'.$refrTaxoValueSlug.'" value="'.$taxonomypOpt->slug.'" /><label for="pRefractiva">'._x('Refr.','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="pRefractiva" name="'.$refrTaxoValueSlug.'" value="'.$taxonomypOpt->slug.'" /><label for="pRefractiva">'._x('Refr.','Right Single Lente Intraocular','iol_cpt_display').'</label>';  
                    }
                 }
                 if($taxonomypOpt->slug == $difrTaxoValueSlug)
                    {
                     if($taxonomypOpt->slug == $Result_ppo)
                       {
                         echo '<input type="checkbox" id="pDifractiva" checked="checked" name="'.$difrTaxoValueSlug.'" value="'.$taxonomypOpt->slug.'" /><label for="pDifractiva">'._x('Difr.','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                       }
                      else{
                         echo '<input type="checkbox" id="pDifractiva" name="'.$difrTaxoValueSlug.'" value="'.$taxonomypOpt->slug.'" /><label for="pDifractiva">'._x('Difr.','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                       }
                    }
                 if($taxonomypOpt->slug == $mixtaTaxoValueSlug )
                    {
                     if($taxonomypOpt->slug == $Result_ppo)
                       {
                         echo '<input type="checkbox" id="pMixta" checked="checked" name="'.$mixtaTaxoValueSlug.'" value="'.$taxonomypOpt->slug.'" /><label for="pMixta">'._x('Mixta','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                       }
                      else{
                         echo '<input type="checkbox" id="pMixta" name="'.$mixtaTaxoValueSlug.'" value="'.$taxonomypOpt->slug.'" /><label for="pMixta">'._x('Mixta','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                       }
                    }
                }
                echo '<input type="checkbox" id="ppOpticoFilterDefault" name="'.$ppOpticoTaxoName.'-se" value = "'.$ppOpticoTaxoName.'-se"  /><label for="ppOpticoFilterDefault">'._x('S/E','Right Single Lente Intraocular','iol_cpt_display').'</label>';  
        } 
       ?>       
    </div>
  </div>

            <!-- Fin Principio Óptico-->

            <!-- Combo del Diseño de Lente-->
                <?php
     //Vamos a poner a sacar el tipo de lente que es (Recordemos que hemos establecido una clasificación jerárquica).

       $diseLenTaxoName = _x('diseno','taxo-name','iol');
       

        $diseLent = get_the_terms( $post->ID, $diseLenTaxoName );
						
        if ( $diseLent && ! is_wp_error( $diseLent ) ){
            
        	$taxo_dise = array();
    	    foreach ( $diseLent as $term ) {
	    	    $taxo_dise[] = $term->slug;
	        }						
	        $Result_DiseLente = join("", $taxo_dise);
        }
        else{
             $UndefinedTaxonomyDataSelector[] = 'select[name="'._x('diseno-lente','taxo-input-name','iol').'"]';
             $Result_DiseLente = '';
        }
     ?>    

            <div class="ui-widget startsUgly" id="comboDiseLente">
            <label  class="labelTitle"><?php echo _x('Diseño de Lente:','Right Single Lente Intraocular','iol_cpt_display'); ?></label>
            <select id="comboboxDiseLente" name="<?php echo _x('diseno-lente','taxo-input-name','iol'); ?>">
    <?php
            //Notamos que $Result_fabricanteURL ya viene obtenido del Left Panel.

           
            $diseLentes = get_terms($diseLenTaxoName); 


            if  ($diseLentes) {
                echo '<option value = "'.$diseLenTaxoName.'-se">'._x('Sin Especificar','Right Single Lente Intraocular','iol_cpt_display').'</option>';
                  foreach ($diseLentes  as $diseLente ) 
                {   
                     if ($diseLente->slug == $Result_DiseLente)
                        {
                        echo '<option value = "' . $diseLente->slug . '" selected="selected">' . $diseLente->name . '</option>';
                         }
                        else{
                             echo '<option value = "' . $diseLente->slug . '">' . $diseLente->name . '</option>';
                            }
                 }
            }
            else{
                 echo '<option value = "'.$diseLenTaxoName.'-se" selected ="selected">'._x('Sin Especificar','Right Single Lente Intraocular','iol_cpt_display').'</option>';
                }    
  ?>
   </select>
   </div>    
            <!-- Fin de Diseño de Lente-->

            <!-- Combo del Material de la Lente-->
                <?php
     //Vamos a poner a sacar el material de la lente intraocular (Recordemos que hemos establecido una clasificación jerárquica).

        $matTaxoName = _x('material','taxo-name','iol');

        $matLent = get_the_terms( $post->ID, $matTaxoName );
						
        if ( $matLent && ! is_wp_error( $matLent ) ){
            
        	$taxo_mat = array();
    	    foreach ( $matLent as $term ) {
	    	    $taxo_mat[] = $term->slug;
	        }						
	        $Result_MatLent = join("", $taxo_mat);
        }
        else{
            $UndefinedTaxonomyDataSelector[] = 'select[name="'.$matTaxoName.'"]';
            $Result_MatLent = '';
        }
     ?>    

            <div class="ui-widget startsUgly" id="comboMatLente">
            <label  class="labelTitle"><?php echo _x('Material de Lente:','Right Single Lente Intraocular','iol_cpt_display'); ?></label>
            <select id="comboboxMatLente" name="<?php echo _x('material','taxo-name','iol');?>">
    <?php
            //Notamos que $Result_fabricanteURL ya viene obtenido del Left Panel.
            $matLentes = get_terms($matTaxoName); 
            if  ($matLentes) {
                  echo '<option value = "'.$matTaxoName.'-se">'._x('Sin Especificar','Right Single Lente Intraocular','iol_cpt_display').'</option>';
                  foreach ($matLentes  as $matLente ) 
                {   
                     if ($matLente->slug == $Result_MatLent)
                        {
                        echo '<option value = "' . $matLente->slug . '" selected="selected">' . $matLente->name . '</option>';
                         }
                        else{
                             echo '<option value = "' . $matLente->slug . '">' . $matLente->name . '</option>';
                            }
                 }
            } 
            else{
              //   echo '<option value = "S/E" selected ="selected">'._x('Sin Especificar','Filter_Template','iol_display').'</option>';
            }   
  ?>
   </select>
   </div>   
            <!-- Fin de Material de Lente-->

            <!-- Inyector -->
            <?php
                
            $injectTaxoName = _x('inyector','taxo-name','iol');

            $inyector = get_the_terms( $post->ID, $injectTaxoName );
						
                if ( $inyector && ! is_wp_error( $inyector ) ){            
            	     $taxo_inyect = array();
    	             foreach ( $inyector as $term ) {
	    	                   $taxo_inyect[] = $term->slug;
	                 }						
	                 $Result_inyect = join("", $taxo_inyect);
                }
                else{
                    $UndefinedTaxonomyDataSelector[] = 'input[name="'.$injectTaxoName.'"]';
                    $Result_inyect = '';
                }
            ?>
  <div class="ui-widget startsUgly">
  <label  class="labelTitle"><?php echo _x('Inyector:','Right Single Lente Intraocular','iol_cpt_display'); ?></label>
    <div id="inyectorFilter">
        <?php 
        $inyectLente = get_terms($injectTaxoName, array('hide_empty' => 0));

        if  ($inyectLente) {
            foreach ($inyectLente as $taxonomyInyectLente ) {

                if($taxonomyInyectLente->slug == _x('con','taxo-value-slug','iol-scaffold'))
                {
                    
                 if($taxonomyInyectLente->slug == $Result_inyect)
                    {
                     echo '<input type="radio" id="inyectorCon" checked="checked" name="'.$injectTaxoName.'" value="'.$taxonomyInyectLente->slug.'" /><label for="inyectorCon">'._x('Con','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="inyectorCon" name="'.$injectTaxoName.'" value="'.$taxonomyInyectLente->slug.'" /><label for="inyectorCon">'._x('Con','Right Single Lente Intraocular','iol_cpt_display').'</label>';  
                    }
                 }
                 if($taxonomyInyectLente->slug != _x('con','taxo-value-slug','iol-scaffold'))
                    {
                     if($taxonomyInyectLente->slug == $Result_inyect)
                       {
                         echo '<input type="radio" id="inyectorSin" checked="checked" name="'.$injectTaxoName.'" value="'.$taxonomyInyectLente->slug.'" /><label for="inyectorSin">'._x('Sin','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                       }
                      else{
                         echo '<input type="radio" id="inyectorSin" name="'.$injectTaxoName.'" value="'.$taxonomyInyectLente->slug.'" /><label for="inyectorSin">'._x('Sin','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                       }
                    }
                }
                echo '<input type="radio" id="inyectSE" name="'.$injectTaxoName.'" value="'.$injectTaxoName.'-se" /><label for="inyectSE">'._x('S/E','Right Single Lente Intraocular','iol_cpt_display').'</label>';  
        } 
       ?>       
    </div>
  </div>

            <!-- Fin Inyector -->

            <!-- Precargada -->

            <?php
            
            $preLoadTaxoName = _x('precargada','taxo-name','iol');

            $precarga = get_the_terms( $post->ID, $preLoadTaxoName );
						
                if ( $precarga && ! is_wp_error( $precarga ) ){            
            	     $taxo_precar = array();
    	             foreach ( $precarga as $term ) {
	    	                   $taxo_precar[] = $term->slug;
	                 }						
	                 $Result_precarg = join("", $taxo_precar);
                }
                else{
                    $UndefinedTaxonomyDataSelector[] = 'input[name="'.$preLoadTaxoName.'"]';
                    $Result_precarg = '';
 
                }
            ?>
  <div class="ui-widget startsUgly">
  <label  class="labelTitle"><?php echo _x('Precargada','Right Archive Lente Intraocular','iol_cpt_display'); ?>:</label>
    <div id="precargadaFilter">
        <?php 
        $precargLente = get_terms($preLoadTaxoName);

        if  ($precargLente) {
            foreach ($precargLente as $taxonomyprecargLente ) {

                if($taxonomyprecargLente->slug == _x('si','taxo-value-slug','iol-scaffold'))
                {
                    
                 if($taxonomyprecargLente->slug == $Result_precarg)
                    {
                     echo '<input type="radio" id="precargaSi" checked="checked" name="'.$preLoadTaxoName.'" value="'.$taxonomyprecargLente->slug.'" /><label for="precargaSi">'._x('Sí','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="precargaSi" name="'.$preLoadTaxoName.'" value="'.$taxonomyprecargLente->slug.'" /><label for="precargaSi">'._x('Sí','Right Single Lente Intraocular','iol_cpt_display').'</label>';  
                    }
                 }
                 if($taxonomyprecargLente->slug != _x('si','taxo-value-slug','iol-scaffold'))
                    {
                     if($taxonomyprecargLente->slug == $Result_precarg)
                       {
                         echo '<input type="radio" id="precargaNo" checked="checked" name="'.$preLoadTaxoName.'" value="'.$taxonomyprecargLente->slug.'" /><label for="precargaNo">'._x('No','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                       }
                      else{
                         echo '<input type="radio" id="precargaNo" name="'.$preLoadTaxoName.'" value="'.$taxonomyprecargLente->slug.'" /><label for="precargaNo">'._x('No','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                       }
                    }
                }
                echo '<input type="radio" id="precargaSE" name="precarga" value="precargada-se" /><label for="precargaSE">'._x('S/E','Right Single Lente Intraocular','iol_cpt_display').'</label>';  
        } 
       ?>       
    </div>
  </div>
            <!-- Fin Inyector -->


            <!-- Inicio Combo diseño de Hápticos-->
                    
                <?php
     //Vamos a poner a sacar el material de la lente intraocular (Recordemos que hemos establecido una clasificación jerárquica).

        $diseHapticTaxoName = _x('diseno-hapticos','taxo-name','iol');   

        $diseHaptic = get_the_terms( $post->ID, $diseHapticTaxoName );
						
        if ( $diseHaptic && ! is_wp_error( $diseHaptic ) ){
            
        	$taxo_dhaptic = array();
    	    foreach ( $diseHaptic as $term ) {
	    	    $taxo_dhaptic[] = $term->slug;
	        }						
	        $Result_DiseHaptic = join("", $taxo_dhaptic);
        }
        else{
            $UndefinedTaxonomyDataSelector[] = 'input[name="'.$diseHapticTaxoName.'"]';
            $Result_DiseHaptic = '';
        }
     ?>    

            <div class="ui-widget startsUgly" id="comboDiseHapticos">
            <label  class="labelTitle"><?php echo _x('Diseño Hápticos:','Right Archive Lente Intraocular','iol_cpt_display'); ?></label>
            <select id="comboboxDiseHaptic" name="<?php echo _x('diseno-hapticos','taxo-name','iol'); ?>">
    <?php
            //Notamos que $Result_fabricanteURL ya viene obtenido del Left Panel.
            $diseHaptics = get_terms($diseHapticTaxoName); 
            if  ($diseHaptics) {
                echo '<option value = "'.$diseHapticTaxoName.'-se">'._x('Sin Especificar','Right Single Lente Intraocular','iol_cpt_display').'</option>';
                  foreach ($diseHaptics  as $disHaptic ) 
                {   
                     if ($disHaptic->slug == $Result_DiseHaptic)
                        {
                        echo '<option value = "' . $disHaptic->slug . '" selected="selected">' . $disHaptic->name . '</option>';
                         }
                        else{
                             echo '<option value = "' . $disHaptic->slug . '">' . $disHaptic->name . '</option>';
                            }
                 }
            }
             else   {
                 echo '<option value = "'.$diseHapticTaxoName.'-se" selected="selected">'._x('Sin Especificar','Right Single Lente Intraocular','iol_cpt_display').'</option>';
             }
  ?>
   </select>
   </div>    
            <!-- Fin Combo diseño de Hápticos-->
                   

            <!-- Fin valores máximos mínimos de esfera-->


              
            <!-- Fin valores máximos mínimos de esfera-->

            </div>
  </div>
  
    <!-- Inicio del Filtro de cirujanos-->
 <div id="surgeonAccordionFilter">
     <h3> <span class="title-filter"><?php echo _x('Asfericid., Diámetros...','Right Archive Lente Intraocular','iol_cpt_display'); ?> </span></h3>
     <div>
            <div class="spanH4Wrapper startsUgly">
            <span id="spanSurgeonFilDisabler" class="startsUgly"><?php echo _x('No aplicar estos filtros:','Right Archive Lente Intraocular','iol_cpt_display'); ?> </span> <button id="surgeonFiltersDisabler"> Surgeon Filters Disabler </button>
            <span style=" clear: both; height: 4px;"  class="startsUgly"></span> 
            <span id="spanSurgeonFilEnabler"  class="startsUgly"><?php echo _x('Aplicar estos filtros:','Right Archive Lente Intraocular','iol_cpt_display'); ?></span> <button id="surgeonFiltersEnabler">Surgeon Filters Enabler</button> 
            <span style=" clear: both;"  class="startsUgly"></span>
            
            <h4><?php echo _x('Rangos Dióptricos','Right Archive Lente Intraocular','iol_cpt_display'); ?></h4>
          </div>

            <!-- 4 Asfericidad -Slider -->
                   <?php 
              $asferic = get_post_meta($post->ID, 'asfericiD',TRUE);

              if($asferic == '' or $asferic == '//')
                 {
                     $minf_asf = 0;
                     $msup_asf = 1;            
                     $UndefinedMetaDataSelector[] = '#amount-asferic';
                 }
                 else{
                     $minf_asf = $asferic - 0.25;//0.01
                     $msup_asf = $asferic + 0.25;                     
                 }
            ?>
       
            <?php 
            //Almacenamos los valores del slider de asfericidad en sendas variables javascript.
             echo '<script>';
                    echo 'var rangeMinfAsf ='.$minf_asf.';'; 
                    echo 'var rangeMsupAsf ='.$msup_asf.';'; 
             echo '</script>';
             ?>


            <div class="ui-widget startsUgly slideWButton">
            <label for="amount-asferic"><?php echo _x('Asfericidad:','Right Single Lente Intraocular','iol_cpt_display'); ?></label>
            <button id="asfericityDisabler">TotalDiameter Disabler</button>
            
            <input type="text" id="amount-asferic" style="border: 0; " name="asfericiD" />
            <div id="slider-range-asferic"></div>
            </div>
              

            <!-- Fin 4 Asfericidad -->

     
                <!-- 1 Diámetro de Óptica-->
            <?php 
              $diamOptic = get_post_meta($post->ID, 'diamOpticD',TRUE);

              if($diamOptic == '' or $diamOptic== '//')
                 {
                     $minf_doptic = 2.5;
                     $msup_doptic = 10;
                     $UndefinedMetaDataSelector[] = '#amount-diamOptic';
                 }
                 else{
                     $minf_doptic = $diamOptic - 2.5;//0.1
                     $msup_doptic = $diamOptic + 2.5;                     
                 }
            ?>
            
            <?php 
            //Almacenamos los valores del diametro de óptica en sendas variables javascript.
             echo '<script>';
                    echo 'var rangeMinfDoptic ='.$minf_doptic.';'; 
                    echo 'var rangeMsupDoptic ='.$msup_doptic.';'; 
             echo '</script>';
             ?>  
            

            <div class="ui-widget startsUgly slideWButton">
            
            <label for="amount-diamOptic"><?php echo _x('Diámetro de Óptica','Right Single Lente Intraocular','iol_cpt_display'); ?>:</label>
            <button id="opticDiameterDisabler">OpticDiameter Disabler</button>

            <input type="text" id="amount-diamOptic" style="border: 0; " name="diamOpticD" />
            <div id="slider-range-diamOptic"></div>
    
            </div>
                                      
            <!-- Fin 1 Diámetro de Óptica-->
     
       <!-- 2 Diámetro Total-->
            <?php 
              $diamTot = get_post_meta($post->ID, 'diamTotD',TRUE);

              if($diamTot == '' or $diamTot== '//')
                 {
                     $minf_dtot = 7;
                     $msup_dtot = 15;
                     $UndefinedMetaDataSelector[] = '#amount-diamTot';
                 }
                 else{
                     $minf_dtot = $diamTot - 2.5;//0.1
                     $msup_dtot = $diamTot + 2.5;                     
                 }
            ?>
          
              <?php 
            //Almacenamos los valores del diametro total en sendas variables javascript.
             echo '<script>';
                    echo 'var rangeMinfDtot ='.$minf_dtot.';'; 
                    echo 'var rangeMsupDtot ='.$msup_dtot.';'; 
             echo '</script>';
             ?>  


            <div class="ui-widget startsUgly slideWButton">
            <label for="amount-diamTot"><?php echo _x('Diámetro Total:','Right Single Lente Intraocular','iol_cpt_display'); ?><br /></label>
            <button id="totalDiameterDisabler">TotalDiameter Disabler</button>
            
            <input type="text" id="amount-diamTot" style="border: 0; " name="diamTotD" />
            <div id="slider-range-diamTot"></div>
            </div>

            <!-- Fin 2 Diámetro Total-->
     
     
     <!-- Ini Esfera -->
            
            
            <!-- Valores Máximos-Mínimos de Esfera -->
              <?php 
              $esfDesde = get_post_meta($post->ID, 'esfDesdeD',TRUE);
              $esfHasta = get_post_meta($post->ID, 'esfHastaD',TRUE);//esfDesdeD
              //Esfera Desde.
              if($esfDesde == '' or $esfDesde == '//')
                 {
                     $esf_desde = 0;
                     $UndefinedMetaDataSelector[] = '#amount-esfera';
                 }
                 else{
                     $esf_desde = $esfDesde;// - 2.5; //0.25                    
                 }
              //Esfera Hasta.
              if($esfHasta == '' or $esfHasta == '//')
                 {
                     $esf_hasta = 0;
                 }
                 else{
                     $esf_hasta = $esfHasta;// + 2.5;//0.25                    
                 }


            ?>

            <?php 
            //Almacenamos los valores del diametro de óptica en sendas variables javascript.
             echo '<script>';
                    echo 'var rangeMinfEsf ='.$esf_desde.';'; 
                    echo 'var rangeMsupEsf ='.$esf_hasta.';'; 
             echo '</script>';
             ?>  

            <div class="ui-widget startsUgly slideWButton">
            <label for="amount-esfera"  class="labelTitle"><?php echo _x('Rango Dioptrías Esfera:','Right Single Lente Intraocular','iol_cpt_display'); ?></label>
            <button id="dioptEsfDisabler">dioptEsf Disabler</button>
            
            <input type="text" id="amount-esfera" style="border: 0; " name="dioptEsfD" />
            <div id="slider-range-esfera"></div>
            </div>
                           

     <!-- Fin Esfera -->
     
     <!-- Ini Cilindro -->
              <?php 
              $cilDesde = get_post_meta($post->ID, 'cilDesdeD',TRUE);
              $cilHasta = get_post_meta($post->ID, 'cilHastaD',TRUE);//esfDesdeD
              
              //Esfera Desde.
              if($cilDesde == '' or $cilDesde == '//')
                 {
                     $cil_desde = 0;
                     $UndefinedMetaDataSelector[] = '#amount-cilinder';                     
                 }
                 else{
                     $cil_desde = $cilDesde; //0.25                   
                 }
              //Esfera Hasta.
              if($cilHasta == '' or $cilDesde == '//')
                 {
                     $cil_hasta = 0;
                     $UndefinedDataSelector[] = '#slider-range-cilinder';
                 }
                 else{
                     $cil_hasta = $cilHasta;//0.25             
                 }
            ?>

            <?php 
            //Almacenamos los valores del diametro de óptica en sendas variables javascript.
             echo '<script>';
                    echo 'var rangeMinfCil ='.$cil_desde.';'; 
                    echo 'var rangeMsupCil ='.$cil_hasta.';'; 
             echo '</script>';
             ?> 

            <div class="ui-widget startsUgly slideWButton">
            <label for="amount-cilinder"  class="labelTitle"><?php echo _x('Rango Dioptrías Cilndro:','Right Single Lente Intraocular','iol_cpt_display'); ?></label>
            <button id="dioptCilDisabler">dioptCil Disabler</button>
            

            <input type="text" id="amount-cilinder" style="border: 0; " name="dioptCilD" />
            <div id="slider-range-cilinder"></div>
            </div>
         <!-- Fin Cilindro -->

         <!-- Ini tamaño de Incisión -->
            <?php 
              $tamInci = get_post_meta($post->ID, 'tamaInciD',TRUE);

              if($tamInci == '' or $taminci = '//')
                 {
                     $minf_tamInci = 1.6;
                     $msup_tamInci = 5;
                     $UndefinedMetaDataSelector[] = '#amount-tamaInci';
                 }
                 else{
                     $minf_tamInci = $tamInci; // - 2.5;//0.1
                     $msup_tamInci = $tamInci;// + 2.5;                     
                 }
            ?>
          
              <?php 
            //Almacenamos los valores del diametro total en sendas variables javascript.
             echo '<script>';
                    echo 'var rangeMinfTInci ='.$minf_tamInci.';'; 
                    echo 'var rangeMsupTInci ='.$msup_tamInci.';'; 
             echo '</script>';
             ?>  


            <div class="ui-widget startsUgly slideWButton">
            <label for="amount-tamaInci"><?php echo _x('Tamaño de Incisión:','Right Single Lente Intraocular','iol_cpt_display'); ?><br /></label>
            <button id="tamaInciDisabler">Tamano Incision Disabler</button>
            
            <input type="text" id="amount-tamaInci" style="border: 0; " name="tamaInciD" />
            <div id="slider-range-tamaInci"></div>
            </div>
         <!-- Fin Tamaño de Incisión -->




     
     
     </div>
 </div>

 	
   </form>
   
