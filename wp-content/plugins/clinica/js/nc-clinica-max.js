

//jQuery UI para los comboboxes;

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
//RETIAR SI NO FUNCIONAAA¡¡¡

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
          //.attr( "title", "Mostrar todos los valores" ) => Quitamos esto porque en el ipad es un coñazo.
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
      //Esta también es de cosecha propia.
     /* select: function( event, ui ) {
        ui.item.option.selected = true;
        self._trigger( "selected", event, {
        item: ui.item.option
        });
        select.trigger("change");                             
       }*/
    });
  })( jQuery );
 
 
 //A ver aquí está la lógica que vincular los dos comboboxes¡¡¡
 function clinicFormComboButtonLoader(){
         jQuery( "#combobox-ubicacion-parent, #combobox-ubicacion-child" ).combobox();
         //Añadimos el de seguros
         jQuery( "#combobox-seguros" ).combobox({
         	select: function (evnt,ui){
         		archiveClinica_submit_me();
         	}
         });

         //añadimos el combobox del número de elementos de clínicas mostrados por el filtro.
         jQuery("#clinica_filter_form #comboboxViewType").combobox({
             select: function (event, ui) {
                 //var currentQString = jQuery('#currentQueryString').html();
                 //alert(currentQString);
                 var urlAjaxQueryRoot = jQuery('#currentQueryString').text();
                 //vamos a añadir un & que está fallando.
                 var urlAjaxQuery = urlAjaxQueryRoot.replace('action=', '&action=');
                 console.log('urlAjaxQuery: ' + urlAjaxQuery);
                 var viewTypeValue = jQuery('#comboboxViewType').val();
                 var newUrlAjaxQuery = UpdateQueryString('viewType', viewTypeValue, urlAjaxQuery);

                 var newAjaxQuery = newUrlAjaxQuery.substring(newUrlAjaxQuery.lastIndexOf("?") + 1, newUrlAjaxQuery.length);
                 //alert(newUrlAjaxQuery.lastIndexOf("?"));
                 if (jQuery('#archiveClinicaTemplate').length) {
                     //alert('newAjaxQuery: ' + newAjaxQuery + 'mandado a archive_clinica_submit_me');
                     archiveClinica_submit_me(newAjaxQuery);
                 }

             } // selected
         });           // combo

         //Los buttonssets verticales.
         jQuery( "#numSxFilter,#tipoOpFilter,#tipoIOLFilter,#tipoMInfFilter" ).buttonsetv();
         
         jQuery( "#numSxFilter input,#tipoOpFilter input,#tipoIOLFilter input,#tipoMInfFilter input" ).bind('click',function(){
         	   if(jQuery('#archiveClinicaTemplate').length){
    			     archiveClinica_submit_me();  
    		    }
    		    }
         );
         
         
         //El de femto-faco y el combo de las lentes.
         jQuery('#femtoFacoFilter, #financiacionFilter').buttonset();
         
         //Ponemos a continuacion que el evento de click dispare el envío ajax del formulario.
         jQuery("#femtoFacoFilter input, #financiacionFilter input").bind("click",function(){
               // do whatever you want to do with clicked button
               if(jQuery('#archiveClinicaTemplate').length){
    			     archiveClinica_submit_me();  
    		    }
    		});
         
         jQuery('#combobox-lensClinics').combobox({
         	select: function(event, ui){
         	if(jQuery('#archiveClinicaTemplate').length){
   				     archiveClinica_submit_me();       	
   				     }
         	}
         });
         
         
         
         
    //El de ubicación
    jQuery('#combobox-ubicacion-parent').combobox({
        select: function (event, ui) { 
        //Mandamos a la función Provincias el slug de la comunidad autónoma para que poble el segundo combobox con los valores asociados
        Provincias(ui.item.value);
        //Vamos a meter también la función de envío del formulario PRUEBA.
        if(jQuery('#archiveClinicaTemplate').length){
        		archiveClinica_submit_me();
        }
           }
        });
   //Hacemos dinámico tambien el de provincias
         jQuery("#combobox-ubicacion-child" ).combobox({
           select: function (event, ui) { 
           if(jQuery('#archiveClinicaTemplate').length){
       		 archiveClinica_submit_me();    
       		 }
           } 
         
         
         });
        
    //Creo que necesitamos otra función recíproca que chequee que no se puede seleccionar otra     
        

 }

