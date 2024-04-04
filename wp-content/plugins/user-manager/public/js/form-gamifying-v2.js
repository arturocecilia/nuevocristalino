//Primero cargamos el formulario en un $object

jQuery(document).ready(function(){

gamifyier();
fineTunner();
wizarder();

});





//Para cuando viene de un link con clean en el hash que solo salgan las pendientes.
//Poner un ancho del progress-bar accorde al ancho del question_bloq
function fineTunner(){
if(window.location.hash.substr(1)){
var type = window.location.hash.substr(1);
if(type == 'clean'){
  cleanFilled($activePregs);
 }
}else{
  type='';
}
if(!jQuery('#wizard').length){
	var widthAC = jQuery('form').find(".question_bloq").not('.helphide').css('width');
  jQuery('.form-progress-bar').css({'width': widthAC});
 }
}


//cargar el wizard.
function wizarder(){
  console.log('wizarder llamada');
if(jQuery('#wizard').length){
  	jQuery('#wizard').smartWizard({
									  /*fixHeight:"",*/
										labelNext:'Siguiente',
										labelPrevious:'Anterior', // label for Previous button
										labelFinish:'Enviar',  //
										hideButtonsOnDisabled: true,
										enableAllSteps:true,
										onLeaveStep: function(){
													jQuery('html, body').animate({
																			scrollTop: jQuery('#wizard').offset().top
																												}, 1000);
																		return true;
																	 }
																});
 }
}

//Reposicionamiento del profilegraph
function relocateProfileGraph(){
	var topMin = jQuery('.submenu-pages').position().top + jQuery('.submenu-pages').height() + 25;
	jQuery('.left-profileuser').css({"top": topMin});
	}

//
function cleanFilled($activePregs){
$activePregs.each(function() {
 var inputRadioHelp 	= jQuery(this).find('input[type="radio"]').length > 0 ? true : false;
 var inputTextHelp 	=  jQuery(this).find('input[type="text"],textarea').length > 0 ? true : false;
 if(inputRadioHelp){
   var inputVal = jQuery(this).find('input[type="radio"]:checked').val();
   var conditionMessage = (inputVal != undefined);
    if(conditionMessage){
        jQuery(this).addClass('helphide');
        }
   }
 if(inputTextHelp){
   var inputVal = jQuery(this).find('input[type="text"],textarea').val();
   var conditionMessage = (inputVal != '');
   if(conditionMessage){
       jQuery(this).addClass('helphide');
       }
   }
});

jQuery($activePregs).not('.helphide').first().css({'opacity':1});
var idFirstNotHide = jQuery($activePregs).not('.helphide').first().attr('id');

//Actualizamos también la progressBar.
idArray = new Array();
jQuery.each($activePregs, function (index,value){
                                               idArray.push(jQuery(value).attr('id'));
                                          });
prefRef = idArray.indexOf(idFirstNotHide); //jQuery(this).attr('id')
numPregsActive = $activePregs.length;

var advAC = 100*(prefRef)/numPregsActive;
var vProgressAfterCleaned = advAC > 100 ? 100 : advAC;

jQuery('.form-progress-bar').progressbar({
      value:vProgressAfterCleaned
    });
console.log('ProgressBar actualizado a: '+ vProgressAfterCleaned);
}

//
function showAllQuestions($activePregs){
  $activePregs.each(function() {
       jQuery(this).removeClass('helphide');
  });
  jQuery('div.quickMensQMode').remove();

  jQuery($activePregs).not('.helphide').first().css({'opacity':1});
  var idFirstNotHide = jQuery($activePregs).not('.helphide').first().attr('id');

  jQuery('.form-progress-bar').progressbar({
      value:0
    });
}




