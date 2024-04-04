function versionNCcleaner(){
	if(jQuery.cookie('ncpatient')){
			jQuery('.pteNoDisplay').css('display','none');
			jQuery('.pteDisplay').css('display','block');

	}else{
			jQuery('.pteNoDisplay').css('display','block');
			jQuery('.pteDisplay').css('display','none');


	}

}

//Detecta si es paciente.

function userEsPaciente(){

	if(jQuery.cookie('ncpatient') == 'ncpatient' ){ //&& jQuery.cookie('ncpatient') != 'null'
		return true;
	}else{
		return false;
	}
}

/*Prueba para ve si la caché se regenera*/

function versionNcUpdater(){
	if(jQuery.cookie('ncpatient')){
			jQuery('.pteNoDisplay').css('display','none');
			jQuery('.pteDisplay').css('display','block');
			console.log('Mostrando pteDisplay y ocultano pteNoDisplay');
					//Single IOL
		if(jQuery('#primary.site-content-single.single-lente').length){

		//Ojo porque si es móvil la propiedad CSS cambia.
		if(jQuery(window).width() > 600){
				jQuery('#primary.site-content-single.single-lente').css('width','68%'); //68%
			}else{
			jQuery('#primary.site-content-single.single-lente').css('width','95%');
			}
			if(jQuery('#main').width() > 970){
			jQuery('#preButtonSetSingle #helpTitle a').css('left',832);
		}else{
			jQuery('#preButtonSetSingle #helpTitle a').css('left',700);
		}
			//Añadimo el contenido y marcado específico para pacientes correspondiente a esa lente.
			addSingleIolPatientContent();


			console.log('single IOl updateada');
		}
		//Vamos a meter también la lógica de updatear el combo para dejarnos de lios.
		if(jQuery('#changeModeLink').length){
			jQuery('span.profChangeVersion.active').removeClass('active');
			jQuery('span.modeSpanActive.modeProf').removeClass('modeSpanActive');
			jQuery('span.modeProf').addClass('modeSpanInactive');

			jQuery('span.pteChangeVersion').addClass('active');
			jQuery('span.modeSpanInactive.modePte').removeClass('modeSpanInactive');
			jQuery('span.modePte').addClass('modeSpanActive');
		}

	}else{
			jQuery('.pteNoDisplay').css('display','block');
			jQuery('.pteDisplay').css('display','none');
			console.log('Ocultando pteDisplay y mostrando pteNoDisplay');
					//Single IOL
		if(jQuery('#primary.site-content-single.single-lente').length){

			if(jQuery(window).width() > 600){
			jQuery('#primary.site-content-single.single-lente').css('width','51%'); //51
			}else{
			jQuery('#primary.site-content-single.single-lente').css('width','95%');//64
			}
			if(jQuery('#main').width() > 970){
			jQuery('#preButtonSetSingle #helpTitle a').css('left',832);
		}else{
			console.log('#preButtonSetSingle #helpTitle a, puesto a 520');
			jQuery('#preButtonSetSingle #helpTitle a').css('left',520);
		}
			console.log('single IOl updateada');
		}
		//Vamos lógica de updatear el combo.
		if(jQuery('#changeModeLink').length){
			jQuery('span.pteChangeVersion.active').removeClass('active');
			jQuery('span.modeSpanActive.modePte').removeClass('modeSpanActive');
			jQuery('span.modePte').addClass('modeSpanInactive');

			jQuery('span.profChangeVersion').addClass('active');
			jQuery('span.modeSpanInactive.modeProf').removeClass('modeSpanInactive');
			jQuery('span.modeProf').addClass('modeSpanActive');
		}


	}
}
//Esta función será para el onclick de los links del changeModeBloq impliquen cambio de modo y refresh.
function versionNCChangeRefresh(){
	console.log('versionNCChangeRefresh ejecutada');
		 if(jQuery.cookie('ncpatient')){
	 			jQuery.cookie('ncpatient',null, { path: '/' });
	 			console.log('cambiado a modo profesional');
	 			goToMain(window.location.href);
	 			return;
	 			//location.reload();
	 			}
	 	   if(!jQuery.cookie('ncpatient')){
	 			jQuery.cookie('ncpatient','ncpatient', { path: '/' });
	 			console.log('Cookie colocada cambiado a modo paciente');
				goToMain(window.location.href);
				return;
				//location.reload();
				}
}

//Add callToQuestion
function addCallToQuestion(){
	jQuery.ajax({
        url: the_ajax_script.ajaxurl,
        data:  { action: "addCallToQuestion"},
        cache: true,
        success:
            function (response_from_the_action_function) {

				jQuery('#callToQuestion div.callToQuestionContenido').html(response_from_the_action_function);
            },
        beforeSend: function () {
         console.log('addCallToQuestion ejecutandose');
						        },
	   complete: function () {
        	//

             }

            }

            );
      console.log('addChangeModeBloqContent ejecutada');

}

//Con esta función añadiremos el contenido del changeModeBloq
/*function addChangeModeBloqContent(){
	jQuery.ajax({
        url: the_ajax_script.ajaxurl,
        data:  { action: "addChangeModeBloqContent"},
        cache: true,
        success:
            function (response_from_the_action_function) {

				jQuery('#changeModeBloq div.contenidoMode').html(response_from_the_action_function);
            },
        beforeSend: function () {
         console.log('addChangeModeBloqContent ejecutandose');
						        },
	   complete: function () {
        	//añadimos el onClick event para el changeVersionContentBloq
        	jQuery('.contentModeBloq a#changeModeLink').click(function(event){
        				event.preventDefault();
        				versionNCChangeRefresh();
        				//goToMain()
        	});

        	jQuery('.contentModeBloq a#changeModeHelp').click(function(event){
        		event.preventDefault();
        		goToHelp(jQuery(this).attr('href'),'primary','primary');
        		console.log('gotTohelp disparada');

        	});

             }

            }

            );
      console.log('addChangeModeBloqContent ejecutada');

}*/


jQuery(document).ready(function(){
	versionNcUpdater();
	console.log('versionNcUpdater trigeado');
	    //Si estamos en la página del buscador de lentes directamente cambiamos el modo de nuevocristalino a professional.
	if(jQuery('#buscadorIol').length){
	 //Hacemos un cambio rápido a modo prof-> quitamos la cookie si está definida
	 if(jQuery.cookie('ncpatient')){
	 		jQuery.cookie('ncpatient',null, { path: '/' });
	 		console.log('Cookie de paciente retirada');
	 			}
	      }
	//Vamos a poner un div en ciertas páginas que muestre el modo de nuevocristalinoy permita su cambio.
	//Básicamente las páginas son TIPOS DE LIO y FABRICANTES.
	if(jQuery('#changeModeBloq').length){
		addChangeModeBloqContent();
	}
	//Añadimos el div de call to question.
	if(jQuery('#callToQuestion').length){
		addCallToQuestion();
		console.log('callToquestion ejecutada');
	}
	//Añadimos el versionswitcher
		/* toggle nav */
	jQuery("#menu-icon").on("click", function(){
jQuery('div.dcjq-mega-menu').slideToggle("slow", function() {
    // Animation complete.
    if(jQuery('.dcjq-mega-menu').css('display') == 'block'){
    	jQuery('.iconMenuText').fadeOut();
    }else{
	    jQuery('.iconMenuText').fadeIn();
        }

     });
	});


	//La lógica del version switcher
	jQuery('#classicChanger').click(function(){
		jQuery('#mobile-css').remove();
		jQuery.cookie('version','classic', { path: '/' });
		console.log('Cambiando a vista clasica');
		//location.reload();//Si metemos true no usará la cache
		return false;
	});
	jQuery('#mobileChanger').click(function (event) {

		jQuery.cookie('version',null, { path: '/' });
   		jQuery("head").append('<link rel="stylesheet"  id="mobile-css" type="text/css" href="<?php echo get_home_url(); ?>/wp-content/themes/iol/css/mobile.css" />"');

   console.log('Cambiando a móvil');
   	location.reload();//Si metemos true no usará la cache
    	return false;
    });

    //Además tenemos que incluir la condición de que el tipo quiera versión classica en dispositivo móvil
	if(jQuery.cookie('version') && jQuery('#mobile-css').length){
		jQuery('#mobile-css').remove();
	}

});


function addSingleIolPatientContent(){
	jQuery.ajax({
        url: the_ajax_script.ajaxurl,
        data:  { action: "getSingleIolPatientInfo"},
        cache: true,
        success:
            function (response_from_the_action_function) {

				jQuery('#iolPatientInfo').html(response_from_the_action_function);
            },
        beforeSend: function () {

						        },
	   complete: function () {
        	versionNCcleaner();
             }

            }

            );
      console.log('addSingleIolPatientContent ejecutada');

}


