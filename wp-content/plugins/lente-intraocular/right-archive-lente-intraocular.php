
 
<!-- Estos botones sólo se van a poner si no es el archive -->
<?php if(FALSE): ?>
   	 <!-- Vamos a meter un link de ayuda que nos explique como se utiliza -->
    	<div id="helpTitle" class="notArchive">
            <?php /*get_page_by_title( 'Ayuda para la Búsqueda de Lentes Intraoculares' )->ID*/ ?>
     		<a href="<?php echo get_permalink(2838); ?>" ></a>
    	</div>
    <!-- Vamos a meter un botón que nos permita refrescar la búsqueda -->
    	<button id="searchReset" class="notArchive">
    		<?php echo _x('Resetear Búsqueda','Right Archive Lente Intraocular','iol_cpt_display'); ?>
    	</button>
<?php endif;?>
<!-- Fin de botones -->


  <h3 class="right-filter-title"> <?php echo _x('BUSCAR LENTES INTRAOCULARES:','Right Archive Lente Intraocular','iol_cpt_display'); ?></h3>      
  <form id="iol_filter_form">

   <input type="button" value="<?php  echo _x('Realizar Filtrado','Right Archive Lente Intraocular','iol_cpt_display'); ?>" class="submitArchive" onClick="archive_submit_me();" />     	

<input name="action" type="hidden" value="filter_result" /> <!-- this puts the action the_ajax_hook into the serialized form -->

<!-- <input name="pt" type="hidden" value="no" /> Quitamos esto también -->

<!-- Select list para el número de elementos a mostrar/tipo de vista del output -->
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
  <div class="ui-widget startsUgly" id="comboViewType">
  <span id="titleViewType"><?php echo _x('Vista','Right Archive Lente Intraocular','iol_cpt_display'); ?>:</span>
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
<!-- Fin SelectList con el tipo de vista-->

<!-- Vamos a añadir este hidden input para llevar a cabo la paginación -->
  <!-- <input id="pagina" name="page" type="hidden" value="empty" />-->

 <div id="simpleAccordionFilter">
     <h3> <span class="title-filter"><?php echo _x('Características Generales','Right Archive Lente Intraocular','iol_cpt_display'); ?> </span> 
     <span id="dragger-simpleAccordionFilter" class="ui-icon ui-icon-arrow-4-diag startsUgly">&nbsp;</span>
     <span id="reseter-simpleAccordionFilter" class="ui-icon ui-icon-refresh startsUgly">&nbsp;</span>
     </h3>
 <!-- Quremos que el div de acontinuación se carge más tarde-->
 <div>
  <div class="startsUgly">
  <!-- Combo con el Tipo de lente -->
  <?php
     //Vamos a ver el tipo de lente que nos viene
        if (get_query_var(_x('tipo-lente-intraocular','taxo-name','iol'))){
           
	        $Result_TipoLente = get_query_var(_x('tipo-lente-intraocular','taxo-name','iol'));
            //echo $Result_Tipo;
        }
         else{
             //$UndefinedTaxonomyDataSelector[] = 'select[name="tipo-lente-intraocular"]';
             $Result_TipoLente = _x('tipo-lente-intraocular','taxo-name','iol')."-se";
         }
     ?>

  <div class="ui-widget startsUgly" id="comboTipoLente">
<?php          

