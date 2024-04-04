
<div id="right" class="filter-right clinica">


<?php      $clinica = get_queried_object();

             $clinica_thumbnail_id = get_post_thumbnail_id( $clinica->ID );

        $argsGallery = array(
                        'numberposts' => 6, // Using -1 loads all posts
                        'orderby' => 'menu_order', // This ensures images are in the order set in the page media manager
                        'order'=> 'ASC',
                        'post_mime_type' => 'image', // Make sure it doesn't pull other resources, like videos
                        'post_parent' => $clinica->ID, // Important part - ensures the associated images are loaded
                        'post_status' => null,
                        'post__not_in' => array($clinica_thumbnail_id),
                        'post_type' => 'attachment'
        );
        
 
        $imagesGallery = get_posts( $argsGallery );

?>

<?php if(!$imagesGallery){ //get_locale()!= 'es_ES', no tiene mucho sentido que desde una clínica puedan ir a las otras... disuade a las clínicas de estar   ?>

  <h3><?php _x('BUSCAR CLÍNICAS:','Right Single Clinica','clinica_cpt_display');?></h3> 
              
  <form id="clinica_filter_form" method="get" action="<?php echo get_post_type_archive_link(_x('clinica','CustomPostType Name','clinica')); ?>">

<input type="button" class="singleClinicSubmit" value="<?php echo _x('Realizar Filtrado','Right Archive Clinica','clinica_cpt_display');?>" onClick="singleClinic_submit_me();" />  

   <!-- En el siguiente accordion: Ubicación y datos adicionales de la clínica -->
    <div id="accordionFilterSecond">
     <h3> <span class="title-filter"><?php echo _x('Ubicación/Características','Right Single Clinica','clinica_cpt_display'); ?> </span></h3>
     <div>
     
     <!-- Ini Faco: Empezamos por el faco -->
     
    <?php
        //Vamos a sacar el número de cirugías de la clínica.
        
        $femtoFacoTN = _x("femto-faco","taxo-name","clinica");

        $femtoFacoSC = get_the_terms( $post->ID, $femtoFacoTN);
						
		//var_dump($femtoFacoSC);
						
        if ( $femtoFacoSC && ! is_wp_error( $femtoFacoSC ) ){            
        	$taxo_femtoFaco = array();
    	    foreach ( $femtoFacoSC as $term ) {
    	    
	    	    $taxo_femtoFaco[] = $term->slug;
	        }						
	        $Result_femtoFaco = join("", $taxo_femtoFaco);
        }
        else{
            $Result_femtoFaco = _x('femto-faco','taxo-name','clinica').'-se';
                    }
                    
           // echo 'El resultado ha sido : '.$Result_femtoFaco.'<br />';        
    ?>
     <div class="ui-widget startsUgly">
  <label  class="cliniBSetTitle"><?php echo _x('Disponibilidad de Láser de Femtosegundo (femto-faco):','Right Single Clinica','clinica_cpt_display');?></label>
    <div id="femtoFacoFilter">
        <?php 
        $femtoFacoTermS = get_terms($femtoFacoTN,array('hide_empty' => false ) ); 
        if  ($femtoFacoTermS) {
            foreach ($femtoFacoTermS as $femtoFaco ) {
            
            
            echo '<input type="radio" id="femtoFaco'.$femtoFaco->slug.'" '.checked($femtoFaco->slug, $Result_femtoFaco, false).' name ="'._x('femto-faco','taxo-name','clinica').'" value="'.$femtoFaco->slug.'" /><label for="femtoFaco'.$femtoFaco->slug.'">'.$femtoFaco->name.'</label>';
            
        }
              echo '<input type="radio" id="femtoFacoDefault" '.checked(_x('femto-faco','taxo-name','clinica').'-se', $Result_femtoFaco, false).'  name ="'._x('femto-faco','taxo-name','clinica').'" value="'._x('femto-faco','taxo-name','clinica').'-se" /><label for="femtoFacoDefault">'._x('S/E','Filter_Template','clinica_display').'</label>';

        
        }

       ?>       
    </div>
  </div>
     
     <!-- Fin Faco -->

             <?php
         //Vamos a poner a sacar el tipo de lente que es (Recordemos que hemos establecido una clasificación jerárquica).
         $uTN = _x('ubicacion','taxo-name','clinica');
         //CUIDADOOOO¡¡¡ => Hay que informar de que sólo se pone una localización no las dos¡¡
         $provinciaTerm = array_shift(array_values(get_the_terms( $post->ID, $uTN )));
         $provinciaTermSlug = $provinciaTerm->slug;

         $comAutos = get_terms( array($uTN), array( 'parent' => 0, 'hide_empty'=> 0  ) ); //, 'hide_empty'=> 0



         //Vemos si lo que se obtiene en provincia term es 1er nivel o 2o nivel.
         //if(current_user_can('manage_options')){
             //si se cumple esta condición es que es del primer nivel
             if($provinciaTerm->parent == 0){
                 $comAuto = $provinciaTerm; 
             }else{
                 $comAuto = get_term_by('id',$provinciaTerm->parent, $uTN);                 
             }
         //}        


         $comAutoSlug = $comAuto->slug;


         $comAutoId = $comAuto->term_id;
         //$provinces =  get_terms( array('ubicacion'), array('hierarchical'=> FALSE, 'hide_empty'=> 0));
         $provincesInScope = get_terms( array($uTN), array('hierarchical'=> FALSE, 'hide_empty'=> 0, 'parent'=>$comAutoId ));

     ?>

        <!-- Inicio de Ubicacion: Comunidad Autónoma -> Son 2 comboboxes: La primera de términos padre y la segunda de términos hijo... lo suyo sería que apareciesen sólo los términos hijos del seleccionado-->
        <div class="ui-widget startsUgly">
        <label  class="cliniBSetTitle"><?php echo _x('Comunidad Autónoma:','Right Single Clinica','clinica_cpt_display');?></label>
        <select id="combobox-ubicacion-parent" name="ubicacion-parent">
        <?php
        if  ($comAutos) {
               echo '<option value = "ubicacion-parent-se" id="comAutoDefault">'._x('Sin Especificar','Right Single Clinica','clinica_cpt_display').'</option>';
             foreach ($comAutos as $taxonomy ) {
                  // echo $taxonomy.'   '.$Result_Tipo;
                   if($taxonomy->slug == $comAutoSlug)
                      {
                       echo '<option selected="selected" value = "' . $taxonomy->slug . '">' . $taxonomy->name . '</option>';
                       if(current_user_can('manage_options')){
            // echo $comAutoSlug;
            //echo 'SIIIIII'; 
         }
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
        <div class="ui-widget startsUgly" id="provincia">
        <label  class="cliniBSetTitle"><?php echo _x('Provincia:','Right Single Clinica','clinica_cpt_display');?></label>
        <select id="combobox-ubicacion-child" name="ubicacion-child">
        <?php
        if  ($provincesInScope) {
               echo '<option value = "ubicacion-parent-se" id="comAutoDefault">'._x('Sin Especificar','Right Single Clinica','clinica_cpt_display').'</option>';
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






 <div id="accordionFilterSimple">
     <h3> <span class="title-filter"><?php echo _x('Características básicas','Right Single Clinica','clinica_cpt_display'); ?></span> </h3>
     <div>


    <!-- Datos adicionales de la Clínica -->
        <?php

        $miTN = _X('mas-info-clinica','taxo-name','clinica');
        $Result_mInfClinArray = array();//No sé si es necesario declarar el array pero bueno...
        //Vamos a sacar el número de cirugías de la clínica.
        $mInfClin = get_the_terms( $post->ID, $miTN );
						
        if ( $mInfClin && ! is_wp_error( $mInfClin ) ){            
        	$taxo_mInfClin = array();
    	    foreach ( $mInfClin as $term ) {
	    	    $Result_mInfClinArray[] = $term->slug;
	        }						
	        //$Result_mInfClin = join("", $taxo_mInfClin);
        }
        else{
            //$Result_mInfClin = '';
            $Result_mInfClinArray[] = $miTN.'-se';
                    }
    ?>
     <div class="ui-widget startsUgly">
  <label class="cliniBSetTitle"><?php echo _x('Datos adicionales de la clínica','Right Single Clinica','clinica_cpt_display');?></label>
    <div id="tipoMInfFilter">
        <?php 
        $mInfClinS = get_terms($miTN, array( 'hide_empty'=> 0 ) ); 
        if  ($mInfClinS) {
            foreach ($mInfClinS as $taxonomyValue ) {

                //Check del segundo término de la taxonomía.
                if($taxonomyValue->slug == _x('seguros','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug,$Result_mInfClinArray))
                    {
                     echo '<input type="checkbox" id="seguros" checked="checked" name ="'.$miTN.'" value="'.$taxonomyValue->slug.'" /><label for="seguros">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="seguros" name ="'.$miTN.'" value = "'.$taxonomyValue->slug.'" /><label for="seguros">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('cirugia-intraocular-bilateral','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug, $Result_mInfClinArray))
                    {
                     echo '<input type="checkbox" id="cirubi" checked="checked" name ="'.$miTN.'" value="'.$taxonomyValue->slug.'" /><label for="cirubi">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="cirubi" name ="'.$miTN.'" value = "'.$taxonomyValue->slug.'" /><label for="cirubi">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('posibilidad-de-hospitalizacion','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_Array($taxonomyValue->slug, $Result_mInfClinArray))
                    {
                     echo '<input type="checkbox" id="posHos" checked="checked" name ="'.$miTN.'" value="'.$taxonomyValue->slug.'" /><label for="posHos">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="posHos" name ="'.$miTN.'" value = "'.$taxonomyValue->slug.'" /><label for="posHos">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('quirofanos-propios','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug, $Result_mInfClinArray)) //antes $Result_equipClinArray
                    {
                     echo '<input type="checkbox" id="quiPro" checked="checked" name ="'.$miTN.'" value="'.$taxonomyValue->slug.'" /><label for="quiPro">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="quiPro" name ="'.$miTN.'" value = "'.$taxonomyValue->slug.'" /><label for="quiPro">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('laser-propio','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug, $Result_mInfClinArray))
                    {
                     echo '<input type="checkbox" id="laPro" checked="checked" name ="'.$miTN.'" value="'.$taxonomyValue->slug.'" /><label for="laPro">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="laPro" name ="'.$miTN.'" value = "'.$taxonomyValue->slug.'" /><label for="laPro">'.$taxonomyValue->name.'</label>';  
                    }
                 }

                }
                if(in_array($miTN.'-se', $Result_mInfClinArray)){
                   echo '<input type="checkbox" checked="checked" id="masInfoDefault" name ="'.$miTN.'" value="'.$miTN.'-se" /><label for="masInfoDefault">'._x('Sin Especificar','Right Single Clinica','clinica_cpt_display').'</label>';  
                }else{
                   echo '<input type="checkbox" id="masInfoDefault" name ="'.$miTN.'" value="'.$miTN.'-se" /><label for="masInfoDefault">'._x('Sin Especificar','Right Single Clinica','clinica_cpt_display').'</label>';  

                }
        }

       ?>       
    </div>
  </div>
         <!-- Fin datos adicionales de la clínica-->



   
   <!-- Inicio Equipamiento-->
       <?php

        $eCTN = _x('equipamiento-clinica','taxo-name','clinica');

        //Vamos a sacar el número de cirugías de la clínica.
        $equipClin = get_the_terms( $post->ID, $eCTN );
						
        if ( $equipClin && ! is_wp_error( $equipClin ) ){            
        	$taxo_equipClin = array();
    	    foreach ( $equipClin as $term ) {
	    	    $Result_equipClinArray[] = $term->slug;
	        }					
	        //$Result_equipClin = join("", $taxo_equipClin);
	        
        }
        else{
            $Result_equipClinArray[] = $eCTN.'-se';
                    }
    ?>
     <div class="ui-widget startsUgly">
    <label  class="cliniBSetTitle"><?php echo _x('Equipos de la clínica','Right Single Clinica','clinica_cpt_display'); ?></label>
    <div id="tipoIOLFilter">
        <?php 
        $equipClinS = get_terms($eCTN, array('hide_empty'=> 0) ); 
        if  ($equipClinS) {
            foreach ($equipClinS as $taxonomyValue ) {
                //Check del primer término de la taxonomía.
                if($taxonomyValue->slug == _x('faco-microincision','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug,$Result_equipClinArray))// == $Result_equipClin)
                    {
                     echo '<input type="checkbox" id="facoMicro" checked="checked" name ="'.$eCTN.'" value="'.$taxonomyValue->slug.'" /><label for="facoMicro">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="facoMicro" name ="'.$eCTN.'" value = "'.$taxonomyValue->slug.'" /><label for="facoMicro">'.$taxonomyValue->name.'</label>';  
                    }
                 }

                //Check del segundo término de la taxonomía.
                if($taxonomyValue->slug == _x('femto-faco','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug,$Result_equipClinArray))
                    {
                     echo '<input type="checkbox" id="femtoFaco" checked="checked" name ="'.$eCTN.'" value="'.$taxonomyValue->slug.'" /><label for="femtoFaco">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="femtoFaco" name ="'.$eCTN.'" value = "'.$taxonomyValue->slug.'" /><label for="femtoFaco">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('biometros','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug,$Result_equipClinArray))
                    {
                     echo '<input type="checkbox" id="biome" checked="checked" name ="'.$eCTN.'" value="'.$taxonomyValue->slug.'" /><label for="biome">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="biome" name ="'.$eCTN.'" value = "'.$taxonomyValue->slug.'" /><label for="biome">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('iol-master','taxo-value-slug','clinica-scaffold'))
                {
                 if(in_array($taxonomyValue->slug,$Result_equipClinArray))
                    {
                     echo '<input type="checkbox" id="iolM" checked="checked" name ="'.$eCTN.'" value="'.$taxonomyValue->slug.'" /><label for="iolM">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="iolM" name ="'.$eCTN.'" value = "'.$taxonomyValue->slug.'" /><label for="iolM">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                 //Check del tercer término de la taxonomía.
                if($taxonomyValue->slug == _x('lenstar','taxo-value-slug','clinica'))
                {
                 if(in_array($taxonomyValue->slug,$Result_equipClinArray))
                    {
                     echo '<input type="checkbox" id="lenst" checked="checked" name ="'.$eCTN.'" value="'.$taxonomyValue->slug.'" /><label for="lenst">'.$taxonomyValue->name.'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="lenst" name ="'.$eCTN.'" value = "'.$taxonomyValue->slug.'" /><label for="lenst">'.$taxonomyValue->name.'</label>';  
                    }
                 }
                }
                if(in_array( $eCTN.'-se',$Result_equipClinArray)){
              echo '<input type="checkbox" id="tipoEquipDefault" checked="checked" name ="'.$eCTN.'" value="'.$eCTN.'-se" /><label for="tipoEquipDefault">'._x('Sin Especificar','Right Single Clinica','clinica_cpt_display').'</label>';  
                }else{
                  echo '<input type="checkbox" id="tipoEquipDefault" name ="'.$eCTN.'" value="'.$eCTN.'-se" /><label for="tipoEquipDefault">'._x('Sin Especificar','Right Single Clinica','clinica_cpt_display').'</label>';  

                }
          }

       ?>       
    </div>
  </div>
   <!-- FIN Equipamiento-->
   
   
  
   	
   	
   <!-- Ini Posibilidad de Financiación -->
     
    <?php
        //Vamos a sacar el número de cirugías de la clínica.
        
        $financiacionTN = _x("financiacion","taxo-name","clinica");

        $financiacionSC = get_the_terms( $post->ID, $financiacionTN);
						
		//var_dump($femtoFacoSC);
						
        if ( $financiacionSC && ! is_wp_error( $financiacionSC ) ){            
        	$taxo_financiacion = array();
    	    foreach ( $financiacionSC as $term ) {
    	    
	    	    $taxo_financiacion[] = $term->slug;
	        }						
	        $Result_financiacion = join("", $taxo_financiacion);
        }
        else{
            $Result_financiacion = _x('financiacion','taxo-name','clinica').'-se';
                    }
                    
           // echo 'El resultado ha sido : '.$Result_femtoFaco.'<br />';        
    ?>
     <div class="ui-widget startsUgly">
  <label  class="cliniBSetTitle"><?php echo _x('Posibilidad de Financiación:','Right Single Clinica','clinica_cpt_display');?></label>
    <div id="financiacionFilter">
        <?php 
        $financiacionS = get_terms($financiacionTN,array('hide_empty'    => false ) ); 
        if  ($financiacionS) {
            foreach ($financiacionS as $financiacion ) {
            
            echo '<input type="radio" id="financiacion'.$financiacion->slug.'" '.checked($financiacion->slug, $Result_financiacion, false).' name ="'._x('financiacion','taxo-name','clinica').'" value="'.$financiacion->slug.'" /><label for="financiacion'.$financiacion->slug.'">'.$financiacion->name.'</label>';
            
        }
              echo '<input type="radio" id="financiacionDefault" '.checked(_x('financiacion','taxo-name','clinica').'-se', $Result_financiacion, false).'  name ="'._x('financiacion','taxo-name','clinica').'" value="'._x('financiacion','taxo-name','clinica').'-se" /><label for="financiacionDefault">'._x('S/E','Filter_Template','clinica_display').'</label>';

        
        }

       ?>       
    </div>
  </div>
     
     <!-- Fin Posibilidad de Financiación -->
   
   
   
   
   

  </div>
     </div>
   	
   </form>

    <?php }else{

        

        // continued below ...
        ?>
        <div class="clinicImages">
        
        <?php if((get_locale()=='es_ES')||(get_locale()=='es_CO')||(get_locale()=='es_MX')||(get_locale()=='es_CL')){
        			echo _x('Imágenes de la clínica','Right Single Clinica','clinica');
        		}
        	  
        	  if(get_locale()=='de_DE' || get_locale()=='de_AT'){
        			echo 'Bildergalerie';
        		}
        	   if((get_locale()=='en_GB')||(get_locale()=='fr_FR')||(get_locale()=='en_US')){
        	   	echo 'Images';
        	   }
        	
        ?>
        
        </div>
    <?php    
    // continued from above ...
        if($imagesGallery){ ?>
                <div id="rightSlider">
                <?php foreach($imagesGallery as $image){ ?>
                    <div class="slideImgWrapper">
                        <a href="<?php echo str_replace("http:","https:",$image->guid); ?>" title="<?php echo $image->post_title; ?>" rel="lightbox[<?php echo $clinica->ID?>]">
                       <img src="<?php echo str_replace("http:","https:",$image->guid); ?>" alt="<?php echo $image->post_title; ?>" title="<?php echo $image->post_title; ?>" />
                        </a>
                    </div>
                    <hr />      
        <?php    } ?>
                </div>
       <style>
     div.clinicImages{      
                        color: #21759b;
                        font-family: negotiatefree;
                        font-size: 14px;
                        text-transform: uppercase;
                        margin-left: 10px;
                        margin-top: 20px;
                        text-align: left;
                        text-decoration: underline;
                      }
           
           #rightSlider {
                            max-width: 98%;
                        }
           #rightSlider .slideImgWrapper {
                                        border: 2px solid #d6d6d6;
                                        margin-top: 20px;
                                        max-height: 80px;
                                        overflow: hidden;
                                        width: 100%;
                                          }
           #rightSlider .slideImgWrapper hr {
           
                     color: #f0f0f0;
           }
           
           #rightSlider img{
                        width: 100%;
                        height: auto;
                        }
       </style>
        <?php }
     
     }
     ?>



</div>	