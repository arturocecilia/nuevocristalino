
   <!-- Prueba para saber si la added_query_var puede coincidir con un taxo_slug -->

<?php //Sacamos la página destino del formulario.
  // Try to get the page by the incoming title
    $title= 'Búsqueda de Lentes Intraoculares del Paciente' ;
    $permalink = NULL;
    $page = get_page_by_title( strtolower( $title ) );
 
    // If the page exists, then let's get its permalink
    if( null != $page ) {
        $permalink = get_permalink( $page->ID );

    }

?>

  <h2> <?php echo _x('BUSCADOR DE LENTES PARA PACIENTES:','Filter_Template','iol_display'); ?></h2>      
  <form id="patient_iol_filter_form" method="get" action="<?php echo $permalink; ?>">

   <input type="button" value="Realizar Filtrado" class="submitSingle" onClick="patient_submit_me();" />

 <!-- <input name="action"  type="hidden" value="filter_result" /> --> <!-- this puts the action the_ajax_hook into the serialized form -->

<!-- Vamos a añadir este hidden input para llevar a cabo la paginación -->
  <!-- <input id="pagina" name="page" type="hidden" value="empty" />-->


  <!-- Inicio del Filtro de usuarios normales-->
 <div id="PatientAccordionFilter">
     <h3> <?php echo _x('Filtro para Pacientes','Filter_Template','iol_display'); ?> </h3>
     <div>

  <div id="estandar" class ="ui-widget startsUgly">
  <label><?php echo _x('Lente Intraocular Estándar:','Filter_Template','iol_display');?><br /></label>
      <input type="radio" id="monofocal" name="tipo-lente" value="monofocal"><label for="monofocal">Monofocal</label></input>
  </div>
  
  <div id="premium" class ="ui-widget startsUgly">
  <label><?php echo _x('Lente Intraocular Premium:','Filter_Template','iol_display');?><br /></label>
     <div id="premiumInputs">
      <input type="radio" id="monofocal-asferica" name="tipo-lente" value="monofocal-asferica"><label for="monofocal-asferica">Monofocal Asférica</label></input>
      <input type="radio" id="multifocal-bifocal" name="tipo-lente" value="multifocal-bifocal"><label for="multifocal-bifocal">Multifocal Bifocal</label></input>      
      <input type="radio" id="multifocal-trifocal" name="tipo-lente" value="multifocal-trifocal"><label for="multifocal-trifocal">Multifocal Trifocal</label></input> 
      <input type="radio" id="acomodativa" name="tipo-lente" value="acomodativa"><label for="acomodativa">Acomodativa</label></input>
      <input type="radio" id="ajustable-por-luz" name="tipo-lente" value="ajustable-por-luz"><label for="ajustable-por-luz">Ajustable por luz</label></input>
     </div>
  </div>
  
  <div id="correccionAstig" class ="ui-widget startsUgly">
  <label><?php echo _x('Correción para Astigmatismo','Filter_Template','iol_display');?><br /></label>
    <div id="correcAstigInputs">
      <input type="radio" id="correcAstigSi" name="correcAstig" value="toricidad-si"><label for="correcAstigSi">Sí</label></input>
      <input type="radio" id="correcAstigNo" name="correcAstig" value="toricidad-no"><label for="correcAstigNo">No</label></input>
    </div>
  </div>

  <div id="filtros" class ="ui-widget startsUgly">
  <label class="filtrosLabel"><?php echo _x('Filtros de la Lente:','Filter_Template','iol_display');?><br /></label>
    <div id="filtrosInputs">
      <input type="checkbox" id="luz-ultravioleta" name="luz-ultravioleta" value="luz-ultravioleta"><label for="luz-ultravioleta">Ultravioleta</label></input>
      <input type="checkbox" id="luz-azul" name="luz-azul" value="luz-azul"><label for="luz-azul">Luz Azul <br /> Protección Mácular</label></input>
    </div>
  </div>
  
  <div id="add-on" class ="ui-widget startsUgly">
  <label class="add-on-label"><?php echo _x('Add On:','Filter_Template','iol_display');?><br /></label>
    <div id="add-onInputs">
      <input type="radio" id="add-on-monofocal" name="tipo-lente" value="add-on-monofocal"><label for="add-on-monofocal">Monofocal</label></input>
      <input type="radio" id="add-on-multifocal" name="tipo-lente" value="add-on-multifocal"><label for="add-on-multifocal">Multifocal</label></input>
    </div>
  </div>  

  <div id="iclContainer" class ="ui-widget startsUgly">
  <label class="icl-label"><?php echo _x('Lente Fáquica ICL:&nbsp;&nbsp;','Filter_Template','iol_display');?><br /></label>
      <input type="radio" id="icl" name="tipo-lente" value="icl"><label for="icl">ICL</label></input>
  </div>
  
  <div id="verisyseContainer" class ="ui-widget startsUgly">
  <label><?php echo _x('Lente Fáquica Verisyse:','Filter_Template','iol_display');?><br /></label>
      <input type="radio" id="verisyse" name="tipo-lente" value="verisyse"><label for="verisyse">Verisyse</label></input>
  </div>
 
     </div>
      </div>
  <!-- Fin del Filtro de usuarios normales-->
     	
   </form>