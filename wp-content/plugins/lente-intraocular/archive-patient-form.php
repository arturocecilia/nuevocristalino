
   <!-- Prueba para saber si la added_query_var puede coincidir con un taxo_slug -->

<?php //Sacamos la página destino del formulario.
    //Nos olvidamos de lo anterior => Vamos a pivotar todo el rato sobre la página archive de lentes intraoculares.

    $iolCptName = _x('lente-intraocular','CustomPostType Name','iol');

    $linkToIolArchive = get_post_type_archive_link( $iolCptName );

?>

<!-- Inicio de Extracción de valores Seleccionados -->
<?php 


//Vamos cargando los valores en las variables
$dOptTN = _x('diseno-optica','taxo-name','iol');

if(array_key_exists($dOptTN,$_GET)){
	$disenoOpticaTerm = $_GET[$dOptTN];
}else{
	$disenoOpticaTerm ='se';
}

$tlentTN = _x('tipo-lente-intraocular','taxo-name','iol');
if(array_key_exists($tlentTN,$_GET)){
	$tipoIolTerm = $_GET[$tlentTN];
}else{
	$tipoIolTerm = 'se';
}

$pFormAttrText = array();
//$pFormAttrTextKeys = array('monoText','monoAsfText','multiBiText','multiTriText','acomodativaText','aplText','toricaText','noToricaText','luzAzulText','luzUltravioletaText', 'addOnMonofocalText','addOnMultifocalText', 'iclText','verisyseText');
$check = 'checked="checked"';
$empty = '';

$notPseudofaquicaSlugs = array(_x('add-on','taxo-value-name','iol-scaffold'),
                               _x('faquica','taxo-value-name','iol-scaffold'),
                               _x('icl','taxo-value-name','iol-scaffold'),
                               _x('cachet','taxo-value-name','iol-scaffold'),
                               _x('verisyse','taxo-value-name','iol-scaffold'));

$pseudo = !in_array($tipoIolTerm,$notPseudofaquicaSlugs);
//Inputs dependientes de la taxonomía diseño de óptica

//monofocal => monoText
if($disenoOpticaTerm == _x('monofocal','taxo-value-slug','iol-scaffold') && $pseudo){
				$pFormAttrText['monoText'] = $check; 
				}else{
				$pFormAttrText['monoText'] =$empty;	
				}
				
//monofoca asférica => monoAsfText
if($disenoOpticaTerm == _x('monofocal-asferica','taxo-value-slug','iol-scaffold')  && $pseudo){
				$pFormAttrText['monoAsfText'] = $check;
				}else{
				$pFormAttrText['monoAsfText'] = $empty;
				}
				
//multifocal bifocal => multiBiText
if($disenoOpticaTerm == _x('multifocal-bifocal','taxo-value-slug','iol-scaffold') || $disenoOpticaTerm == _x('multifocal-bifocal-asferica','taxo-value-slug','iol-scaffold') || $disenoOpticaTerm == _x('multifocal-bifocal-esferica','taxo-value-sllug','iol-scaffold')  && $pseudo){
				$pFormAttrText['multiBiText']  = $check;
				}else{
				$pFormAttrText['multiBiText']  = $empty;
				}
//multifocal trifocal => multiTriText		
if($disenoOpticaTerm == _x('multifocal-trifocal','taxo-value-slug','iol-scaffold') || $disenoOpticaTerm == _x('multifocal-trifocal-asferica','taxo-value-slug','iol-scaffold') ||$disenoOpticaTerm == _x('multifocal-trifocal-esferica','taxo-value-slug','iol-scaffold')  && $pseudo){
				$pFormAttrText['multiTriText'] = $check;
				}else{
				$pFormAttrText['multiTriText'] = $empty;
				}
				
