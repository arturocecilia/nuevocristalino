//Primero cargamos el formulario en un $object


jQuery(document).ready(function(){

gamifyier();

});



function gamifyier(){

//Primero cargamos el formulario en un $object


var currentLang = document.documentElement.lang; //- no _
var langEsp =  ['es-MX','es-ES','es-CO','es-CL'];
$formLength = jQuery('#qpls,#catques9sf,#prols,#addProfileBasicData').length;//#prols,,#prols

if((jQuery.inArray(currentLang,langEsp)!= -1) && $formLength){
//Salimos de esto si no se cumple lo anterior.
$form= jQuery('#qpls,#prols,#catques9sf,#addProfileBasicData')



$activePregs = $form.find('.question_bloq,.comun_question_set');//.not(".hidden[data-condition]");//No incluimos las dinámicas para no desmoralizar más de la cuenta


currentForm = $form.attr('id');
numPregsActive = $activePregs.length;
numThisPreg = 0;

if(jQuery.inArray(currentLang,langEsp)!= -1){
  var infoAboutFormES = {
                          "addProfileBasicData": "Perfil básico de usuario",//vamos a meter este
                          "qpls" : "Información preoperatoria",
                          "prols": "Resultados de su operación ocular",
                          "catques9sf": "Resultados de su operación de cataratas"
                        }

  //console.log(infoAboutFormES.qpls);
  }


  //inicializamos el pregressbar

  jQuery('<div class="form-progress-bar"></div>').insertBefore('#'+currentForm); //.find('.question_bloq ').first()






  var iniPos = $form.find(">:first-child").position();

  var iniPosTopRefined = iniPos.top -6; //6
  //console.log(iniPos);
  var iniPosLeftRefined = iniPos.Left + 4;
  var width = $form.find(">:first-child").css('width');

   jQuery('.form-progress-bar').progressbar({
    value:0
  });

    jQuery('.ui-progressbar-value.ui-widget-header.ui-corner-left').css({
      //background:'#fea63c',//'https:www.nuevocristalino.es/wp-content/plugins/lente-intraocular/images/step-bar.gif',//'#fea63c',
      border: '1px solid #d3d3d3'
  });

  jQuery('.form-progress-bar').css({
    height:'10px',
    border: '1px solid #d3d3d3',
    position: 'absolute',
    top: iniPosTopRefined + 'px',
    left: iniPosLeftRefined + 'px',
    width: width

  })






//Hacemos que aparezca un tooltipo con info en la parte superior derecha de la caja de info.
/*$form.find('.question_bloq').attr('title','');
$form.find('.question_bloq').tooltip( {content:"Awesome title!", position: { my: "left-150 center", at: "right center" }} );
*/

complexStructure = new Array();

contentMessageOk 			= '<span class="message ok">Pregunta Contestada!</span>';
contentMessageNotOk 		= '<span class="message empty">No has contestado a esta pregunta</span>';


//ponemos aquí la lógica de que al se actualice el profile-graph.

jQuery('form input, form select').on('change',function(){
  var qForm = jQuery('form').attr('id');
  var inputsFilled = jQuery('form').serializeArray().length - 1;
  var totalInputs = jQuery('#init-info-profil-graph').data(qForm + '_total');
  jQuery('#'+qForm+'-profile-mens span').html(totalInputs - inputsFilled + ' Faltan'  );

  //Vamos a actualizar el valor del circle
  var totalInputsAllForms = jQuery('#init-info-profil-graph').data(qForm + '_total_forms');
  console.log('Todos los inputs de este perfil son:'+totalInputsAllForms);
  var totalInputsAllFormsFilled = jQuery('#init-info-profil-graph').data(qForm + '_total_completed_forms');
  console.log('Todos los inputs que este usuario ha rellenado son: '+totalInputsAllFormsFilled);
  var initInputsThisForm =  jQuery('#init-info-profil-graph').data(qForm + '_completed');
  console.log('Todos los inputs que este usuario había rellenado en este form son: '+totalInputsAllFormsFilled);

  var thisFormFilledIncrement = inputsFilled - initInputsThisForm;
  var totalInputsAllFormsFilledUpdated = totalInputsAllFormsFilled + thisFormFilledIncrement;
  var valueUpdated = totalInputsAllFormsFilledUpdated/totalInputsAllForms;

  console.log('El nuevo valor es: '+valueUpdated);

  jQuery('.circle-profile').circleProgress({
      value: valueUpdated,
  }).on('circle-animation-progress', function(event, progress) {

      jQuery(this).find('strong').html(parseInt(100 * valueUpdated) + '<i>%</i>');
  });


});



$activePregs.each(function(){


  $this = jQuery(this);
  numThisPreg = 1+numThisPreg;
  var remain = parseInt(100*(numPregsActive - numThisPreg)/numPregsActive);



  /*-- PARTE DEL FADE DE ELEMENTOS ANTERIORES Y POSTERIORES --*/
  //$elementsToBeDisplayed = jQuery($activePregs[numThisPreg-1],$activePregs[numThisPreg],$activePregs[numThisPreg+1]);


  $this.on('hover',function(){

    //Necesitamos el prefRef

        idArray = new Array();

        jQuery.each($activePregs, function (index,value){
                                               idArray.push(jQuery(value).attr('id'));
                                          });


      prefRef = idArray.indexOf(jQuery(this).attr('id'));

    toBeDisplayed = []; //[$activePregs[prefRef],$activePregs[prefRef +1 ],$activePregs[prefRef+2]];

    toBeGrey = []; //[$activePregs[prefRef+3]]

    toBeHidden = [];


    $activePregs.each(function(index, element){

      if((index == prefRef)){
      toBeDisplayed.push(element);
        //console.log(element);
        //console.log(index);
      }

      if((index == prefRef+1)||(index == prefRef-1) ){
        toBeGrey.push(element);
        //console.log(element+'greyed');
      }

      if((index > prefRef+1)|| (index < prefRef-1)){
        toBeHidden.push(element);
        //console.log(element+'greyed');
      }


            });



    jQuery.each(toBeDisplayed, function(index, value){
      jQuery(value).css({opacity: 1});
            //jQuery(value).fadeIn( "slow", function(){console.log('fade in realizado')} );
        });

    jQuery.each(toBeGrey, function(index, value){
      jQuery(value).css({opacity: 0.7});
      //  jQuery(value).fadeTo( "slow",0.5);
        });
    jQuery.each(toBeHidden, function(index, value){
      jQuery(value).css({opacity: 0.4});
           // jQuery(value).fadeTo( "slow",0.2);
        });

    //AHORA EL RESPOSICIONAMIENTO DE LA BARRA DE PROGRESO.

    var position = jQuery(this).position();
    var width = jQuery(this).css('width');

    var topRefined = position.top -6;
    var topRefinedProfileGraph = position.top + 240;
    var leftRefined = position.left - 50;
    //console.log(topRefined);



//  console.log(idArray.indexOf(jQuery(this).attr('id'))+' es el index');
    jQuery('.form-progress-bar').css({
      position:'absolute',
      top: topRefined + 'px',
      width: width
    });

    //Añadimos posicionamiento del avance del perfil.

    //vamos a meterle una animación



if( (idArray.indexOf(jQuery(this).attr('id')) >0) &&  (jQuery(window).width()>640)){
/*
    jQuery('.left-profileuser').css({
      position:'absolute',
      top: topRefinedProfileGraph + 'px',
      width: width
    });*/

//console.log(topRefinedProfileGraph + 'px');
jQuery('.left-profileuser').css("position","absolute");


    jQuery('.left-profileuser').animate({
      //"position":'absolute',
      "top": topRefinedProfileGraph+ 'px',// + 'px'
      //"width": width
    });


    }
    else{

      jQuery('.left-profileuser').css("position","absolute");
      var altPrimerElement = jQuery(this).height;
      var topRefinedProfileGraphRef = topRefinedProfileGraph + altPrimerElement;

          jQuery('.left-profileuser').animate({
            //"position":'absolute',
            "top": topRefinedProfileGraphRef+ 'px',// + 'px'
            //"width": width
          });


        //
  /*    jQuery('.left-profileuser').css("position","relative");
      jQuery('.left-profileuser').css("top","0px");*/
    }


    //actualizamos el valor de la barra de progreso

    var adv = 100*(prefRef)/numPregsActive;
    vProgress = adv > 100 ? 100 : adv;

    jQuery('.form-progress-bar').progressbar({
      value:vProgress
    });



    //InputType
    var inputRadio 	= jQuery(this).find('input[type="radio"]').length > 0 ? true : false;
    var inputText 	=  jQuery(this).find('input[type="text"]').length > 0 ? true : false;
    //AlreadyWarnings
    var noMessage      =	jQuery(this).find('span.message').length == 0 ? true : false;
    var messageNotOk		=	jQuery(this).find('span.message.empty').length > 0 ? true : false;
    var messageOk		=	jQuery(this).find('span.message.ok').length > 0 ? true : false;

    //console.log('No message '+noMessage);

    //Vamos a añadir un span persistente informativo con la validación->


    if(inputRadio){
      var inputVal = jQuery(this).find('input[type="radio"]:checked').val();
      var conditionMessage = (inputVal === undefined);
      //console.log('inputRadio!!');
      }
    if(inputText){
      var inputVal = jQuery(this).find('input[type="text"]').val();
      var conditionMessage = (inputVal == '');
      //console.log('inputText!!');
      }




          if(conditionMessage){
                console.log('está vacíoo');
                if(noMessage){
                    jQuery(this).append(contentMessageNotOk);
                    console.log('No previousMessage adding Not Ok');
                    }else{
                      if(messageOk){
                        console.log('PreviousMessage oK REMOVING AND adding Not Ok');
                        jQuery(this).find('span.message').remove();
                        jQuery(this).append(contentMessageNotOk);
                        }

                      }

              }else{
                 if(noMessage){
                    jQuery(this).append(contentMessageOk);
                      console.log('No previousMessage adding Ok');
                      }else{
                        if(messageNotOk){
                            console.log('PreviousMessage nOT oK REMOVING AND adding  Ok');
                            jQuery(this).find('span.message').remove();
                            jQuery(this).append(contentMessageOk);
                          }

                        }
                    }


                             });







    /*-- En lo que al click se refiere va a ser igual a la lógica del onhover pero con--*/



//va a haber código duplicado ahora con input text.
 $this.find('input[type="text"]').each(
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
          console.log('está vacíoo');
          if(noMessage){
              $parentBloq.append(contentMessageNotOk);
              console.log($parentBloq);
              console.log('No previousMessage adding Not Ok');
              console.log('Eso eso  '+contentMessageNotOk);
              }else{
                if(messageOk){
                  console.log('PreviousMessage oK REMOVING AND adding Not Ok');
                  console.log(contentMessageNotOk);
                  $parentBloq.find('span.message').remove();
                  $parentBloq.append(contentMessageNotOk);
                  }

                }

        }else{
           if(noMessage){
              $parentBloq.append(contentMessageOk);
                console.log('No previousMessage adding Ok');
                }else{
                  if(messageNotOk){
                      console.log('PreviousMessage nOT oK REMOVING AND adding  Ok');
                      $parentBloq.find('span.message').remove();
                      $parentBloq.append(contentMessageOk);
                    }

                  }
              }

                    });

                }
 );

