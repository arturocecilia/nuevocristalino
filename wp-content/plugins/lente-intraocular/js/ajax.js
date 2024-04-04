//Centralizamos

function userEsPaciente(){

	if(jQuery.cookie('ncpatient') == 'ncpatient' ){ // , { path: '/' } && jQuery.cookie('ncpatient') != 'null'
		console.log('ESTAMOS EN MODO PACIENTE');
		return true;
	}else{
		console.log('NO ESTAMOS EN MODO PACIENTE');
		return false;
	}
}



function versionNCcleaner(){
	if(userEsPaciente()){
			jQuery('.pteNoDisplay').css('display','none');
			jQuery('.pteDisplay').css('display','block');

	}else{
			jQuery('.pteNoDisplay').css('display','block');
			jQuery('.pteDisplay').css('display','none');


	}

}



/*Prueba para ve si la caché se regenera*/

function versionNcUpdater(){
	if(userEsPaciente()){
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
			console.log('#preButtonSetSingle #helpTitle a, puesto a 520');
			jQuery('#preButtonSetSingle #helpTitle a').css('left',520);
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
			jQuery('#preButtonSetSingle #helpTitle a').css('left',615);
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
		 if(userEsPaciente()){

	 			if(jQuery.removeCookie('ncpatient', { path: '/', domain:document.domain }) || jQuery.removeCookie('ncpatient', { path: '/', domain:'.nuevocristalino.es' })){//este es el bueno
	 			console.log('Cookie retirada correctamente');
	 			}
	 			console.log('cambiado a modo profesional');
	 			goToMain(window.location.href);
	 			return;
	 			//location.reload();
	 			}
	 	   if(!userEsPaciente()){
	 			jQuery.cookie('ncpatient','ncpatient', { path: '/', domain:document.domain});
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
      console.log('addCallToquestion ejecutada');

}




jQuery(document).ready(function(){
	versionNcUpdater();
	console.log('versionNcUpdater trigeado');
	    //Si estamos en la página del buscador de lentes directamente cambiamos el modo de nuevocristalino a professional.
	if(jQuery('#buscadorIol').length){
	 //Hacemos un cambio rápido a modo prof-> quitamos la cookie si está definida
	 if(userEsPaciente()){
	 		jQuery.removeCookie('ncpatient', { path: '/', domain :document.domain });
	 		jQuery.removeCookie('ncpatient', { path: '/', domain:'.nuevocristalino.es' })

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

		jQuery.cookie('version','mobile', { path: '/' });
   		jQuery("head").append('<link rel="stylesheet"  id="mobile-css" type="text/css" href="<?php echo get_home_url(); ?>/wp-content/themes/iol/css/mobile.css" />"');

   console.log('Cambiando a móvil');
   	location.reload();//Si metemos true no usará la cache
    	return false;
    });

    //Además tenemos que incluir la condición de que el tipo quiera versión classica en dispositivo móvil
	if((jQuery.cookie('version') == 'classic' )&& jQuery('#mobile-css').length){
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

            href = href.replace('https://' + document.domain, ''); //GA_CHANGE
            ga('send', 'pageview',href);
console.log('1');
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

								//Vamos a meter aquí el scroll top para que el usuario movil se enter.
											if(jQuery(window).width() < 600){
																if(jQuery('.site-content-archive-lentes').length){
																		scrollToElement(jQuery('h1.archive-title'));
																		}
										}



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
       href = href.replace('https://' + document.domain, ''); //GA_CHANGE
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
        href = href.replace('https://' + document.domain, ''); //GA_CHANGE
        ga('send', 'pageview',href);
console.log('2');
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








//El siguiente condicional nos permite saber si el usuario tiene html5-> Podemos poner más condicionales por encima o en paralelo:
//por ejemplo para cuando el usuario se encuentre en otras áreas de la web.


//Esta función nos devolverá false si no queremos utilizar AJAX.
function getPartOfTheSite() {

    var url = window.location.href;
    var splits = url.replace('https://', '').split('/');
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



Ajaxor();


//Funciones de manejo de redes sociales.
    //Metemos aquí las redes sociales.
     function linkedInShare() {
 							   jQuery.getScript('https://platform.linkedin.com/in.js', function() {
      					 //jQuery('#linkedInWrapper').append('<script type="IN/Share" data-id="10034187"><\/script>');
      					 jQuery('#linkedInWrapper').append('<script type="IN/FollowCompany" data-id="10034187"></script>');
    						})}

		function twitterFollow(){
			!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
			}


//Cuando se trate de los links del submenú de la página de explicación para pacientes:

jQuery(document).ready(function () {

    if (jQuery("#left-explicacion-lio").length) {

        //Ya que estamos cargando la función del submenú. Al ser una página tan larga vamos a hacer que el menú se deslice al hacer scroll.
        activacionLeftMenuScroller();
        scrollToOnClick();
    }

    if (jQuery("#menu-menu-anatomia-ojo").length) {
				scrollToOnClickAnatomy();
				}


     if(jQuery( "#linkedInWrapper" ).length) {
  						// Handler for .load() called.
									linkedInShare();
							console.log('Linkedin cargado');
									twitterFollow();
							console.log('twitter cargado');
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
            scrollTop: jQuery('a[name="#' + linkHash + '"]').offset().top
        }, 2000);
        return false;
    });
 }


function scrollToOnClickAnatomy(){

        //La siguiente función se encarga de ir a la parte deseada del documento.
    jQuery("#menu-menu-anatomia-ojo ul.sub-menu a").click(function () {
        var linkHash = jQuery(this).attr('href').split('#')[1];
        console.log('Esto va a dar error: jQuery(\'#' + linkHash + '\').offset().top');
        jQuery('html, body').animate({
            scrollTop: jQuery('#' + linkHash + '').offset().top //a[name="#' + linkHash + '"]
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

                if(!userEsPaciente()){
	 					jQuery.cookie('ncpatient','ncpatient', { path: '/', domain :document.domain });//,domain:document.domain
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
	 if(userEsPaciente()){

	 			jQuery.removeCookie('ncpatient', { path: '/', domain :document.domain });
	 			jQuery.removeCookie('ncpatient', { path: '/', domain:'.nuevocristalino.es' })


	 			//versionNC(); , domain:document.domain
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
                if(!userEsPaciente()){
	 					jQuery.cookie('ncpatient','ncpatient', { path: '/', domain :document.domain });
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
	 if(userEsPaciente()){
	 			jQuery.removeCookie('ncpatient', { path: '/', domain:document.domain });
			  jQuery.removeCookie('ncpatient', { path: '/', domain:'.nuevocristalino.es' })
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

    //Aplicamos el accordion a los menus de profile y area interna.
    accordionProfAndMyNC();

})

function accordionProfAndMyNC(){

	if(jQuery('#menu-menu-myprofile, #menu-menu-myprofile-mync').length){
		exeVerticalAccordion('#menu-menu-myprofile, #menu-menu-myprofile-mync');
		}
  if(jQuery('#menu-menu-mync,#menu-menu-mync-myprofile').length){

		exeVerticalAccordion('#menu-menu-mync,#menu-menu-mync-myprofile');
		}
	console.log('acordion vertical realizada');
	}

function exeVerticalAccordion(selector){

	jQuery(selector).dcAccordion({
																									eventType: 'click',
																									hoverDelay: 0,
																									menuClose: true,
																									autoClose: true,
																									saveState: true,
																									autoExpand: true,
																									classExpand: 'current-menu-item',
																									classDisable: '',
																									showCount: false,
																									disableLink: true,
																									cookie: selector,//'menu-menu-myprofile'
																									speed: 'slow'
																									});

	}


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
            jQuery('a[rel=lightbox],a[data-lightboxplus=lightboxplus]').colorbox({maxWidth:'90%', maxHeight:'90%'});
            //Actualizamos la url -> Esta es una diferencia importante respecto al gotoMain que no incluía este paso.
            history.pushState(null, null, href);
            //AVISO GAnalytics cambio de página
            href = href.replace('https://' + document.domain, ''); //GA_CHANGE
            ga('send', 'pageview',href);
console.log('6');
            console.log('pushState llevado a cabo a:' + href + 'como asignación automática de goToMain');

        }
    });

}


//Añadimos la clase select al link que haya sido clickeado en el menú de cirugías.
function addSelectToMenuCirugia(){

console.log('addSelectToMenuCirugia disparado');

        var url = window.location.href;
         //Tenemos que diferenciar el template de Presbicia del template del resto de cirugías.
         if (jQuery('#lateral-presbicia #menu-cirugia a[href="' + url + '"]').length) {
                     jQuery('#menu-cirugia #menu-menu-cirugia li:nth-child(5) a').addClass('selected');
            }else{
							  jQuery('#menu-cirugia a').removeClass('selected');
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