function archive_submit_me(viewTypeData){
    //Esta función puede ser llamada también por el viewType combobox => Sólo se hará la llamada ajax asociada.
    //CABMIO COMO EN PATIENT_SUBMIT_ME
    if (typeof(viewTypeData) === 'undefined' || 1==1 ) {
        console.log('archive submit me llamada desde el form');
        var textoInfoPannel = jQuery('h4#expanderHead span.infoIolHeaderTitle').html();
        var idsNotToProcess = new Array();
        // console.log(jQuery("#iol_filter_form").serialize());

        jQuery("#iol_filter_form").serialize();
        //Si hay algún input con valor que contenga "-se" -> Fuera.
        jQuery("#iol_filter_form input, #iol_filter_form select").each(function () {
            if (this.value.substr(this.value.length - 3) == '-se' || jQuery(this).prop('disabled') == true) { //this.value == 'S/E'
                //jQuery(this).prop('disabled', true);
                //console.log(this.value + 'Ha sido desabilitado');
                idsNotToProcess.push('#' + jQuery(this).attr('id'));
            }
            else {

                //valoresToProcess.push(jQuery(this));
                //jQuery(this).prop('disabled', false);
            }
        });


        var selectorNotToProcess = idsNotToProcess.join(',');
        //console.log(selectorNotToProcess);
        var data = jQuery("#iol_filter_form input,#iol_filter_form select").not(selectorNotToProcess).serialize();

        //Queremos añadir un key-value para identificar si el request viene del form de buscador iol.
        // ---> Esto lo hemos logrado gracias a un input hidden.



        //Ponemos en nuestro div auxiliar la información sobre la query en curso.
        jQuery('#currentQueryString').html(the_ajax_script.ajaxurl + '?' + data);

        //Tenemos que hacer que si está en la página de modelos mande el formulario serializado vía get a la url del archive.
        //Esto lo podemos hacer bien parseando la url bien, comprobando la existencia del infoPannel, nos decantaremos de momento por la segunda opción.
        if (jQuery('#modelosIol').length && jQuery('#archiveUrl').length) { //jQuery('#archiveUrl').length && jQuery('#modelosUrl').length

            var archive_page = jQuery('#archiveUrl').html(); //'/lentes-intraoculares/?';
            jQuery('#iol_filter_form').get(0).setAttribute('method', 'get');
            jQuery('#iol_filter_form').get(0).setAttribute('action', archive_page);
            //De momento mientras el envío se haga síncrono.
            jQuery("#iol_filter_form input, #iol_filter_form select").each(function () {
                if (this.value.substr(this.value.length - 3) == '-se' || jQuery(this).prop('disabled') == true) { //this.value == 'S/E'
                    jQuery(this).prop('disabled', true);
                    //console.log(this.value + 'Ha sido desabilitado');
                    //idsNotToProcess.push('#'+jQuery(this).attr('id'));
                }
            });

            //lo que hacemos es "dirigir" a la página sin hacer submit en el formulario.
            //jQuery("#iol_filter_form").submit();

            //location.href= archive_page + '?'+ jQuery('#iol_filter_form').serialize();


            //Lo anterior era sin ajax, simplemente un redireccionamiento. A continuación lo hacemos con Ajax.
            var href = archive_page + '?' + jQuery('#iol_filter_form').serialize();//añadimos lo del pt=no lo quitamos pt=no&


            //alert('Estoy en modelos');
            goToMain(href, "#right", null, 'SI'); //goToContent(href);
			//goToContent(href);


            history.pushState(null, null, href);

            //AVISO GAnalytics cambio de página

            href = href.replace('http://' + document.domain, ''); //GA_CHANGE
            ga('send', 'pageview',href);

            console.log('pushState llevado a cabo a: ' + href + ' , en archive_submit_me()');
            return;
        }
    }
    else {
        console.log('archive submit me llamada desde paginación');
        data = viewTypeData;
    }


    jQuery.ajax({
        url: the_ajax_script.ajaxurl,
        data: data,
        cache: true,
        success:
            function (response_from_the_action_function) {

                jQuery("#primary #content").html(response_from_the_action_function);
                //A ver como actualizamos el iolInfoPannel... -> Lo haremos a posteriori ya que el preproceso no funciona.

                if (typeof (viewTypeData) === 'undefined') {
                    var iolInfoAJAX = jQuery("#AJAXiolInfoPannel").html();
                    //var textoInfoPannel = jQuery('h4#expanderHead span.infoIolHeaderTitle').html();
                    console.log('El texto a sustituir:' +textoInfoPannel);
                    jQuery('h4#expanderHead span.infoIolHeaderTitle').css('color', '#FEA63C').text(textoInfoPannel);
                    switch (Clickeado) {
                        case 0:
                            jQuery('#expanderContent').html(iolInfoAJAX);
                            break;
                        case 1:
                            jQuery('#iolInfoPannel #expanderContent').fadeOut('slow', function () { jQuery(this).html(iolInfoAJAX).fadeIn('slow') });
                            break;
                    }
                }

                jQuery('#LinkPagination a, #LinkPages a , #LinkPagesBis a').on('click', function (event) {
                    event.preventDefault();
                    submit_me_link(this);
                }
                    );

            },
        beforeSend: function () {

            jQuery('#IOL_Filtradas').hide();
            jQuery('#IOL_Filtradas').html(jQuery('#loadingGif').html());
            jQuery('#IOL_Filtradas').show();
            console.log('Cambio de título');
            if (typeof (viewTypeData) === 'undefined') {
                jQuery('h4#expanderHead span.infoIolHeaderTitle').html('Updating').css('color', 'green');
                jQuery('#resizableTitle').animate({ opacity: '0' }, 1000).animate({ opacity: '1' }, 1000);
            }
        }
    }
            );
}

//Como complemento  a la función de envío del archive_submit_me.
//Vamos a hacer que cuando se encuentre el usuario en modelos-lente-intraocular se le deshabiliten de partida los inputs que esa lente
//no haya tenid rellenados => Lo haremos sólo creo en los que sean numéricos.

jQuery(document).ready(function (){
	//chequeamos que efectivamente estamos en la página de single lente intraocular.
	if(jQuery('#singleIolTemplate').length){
	//De primeras hacemos un disable sobre los inputs que no "traen dato" y son numéricos.
	var selectors = jQuery('#inputSelectorsToDisable').html();
		jQuery(selectors).each(function(){
        	        jQuery(this).prop('disabled', true);
            	    //3.Disable de Buttons Asociados
                	 jQuery(this).prop('disabled', true);
              	     jQuery(this).parent().children(':button').button({ icons: { primary: "ui-icon-close"} });
               		 jQuery(this).parent().children(':button').addClass("noEnvia").removeClass("envia");
                 	 jQuery(this).parent().children('.ui-slider').css('opacity', '0.3'); //#opticDiameterDisabler
                 	 jQuery(this).parent().children(':button').button("refresh");
	});

	if(jQuery('#sLensClinics').length){

	lensClinicsLoader();
	}


	}
});


function lensClinicsLoader(){
       		jQuery( "#combobox-singleLens-ubicacion-child" ).combobox(
       		  {
        			select: function (event, ui) {
        				getLensClinicCStatus();
           			}
        		}
       		);

           	//El de ubicación
 		   	jQuery('#combobox-singleLens-ubicacion-parent').combobox({
        			select: function (event, ui) {
        			//Mandamos a la función Provincias el slug de la comunidad autónoma para que poble el segundo combobox con los valores asociados
        			ProvinciasSingle(ui.item.value);
        			getLensClinicCStatus();
           			}
        		});


        //Llamada ajax.
        jQuery('#sLensClinics button').on('click',getLensClinicCStatus);
        jQuery('#combobox-singleLens-ubicacion-parent,#combobox-singleLens-ubicacion-child').change(
        function (){ alert('cambio');} );



}


        function ProvinciasSingle (cAutonoma) {

    //Primero quitamos el texto de selección.
    var el = jQuery("#combobox-singleLens-ubicacion-child");

    el.empty(); // remove old options

    jQuery.each(provinciaValues[cAutonoma], function(key, value) {
    		console.log('Punto 3.1'+ key);
            el.append(jQuery("<option></option>").attr("value", value).text(key));
    		console.log('Punto 3.2'+ value);
    });

    //Si queremos dejarlo en blanco.
    jQuery('#provincia .ui-autocomplete-input').val('');
    //Aquí ponemos la lógica por si no queremos dejarlo en blanco.

}

 function getLensClinicCStatus(){

        var ids= jQuery('#listIds').val();
        var ubicacionParent = jQuery('#combobox-singleLens-ubicacion-parent').val();
        var ubicacionChild = jQuery('#combobox-singleLens-ubicacion-child').val();
        var data =  { action: "getLensClinics", iDs :ids , uParent : ubicacionParent, uChild : ubicacionChild };

        jQuery.ajax({
 	     url: the_ajax_script.ajaxurl,
 	     data: data,
 	     cache: true,
 	     success:
            function (response_from_the_action_function) {
				//alert(response_from_the_action_function);
                jQuery("#sLensClinicsContainer").html(response_from_the_action_function);

            },
 	     beforeSend: function () {

 	         jQuery('#sLensClinicsContainer').hide();
 	         jQuery('#sLensClinicsContainer').html(jQuery('#loadingGif').html());
 	         jQuery('#sLensClinicsContainer').show();

 	     },
 	     complete :  function(){

 	     }

 	 });}


//Esta función se asigna a los links de la paginación.

function submit_me_link(element) {

	//alert('submit_me_link element disparada');
	//Antes de iniciar la descarga de contenidos en el central, hacemos un smoothly scroolToTop.
	jQuery("html, body").animate({ scrollTop: jQuery("#primary").offset().top }, 2000);

	//console.log(jQuery(element).attr('href') + 'Submit_me_link ejecutado ');
	//console.log('El ajax url es:' + the_ajax_script.ajaxurl);
	console.log('El data a añadir es: '+jQuery(element).attr('href').replace(the_ajax_script.ajaxurl + '?', ''));

    jQuery.ajax({
        url: the_ajax_script.ajaxurl,
        data: jQuery(element).attr('href').replace(the_ajax_script.ajaxurl + '/?', ''),
        success:
                function (response_from_the_action_function) {

                    jQuery("#primary #content").html(response_from_the_action_function);

                    jQuery('#LinkPagination a, #LinkPages a, #LinkPagesBis a').on('click', function (event) {
                        event.preventDefault();
                        submit_me_link(this);
                    });
                }
                ,
        beforeSend: function () {
                //something you want delayed
				//alert('submit_me_link Element activándose.');

                //jQuery('#IOL_Filtradas').hide();

                jQuery('#PaginationWrapperBis');
                console.log('se ha ocultado');
                var iolFiltradasHeight = jQuery('#IOL_Filtradas').height();

                jQuery('#IOL_Filtradas').html(jQuery('#loadingGif').html());//.css('height',iolFiltradasHeight + 'px');
                console.log(jQuery('#IOL_Filtradas').height());
                jQuery('#IOL_Filtradas').show();
              /*  console.log('ExeTwo');
            }, 2000);*/
        }

    });

}

//Función que se ejecuta al enviar el formulario de la derecha del single lente intraocular.
function single_submit_me(){

       //recorremos los inptus y hacemos disabler sobre el que tenga un valor cuyos 3 últimos chars sean "-se".
    jQuery("#iol_filter_form input, #iol_filter_form select").each(function () {
        if (this.value.substr(this.value.length - 3) == '-se'|| jQuery(this).prop('disabled') == true) { //this.value == 'S/E'
            jQuery(this).prop('disabled', true);
        }
        else {
            // Por qué he puesto esto?? -> jQuery(this).prop('disabled', false);
        }
    });

		var qString = jQuery("#iol_filter_form").serialize();
	   //location.href = jQuery("#archiveUrl").html()+'?'+qString;
		console.log(qString);
       //jQuery("#iol_filter_form").submit();
       //Vamos a mandar el formulario como goToMain.
       var href = jQuery("#iol_filter_form").attr("action") + '?'+ qString;


 	   goToMain(href,"#right"); //goToContent(href); ,"#right"
 	   //console.log('Función single_submit_me, en teoría #right no debería sufrir fade.');
       history.pushState(null, null, href);
       //AVISO GAnalytics cambio de página
       href = href.replace('http://' + document.domain, ''); //GA_CHANGE
       ga('send', 'pageview',href);

       //console.log('pushState llevado a cabo a: ' + href + ' , en archive_submit_me()');

  }