//va a haber código duplicado ahora con input radio.
$this.find('input[type="radio"]').each(
   function(){



             jQuery(this).on('click',function(){

               $parentBloq =  jQuery(this).closest('.question_bloq,.comun_question_set');
               //AlreadyWarnings
               var noMessage      =	$parentBloq.find('span.message').length == 0 ? true : false;
               var messageNotOk	 =	$parentBloq.find('span.message.empty').length > 0 ? true : false;
               var messageOk		   =  $parentBloq.find('span.message.ok').length > 0 ? true : false;


               var inputVal = jQuery(this).val();
               console.log(inputVal);
               var conditionMessage = (inputVal === undefined);

 if(conditionMessage){
       console.log('está vacíoo');
       if(noMessage){
           $parentBloq.append(contentMessageNotOk);
           console.log($parentBloq);
           console.log('No previousMessage adding Not Ok');
           console.log('Eso eso  '+contentMessageNotOk);
           }else{
             if(messageOk){
               console.log('PreviousMessage oK REMOVING AND adding Not Ok');
               console.log(contentMessageNotOk);
               $parentBloq.find('span.message').remove();
               $parentBloq.append(contentMessageNotOk);
               }

             }

     }else{
        if(noMessage){
           $parentBloq.append(contentMessageOk);
             console.log('No previousMessage adding Ok');
             }else{
               if(messageNotOk){
                   console.log('PreviousMessage nOT oK REMOVING AND adding  Ok');
                   $parentBloq.find('span.message').remove();
                   $parentBloq.append(contentMessageOk);
                 }

               }
           }

                 });

             }
);








  $this.on('mouseleave',function(){

    //animación para fadeout del profilegraph.
        //jQuery('.left-profileuser').css('opacity','0');

  if(jQuery(window).width()>640){
        //jQuery('.left-profileuser').fadeTo(1,'0.1');
      //  setTimeout(function(){jQuery('.left-profileuser').fadeTo('slow',1);},300);
      jQuery('.left-profileuser').fadeTo('slow',1);
}




    //quiero quitar el mensaje de la pregunta
    if(jQuery(this).find('span.message.empty').length > 0 ){
      idElement = jQuery(this).attr('id');
      jQuery('#'+idElement).find('span.message.empty').fadeTo(800,0.1);
      setTimeout(function(){

          jQuery('#'+idElement).find('span.message.empty').remove()},800);
      }


    /*
                                    $toBeDisplayed = jQuery(jQuery(this),jQuery(this).next(),jQuery(this).next().next());
                                    $toBeHidden =$activePregs.not( $toBeDisplayed);
                                    $toBeHidden.fadeOut( "slow" )*/
  });

 // $this.on('mouseout',function(){$activePregs.not(this).fadeTo( "slow" ,0.5)});


  /*-- PARTE DE TOLTIP DINÁMICO--*/
  var message = 'Rellenando formulario postoperatorio'
  $qlabel = $this.find('.udm_question_label');

  if( $qlabel.find('span span.optional').length ){

    message  = 'Esta es su contestación número: '+numThisPreg+'<br/>';
    message += 'Responder a esta información es conveniente <br />';
    message += 'Le queda el '+remain+'% de su '+ infoAboutFormES.qpls +'.';


    $this.attr('title','');
    $this.tooltip( {
                      content:message,
                      position: { my: "left-250 center", at: "right top+27" },
                      show: { effect: "blind", duration: 500 },

            open: function (event, ui) {
            setTimeout(function () { jQuery(ui.tooltip).hide('explode');}, 1000);}




    } );


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
  });
}
}
