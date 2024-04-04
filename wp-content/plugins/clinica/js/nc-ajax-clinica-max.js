function archiveClinica_submit_me(viewTypeData){

    if (typeof (viewTypeData) === 'undefined') {

        var textoInfoPannel = jQuery('h4#expanderHead span.infoIolHeaderTitle').html();
        
        var idsNotToProcess = new Array();
        console.log(jQuery("#clinica_filter_form").serialize());

        jQuery("#clinica_filter_form").serialize();

        //Si hay algún input con valor que contenga "-se" -> Fuera, a no ser que sea el de ubicación
        jQuery("#clinica_filter_form input, #clinica_filter_form select").each(function () {
                
        if ((this.value.substr(this.value.length - 3) == '-se' || jQuery(this).prop('disabled') == true) && (this.value.indexOf('ubicacion') == -1)) { 
           idsNotToProcess.push('#' + jQuery(this).attr('id'));
                   }
             else {
            
                   }
          });


        var selectorNotToProcess = idsNotToProcess.join(',');
         //alert(selectorNotToProcess);
        console.log('Selectores que no procesan: '.selectorNotToProcess);
        var data = jQuery("#clinica_filter_form input,#clinica_filter_form select").not(selectorNotToProcess).serialize();
        //console.log(data);
        //alert(data);
    }
    else { 
        console.log('archive submit me llamada desde paginación');
        data = viewTypeData;
        //alert(data);
    }
 	//Tenemos que hacer que si está en la página intro de clínicas mande el formulario serializado vía get a la url del archive.
 	//Esto lo podemos hacer bien parseando la url bien, comprobando la existencia del infoPannel, nos decantaremos de momento por la segunda opción.
 	
 
 	if(jQuery('#archiveClinicaUrl').length && jQuery('#clinicasIolUrl').length){
 	 	    //alert('Ojo por aquí también pasa');
 	    jQuery("#clinica_filter_form input, #clinica_filter_form select").each(function () {
        if ((this.value.substr(this.value.length - 3) == '-se' || jQuery(this).prop('disabled') == true) && (this.value.indexOf('ubicacion') == -1)) { //this.value == 'S/E'
            jQuery(this).prop('disabled', true);
             //console.log(this.value + 'Ha sido desabilitado');
            //idsNotToProcess.push('#'+jQuery(this).attr('id'));
         
         console.log('condicional archiveClinica_submit_me activado');
         }
        });
 	   
 	   //lo que hacemos es "dirigir" a la página sin hacer submit en el formulario.
	   //jQuery("#clinica_filter_form").submit(); 		
 	   var clinicFormQuery = jQuery("#clinica_filter_form").serialize();
 	   var clinicArchiveUrl = jQuery('#clinica_filter_form').attr('action');
 	   //location.href= archive_page + '?'+ jQuery('#clinica_filter_form').serialize();
 	   var hrefClinic= clinicArchiveUrl +'?' +clinicFormQuery;  
 	   goToMain(hrefClinic,'#right',null,'SiDragg');
 	   history.pushState(null, null, hrefClinic);
       //AVISO GAnalytics cambio de página
       ga('send', 'pageview',hrefClinic);

	   /*Lo has centralizado en una función, si estás en la página-template de clínicas no estás haciendo una llamada ajax a wp-admin sino que estás haciendo una descarga de la página por goToMain. Hay pués que cerciorarse de que en la descarga del archive, está pasando por el filterClinica y cogiendo la constraint de la lente intraocular. */	
			
 	   return;
 	 }



 	 jQuery.ajax({
 	     url: the_ajax_script.ajaxurl,
 	     data: data,
 	     cache: true,
 	     success:
            function (response_from_the_action_function) {

                jQuery("#primary #content").html(response_from_the_action_function);
                //A ver como actualizamos el iolInfoPannel... -> Lo haremos a posteriori ya que el preproceso no funciona.
                //alert(typeof (viewTypeData));
                if (typeof (viewTypeData) === 'undefined') {
                    var clinicaInfoAJAX = jQuery("#AJAXclinicaInfoPannel").html();
                    jQuery('h4#expanderHead span.infoIolHeaderTitle').css('color', '#FEA63C').text(textoInfoPannel);

                    switch (clinicaClickeado) {
                        case 0:
                            jQuery('#expanderContent').html(clinicaInfoAJAX);
                            break;
                        case 1:
                            jQuery('#clinicaInfoPannel #expanderContent').fadeOut('slow', function () { jQuery(this).html(clinicaInfoAJAX).fadeIn('slow') });
                            break;
                    }
                }
                jQuery('#LinkPagination a, #LinkPages a').on('click', function (event) {
                    event.preventDefault();
                    //  console.log('Llamada realizada por la carga recursiva tras ajax');
                    submit_me_link(this);
                }
                    );

            },
 	     beforeSend: function () {

 	         jQuery('#CLINICA_Filtradas').hide();
 	         jQuery('#CLINICA_Filtradas').html(jQuery('#loadingGif').html());
 	         jQuery('#CLINICA_Filtradas').show();
 	         //alert('poniendo actualizando info');
 	         if (typeof (viewTypeData) === 'undefined') {
 	             jQuery('h4#expanderHead span.infoIolHeaderTitle').html('Actualizando la Información').css('color', 'green');
 	             jQuery('#resizableTitle').animate({ opacity: '0' }, 1000).animate({ opacity: '1' }, 1000);
 	         }

 	     }
 	 }
            )
}