function Provincias (cAutonoma) {
	
    //Primero quitamos el texto de selección.
    var el = jQuery("#combobox-ubicacion-child");
    
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


//Activamos los Accordions en inactive del filtro simple.
  jQuery(function () {
       if (jQuery("#clinica_filter_form").length) {
      clinicFormAccordionLoader();
      clinicFormComboButtonLoader();
      }
  });

  function clinicFormAccordionLoader() {
        jQuery("#accordionFilterSimple").accordion({
          collapsible: true,
          active: 0,
          heightStyle: "content"
      });

      jQuery("#accordionFilterSecond").accordion({
          collapsible: true,
          active: 0,
          heightStyle: "content"
      });
      
    //Vamos a hacer que también sean draggables.
    jQuery("#accordionFilterSimple,#accordionFilterSecond").each(
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
        					'left': 		left,//jQuery(this).data('originalLeft'),
        					'top':  		top,//jQuery(this).data('origionalTop')
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
			//vamos a ver si podemos hacer un revert.

			
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
  }




//Función para el envío del formulario del single de la lente intraocular.
  function singleClinic_submit_me(){
      jQuery("#clinica_filter_form input, #clinica_filter_form select").each(
function () {

    //Añadimos la condición de que el input no contenga la secuencia de letras ubicacion.
    //ya que si es ubicacion-child-se SÍ que queremos que lo mande.
    //alert(this.value.indexOf('ubicacion'));

    if ((this.value.substr(this.value.length - 3) == '-se') && (this.value.indexOf('ubicacion') == -1)) {
        jQuery(this).prop('disabled', true);
    } else { }
    
});
	var qString = jQuery("#clinica_filter_form").serialize();
	var archiveClinicUrl = jQuery("#clinica_filter_form").attr('action'); 
	var hrefSingleForm = archiveClinicUrl +'?'+ qString;
	
	goToMain(hrefSingleForm);
	
	history.pushState(null, null, hrefSingleForm);
       //AVISO GAnalytics cambio de página
       ga('send', 'pageview',archiveClinicUrl);
	
	//var urlClinicArchive = jQuery('#clinica_filter_form').attr('action');
	//location.href= jQuery("#archiveClinicaUrl").html()+'?'+qString;
    //jQuery("#clinica_filter_form").submit();
    
//return false;
  }
    


  (function( $ ){
  //plugin buttonset vertical
  $.fn.buttonsetv = function() {
    return this.each(function(){
      $(this).buttonset();
      $(this).css({'display': 'table', 'margin-bottom': '7px'});
      $('.ui-button', this).css({'margin': '0px', 'display': 'table-cell'}).each(function(index) {
              if (! $(this).parent().is("div.dummy-row")) {
                  $(this).wrap('<div class="dummy-row" style="display:table-row; " />');
              }
          });
      $('.ui-button:first', this).first().removeClass('ui-corner-left').addClass('ui-corner-top');
      $('.ui-button:last', this).last().removeClass('ui-corner-right').addClass('ui-corner-bottom');
    });
  };
})( jQuery );


//Vamos a añadir ahora la lógica de cambio de valores de las comboboxes según esté seleccionado una u otra comunidad autónoma.

var newOptions = {"Option 1": "value1",
                  "Option 2": "value2",
                  "Option 3": "value3"
                  };

//Estructura ejemplo de datos:

var employees = { "accounting" :    // accounting is an array in employees.
                                    { "Option 1" : "John",  // First element
                                      "lastName"  : "Doe",
                                      "age"       : '23' }
                                  , // End "accounting" array.                                  
                  "sales"       :  // Sales is another array in employees.
                                    { "firstName" : "Sally", // First Element
                                      "lastName"  : "Green",
                                      "age"       : 27 }
                                   // End "sales" Array.
                } // End Employees
                var nombre = 'accounting';

//Metemos la parte del pannel de información para la búsqueda de clínicas.

//Lógica del iolInfoPannel -> Definimos Clickeado como una variable Global.
//Cuando está en 0 es que no ha sido clickeado.
var clinicaClickeado = 0;
//Definimos también comprimido, cuando está en 0 es que no está comprimido en 1 sí.
var clinicaComprimido = 0;

jQuery(document).ready(function () {
    clinicaInfoPannelLoader();
    clinicaQueryStringUpdater();

    //Cargamos también en #currentQueryString la querystring de la página

    //Metemos un if para quitar el combo del viewtype
    //Queremos que no salga el combo de selección de vista.
    if (jQuery('#clinicasIolUrl').length) {
        jQuery('#comboViewTypeClinic').remove();
    }

}
);

function clinicaQueryStringUpdater(){
        if (jQuery('#currentQueryString').length && jQuery('#archiveClinicaTemplate').length) {
        var urlQString = location.search;
        urlQString = urlQString.replace('?','');
        if (urlQString.indexOf('action=clinica_filter_result') == -1) {
            urlQString = urlQString + 'action=clinica_filter_result';
        }
        jQuery('#currentQueryString').text(the_ajax_script.ajaxurl + '?' + urlQString);
        //alert('QuerystringDiv remplazado');
    }
}


function clinicaInfoPannelLoader(){
    //Código para hacer que el div haga scroll con la página.
    if(jQuery('#clinicaInfoPannel').length){
    //console.log('ahora si que se ha guardado el cambio en iol.js');
    // check where the shoppingcart-div is  
    var offset = jQuery('#clinicaInfoPannel').offset();
    jQuery(window).scroll(function () {
        var scrollTop = jQuery(window).scrollTop();
        // check the visible top of the browser     
        if (offset.top < scrollTop) {
            jQuery('#clinicaInfoPannel').addClass('fixed');
        } else {
            jQuery('#clinicaInfoPannel').removeClass('fixed');
        }
    });

    //Función que se ejecuta cuando se clickee el header que realiza la expansion.
    // Para que funcione adecuadamente conviene definir unas funciones de inicio.



    jQuery("#expanderHead").click(function () {
        PannelClinicaClickResponse();
    });


    //
    console.log(jQuery('#clinicaInfoPannel').css('display'));
    jQuery('.draggable').draggable({ handle: "#dragger" });
    //En resizable metemos como mínima altura la propia del contenido que se ha cargado.

    //   console.log('La altura mínima es' + alturaContenidoPannel);
    jQuery('.resizable').resizable({ 'minWidth': 300 });
    jQuery('#clinicaInfoPannel').css('display', 'block');
}

}



function PannelClinicaClickResponse() { 
    //Ponemos primero el slider toggle para que no haya efectos raros.
        console.log(jQuery("#expanderContent").css('height'));
        //console.log('El valor actual de la variable Clickeado es:'+ Clickeado );
        var newAlturaContenidoPannel = parseInt(jQuery("#expanderContent").css('height').replace('px', '')) + 35;
        var newAnchuraContenidoPannel = parseInt(jQuery("#expanderContent").css('width').replace('px', '')) + 20;
        jQuery("#expanderContent").slideToggle('1000');

        //  Clickeado = 0 quiere decir que el container está cerrado.
        switch (clinicaClickeado) {
            case 0:
                clinicaClickeado = 1;
                jQuery("#expanderContent").css('visibility', 'visible');
                jQuery(".resizable").css('height', 'auto');
                jQuery(".resizable").resizable();
                jQuery(".resizable").resizable("option", "minHeight", newAlturaContenidoPannel);
                jQuery(".resizable").resizable("option", "minWidth", newAnchuraContenidoPannel);
                jQuery('#expanderSign').removeClass('ui-icon-carat-1-e').addClass('ui-icon-carat-1-s');
                break;
            case 1:
                console.log('Se está clickeando para colapsar el container: Ponemos clickeado a 0.');
                clinicaClickeado = 0;
                jQuery("#expanderContent").css('visibility', 'hidden');
                //jQuery(".resizable").resizable("option", "minHeight", null);
                jQuery(".resizable").resizable('destroy'); //.resizable("option", {"minHeight": 20,"maxHeight": 25});
                jQuery(".resizable").css('height', '20');
                break;
        }
        /* Para hacer un cambio en el header.
        if (jQuery("#expanderSign").text() == "+") {
        jQuery("#expanderSign").html("−")
        }
        else {
        jQuery("#expanderSign").text("+")
        }*/
}

//Jquery para los botones del pannel de información.

jQuery(document).ready(
         function () {
		buttonClinicaInfoPannelLoader();        
             
    });

function buttonClinicaInfoPannelLoader(){
         if(jQuery('#clinicaActionsContainer').length){
         
             jQuery('#clinicaInfoPannelMini').button({
                 icons: {
                     primary: "ui-icon-circle-minus"
                 },
                 text: false
             });
             
             jQuery('#clinicaInfoPannelMaxi').button({
                 icons: {
                     primary: "ui-icon-circle-plus"
                 },
                 text: false
             });
             
             
             jQuery('#clinicaInfoPannelClose').button({
                 icons: {
                     primary: "ui-icon-circle-close"
                 },
                 text: false
             });
             
             //3-ClickEvent Definition
             //Botón de cerrar.
             jQuery('#clinicaInfoPannelClose').click(function () {
             
                 //alert(Comprimido);
                 //console.log("disabler pulsado");
                 if (clinicaClickeado == 0 && clinicaComprimido != 1) {
                     //esto quiere decir que el pannel está minimizado=> habrá que estrecharlo y llevarlo a la derecha.	
                     stylesClinicaCerrarIzqArriba();
                     //ifExpandedCollapse();
                     clinicaComprimido =1;
                     }
                 else {
                 console.log('clinicaClickeado es: '+clinicaClickeado);
                 console.log('clinicaComprimido es: '+clinicaComprimido);
                 		//Si el infoPannel está extendido
                 		if(clinicaClickeado == 1 && clinicaComprimido != 1){
                 		//alert('adsfad');
                 		ifClinicaExpandedCollapse();
                 		stylesClinicaCerrarIzqArriba();
                 		clinicaComprimido =1;
                 		}
                 }
                 return false;
             });

              //Botón de cerrar.
             jQuery('#clinicaInfoPannelMaxi').click(function () {
             
                 //alert(Comprimido);
                 //Está colapsado y comprimido.
                 if (clinicaClickeado == 0 && clinicaComprimido == 1) {
                     //primero lo abrimos.
                     clinicaComprimido = 0;	
                     stylesClinicaAbrir();
                     //Luego lo expandimos.
                     //setTimeout(function (){ifCollapsedExpand()},1000);
                     PannelClinicaClickResponse();
                     
                     }
                 else {
                       //Está colapsado y sin comprimir.
                       if(clinicaClickeado == 0 && clinicaComprimido ==0){                       
                       ifClinicaCollapsedExpand();
                       }
                 }
                 return false;
             });
             
             //Botón de Minimizar.
             jQuery('#clinicaInfoPannelMini').click(function () {
             
                 //Está expandido (Si está expandido no puede estar comprimido).
                 if (clinicaClickeado == 1) {
						ifClinicaExpandedCollapse();
                     }
                 else {
                       //Está colapsado y sin comprimir.
                       if(clinicaClickeado == 0 && clinicaComprimido ==0){                       
                       stylesClinicaCerrarIzqArriba();
                       clinicaComprimido = 1;
                       }
                 }
                 return false;
             });
             
             
             
             }

}


	//Aplica estilos para "cerrar" el info pannel
	function stylesClinicaCerrarIzqArriba(){
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
    function stylesClinicaAbrir(){
				var tempTrans = 1000;
       		jQuery('#expanderContent').css('width','380px');
			jQuery('#resizableTitle').animate({width:"495px"},tempTrans);//css('width','430px'); //430px 
			jQuery('h4#expanderHead, #expanderSign').show(1000); //width: 300px;
			jQuery('.resizable').css('min-width','315px');  

    }      		
          		
    //Función en la que si el pannel está expandido, lo contrae. Sin no lo está no hace nada.      		
    function ifClinicaExpandedCollapse(){
    		if (clinicaClickeado ==1 ){
    		    jQuery("#expanderContent").slideToggle();
                console.log('Estaba expandido y lo contraemos, ponemos clickeado a 0.');
    			//console.log('Se está clickeando para colapsar el container.');
                clinicaClickeado = 0;
                jQuery("#expanderContent").css('visibility', 'hidden');
                //jQuery(".resizable").resizable("option", "minHeight", null);
                jQuery(".resizable").resizable('destroy'); //.resizable("option", {"minHeight": 20,"maxHeight": 25});
                jQuery(".resizable").css('height', '20');
    		}

		return;
    }
    //Función simétrica a la anterior si está contraido, lo expande, si no, lo contrae.
	function ifClinicaCollapsedExpand(){
             if(clinicaClickeado == 0){
    			clinicaClickeado = 1;
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
	
//Cargamos la función de busqueda de clínica por nombre.

var timeoutReference;
jQuery(document).ready(function() {

	clinicaTextSearch();

});


function clinicaTextSearch(){
    
    jQuery('input#clinicaName').keypress(function() {
        var el = this; // copy of this object for further usage

        if (timeoutReference) clearTimeout(timeoutReference);
        timeoutReference = setTimeout(function() {
            clinicaDoneTyping.call(el);
        }, 750);
    });
    jQuery('input#clinicaName').blur(function(){
        clinicaDoneTyping.call(this);
    });

}


function clinicaDoneTyping(){
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
    
    
    
    
    var data = 'action=getClinica&clinicaTextName='+jQuery('input#clinicaName').val()+'&'+grid;
    
    jQuery.ajax({
        url: the_ajax_script.ajaxurl,
        data: data,
        cache: true,
        success:
            function (response_from_the_action_function) {

                jQuery("#primary #content").html(response_from_the_action_function);
                //A ver como actualizamos el iolInfoPannel... -> Lo haremos a posteriori ya que el preproceso no funciona.

                if (typeof (viewTypeData) === 'undefined') {
                    var iolInfoAJAX = jQuery("#AJAXclinicaInfoPannel").html();
                    var textoInfoPannel = jQuery('h4#expanderHead span.infoIolHeaderTitle').html();

                    jQuery('h4#expanderHead span.infoIolHeaderTitle').css('color', '#FEA63C').text('Ver Información de la búsqueda');//textoInfoPannel
                    switch (Clickeado) {
                        case 0:
                            jQuery('#expanderContent').html(iolInfoAJAX);
                            break;
                        case 1:
                            jQuery('#clinicaInfoPannel #expanderContent').fadeOut('slow', function () { jQuery(this).html(iolInfoAJAX).fadeIn('slow') });
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

jQuery(document).ready(
    function(){
        
        if(jQuery("#searchClinicaReset").length){
            
            ClinicReseter();
        }

    }
);

function ClinicReseter(){

	//Cargamos también el botón de reseteo de la clinicareset
	jQuery("#searchClinicaReset").click(function() {
		//Cuando tientes el panel de información abierto y reseteas "casca"
		//Cuando tienes parámetros en la url no resetea.
	//alert('clickeado');
	
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
                 if (clinicaClickeado == 1) {
						ifClinicaExpandedCollapse();
                     }
                 else {
                       //Está colapsado y sin comprimir.
                       if(clinicaClickeado == 0 && clinicaComprimido ==0){                       
                       stylesClinicaCerrarIzqArriba();
                       clinicaComprimido = 1;
                       }
                 }

       	jQuery('#clinicaInfoPannel').remove();
       	
   	    //var Clickeado = 0;
		//Definimos también comprimido, cuando está en 0 es que no está comprimido en 1 sí.
		//var Comprimido = 0;
        goToMain(strippedHref);
       	
	});

    }


	
 
