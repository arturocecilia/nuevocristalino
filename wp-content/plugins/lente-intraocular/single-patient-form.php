
   <!-- Prueba para saber si la added_query_var puede coincidir con un taxo_slug -->

<?php //Sacamos la página destino del formulario.
  // Try to get the page by the incoming title
   
    //Nos olvidamos de lo anterior => Vamos a pivotar todo el rato sobre la página archive de lentes intraoculares.

    $iolCPTN = _x('lente-intraocular','CustomPostType Name','iol');
    $linkToIolArchive = get_post_type_archive_link( $iolCPTN );


?>

  <h2> <?php echo _x('BUSCADOR DE LENTES PARA PACIENTES:','Single Patient Form','iol_cpt_display'); ?></h2>      
  <form id="patient_iol_filter_form" method="get" action="<?php echo $linkToIolArchive.'?t=1'; ?>"> <?php //Nos cargamos las referencias a ?pt=yes ?>

   <input type="button" value="<?php  echo _x('Realizar Filtrado','Right Archive Lente Intraocular','iol_cpt_display'); ?>" class="submitSingle" onClick="patient_submit_me();" />    

 <!-- <input name="action"  type="hidden" value="filter_result" /> --> <!-- this puts the action the_ajax_hook into the serialized form -->

<!-- Vamos a añadir este hidden input para llevar a cabo la paginación -->
<input name="action" type="hidden" value="filter_result" />

<!-- Las informaciones sobre la lente que van a estar en juego son: diseno-optica, toricidad, luz-azul, luz-ultravioleta, tipo-lente-intraocular -->

<!-- Como ya tenemos las opciones del filtro de partida, sólo hay que comprobar la presencia de valores y checkear o no el asociado -->

<!-- Empezamos por diseno-optica -->
<?php 


$disenoOpticaObjects = get_the_terms( $post->ID, _x('diseno-optica','taxo-name','iol' ));

//Necesitas incluir también los términos padres que son los que aparecen en el menú simplificado o bien incluir los hijos en el
//condicional.

$disenoOpticaTerms = wp_list_pluck($disenoOpticaObjects,'slug');
$disenoOpticaTermsIds = wp_list_pluck($disenoOpticaObjects,'term_id');

$tipoIolObjects = get_the_terms( $post->ID, _x('tipo-lente-intraocular','taxo-name','iol') );

$tipoIolTerms = wp_list_pluck($tipoIolObjects,'slug');

//var_dump($disenoOpticaTerms);




//Inputs dependientes de la taxonomía diseño de óptica
if(in_array( _x('pseudofaquica','taxo-value-slug','iol-scaffold') ,$tipoIolTerms) ||
   in_array(_x('lente-premium','taxo-value-slug','iol-scaffold') ,$tipoIolTerms)  || 
   in_array(_x('lente-estandar','taxo-value-slug','iol-scaffold') ,$tipoIolTerms)
   ){
    
         



	if(count($disenoOpticaTerms)){ //array_key_exists('diseno-optica',$disenoOpticaTerms)
			//monofocal



			if((in_array(_x('monofocal','taxo-value-slug','iol-scaffold'),$disenoOpticaTerms)) || (in_array(_x('monofocal-esferica','taxo-value-slug','iol-scaffold'),$disenoOpticaTerms)) ){

            	$monoText = 'checked="checked"';

			}
			else{
				$monoText ='';
			}


			//monofocal asférica
			if(in_array(_x('monofocal-asferica','taxo-value-slug','iol-scaffold'),$disenoOpticaTerms)){

                   if(current_user_can('manage_options')){
                      //  echo 'adslfjasdkfjasdjfasjfljfasjf';
                   }
				$monoAsfText = 'checked="checked"';



			}
			else{
				$monoAsfText ='';
			}
			//multifocal bifocal
			if(in_array(_x('multifocal-bifocal','taxo-value-slug','iol-scaffold'),$disenoOpticaTerms) || in_array(_x('multifocal-bifocal-asferica','taxo-value-slug','iol-scaffold'),$disenoOpticaTerms) ||in_array(_x('multifocal-bifocal-esferica','taxo-value-slug','iol-scaffold'),$disenoOpticaTerms)){
				$multiBiText = 'checked="checked"';


			}
			else{
				$multiBiText ='';
			}


			//multifocal trifocal
			if(in_array(_x('multifocal-trifocal','taxo-value-slug','iol-scaffold'),$disenoOpticaTerms) || in_array(_x('multifocal-trifocal-asferica','taxo-value-slug','iol-scaffold'),$disenoOpticaTerms) ||in_array(_x('multifocal-trifocal-esferica','taxo-value-slug','iol-scaffold'),$disenoOpticaTerms)){
				$multiTriText = 'checked="checked"';
			}
			else{
				$multiTriText ='';
			}
			
			//multifocal a secas
			if(in_array(_x('multifocal','taxo-value-slug','iol-scaffold'),$disenoOpticaTerms) || in_array(_x('multifocal-trifocal','taxo-value-slug','iol-scaffold'),$disenoOpticaTerms) || in_array(_x('multifocal-trifocal-asferica','taxo-value-slug','iol-scaffold'),$disenoOpticaTerms) ||in_array(_x('multifocal-trifocal-esferica','taxo-value-slug','iol-scaffold'),$disenoOpticaTerms)){
				$multifocalText = 'checked="checked"';
			}
			else{
				$multifocalText ='';
			}
			
			
			
			
			//acomodativa
			if(in_array(_x('acomodativa','taxo-value-slug','iol-scaffold'),$disenoOpticaTerms)){
				$acomodativaText = 'checked="checked"';
			}
			else{
				$acomodativaText ='';
			}
			//ajustable-por-luz
			if(in_array(_x('ajustable-por-luz','taxo-value-slug','iol-scaffold'),$disenoOpticaTerms)){
				$aplText = 'checked="checked"';
			}
			else{
				$aplText ='';
			}
			
	}
}
//Inputs dependientes de la taxonomía toricidad.