//Vamos a definir la función que lleva a cabo el envío de información desde la página: explicacion-para-pacientes-de-los-tipos-de-lente-intraocular
//a la página de busqueda-de-lentes-intraoculares-del-paciente.
//Nos olvidamos de lo anterior. Vamos a pivotar en la medida de lo posible el archive de lentes intraoculares y ésta no será una excepción.

function patient_submit_me(viewTypeData) {
    //alert('Inicio de patient_submit_me');

    if (typeof(viewTypeData) === 'undefined' || 1==1) {
        console.log('Patient submit_me llamada desde el form');
        //Hay que rehacer esto, no se puede tener un buttonset formado por inputs con distinto name

        //Habrá que trabajar con la serialización puesto que no podemos poner los names correctos al tratarse de sets de botones diferentes.
        //Sólo se van a poder mandar 3 inputs simultáneamente:
        //add-on-monofocal, add-on-multifocal-> tanto name como value.
        //pf-monofocal-> tanto name como value

        //a_href = a_href.replace(/(test_ref=)[^\&]+/, '$1' + updated_test_ref);
        var qString = jQuery('#patient_iol_filter_form').serialize(); //.submit();
        //alert(qString.indexOf('button-add-on-mono=button-add-on-mono-value')!=-1);
        //en el caso de que estén checkeados alguno de los inputs de add-on, habrá que añadir a la query string el diseño de óptica asociado.
        //Lo que hacemos es trabajar directamente sobre qString y ver si se encuentran las cadenas correspondientes a los inputs anteriores y remplazarlas.
        if (qString.indexOf('button-add-on=button-add-on-mono-value') != -1) {
            var dTax1 = jQuery("#add-on-monofocal").data('taxo1');
            var dValue1 = jQuery("#add-on-monofocal").data('value1');

            var dTax2 = jQuery("#add-on-monofocal").data('taxo2');
            var dValue2 = jQuery("#add-on-monofocal").data('value2');

            var correctParam = dTax1 + '=' + dValue1 + '&' + dTax2 + '=' + dValue2;
            qString = qString.replace('button-add-on=button-add-on-mono-value', correctParam);

        }

        if (qString.indexOf('button-add-on=button-add-on-multi-value') != -1) {
            var dTax1 = jQuery("#add-on-multifocal").data('taxo1');
            var dValue1 = jQuery("#add-on-multifocal").data('value1');

            var dTax2 = jQuery("#add-on-multifocal").data('taxo2');
            var dValue2 = jQuery("#add-on-multifocal").data('value2');

            var correctParam = dTax1 + '=' + dValue1 + '&' + dTax2 + '=' + dValue2;
            qString = qString.replace('button-add-on=button-add-on-multi-value', correctParam);

        }
        //El dTax y el Value que se asocian al valor del button monofocal no están ni en el name ni en el value sino en los data.
        if (qString.indexOf('button-monofocal=button-monofocal-value') != -1) {
            var dTax = jQuery("#pf-monofocal").data('taxo');
            var dValue = jQuery("#pf-monofocal").data('value');

            var correctParam = dTax + '=' + dValue;
            qString = qString.replace('button-monofocal=button-monofocal-value', correctParam);
            //Hay que añadir la condición de tipo de lente.
            var tLente = jQuery('#tLente').html();
            var pseudo = jQuery('#pseudo').html();
            qString = qString + '&' + tLente+'=' + pseudo;

        }
        //Hay que hacer lo mismo para icl y verisyse.
        if (qString.indexOf('button-icl=button-icl-value') != -1) {
            var dTax = jQuery("#icl").data('taxo');
            var dValue = jQuery("#icl").data('value');

            var correctParam = dTax + '=' + dValue;
            qString = qString.replace('button-icl=button-icl-value', correctParam)
        }

        if (qString.indexOf('button-verisyse=button-verisyse-value') != -1) {
            var dTax = jQuery("#verisyse").data('taxo');
            var dValue = jQuery("#verisyse").data('value');

            var correctParam = dTax + '=' + dValue;
            qString = qString.replace('button-verisyse=button-verisyse-value', correctParam);
        }

        /*if(jQuery("#add-on-monofocal").prop('checked')){
        var nameVar  = jQuery('#ao-monofocal').attr('name');
        var valueVar = jQuery('#ao-monofocal').attr('value');
        qString = qString + '&nameVar=valueVar';
        }

        if(jQuery("#add-on-multifocal").prop('checked')){
        var nameVar  = jQuery('#ao-multifocal').attr('name');
        var valueVar = jQuery('#ao-multifocal').attr('value');
        qString = qString + '&nameVar=valueVar';
        }*/
        //Si alguno de los premium inputs está pulsado tenemos que añadir que es pseudofáquica.
        if (jQuery('#premiumInputs input[type="radio"]').val() && ((qString.indexOf('add')== -1) && (qString.indexOf('icl')== -1) && (qString.indexOf('verisyse')== -1)  ) ){
            console.log('Es un premium input el que está pulsado');
            var tLente = jQuery('#tLente').html();
            var pseudo = jQuery('#pseudo').html();
            qString = qString + '&' + tLente+'=' + pseudo;
        }


        //Ponemos en nuestro div auxiliar la información sobre la query en curso.
        jQuery('#currentQueryString').html(the_ajax_script.ajaxurl + '?' + qString);
    }
    else {
        console.log('Patient submit me llamada desde paginación');
        //Le voy a añadir al qstring la info del form
        qString = viewTypeData;
        console.log(qString);
    }
    //Si estamos en archive vamos a replicar la llamada ajax que hacemos desde el right form normal.
    if(jQuery('#archiveIolTemplate').length){

        //Aquí la variable data es la query string.
        var textoInfoPannel = jQuery('h4#expanderHead span.infoIolHeaderTitle').html();
   	    var data = qString;

   	    jQuery.ajax({
   	        url: the_ajax_script.ajaxurl,
   	        data: data,
   	        cache: false,
   	        success:
            function (response_from_the_action_function) {
                jQuery("#primary #content").html(response_from_the_action_function);
                //A ver como actualizamos el iolInfoPannel... -> Lo haremos a posteriori ya que el preproceso no funciona.
                if (viewTypeData !== 'undefined') {
                    var iolInfoAJAX = jQuery("#AJAXiolInfoPannel").html();

                    jQuery('h4#expanderHead span.infoIolHeaderTitle').css('color', '#FEA63C').text(textoInfoPannel);

                    switch (Clickeado) {
                        case 0:
                            jQuery('#expanderContent').html(iolInfoAJAX);
                            break;
                        case 1:
                            jQuery('#iolInfoPannel #expanderContent').fadeOut('slow', function () { jQuery(this).html(iolInfoAJAX).fadeIn('slow') });
                            break;
                    }
                }

                jQuery('#LinkPagination a, #LinkPages a, #LinkPagesBis a').on('click', function (event) {
                    event.preventDefault();
                    submit_me_link(this);
                }
                    );
                return;
            },
   	        beforeSend: function () {

   	            jQuery('#IOL_Filtradas').hide();
   	            jQuery('#IOL_Filtradas').html(jQuery('#loadingGif').html());
   	            jQuery('#IOL_Filtradas').show();
   	            console.log('Se cambia el título del header');
   	            jQuery('h4#expanderHead span.infoIolHeaderTitle').html('Updating').css('color', 'green');
   	            jQuery('#resizableTitle').animate({ opacity: '0' }, 1000).animate({ opacity: '1' }, 1000);
   	        }
   	    }
            );

            }

    if(jQuery('#tipoIolTemplate').length || jQuery('#singleIolTemplate').length){
            //Esté en Single lente o en la página de

    var urlAction = jQuery('#patient_iol_filter_form').attr('action');
    var href = urlAction +'&'+ qString;//Atención ya sabemos que el patient_form tiene la queryString inciada con el pt=yes
    //var currentUrl = window.location.href;//document.location

        goToMain(href);
        history.pushState(null, null, href);
        //AVISO GAnalytics cambio de página
        href = href.replace('http://' + document.domain, ''); //GA_CHANGE
        ga('send', 'pageview',href);

        console.log('pushState llevado a cabo a: '+ href + ', en patient_submit_me();');
        //Ahoara adaptaremos el right (puede ser más ancho).
        if(jQuery('#right').hasClass('patient-filter')){
        //	jQuery('#right').removeClass('patient-filter');
        }



    return false;
    }

    }




//vamos a implementar paginación ajax en los links generados por el archivo.
jQuery(document).ready(function () {

    jQuery('#LinkPages.archiveLenteIntraocularAjaxer a, #LinkPagesBis.archiveLenteIntraocularAjaxer a ').live('click', function (e) { //check when pagination link is clicked and stop its action.

        e.preventDefault();

		//La generación de paginación tras el ajax es distinta que tras la carga síncrona de la página.
		jQuery("html, body").animate({ scrollTop: jQuery("#primary").offset().top }, 2000);

        var link = jQuery(this).attr('href'); // + '/'; //Get the href attribute
        /*if (link.slice(-1) != '/' && link.indexOf('?')!=-1) {
            link = link + '/';
        }*/

        //alert(link);

        //Nada más clickear...
        jQuery('#IOL_Filtradas').hide();
        jQuery('#IOL_Filtradas').html(jQuery('#loadingGif').html());
        jQuery('#IOL_Filtradas').show();
        //
        jQuery('#primary #content').load(link + ' #content',
                function () {
                    //Contenido de una función a ejecutarse cuando la funcion se ha procesado con éxito.
                    // alert('Contenido ajax cargado');
                });
        //return false;
    });


});

//vamos a implementar paginación ajax en los links generados por el archivo de Clínicas, en teoría esto debería hacerse llamándo a la función goToContent.
jQuery(document).ready(function () {

    jQuery('div#primary.site-content-archive-clinica #LinkPages a, div#primary.site-content-archive-clinica #LinkPagesBis a ').live('click', function (e) { //check when pagination link is clicked and stop its action.

        e.preventDefault();

		//La generación de paginación tras el ajax es distinta que tras la carga síncrona de la página.
		jQuery("html, body").animate({ scrollTop: jQuery("#primary").offset().top }, 2000);

        var link = jQuery(this).attr('href'); // + '/'; //Get the href attribute

        //Nada más clickear...
        jQuery('#IOL_Filtradas').hide();
        jQuery('#IOL_Filtradas').html(jQuery('#loadingGif').html());
        jQuery('#IOL_Filtradas').show();
        //
        jQuery('#primary #content').load(link + ' #content',
                function () {

                });
        //return false;
    });


});




//Vamos ahora a implementar ajax en los links del menú principial que vayamos viendo -> cambiará también la url.