//añadimos el de sólo multifocal				
if($disenoOpticaTerm == _x('multifocal','taxo-value-slug','iol-scaffold') || $disenoOpticaTerm == _x('multifocal-trifocal','taxo-value-slug','iol-scaffold') || $disenoOpticaTerm == _x('multifocal-trifocal-asferica','taxo-value-slug','iol-scaffold') ||$disenoOpticaTerm == _x('multifocal-trifocal-esferica','taxo-value-slug','iol-scaffold')  && $pseudo){
				$pFormAttrText['multifocal'] = $check;
				}else{
				$pFormAttrText['multifocal'] = $empty;
				}


				
//acomodativa => acomodativaText
if($disenoOpticaTerm ==_x('acomodativa','taxo-value-name','iol-scaffold')  && $pseudo){
				$pFormAttrText['acomodativaText'] = $check;
				}else{
				$pFormAttrText['acomodativaText'] = $empty;
				}
//ajustable por luz => aplText
if($disenoOpticaTerm == _x('ajustable-por-luz','taxo-value-name','iol-scaffold')  && $pseudo){
				$pFormAttrText['aplText'] = $check;
				}else{
				$pFormAttrText['aplText'] = $empty;
				}

//Inputs dependientes de la taxonomía toricidad.
if(array_key_exists(_x('toricidad','taxo-name','iol'),$_GET)){ //NO VA EL TAXO NAME EN TORICIDAD PORQUE SE PA
	$toricidadTerm = $_GET[_x('toricidad','taxo-name','iol')];
    
}else{
	$toricidadTerm = 'se';
}


	if($toricidadTerm == _x('torica','taxo-value-slug','iol-scaffold')){
			$pFormAttrText['toricaText'] = $check;
			}else{
			$pFormAttrText['toricaText'] = $empty;
			}
			
	if($toricidadTerm == _x('no-torica','taxo-value-slug','iol-scaffold')){
			$pFormAttrText['noToricaText'] = $check;
			}else{
			$pFormAttrText['noToricaText'] = $empty;
			}
							

//Inputs dependientes de la taxonomía de filtros.
	if(array_key_exists(_x('luz-azul','taxo-value-slug','iol-scaffold'),$_GET)){
		$luzAzulTerm = $_GET['luz-azul'];
			}else{
		$luzAzulTerm = 'se';
		}

	if(array_key_exists(_x('luz-ultravioleta','taxo-value-slug','iol-scaffold'),$_GET)){
		$luzUltravioletaTerm = $_GET['luz-ultravioleta'];
			}else{
		$luzUltravioletaTerm = 'se';
		}
		

	if($luzAzulTerm == _x('luz-azul','taxo-value-slug','iol-scaffold')){
			$pFormAttrText['luzAzulText'] = $check;
			}else{
			$pFormAttrText['luzAzulText'] = $empty;
			}
	
	if($luzUltravioletaTerm == _x('luz-ultravioleta','taxo-value-slug','iol-scaffold')){
			$pFormAttrText['luzUltravioletaText'] = $check;
			}else{
			$pFormAttrText['luzUltravioletaText'] = $empty;
			}		


//inputs add-on=> ha de cumplir simultáneamente tipo-lente-intraocular= add-on y el de diseno-optica

	if( $tipoIolTerm == _x('add-on','taxo-value-slug','iol-scaffold') && $disenoOpticaTerm == _x('monofocal','taxo-value-slug','iol-scaffold')){
		$pFormAttrText['addOnMonofocalText'] = $check;
	}else{
		$pFormAttrText['addOnMonofocalText'] = $empty;
	}
	
	if($tipoIolTerm == _x('add-on','taxo-value-slug','iol-scaffold') && $disenoOpticaTerm == _x('multifocal','taxo-value-slug','iol-scaffold')){
		$pFormAttrText['addOnMultifocalText'] = $check; 
	}else{
		$pFormAttrText['addOnMultifocalText'] = $empty;
	}