$toricidadIolObjects = get_the_terms( $post->ID, _x('toricidad','taxo-name','iol') );
$toricidadIolTerms = wp_list_pluck($toricidadIolObjects,'slug'); 

if(count($toricidadIolTerms)){
		if(in_array(_x('torica','taxo-value-slug','iol-scaffold'),$toricidadIolTerms)){
			$toricaText = 'checked="checked"';
		}else{
			$toricaText ="";
		}
		
		if(in_array(_x('no-torica','taxo-value-slug','iol-scaffold'),$toricidadIolTerms)){
			$noToricaText = 'checked="checked"';
		}else{
			$noToricaText ="";
		}
}

//Inputs dependientes de la taxonomía de filtros.

$filtrosObjects = get_the_terms($post->ID, _x('filtros','taxo-name','iol'));
$filtrosTerms = wp_list_pluck($filtrosObjects,'slug'); 

if(count($filtrosTerms)){
		if(in_array(_x('luz-azul','taxo-value-slug','iol-scaffold'),$filtrosTerms)){
			$luzAzulText = 'checked="checked"';
		}else{
			$luzAzulText ="";
		}
		
		if(in_array(_x('luz-ultravioleta','taxo-value-slug','iol-scaffold'),$filtrosTerms)){
			$luzUltravioletaText = 'checked="checked"';
		}else{
			$luzUltravioletaText ="";
		}
}

//inputs add-on=> ha de cumplir simultáneamente tipo-lente-intraocular= add-on y el de diseno-optica