function goToMain(href,selectorsNotToFade,scrollTop,dragchecker) {

    //console.log('Función goToMain llamada');

    //sabemos que cualquier goToMain llamado desde el home implicará que el fakeDiv no esté visible
    if(jQuery('#sliderMBloqsWrapper #slider').length){
        //fakeDivGenerator();
        fakeDivHidder();
    }


    //Podemos hacer de primeras un Fade selectivo.
    if (typeof selectorsNotToFade !== "undefined") {

    if(jQuery(selectorsNotToFade).length){

       if(selectorsNotToFade == '#menu-cirugia'){
           jQuery('#main').children().children().not('#menu-cirugia').fadeTo('slow',0.5);
                 if (jQuery("#loadingGif.loadingGeneral").length) {
                    jQuery("#loadingGif.loadingGeneral").css({
                                        "display":"block"

                });
                }
           }
        else {
            if(selectorsNotToFade == "#LinkPages.testPagination"){
                //recordar que para fadeTo el not, tiene que etar en el nivel jerárquico correspondiente para funcionar
                jQuery('#main').children().children().children().not('div#PaginationWrapper').fadeTo('fast', 0.5);
                                                 if (jQuery("#loadingGif.loadingGeneral").length) {
                    jQuery("#loadingGif.loadingGeneral").css({
                                        "display":"block"
                });
                }
                  }else{
            jQuery('#main').children().not(selectorsNotToFade).fadeTo('fast',0.5);
                                             if (jQuery("#loadingGif.loadingGeneral").length) {
                    jQuery("#loadingGif.loadingGeneral").css({
                                        "display":"block"
                });
                }
                   console.log('Los elementos'+ selectorsNotToFade+ 'No han sufrido fade alguno' );
             }
             //alert('si si');
            }


        //jQuery(selectorsNotToFade).fadeTo('fast',0.85);
        console.log(selectorsNotToFade + "No han sufrido fade alguno");
        }else{
                //Final
                jQuery('#main').fadeTo('fast', 0.5);
                                 if (jQuery("#loadingGif.loadingGeneral").length) {
                    jQuery("#loadingGif.loadingGeneral").css({
                                        "display":"block"
                });
                }
        }


    } else {
    //Final

    jQuery('#main').fadeTo('fast', 0.5);
                     if (jQuery("#loadingGif.loadingGeneral").length) {
                    jQuery("#loadingGif.loadingGeneral").css({
                                        "display":"block"
                });
                }

    }
    //Vamos a meter la lógica para que se respete el posicionamiento de los accordions sobre los que se ha hecho dragg.
    if(typeof dragchecker !== "undefined"){
    	if(jQuery('#accordionFilterSecond').length){
    		var $accFSecond = jQuery('#accordionFilterSecond');
    		if($accFSecond.css('position') == 'fixed'){
    			var accFSecondTop = $accFSecond.css('top');
    			var accFSecondLeft = $accFSecond.css('left');
    			var accFSecondWidth = $accFSecond.css('width');

    			var style1 = jQuery('<style> #accordionFilterSecond { width:'+ accFSecondWidth +'; position: absolute; left:'+accFSecondLeft+';top:'+ accFSecondTop +'; }</style>');
							jQuery('html > head').append(style1);
    		}
    	}
    	if(jQuery('#accordionFilterSimple').length){
    		var $accFSimple = jQuery('#accordionFilterSimple');
    		if($accFSimple.css('position') == 'fixed'){
    			var accFSimpleTop  = $accFSimple.css('top');
    			var accFSimpleLeft = $accFSimple.css('left');
    			var accFSimpleWidth = $accFSimple.css('width');

    			var style2 = jQuery('<style> #accordionFilterSimple { width:'+ accFSimpleWidth +'; position: absolute; left:'+accFSimpleLeft+';top:'+ accFSimpleTop +'; }</style>');
							jQuery('html > head').append(style2);
    		}
    	}
    	if(jQuery('#simpleAccordionFilter').length){
    		var $accsFilter = jQuery('#simpleAccordionFilter');
    		if($accsFilter.css('position') == 'fixed'){
    			var accsFilterTop  = $accsFilter.css('top');
    			var accsFilterLeft = $accsFilter.css('left');
    			var accsFilterWidth = $accsFilter.css('width');

    			var style3 = jQuery('<style> #simpleAccordionFilter { width:'+ accsFilterWidth +'; position: absolute; left:'+accsFilterLeft+';top:'+ accsFilterTop +'; }</style>');
							jQuery('html > head').append(style3);

    		}
    	}
    	if(jQuery('#advancedAccordionFilter').length){
    		var $accAFilter = jQuery('#advancedAccordionFilter');
    		if($accAFilter.css('position') == 'fixed'){
    			var accAFilterTop  = $accAFilter.css('top');
    			var accAFilterLeft = $accAFilter.css('left');
    			var accAFilterWidth = $accAFilter.css('width');

    			var style4 = jQuery('<style> #advancedAccordionFilter { width:'+ accAFilterWidth +'; position: absolute; left:'+accAFilterLeft+';top:'+ accAFilterTop +'; }</style>');
							jQuery('html > head').append(style4);
    		}
    	}
    	if(jQuery('#surgeonAccordionFilter').length){
    		var $accSxFilter = jQuery('#surgeonAccordionFilter');
    		if($accSxFilter.css('position') == 'fixed'){
    			var accSxFilterTop  = $accSxFilter.css('top');
    			var accSxFilterLeft = $accSxFilter.css('left');
    			var accSxFilterWidth = $accSxFilter.css('width');

    			var style5 = jQuery('<style> #surgeonAccordionFilter { width:'+ accSxFilterWidth +' ; position: absolute; left:'+accSxFilterLeft+';top:'+ accSxFilterTop +'; }</style>');
							jQuery('html > head').append(style5);
    		}
    	}



    }





    /*Voy a cambiar el jQuery Aja por el Load creo...*/

    jQuery.ajax({
        url: href,
        beforeSend:function(){
        //Si es móvil hacemos un fade a todo menos el header para que el usuario vea que está pasando algo.
            if(jQuery(window).width() < 600){
            		jQuery('#menu-site').animate({ opacity: '0.2' }, 700);
			        jQuery('#page').animate({ opacity: '0.5' }, 700);
			        jQuery('#footer-wrap').animate({ opacity: '0.5' }, 700);
			        jQuery('body').css('cursor','wait !important');
			        }

        },
        //   cache: false,
        success: function (data) {

            //Cargamos los scripts de la respuesta.
            //De la función respuesta tambien cogeremos #main -> En un segundo paso esto no será necesario puesto que será lo único que devolvamos con ajax.
            console.log('Petición Ajax realizada con éxito');

            var mainContent = jQuery(data).find('#main').html();
            jQuery('#main').html(mainContent);
            console.log('Contenido Central Remplazado');
            //Exito
            if (jQuery("#loadingGif.loadingGeneral").length) {
                jQuery("#loadingGif.loadingGeneral").css({ "display": "none" });
            }

            jQuery('#main').fadeTo('fast', 1);            //Necesitamos además cargar los scripts que activan los elementos presentes en la respuesta¡¡
            //Su está presente el form de lentes:
            if (jQuery("#iol_filter_form").length) {
                // do something here
                iolFormComboboxInputSlider();
                iolFormButtonAccordionLoader();
                jQuery("#addDisabler").DisablerButton();
                buttonsChangeFilterLoader();
                iolQueryStringUpdater();
                iolTextSearch();
                console.log('Condición de #iol_filter_form cumplida');
            }
            //función que ha de ejecutarse si la página que se descarga tiene el formulario de post op.
            if (jQuery('#post-op-form').length) {
                postOpFormLoader();
            }

            //La siguiente condición también en complete para ver si se ejecuta.
            if (jQuery('#patient_iol_filter_form').length) {
                PatientFormLoader();
                buttonsChangeFilterLoader();
                iolQueryStringUpdater();
                iolTextSearch();
                //alert('el patiene y el buttonschangeloader...');
            }

            //Tenemos que hacer los mismo con el form de clínicas.
            if (jQuery('#clinica_filter_form').length) {
                	//CLINICAS --> Tratamos de llamar a gmap asíncronamente aquí
  /*      if(typeof referenceLatitude === 'undefined'){
          loadGmapsScript();
          }	*/
 /*    jQuery.when(
    jQuery.getScript('http://maps.google.com/maps/api/js?sensor=false'),
	jQuery.getScript('http://www.nuevocristalino.es/wp-content/plugins/clinica/js/clinica-maps.js')
).done(function(){

                clinicFormAccordionLoader();
                clinicFormComboButtonLoader();
                clinicaQueryStringUpdater();
                gmapsClinicsLoader();
                clinicaTextSearch();
                if (jQuery('#singleClinicTemplate').length) {

                }
                else {
                    ClinicReseter();
                }*/


//});
                clinicFormAccordionLoader();
                clinicFormComboButtonLoader();
                clinicaQueryStringUpdater();
                gmapsClinicsLoader();
                clinicaTextSearch();
                if (jQuery('#singleClinicTemplate').length) {

                }
                else {
                    ClinicReseter();
                }
            }
            //También en la página correspondiente de explicación de clínicas
            if (jQuery('#clinicasIolUrl').length) {
            	//CLINICAS --> Tratamos de llamar a gmap asíncronamente aquí
    /*    if(typeof referenceLatitude === 'undefined'){
          loadGmapsScript();
          }
*/
/*jQuery.when(
    jQuery.getScript('http://maps.google.com/maps/api/js?sensor=false'),
	jQuery.getScript('http://www.nuevocristalino.es/wp-content/plugins/clinica/js/clinica-maps.js')
).done(function(){
                clinicFormAccordionLoader();
                clinicFormComboButtonLoader();
                clinicaQueryStringUpdater();
                gmapsClinicsLoader();*/
                /*Revisar estos procedimientos*/

                //Queremos que no salga el combo de selección de vista.
//                jQuery('#comboViewTypeClinic').remove();
//});


                clinicFormAccordionLoader();
                clinicFormComboButtonLoader();
                clinicaQueryStringUpdater();
                gmapsClinicsLoader();
                /*Revisar estos procedimientos*/

                //Queremos que no salga el combo de selección de vista.
                jQuery('#comboViewTypeClinic').remove();
            }

            //También con el form del test.
            if (jQuery('#testLIO').length) {
                testFormButtonTabLoader();
            }
            //Lo mismo con la página de explicación de tipos de lentes para pacientes.
            if (jQuery('#left-explicacion-lio').length) {
                PatientFormLoader();
                buttonsChangeFilterLoader();
                activacionLeftMenuScroller();
                scrollToOnClick();
                jQuery('#comboViewType').remove();
            }
            if (jQuery('#archiveClinicaTemplate').length) {
            	//CLINICAS --> Tratamos de llamar a gmap asíncronamente aquí
         //if(typeof referenceLatitude === 'undefined'){
          //loadGmapsScript();
          //}

                clinicaInfoPannelLoader();
                buttonClinicaInfoPannelLoader();

                //Cargamos el botón de ayuda.
                // jQuery('#helpTitle a').on('click', function () {
                //     goToContent(jQuery(this).attr('href'));
                //     return false;
                // });
            }
            //Metemos el ocultador del submenu de Mis Ojos.
            if (jQuery('#templateMisOjos').length) {
                showHideSubmenuMisOjos();
                //alert('condicion Template mis ojos detectada');
            }
            //Metemos la condición para la validación del formulario.
            if (jQuery("#post-op-form").length) {
                console.log('esto se cumple');
                postOpFormValidation();
            }

            //Metemos aquí el condicional del template de cirugía o de presbicia.
            if (jQuery('#templatePresbicia').length || jQuery('#templateCirugiaOcular').length) {
                addSelectToMenuCirugia();
                console.log('Sí que se ha aplicado el add select al menú superior');
            }
            //Metemos la condición de que si está el changeModeBloqContent rellene su contenido.
            if(jQuery('#changeModeBloq').length){
            addChangeModeBloqContent();
			}
			//Metemos el callToFunction.
				//Añadimos el div de call to question.
			if(jQuery('#callToQuestion').length){
				addCallToQuestion();
				console.log('callToquestion ejecutada');
			}


            //Hacemos visibles todos los elementos que tengan la clase de .startsUgly.
            jQuery(".startsUgly").show();


            //update the page title
            var title = jQuery('#main').find('h1').text();
            jQuery('head').find('title').text(title);

            //Metemos la actualización de la versiónd e Paciente o de Profesional.
            versionNcUpdater();
            console.log('Función de actualización de versión llamada desde gotomain');


            if(jQuery(window).width() < 600){
               		jQuery('#menu-site').animate({ opacity: '1' }, 700);
			        jQuery('#page').animate({ opacity: '1' }, 700);
			        jQuery('#footer-wrap').animate({ opacity: '1' }, 700);
			        jQuery('body').css('cursor','default');
			        }


        },
        complete: function (data) {
            //Si está en la pagina de modelos de IOL.
            //Ponemos esta función en el complete porque en el success falla...
            if (jQuery('#modelosIol').length) {
                /*PatientFormLoader();
                buttonsChangeFilterLoader();*/
                iolInfoPannelLoader();
                buttonPannelLoader();
                //Queremos quitar el botón de paginación si se encuentra.

                jQuery('#comboViewType').remove();
            }
            //Si está el listado de clínicas asociadas hay que meter el script.
            if (jQuery('#singleLensClinics').length) {
                lensClinicsLoader();
            }
            //Si es la home tenemos que mostrar el fakediv
            if (jQuery('#sliderMBloqsWrapper #slider').length) {
                if (jQuery('body #fakeDiv').length == 0) {
                    jQuery('body').append('<div id="fakeDiv">&nbsp;</div>');
                }
                fakeDivGenerator();
                console.log('fakeDivGenerator activado');
                //fakeDivHidder();
            }


            //Metemos ahora el del tipos de lentes para que se añada la clase "seleccionado" al item correspondiente del submenu.
            if (jQuery('#menu-menu-tipos-lentes').length) {
                var url = window.location.href;
                jQuery('.menu-menu-tipos-lentes-container a[href="' + url + '"]').parent().addClass('seleccionado');

            }

            //Metemos las llamadas necesarias para google charts en el post results.
            if (jQuery('#templatePostOpTestResult').length || jQuery('#templatePostOp').length) {// desde #templatePostOp
                console.log('Ahora es el surgeryResults Loader');
                //resultPostOpTabsLoader();
                surgeryShowResultsLoader();
                console.log('Fin del surgeryResults loader');
            }


            //Hay que ver la razón por la que el buttonloader no funciona onSuccess.
            //Vamoa a llevar a cabo la actualización del infoPannel.
            if (jQuery('#archiveIolTemplate').length) {
                //Pienso que lo único que hay que hacer es activarlo y punto.
                //alert('Por aquí que vino');
                iolInfoPannelLoader();
                buttonPannelLoader();
            }
            if (typeof scrollTop !== "undefined") {
                //alert('scroll top activado');
              console.log('Por ejemplo en los links del footer habrá que hacerle scroll.');
                if (jQuery("#menu-site").length) {
                    jQuery("html, body").animate({ scrollTop: jQuery("#menu-site").offset().top }, 2000); //Cambiamos #primary por menu-site
                } else {
                    if (jQuery("#top-header-blog").length) {
                        jQuery("html, body").animate({ scrollTop: jQuery("#top-header-blog").offset().top }, 2000);
                    } else {
                        if (jQuery("#top-header-foro").length) {
                        jQuery("html, body").animate({ scrollTop: jQuery("#top-header-foro").offset().top }, 2000);
                        }

                        if(jQuery("#qa-menu").length){
								console.log('al qa-menu');
								jQuery("html, body").animate({ scrollTop: jQuery("#qa-menu").offset().top }, 2000);
						}


                    }
                }
            }

            			//Quitar el viewtype combobox cuando es la página de modelos.
			if(jQuery('.site-content-modelos-lentes').length){
				jQuery('#comboViewType').css('visibility','hidden');
				console.log('viewtype quitado');
			}

            if (jQuery('#templateIolSimulator').length) {
                //alert("SimLoader");
                SimLoader();
            }
            //Metemos la validación del perfil de clínica
            if (jQuery("#primary.clinic-profile form").length) {
                jQuery("#primary.clinic-profile form").submit(function (event) {
                    if (jQuery('input[name="clinicname"]').val() == "") {
                        event.preventDefault();
                        jQuery('label[for="clinicname"]').css('color', 'red');
                        return false;
                    }
                    if (jQuery('input[type="checkbox"]').prop('checked') != true) {
                        event.preventDefault();
                        jQuery('label.checkbox').css('color', 'red');
                        return false;
                    }
                    return true;
                });
            }


			//Vamos a poner la condición de que si está en móvil se mueva al inicio del content.
			//Mobile
			if(jQuery(window).width() < 600){
				if(jQuery('#content').length){
				scrollToElement(jQuery('#content'));}
				if(jQuery('#content-quienes').length){
				scrollToElement(jQuery('#content-quienes'));}
			}


            //Ejecutamos el lightbox
            //jQuery('a[rel=lightbox]').colorbox();  --> Lo Ampliamos
            jQuery('a[rel*=lightbox]').colorbox({maxWidth:'90%', maxHeight:'90%'});
        }
    });

}

