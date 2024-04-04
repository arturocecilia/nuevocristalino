
   <!-- Prueba para saber si la added_query_var puede coincidir con un taxo_slug -->

<?php //Sacamos la página destino del formulario.
  // Try to get the page by the incoming title
   
   /* $title= 'Búsqueda de Lentes Intraoculares del Paciente' ;
    $permalink = NULL;
    $page = get_page_by_title( strtolower( $title ) );
 
    // If the page exists, then let's get its permalink
    if( null != $page ) {
        $permalink = get_permalink( $page->ID );

    }*/
    //Nos olvidamos de lo anterior => Vamos a pivotar todo el rato sobre la página archive de lentes intraoculares.
    $linkToIolArchive = get_post_type_archive_link( _x('lente-intraocular','CustomPostType Name','iol') );

?>




  <h2> <?php echo _x('BUSCADOR DE LENTES PARA PACIENTES:','Patient Form','iol_cpt_display'); ?></h2>      
  <form id="patient_iol_filter_form" method="get" action="<?php echo $linkToIolArchive; ?>?t=1">

   <input type="button" value="<?php  echo _x('Realizar Filtrado','Right Archive Lente Intraocular','iol_cpt_display'); ?>" class="submitSingle" onClick="patient_submit_me();" />  

 <!-- <input name="action"  type="hidden" value="filter_result" /> --> <!-- this puts the action the_ajax_hook into the serialized form -->