if(count($disenoOpticaTerms) && count($tipoIolTerms)){

    if(current_user_can('manage_options')){
      //  var_dump($disenoOpticaTerms);
      //  var_dump($tipoIolTerms);
    }

    //Sacamos el ID del término monofocal.
    $idMonoTerm = get_term_by( 'slug', _x('monofocal','taxo-value-slug','iol-scaffold'), _x('diseno-optica','taxo-name','iol') ); 
    
    //Sacamos una array con los term_IDs de los hijos de multifocal.
    $arrayMonoValues = get_term_children($idMonoTerm->term_id , _x('diseno-optica','taxo-name','iol') );

    //Cruzamos el array anterior con los Ids de los términos de la taxonomía disno-optica que tiene la lente.

	if(in_array(_x('add-on','taxo-value-slug','iol-scaffold'),$tipoIolTerms) && array_intersect ( $disenoOpticaTermsIds , $arrayMonoValues)){ //in_array(_x('monofocal','taxo-value-slug','iol-scaffold'), $disenoOpticaTerms)
		$addOnMonofocalText = 'checked="checked"';
	}else{
		$addOnMonofocalText = '';
	}
	
    /*$arrayMultiValues = array(    _x('multifocal-bifocal-asferica','taxo-value-slug','iol-scaffold'),
                                    _x('multifocal-bifocal-esferica','taxo-value-slug','iol-scaffold'),
                                    _x('multifocal-trifocal-esferica','taxo-value-slug','iol-scaffold'),
                                    _x('multifocal-trifocal-asferica','taxo-value-slug','iol-scaffold'));*/

    //Sacamos el ID del término multifocal.
    $idMultiTerm = get_term_by( 'slug', _x('multifocal','taxo-value-slug','iol-scaffold'), _x('diseno-optica','taxo-name','iol') ); 
    
    //Sacamos una array con los term_IDs de los hijos de multifocal.
    $arrayMultiValues = get_term_children($idMultiTerm->term_id , _x('diseno-optica','taxo-name','iol') );


	if(in_array(_x('add-on','taxo-value-slug','iol-scaffold'),$tipoIolTerms) && array_intersect ( $disenoOpticaTermsIds , $arrayMultiValues)){ //in_array(_x('multifocal','taxo-value-slug','iol-scaffold'),$disenoOpticaTerms)
		$addOnMultifocalText = 'checked="checked"'; 
	}else{
		$addOnMultifocalText = '';
	}
}
//Vamos a por los inputs de icl y de verisyse
if(count($tipoIolTerms)){
	if(in_array(_x('icl','taxo-value-slug','iol-scaffold'),$tipoIolTerms)){
		$iclText = 'checked="checked"';
	}else{
		$iclText = '';
	}

	if(in_array(_x('verisyse','taxo-value-slug','iol-scaffold'),$tipoIolTerms)){
		$verisyseText = 'checked="checked"';
	}else{
		$verisyseText = '';
	}


}


	
?>



 <div id="PatientAccordionFilter">
     <h3> <?php echo _x('Filtro para Pacientes','Single Patient Form','iol_cpt_display'); ?> </h3>
     <div>

  <div id="estandar" class ="ui-widget startsUgly"> <!-- -->
  <label><?php echo _x('Lente Intraocular Estándar:','Single Patient Form','iol_cpt_display');?><br /></label>
      <input type="radio" <?php echo $monoText; ?> id="pf-monofocal" data-taxo="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" data-value="<?php echo _x('monofocal','taxo-value-slug','iol-scaffold'); ?>" name="button-monofocal" value="button-monofocal-value"><label for="pf-monofocal"><?php echo _x('Monofocal','Single Patient Form','iol_cpt_display'); ?></label></input>
  </div>



  <div id="premium" class ="ui-widget startsUgly">
  <label><?php echo _x('Lente Intraocular Premium:','Single Patient Form','iol_cpt_display'); ?><br /></label>
     <div id="premiumInputs">


      <input type="radio" id="monofocal-asferica" <?php echo $monoAsfText; ?> name="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" value="<?php echo _x('monofocal-asferica','taxo-value-slug','iol-scaffold'); ?>">
      <label for="monofocal-asferica"><?php echo _x('Monofocal Asférica','Single Patient Form','iol_cpt_display'); ?></label><!-- </input> -->
      <input type="radio" id="multifocal" <?php echo $multifocalText; ?> name="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" value="<?php echo _x('multifocal','taxo-value-slug','iol-scaffold'); ?>"><label for="multifocal"><?php echo _x('Multifocal','Single Patient Form','iol_cpt_display'); ?></label><!--</input>      -->
      
      <input type="radio" id="acomodativa" <?php echo $acomodativaText; ?> name="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" value="<?php echo _x('acomodativa','taxo-value-slug','iol-scaffold'); ?>"><label for="acomodativa"><?php echo _x('Acomodativa','Single Patient Form','iol_cpt_display'); ?></label><!--</input>-->
      <input type="radio" id="ajustable-por-luz" <?php echo $aplText; ?> name="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" value="<?php echo _x('ajustable-por-luz','taxo-value-slug','iol-scaffold'); ?>"><label for="ajustable-por-luz"><?php echo _x('Ajustable por luz','Single Patient Form','iol_cpt_display'); ?></label><!--</input> -->
      	


     </div>
  </div>
  
  
  
  <div id="correccionAstig" class ="ui-widget startsUgly">
  <label><?php echo _x('Corrección para Astigmatismo','Single Patient Form','iol_cpt_display');?><br /></label>
    <div id="correcAstigInputs">
      <input type="radio" id="correcAstigSi" <?php echo $toricaText; ?> name="<?php echo _x('toricidad','taxo-name','iol'); ?>" value="<?php echo _x('torica','taxo-value-slug','iol-scaffold'); ?>">
      <label for="correcAstigSi"><?php echo _x('Sí','Single Patient Form','iol_cpt_display'); ?></label><!-- </input>-->
      <input type="radio" id="correcAstigNo" <?php echo $noToricaText; ?> name="<?php echo _x('toricidad','taxo-name','iol'); ?>" value="<?php echo _x('no-torica','taxo-value-slug','iol-scaffold'); ?>">
      <label for="correcAstigNo"><?php echo _x('No','Single Patient Form','iol_cpt_display'); ?></label> <!-- </input>-->
    </div>
  </div>

  <div id="filtros" class ="ui-widget startsUgly">
  <label class="filtrosLabel"><?php echo _x('Filtros de la Lente:','Single Patient Form','iol_cpt_display');?><br /></label>
    <div id="filtrosInputs">
      <input type="checkbox" id="luz-ultravioleta"<?php echo $luzUltravioletaText;?> name="<?php echo _x('luz-ultravioleta','taxo-value-slug','iol-scaffold'); ?>" value="<?php  echo _x('luz-ultravioleta','taxo-value-slug','iol-scaffold'); ?>">
      <label for="luz-ultravioleta"><?php echo _x('Ultravioleta','Single Patient Form','iol_cpt_display'); ?></label><!-- </input> -->
      <input type="checkbox" id="luz-azul" <?php echo $luzAzulText; ?> name="<?php echo _x('luz-azul','taxo-value-slug','iol-scaffold'); ?>" value="<?php  echo _x('luz-azul','taxo-value-slug','iol-scaffold'); ?>">
      <label for="luz-azul"><?php echo _x('Luz Azul','Single Patient Form','iol_cpt_display'); ?> <br /><?php echo _x('Protección Macular','Single Patient Form','iol_cpt_display'); ?></label>
      <!-- </input> -->
    </div>
  </div>

  <div id="add-on" class ="ui-widget startsUgly">
  <label class="add-on-label"><?php echo _x('Add On:','Single Patient Form','iol_cpt_display');?><br /></label>
    <div id="add-onInputs">
      <input type="radio" data-taxo1="<?php echo _x('tipo-lente-intraocular','taxo-name','iol'); ?>" data-value1="<?php echo _x('add-on','taxo-value-slug','iol-scaffold'); ?>" data-taxo2="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" data-value2="<?php echo _x('monofocal','taxo-value-slug','iol-scaffold'); ?>" id="add-on-monofocal" <?php echo $addOnMonofocalText; ?> name="button-add-on" value="button-add-on-mono-value">
      <label for="add-on-monofocal">
      <?php echo _x('Monofocal','Single Patient Form','iol_cpt_display'); ?>
      </label> <!-- </input> -->
      <input type="radio" data-taxo1="<?php echo _x('tipo-lente-intraocular','taxo-name','iol'); ?>" data-value1="<?php echo _x('add-on','taxo-value-slug','iol-scaffold'); ?>" data-taxo2="<?php echo _x('diseno-optica','taxo-name','iol'); ?>" data-value2="<?php echo _x('multifocal','taxo-value-slug','iol-scaffold'); ?>" id="add-on-multifocal" <?php echo $addOnMultifocalText; ?> name="button-add-on" value="button-add-on-multi-value">
      <label for="add-on-multifocal"><?php echo _x('Multifocal','Single Patient Form','iol_cpt_display'); ?></label><!-- </input>-->
 <!-- 	<input type="hidden" disabled="disabled" id="ao-multifocal" name="diseno-optica" value="multifocal" />
    -->
    </div>
  </div>  




  <div id="iclContainer" class ="ui-widget startsUgly">
  <label class="icl-label"><?php echo _x('Lente Fáquica ICL:&nbsp;&nbsp;','Single Patient Form','iol_cpt_display');?><br />
  </label>
      <input type="radio" id="icl" <?php echo $iclText; ?> data-taxo="<?php echo _x('tipo-lente-intraocular','taxo-name','iol'); ?>" data-value="<?php echo _x('icl','taxo-value-slug','iol-scaffold'); ?>" name="button-icl" value="button-icl-value">
      <label for="icl">ICL</label><!-- </input>-->
  </div>
  
  <div id="verisyseContainer" class ="ui-widget startsUgly">
  <label><?php echo _x('Lente Fáquica Verisyse:','Single Patient Form','iol_cpt_display');?><br /></label>
      <input type="radio" id="verisyse" <?php echo $verisyseText; ?> data-taxo="<?php echo _x('tipo-lente-intraocular','taxo-name','iol'); ?>" data-value="<?php echo _x('verisyse','taxo-value-slug','iol-scaffold'); ?>"   name="button-verisyse" value="button-verisyse-value"><label for="verisyse">Verisyse</label><!-- </input>-->
  </div>
 
     </div>
      </div>
      
      
      
      
      
      
      
  <!-- Fin del Filtro de usuarios normales-->
     		<!-- Input para salida específica de pacientes -->
	<input type="hidden" name="nivel-pref-lente" value="5">
 	
   </form>

<?php
    //Div auxiliar que sólo lleva traducciones.
    echo '<div style="visibility:hidden;">
        <div id="tLente">'._x('tipo-lente-intraocular','taxo-name','iol').'</div>
        <div id="pseudo">'._x('pseudofaquica','taxo-value-slug','iol-scaffold').'</div>
    </div>';