//Creamos la función gotocontent para sólo cambiar el div id=content de la página.
function goToContent(href,hashScrollTo) {
    jQuery('#content').fadeTo('fast', 0.5);
           if (jQuery("#loadingGif.loadingGeneral").length) {
                    jQuery("#loadingGif.loadingGeneral").css({
                                        "display":"block"
                });
                }

    console.log('Función GoToContent llamada');
    jQuery.ajax({
        url: href,
        //   cache: false,
        success: function (data) {

            //Cargamos los scripts de la respuesta.
            //De la función respuesta tambien cogeremos #main -> En un segundo paso esto no será necesario puesto que será lo único que devolvamos con ajax.
            console.log('Petición Ajax realizada con éxito');
            var mainContent = jQuery(data).find('#content').html(); //Queremos sólo el interior de #content
            //console.log(mainContent.html());
            jQuery('#content').html(mainContent);
            console.log('Contenido Central Remplazado');
            //Exito
            if (jQuery("#loadingGif.loadingGeneral").length) {
            jQuery("#loadingGif.loadingGeneral").css({ "display": "none" });
            }
            jQuery('#content').fadeTo('fast', 1);

            //Vamos a detectar la función que actualiza el pannel.
            //Aquí hay que hacer una descarga selectiva de funciones como la que se ha hecho con GoToMain.


            //update the page title
            var title = jQuery('#main').find('h1').text();
            jQuery('head').find('title').text(title);
        },
        complete: function () {
            //jQuery('a[rel=lightbox]').colorbox();
            jQuery('a[rel*=lightbox]').colorbox({maxWidth:'90%', maxHeight:'90%'});
            //Metemos el ocultador del submenu de Mis Ojos.
            if (jQuery('#templateMisOjos').length) {
                showHideSubmenuMisOjos();
                //alert('condicion Template mis ojos detectada');
            }
            //Si el parámetro hashScrollTo está definido es que hay que direccionar
            if (typeof (hashScrollTo) != 'undefined') {
                scrollToElement(jQuery(hashScrollTo));
            }


        }
    });
}

//El siguiente condicional nos permite saber si el usuario tiene html5-> Podemos poner más condicionales por encima o en paralelo:
//por ejemplo para cuando el usuario se encuentre en otras áreas de la web.


//Esta función nos devolverá false si no queremos utilizar AJAX.
function getPartOfTheSite() {

    var url = window.location.href;
    var splits = url.replace('http://', '').split('/');
    var PartesSite = new Array('wp-admin','forums','preguntas-cirujano-ocular','tecnologia-lentes-intraoculares');

    if (PartesSite.indexOf(splits[1]) > -1) {
        console.log('ajax deshabilitado');
        return false;
    }
    else {
        console.log('ajax habilitado');
        return true;
    }
    return false;

}


//Cargamso la variable con la url del sitio en función del get locale.

if(ncSITE.Country){
    //console.log('Lo ha cogido y es: '+site.Country);
    switch(ncSITE.Country)
        {
        case 'es_ES':
                    urlSITE = 'www.nuevocristalino.es';
            break;
        case 'es_MX':
                    urlSITE = 'www.nuevocristalino.mx';
            break;
        case 'en_GB':
                    urlSITE = 'www.newlens.co.uk';
            break;
        case 'de_DE':
                    urlSITE = 'www.neuelinsen.com';
            break;
        case 'es_CO':
                    urlSITE = 'www.nuevocristalino.co';
            break;
        case 'fr_FR':
                    urlSITE = 'www.nouveaucristallin.com';
            break;
        case 'es_CL':
                    urlSITE = 'www.nuevocristalino.cl';
            break;
        case 'de_AT':
                    urlSITE = 'www.neuelinsen.at';
            break;
        case 'en_US':
                    urlSITE = 'www.mylifestylelens.com';
            break;


            default:
                    urlSITE = 'www.nuevocristalino.es';            }
        }else{
                    urlSITE = 'www.nuevocristalino.es';
            }



