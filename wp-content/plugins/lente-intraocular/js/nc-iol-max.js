//jQuery UI para los comboboxes;
//Definición de función de activación de los comboboxes.
  (function( jQuery ) {
    jQuery.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = jQuery( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = jQuery( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: jQuery.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
      
//RETIRAR SI NO FUNCIONA¡¡¡¡
       /* Snip */
/*select: function( event, ui ) {
    ui.item.option.selected = true;
    self._trigger( "selected", event, {
        item: ui.item.option
    });
    select.trigger("change");                            
},*/
/* Snip */
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        jQuery( "<a>" )
          .attr( "tabIndex", -1 )
          //.attr( "title", "Mostrar todos los valores" ) => Lo quitamos porque en el ipad es un coñazo.
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( jQuery.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = jQuery( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( jQuery( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " ningún valor coincidente" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
      },
      //Esta es de cosecha propia
      refresh:function(){ 
             selected = this.element.children( ":selected" );
             this.input.val(selected.text());
         },

      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
 
  function iolFormComboboxInputSlider(){
    //Activamos los Comboboxes de los filtros de IOL.    
    jQuery( "#comboboxTipo,#comboboxFabricante,#comboboxDiseLente,#comboboxMatLente,#comboboxDiseHaptic,#comboboxTipoLente" ).combobox(); //,#comboboxViewType

    jQuery("#iol_filter_form #comboboxViewType").combobox({
        select: function (event, ui) {
            //var currentQString = jQuery('#currentQueryString').html();
            //alert(currentQString);
            var urlAjaxQuery = jQuery('#currentQueryString').text();
            console.log('urlAjaxQuery: ' + urlAjaxQuery);
            var viewTypeValue = jQuery('#comboboxViewType').val();
            var newUrlAjaxQuery = UpdateQueryString('viewType', viewTypeValue, urlAjaxQuery);

            var newAjaxQuery = newUrlAjaxQuery.substring(newUrlAjaxQuery.lastIndexOf("?") + 1, newUrlAjaxQuery.length);
            //alert(newUrlAjaxQuery.lastIndexOf("?"));
            //alert(newAjaxQuery);
            //console.log('newUrlAjaxQuery: ' + newUrlAjaxQuery);
            if (jQuery('#archiveIolTemplate').length) {
                //Vamos a añadirle un parámetro si está en el buscador de iols.
                if(jQuery("#buscadorIol").length){
                 archive_submit_me(newAjaxQuery + '&buscador=True');   
                }        
                else{
                archive_submit_me(newAjaxQuery);
                }
            }

        } // selected
    });          // combo


    //Activamos los checkboxes y los inputs radio de los filtros de IOL.
    jQuery( "#toricidadFilter, #filtrosFilter,#asfericidadFilter,#bordeCuadFilter,#ppOpticoFilter,#diseLenteFilter,#inyectorFilter, #precargadaFilter" ).buttonset();
    
    //Activamos el Slider Range de Adición-> Ya con valores correctos : 2.5 a 4 en steps de 0.5
    jQuery( "#slider-range-add" ).slider({
      range: true,
      min: 1.5,
      max: 4,
      values: [ 1.5, 4 ],
      step:0.25,
      slide: function( event, ui ) {
        jQuery( "#amount-add" ).val( ui.values[ 0 ] + " diopt - " + ui.values[ 1 ]+" diopt" );
      }
    });
    jQuery( "#amount-add" ).val( jQuery( "#slider-range-add" ).slider( "values", 0 )+" diopt"  +
      " - " + jQuery( "#slider-range-add" ).slider( "values", 1 ) + " diopt");
    
    //Activamos el Slider Range de Diametro Óptica-> de 5 a 7 en steps de 0.25

    jQuery( "#slider-range-diamOptic" ).slider({
      range: true,
      min: 5,
      max: 7,
      values: [ 7, 7 ],
      step:0.25,
      slide: function( event, ui ) {
        jQuery( "#amount-diamOptic" ).val( ui.values[ 0 ] + " mm - " + ui.values[ 1 ]+" mm" );
      }
    });
    jQuery( "#amount-diamOptic" ).val( jQuery( "#slider-range-diamOptic" ).slider( "values", 0 )+" mm"  +
      " - " + jQuery( "#slider-range-diamOptic" ).slider( "values", 1 ) + " mm");
    //Activamos el Slider Range de Diametro Total. 7 - 15

    jQuery( "#slider-range-diamTot" ).slider({
      range: true,
      min: 7,
      max: 15,
      values: [ 7, 15 ],
      step:0.1,
      slide: function( event, ui ) {
        jQuery( "#amount-diamTot" ).val( ui.values[ 0 ] + " mm - " + ui.values[ 1 ]+" mm" );
      }
    });

    jQuery( "#amount-diamTot" ).val( jQuery( "#slider-range-diamTot" ).slider( "values", 0 )+" mm"  +
      " - " + jQuery( "#slider-range-diamTot" ).slider( "values", 1 ) + " mm");

     //Añadimo el de tamaño de incisión
    jQuery( "#slider-range-tamaInci" ).slider({
      range: true,
      min: 1.2,
      max: 5,
      values: [ 1.2, 5 ],
      step:0.1,
      slide: function( event, ui ) {
        jQuery( "#amount-tamaInci" ).val( ui.values[ 0 ] + " mm - " + ui.values[ 1 ]+" mm" );
      }
    });

    jQuery( "#amount-tamaInci" ).val( jQuery( "#slider-range-tamaInci" ).slider( "values", 0 )+" mm"  +
      " - " + jQuery( "#slider-range-tamaInci" ).slider( "values", 1 ) + " mm");

    //Fin del slider de tamaño de incisión.


     //Activamos el Slider Range de Asfericidad 0 - 1
    jQuery( "#slider-range-asferic" ).slider({
      range: true,
      min: -0.5,
      max: 0.5,
      values: [ -0.5, 0.5 ],
      step:0.01,
      slide: function( event, ui ) {
        jQuery( "#amount-asferic" ).val( ui.values[ 0 ] + " um - " + ui.values[ 1 ]+" um" );
      }
    });

    jQuery( "#amount-asferic" ).val( jQuery( "#slider-range-asferic" ).slider( "values", 0 )+" um"  +
      " - " + jQuery( "#slider-range-asferic" ).slider( "values", 1 ) + " um");
    //Activamos el Slider Range de Rango de Dioptrías Esféricas -30 a 60 en steps de 0.1
    jQuery( "#slider-range-esfera" ).slider({
      range: true,
      min: -30,
      max: 60,
      values: [ 0, 30 ],
      step: 0.1,
      slide: function( event, ui ) {
        jQuery( "#amount-esfera" ).val( ui.values[ 0 ] + " diopt. - " + ui.values[ 1 ]+" diopt." );
      }
    });
    //Valores de dioptráis de esfera:
    jQuery( "#amount-esfera" ).val( jQuery( "#slider-range-esfera" ).slider( "values", 0 )+" diopt."  +
      " - " + jQuery( "#slider-range-esfera" ).slider( "values", 1 ) + " diopt.");
    //Activamos el Slider Range de Rango de Dioptrías Cilindricas 0 - 
    jQuery( "#slider-range-cilinder" ).slider({
      range: true,
      min: -10,
      max: 10,
      values: [ -10, 10 ],
      step: 0.1,
      slide: function( event, ui ) {
        jQuery( "#amount-cilinder" ).val( ui.values[ 0 ] + " diopt. - " + ui.values[ 1 ]+" diopt." );
      }
    });
    jQuery( "#amount-cilinder" ).val( jQuery( "#slider-range-cilinder" ).slider( "values", 0 )+" diopt."  +
      " - " + jQuery( "#slider-range-cilinder" ).slider( "values", 1 ) + " diopt.");

      /* En los elementos que acabamos de crear en jQuery UI hay que meter en el evento cambio que ajecuten: archive_submit_me()*/

      //Detectamos que estamos en la página del buscador.

      if(jQuery('#buscadorIol').length){
          //Evento cambio en Comboboxes.
          jQuery("#comboboxTipo,#comboboxFabricante,#comboboxDiseLente,#comboboxMatLente,#comboboxDiseHaptic,#comboboxTipoLente").combobox({
              select: function (event, ui) {
                  archive_submit_me();
                      }
                });
           //Evento cambio en buttonsets.
           jQuery("#toricidadFilter, #filtrosFilter,#asfericidadFilter,#bordeCuadFilter,#ppOpticoFilter,#diseLenteFilter,#inyectorFilter, #precargadaFilter").on("change", function () {
                  archive_submit_me();
            });
           //Evento de cambio en los sliders.
           
           jQuery( "#slider-range-add,#slider-range-diamOptic,#slider-range-diamTot,#slider-range-tamaInci,#slider-range-asferic,#slider-range-esfera" ).slider({
                    stop: function( event, ui ) {
                       archive_submit_me(); 
                    }
                });
                

      }



      }
         
  function iolFormButtonAccordionLoader(){
      //simpleAccordion
      jQuery("#simpleAccordionFilter").accordion({
          collapsible: true,
          active: 0,
          heightStyle: "content"
      });

      //Activamos el Accordion del Filtro Avanzado.
       jQuery("#advancedAccordionFilter").accordion({
          collapsible: true,
          active: 0,
          heightStyle: "content",
          activate: function (event, ui) {
              //console.log(event);
              //console.log(ui);
              if (jQuery('#advancedAccordionFilter h3').hasClass('ui-state-active')) {
                  AdvancedFilterEnablerF();
                  console.log('Enabler Disparado');
              }
          }
      });
      //surgeonAccordion
      //el parámetro de inico active será diferente si esta función se llama desde buscador iol o desde el site normal de nuevocristalino.
      var activadoSurg = false;
      if(jQuery('#buscadorIol').length){
          activadoSurg = 0;
      }
      jQuery("#surgeonAccordionFilter").accordion({
          collapsible: true,
          active: activadoSurg, //false
          heightStyle: "content",
          activate: function (event, ui) {
              //console.log(event);
              //console.log(ui);
              if (jQuery('#surgeonAccordionFilter h3').hasClass('ui-state-active')) {
                  //SurgeonFilterEnablerF();
                  console.log('No disparamos el surgeon filter enabler');
              }


          }
      });
	//Vamos a ver si podemos hacer los accordions draggables.
	jQuery("#simpleAccordionFilter,#advancedAccordionFilter,#surgeonAccordionFilter").each(
	function(){
	var thisHandlerid = "#dragger-"+jQuery(this).attr("id");
	//Cargamos que el handler sólo sea handler, no colapse también.
	jQuery(thisHandlerid).on('click', function (){return false;})
	
	var thisReseterId = "#reseter-"+jQuery(this).attr("id"); 
	jQuery(thisReseterId).on('click', function (){return false;})

	//var position = jQuery(this).position();
	var left = jQuery(this).css('left');
	var top =  jQuery(this).css('top');
	//Vamos a ver si podemos hacer lo del draggable con reversión.
	
	jQuery(thisReseterId).click(function() {
    				jQuery(this).parent().parent().css({
        					'left': 		'0px',//left,//jQuery(this).data('originalLeft'),
        					'top':  		'0px',//top,//jQuery(this).data('origionalTop')
    						'position':		'relative',
    						'box-shadow':	'none'
    										});
			});
	
	
	//console.log(thisHandlerid);
	jQuery(this).draggable({
	//Añadimos el tema del container.
		containment: "document",
		handle: thisHandlerid,
	    //vamos a cambiar la propiedad de posición en cuanto se fije.
		start: function( event, ui ) {
			jQuery(this).css('width',jQuery(this).parent().width());
			jQuery(this).css('z-index',1600);
			//ponemos la sombra.
			jQuery(this).css('-moz-box-shadow', '0 0 5px #888');
			jQuery(this).css('-webkit-box-shadow','0 0 5px#888');
			jQuery(this).css('box-shadow','0 0 5px #888');
		},
		stop: function( event, ui ) {
			jQuery(this).css('width',jQuery(this).parent().width());
			
			var topElement = jQuery(this).offset().top;
			var docScroll  = jQuery(document).scrollTop();
			//alert(topElement);
			var leftElement = jQuery(this).offset().left; 
			jQuery(this).css('position','fixed').css('top',topElement - docScroll).css('left',leftElement);
		}
	}
	)}
	);

	//Cargamos también el botón de reseteo.
	jQuery("#searchReset").click(function() {
		//Cuando tientes el panel de información abierto y reseteas "casca"
		//Cuando tienes parámetros en la url no resetea.
	
	
	   //Está expandido (Si está expandido no puede estar comprimido).
    /*         if (Clickeado == 1) {
					ifExpandedCollapse();
                    }
                else {
                     //Está colapsado y sin comprimir.
                     if(Clickeado == 0 && Comprimido ==0){                       
                     stylesCerrarIzqArriba();
                     Comprimido = 1;
                      }
                }*/
		
		var currentUrl = location.href; 
		var strippedHref = currentUrl.substring(0, currentUrl.indexOf('?'));
		//antes de llamar a goToMain, quitamos directamente del documento el panel de información.
       	
       	//Vamos a copiar la función que se ejecuta al darle a cerrar porque así parece que funciona cerrado parece que funciona ok.

                 //Está expandido (Si está expandido no puede estar comprimido).
                 if (Clickeado == 1) {
						ifExpandedCollapse();
                     }
                 else {
                       //Está colapsado y sin comprimir.
                       if(Clickeado == 0 && Comprimido ==0){                       
                       stylesCerrarIzqArriba();
                       Comprimido = 1;
                       }
                 }


       	jQuery('#iolInfoPannel').remove();
       	
   	    //var Clickeado = 0;
		//Definimos también comprimido, cuando está en 0 es que no está comprimido en 1 sí.
		//var Comprimido = 0;
        goToMain(strippedHref);
       	
	});


      //Disabler Buttons:
      //1-Enumeración.Lista 2-Activación 3-ClickEvent Definition
      //1 Óptica:

      //1-Enumeración
      var sliderButtonsSurgeonEnaDisIDs = "#opticDiameterDisabler,#totalDiameterDisabler,#dioptEsfDisabler,#dioptCilDisabler,#asfericityDisabler,#addDisabler, #tamaInciDisabler";//
      //Hemos añadido el addDisabler aunque esté en el primer accordion.

      jQuery(sliderButtonsSurgeonEnaDisIDs).each(
      //2.Activación.
         function () {
             jQuery(this).button({
                 icons: {
                     primary: "ui-icon-close"
                 },
                 text: false
             });
             //3-ClickEvent Definition
             jQuery(this).click(function () {
                 console.log("disabler pulsado");
                 if (jQuery(this).parent().children('input').prop('disabled')) {//jQuery("#amount-diamOptic")
                     console.log("El botón estaba en disabled-> pasamos a ponerlo en enabled");
                     jQuery(this).parent().children('input').prop('disabled', false);
                     jQuery(this).button({ icons: { primary: "ui-icon-check"} });
                     jQuery(this).removeClass("noEnvia").addClass("envia");
                     jQuery(this).parent().children('.ui-slider').css('opacity', '1'); //#opticDiameterDisabler
                     jQuery(this).button("refresh");
                 }
                 else {
                     console.log("El botón estaba en enabled");
                     jQuery(this).parent().children('input').prop('disabled', true);
                     jQuery(this).button({ icons: { primary: "ui-icon-close"} });
                     jQuery(this).addClass("noEnvia").removeClass("envia");
                     jQuery(this).parent().children('.ui-slider').css('opacity', '0.3'); //#opticDiameterDisabler
                     jQuery(this).button("refresh");
                 }
                 return false;
             });

         });

      jQuery("#surgeonFiltersDisabler").button({
          icons: {
              primary: "ui-icon-close"
          },
          text: false
      });
      jQuery("#surgeonFiltersEnabler").button({
          icons: {
              primary: "ui-icon-check"
          },
          text: false
      });

      jQuery("#advancedFiltersDisabler").button({
          icons: {
              primary: "ui-icon-close"
          },
          text: false
      });

      jQuery("#advancedFiltersEnabler").button({
          icons: {
              primary: "ui-icon-check"
          },
          text: false
      });


      //Llamamos a las funciones correspondientes.
      jQuery("#surgeonFiltersDisabler").click(function () {
          //Llamada a la función advancedFilterDisablerF     
          //AdvancedFilterDisablerF(); => De momento sólo deshabilitaré los Surgeon
          SurgeonFilterDisablerF();
          return false;
      });
      jQuery("#surgeonFiltersEnabler").click(function () {

          //AdvancedFilterEnablerF(); => De momento sólo deshabilitaré los Surgeon.
          SurgeonFilterEnablerF('all');
          return false;
      });
      jQuery("#advancedFiltersDisabler").click(function () {
          //Llamada a la función advancedFilterDisablerF     
          //AdvancedFilterDisablerF(); => De momento sólo deshabilitaré los Surgeon
          AdvancedFilterDisablerF();
          console.log('Advanced filter disabler se ha disparado');
          return false;
      });
      jQuery("#advancedFiltersEnabler").click(function () {

          //AdvancedFilterEnablerF(); => De momento sólo deshabilitaré los Surgeon.
          AdvancedFilterEnablerF();
          return false;
      });

      //Cargamos los checkboxes que tengan una de las opciones S/E, lo que haremos será inhabilitar el input que esté activado.
      //El primero el de los filtros.
      jQuery('#filtrosFilterDefault').click(function () {
          if (jQuery("#UV").prop('checked')) {
              jQuery("#UV").prop('checked', false);
              jQuery('#UV').button("refresh");
          }
          if (jQuery("#LuzAzul").prop('checked')) {
              jQuery("#LuzAzul").prop('checked', false);
              jQuery('#LuzAzul').button("refresh");
          }
      });

      jQuery('#UV,#LuzAzul').click(function () {
          if (jQuery("#filtrosFilterDefault").prop('checked')) {
              jQuery("#filtrosFilterDefault").prop('checked', false);
              jQuery('#filtrosFilterDefault').button("refresh");
          }
      });

      //Seguimos con los principios ópticos.  ppOpticoFilterDefault
      jQuery('#ppOpticoFilterDefault').click(function () {
          if (jQuery("#pRefractiva").prop('checked')) {
              jQuery("#pRefractiva").prop('checked', false);
              jQuery('#pRefractiva').button("refresh");
          }
          if (jQuery("#pDifractiva").prop('checked')) {
              jQuery("#pDifractiva").prop('checked', false);
              jQuery('#pDifractiva').button("refresh");
          }
          if (jQuery("#pMixta").prop('checked')) {
              jQuery("#pMixta").prop('checked', false);
              jQuery('#pMixta').button("refresh");
          }
      });

      jQuery('#pRefractiva,#pDifractiva,#pMixta').click(function () {
          if (jQuery("#ppOpticoFilterDefault").prop('checked')) {
              jQuery("#ppOpticoFilterDefault").prop('checked', false);
              jQuery('#ppOpticoFilterDefault').button("refresh");
          }
      });

      //A no ser que se desplieguen los dos filtros estarán desactivados.
      SurgeonFilterDisablerF();
    //  AdvancedFilterDisablerF();

}

function iolFormSeteoSliders(a) { 
    var rangeAddMinfAdd = a[0];
    var rangeAddMsupAdd = a[1];
    var rangeMinfAsf = a[2];
    var rangeMsupAsf = a[3];
    var rangeMinfDoptic = a[4];
    var rangeMsupDoptic = a[5];
    var rangeMinfEsf = a[6];
    var rangeMsupEsf = a[7];
    var rangeMinfCil = a[8];
    var rangeMsupCil = a[9];
    var rangeMinfDtot = a[10];
    var rangeMsupDtot = a[11];
    var rangeMinfTInci = a[12];
    var rangeMsupTInci = a[13];


    //Slider de multifocalidad Presbicia.
    jQuery("#slider-range-add").slider("values",0,rangeAddMinfAdd); // sets second handle (index 1) to 80
    jQuery("#slider-range-add").slider("values",1,rangeAddMsupAdd); // sets second handle (index 1) to 80  
    jQuery( "#amount-add" ).val( rangeAddMinfAdd+" diopt - "+ rangeAddMsupAdd+" diopt" );
    //Slider de Asfericidad.
    jQuery("#slider-range-asferic").slider("values",0,rangeMinfAsf); // sets second handle (index 1) to 80
    jQuery("#slider-range-asferic").slider("values",1,rangeMsupAsf); // sets second handle (index 1) to 80  
    jQuery( "#amount-asferic" ).val( rangeMinfAsf+" um - "+rangeMsupAsf+" um" );
    //Slider de Diámetro de óptica.
    jQuery("#slider-range-diamOptic").slider("values",0,rangeMinfDoptic); // sets second handle (index 1) to 80
    jQuery("#slider-range-diamOptic").slider("values",1,rangeMsupDoptic); // sets second handle (index 1) to 80  
    jQuery( "#amount-diamOptic" ).val( rangeMinfDoptic+" mm - "+rangeMsupDoptic+" mm" );
    //Slider Esfera.
    jQuery("#slider-range-esfera").slider("values",0,rangeMinfEsf); // bla blasets second handle (index 1) to 80
    jQuery("#slider-range-esfera").slider("values",1,rangeMsupEsf); // sets second handle (index 1) to 80  
    jQuery( "#amount-esfera" ).val( rangeMinfEsf+" diopt - "+rangeMsupEsf+" diopt");
    //Slider Cilindro.
    jQuery("#slider-range-cilinder").slider("values",0,rangeMinfCil); // sets second handle (index 1) to 80
    jQuery("#slider-range-cilinder").slider("values",1,rangeMsupCil); // sets second handle (index 1) to 80  
    jQuery( "#amount-cilinder" ).val( rangeMinfCil+" diopt - "+rangeMsupCil+" diopt" );
    //Slider diámetro total.
    jQuery("#slider-range-diamTot").slider("values",0,rangeMinfDtot); // sets second handle (index 1) to 80
    jQuery("#slider-range-diamTot").slider("values",1,rangeMsupDtot); // sets second handle (index 1) to 80  
    jQuery( "#amount-diamTot" ).val( rangeMinfDtot+" mm - "+rangeMsupDtot+" mm" );
        //Slider diámetro total.
    jQuery("#slider-range-tamaInci").slider("values",0,rangeMinfTInci); // sets second handle (index 1) to 80
    jQuery("#slider-range-tamaInci").slider("values",1,rangeMsupTInci); // sets second handle (index 1) to 80  
    jQuery( "#amount-tamaInci" ).val( rangeMinfTInci+" mm - "+rangeMsupTInci+" mm" );
    
}


//Activamos los accordions los buttons y los inputs y sliders.
jQuery(function () {
    
    if (jQuery("#iol_filter_form").length) {
     
        var a = new Array(rangeAddMinfAdd, rangeAddMsupAdd, rangeMinfAsf, rangeMsupAsf, rangeMinfDoptic, rangeMsupDoptic, rangeMinfEsf, rangeMsupEsf, rangeMinfCil, rangeMsupCil, rangeMinfDtot, rangeMsupDtot,rangeMinfTInci, rangeMsupTInci);
        iolFormComboboxInputSlider();
        iolFormButtonAccordionLoader();
        iolFormSeteoSliders(a);
        //Hacemos que la multifocalidad esté en disabled por defecto.
        jQuery("#addDisabler").DisablerButton();
    }
});


jQuery.fn.DisablerButton =function () { 
        jQuery(this).parent().children('input').prop('disabled', true);
        jQuery(this).button({ icons: { primary: "ui-icon-close"} });
        jQuery(this).addClass("noEnvia").removeClass("envia");
        jQuery(this).parent().children('.ui-slider').css('opacity', '0.3'); //#opticDiameterDisabler
        jQuery(this).button("refresh");
        }
 

       //Definición de la función AdvancedFilterDisablerF: Esta función lo que hace es deshabilitar todos los inputs del "avanzado".
       //Los inputs del filtro avanzado son los que no están en el simple y los que no hacen referencia a metadatos (que están en el surgeon).
 function AdvancedFilterDisablerF() {
          //input radio y checkboxes por un lado y comboboxes por el otro. jQuery('#bordeCuadFilter').children('input') jQuery("#comboDiseLente").children('span.custom-combobox').children('input')
          var inputRCAdvancedIds = '#bordeCuadFilter,#ppOpticoFilter,#inyectorFilter,#precargadaFilter';
          jQuery(inputRCAdvancedIds).each(function () {
              jQuery(this).children('input').button('disable');
              jQuery(this).children('input').button('refresh');
          });

          var inputComboAdvancedIds = '#comboboxDiseLente,#comboboxMatLente,#comboboxDiseHaptic';
          jQuery(inputComboAdvancedIds).each(function (){
                    jQuery(this).parent().find("input.ui-autocomplete-input").autocomplete("option", "disabled", true).prop("disabled", true);
                    jQuery(this).parent().find("a.ui-button").button("disable");
                    jQuery(this).children('span.custom-combobox').children('input').addClass('ui-state-disabled').removeClass('ui-state-default');
                    jQuery(this).attr('disabled', true);
          });
      }
     
      function AdvancedFilterEnablerF() {

          var inputRCAdvancedIds = '#bordeCuadFilter,#ppOpticoFilter,#inyectorFilter,#precargadaFilter';
          jQuery(inputRCAdvancedIds).each(function () {
              jQuery(this).children('input').button('enable');
              jQuery(this).children('input').button('refresh');
          });
          var inputComboAdvancedIds = '#comboboxDiseLente,#comboboxMatLente,#comboboxDiseHaptic';
          jQuery(inputComboAdvancedIds).each(function (){
                    jQuery(this).parent().find("input.ui-autocomplete-input").autocomplete("option", "disabled", false).prop("disabled", false);
                    jQuery(this).parent().find("a.ui-button").button("enable");
                    jQuery(this).children('span.custom-combobox').children('input').addClass('ui-state-default').removeClass('ui-state-disabled');
                    jQuery(this).attr('disabled', false);
          });
      }
       
      //Ahora definimos la función de Disabler del Surgeon filter (Recordamos que sólo contiene los inputs que refieran a metadatos):
      //valor numérico de asfericidad, diámetro de óptica, diámetro total, rangos dióptr esféricos, rangos dioptr cilíndricos.

      function SurgeonFilterDisablerF() {
            //1-Selección Enumeración de Inputs.2- Disable de inputs 3- Disable de Buttons Asociados.

            //1.Selección-Enumeración de Inputs.
            var inputsSurgeonSliderFilterIDs = "#amount-diamOptic,#amount-tamaInci,#amount-diamTot,#amount-asferic,#amount-esfera,#amount-cilinder";
            jQuery(inputsSurgeonSliderFilterIDs).each(
            function () { 
                //2.Disable de Inputs
                jQuery(this).prop('disabled', true);
                //3.Disable de Buttons Asociados
                 jQuery(this).prop('disabled', true);
                 jQuery(this).parent().children(':button').button({ icons: { primary: "ui-icon-close"} });
                 jQuery(this).parent().children(':button').addClass("noEnvia").removeClass("envia");
                 jQuery(this).parent().children('.ui-slider').css('opacity', '0.3'); //#opticDiameterDisabler
                 jQuery(this).parent().children(':button').button("refresh");
                }
            );
      }

       
      //Ahora definimos la función del Enabler del Surgeon Filter.
      function SurgeonFilterEnablerF(alpha) {
      	 //En esta función vamos a limitar el enablizado automático en el single lente intraocular cuando la lente no presente.
      	 //los valores correspondientes a esos inputs.


          var inputsSurgeonSliderFilterIDs = "#amount-diamOptic,#amount-tamaInci,#amount-diamTot,#amount-asferic,#amount-esfera,#amount-cilinder";
      	 
      	 //Condición para detectar que efectivamente es un single lente intraocular y no activar los valores que la lente no tuviese definidos. 
      	 if(jQuery('#singleIolTemplate').length){
         	 var selectorsNotToEnableAuto = jQuery('#inputSelectorsToDisable').html();
      	     //var inputsSurgeonSelectorToEnable =  inputsSurgeonSliderFilterIDs + ':not('+selectorsNotToEnableAuto+')';
      	   	 //alert(inputsSurgeonSelectorToEnable);
      	 }
      	 else{
	      	 var selectorsNotToEnableAuto = '';  	 
      	 }
      	 //Cuando sea llamada esta función desde el right archive, no activará inputs que no hayan estado especificados en la query.
      	 if(jQuery('#archiveIolTemplate').length){
        	 var selectorsNotToEnableAuto = jQuery('#inputSelectorsToDisable').html();
      	 }
      	 
            if(alpha == 'all'){
             selectorsNotToEnableAuto='';
            }
		

          jQuery(inputsSurgeonSliderFilterIDs).not(selectorsNotToEnableAuto).each(
          function () { 
                  jQuery(this).prop('disabled', false);
                  jQuery(this).parent().children(':button').button({ icons: { primary: "ui-icon-check"} });
                  jQuery(this).parent().children(':button').removeClass("noEnvia").addClass("envia");
                  jQuery(this).parent().children('.ui-slider').css('opacity', '1'); //#opticDiameterDisabler
                  jQuery(this).parent().children(':button').button("refresh");
           }
          );
      }



jQuery(document).ready(function () {
    //alert('documento cargado');
    jQuery(".startsUgly").show();
    jQuery('a[rel*=lightbox]').colorbox();
});

/*js Necesario  para los filtros de paciente */


jQuery(document).ready(function () {

    PatientFormLoader();
});


function PatientFormLoader(){

    jQuery("#PatientAccordionFilter").accordion({
        collapsible: true,
        active: 0,
        heightStyle: "content"
    });
    //Cargamos los elementos del Form:

    //También hay que cargar el viewtype asociado pero en lugar de mandarlo al archive submit me al patient_submit_me();

    jQuery("#patient_iol_filter_form #comboboxViewType").combobox({
        select: function (event, ui) {
            console.log('evento del combo detectado');
            //var currentQString = jQuery('#currentQueryString').html();
            //alert(currentQString);
            var urlAjaxQuery = jQuery('#currentQueryString').text();

            var viewTypeValue = decodeURI(jQuery('#comboboxViewType').val());
            var newUrlAjaxQuery = UpdateQueryString('viewType', viewTypeValue, urlAjaxQuery);
            var newAjaxQuery = newUrlAjaxQuery.substring(newUrlAjaxQuery.lastIndexOf("?") + 1, newUrlAjaxQuery.length);

            //Si estamos en otra página que no sea la de archive NO ENVIAMOS EL FORMULARIO CON EL CAMBIO de número de elementos.
            if (jQuery('#archiveIolTemplate').length) {
                patient_submit_me(newAjaxQuery);
            }

        } // selected
    });       // combo



    //Input Monofocal.
    jQuery( "#pf-monofocal" ).button();
    jQuery( "#premiumInputs" ).buttonsetv();
    jQuery( "#correcAstigInputs" ).buttonset();
    jQuery( "#filtrosInputs" ).buttonsetv();
    jQuery( "#add-onInputs" ).buttonset();
    jQuery( "#icl, #verisyse").button();
    
    //Metemos la función que vincule el input de monofocal con el resto de premium inputs que también son de diseño de optica y con el resto de inputs que no sieno de diseño de óptica no pueden estar clickeados al mismo tiempo por ser incompatibles.
    
    jQuery('#premiumInputs').on("change", function(event){
             //Es input radio en cuanto se dispare el evento onchange es que el usuario ha clickeado.
      		//jQuery('#pf-monofocal,#icl, #verisyse, #add-onInputs input').removeProp('checked');
      		jQuery('#pf-monofocal,#icl, #verisyse, #add-onInputs input').prop('checked',false);
            jQuery('#pf-monofocal,#icl, #verisyse, #add-onInputs input').button('refresh');
      		      
        });
	//Hacemos lo mismo para el resto de inputs.
	 jQuery('#pf-monofocal').on("change", function (event){
	 		//jQuery('#premiumInputs input, #icl, #verisyse, #add-onInputs input').removeProp('checked');
            jQuery('#premiumInputs input, #icl, #verisyse, #add-onInputs input').prop('checked',false);
	 		jQuery('#premiumInputs input, #icl, #verisyse, #add-onInputs input').button('refresh');
	 	
	 });
	 
	 jQuery('#add-onInputs').on('change', function (event){
	 		//jQuery('#premiumInputs input, #icl, #verisyse, #pf-monofocal').removeProp('checked');
            jQuery('#premiumInputs input, #icl, #verisyse, #pf-monofocal').prop('checked',false);
	 		jQuery('#premiumInputs input, #icl, #verisyse, #pf-monofocal').button('refresh');
	 });


	 
	 
	 jQuery('#icl').on('click', function (event){
	 		jQuery('#premiumInputs input,#add-onInputs input, #verisyse, #pf-monofocal').removeProp('checked');
            jQuery('#premiumInputs input,#add-onInputs input, #verisyse, #pf-monofocal').prop('checked',false);
	 		jQuery('#premiumInputs input,#add-onInputs input, #verisyse, #pf-monofocal').button('refresh');
	 		/*jQuery('#premiumInputs input, #add-onInputs, #verisyse, #pf-monofocal').removeProp('checked');*/
	 		/*jQuery('#premiumInputs input, #add-onInputs, #verisyse, #pf-monofocal').button('refresh');*/
	 });
	 
	 jQuery('#verisyse').on('click', function (event){
	 		//jQuery('#premiumInputs input, #add-onInputs input, #icl , #pf-monofocal').removeProp('checked');
	 		jQuery('#premiumInputs input, #add-onInputs input, #icl , #pf-monofocal').prop('checked',false);
            jQuery('#premiumInputs input, #add-onInputs input, #icl, #pf-monofocal').button('refresh');
	 });
}

//Lógica del iolInfoPannel -> Definimos Clickeado como una variable Global.
//Cuando está en 0 es que no ha sido clickeado.
var Clickeado = 0;
//Definimos también comprimido, cuando está en 0 es que no está comprimido en 1 sí.
var Comprimido = 0;

jQuery(document).ready(function () {
    //Código para hacer que el div haga scroll con la página.
    iolInfoPannelLoader();
    //Cargamos también en #currentQueryString la querystring de la página
    iolQueryStringUpdater();
}
);

function iolQueryStringUpdater() { 
    if (jQuery('#currentQueryString').length && jQuery('#archiveIolTemplate').length) {
        var urlQString = location.search;
        urlQString = urlQString.replace('?','');
        if (urlQString.indexOf('action=filter_result') == -1) {
            urlQString = urlQString + '&action=filter_result';
            console.log('query string updateado en iolQueryStrngUpdater');
        }
        jQuery('#currentQueryString').text(the_ajax_script.ajaxurl + '?' + urlQString);
    }
}


function iolInfoPannelLoader(){
    if(jQuery('#iolInfoPannel').length){
    //console.log('ahora si que se ha guardado el cambio en iol.js');
    // check where the shoppingcart-div is  
    var offset = jQuery('#iolInfoPannel').offset();
    jQuery(window).scroll(function () {
        var scrollTop = jQuery(window).scrollTop();
        // check the visible top of the browser     
        if (offset.top < scrollTop) {
            jQuery('#iolInfoPannel').addClass('fixed');
        } else {
            jQuery('#iolInfoPannel').removeClass('fixed');
        }
    });

    //Función que se ejecuta cuando se clickee el header que realiza la expansion.
    // Para que funcione adecuadamente conviene definir unas funciones de inicio.



    jQuery("#expanderHead").click(function () {
        PannelClickResponse();
    });


    //
    console.log(jQuery('#iolInfoPannel').css('display'));
    jQuery('.draggable').draggable({ handle: "#dragger",containment: "document" });
    //En resizable metemos como mínima altura la propia del contenido que se ha cargado.

    //   console.log('La altura mínima es' + alturaContenidoPannel);
    jQuery('.resizable').resizable({ 'minWidth': 300 });
    jQuery('#iolInfoPannel').css('display', 'block');
}
}

function PannelClickResponse() { 
    //Ponemos primero el slider toggle para que no haya efectos raros.
        console.log(jQuery("#expanderContent").css('height'));
        //console.log('El valor actual de la variable Clickeado es:'+ Clickeado );
        var newAlturaContenidoPannel = parseInt(jQuery("#expanderContent").css('height').replace('px', '')) + 35;
        var newAnchuraContenidoPannel = parseInt(jQuery("#expanderContent").css('width').replace('px', '')) + 20;
        jQuery("#expanderContent").slideToggle('1000');

        //  Clickeado = 0 quiere decir que el container está cerrado.
        switch (Clickeado) {
            case 0:
                Clickeado = 1;
                jQuery("#expanderContent").css('visibility', 'visible');
                jQuery(".resizable").css('height', 'auto');
                jQuery(".resizable").resizable();
                jQuery(".resizable").resizable("option", "minHeight", newAlturaContenidoPannel);
                jQuery(".resizable").resizable("option", "minWidth", newAnchuraContenidoPannel);
                jQuery('#expanderSign').removeClass('ui-icon-carat-1-e').addClass('ui-icon-carat-1-s');
                break;
            case 1:
                console.log('Se está clickeando para colapsar el container: Ponemos clickeado a 0.');
                Clickeado = 0;
                jQuery("#expanderContent").css('visibility', 'hidden');
                //jQuery(".resizable").resizable("option", "minHeight", null);
                jQuery(".resizable").resizable('destroy'); //.resizable("option", {"minHeight": 20,"maxHeight": 25});
                jQuery(".resizable").css('height', '20');
                break;
        }
}

//Jquery para los botones del pannel de información.

jQuery(document).ready(function(){
      		buttonPannelLoader();  
      	}	  
    );


function buttonPannelLoader(){

         if(jQuery('#iolActionsContainer').length){
         
             jQuery('#iolInfoPannelMini').button({
                 icons: {
                     primary: "ui-icon-circle-minus"
                 },
                 text: false
             });
             
             jQuery('#iolInfoPannelMaxi').button({
                 icons: {
                     primary: "ui-icon-circle-plus"
                 },
                 text: false
             });
             
             
             jQuery('#iolInfoPannelClose').button({
                 icons: {
                     primary: "ui-icon-circle-close"
                 },
                 text: false
             });
             
             //3-ClickEvent Definition
             //Botón de cerrar.
             jQuery('#iolInfoPannelClose').click(function () {
             
                 //alert(Comprimido);
                 //console.log("disabler pulsado");
                 if (Clickeado == 0 && Comprimido != 1) {
                     //esto quiere decir que el pannel está minimizado=> habrá que estrecharlo y llevarlo a la derecha.	
                     stylesCerrarIzqArriba();
                     //ifExpandedCollapse();
                     Comprimido =1;
                     }
                 else {
                 console.log('Clickeado es: '+Clickeado);
                 console.log('Comprimido es: '+Comprimido);
                 		//Si el infoPannel está extendido
                 		if(Clickeado == 1 && Comprimido != 1){
                 		//alert('adsfad');
                 		ifExpandedCollapse();
                 		stylesCerrarIzqArriba();
                 		Comprimido =1;
                 		}
                 }
                 return false;
             });

              //Botón de cerrar.
             jQuery('#iolInfoPannelMaxi').click(function () {
             
                 //alert(Comprimido);
                 //Está colapsado y comprimido.
                 if (Clickeado == 0 && Comprimido == 1) {
                     //primero lo abrimos.
                     Comprimido = 0;	
                     stylesAbrir();
                     //Luego lo expandimos.
                     //setTimeout(function (){ifCollapsedExpand()},1000);
                     PannelClickResponse();
                     
                     }
                 else {
                       //Está colapsado y sin comprimir.
                       if(Clickeado == 0 && Comprimido ==0){                       
                       ifCollapsedExpand();
                       }
                 }
                 return false;
             });
             
             //Botón de Minimizar.
             jQuery('#iolInfoPannelMini').click(function () {
             
                 //Está expandido (Si está expandido no puede estar comprimido).
                 if (Clickeado == 1) {
						ifExpandedCollapse();
                     }
                 else {
                       //Está colapsado y sin comprimir.
                       if(Clickeado == 0 && Comprimido ==0){                       
                       stylesCerrarIzqArriba();
                       Comprimido = 1;
                       }
                 }
                 return false;
             });
           
             }
}
	//Aplica estilos para "cerrar" el info pannel
	function stylesCerrarIzqArriba(){
				var tempTrans = 1200;
           		//jQuery('.resizable').css('min-width','50px');//min-width: 315px;
           		//jQuery('h4#expanderHead, #expanderSign').css('display','none'); //width: 300px;
           		jQuery('h4#expanderHead, #expanderSign').hide(1000);//animate({display:"none"},4000);//css('display','none');           	
           		//jQuery('#resizableTitle').css('width','130px'); //430px 
          		jQuery('#expanderContent').css('width','80px');
          		jQuery('.resizable').css('min-width','140px'); //315px
         		jQuery('#resizableTitle').animate({width:"130px"},tempTrans);
           		//jQuery('div.draggable').css('left','0px').css('top','0px');
          		jQuery('div.draggable').animate({left:"0px", top:"0px"},tempTrans);

          		}
    function stylesAbrir(){
				var tempTrans = 1000;
       		jQuery('#expanderContent').css('width','380px');
			jQuery('#resizableTitle').animate({width:"430px"},tempTrans);//css('width','430px'); //430px 
			jQuery('h4#expanderHead, #expanderSign').show(1000); //width: 300px;
			jQuery('.resizable').css('min-width','315px');  

    }      		
          		
    //Función en la que si el pannel está expandido, lo contrae. Sin no lo está no hace nada.      		
    function ifExpandedCollapse(){
    		if (Clickeado ==1 ){
    		    jQuery("#expanderContent").slideToggle();
                console.log('Estaba expandido y lo contraemos, ponemos clickeado a 0.');
    			//console.log('Se está clickeando para colapsar el container.');
                Clickeado = 0;
                jQuery("#expanderContent").css('visibility', 'hidden');
                //jQuery(".resizable").resizable("option", "minHeight", null);
                jQuery(".resizable").resizable('destroy'); //.resizable("option", {"minHeight": 20,"maxHeight": 25});
                jQuery(".resizable").css('height', '20');
    		}

		return;
    }
    //Función simétrica a la anterior si está contraido, lo expande, si no, lo contrae.
	function ifCollapsedExpand(){
             if(Clickeado == 0){
    			Clickeado = 1;
                jQuery("#expanderContent").slideToggle();
                jQuery('#expanderContent').animate({width:'380px'});
                jQuery("#expanderContent").css('visibility','visible');
               // console.log(jQuery("#expanderContent").html());
       	        var newAlturaContenidoPannel = jQuery("#expanderContent li").length*20 +80;
       	        //parseInt(jQuery("#expanderContent").css('height').replace('px', '')) + 35;
       	        console.log('Altura del slide calculada: ' +newAlturaContenidoPannel);
                var newAnchuraContenidoPannel = parseInt(jQuery("#expanderContent").css('width').replace('px', '')) + 20;
                console.log('Y la anchura es:'+ newAnchuraContenidoPannel);
                jQuery("#expanderContent").css('opacity',0);//animate({opacity:'0'});//hide();//css('visibility','hidden');

                
                //Vamos a hacer que la visibilidad de vuelta sea gradual.
                jQuery("div#expanderContent").animate({opacity:1},1000);//show('4000')
                jQuery(".resizable").css('height', 'auto');
                jQuery(".resizable").resizable();
                jQuery(".resizable").resizable("option", "maxHeight", newAlturaContenidoPannel);//newAlturaContenidoPannel
                jQuery(".resizable").resizable("option", "minWidth", newAnchuraContenidoPannel);//newAnchuraContenidoPannel
                
                //jQuery(".resizable").resizable("option", { "minHeight": alturaContenidoPannelFinal });
                jQuery('#expanderSign').removeClass('ui-icon-carat-1-e').addClass('ui-icon-carat-1-s');
                      
		}
		return;
	}
	
	//activar mañanana las imagenes en colorbox jQuery('a').colorbox();
	//Crear campo de texto que onkey dispare queries.
	
var timeoutReference;
jQuery(document).ready(function() {

	iolTextSearch();

});

//hacemos lo de siempre: metemos las instruccines en una función para poder llamarla en el goToMain

function iolTextSearch(){
    
    jQuery('input#iolName').keypress(function() {
        var el = this; // copy of this object for further usage

        if (timeoutReference) clearTimeout(timeoutReference);
        timeoutReference = setTimeout(function() {
            doneTyping.call(el);
        }, 750);
    });
    jQuery('input#username').blur(function(){
        doneTyping.call(this);
    });

}


function doneTyping(){
    // we only want to execute if a timer is pending
    if (!timeoutReference){
        return;
    }
    // reset the timeout then continue on with the code
    timeoutReference = null;

    //
    // Code to execute here
    //
    //alert('This was executed when the user is done typing.');
    //alert(jQuery('input#iolName').val());
    
    //Tenemos que pasar también el tipo de visualización que está seleccionada en el selectView Type:
    var viewType = jQuery('#comboboxViewType').val();
    var grid;
    	if(!viewType){
     			grid ="viewType = 4";
    		}else{
		    	grid= "viewType="+viewType;
    		}
    
    var data = 'action=getIol&iolTextName='+jQuery('input#iolName').val()+'&'+grid;
    
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
                    var textoInfoPannel = jQuery('h4#expanderHead span.infoIolHeaderTitle').html();
					//alert(textoInfoPannel);
                    jQuery('h4#expanderHead span.infoIolHeaderTitle').css('color', '#FEA63C').text('Ver información de la búsqueda');//
                    
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

            },
        beforeSend: function () {

            jQuery('#IOL_Filtradas').hide();
            jQuery('#IOL_Filtradas').html(jQuery('#loadingGif').html());
            jQuery('#IOL_Filtradas').show();
            if (typeof (viewTypeData) === 'undefined') {
                jQuery('h4#expanderHead span.infoIolHeaderTitle').html('Actualizando la Información').css('color', 'green');
                jQuery('#resizableTitle').animate({ opacity: '0' }, 1000).animate({ opacity: '1' }, 1000);
            }
        }
    }
            );    
}

//Cargamos ahora el js necesario para la página del test post op.


jQuery(document).ready(function (){
	
   postOpFormLoader();
	
});

function postOpFormLoader(){

		if(jQuery('#templatePostOp').length){
		//alert('trincado');
			//Cargamos los buttonsets normales.
		    jQuery( "#post-op-form #surgeryTime ,#post-op-form #surgeryEye ,#post-op-form #dDriving,#post-op-form #nDriving, #post-op-form  #iVision, #post-op-form  #newspaper,#post-op-form #prices,#post-op-form  #needle,#post-op-form  #dGlasses,#post-op-form  #nGlasses, #post-op-form #currentVision,#post-op-form  #satIol" ).buttonset();
		    //luego los verticales
		    jQuery( "#post-op-form #surgeryIol" ).buttonsetv();
		
		}

}


function enviarPostOpTest(){
	
	jQuery('#post-op-form').submit();

}


/* Como no se haya llamado la función surgeryShowResultsLoader() antes de mostrar los resultados de satisfacción, da error. */



 jQuery(document).ready(function (){
 	
 	if(jQuery('#templatePostOpTestResult').length){
 	  //alert('reconocida');
 	 surgeryShowResultsLoader();
 	  //resultPostOpTabsLoader(); //surgeryShowResultsLoader()
 	}
 	
 	});
 
 function resultPostOpTabsLoader() {

 if(jQuery('#templatePostOpTestResult').length){
     jQuery("#satIol, #dDriving, #nDriving, #iVision, #newspaper, #prices, #needle, #dGlasses, #nGlasses, #currentVision").tabs( //#dDriving
       {
       active: 1,
       //beforeLoad: function(event,ui){alert('beforeLoad triggered')},
       //Inicio del Create
       create:
       	       	function (event, ui) {

       	       	    //ui.panel.html('<div>A continuación vendrá el contenido¡¡¡</div>');
       	       	    var selector = ui.panel.selector;
       	       	    var numberQ = selector.substring(selector.lastIndexOf("tabs-") + 6, selector.lastIndexOf("-"));
       	       	    //console.log(numberQ);
       	       	    var str = '#tabs' + numberQ + '-'; //+numberQ;
       	       	    //console.log(str);
       	       	    var surgeryIol = selector.replace(str, '');
       	       	    //console.log(surgeryIol);

       	       	    var question = jQuery(this).attr('id');
       	       	    //alert(question);
       	       	    console.log('a continuación el Ajax');
       	       	    jQuery.ajax({
       	       	        url: the_ajax_script.ajaxurl,
       	       	        data: 'action=getPostOpTestResults&question=' + question + '&surgeryIol=' + surgeryIol,
       	       	        cache: true,
       	       	        beforeSend: function () {
       	       	            jQuery('#ajaxResult' + numberQ + '-' + surgeryIol).hide();
       	       	            jQuery('#loading' + numberQ + '-' + surgeryIol + ' img').show();
       	       	        },
       	       	        complete: function () {
       	       	            jQuery('#ajaxResult' + numberQ + '-' + surgeryIol).show();
       	       	        },
       	       	        success:
        					function (response_from_the_action_function) {
        					    jQuery('#loading' + numberQ + '-' + surgeryIol + ' img').hide();
        					    var title = 0;
        					    jQuery('#ajaxResult' + numberQ + '-' + surgeryIol).html(response_from_the_action_function);
        					    //alert('#ajaxResult'+numberQ+'-'+surgeryIol);		
        					    var data = new google.visualization.DataTable();
        					    var pregunta = response_from_the_action_function[0][0];
        					    var tipo_Iol = response_from_the_action_function[0][1];
        					    var titleLeyenda = pregunta + ': ' + tipo_Iol

        					    var options = {
        					        title: titleLeyenda,
        					        width: 550,
        					        height: 300
        					    };



        					    jQuery.each(response_from_the_action_function, function () {/*alert(this);*/
        					        console.log(this[0]);
        					        if (title == 0) {
        					            data.addColumn('string', this[0]); //'years'
        					            data.addColumn('number', this[1]); //'sales'
        					            //console.log('columnas: '+ this[0] +','+ this[1] )
        					            title += 1;
        					        }
        					        else {
        					            data.addRow([this[0], parseInt(this[1])]); //[years[i], sales[i]]
        					            //console.log('filas: '+ this[0] +','+ this[1] )
        					        }
        					    });
        					    var chart = new google.visualization.PieChart(document.getElementById('ajaxResult' + numberQ + '-' + surgeryIol));

        					    jQuery('#ajaxResult' + numberQ + '-' + surgeryIol).show();
        					    chart.draw(data, options);

        					}
       	       	    });
       	       	}


       	,
       //Fin del Create
       activate:
       	function (event, ui) {
       	    var selector = ui.newPanel.selector;
       	    //var surgeryIol = selector.replace('#tabs-','');
       	    var numberQ = selector.substring(selector.lastIndexOf("tabs-") + 6, selector.lastIndexOf("-"));
       	    //alert(numberQ);
       	    var str = '#tabs' + numberQ + '-'; //+numberQ;
       	    var surgeryIol = selector.replace(str, '');
       	    var question = jQuery(this).attr('id');

       	    jQuery.ajax({
       	        url: the_ajax_script.ajaxurl,
       	        data: 'action=getPostOpTestResults&question=' + question + '&surgeryIol=' + surgeryIol,
       	        cache: true,
       	        beforeSend: function () {
       	            jQuery('#ajaxResult' + numberQ + '-' + surgeryIol).hide();
       	            jQuery('#loading' + numberQ + '-' + surgeryIol + ' img').show();
       	        },
       	        complete: function () {
       	            //jQuery('#ajaxResult'+numberQ+'-'+surgeryIol).show();	
       	        },
       	        success:
        					function (response_from_the_action_function) {
        					    jQuery('#loading' + numberQ + '-' + surgeryIol + ' img').hide();
        					    var title = 0;
        					    //jQuery('#ajaxResult-'+surgeryIol).html(response_from_the_action_function);

        					    var data = new google.visualization.DataTable();
        					    var pregunta = response_from_the_action_function[0][0];
        					    var tipo_Iol = response_from_the_action_function[0][1];
        					    var titleLeyenda = pregunta + ': ' + tipo_Iol

        					    var options = {
        					        title: titleLeyenda,
        					        width: 550,
        					        height: 300
        					    };



        					    jQuery.each(response_from_the_action_function, function () {/*alert(this);*/
        					        //console.log(this[0]);
        					        if (title == 0) {
        					            data.addColumn('string', this[0]); //'years'
        					            data.addColumn('number', this[1]); //'sales'
        					            //console.log('columnas: '+ this[0] +','+ this[1] )
        					            title += 1;
        					        }
        					        else {
        					            data.addRow([this[0], parseInt(this[1])]); //[years[i], sales[i]]
        					            //console.log('filas: '+ this[0] +','+ this[1] )
        					        }
        					    });
        					    var chart = new google.visualization.PieChart(document.getElementById('ajaxResult' + numberQ + '-' + surgeryIol));
        					    jQuery('#ajaxResult' + numberQ + '-' + surgeryIol).show();

        					    chart.draw(data, options);

        					    //jQuery('#ajaxResult'+numberQ+'-'+surgeryIol).show();		
        					}
       	    });
       	} 
   })
                	            }
                	            }


//Estamos buscando una función que se procese antes o después de la llamada ajax en el gotomain en el caso específico de esta página.
function surgeryShowResultsLoader(){
    jQuery.ajax({
        url: 'https://www.google.com/jsapi?callback',
        cache: true,
        dataType: 'script',
        success: function () {
            console.log('previo al error de ajax en result loader');
            google.load('visualization', '1', { packages: ['corechart'], 'callback': function () {

	        resultPostOpTabsLoader();
     
            }
            });
            return true;
        }
    });
                                }
    jQuery(document).ready(function(){
    			if(jQuery('#templateIolSimulator').length){
        			SimLoader();
        			}
           		});                               
                                
 //Creamos una variable global que sea escenario, será lo que acompañe tras el dash al nombre de la clave.
 var scenario = 'day';
 var currentImage;
                                
 function SimLoader(){
        	var pathToImagFolder = unescape(jQuery('#auxPathToFolder').html());
        	
           jQuery('#monofocal_Esferica_Torica, label[for=monofocal_Esferica_Torica],#monofocal_Asferica_Torica, label[for=monofocal_Asferica_Torica], #multifocal_Bifocal_Torica, label[for=multifocal_Bifocal_Torica], #multifocal_Trifocal_Torica, label[for=multifocal_Trifocal_Torica]').fadeOut("slow"); //animate({"display":"none"},1000);                

        	//alert(pathToImagFolder);   
           //alert('Simloader ejecutada');
            jQuery("#sym").symlens({
                easeOut : "easeInExpo",
                easeIn : "easeOutExpo",
                duration: 1000,
                width: 800, //obligatorio
                height: 450, //obligatorio
                images : [ //obligatorio
                //Condiciones Oculares en Ambos Escenarios.
                //En extensión jpg las imágenes ocupan muchísmo menos.
                ["normal-day", ""+ pathToImagFolder + "normal-day.jpg"], //http://www.nuevocristalino.es/wp-content/themes/iol/images/
                ["normal-night", ""+ pathToImagFolder + "normal-night.jpg"],
                ["presbicia-day", "" + pathToImagFolder + "presbicia-day.jpg"],
                ["presbicia-night", "" + pathToImagFolder + "presbicia-night.jpg"],                
                ["cataratas-day", "" + pathToImagFolder + "cataratas-day.jpg"],
                ["cataratas-night", "" + pathToImagFolder + "cataratas-night.jpg"],
                ["astigmatismo-day", "" + pathToImagFolder + "astigmatismo-day.jpg"],
                ["astigmatismo-night", "" + pathToImagFolder + "astigmatismo-night.jpg"],
                //Resultados visual con Lentes
                //Monofocales
                ["monofocal_Esferica-day", "" + pathToImagFolder + "monofocal_Esferica-day.jpg"], //En teoría es la misma imagen que presbicia
                ["monofocal_Esferica-night", "" + pathToImagFolder + "monofocal_Esferica-night.jpg"],
                ["monofocal_Asferica-day", "" + pathToImagFolder + "monofocal_Asferica-day.jpg"],
                ["monofocal_Asferica-night", "" + pathToImagFolder + "monofocal_Asferica-night.jpg"],
                //Monofocales + Astigmatismo.
                ["monofocal_Esferica_astigmatismo-day", "" + pathToImagFolder + "monofocal_Esferica_astigmatismo-day.jpg"], //En teoría es la misma imagen que presbicia
                ["monofocal_Esferica_astigmatismo-night", "" + pathToImagFolder + "monofocal_Esferica_astigmatismo-night.jpg"],
                ["monofocal_Asferica_astigmatismo-day", "" + pathToImagFolder + "monofocal_Asferica_astigmatismo-day.jpg"],
                ["monofocal_Asferica_astigmatismo-night", "" + pathToImagFolder + "monofocal_Asferica_astigmatismo-night.jpg"],
                //Monofocales Tóricas.
                ["monofocal_Esferica_Torica-day", "" + pathToImagFolder + "monofocal_Esferica_Torica-day.jpg"], //En teoría es la misma imagen que presbicia
                ["monofocal_Esferica_Torica-night", "" + pathToImagFolder + "monofocal_Esferica_Torica-night.jpg"],
                ["monofocal_Asferica_Torica-day", "" + pathToImagFolder + "monofocal_Asferica_Torica-day.jpg"],
                ["monofocal_Asferica_Torica-night", "" + pathToImagFolder + "monofocal_Asferica_Torica-night.jpg"],
                //["monofocal_Torica-day", "" + pathToImagFolder + "monofocal_Torica-day.jpg"],
                //["monofocal_Torica-night", "" + pathToImagFolder + "monofocal_Torica-night.jpg"],
                //Multifocales
                ["multifocal_Bifocal-day", "" + pathToImagFolder + "multifocal_Bifocal-day.jpg"],
                ["multifocal_Bifocal-night", "" + pathToImagFolder + "multifocal_Bifocal-night.jpg"],
                ["multifocal_Trifocal-day", "" + pathToImagFolder + "multifocal_Trifocal-day.jpg"],
                ["multifocal_Trifocal-night", "" + pathToImagFolder + "multifocal_Trifocal-night.jpg"],
                //Multifocales + Astigmatismo
                ["multifocal_Bifocal_astigmatismo-day", "" + pathToImagFolder + "multifocal_Bifocal_astigmatismo-day.jpg"],
                ["multifocal_Bifocal_astigmatismo-night", "" + pathToImagFolder + "multifocal_Bifocal_astigmatismo-night.jpg"],

                ["multifocal_Trifocal_astigmatismo-day", "" + pathToImagFolder + "multifocal_Trifocal_astigmatismo-day.jpg"],
                ["multifocal_Trifocal_astigmatismo-night", "" + pathToImagFolder + "multifocal_Trifocal_astigmatismo-night.jpg"],

                //["multifocal_Torica-day", "" + pathToImagFolder + "multifocal_Torica-day.jpg"],
                //["multifocal_Torica-night", "" + pathToImagFolder + "multifocal_Torica-night.jpg"],
                //Multifocales Tóricas
                ["multifocal_Bifocal_Torica-day", "" + pathToImagFolder + "multifocal_Bifocal_Torica-day.jpg"],
                ["multifocal_Bifocal_Torica-night", "" + pathToImagFolder + "multifocal_Bifocal_Torica-night.jpg"],
                ["multifocal_Trifocal_Torica-day", "" + pathToImagFolder + "multifocal_Trifocal_Torica-day.jpg"],
                ["multifocal_Trifocal_Torica-night", "" + pathToImagFolder + "multifocal_Trifocal_Torica-night.jpg"],


                /*
                ["cataratasFull-day", "" + pathToImagFolder + "cataratasFull-day.png"],
                ["cataratasEnd-day", "" + pathToImagFolder + "cataratasEnd-day.png"],
               */
                ]       
            });
               
            //jQuery( '#sym-control').buttonset();
            
            jQuery( '#scenarios').buttonset();

            jQuery('#astigButtons').buttonset();
            
            //cargamos la lógica de botones de Astimgatismo y LIO.

            //Clickeamos en el botón de Sí, astigmatismo.
            jQuery('#astigmatismo').click(function () {

                //jQuery('#monofocal_Torica, label[for=monofocal_Torica], label[for=multifocal_Torica]').css('display','inline');
                //Alteramos los botones correspondientes a las lentes no tóricas para que incluyan la palabra astigmatismo:
                //Escenario ya está definido.
                //var thisScenario = jQuery(this).data('scenario');
                //scenario = thisScenario;

                jQuery('#vision-result .botonSim:not(.toric)').each(function () {
                    var imgPrev = jQuery(this).data('image');
                    //Si tiene la palabra astigmatismo no lo tocamos, si no la tiene lo añadimos.
                    if (imgPrev.indexOf("_astigmatismo") != -1) {
                        var imgNew = imgPrev;
                    } else {
                        var imgNew = imgPrev.split('-')[0] + '_astigmatismo' + '-' + scenario;
                    }

                    jQuery(this).data('image', imgNew);
                });

                console.log('La current Image es:' + currentImage);

                //Actualizamos la imagen que está mostrándose
                if (typeof (currentImage) == 'undefined') {
                    currentNew = 'astigmatismo-day';
                    currentImage = currentNew;
                }
                if ((currentImage == 'presbicia-day') || (currentImage == 'presbicia-night') || (currentImage == 'cataratas-day') || (currentImage == 'cataratas-night')) {
                    currentNew = currentImage.replace('presbicia', 'astigmatismo');
                    console.log('Ha modfidificado :' + currentNew + 'sustitutyendo presbicia');
                    currentNew = currentNew.replace('cataratas', 'astigmatismo');
                    console.log('Hipotético Remplazo a ' + currentNew);
                   currentImage = currentNew;

                }
                if (currentImage == 'presbicia-day') {
                    currentNew = 'astigmatismo-day';
                   currentImage = currentNew;
                }






                console.log('La current Image es:presbicia-day' + currentImage);
                if (currentImage.indexOf('astigmatismo') == -1) {
                    currentPrev = currentImage;
                    currentPrevAux = currentPrev.split('-')[0];
                    currentNew = currentPrevAux + '_astigmatismo' + '-' + scenario;
                }



                //var currentNew = currentPrev.split('-')[0] + '-' + scenario;

                console.log('Actualización de la imagen a:' + currentNew);
                jQuery("#sym").symlens('drawImage', currentNew); //attr('id')
                currentImage = currentNew;

                //Metemos los botones que insertan las imágenes de Astigmatismo.
                jQuery('#monofocal_Esferica_Torica, label[for=monofocal_Esferica_Torica],#monofocal_Asferica_Torica, label[for=monofocal_Asferica_Torica], #multifocal_Bifocal_Torica, label[for=multifocal_Bifocal_Torica], #multifocal_Trifocal_Torica, label[for=multifocal_Trifocal_Torica]').fadeIn("slow"); //animate({"display":"none"},1000);                
                //alert('Astigmatismo Clickeado¡¡');
            });


            jQuery('#astigmatismo_no').click(function () {
                //jQuery('#monofocal_Torica, label[for=monofocal_Torica], #multifocal_Torica, label[for=multifocal_Torica]').css('display', 'none');

                //var thisScenario = jQuery(this).data('scenario');
                //scenario = thisScenario;

                jQuery('#vision-result .botonSim').each(function () {
                    var imgPrev = jQuery(this).data('image');
                    //Si tiene la palabra astigmatismo la quitamos.
                    if (imgPrev.indexOf("_astigmatismo") == -1) {
                        var imgNew = imgPrev;
                        console.log(imgPrev + ' no contiene  _astigmatismo');
                    } else {
                        var imgNewAux = imgPrev.split('-')[0];
                        var imgNew = imgNewAux.replace('_astigmatismo', '') + '-' + scenario;
                    }
                    console.log('cambio desde:' + imgPrev + ' a ' + imgNew);
                    jQuery(this).data('image', imgNew);
                });

                console.log('La current Image es:' + currentImage);
                //Actualizamos la imagen que está mostrándose
                if (typeof (currentImage) == 'undefined') {
                    currentNew = 'normal-day';
                    currentImage = currentNew;
                }
                if (currentImage == 'astigmatismo-day') {
                    currentNew = 'normal-day';
                    currentImage = currentNew;
                }

                if (currentImage == 'astigmatismo-night') {
                    currentNew = 'normal-night';
                    currentImage = currentNew;
                }


                if (currentImage.indexOf('astigmatismo') != -1) {
                    currentPrev = currentImage;
                    currentPrevAux = currentPrev.split('-')[0];
                    currentPrevAux1 = currentPrevAux.replace('_astigmatismo', '');
                    currentNew = currentPrevAux1 + '-' + scenario;
                    console.log('Definitivamente tenía astigmatismo se ha remplazado a : ' + currentNew);
                }
                //Si la current image tiene Torica en el nombre:
                if (currentImage.indexOf('_Torica') != -1) {
                    currentPrev = currentImage;
                    currentPrevAux = currentPrev.split('-')[0];
                    currentPrevAux1 = currentPrevAux.replace('_Torica', '');
                    currentNew = currentPrevAux1 + '-' + scenario;
                    //Tenemos a su vez que simular el click porque el del input tórico se nos ha quedado seleccionado.
                    jQuery('#' + currentPrevAux1).prop('checked',true);
                    console.log('Definitivamente tenía astigmatismo se ha remplazado a : ' + currentNew);

                }


                //var currentPrev = currentImage;
                //var currentNew = currentPrev.split('-')[0] + '-' + scenario;
                console.log('Actualización de ' + currentImage + ' a:' + currentNew);
                jQuery("#sym").symlens('drawImage', currentNew); //attr('id')
                currentImage = currentNew;


                //jQuery('#monofocal_Torica, label[for=monofocal_Torica], label[for=multifocal_Torica]').fadeOut("slow"); //.animate({"display":"none"},1000);
                //Retiramos los botones 
                jQuery('#monofocal_Esferica_Torica, label[for=monofocal_Esferica_Torica], #monofocal_Asferica_Torica, label[for=monofocal_Asferica_Torica], #multifocal_Bifocal_Torica, label[for=multifocal_Bifocal_Torica], #multifocal_Trifocal_Torica, label[for=multifocal_Trifocal_Torica]').fadeOut("slow"); //animate({"display":"none"},1000);                

                //alert('Astigmatismo No Clickeado¡¡');
            });

            jQuery( '#scenarios input[type="radio"]').each(function (index,element){
            
            		//queremos que cambie el dash de los botones al clickear sobre ambos escenarios
            		jQuery(element).on('click', function (){
            				
            				var thisScenario = jQuery(this).data('scenario');
            				scenario = thisScenario;
            				
            				jQuery('.botonSim').each(function(){
            				var imgPrev = jQuery(this).data('image');
               				var imgNew =  imgPrev.split('-')[0] + '-' + thisScenario;
            				jQuery(this).data('image',imgNew);
            				
            				//Actualizamos la imagen que está mostrándose
            				if(typeof(currentImage)== 'undefined'){
            						currentImage = 'normal-day';
            						}
            				currentPrev = currentImage;
            				currentNew = currentPrev.split('-')[0] + '-' + thisScenario;
                            console.log('Actualización de la imagen a:'+ currentNew);
            				jQuery( "#sym" ).symlens('drawImage',currentNew);//attr('id')
            				currentImage = currentNew;
            				});            				
            		});
            	
            });
            
            //Aquí estamos asignando a cada input type radio que implique un cambio de imagen que la ponga en al clickearla.
            jQuery('#simulator-options-conditions input[type="radio"], #vision-result input[type="radio"]').each(function (index, element) {
                jQuery(element).on('click', function () {
                    //alert('sym-clickeado');
                    console.log('Mostrando imagen: '+jQuery(this).data('image'));
                    jQuery("#sym").symlens('drawImage', jQuery(this).data('image')); //attr('id')
                    currentImage = jQuery(this).data('image');
                });
            }); 
            
            
                   jQuery( "#cataractSlider" ).slider({
					change: function( event, ui ) {
							
							if(ui.value >= 0 && ui.value < 30 ){
							jQuery('#cataractSliderValue').html('Fase 1');
							 jQuery( "#sym" ).symlens('drawImage','cataratas-' + scenario);
							 currentImage = 'cataratas-day';
							}
							if(ui.value >= 30 && ui.value < 60 ){
							jQuery('#cataractSliderValue').html('Fase 2');
							 jQuery( "#sym" ).symlens('drawImage','cataratasFull-' + scenario);
							 currentImage = 'cataratasFull-day';
							}
							if(ui.value >= 60 && ui.value <= 100 ){
							jQuery('#cataractSliderValue').html('Fase 3');
							 jQuery( "#sym" ).symlens('drawImage','cataratasEnd-' + scenario);
							 currentImage = 'cataratasEnd-day';
							}
					}
					});
					
					
					
					
				jQuery('#monofButton').on('click', function (){
						jQuery( "#sym" ).symlens('drawImage','monofocal-'+scenario);
						currentImage = 'monofocal-'+scenario;
						});
				jQuery('#multifButton').on('click', function (){
						jQuery( "#sym" ).symlens('drawImage','multifocal-'+scenario);
						currentImage = 'multifocal-'+scenario;
						});
  		}
 
                               

function animateArrayImages(array,timer){
		var i = 0;
		var numberCount = array.length;
		
		var counter = window.setInterval(function() {
	     jQuery( "#sym" ).symlens('drawImage',array[i++]);//alert(++i);
		   //console.log('La imagen ' + array[i] + 'ha sido cargada');
		   // when i = 4, stop repeating
   			if(i == numberCount)
     		{   
       			window.clearInterval(counter);
      		}  
		}, timer);
}

var sitesMostrados = 0;

jQuery(document).ready(function () {

    if (jQuery('#tipoIolTemplate').length) {

        jQuery('#comboViewType').remove();
    }

    //Añadimos aquí que si está en el home ejecute el fakeDivGenerator
    if (jQuery('#sliderMBloqsWrapper #slider').length) {
        if (jQuery('body #fakeDiv').length == 0) {
            jQuery('body').append('<div id="fakeDiv">&nbsp;</div>');
        }
        fakeDivGenerator();
    }

    //Añadimos el siteChanger
    jQuery('#wsIcon #siteShower').on('click', function () {
        //alert('Clickeado');
        toggleSites();
        return false;
    });

});


function fakeDivGenerator() {
    var pTopGRef = jQuery('#grey-in').parent().position();
    var topGRef = jQuery('#grey-in').position();
    var topP = topGRef.top + pTopGRef.top - 160;
    var topBRef = jQuery('#block1').position();
    var bottomRef = topBRef.top - 30;
    var heigh = bottomRef - topGRef.top+53;  
//console.log(topP);

//console.log(heigh);

//var width = jQuery(window).width();

jQuery('body #fakeDiv').css({ 'position': 'absolute',
    'display':'block',
    'height': heigh + 'px',
    'width': '100%', /*width*/
    'top': topP + 'px',
    'z-index': '-10',
    'background': '#e9e9e9',
    'min-width':'100% !important',
    'margin':'0px',
    'padding':'0px',
    'overflow': 'visible'
});
}

function fakeDivHidder() {
    jQuery('#fakeDiv').css({'display':'none'});
} 
    
function showSites() { 

// if (jQuery('#countrySitesList').css('opacity') == '0'){
             jQuery('#countrySitesList').animate({opacity:1}, {duration: 700});//css('display', 'block');
/*          }
          else
           {*/
  //          jQuery('#countrySitesList').animate({opacity:0}, {duration: 1000});
            //jQuery('#countrySitesList').css({display:"none", opacity: 0})
            //}
}

function hideSites() { 
            jQuery('#countrySitesList').animate({opacity:0}, {duration: 700});
}



function toggleSites() { 

 if (jQuery('#countrySitesList').css('opacity') == '0'){
 			 jQuery('#countrySitesList').css('display','block');
             jQuery('#countrySitesList').animate({opacity:1}, {duration: 300});//css('display', 'block');
       
              }
            else  
           {
            jQuery('#countrySitesList').animate({opacity:0}, {duration: 300});
            jQuery('#countrySitesList').css('display', 'none');
             }
 }

 function activador() {
     jQuery('label[for=\"multifocal-trifocal\"],label[for=\"multifocal-bifocal\"] ').addClass('ui-state-active');
 }