?>

  <label  class="labelTitleFirst"><?php echo _x('Tipo de lente intraocular:','Right Archive Lente Intraocular','iol_cpt_display');?></label>
  <select id="comboboxTipoLente" name="<?php echo  _x('tipo-lente-intraocular','taxo-name','iol')?>">
  <?php
      //Extraemos el tipo que tiene la lente.
       $LentePseudofaquicadId = get_term_by('slug',_x('pseudofaquica','taxo-value-slug','iol-scaffold'),_x('tipo-lente-intraocular','taxo-name','iol'))->term_id;
       $LentesStandyPremIds = get_term_children($LentePseudofaquicadId,_x('tipo-lente-intraocular','taxo-name','iol'));
       $tiposLenteArgs = array('exclude' => $LentesStandyPremIds, 'hide_empty' => 0,'orderby'=>'none');
       $tiposLente = get_terms(_x('tipo-lente-intraocular','taxo-name','iol'),$tiposLenteArgs); 
       

       if  ($tiposLente) {
           if($Result_TipoLente==_x('tipo-lente-intraocular','taxo-name','iol')."-se"){
            echo '<option value = "'._x('tipo-lente-intraocular','taxo-name','iol').'-se" selected="selected" id="diseOpticDefault">'._x('Sin Especificar','Right Archive Lente Intraocular','iol_cpt_display').'</option>';
           }
           else{
               echo '<option value = "'._x('tipo-lente-intraocular','taxo-name','iol').'se" id="diseOpticDefault">'._x('Sin Especificar','Right Archive Lente Intraocular','iol_cpt_display').'</option>';
           }
           foreach ($tiposLente as $taxonomy ) {
              //echo 'A ver'.$taxonomy->slug.'   '.$Result_TipoLente.'<br />';
               if($taxonomy->slug == $Result_TipoLente)
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
  <!-- Fin del Combobox con el tipo de lente -->

 
 
  <!-- Combo con el Tipo de Lente -->
  <?php
     //Vamos a ver el tipo de lente que nos viene
        if (get_query_var(_x('diseno-optica','taxo-name','iol'))){ //get_query_var('diseno-optica') //array_key_exists(_x('diseno-optica','taxo-name','iol'),$_GET)
           

	        $Result_Tipo = get_query_var(_x('diseno-optica','taxo-name','iol'));//$_GET[_x('diseno-optica','taxo-name','iol')];//get_query_var('diseno-optica');
            //echo $Result_Tipo;
        }
         else{
             $Result_Tipo = _x('diseno-optica','taxo-name','iol')."-se";
             //$UndefinedTaxonomyDataSelector[] = 'select[name="diseno-optica"]';
         }
     ?>

  <div class="ui-widget startsUgly" id="comboTipoOptica">
  <label title=" Explicación del diseño de óptica"  class="labelTitle"><?php echo _x('Diseño de Óptica:','Right Archive Lente Intraocular','iol_cpt_display');?></label>
  <select id="comboboxTipo" name="<?php echo _x('diseno-optica','taxo-name','iol'); ?>">
  <?php
      //Extraemos el tipo que tiene la lente.
       $disenoOpticaArgs = array('hide_empty' => 0,'orderby'=>'none');
       $tipos = get_terms( _x('diseno-optica','taxo-name','iol'),$disenoOpticaArgs); 
       if  ($tipos) {
           if($Result_Tipo == _x('diseno-optica','taxo-name','iol')."-se"){
            echo '<option value = "'._x('diseno-optica','taxo-name','iol').'-se" selected="selected" id="diseOpticDefault">'._x('Sin Especificar','Right Archive Lente Intraocular','iol_cpt_display').'</option>';
           }
           else{
               echo '<option value = "'._x('diseno-optica','taxo-name','iol').'-se" id="diseOpticDefault">'._x('Sin Especificar','Right Archive Lente Intraocular','iol_cpt_display').'</option>';
           }
           foreach ($tipos as $taxonomy ) {
              echo 'A ver'.$taxonomy->slug.'   '.$Result_Tipo.'<br />';
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
      //Vamos a sacar la toricidad de lente que nos viene en el POST.
       if( get_query_var( _x('toricidad','taxo-name','iol') )){
           
           $Result_toricidad = get_query_var(_x('toricidad','taxo-name','iol'));
        }
        else{
            $Result_toricidad = _x('toricidad','taxo-name','iol').'-se';
            //$UndefinedTaxonomyDataSelector[] = 'input[name="toricidad"]';
        }
     ?>
  <div class="ui-widget startsUgly" id="selectToricidadLente">
  <label title=" Explicación de toricidad" class="labelTitle"><?php echo _x('Toricidad de la Lente:','Right Archive Lente Intraocular','iol_cpt_display');?></label>
    <div id="toricidadFilter">
        <?php 
        $toricidades = get_terms(_x('toricidad','taxo-name','iol')); 
        if  ($toricidades) {
            foreach ($toricidades as $taxonomyTor ) {
                if($taxonomyTor->slug == _x('torica','taxo-value-slug','iol-scaffold'))
                {
                 if($taxonomyTor->slug == $Result_toricidad)
                    {
                     echo '<input type="radio" id="Toric" checked="checked" name ="'._x('toricidad','taxo-name','iol').'" value="'.$taxonomyTor->slug.'" /><label for="Toric">'._x('Tórica','taxo-value-name','iol-scaffold').'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="Toric" name ="'._x('toricidad','taxo-name','iol').'" value = "'.$taxonomyTor->slug.'" /><label for="Toric">'._x('Tórica','taxo-value-name','iol-scaffold').'</label>';  
                    }
                 }
                 if($taxonomyTor->slug != _x('torica','taxo-value-slug','iol-scaffold'))
                    {
                     if($taxonomyTor->slug == $Result_toricidad)
                       {
                         echo '<input type="radio" id="NoToric" checked="checked" name ="'._x('toricidad','taxo-name','iol').'" value="'.$taxonomyTor->slug.'" /><label for="NoToric">'._x('No Tórica','taxo-value-name','iol-scaffold').'</label>';
                       }
                      else{
                         echo '<input type="radio" id="NoToric" name ="'._x('toricidad','taxo-name','iol').'" value="'.$taxonomyTor->slug.'"/><label for="NoToric">'._x('No Tórica','taxo-value-name','iol-scaffold').'</label>';
                       }
                    }
                }
                if($Result_toricidad == _x('toricidad','taxo-name','iol').'-se')
                {
                 echo '<input type="radio" checked="checked" id="toricidadFilterDefault" name ="'._x('toricidad','taxo-name','iol').'" value="toricidad-se" /><label for="toricidadFilterDefault">'._x('S/E','Right Archive Lente Intraocular','iol_cpt_display').'</label>';
                }
                else{
                    echo '<input type="radio" id="toricidadFilterDefault" name ="'._x('toricidad','taxo-name','iol').'" value="'._x('toricidad','taxo-name','iol').'-se" /><label for="toricidadFilterDefault">'._x('S/E','Right Archive Lente Intraocular','iol_cpt_display').'</label>';
                 }   
        }

       ?>       
    </div>
  </div>




      <!-- Button Group con los filtros -->

     <?php   
      //Vamos a poner a mostrar en grupo de botones los filtros que lleva la lente.
     if(get_query_var(_x('luz-ultravioleta','taxo-value-slug','iol-scaffold')) or get_query_var(_x('luz-azul','taxo-value-slug','iol-scaffold') ))
    {
        if(get_query_var(_x('luz-ultravioleta','taxo-value-slug','iol-scaffold'))){ 
            $Result_filtros = get_query_var(_x('luz-ultravioleta','taxo-value-slug','iol-scaffold'));
            //$Result_filtros = _x('UV','taxo-filtros-value','iol');
            //$args[_x('filtros','taxo-name','iol')] =  $_GET['uvSI'];
        }
        if(get_query_var(_x('luz-azul','taxo-value-slug','iol-scaffold'))){
            $Result_filtros = get_query_var(_x('luz-azul','taxo-value-slug','iol-scaffold'));
            //echo 'Sí que se ha identificado';
            //   $args[_x('filtros','taxo-name','iol')] =  $_GET['laSI'];
            //$Result_filtros =   _x('Luz Azul','taxo-filtros-value','iol');
        }
    }
     else{
           $Result_filtros = _x('filtros','taxo-name','iol')."-se";
            //$UndefinedTaxonomyDataSelector[] = '#filtrosFilter input';
     }
      
     ?>
  <div class="ui-widget startsUgly" id="selectFiltrosLente">
  <label title=" Explicación de filtros" class="labelTitle"><?php echo _x('Filtros de la Lente:','Right Archive Lente Intraocular','iol_cpt_display'); ?></label>
    <div id="filtrosFilter">
        <?php 
        $filtros = get_terms(_x('filtros','taxo-name','iol'), array('hide_empty' => 0)); 
        if  ($filtros) {
            foreach ($filtros as $taxonomyFiltr ) {
                if($taxonomyFiltr->slug == _x('luz-ultravioleta','taxo-value-slug','iol-scaffold')){
                       if($taxonomyFiltr->slug == $Result_filtros)
                           {
                             echo '<input type="checkbox" id="UV" checked="checked"  name="'._x('luz-ultravioleta','taxo-value-slug','iol-scaffold').'" value='.$taxonomyFiltr->slug.' /><label for="UV">'._x('UV','Right Archive Lente Intraocular','iol_cpt_display').'</label>';
                           }
                       else{
                             echo '<input type="checkbox" id="UV" name="'._x('luz-ultravioleta','taxo-value-slug','iol-scaffold').'" value='.$taxonomyFiltr->slug.' /><label for="UV">'._x('UV','Right Archive Lente Intraocular','iol_cpt_display').'</label>';      
                           }
                       }
                 if($taxonomyFiltr->slug == _x('luz-azul','taxo-value-slug','iol-scaffold')){
                    
                       if($taxonomyFiltr->slug == $Result_filtros)
                           {
                             echo '<input type="checkbox" id="LuzAzul" checked="checked"  name="'._x('luz-azul','taxo-value-slug','iol-scaffold').'" value='.$taxonomyFiltr->slug.' /><label for="LuzAzul">'._x('Luz Azul','Single Patient Form','iol_cpt_display').'</label>';
                           }
                       else{
                             echo '<input type="checkbox" id="LuzAzul"  name="'._x('luz-azul','taxo-value-slug','iol-scaffold').'" value='.$taxonomyFiltr->slug.' /><label for="LuzAzul">'._x('Luz Azul','Single Patient Form','iol_cpt_display').'</label>';
                           }
                       }
                   }
              //Si este está seleccionado, no habrá filtro.
              if ($Result_filtros== _x('filtros','taxo-name','iol')."-se")
              {
                  echo '<input type="checkbox" checked ="checked" id="filtrosFilterDefault" name="'._x('filtros','taxo-name','iol').'-se" value ="'._x('filtros','taxo-name','iol').'-se" /><label for="filtrosFilterDefault">'._x('S/E','Right Archive Lente Intraocular','iol_cpt_display').'</label>';  
              }
              else{
                  echo '<input type="checkbox" id="filtrosFilterDefault" name="'._x('filtros','taxo-name','iol').'-se" value ="'._x('filtros','taxo-name','iol').'-se" /><label for="filtrosFilterDefault">'._x('S/E','Right Archive Lente Intraocular','iol_cpt_display').'</label>'; 
              }
            }
            
       ?>       
    </div>
  </div>


  <!-- Slider con el Rango de Adiciones -->
  <?php 



    if(get_query_var('adicion-cercaTV')){
        $adCe = get_query_var('adicion-cercaTV');
        //Primero sacamos los 2 límites y luego con meta_query hacemos la query.
        $pos = strpos($adCe, ' ');
        $add_inf = substr($adCe, 0, $pos);
        
        $last_space = strrpos($adCe, ' ');
        $pos_guion = strpos($adCe, '-',strpos($adCe,'diopt'));
        $add_sup_lenght = $last_space - $pos_guion - 1;
         
        $add_sup =substr($adCe, $pos_guion +1 , $add_sup_lenght);

      //  echo 'La adición inferior de acuerdo a la url es:'.$add_inf.'<br />';
      //  echo 'La adición superior de acuerdo a la url es:'.$add_sup.'<br />';

        $Result_Add = ($add_inf + $add_sup)/2;
    }
    else
    {
       //$UndefinedMetaDataSelector[] = '#amount-add';
       $Result_Add = '0'; 
        
    }

      //Calculamos ahora los valores a mostrar por el slider asociado.
       if( $Result_Add == '0')
          {
            //Si en la query no hay adición ponemos el slider en sus valores límites.
            $minf_add = strval(1.5);
            $msup_add = strval(4);
          }
          else{
            //Si en la query hay valores dados, ponemos el slider en esos valores.
            $minf_add = $add_inf;
            $msup_add = $add_sup;

             // $msup_add = strval(floatval($Result_Add) );//+ 0.25 Dejamos lo de "añadir márgenes".
             // $minf_add = strval(floatval($Result_Add) ); //- 0.25
          }
  ?>

           <?php 
      //Almacenamos los valores del slider en sendas variables javascript.
        echo '<script>';
            echo 'var rangeAddMinfAdd ='.$minf_add.';'; 
            echo 'var rangeAddMsupAdd ='.$msup_add.';'; 
        echo '</script>';
        ?>
  <div class="ui-widget startsUgly slideWButton" id="sliderMultifocalidadLente">
  <label for="amount" title=" Explicación de adición" class="labelTitle"><?php echo _x('Multifocalidad - Presbicia:','Right Archive Lente Intraocular','iol_cpt_display'); ?></label>
  <button id="addDisabler">adicion Disabler</button>
  <input type="text" id="amount-add" style="border: 0; " name="adicion-cercaTV" />
  <div id="slider-range-add"></div>

  </div>
  <!-- Combo con el fabricante -->
     <?php
     //Vamos a poner a sacar el fabricante de lente que es (Recordemos que hemos establecido una clasificación jerárquica).
        if (get_query_var(_x('fabricante-lente','taxo-name','iol'))){
	        $Result_Fabricante = get_query_var(_x('fabricante-lente','taxo-name','iol'));
            }
         else{
             $Result_Fabricante = _x('fabricante-lente','taxo-name','iol')."-se";
             //$UndefinedTaxonomyDataSelector[] = 'select[name="fabricante-lente"]';
         }

     ?>    


  <div class="ui-widget startsUgly" id="comboFabricanteLente">
  <label title=" Explicación de fabricante" class="labelTitle"><?php echo _x('Fabricante:','Right Archive Lente Intraocular','iol_cpt_display'); ?></label>
  <select id="comboboxFabricante" name="<?php echo _x('fabricante-lente','taxo-name','iol'); ?>">
  <?php
       //Notamos que $Result_Fabricante ya viene obtenido del Left Panel.
       $fabricantes = get_terms(_x('fabricante-lente','taxo-name','iol')); 
       if  ($fabricantes) {
             echo '<option value = "'._x('fabricante-lente','taxo-name','iol').'-se">'._x('Sin Especificar','Right Archive Lente Intraocular','iol_cpt_display').'</option>';
              foreach ($fabricantes  as $fabricante ) 
              { 
                  echo '<br />'.$fabricante->slug.'--'.$Result_Fabricante.'<br />';  
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
 
 </div>
  <!-- Fin del Filtro de usuarios normales-->

  <!-- PROCEDEMOS AHORA CON FILTRO AVANZADO -->

  <div id="advancedAccordionFilter">
        <h3><span class="title-filter"><?php echo _x('Bordes, Material, Hápticos...','Right Archive Lente Intraocular','iol_cpt_display'); ?></span>
        <span id="dragger-advancedAccordionFilter" class="ui-icon ui-icon-arrow-4-diag startsUgly">&nbsp;</span>
        <span id="reseter-advancedAccordionFilter" class="ui-icon ui-icon-refresh startsUgly">&nbsp;</span>
        </h3>
        
        <div>
           <!-- Magnitudes del filtro avanzado -->
           <div class="spanH4Wrapper startsUgly">
            <span id="spanAdvFilDisabler" class="startsUgly"><?php echo _x('No aplicar estos filtros:','Right Archive Lente Intraocular','iol_cpt_display');?></span> <button id="advancedFiltersDisabler"> Advanced Filters Disabler </button>
            <span style=" clear: both; height: 4px;"  class="startsUgly"></span> 
            <span id="spanAdvFilEnabler"  class="startsUgly"><?php echo _x('Aplicar estos filtros:','Right Archive Lente Intraocular','iol_cpt_display');?></span> <button id="advancedFiltersEnabler">Advanced Filters Enabler</button> 
            <span style=" clear: both;"  class="startsUgly"></span>
            <div style="clear: both;height: 0px;">&nbsp;</div>
          </div>


            <!-- 3 Bordes Cuadrados -->
            <?php
                
            if(get_query_var(_x('bordes-cuadrados','taxo-name','iol'))){
                 $Result_bcuad = get_query_var(_x('bordes-cuadrados','taxo-name','iol'));    
                }
                else{
                $Result_bcuad = _x('bordes-cuadrados','taxo-name','iol').'-se';
                //$UndefinedTaxonomyDataSelector[] = 'input[name="bordes-cuadrados"]';
                }
                                
              ?>
  <div class="ui-widget startsUgly"  id="selectBordCuadLens">
  <label title=" Explicación de bordes cuadrados" class="labelTitleFirst"><?php echo _x('Bordes Cuadrados:','Right Archive Lente Intraocular','iol_cpt_display'); ?></label>
    <div id="bordeCuadFilter">
        <?php 
        $bCuadrados = get_terms(_x('bordes-cuadrados','taxo-name','iol'), array('hide_empty' => 0));

        if  ($bCuadrados) {
            foreach ($bCuadrados as $taxonomyTBCuad ) {

                if($taxonomyTBCuad->slug == _x('si','taxo-value-slug','iol-scaffold'))
                {
                    
                 if($taxonomyTBCuad->slug == $Result_bcuad)
                    {
                     echo '<input type="radio" id="BCuadSi" name="'._x('bordes-cuadrados','taxo-name','iol').'" checked="checked" value="'.$taxonomyTBCuad->slug.'" /><label for="BCuadSi">'._x('Sí','Right Archive Lente Intraocular','iol_cpt_display').'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="BCuadSi" name="'._x('bordes-cuadrados','taxo-name','iol').'" value="'.$taxonomyTBCuad->slug.'"/><label for="BCuadSi">'._x('Sí','Right Archive Lente Intraocular','iol_cpt_display').'</label>';  
                    }
                 }
                 if($taxonomyTBCuad->slug != _x('si','taxo-value-slug','iol-scaffold'))
                    {
                     if($taxonomyTBCuad->slug == $Result_bcuad)
                       {
                         echo '<input type="radio" id="BCuadNo" checked="checked" name="'._x('bordes-cuadrados','taxo-name','iol').'" value="'.$taxonomyTBCuad->slug.'" /><label for="BCuadNo">'._x('No','Right Archive Lente Intraocular','iol_cpt_display').'</label>';
                       }
                      else{
                         echo '<input type="radio" id="BCuadNo" name="'._x('bordes-cuadrados','taxo-name','iol').'" value="'.$taxonomyTBCuad->slug.'" /><label for="BCuadNo">'._x('No','Right Archive Lente Intraocular','iol_cpt_display').'</label>';
                       }
                    }
                }
                if($Result_bcuad == _x('bordes-cuadrados','taxo-name','iol').'-se'){
                    echo '<input type="radio" id="BCuadSE" checked="checked" name="'._x('bordes-cuadrados','taxo-name','iol').'" value="'._x('bordes-cuadrados','taxo-name','iol').'-se" /><label for="BCuadSE">'._x('S/E','Right Archive Lente Intraocular','iol_cpt_display').'</label>';  
                }
                else{
                    echo '<input type="radio" id="BCuadSE" name="'._x('bordes-cuadrados','taxo-name','iol').'" value="'._x('bordes-cuadrados','taxo-name','iol').'-se" /><label for="BCuadSE">'._x('S/E','Right Archive Lente Intraocular','iol_cpt_display').'</label>'; 
                }
        } 
       ?>       
    </div>
  </div>

            <!-- Fin 3 Bordes Cuadrados -->



            <!-- 5 Principio Óptico-->
<?php			
          if(get_query_var(_x('refractiva','taxo-value-slug','iol-scaffold')) or get_query_var(_x('difractiva','taxo-value-slug','iol-scaffold')) or get_query_var(_x('mixta','taxo-value-slug','iol-scaffold')) ) //
            {
                if(get_query_var(_x('refractiva','taxo-value-slug','iol-scaffold'))){ 
                //Aquí va a haber que matchear el valor con el incluido en refractiva en el SetUp.
                $Result_ppo=  get_query_var(_x('refractiva','taxo-value-slug','iol-scaffold'));
                 }
                if(get_query_var(_x('difractiva','taxo-value-slug','iol-scaffold'))){
                $Result_ppo =  get_query_var(_x('difractiva','taxo-value-slug','iol-scaffold'));
                echo '<br />'.$Result_ppo.'<br />';
                }
                if(get_query_var(_x('mixta','taxo-value-slug','iol-scaffold'))){
                $Result_ppo =  get_query_var(_x('mixta','taxo-value-slug','iol-scaffold'));
                }
            }
            else{
                $Result_ppo= _x('principio-optico','taxo-name','iol').'-se';
                //$UndefinedTaxonomyDataSelector[] = '#ppOpticoFilter input';
            }
        		
            ?>
  <div class="ui-widget startsUgly" id="selectPrincOpticLens">
  <label title=" Explicación de principios ópticos" class="labelTitle"><?php echo _x('Principio Óptico:','Right Archive Lente Intraocular','iol_cpt_display'); ?></label>
    <div id="ppOpticoFilter">
        <?php 
        $ppOpticos = get_terms(_x('principio-optico','taxo-name','iol'), array('hide_empty' => 0));


        if  ($ppOpticos) {
            foreach ($ppOpticos as $taxonomypOpt ) {
               if($taxonomypOpt->slug == _x('refractiva','taxo-value-slug','iol-scaffold'))
                {
                    
                 if($taxonomypOpt->slug == $Result_ppo)
                    {
                     echo '<input type="checkbox" id="pRefractiva" checked="checked" name="'._x('refractiva','taxo-value-slug','iol-scaffold').'" value="'.$taxonomypOpt->slug.'" /><label for="pRefractiva">'._x('Refr.','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                    }    
                  else{
                     echo '<input type="checkbox" id="pRefractiva" name="'._x('refractiva','taxo-value-slug','iol-scaffold').'" value="'.$taxonomypOpt->slug.'" /><label for="pRefractiva">'._x('Refr.','Right Single Lente Intraocular','iol_cpt_display').'</label>';  
                    }
                 }
                 if($taxonomypOpt->slug == _x('difractiva','taxo-value-slug','iol-scaffold'))
                    {
                     if($taxonomypOpt->slug == $Result_ppo)
                       {
                         echo '<input type="checkbox" id="pDifractiva" checked="checked" name="'._x('difractiva','taxo-value-slug','iol-scaffold').'" value="'.$taxonomypOpt->slug.'" /><label for="pDifractiva">'._x('Difr.','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                       }
                      else{
                         echo '<input type="checkbox" id="pDifractiva" name="'._x('difractiva','taxo-value-slug','iol-scaffold').'" value="'.$taxonomypOpt->slug.'" /><label for="pDifractiva">'._x('Difr.','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                       }
                    }
                 if($taxonomypOpt->slug == _x('mixta','taxo-value-slug','iol-scaffold'))
                    {
                     if($taxonomypOpt->slug == $Result_ppo)
                       {
                         echo '<input type="checkbox" id="pMixta" checked="checked" name="'._x('mixta','taxo-value-slug','iol-scaffold').'" value="'.$taxonomypOpt->slug.'" /><label for="pMixta">'._x('Mixta','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                       }
                      else{
                         echo '<input type="checkbox" id="pMixta" name="'._x('mixta','taxo-value-slug','iol-scaffold').'" value="'.$taxonomypOpt->slug.'" /><label for="pMixta">'._x('Mixta','Right Single Lente Intraocular','iol_cpt_display').'</label>';
                       }
                    }
                }
                if($Result_ppo == _x('principio-optico','taxo-name','iol').'-se'){
                    echo '<input type="checkbox" checked="checked" id="ppOpticoFilterDefault" value ="'._x('principio-optico','taxo-name','iol').'-se" name="'._x('principio-optico','taxo-name','iol').'-se" /><label for="ppOpticoFilterDefault">'._x('S/E','Right Archive Lente Intraocular','iol_cpt_display').'</label>';
                }
                else{
                echo '<input type="checkbox" id="ppOpticoFilterDefault" value ="'._x('principio-optico','taxo-name','iol').'-se" name="'._x('principio-optico','taxo-name','iol').'-se" /><label for="ppOpticoFilterDefault">'._x('S/E','Right Archive Lente Intraocular','iol_cpt_display').'</label>';  
                }
            } 
       ?>       
    </div>
  </div>
            <!-- Fin Principio Óptico-->

            <!-- Combo del Diseño de Lente-->
                <?php
     //Vamos a poner a sacar el tipo de lente que es (Recordemos que hemos establecido una clasificación jerárquica).
       	
      if(get_query_var(_x('diseno','taxo-name','iol'))){
            $Result_DiseLente= get_query_var(_x('diseno','taxo-name','iol'));
        }
         else{
            $Result_DiseLente=_x('diseno','taxo-name','iol').'-se';
            //$UndefinedTaxonomyDataSelector[] = 'select[name="diseno-lente"]';
        }  
     ?>    

            <div class="ui-widget startsUgly" id="comboDiseLente">
            <label title=" Explicación de los filtros" class="labelTitle"><?php echo _x('Diseño de Lente:','Right Archive Lente Intraocular','iol_cpt_display'); ?></label>
            <select id="comboboxDiseLente" name="<?php echo _x('diseno','taxo-name','iol');?>">
    <?php
            //Notamos que $Result_fabricanteURL ya viene obtenido del Left Panel.
            $diseLentes = get_terms(_x('diseno','taxo-name','iol')); 
            if  ($diseLentes) {
                if($Result_DiseLente=='diseno-se'){
                    echo '<option selected=selected value = "'._x('diseno','taxo-name','iol').'-se">'._x('Sin Especificar','Right Archive Lente Intraocular','iol_cpt_display').'</option>';
                }
                 else{
                    echo '<option value = "'._x('diseno','taxo-name','iol').'-se">'._x('Sin Especificar','Right Archive Lente Intraocular','iol_cpt_display').'</option>';
                     }
                
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
                 echo '<option value = "'._x('diseno','taxo-name','iol').'-se" selected ="selected">'._x('Sin Especificar','Right Archive Lente Intraocular','iol_cpt_display').'</option>';
                }    
  ?>
   </select>
   </div>    
            <!-- Fin de Diseño de Lente-->

            <!-- Combo del Material de la Lente-->
                <?php
     //Vamos a poner a sacar el material de la lente intraocular (Recordemos que hemos establecido una clasificación jerárquica).
       
     if(get_query_var('material')){
                   $Result_MatLent = get_query_var('material');
      }	else{
            $Result_MatLent = 'material-se';
            //$UndefinedTaxonomyDataSelector[] = 'select[name="material"]';
        }	
                
        ?>    

            <div class="ui-widget startsUgly" id="comboMatLente">
            <label class="labelTitle"><?php echo _x('Material de Lente:','Right Archive Lente Intraocular','iol_cpt_display'); ?></label>
            <select id="comboboxMatLente" name="<?php echo _x('material','taxo-name','iol');?>">
    <?php
            //Notamos que $Result_fabricanteURL ya viene obtenido del Left Panel.
            $matLentes = get_terms(_x('material','taxo-name','iol')); 
            if  ($matLentes) {
                if($Result_MatLent == _x('material','taxo-name','iol').'-se'){
                    echo '<option selected="selected" value = "'._x('material','taxo-name','iol').'-se">'._x('Sin Especificar','Right Archive Lente Intraocular','iol_cpt_display').'</option>';
                }
                else{
                    echo '<option value = "'._x('material','taxo-name','iol').'-se">'._x('Sin Especificar','Right Archive Lente Intraocular','iol_cpt_display').'</option>';
                }
                  
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
              //   echo '<option value = "S/E" selected ="selected">'._x('Sin Especificar','Filter_Template','iol_cpt_display').'</option>';
            }   
  ?>
   </select>
   </div>   
            <!-- Fin de Material de Lente-->

            <!-- Inyector -->
            <?php
		 if(get_query_var(_x('inyector','taxo-name','iol'))){
          $Result_inyect = get_query_var(_x('inyector','taxo-name','iol'));
         }
          else{
               $Result_inyect = _x('inyector','taxo-name','iol').'-se';
               //$UndefinedTaxonomyDataSelector[] = 'input[name="inyector"]';
                }
            ?>
  <div class="ui-widget startsUgly" id="selectInjectorLente">
  <label class="labelTitle"><?php echo _x('Inyector:','Right Single Lente Intraocular','iol_cpt_display'); ?></label>
    <div id="inyectorFilter">
        <?php 
        $inyectLente = get_terms(_x('inyector','taxo-name','iol'));

        if  ($inyectLente) {
            foreach ($inyectLente as $taxonomyInyectLente ) {

                if($taxonomyInyectLente->slug == _x('con','taxo-value-slug','iol-scaffold'))
                {
                    
                 if($taxonomyInyectLente->slug == $Result_inyect)
                    {
                     echo '<input type="radio" id="inyectorCon" checked="checked" name="'._x('inyector','taxo-name','iol').'" value="'.$taxonomyInyectLente->slug.'" /><label for="inyectorCon">'._x('Con','Right Archive Lente Intraocular','iol_cpt_display').'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="inyectorCon" name="'._x('inyector','taxo-name','iol').'" value="'.$taxonomyInyectLente->slug.'" /><label for="inyectorCon">'._x('Con','Right Archive Lente Intraocular','iol_cpt_display').'</label>';  
                    }
                 }
                 if($taxonomyInyectLente->slug != _x('con','taxo-value-slug','iol-scaffold'))
                    {
                     if($taxonomyInyectLente->slug == $Result_inyect)
                       {
                         echo '<input type="radio" id="inyectorSin" checked="checked" name="'._x('inyector','taxo-name','iol').'" value="'.$taxonomyInyectLente->slug.'" /><label for="inyectorSin">'._x('Sin','Right Archive Lente Intraocular','iol_cpt_display').'</label>';
                       }
                      else{
                         echo '<input type="radio" id="inyectorSin" name="'._x('inyector','taxo-name','iol').'" value="'.$taxonomyInyectLente->slug.'" /><label for="inyectorSin">'._x('Sin','Right Archive Lente Intraocular','iol_cpt_display').'</label>';
                       }
                    }
                }
                if($Result_inyect == _x('inyector','taxo-name','iol').'-se'){
                    echo '<input type="radio" id="inyectSE"checked="checked" name="'._x('inyector','taxo-name','iol').'" value="'._x('inyector','taxo-name','iol').'-se" /><label for="inyectSE">'._x('S/E','Right Archive Lente Intraocular','iol_cpt_display').'</label>';
                }
                else{
                     echo '<input type="radio" id="inyectSE" name="'._x('inyector','taxo-name','iol').'" value="'._x('inyector','taxo-name','iol').'-se" /><label for="inyectSE">'._x('S/E','Right Archive Lente Intraocular','iol_cpt_display').'</label>';
                }
  
        } 
       ?>       
    </div>
  </div>
            <!-- Fin Inyector -->
            <!-- Precargada -->

            <?php
          if(get_query_var(_x('precargada','taxo-name','iol'))){
               $Result_precarg = get_query_var(_x('precargada','taxo-name','iol'));    
           }
            else{
                 $Result_precarg = _x('precargada','taxo-name','iol').'-se';
                 //$UndefinedTaxonomyDataSelector[] = 'input[name="precargada"]';
                }
            ?>
  <div class="ui-widget startsUgly" id="selectPrecargadaLente">
  <label class="labelTitle"><?php echo _x('Precargada','Right Archive Lente Intraocular','iol_cpt_display'); ?>:</label>
    <div id="precargadaFilter">
        <?php 
        $precargLente = get_terms(_x('precargada','taxo-name','iol'));

        if  ($precargLente) {
            foreach ($precargLente as $taxonomyprecargLente ) {

                if($taxonomyprecargLente->slug == _x('si','taxo-value-slug','iol-scaffold'))
                {
                    
                 if($taxonomyprecargLente->slug == $Result_precarg)
                    {
                     echo '<input type="radio" id="precargaSi" checked="checked" name="'._x('precargada','taxo-name','iol').'" value="'.$taxonomyprecargLente->slug.'" /><label for="precargaSi">'._x('Sí','Right Archive Lente Intraocular','iol_cpt_display').'</label>';
                    }    
                  else{
                     echo '<input type="radio" id="precargaSi" name="'._x('precargada','taxo-name','iol').'" value="'.$taxonomyprecargLente->slug.'" /><label for="precargaSi">'._x('Sí','Right Archive Lente Intraocular','iol_cpt_display').'</label>';  
                    }
                 }
                 if($taxonomyprecargLente->slug != _x('si','taxo-value-slug','iol-scaffold'))
                    {
                     if($taxonomyprecargLente->slug == $Result_precarg)
                       {
                         echo '<input type="radio" id="precargaNo" checked="checked" name="'._x('precargada','taxo-name','iol').'" value="'.$taxonomyprecargLente->slug.'" /><label for="precargaNo">'._x('No','Right Archive Lente Intraocular','iol_cpt_display').'</label>';
                       }
                      else{
                         echo '<input type="radio" id="precargaNo" name="'._x('precargada','taxo-name','iol').'" value="'.$taxonomyprecargLente->slug.'" /><label for="precargaNo">'._x('No','Right Archive Lente Intraocular','iol_cpt_display').'</label>';
                       }
                    }
                }
                if($Result_precarg == _x('precargada','taxo-name','iol').'-se'){
                   echo '<input type="radio" checked="checked" id="precarga-se" name="'._x('precargada','taxo-name','iol').'" value="'._x('precargada','taxo-name','iol').'-se" /><label for="precarga-se">'._x('S/E','Right Archive Lente Intraocular','iol_cpt_display').'</label>';
                }else{
                      echo '<input type="radio" id="precarga-se" name="'._x('precargada','taxo-name','iol').'" value="'._x('precargada','taxo-name','iol').'-se" /><label for="precarga-se">'._x('S/E','Right Archive Lente Intraocular','iol_cpt_display').'</label>';                    
                }
  
        } 
       ?>       
    </div>
  </div>
            <!-- Fin Inyector -->


            <!-- Inicio Combo diseño de Hápticos-->
                    
      <?php
     //Vamos a poner a sacar el material de la lente intraocular (Recordemos que hemos establecido una clasificación jerárquica).
       
						
       if(get_query_var(_x('diseno-hapticos','taxo-name','iol'))){
            $Result_DiseHaptic =  get_query_var(_x('diseno-Hapticos','taxo-name','iol'));
        }
         else{
            $Result_DiseHaptic = _x('diseno-hapticos','taxo-name','iol').'-se';
            //$UndefinedTaxonomyDataSelector[] = 'input[name="diseno-hapticos"]';
        }
     ?>    

            <div class="ui-widget startsUgly" id="comboDiseHapticos">
            <label class="labelTitle"><?php echo _x('Diseño Hápticos:','Right Archive Lente Intraocular','iol_cpt_display'); ?></label>
            <select id="comboboxDiseHaptic" name="<?php echo _x('diseno-hapticos','taxo-name','iol');?>">
    <?php
            //Notamos que $Result_fabricanteURL ya viene obtenido del Left Panel.
            $diseHaptics = get_terms(_x('diseno-hapticos','taxo-name','iol')); 
            if  ($diseHaptics) {
                if($Result_DiseHaptic == _x('diseno-hapticos','taxo-name','iol').'-se'){
                    echo '<option selected="selected" value = "'._x('diseno-hapticos','taxo-name','iol').'-se">'._x('Sin Especificar','Right Archive Lente Intraocular','iol_cpt_display').'</option>';
                }else{
                    echo '<option value = "'._x('diseno-hapticos','taxo-name','iol').'-se">'._x('Sin Especificar','Right Archive Lente Intraocular','iol_cpt_display').'</option>';
                }
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
                 echo '<option value = "diseno-hapticos-se" selected="selected">'._x('Sin Especificar','Right Archive Lente Intraocular','iol_cpt_display').'</option>';
             }
  ?>
   </select>
   </div>    
            <!-- Fin Combo diseño de Hápticos-->
            </div>
  </div>

  <!-- Inicio del Surgeon Accordion-->

          <!-- Inicio del Filtro de cirujanos-->
 <div id="surgeonAccordionFilter">
     <h3> <span class="title-filter"><?php echo _x('Asfericid., Diámetros...','Right Archive Lente Intraocular','iol_cpt_display'); ?></span> 
     <span id="dragger-surgeonAccordionFilter" class="ui-icon ui-icon-arrow-4-diag startsUgly">&nbsp;</span>
     <span id="reseter-surgeonAccordionFilter" class="ui-icon ui-icon-refresh startsUgly">&nbsp;</span>
     </h3>
     
     <div>
         <div class="spanH4Wrapper startsUgly">
            <span id="spanSurgeonFilDisabler" class="startsUgly"><?php echo _x('No aplicar estos filtros:','Right Archive Lente Intraocular','iol_cpt_display'); ?> </span> <button id="surgeonFiltersDisabler"> Surgeon Filters Disabler </button>
            <span style=" clear: both; height: 4px;"  class="startsUgly"></span> 
            <span id="spanSurgeonFilEnabler"  class="startsUgly"><?echo _x('Aplicar estos filtros:','Right Archive Lente Intraocular','iol_cpt_display'); ?></span> <button id="surgeonFiltersEnabler">Surgeon Filters Enabler</button> 
            <span style=" clear: both;"  class="startsUgly"></span>
            
            <h4><?php echo _x('Rangos Dióptricos','Right Archive Lente Intraocular','iol_cpt_display'); ?></h4>
          </div>
            <!-- Valores Máximos-Mínimos de Esfera -->
              <?php 
           if(get_query_var('dioptEsfD')){//dioptEsfMV
                $dEsf = get_query_var('dioptEsfD');//dioptEsfMV
            //Primero sacamos los 2 límites y luego con meta_query hacemos la query.
            $pos = strpos($dEsf, ' ');
            $esfDesde = substr($dEsf, 0, $pos);
           
            $last_space = strrpos($dEsf, ' ');
            $pos_guion = strpos($dEsf, '-',strpos($dEsf,'diop'));
            $dioptEsf_sup_lenght = $last_space - $pos_guion - 2;
         
            $esfHasta =substr($dEsf, $pos_guion +2 , $dioptEsf_sup_lenght);
            }
              else{

                  $esfDesde = '';
                  $esfHasta = '';
				  //$UndefinedMetaDataSelector[] = '#amount-esfera';
              }

                   //Esfera Desde.
              if($esfDesde == '')
                 {
                     $esf_desde = -30;
                 }
                 else{
                     $esf_desde = $esfDesde;// - 2.5; //0.25                    
                 }
              //Esfera Hasta.
              if($esfHasta == '')
                 {
                     $esf_hasta = 60;
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

            <div class="ui-widget startsUgly slideWButton" id="sliderRangeSphLens">
            <label for="amount-esfera" class="labelTitle"><?php echo _x('Rango Dioptrías Esfera:','Right Archive Lente Intraocular','iol_cpt_display'); ?></label>
            <button id="dioptEsfDisabler">dioptEsf Disabler</button>
            
            <input type="text" id="amount-esfera" style="border: 0; " name="dioptEsfD" />
            <div id="slider-range-esfera"></div>
            </div>          
              

            <!-- Fin valores máximos mínimos de esfera-->

             <!-- Valores Máximos-Mínimos de Cilindro -->

              <?php 
            if(get_query_var('dioptCilD')){
                $dCil = get_query_var('dioptCilD');
              //Primero sacamos los 2 límites y luego con meta_query hacemos la query.
                    $pos = strpos($dCil, ' ');
                    $cilDesde = substr($dCil, 0, $pos);
                
                    $last_space = strrpos($dCil, ' ');
                    $pos_guion = strpos($dCil, '-',strpos($dCil,'diop'));
                    $dioptCil_sup_lenght = $last_space - $pos_guion - 2;
         
                    $cilHasta =substr($dCil, $pos_guion +2 , $dioptCil_sup_lenght);
                }
                else{
                    $cilDesde = '';
                    $cilHasta = '';
                    
                    //$UndefinedMetaDataSelector[] = '#amount-cilinder'; 
                }
              
              //Esfera Desde.
              if($cilDesde == '')
                 {
                     $cil_desde = -10;
                 }
                 else{
                     $cil_desde = $cilDesde;// - 2.5; //0.25                   
                 }
              //Esfera Hasta.
              if($cilHasta == '')
                 {
                     $cil_hasta = 10;
                 }
                 else{
                     $cil_hasta = $cilHasta;// + 2.5;//0.25             
                 }
            ?>

            <?php 
            //Almacenamos los valores del diametro de óptica en sendas variables javascript.
             echo '<script>';
                    echo 'var rangeMinfCil ='.$cil_desde.';'; 
                    echo 'var rangeMsupCil ='.$cil_hasta.';'; 
             echo '</script>';
             ?> 

            <div class="ui-widget startsUgly slideWButton" id="sliderRangeCilLens">
            <label for="amount-cilinder" class="labelTitle"><?php echo _x('Rango Dioptrías Cilndro:','Right Archive Lente Intraocular','iol_cpt_display'); ?></label>
            <button id="dioptCilDisabler">dioptCil Disabler</button>
            
            <input type="text" id="amount-cilinder" style="border: 0; " name="dioptCilD" />
            <div id="slider-range-cilinder"></div>
            </div>

            <?php /*
            echo '<script>
                     jQuery(function() {
                           jQuery("#slider-range-cilinder").slider("values",0,'. $cil_desde .'); // sets second handle (index 1) to 80
                           jQuery("#slider-range-cilinder").slider("values",1,'. $cil_hasta.'); // sets second handle (index 1) to 80  
                           jQuery( "#amount-cilinder" ).val( '.$cil_desde.'+" diopt - "+'. $cil_hasta.'+" diopt" );
                     });  
                  </script>';*/
             ?>
              
            <!-- Fin valores máximos mínimos de esfera-->


                     <!-- 4 Asfericidad -Slider -->
                   <?php 
              if(get_query_var('asfericiD')){
                $asf = get_query_var('asfericiD');
                //Primero sacamos los 2 límites y luego con meta_query hacemos la query.
                $pos = strpos($asf, ' ');
                $asferic_inf = substr($asf, 0, $pos);
               

                $last_space = strrpos($asf, ' ');
                //Estamos teniendo problemas con los Negativos :) porque luego son detectados como guion

                $pos_guion = strpos($asf, '-',strpos($asf,'um'));
                $asferic_sup_lenght = $last_space - $pos_guion - 2;
         
                 $asferic_sup =substr($asf, $pos_guion +2 , $asferic_sup_lenght);
                
                 $asferic = ($asferic_inf + $asferic_sup)/2;
             }
             else{
                 $asferic ='';
                 //$UndefinedMetaDataSelector[] = '#amount-asferic';

             }


              if($asferic == '')
                 {
                     $minf_asf = 0;
                     $msup_asf = 1;
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

            <div class="ui-widget startsUgly slideWButton" id="sliderAsphLens">
            <label for="amount-asferic" class="labelTitle"><?php echo _x('Asfericidad:','Right Archive Lente Intraocular','iol_cpt_display'); ?></label>
            <button id="asfericityDisabler">TotalDiameter Disabler</button>
            
            <input type="text" id="amount-asferic" style="border: 0; " name="asferic" />
            <div id="slider-range-asferic"></div>
            </div>

            <?php /*
            echo '<script>
                     jQuery(function() {
                           jQuery("#slider-range-asferic").slider("values",0,'. $minf_asf .'); // sets second handle (index 1) to 80
                           jQuery("#slider-range-asferic").slider("values",1,'. $msup_asf.'); // sets second handle (index 1) to 80  
                           jQuery( "#amount-asferic" ).val( '.$minf_asf.'+" um - "+'. $msup_asf.'+" um" );
                           
                     });  
                  </script>';*/
             ?>
              

            <!-- Fin 4 Asfericidad -->

                    <!-- 1 Diámetro de Óptica-->
            <?php 
                      
             if(get_query_var('diamOpticD')){
                //Primero sacamos los 2 límites y luego con meta_query hacemos la query.
                 $dOptic =get_query_var('diamOpticD');
                 //echo  '<br />'.$dOptic.'<br />';
                 $pos = strpos($dOptic, ' ');
                 $diamOpt_inf = substr($dOptic, 0, $pos);
        
                 $last_space = strrpos($dOptic, ' ');
                 $pos_guion = strpos($dOptic, '-');
                 $diamOpt_sup_lenght = $last_space - $pos_guion - 1;
         
                 $diamOpt_sup =substr($dOptic, $pos_guion +1 , $diamOpt_sup_lenght);

                 //echo  '<br />'.$diamOpt_sup.'<br />';
                 //echo  '<br />'.$diamOpt_inf.'<br />';
                 //$Result_Add = ($add_inf + $add_sup)/2;
                 //$diamOptic = ($diamOpt_inf + $diamOpt_sup)/2;
                 //echo  '<br />'.$diamOptic.'<br />';
                 }
                 else{
                         $dOptic=''; 
                         //$UndefinedMetaDataSelector[] = '#amount-diamOptic';

                         
                 }
              if($dOptic == '')
                 {
                     $minf_doptic = 2.5;
                     $msup_doptic = 10;
                 }
                 else{
                     $minf_doptic = $diamOpt_inf;//$diamOptic - 2.5;//0.1
                     $msup_doptic = $diamOpt_sup;//$diamOptic + 2.5;                     
                 }
            ?>
            
            <?php 
            //Almacenamos los valores del diametro de óptica en sendas variables javascript.
             echo '<script>';
                    echo 'var rangeMinfDoptic ='.$minf_doptic.';'; 
                    echo 'var rangeMsupDoptic ='.$msup_doptic.';'; 
             echo '</script>';
             ?>  

            <div class="ui-widget startsUgly slideWButton" id="sliderOpticDiamLens">
            <label for="amount-diamOptic" class="labelTitle"><?php echo _x('Diámetro de Óptica:','Right Archive Lente Intraocular','iol_cpt_display'); ?></label>
            <button id="opticDiameterDisabler">OpticDiameter Disabler</button>
           
            <input type="text" id="amount-diamOptic" style="border: 0; " name="diamOpticD" />
            <div id="slider-range-diamOptic"></div>
            </div>

            <!-- Fin 1 Diámetro de Óptica-->

           <!-- 2 Diámetro Total-->
            <?php 
              
        if(get_query_var('diamTotD')){//Primero sacamos los 2 límites y luego con meta_query hacemos la query.
            $dTot = get_query_var('diamTotD');
            $pos = strpos($dTot, ' ');
            $diamTot_inf = substr($dTot, 0, $pos);
            //echo '<p>a'.$diamTot_inf.'a</p>';       
            $last_space = strrpos($dTot, ' ');
            $pos_guion = strpos($dTot, '-');
            $diamTot_sup_lenght = $last_space - $pos_guion - 1;
            $diamTot_sup =substr($dTot, $pos_guion +2 , $diamTot_sup_lenght-1);
                
            $diamTot = ($diamTot_inf + $diamTot_sup)/2;
             }
             else{
                 $diamTot = '';
                 //$UndefinedMetaDataSelector[] = '#amount-diamTot';
             }
             
              if($diamTot == '')
                 {
                     $minf_dtot = 7;
                     $msup_dtot = 15;
                 }
                 else{
                     $minf_dtot = $diamTot_inf;//$diamTot - 2.5;//0.1
                     $msup_dtot = $diamTot_sup;//$diamTot + 2.5;                     
                 }
            ?>

            <?php 
             //Almacenamos los valores del diametro total en sendas variables javascript.
             echo '<script>';
                    echo 'var rangeMinfDtot ='.$minf_dtot.';'; 
                    echo 'var rangeMsupDtot ='.$msup_dtot.';'; 
             echo '</script>';
             ?>  

            <div class="ui-widget startsUgly lastAccordionInput slideWButton" id="sliderTotDiamLens">
            <label for="amount-diamTot" class="labelTitle"><?php echo _x('Diámetro Total:','Right Archive Lente Intraocular','iol_cpt_display'); ?></label>
            <button id="totalDiameterDisabler">TotalDiameter Disabler</button>
            
            <input type="text" id="amount-diamTot" style="border: 0; " name="diamTotD" />
            <div id="slider-range-diamTot"></div>
            </div>

            <!-- Fin 2 Diámetro Total-->

            <!-- Tamaño de Inicisión-->
            <?php 
              
        if(get_query_var('tamaInciD')){//Primero sacamos los 2 límites y luego con meta_query hacemos la query.
            //echo 'Efectivamente está asignada la variable de Tamaño de Incisión con un valor de:'.get_query_var('tamaInciD');
            $tamInci = get_query_var('tamaInciD');
            $pos = strpos($tamInci, ' ');//posición del primer espacio
            $tamInci_inf = substr($tamInci, 0, $pos);
            //echo '<p>a'.$diamTot_inf.'a</p>';       
            $last_space = strrpos($tamInci, ' ');
            $pos_guion = strpos($tamInci, '-');
            $tamInci_sup_lenght = $last_space - $pos_guion - 1;
            $tamInci_sup =substr($tamInci, $pos_guion +2 , $tamInci_sup_lenght-1);
                
            $tamInci = ($tamInci_inf + $tamInci_sup)/2;
             }
             else{
                 $tamInci = '';
                 //$UndefinedMetaDataSelector[] = '#amount-tamaInci';
             }
             
              if($tamInci == '')
                 {
                     $minf_tamInci = 1.6;
                     $msup_tamInci = 5;
                 }
                 else{
                     $minf_tamInci = $tamInci_inf;//$diamTot - 2.5;//0.1
                     $msup_tamInci = $tamInci_sup;//$diamTot + 2.5;                     
                 }
            ?>

            <?php 
             //Almacenamos los valores del diametro total en sendas variables javascript.
             echo '<script>';
                    echo 'var rangeMinfTInci ='.$minf_tamInci.';'; 
                    echo 'var rangeMsupTInci ='.$msup_tamInci.';'; 
             echo '</script>';
             ?>  

            <div class="ui-widget startsUgly lastAccordionInput slideWButton" id="sliderIncisionSizeLens">
            <label for="amount-tamaInci" class="labelTitle"><?php echo _x('Tamaño de Incisión:','Right Archive Lente Intraocular','iol_cpt_display'); ?></label>
            <button id="tamaInciDisabler">Tamaño Incision Disabler</button>
            
            <input type="text" id="amount-tamaInci" style="border: 0; " name="tamaInciD" />
            <div id="slider-range-tamaInci"></div>
            </div>

            <!-- Fin del tamaño de Inicisión-->





     </div>
</div>
  <!-- Fin del Surgeon Accordion -->

   </form>
   