if(getPartOfTheSite()){
if (typeof history.pushState !== "undefined") {
    console.log("historyCount puesto a 0" );
    var historyCount = 0;
    //A continuación estamos asignando la función gotoMain...
    //A los links que no necesitan un remplazo de toda la página puesto que están en un submenú(:el main de ese grupo ya se ha descargado), tendremos que asignarles el gotoContent.

    var selectorsArrayNoGoToMain = new Array(   'a[href *= "http://'+urlSITE+'/wp-admin"]',
                                                'div.link-to-archive a',
                                                '#top-header-blog a',
                                                'div.groupLinkToPage a',
                                                '#changeFilter a',
                                                'a[href*="http://'+urlSITE+'/logout"]',
                                                '#dc_jqmegamenu_widget-2-item ul#menu-menu-site li:nth-child(7) .sub-container.non-mega li:nth-child(2) a',
                                                '#news #foro a ',
                                                '#destacados .destacado2 h2 a',
                                                '#lateral-presbicia a',
                                                '#LinkPages.testPagination a',
                                                'a.bbp-topic-edit-link ',
                                                'a[rel=lightbox]',
                                                '#menu-header-foro a',
                                                '#submisojos a',
                                                '#subfaqs a',
                                                '#menu-menu-explicacion-tipos-lio a',
                                                '.submenu-pages #menu-menu-tipos-lentes a',
                                                '#LinkPages.archiveLenteIntraocularAjaxer a',
                                                '#LinkPagesBis.archiveLenteIntraocularAjaxer a',
                                                'div#primary.site-content-archive-clinica #LinkPages a',
                                                'div#primary.site-content-archive-clinica #LinkPagesBis a',
                                                '#footer-wrap a',
                                                '#helpTitle a',
                                                '#menu-cirugia a',
                                                '#menu-cirugia-submenu a',
                                                '.noGotoMain',
                                                'div.footerClinicas a',
                                                '#loginStuff a.noGotoMain',
                                                '.content-destacado a',
                                                '.block h2 a',
                                                '.block-last h2 a',
                                                '#helpTitle a',
                                                '#testimonios-home a',
                                                '#top-header-qa a',
                                                '#mCLens a',
                                                'a.cboxElement',
                                                'a.linkSubTipoIol',
                                                'div.groupLinkArchive a',
                                                '#rightLogin a',
                                                '#community.rightProfile a',
                                                '.nWindIol',
                                                'div.moreClinics a',
                                                'div.bloq-single-lente.std div.value a',
                                                '.searchLink a',
                                                '#block1left a',
                                                'div.clinicListsWrapper a',
                                                '.widget_recent_entries ul li a',
                                                '.widget_categories ul li a',
                                                '#bbpress-forums a.bbp-breadcrumb-home',
                                                '#list-topic-forum ul li a',
                                                '#list-forum ul li a',
                                                '#list-countries-forum ul li a',
                                                '#list-about-forum ul li a',
                                                '#footer-wrap-blog a',
                                                '.slideImgWrapper a',
                                                'a.singleIOLFeatImage',
                                                'li#qa-current-url a',
                                                'div.archive-clinica-wrapper h1.archive-clinica-title a',
                                                'a.bbp-forum-title',
                                                'div#widget-forum ul.tml-user-links a',
                                                'a.bbp-breadcrumb-forum',
                                                'a.bbp-topic-permalink',
                                                '#qa-menu ul li:nth-child(3) a',
                                                'div.question-summary h3 a',
                                                'div.yarpp-related a',
                                                '#qSugLinks ul li a',
                                                '#bbpress-forums li.bbp-forum-freshness a',
                                                '#changeModeHelp',
                                                'div.contenidoCallToQuestion a',
                                                '#buscadorBody footer#colophon a',
                                                '.firstPoint a',
                                                '.rightBCWrapper2 a',
                                                '#content.template-bucador-clinicas #sponsoredListWrapper a',
                                                '#mVisitedClinics a', //:not(#buscadorBody footer#colophon a)
                                                '#menu-menu-site > li:nth-child(7) > a',
                                                //Vamos a meter algunos de scroll
                                                'div.leermas-blog a',
                                                'aside.widget-container.widget_display_replies ul li a',
                                                'ul#recentcomments li.recentcomments a',
                                                'div.qa-pagination a',
                                                '#grey-in #grey3 h2 a',
                                                'aside.widget-container.widget_question_tags div.question-tagcloud a',
                                                'aside.widget-container.widget_question_categories ul li a',
                                                'aside.widget-container.widget_questions ul li a'

                                            );
         var selectorsStringNoStandardGoToMain = selectorsArrayNoGoToMain.join(',');

    //alert('Modificación de historial del navegador');
        jQuery(' a[href*="http://'+urlSITE+'"]:not('+selectorsStringNoStandardGoToMain+')').live('click', function () {
             var href = jQuery(this).attr('href'); //#rightFaqsSxCataratas a,

         if ((jQuery(this).attr('href').indexOf('forums') != -1) || (jQuery(this).attr('href').indexOf('tecnologia-lentes-intraoculares') != -1) || (jQuery(this).attr('href').indexOf('preguntas-cirujano-ocular') != -1)) {

                 } else {

            //alert('Cogida por goToMain');
            goToMain(href);
            history.pushState(null, null, href);
              //AVISO GAnalytics cambio de página
            href = href.replace('http://' + document.domain, ''); //GA_CHANGE
            ga('send', 'pageview',href);

            console.log('pushState llevado a cabo a:' + href + 'como asignación automática de goToMain');
                 return false;
           }
     });

    jQuery('#menu-menu-cirugia a').live('click', function(){
        var href = jQuery(this).attr('href');
        goToMain(href,'#menu-cirugia');
        history.pushState(null, null, href);
        //AVISO GAnalytics cambio de página
        href = href.replace('http://' + document.domain, ''); //GA_CHANGE
        ga('send', 'pageview',href);

        console.log('#menu-cirugía no ha sufrido fade en teoría, pushState llevado a cabo a:' +href +'como asignación automática de goToMain');

        return false;
    });
    //En los siguientes hay scroll top (metemos también el de explicación básica)
    var selectorsArrayScroll = new Array(
                                         '#content.template-clinicas div.clinicListsWrapper a',
                                         '#block1left a',
                                         '#mCLens a',
                                         'a.linkSubTipoIol',
                                         'div.groupLinkArchive a',
                                         'div.groupLinkToPage a',
                                         'div.moreClinics a',
                                         'div.bloq-single-lente.std div.value a',
                                         '.widget_recent_entries ul li a',
                                         '.widget_categories ul li a',
                                         '#list-topic-forum ul li a',
                                         '#list-forum ul li a',
                                         'div.archive-clinica-wrapper h1.archive-clinica-title a',
                                         '.secondPoint a',
                                         '.thirdPoint a',
                                         //Vamos a meter algunos de scroll.
                                         'div.leermas-blog a',
                                         'aside.widget-container.widget_display_replies ul li a',
                                         'ul#recentcomments li.recentcomments a',
                                         'div.qa-pagination a',
                                         'aside.widget-container.widget_question_tags div.question-tagcloud a',
                                         'aside.widget-container.widget_question_categories ul li a',
                                         'aside.widget-container.widget_questions ul li a'
                                        );
     var selectorsStringScroll = selectorsArrayScroll.join(',');
    jQuery(selectorsStringScroll+':not(#buscadorBody footer#colophon a)').live('click', function (){
        var href = jQuery(this).attr('href');
        goToMain(href,null,'ScrollTop');
        history.pushState(null, null, href);
        //AVISO GAnalytics cambio de página
        href = href.replace('http://' + document.domain, ''); //GA_CHANGE
        ga('send', 'pageview',href);

        return false;

    });




    //El que descarga los resultados de satisfacción del paciente necesita una función específica
       jQuery('#dc_jqmegamenu_widget-2-item ul#menu-menu-site li:nth-child(7) .sub-container.non-mega li:nth-child(2) a, #destacados .destacado2 h2 a, #destacados .destacado1 h2 a, #testimonios-home a').live('click', function () {
        var href = jQuery(this).attr('href');
        surgeryShowResultsLoader();
        goToMain(href,null,'ScrollTop');
        history.pushState(null, null, href);

        //AVISO GAnalytics cambio de página
        href = href.replace('http://' + document.domain, ''); //GA_CHANGE
        ga('send', 'pageview',href);

        console.log('pushState llevado a cabo a:' + href + 'como asignación automática de goToMain');
          return false;
         });


    //Metemos ahora los de cirugías.
    //Con el de ayuda no queremos hacer push state
    jQuery('#submisojos a,#subfaqs a, .submenu-pages #menu-menu-tipos-lentes a').live('click', function () {
        var href = jQuery(this).attr('href');
        goToContent(href);
        history.pushState(null, null, href);
        //AVISO GAnalytics cambio de página
        href = href.replace('http://' + document.domain, ''); //GA_CHANGE
        ga('send', 'pageview',href);

        console.log('pushState llevado a cabo a:' +href +'como asignación automática de goToMain');

        return false;
    });
    //-- Los links de ayuda van con la función goToHelp
    jQuery('#helpTitle a').live('click', function () {
        var href = jQuery(this).attr('href');
        //El resto de parámetros lo vamos a sacar mediante data attributes del link.
        idToGet = jQuery(this).data('idtoget');
        //console.log('El idToGet es: ' + idToGet);
        idToReplace = jQuery(this).data('idtoreplace');
        //console.log('El idToReplace es: ' + idToReplace);
        if (jQuery(this).data('selectorsnottofade') == "") {
            selectorsNotToFade = null;
        }
        if (jQuery(this).data('scrolltop') == "") {
            scrollTop = jQuery(this).data('scrolltop');
        }


        goToHelp(href, idToGet, idToReplace); //, selectorsNotToFade, scrollTop
        //console.log('goToHelp llamada y ejecutada');

        return false;
    });

    //Ahora los links de la paginación del test merecen una llamada a gotomain específica
    jQuery('#LinkPages.testPagination a').live('click', function () {
        var href = jQuery(this).attr('href');
        goToMain(href, "#LinkPages.testPagination", 'yes');
        console.log('Específico para paginación del test');
        return false;

    });


    //A los links de abajo y a los de #content-destacado le damos el scroll to top.
     jQuery('#destacados .destacado1 h2 a, #mVisitedIols a:not(#buscadorBody footer#colophon a), #corporativeLinks a:not(#buscadorBody footer#colophon a), div.link-to-archive a:not(#buscadorBody footer#colophon a), .content-destacado a, .block-last h2 a, .block h2 a, block-last h2 a:not(#buscadorBody footer#colophon a)').live('click', function(){

        var href = jQuery(this).attr('href');
        goToMain(href,null,'scrollTop');
        history.pushState(null, null, href);
        //AVISO GAnalytics cambio de página
        href = href.replace('http://' + document.domain, ''); //GA_CHANGE
        ga('send', 'pageview',href);

        return false;
     });

     //Parte izquierda del menú de presbicia
     jQuery('#lateral-presbicia #menu-cirugia-submenu a').live('click', function () {

         var href = jQuery(this).attr('href');
         goToContent(href);
         history.pushState(null, null, href);
         //AVISO GAnalytics cambio de página
         href = href.replace('http://' + document.domain, ''); //GA_CHANGE
         ga('send', 'pageview',href);

        return false;
     });

     jQuery('#leftFaqsPresbicia a').live('click', function () {

         var href = jQuery(this).attr('href');
         goToContent(href, jQuery(this).data('hashidselector'));
         history.pushState(null, null, href);
         //AVISO GAnalytics cambio de página
         href = href.replace('http://' + document.domain, ''); //GA_CHANGE
         ga('send', 'pageview',href);

        return false;
     });

     //Cargamos la función scroll to de la parte derecha de Operación Cataratas.
    /* jQuery('#rightFaqsSxCataratas li a').live('click', function () {
         scrollToElement(jQuery(jQuery(this).data('hashidselector')));

         return false;
     });*/


    //Cargamos ahora la función Onpopstate
    //El evento onpopstate está asociado al navegador no al link: Hay que poner el gotoMain o el gotoContent en función de función de la url.
    //La url destino te viene dada por el document.location


     window.onpopstate = function () {
         //Esto es para el primer onpopsate de Chrome.
         if (historyCount) {
             var urlActual = document.location;
             console.log('esto nos va a lelvar a ' + urlActual);
             goToMain(urlActual);

             //window.location.href = urlActual;
             //Para mejorar la experiencia del usuario habrá que poner en qué casos hay goToMain y en cuales window.location.href
             console.log('onpopstate activada. HistoryCount con valor: ' + historyCount);
         }else{
         console.log('historyCount ha dado false');
         //historyCount = historyCount + 1;
         }
     }


     //El problema es que Firefox no dispara el evento onpopstate con el load de la primera página.


     jQuery(window).load(function () {
         console.log("1185");
         var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
         console.log('El hostname es: ' + location.hostname);
         console.log('el docuemnt referer es: ' + document.referrer);
         if ((jQuery.browser.mozilla && !historyCount && (document.referrer.indexOf(location.hostname) == -1)) || (isChrome && !historyCount && (document.referrer.indexOf(location.hostname) == -1))) {
             href = window.location;
             history.pushState(null, null, href);
             historyCount = historyCount + 1;
             console.log('historyCount puesto a' + historyCount);
             console.log('Pushsate llevado a:' + href);
         }
         //No tenemos que forzar nosotros el pushState puesto que ya lo hace el propio nav pero resetea nuestro contador de historial
         //con lo que hay que reiniciarlo con valor 1.
         historyCount = historyCount + 1;
         console.log('esta página se ha cargado viniendo del site, ponemos el history count a: 1');
     })


}
}