function gamifyier(){

//Primero cargamos el formulario en un $object

var currentLang = document.documentElement.lang; //- no _
var langEsp =  ['es-MX','es-ES','es-CO','es-CL'];
$formLength = jQuery('#qpls,#catques9sf,#prols,#addProfileBasicData,#ncreg_postdata_id_basicCatQ').length;//#prols,,#prols,#addProfileBasicData

if((jQuery.inArray(currentLang,langEsp)!= -1) && $formLength){
//Salimos de esto si no se cumple lo anterior.
$form= jQuery('#qpls,#prols,#catques9sf,#addProfileBasicData,#ncreg_postdata_id_basicCatQ')//,#addProfileBasicData

//VARIABLE activePregs definida
$activePregs = $form.find('.question_bloq,.comun_question_set').not('.hidden');//.not(".hidden[data-condition]");//No incluimos las din�micas para no desmoralizar m�s de la cuenta

//Ini del tema cleaning de preguntas
//Ini botones con funcionalidad mostrar ocultar preguntas.
jQuery('<div class="greyButton" id="cleanFilled" style="margin-top:20px;">Mostrar sólo las no contestadas</div>').appendTo('header.entry-header');
jQuery('<div class="greyButton" id="showAllQuestions" style="margin-top:10px;margin-bottom:30px;">Mostrar todas</div>').appendTo('header.entry-header');
jQuery('#cleanFilled').on('click',function(){
        cleanFilled($activePregs);
      });
jQuery('#showAllQuestions').on('click',function(){
          showAllQuestions($activePregs);
      });
//Fin del par de botones de ayuda con funcionalidad
//vamos a parsear un poco la url y ver si queremos que esté cleanded o no.
if(window.location.hash.substr(1)){
var type = window.location.hash.substr(1);
 if(type == 'clean'){
   cleanFilled($activePregs);
 }}else{
  console.log('showing all');
  type='';
}

if( type == 'clean'){
  $formPrev = $form.prev().prev().prev();
  console.log($formPrev);
  jQuery('<div class="quickMensQMode">Está viendo sólo las preguntas sin contestar. Para ver todas pulse en el botón superior "Mostrar todas".</div>').appendTo($formPrev);
}
//Fin del tema de cleaning de preguntas

//Inicio de variables
currentForm = $form.attr('id');
numPregsActive = $activePregs.length;
numThisPreg = 0;
if(jQuery.inArray(currentLang,langEsp)!= -1){
  var infoAboutFormES = {
                          "addProfileBasicData": "Perfil básico de usuario",//vamos a meter este �basicProfile?
                          "qpls" : "Información preoperatoria",
                          "prols": "Resultados de su operación ocular",
                          "catques9sf": "Resultados de su operación de cataratas"
                        }
  }
contentMessageOk 			= '<span class="message ok">Pregunta Contestada!</span>';
contentMessageNotOk 		= '<span class="message empty">No has contestado a esta pregunta</span>';
//Fin de inicio de variables

//INI del Progressbar (Inserción más posición)
if(!jQuery('#wizard').length){
  jQuery('<div class="form-progress-bar"></div>').insertBefore('#'+currentForm); //.find('.question_bloq ').first()
}else{
	jQuery('<div class="form-progress-bar"></div>').insertBefore('#'+currentForm);
}

if( type != 'clean'){
  var iniPos = $form.find(">:first-child").position();//.not('.helphide')
}else{
  var $firstVisible = $form.find(" .question_bloq").not('.helphide');
  var iniPos = $firstVisible.first().position();
}

var iniPosTopRefined = iniPos.top -6; //6
var iniPosLeftRefined = iniPos.Left + 4;
var width = $form.find(">:first-child").css('width');

jQuery('.form-progress-bar').progressbar({
    value:0
  });
jQuery('.ui-progressbar-value.ui-widget-header.ui-corner-left').css({
      //background:'#fea63c',//'https:www.nuevocristalino.es/wp-content/plugins/lente-intraocular/images/step-bar.gif',//'#fea63c',
      border: '1px solid #d3d3d3'
});

if(!jQuery('#wizard').length){
jQuery('.form-progress-bar').css({
    height:'10px',
    border: '1px solid #d3d3d3',
    position: 'absolute',
    top: iniPosTopRefined + 'px',
    left: iniPosLeftRefined + 'px',
    width: width
  });
}	else{
jQuery('.form-progress-bar').css({
	  height:'10px',
	  border: '1px solid #d3d3d3',
	  position: 'absolute',
	  top: iniPosTopRefined + 'px',
	  right: '0px',
	  width: '350px',
		borderRadius: '3px'
	  });
	}
//Fin del Progressbar (Inserción más posición)




//Hacemos que aparezca un tooltipo con info en la parte superior derecha de la caja de info.


//INI circle graph.
//Ponemos aquí la lógica de que al cambiar un input se actualice el profile-graph.
jQuery('form input, form select, form textarea').on('change',function(){
 var qForm = jQuery('form').attr('id').toLowerCase();
 var $inputsFilled = jQuery('.question_bloq input, .comun_question_set input,.question_bloq textarea').not('.hidden input').not('[name*="Which"]').not('[name*="which"]');
 var inputsFilledSer = $inputsFilled.filter(function(index, element) {
     return jQuery(element).val() != "";
	 }).serializeArray().length ; //Aquí sacamos el total de las preguntas contestadas, no incluyes el wich.

  var totalInputs = jQuery('#init-info-profil-graph').data(qForm + '_total');//Este vale de inicio pero no en  el cambio porque sí que tenemos en cuenta los Wich.
  var rem = totalInputs - inputsFilledSer;//rem es de remaining, son los que quedan por rellenar.
if((rem < 0) ||(rem == 0)){
  jQuery('#'+qForm+'-profile-mens span').html( 'Ok, proceda a guadar el cuestionario!' );
  }else{
  jQuery('#'+qForm+'-profile-mens span').html(rem + ' Faltan'  );
}
  //Vamos a actualizar el valor del circle
  var totalInputsAllForms = jQuery('#init-info-profil-graph').data(qForm + '_total_forms');
  //console.log('Todos los inputs de este perfil son:'+totalInputsAllForms);
  var totalInputsAllFormsFilled = jQuery('#init-info-profil-graph').data(qForm + '_total_completed_forms');
  //console.log('Todos los inputs que este usuario ha rellenado son: '+totalInputsAllFormsFilled);
  var initInputsThisForm =  jQuery('#init-info-profil-graph').data(qForm + '_completed');
	//Tip en el marcado cuentas con los inputs del form. Con js sabes los que tienes rellenado.
	//sólo hay que ver la resta.
  var thisFormFilledIncrement = inputsFilledSer - initInputsThisForm;
  //console.log('Incremento' +thisFormFilledIncrement);
  var totalInputsAllFormsFilledUpdated = totalInputsAllFormsFilled + thisFormFilledIncrement;
  //console.log('Total actualizado' +totalInputsAllFormsFilledUpdated);
  var valueUpdated = totalInputsAllFormsFilledUpdated/totalInputsAllForms;

if(valueUpdated>1){
    valueUpdated = 1;
  }

jQuery('.circle-profile').circleProgress({
      value: valueUpdated,
  }).on('circle-animation-progress', function(event, progress) {
      jQuery(this).find('strong').html(parseInt(100 * valueUpdated) + '<i>%</i>');
  });
});
//FIN del circleprofilgraph




$activePregs.each(function(){
 $this = jQuery(this);
 numThisPreg = 1+numThisPreg;
 var remain = parseInt(100*(numPregsActive - numThisPreg)/numPregsActive);



$this.on('hover',function(){

//Ini del Hover con el fade y hide de los elementos anteriores/posteriores
  idArray = new Array();
  jQuery.each($activePregs, function (index,value){
                   idArray.push(jQuery(value).attr('id'));
                });

  prefRef = idArray.indexOf(jQuery(this).attr('id'));
  toBeDisplayed = [];
  toBeGrey = [];
  toBeHidden = [];

  $activePregs.each(function(index, element){
    if((index == prefRef)){
    	toBeDisplayed.push(element);
    }
    if((index == prefRef+1)||(index == prefRef-1) ){
      toBeGrey.push(element);
    }
    if((index > prefRef+1)|| (index < prefRef-1)){
      toBeHidden.push(element);
    }
	});

jQuery.each(toBeDisplayed, function(index, value){
      jQuery(value).css({opacity: 1});
    });

jQuery.each(toBeGrey, function(index, value){
      jQuery(value).css({opacity: 0.7});
    });

jQuery.each(toBeHidden, function(index, value){
      jQuery(value).css({opacity: 0.4});
  });
//Fin del fade hide de los elementos

//AHORA EL RESPOSICIONAMIENTO Y ACTUALIZACIÓN DE LA BARRA DE PROGRESO.

var position = jQuery(this).position();
var width = jQuery(this).css('width');
var topRefined = position.top -6;
var topRefinedProfileGraph = position.top + 240;
var leftRefined = position.left - 50;

if(!jQuery('#wizard').length){
    jQuery('.form-progress-bar').css({
      position:'absolute',
      top: topRefined + 'px',
      width: width
    });}

//Actualizamos el valor de la barra de progreso
var adv = 100*(prefRef)/numPregsActive;
vProgress = adv > 100 ? 100 : adv;
jQuery('.form-progress-bar').progressbar({
      value:vProgress
});
//FIN RESPOSICIONAMIENTO y ACTUALIZACIÓN DE LA BARRA DE PROGRESO



//REPOSICIONAMIENTO DEL CIRCLEGRAPH
if( (idArray.indexOf(jQuery(this).attr('id')) > 1) &&  (jQuery(window).width()>640)){
 var topMin = jQuery('.submenu-pages').position().top + jQuery('.submenu-pages').height() + 25;
 if(topRefinedProfileGraph < topMin ){
		topRefinedProfileGraph = topMin;
		}
jQuery('.left-profileuser').css("position","absolute");
jQuery('.left-profileuser').css({ //animate
      //"position":'absolute',
      "top": topRefinedProfileGraph+ 'px',// + 'px'
      //"width": width
    });
}else{
    	//jQuery('#menu-menu-myprofile > li:last-child')
			//Estamos colocando el circle en el primer y segundo elemento
	if((jQuery(window).width()>640)){
    jQuery('.left-profileuser').css("position","absolute");
    var altPrimerElement = jQuery(this).height;
    var newReference = jQuery('.submenu-pages > div > ul > li:last-child').position().top +115;//#menu-menu-myprofile
    var topRefinedProfileGraphRef = topRefinedProfileGraph + altPrimerElement;
    var topMin = jQuery('.submenu-pages').position().top + jQuery('.submenu-pages').height() + 25;
  	if(newReference < topMin ){
	  	newReference =topMin;
		}
    jQuery('.left-profileuser').css({ //animate
            //"position":'absolute',
            "top": newReference + 'px',// + 'px' //topRefinedProfileGraphRef
            //"width": width
          });
    }
}
//FIN DEL REPOSICIONAMIENTO DEL CIRCLEGRAPH




//INI en HOVER ADICIÓN DE LOS MENSAJES DE OK O POR CONTESTAR
//InputType
var inputRadio 	= jQuery(this).find('input[type="radio"]').length > 0 ? true : false;
var inputText 	=  jQuery(this).find('input[type="text"],textarea').length > 0 ? true : false;

//AlreadyWarnings
var noMessage      =	jQuery(this).find('span.message').length == 0 ? true : false;
var messageNotOk		=	jQuery(this).find('span.message.empty').length > 0 ? true : false;
var messageOk		=	jQuery(this).find('span.message.ok').length > 0 ? true : false;

if(inputRadio){
  var inputVal = jQuery(this).find('input[type="radio"]:checked').val();
  var conditionMessage = (inputVal === undefined);
  }

if(inputText){
  var inputVal = jQuery(this).find('input[type="text"],textarea').val();
  var conditionMessage = (inputVal == '');
  }

if(conditionMessage){
    if(noMessage){
              jQuery(this).append(contentMessageNotOk);
    }else{
          if(messageOk){
              jQuery(this).find('span.message').remove();
              jQuery(this).append(contentMessageNotOk);
            }
    }
 }else{
        if(noMessage){
                    jQuery(this).append(contentMessageOk);
          }else{
                    if(messageNotOk){
                    jQuery(this).find('span.message').remove();
                    jQuery(this).append(contentMessageOk);
                    }
                }
 }
//FIN en HOVER DE ADICIÓN DE LOS MENSAJES D OK O POR CONTESTAR EN EL SPAN
}); //Fin del hover




//va a haber código duplicado ahora con input text pero con otro evento.
$this.find('input[type="text"], textarea').each(
  function(){
    jQuery(this).on('change keyup',function(){
    $parentBloq =  jQuery(this).closest('.question_bloq,.comun_question_set');
    //AlreadyWarnings
    var noMessage      =	$parentBloq.find('span.message').length == 0 ? true : false;
    var messageNotOk	 =	$parentBloq.find('span.message.empty').length > 0 ? true : false;
    var messageOk		   =  $parentBloq.find('span.message.ok').length > 0 ? true : false;

    var inputVal = jQuery(this).val();
    var conditionMessage = (inputVal == '');

    if(conditionMessage){

          if(noMessage){
              $parentBloq.append(contentMessageNotOk);
              }else{
                if(messageOk){
                  $parentBloq.find('span.message').remove();
                  $parentBloq.append(contentMessageNotOk);
                  }
              }
        }else{
           if(noMessage){
              $parentBloq.append(contentMessageOk);
              }else{
                  if(messageNotOk){
                    $parentBloq.find('span.message').remove();
                    $parentBloq.append(contentMessageOk);
                    }
                  }
              }

        });
});

//va a haber código duplicado ahora con input radio y el evento click.
$this.find('input[type="radio"]').each(
   function(){
     jQuery(this).on('click',function(){
     $parentBloq =  jQuery(this).closest('.question_bloq,.comun_question_set');
     //AlreadyWarnings
     var noMessage      =	$parentBloq.find('span.message').length == 0 ? true : false;
     var messageNotOk	 =	$parentBloq.find('span.message.empty').length > 0 ? true : false;
     var messageOk		   =  $parentBloq.find('span.message.ok').length > 0 ? true : false;

     var inputVal = jQuery(this).val();
    var conditionMessage = (inputVal === undefined);

  if(conditionMessage){
       if(noMessage){
           $parentBloq.append(contentMessageNotOk);
           }else{
             if(messageOk){
               $parentBloq.find('span.message').remove();
               $parentBloq.append(contentMessageNotOk);
               }
             }
     }else{
        if(noMessage){
           $parentBloq.append(contentMessageOk);
             }else{
               if(messageNotOk){
                   $parentBloq.find('span.message').remove();
                   $parentBloq.append(contentMessageOk);
                 }
               }
           }
    });
   });

$this.on('mouseleave',function(){
  if(jQuery(window).width()>640){
      jQuery('.left-profileuser').fadeTo('slow',1);//? No sé por qué es esto.
 }
  //quiero quitar el mensaje de la pregunta
  if(jQuery(this).find('span.message.empty').length > 0 ){
    idElement = jQuery(this).attr('id');
    jQuery('#'+idElement).find('span.message.empty').fadeTo(800,0.1);
    setTimeout(function(){
       jQuery('#'+idElement).find('span.message.empty').remove()},800);
  }
});

 // $this.on('mouseout',function(){$activePregs.not(this).fadeTo( "slow" ,0.5)});


  /*-- PARTE DE TOLTIP DINÁMICO--*/
var message = 'Rellenando formulario postoperatorio'
$qlabel = $this.find('.udm_question_label');

if( $qlabel.find('span span.optional').length ){
    message  = 'Esta es su contestación número: '+numThisPreg+'<br/>';
    message += 'Responder a esta información es conveniente <br />';
    message += 'Le queda el '+remain+'% de su '+ infoAboutFormES.qpls +'.';
	if(!$this.hasClass('input_select')){
    $this.attr('title','');
    $this.tooltip( {
                      content:message,
                      position: { my: "left-250 center", at: "right top+27" },
                      show: { effect: "blind", duration: 500 },

            open: function (event, ui) {
            setTimeout(function () { jQuery(ui.tooltip).hide('explode');}, 1000);
					}

	 });
}else{
	$this.attr('title','');
	$this.find('.question_title.udm_question_label').tooltip( {
										content:message,
										position: { my: "left-250 center", at: "right top+27" },
										show: { effect: "blind", duration: 500 },

					open: function (event, ui) {
					setTimeout(function () { jQuery(ui.tooltip).hide('explode');}, 1000);
				}

 });
}

  }else{
    message  = 'Esta es su contestación número: '+numThisPreg+'<br/>';
    message += 'Le queda el '+remain+'% de su '+ infoAboutFormES.qpls +'.';

    $this.attr('title','');
    $this.tooltip( {
                    content:message,
                    position: { my: "left-250 center", at: "right top+20" },
                    show: { effect: "blind", duration: 500 },
      open: function (event, ui) {
            setTimeout(function () { jQuery(ui.tooltip).hide('explode');},1000);}
                    } );
  }
});//Fin del each por las activePregs

  //En el basic si cambia de tipo de usuario quitamos el profile graph.
if(jQuery('input[name="ncusertype"]').length){
  jQuery('input[name="ncusertype"]').on('change', function(){jQuery('.circle-profile').remove();});
}


} //Fin de si está en español y es uno de los forms de al principio.
}//Fin de la función gamifyier