//Vamos a por los inputs de icl y de verisyse

	if($tipoIolTerm == _x('icl','taxo-value-slug','iol-scaffold')){
		$pFormAttrText['iclText'] = $check;
	}else{
		$pFormAttrText['iclText'] = $empty;
	}

	if($tipoIolTerm == _x('verisyse','taxo-value-slug','iol-scaffold')){
		$pFormAttrText['verisyseText'] = $check;
	}else{
		$pFormAttrText['verisyseText'] = $empty;
	}

?>
<!-- Fin Extracción de valores seleccionados -->

  <h2> <?php echo _x('BUSCADOR BÁSICO:','Archive Patient Form','iol_cpt_display'); ?></h2>      
  <form id="patient_iol_filter_form" method="get" action="<?php echo $linkToIolArchive.'?t=1'; ?>"><?PHP //QUITAMOS LAS REFERENCIAS A PT=YES ?>

   <input type="button" value="<?php  echo _x('Realizar Filtrado','Archive Patient Form','iol_cpt_display');?>" class="submitSingle" onClick="patient_submit_me();" />     

 <!-- <input name="action"  type="hidden" value="filter_result" /> --> <!-- this puts the action the_ajax_hook into the serialized form -->

<!-- Vamos a añadir este hidden input para llevar a cabo la paginación -->
<input name="action" type="hidden" value="filter_result" />

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
  <div class="ui-widget patient startsUgly" id="comboViewType">
  <span id="titleViewType"><?php   echo _x('Vista:','Archive Patient Form','iol_cpt_display');?></span>
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





  <!-- Inicio del Filtro de usuarios normales-->
 <div id="PatientAccordionFilter">
     <h3> <?php echo _x('Filtro para Pacientes','Archive Patient Form','iol_cpt_display'); ?> </h3>
     <div>

  <div id="estandar" class ="ui-widget startsUgly"> <!-- -->
  <label><?php echo _x('Lente Intraocular Estándar:','Archive Patient Form','iol_cpt_display');?><br /></label>
      <input type="radio" <?php echo $pFormAttrText['monoText']; ?> id="pf-monofocal" data-taxo="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" data-value="<?php echo _x('monofocal','taxo-value-slug','iol-scaffold'); ?>" name="button-monofocal" value="button-monofocal-value"><label for="pf-monofocal"><?php echo _x('Monofocal','taxo-value-name','iol-scaffold'); ?></label><!-- </input> -->
  </div>
   
  <div id="premium" class ="ui-widget startsUgly">
  <label><?php echo _x('Lente Intraocular Premium:','Archive Patient Form','iol_cpt_display');?><br /></label>
     <div id="premiumInputs">
        
      <?php if(1){ /*current_user_can('manage_options')*/ ?>  
      <input type="radio" id="monofocal-asferica" <?php echo $pFormAttrText['monoAsfText']; ?> name="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" value="<?php echo  _x('monofocal-asferica','taxo-value-slug','iol-scaffold'); ?>"><label for="monofocal-asferica"><?php echo _x('Monofocal Asférica','Patient Form','iol_cpt_display'); ?></label><!-- </input> -->    
      <input type="radio" id="multifocal" <?php echo $pFormAttrText['multifocal']; ?> name="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" value="<?php echo _x('multifocal','taxo-value-slug','iol-scaffold'); ?>"><label for="multifocal"><?php echo _x('Multifocal','Patient Form','iol_cpt_display'); ?></label><!-- </input> --> 
      <input type="radio" id="acomodativa" <?php echo $pFormAttrText['acomodativaText']; ?> name="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" value="<?php echo _x('acomodativa','taxo-value-slug','iol-scaffold'); ?>"><label for="acomodativa"><?php echo _x('Acomodativa','Patient Form','iol_cpt_display'); ?></label><!-- </input> -->
      <input type="radio" id="ajustable-por-luz" <?php echo $pFormAttrText['aplText']; ?> name="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" value="<?php echo _x('ajustable-por-luz','taxo-value-slug','iol-scaffold'); ?>"><label for="ajustable-por-luz"><?php echo _x('Ajustable por luz','Patient Form','iol_cpt_display'); ?></label><!-- </input> -->
        
       <?php }else{ ?> 
        
      <input type="radio" id="monofocal-asferica" <?php echo $pFormAttrText['monoAsfText']; ?> name="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" value="<?php echo  _x('monofocal-asferica','taxo-value-slug','iol-scaffold'); ?>"><label for="monofocal-asferica"><?php echo _x('Monofocal Asférica','Patient Form','iol_cpt_display'); ?></label><!-- </input> -->
      <input type="radio" id="multifocal-bifocal" <?php echo $pFormAttrText['multiBiText']; ?> name="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" value="<?php echo _x('multifocal-bifocal','taxo-value-slug','iol-scaffold'); ?>"><label for="multifocal-bifocal"><?php echo _x('Multifocal Bifocal','Patient Form','iol_cpt_display'); ?></label><!-- </input> -->     
      <input type="radio" id="multifocal-trifocal" <?php echo $pFormAttrText['multiTriText']; ?> name="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" value="<?php echo _x('multifocal-trifocal','taxo-value-slug','iol-scaffold'); ?>"><label for="multifocal-trifocal"><?php echo _x('Multifocal Trifocal','Patient Form','iol_cpt_display'); ?></label><!-- </input> --> 
      <input type="radio" id="acomodativa" <?php echo $pFormAttrText['acomodativaText']; ?> name="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" value="<?php echo _x('acomodativa','taxo-value-slug','iol-scaffold'); ?>"><label for="acomodativa"><?php echo _x('Acomodativa','Patient Form','iol_cpt_display'); ?></label><!-- </input> -->
      <input type="radio" id="ajustable-por-luz" <?php echo $pFormAttrText['aplText']; ?> name="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" value="<?php echo _x('ajustable-por-luz','taxo-value-slug','iol-scaffold'); ?>"><label for="ajustable-por-luz"><?php echo _x('Ajustable por luz','Patient Form','iol_cpt_display'); ?></label><!-- </input> -->
     <?php } ?>
     </div>
  </div>
  
  
  
  <div id="correccionAstig" class ="ui-widget startsUgly">
  <label><?php echo _x('Corrección para Astigmatismo','Patient Form','iol_cpt_display');?><br /></label>
    <div id="correcAstigInputs">
      <input type="radio" id="correcAstigSi" <?php echo $pFormAttrText['toricaText']; ?> name="<?php echo _x('toricidad','taxo-name','iol'); ?>" value="<?php echo _x('torica','taxo-value-slug','iol-scaffold'); ?>"><label for="correcAstigSi"><?php echo  _x('Sí','Patient Form','iol_cpt_display'); ?></label><!-- </input> -->
      <input type="radio" id="correcAstigNo" <?php echo $pFormAttrText['noToricaText']; ?> name="<?php echo _x('toricidad','taxo-name','iol'); ?>" value="<?php echo _x('no-torica','taxo-value-slug','iol-scaffold'); ?>"><label for="correcAstigNo"><?php echo _x('No','Patient Form','iol_cpt_display'); ?></label><!-- </input> -->
    </div>
  </div>

  <div id="filtros" class ="ui-widget startsUgly">
  <label class="filtrosLabel"><?php echo _x('Filtros de la Lente:','Patient Form','iol_cpt_display');?><br /></label>
    <div id="filtrosInputs">
      <input type="checkbox" id="luz-ultravioleta" <?php echo $pFormAttrText['luzUltravioletaText']; ?> name="<?php echo _x('luz-ultravioleta','taxo-value-slug','iol-scaffold'); ?>" value="<?php echo _x('luz-ultravioleta','taxo-value-slug','iol-scaffold'); ?>"><label for="luz-ultravioleta"><?php echo _x('Ultravioleta','Patient Form','iol_cpt_display'); ?></label><!-- </input> -->
      <input type="checkbox" id="luz-azul"  <?php echo $pFormAttrText['luzAzulText']; ?> name="<?php echo _x('luz-azul','taxo-value-slug','iol-scaffold'); ?>" value="<?php echo _x('luz-azul','taxo-value-slug','iol-scaffold');?>"><label for="luz-azul"><?php echo _x('Luz Azul','Patient Form','iol_cpt_display'); ?><br /><?php echo _x('Protección Mácular','Patient Form','iol_cpt_display'); ?></label><!-- </input> -->
    </div>
  </div>

  <div id="add-on" class ="ui-widget startsUgly">
  <label class="add-on-label"><?php echo _x('Add On:','Patient Form','iol_cpt_display');?><br /></label>
    <div id="add-onInputs">
      <input type="radio" <?php echo $pFormAttrText['addOnMonofocalText']; ?> data-taxo1="<?php echo _x('tipo-lente-intraocular','taxo-name','iol'); ?>" data-value1="<?php echo _x('add-on','taxo-value-slug','iol-scaffold'); ?>" data-taxo2="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" data-value2="<?php echo _x('monofocal','taxo-value-slug','iol-scaffold'); ?>" id="add-on-monofocal" name="button-add-on" value="button-add-on-mono-value"><label for="add-on-monofocal"><?php echo _x('Monofocal','Patient Form','iol_cpt_display'); ?></label><!-- </input> -->
      <input type="radio" <?php echo $pFormAttrText['addOnMultifocalText']; ?> data-taxo1="<?php echo _x('tipo-lente-intraocular','taxo-name','iol'); ?>" data-value1="<?php echo _x('add-on','taxo-value-slug','iol-scaffold'); ?>" data-taxo2="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" data-value2="<?php echo _x('multifocal','taxo-value-slug','iol-scaffold'); ?>" id="add-on-multifocal" name="button-add-on" value="button-add-on-multi-value"><label for="add-on-multifocal"><?php echo _x('Multifocal','Patient Form','iol_cpt_display'); ?></label><!-- </input> -->
 <!-- 	<input type="hidden" disabled="disabled" id="ao-multifocal" name="diseno-optica" value="multifocal" />
    -->
    </div>
  </div>  

  <div id="iclContainer" class ="ui-widget startsUgly">
  <label class="icl-label"><?php echo _x('Lente Fáquica ICL:&nbsp;&nbsp;','Patient Form','iol_cpt_display');?><br /></label>
      <input type="radio" <?php echo $pFormAttrText['iclText']; ?> id="icl" name="button-icl" data-taxo="<?php echo _x('tipo-lente-intraocular','taxo-name','iol'); ?>" data-value="<?php echo _x('icl','taxo-value-slug','iol-scaffold'); ?>" value="button-icl-value"><label for="icl">ICL</label><!-- </input> -->
  </div>
  
  <div id="verisyseContainer" class ="ui-widget startsUgly">
  <label><?php echo _x('Lente Fáquica Verisyse:','Archive Patient Form','iol_cpt_display');?><br /></label>
      <input type="radio" <?php echo $pFormAttrText['verisyseText']; ?> id="verisyse" data-taxo="<?php echo _x('tipo-lente-intraocular','taxo-name','iol'); ?>" data-value="<?php echo _x('verisyse','taxo-value-slug','iol-scaffold'); ?>" name="button-verisyse" value="button-verisyse-value"><label for="verisyse">Verisyse</label><!-- </input> -->
  </div>
 
     </div>
      </div>
  <!-- Fin del Filtro de usuarios normales-->
	
   		<!-- Input para salida específica de pacientes -->
	<input type="hidden" name="nivel-pref-lente" value="5">	
   </form>


<?php
    //Div auxiliar que sólo lleva traducciones.
    echo '<div style="visibility:hidden;">';
        echo '<div id="tLente">'._x('tipo-lente-intraocular','taxo-name','iol').'</div>';
        echo '<div id="pseudo">'._x('pseudofaquica','taxo-value-slug','iol-scaffold').'</div>';
    echo '</div>';
?>