//Cuando se trate de los links del submenú de la página de explicación para pacientes:

jQuery(document).ready(function () {

    if (jQuery("#left-explicacion-lio").length) {

        //Ya que estamos cargando la función del submenú. Al ser una página tan larga vamos a hacer que el menú se deslice al hacer scroll.
        activacionLeftMenuScroller();
        scrollToOnClick();
    }
});


//Función que convierte el menú de la izquierda en scrollable
  function activacionLeftMenuScroller(){
        var $sidebar = jQuery("#left-explicacion-lio"),
        $window = jQuery(window),
        offset = $sidebar.offset(),
        topPadding = 90;
        docheight = jQuery(document).height();

        $window.on('scroll', function () {
            if (($window.scrollTop() > offset.top) && ($window.scrollTop() < (docheight-800))) { //si es menos de 800px se va de varas
                $sidebar.stop().animate({
                    marginTop: $window.scrollTop() - offset.top + topPadding
                });
            } else {
                $sidebar.stop().animate({
                    marginTop: 70
                });
            }
        });

        //Vamos a intentar que la función anterior no se ejecute si está haciendo hover sobre el menú.
        jQuery("#left-explicacion-lio").hover(
          function () {
              hovering = true;
              $window.off('scroll');
          },
    function () {
        $window.on('scroll', function () {
            if (($window.scrollTop() > offset.top) && ($window.scrollTop() < (docheight-800))) {
                $sidebar.stop().animate({
                    marginTop: $window.scrollTop() - offset.top + topPadding
                });
            } else {
                $sidebar.stop().animate({
                    marginTop: 70
                });
            }
        });
    }
);
}

//Function scrollto on link para el menú izquierdo de explicación de tipos de lentes
function scrollToOnClick(){

        //La siguiente función se encarga de ir a la parte deseada del documento.
    jQuery("#left-explicacion-lio a").click(function () {
        var linkHash = jQuery(this).attr('href').split('#')[1];

        jQuery('html, body').animate({
            scrollTop: jQuery('a[name=#' + linkHash + ']').offset().top
        }, 2000);
        return false;
    });
 }



//Creamos una función que nos devuelva un 1 o un 0 en función de si hay que llamar a goToMain o gotoContent.
function urlDivContentChecker(url){
    var urlContent = new Array(
              'el-ojo-y-la-vision',
              'cataratas-oculares',
              'condiciones-refractivas',
              'el-ojo-y-la-vision',
              'preguntas-frecuentes-cataratas',
              'preguntas-frecuentes-presbicia',
              'preguntas-frecuentes-lentes-intraoculares-premium'
              );
   // console.log(url.href);

     for (var i = 0; i < urlContent.length; i++) {
             //alert(myStringArray[i]);
             //Do something
         var index = (url.href).indexOf(urlContent[i]);

             if(index != -1){
                 return 1;
                 console.log('No sale del Loop');
             }
        }
        return 0;
        }


//Funciones para el cambio de filtro en singleIolTemplate y archiveIolTemplate.
//Creamos una función para Sustituir el PatientForm por el avanzado.
function getForm(action,qString) {
    console.log('Función getForm llamada¡¡');
    console.log('La acción es:'+action);
    //console.log('llamada de verdad');
	var postId = '';
	var textPostId='';

	//alert(action);
	//al query string vamos a añadirle el postId si estamos en el single LenteIntraocular.
	if(jQuery('#singleIolTemplate').length){
		 postId = jQuery("#postId").html();
		 textPostId = '&postId='+ postId;
	}

	data = qString+'&action='+action+textPostId+'&getform=getform';//get_adv_iol_filter_form
    data = data.replace('?','');
    jQuery('#right form, #right H3').fadeTo('slow', 0.5);//'#right

    jQuery.ajax({
        url: the_ajax_script.ajaxurl,
     	data: data,
     //   cache: false,
        success: function (response) {
            //console.log(response);

            //Cargamos los scripts de la respuesta.
            //De la función respuesta tambien cogeremos #main -> En un segundo paso esto no será necesario puesto que será lo único que devolvamos con ajax.
            console.log('Petición Ajax realizada con éxito');

            var mainContent = response;//jQuery(response).filter('#right');//response;

            //jQuery('#right').remove();

            console.log('sin sustituir');
            //jQuery('#right').empty();
    //1        jQuery('#right').html(mainContent);//#right



            //Vamos a ver como podemos no mostrar la vista si estamos en la página de modelos
            if(jQuery('#tipoIolTemplate').length && jQuery('#modelosIol').length ){
            jQuery('#comboViewType').remove();
            //	jQuery(mainContent).remove('#comboViewType');
            }



            console.log('Formulario Remplazado');
            jQuery('#right form, #right H3').fadeTo('fast', 1);//#righ

            //Vamos a detectar la función que actualiza el pannel.

             //update the page title
             var title = jQuery('#main').find('h1').text();
             jQuery('head').find('title').text(title);
        },
        complete: function(){
    //Hay que pasar una función de carga de Formularios u otra y cambiar el parámetro de la url añadiendo o retirando el pt=yes
       if(action == "getPatientForm" || action == "getSinglePatientForm"){
      console.log('Solo pasamos el NCCleaner');
    	console.log('inicio del formateo');
  //1  	PatientFormLoader();
    	jQuery('.startsUgly').show();//css('display','block');
  //1	buttonsChangeFilterLoader();

		//Tenemos que updatear en right la clase de trackeo de paciente
//1	jQuery('#right').removeClass('pteNoDisplay');
//1		jQuery('#right').addClass('pteDisplay');
                //Punto de identificación de Paciente
                if(!jQuery.cookie('ncpatient')){
	 					jQuery.cookie('ncpatient','ncpatient', { path: '/' });
	 					console.log('Cookie colocada y función version disparada en buttonsChangeFilterLoader');
	 					//versionNC();
//1	versionNcUpdater();
versionNcUpdater();
	 				}else{
	 			//1	versionNCcleaner();
	 				versionNcUpdater();
	 				}



    }

    if(action == "getAdvForm" || action == "getSingleAdvForm"){

    console.log('Solo pasamos el NCCleaner');
 //1       var a = new Array(rangeAddMinfAdd, rangeAddMsupAdd, rangeMinfAsf, rangeMsupAsf, rangeMinfDoptic, rangeMsupDoptic, rangeMinfEsf, rangeMsupEsf, rangeMinfCil, rangeMsupCil, rangeMinfDtot, rangeMsupDtot,rangeMinfTInci, rangeMsupTInci);
 //1       iolFormComboboxInputSlider();
 //1       iolFormButtonAccordionLoader();
 //1       iolFormSeteoSliders(a);
        //Hacemos que la multifocalidad esté en disabled por defecto.
 //1       jQuery("#addDisabler").DisablerButton();
    	jQuery('.startsUgly').css('display','block');

    	console.log('si si si');
//1		buttonsChangeFilterLoader();
		//
//1		jQuery('#right').removeClass('pteDisplay');
//1		jQuery('#right').addClass('pteNoDisplay');


		//PUNTO DE IDENTIFICACIÓN DE NO PACIENTE
			 //Retiramos la cookie de paciente y hacemos los cambios pertinentes
	 if(jQuery.cookie('ncpatient')){
	 			jQuery.cookie('ncpatient',null, { path: '/' });
	 			//versionNC();
	 			versionNcUpdater();

	 		console.log('Formulario avanzado cargado y cookie retirada');
		}else{
			//versionNCcleaner();
			versionNcUpdater();
		}
		//

    }



        }

    });


}


jQuery(document).ready(function(){

	buttonsChangeFilterLoader();
});

//var buttonChangeCheck = false;