<!-- Vamos a añadir este hidden input para llevar a cabo la paginación -->
<input name="action" type="hidden" value="filter_result" />


  <!-- Inicio del Filtro de usuarios normales-->
 <div id="PatientAccordionFilter">
     <h3> <span class="title-filter"><?php echo _x('Filtro para Pacientes','Patient Form','iol_cpt_display'); ?></span></h3>
     <div>

  <div id="estandar" class ="ui-widget startsUgly"> <!-- -->
  <label><?php echo _x('Lente Intraocular Estándar:','Patient Form','iol_cpt_display');?><br /></label>
      <input type="radio" id="pf-monofocal" data-taxo="diseno-optica" data-value="monofocal" name="button-monofocal" value="button-monofocal-value"><label for="pf-monofocal"><?php echo _x('Monofocal','Patient Form','iol_cpt_display'); ?></label></input>
  </div>
   
  <div id="premium" class ="ui-widget startsUgly">
  <label><?php echo _x('Lente Intraocular Premium:','Patient Form','iol_cpt_display');?><br /></label>
     <div id="premiumInputs">
        
      <?php if(current_user_can('manage_options')){?>  
        
        Archivo patient form -> El usuario está registrado y es Administrador.

       <?php }else{?>
      <input type="radio" id="monofocal-asferica" name="diseno-optica" value="monofocal-asferica"><label for="monofocal-asferica"><?php echo _x('Monofocal Asférica','Patient Form','iol_cpt_display'); ?></label><!-- </input>-->
      <input type="radio" id="multifocal-bifocal" name="diseno-optica" value="multifocal-bifocal"><label for="multifocal-bifocal"><?php echo _x('Multifocal Bifocal','Patient Form','iol_cpt_display'); ?></label><!-- </input>      -->
      <input type="radio" id="multifocal-trifocal" name="diseno-optica" value="multifocal-trifocal"><label for="multifocal-trifocal"><?php echo _x('Multifocal Trifocal','Patient Form','iol_cpt_display'); ?></label><!-- </input> -->
      <input type="radio" id="acomodativa" name="diseno-optica" value="acomodativa"><label for="acomodativa"><?php echo _x('Acomodativa','Patient Form','iol_cpt_display'); ?></label><!-- </input>-->
      <input type="radio" id="ajustable-por-luz" name="diseno-optica" value="ajustable-por-luz"><label for="ajustable-por-luz"><?php echo _x('Ajustable por luz','Patient Form','iol_cpt_display'); ?></label><!-- </input>-->       
       <?php }?>
     </div>
  </div>
  
  
  
  <div id="correccionAstig" class ="ui-widget startsUgly">
  <label><?php echo _x('Corrección para Astigmatismo','Patient Form','iol_cpt_display');?><br /></label>
    <div id="correcAstigInputs">
      <input type="radio" id="correcAstigSi" name="toricidad" value="torica"><label for="correcAstigSi"><?php echo _x('Sí','Patient Form','iol_cpt_display');?></label></input>
      <input type="radio" id="correcAstigNo" name="toricidad" value="no-torica"><label for="correcAstigNo"><?php echo _x('No','Patient Form','iol_cpt_display');?></label></input>
    </div>
  </div>

  <div id="filtros" class ="ui-widget startsUgly">
  <label class="filtrosLabel"><?php echo _x('Filtros de la Lente:','Patient Form','iol_cpt_display');?><br /></label>
    <div id="filtrosInputs">
      <input type="checkbox" id="luz-ultravioleta" name="luz-ultravioleta" value="luz-ultravioleta"><label for="luz-ultravioleta"><?php echo _x('Ultravioleta','Patient Form','iol_cpt_display');?></label></input>
      <input type="checkbox" id="luz-azul" name="luz-azul" value="luz-azul"><label for="luz-azul"><?php _x('Luz Azul','Patient Form','iol_cpt_display');?> <br /><?php echo _x('Protección Mácular','Patient Form','iol_cpt_display');?></label></input>
    </div>
  </div>
  
  <div id="add-on" class ="ui-widget startsUgly">
  <label class="add-on-label"><?php echo _x('Add On:','Patient Form','iol_cpt_display');?><br /></label>
    <div id="add-onInputs">
      <input type="radio" data-taxo1="tipo-lente-intraocular" data-value1="add-on" data-taxo2="diseno-optica" data-value2="monofocal" id="add-on-monofocal" name="button-add-on-mono" value="button-add-on-mono-value"><label for="add-on-monofocal"><?php echo _x('Monofocal','Patient Form','iol_cpt_display');?></label></input>
      <input type="radio" data-taxo1="tipo-lente-intraocular" data-value1="add-on" data-taxo2="diseno-optica" data-value2="multifocal" id="add-on-multifocal" name="button-add-on-multifocal" value="button-add-on-multi-value"><label for="add-on-multifocal"><?php echo _x('Multifocal','Patient Form','iol_cpt_display');?></label></input>
 <!-- 	<input type="hidden" disabled="disabled" id="ao-multifocal" name="diseno-optica" value="multifocal" />
    -->
    </div>
  </div>  

  <div id="iclContainer" class ="ui-widget startsUgly">
  <label class="icl-label"><?php echo _x('Lente Fáquica ICL:&nbsp;&nbsp;','Patient Form','iol_cpt_display');?><br /></label>
      <input type="radio" id="icl" name="tipo-lente-intraocular" value="icl"><label for="icl">ICL</label></input>
  </div>
  
  <div id="verisyseContainer" class ="ui-widget startsUgly">
  <label><?php echo _x('Lente Fáquica Verisyse:','Patient Form','iol_cpt_display');?><br /></label>
      <input type="radio" id="verisyse" name="tipo-lente-intraocular" value="verisyse"><label for="verisyse">Verisyse</label></input>
  </div>
 
     </div>
      </div>
  <!-- Fin del Filtro de usuarios normales-->
   	
   		<!-- Input para salida específica de pacientes -->
	<input type="hidden" name="nivel-pref-lente" value="5">

   	
   </form>



<?
    //Div auxiliar que sólo lleva traducciones.
    echo '<div style="visibility:hidden;">';
        echo '<div id="tLente">'._x('tipo-lente-intraocular','taxo-name','iol').'</div>';
        echo '<div id="pseudo">'._x('pseudofaquica','taxo-value-slug','iol-scaffold').'</div>';
    echo '</div>';
?>