//Función que asigna la función ajax a los botones.
function buttonsChangeFilterLoader(){


if(jQuery('#changeFilter').length){
    //Ahora es cuando asignamos las funciones de cambio de filtro
    jQuery('#changeFilter a#changeModeLink').each(function () { //jQuery('#changeFilter button').each(function(){
        jQuery(this).off();
        jQuery(this).on('click', function () {

            var action = jQuery(this).data('action');
            //alert(action);
            var qString = location.search;
            //Tenemos que mandar también la query string para que puedan seleccionarse los valores correspondientes.
            getForm(action, qString);
            //Vamos a ver como podemos llevar el traqueo de que estamos en "modo" paciente.


            //Necesitamos una función que añada si no existe el pt=yes a todos los links cada vez que se clickee el button "alternativo" y a la url actual..
            //Detectamos si el botón clickeado es el de PatientForm.
            if (action == 'getSinglePatientForm') {
                //alert('dentro de getSinglePatientForm');
                console.log('getSinglePatientForm LLAMADOOOOO');
                jQuery('#menu-menu-site a').each(function () {//not('#footer-wrap a, #top-header a, #menu-menu-site a')
                    var hrefA = jQuery(this).attr('href');
                    if (hrefA != undefined) {
                        if (hrefA.indexOf("?pt=no") != -1) {
                            hrefA = hrefA.replace("pt=no", "pt=yes"); //No remplazamos nada lo dejamos como está
                        	//hrefA = hrefA + '?';
                        }
                        else {
                            //hrefA = hrefA + "?pt=yes"; //Me voy a cargar lo del pt=yes => Problemas de SEO
                        	hrefA = hrefA + '?';
                        }

                        jQuery(this).attr('href', hrefA);
                    }
                });

                //Vamos a poner


                //Punto de identificación de Paciente
                if(!jQuery.cookie('ncpatient')){
	 					jQuery.cookie('ncpatient','ncpatient', { path: '/' });
	 					console.log('Cookie colocada y función version disparada en buttonsChangeFilterLoader');
	 					//versionNC();
	 					versionNcUpdater();
	 				}

            }
            //Detectamos si es el advanced
            if (action == 'getSingleAdvForm') {

                jQuery('#menu-menu-site a').each(function () { //not('#footer-wrap a, #top-header a')
                    var hrefA = jQuery(this).attr('href');
                    console.log('por aquí');
                    if (hrefA != undefined) {
                        if (hrefA.indexOf("pt=yes") != -1) {
                            hrefA = hrefA.replace("pt=yes", "pt=no"); //Quitamos los pt=yes que haya// No remplazamos nada lo dejamos como está
                        }
                        else {
                            hrefA = hrefA + "?"; //No añadimos nada. pt=no
                        }
                        jQuery(this).attr('href', hrefA);
                    }
                });

                		//PUNTO DE IDENTIFICACIÓN DE NO PACIENTE
			 //Retiramos la cookie de paciente y hacemos los cambios pertinentes
	 if(jQuery.cookie('ncpatient')){
	 			jQuery.cookie('ncpatient',null, { path: '/' });
	 			//versionNC();
				versionNcUpdater();
	 		console.log('Formulario avanzado cargado y cookie retirada en buttonsChangeFilterLoader');
		}
		//

            }
            return false;
        });

    });

	}

	}

//Función para añadir,mofidifcar parámetros de la url.

/*
I have expanded the solution and combined it with another that I found to replace/update/remove the querystring parameters based on the users input and taking the urls anchor into consideration.

Not supplying a value will remove the parameter, supplying one will add/update the paramter. If no URL is supplied, it will be grabbed from window.location
*/
function UpdateQueryString(key, value, url) {
    if (!url) url = window.location.href;
    var re = new RegExp("([?|&])" + key + "=.*?(&|#|$)(.*)", "gi");

    if (re.test(url)) {
        if (typeof value !== 'undefined' && value !== null)
            return url.replace(re, '$1' + key + "=" + value + '$2$3');
        else {
            return url.replace(re, '$1$3').replace(/(&|\?)$/, '');
        }
    }
    else {
        if (typeof value !== 'undefined' && value !== null) {
            var separator = url.indexOf('?') !== -1 ? '&' : '?',
                hash = url.split('#');
            url = hash[0] + separator + key + '=' + value;
            if (hash[1]) url += '#' + hash[1];
            return url;
        }
        else
            return url;
    }
}

//Añadimos lo siguiente para que no salga el select de vista en la página de modelos IOL.
jQuery(document).ready(function () {
    if (jQuery('#modelosIol').length) {
        jQuery('#comboViewType').remove();
    }


    //Cargamos el evento click una sóla vez.
    submenuMisOjosClick();

    //Hacemos el checkeo para que desaparezcan los items de menú.
    //Esta también es para el Ajax.
    showHideSubmenuMisOjos();

})

//Añadimos el asunto con el submenú de anatomía.

function showHideSubmenuMisOjos(){
    if(jQuery('#cornea').length){ //a[href="#cornea"]

        jQuery('#submisojos #menu-menu-anatomia-ojo .sub-menu').css('display','block');
    }else{
         jQuery('#submisojos #menu-menu-anatomia-ojo .sub-menu').fadeOut();
        }
}

function submenuMisOjosClick(){
    jQuery('#submisojos #menu-menu-anatomia-ojo .sub-menu a').each(function () {
        jQuery(this).on('click', function () {
            scrollToElement(jQuery(jQuery(this).attr('href')));
        });
    });
        }

function scrollToElement(ele) {
//jQuery(window).scrollTop(ele.offset().top).scrollLeft(ele.offset().left);
jQuery('html, body').stop().animate({
'scrollTop': ele.offset().top
}, 1500, 'swing', function () {
//window.location.hash = target;
});
}


//Vamos a crear ahora una función goHelp(url,idToReplace, idToGet, selectorsNotToFade,scrollTop...) a imagen y semejanza de GoToMain y gotocontent.

//Vamos ahora a implementar ajax en los links del menú principial que vayamos viendo -> cambiará también la url.

function goToHelp(href,idToGet,idToReplace,selectorsNotToFade,scrollTop) {

    console.log('Función goToHelp llamada');

    /* Función Ajax que realiza el remplazo del contenido y la actualización de la url (Tmabién hará la llamada a GAnlytics) */
    jQuery.ajax({
        url: href,
        //   cache: false,
        beforeSend: function (data) {
            console.log('#' + idToReplace + 'Es el que en teoría se fadeado');
            jQuery('#' + idToReplace).fadeTo('slow', 0.5);

        },
        success: function (data) {
            //De la función respuesta tambien cogeremos #main -> En un segundo paso esto no será necesario puesto que será lo único que devolvamos con ajax.
            console.log('Petición Ajax Helpsrealizada con éxito');
            //En esta función el id a coger y el id a remplazar son sendos parámetros.
            var responseContentGot = jQuery(data).find('#' + idToGet).html();

            //alert(responseContentGot);
            jQuery('#' + idToReplace).html(responseContentGot);
            console.log('Contenido Central Remplazado');
            jQuery('#' + idToReplace).fadeTo('slow', 1);
            //Aquí no Necesitamos además cargar los scripts que activan los elementos presentes en la respuesta¡¡

            //Hacemos visibles todos los elementos que tengan la clase de .startsUgly.
            jQuery(".startsUgly").show();

            //update the page title
            var title = jQuery('#main').find('h1').text();
            jQuery('head').find('title').text(title);
        },
        complete: function (data) {
            if (typeof scrollTop !== "undefined") {
                //Por ejemplo en los links del footer habrá que hacerle scroll.
              if(jQuery("#menu-site").length){
                jQuery("html, body").animate({ scrollTop: jQuery("#menu-site").offset().top }, 2000);
				}

			  /*if(jQuery("#qa-menu").length){
				  console.log('al qa-menu');
                jQuery("html, body").animate({ scrollTop: jQuery("#qa-menu").offset().top }, 2000);
				}*/


            }
            //Ejecutamos el lightbox
            jQuery('a[rel=lightbox]').colorbox({maxWidth:'90%', maxHeight:'90%'});
            //Actualizamos la url -> Esta es una diferencia importante respecto al gotoMain que no incluía este paso.
            history.pushState(null, null, href);
            //AVISO GAnalytics cambio de página
            href = href.replace('http://' + document.domain, ''); //GA_CHANGE
            ga('send', 'pageview',href);

            console.log('pushState llevado a cabo a:' + href + 'como asignación automática de goToMain');

        }
    });

}


//Añadimos la clase select al link que haya sido clickeado en el menú de cirugías.
function addSelectToMenuCirugia(){
        var url = window.location.href;
         //Tenemos que diferenciar el template de Presbicia del template del resto de cirugías.
         if (jQuery('#lateral-presbicia #menu-cirugia a[href="' + url + '"]').length) {
                     jQuery('#menu-cirugia #menu-menu-cirugia li:nth-child(5) a').addClass('selected');
            }else{
            jQuery('#menu-cirugia a[href="'+url+'"]').addClass('selected');
                    }

         //Aplicamos la class seleccionado al item del submenú que corresponda de presbicia
         if (jQuery('#lateral-presbicia #menu-cirugia a[href="' + url + '"]').length) {
            jQuery('#lateral-presbicia #menu-cirugia a[href="' + url + '"]').parent().addClass('seleccionado');
           }



            //Aprovechamos esta función para que si se trata de presbicia añadamos la clase cuando está seleccionado.
        if(jQuery('#submenu-lateral-presbicia li').length){
             jQuery('#submenu-lateral-presbicia li').on('click', function(){
             jQuery('#submenu-lateral-presbicia li').each(function(){
                  jQuery(this).removeClass('seleccionado');
                     })
             jQuery(this).addClass('seleccionado');
               });
          }

     }
//Añadimos lo mismo para el menú de los tipos de lentes.

function addSelectToMenuTiposIol(){
        var url = window.location.href;


            if(jQuery('.menu-menu-tipos-lentes-container a[href="'+url+'"]').length)
            {
            jQuery('.menu-menu-tipos-lentes-container a[href="'+url+'"]').parent().addClass('seleccionado');
                    }

            //Aprovechamos esta función para que si se trata de presbicia añadamos la clase cuando está seleccionado.
            if(jQuery('.menu-menu-tipos-lentes-container li').length){
           jQuery('.menu-menu-tipos-lentes-container li').on('click', function(){
               jQuery('.menu-menu-tipos-lentes-container li').each(function(){
                           jQuery(this).removeClass('seleccionado');
                                   })
         jQuery(this).addClass('seleccionado');
           });
          }
        }



    jQuery(document).ready(function () {
          if (jQuery('#menu-cirugia').length || jQuery('#templateCirugiaOcular').length) {
              addSelectToMenuCirugia();
             }
          if(jQuery('.menu-menu-tipos-lentes-container').length){
          	  addSelectToMenuTiposIol();
            }

          });
