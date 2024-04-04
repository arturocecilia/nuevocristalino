/*-- JS--*/

jQuery(document).ready(function(){

userDataFormLoader();
userProfClinicsLoader();

if(jQuery('#page_patientform_id').length){
					linksGeneratorInputsLoader();
		}

if(jQuery('#change_sx_defaults').length){
					customConfigEditer();
		}
});



function imageInputClickEffect(){
if(jQuery('.question_inputs.images label').length){

	jQuery('.question_inputs.images label').on('click',function(){

	        jQuery(this).siblings().removeClass('imageBold');
	        jQuery(this).siblings().addClass('imageLight');

	        jQuery(this).removeClass('imageLight')
	        jQuery(this).addClass('imageBold');
	      });
				}
}

function userDataFormLoader(){
			profileFormLoader();
			inputsStyler();
			numerate_fields();
			give_wrapper_display();
			specific_input_relations();
			hiddeUnnecesaryCompulsoryMessages();
			show_or_hide_fields();//Lo metemos aquí por si hay defaults...
			supersocializerTexts();
			imageInputClickEffect();
			}



function inputsStyler(){
//Estilado de input tipo estrella.
if(jQuery('.stars').length){
	 jQuery('.stars input').on('click', function(){
	  		$thisInput = jQuery(this);
	  		var idInput = $thisInput.attr('id');
				var labelText =  jQuery('label[for='+idInput+']').html();
	  		$thisInput.parent().siblings('.starexpla').html(labelText);
				} );
 }





//Creamos el efecto hover de que aparezcan checked las estrellas anteriores.
$stars = jQuery('.question_inputs.stars label');
$stars.on('hover',function(){
	var starsParent = jQuery(this).parent();
  var starSisters = starsParent.find('label');
	console.log(starSisters.index(jQuery(this)));
	var indexHover = jQuery('.question_inputs.stars label').index(jQuery(this));

 //console.log(starsParent);
  starSisters.each(function(){
    $this = jQuery(this);
//creo que este $stars
//console.log($this.parent().find('.stars').index($this));


    if($stars.index($this) >= indexHover){
      $this.addClass('amarilleada');
      console.log($this.addClass());
    }else{
    $this.removeClass('amarilleada');
    }
  });
});
jQuery('.question_inputs.stars').on('mouseout',function(){

  $stars.each(function(){
     $this = jQuery(this);
    $this.removeClass('amarilleada');
  });

});

//Estilado de input tipo sliderbar
 if(jQuery('.sliderbar').length){
			//solo lo aplicamos si el no estamos en móvil puesto que el slider es horizontal, hacemos default to vertical buttons de jquery.
	if(jQuery(window).width()>640){
		 jQuery('.sliderbar').radiosToSlider({
		    			animation: true,
						});
		}else{
					jQuery('.sliderbar').buttonsetv();
							}
}
//Estilado de los slects tipo barrating (bars-movie o bars-1to10)
if(jQuery('.question_inputs.barrating select.toCombobox').length){
	 jQuery('.question_inputs.barrating select.toCombobox').barrating('show', {
						//theme: 'bars-movie'
						theme: 'bars-1to10'
				});
			}
}




function profileFormLoader(){
//Transformación con Jquery UI de los elementos de los forms a partir del marcado
//generado en get_user_data_form
//Seleccionamos los inputs con data-buttonset = vertical
var $jqueryVElements =jQuery('[data-buttonset="vertical"]');
jQuery($jqueryVElements).buttonsetv();
//Lo mismo pero con el data-horizontal
var $jqueryHElements =jQuery('[data-buttonset="horizontal"]');
jQuery($jqueryHElements).buttonset();
//De la misma manera que hemos convertido los input radio en buttonsets vamos a convertir los selects en comboboxes.
jQuery('.question_inputs.toCombobox select.toCombobox').combobox();
///////////////////////////////////////////////////////////////////////

if((jQuery('form.user-manager-form').length) || (jQuery('#id_bloq_usertype').length)){
//Actualizar el form para que sea consistente con cambios:
//valores dependientes de otros, renumeración, mensajes de obligatoriedad.
 jQuery('input[type="radio"]').on('change', show_or_hide_fields);
 jQuery('input[type="radio"]').on('change', numerate_fields);
 jQuery('input[type="radio"]').on('change',hiddeUnnecesaryCompulsoryMessages);
 jQuery('input[type="radio"]').on('change',checkWizardHeight);

 jQuery("input[type='text']").on('change',hiddeUnnecesaryCompulsoryMessages);
//voy a meter también en el input text el show_or_hide_fields por los if empty.
  jQuery("input[type='text']").on('change',show_or_hide_fields);
	jQuery("input[type='text']").on('change',checkWizardHeight);
		}
}


function checkWizardHeight(){

	if(jQuery('#wizard').length){
		console.log('check wizard height');
		jQuery('#wizard').smartWizard('fixHeight');
	}

}



function show_or_hide_fields(){
//Primero cojo los elementos en los que hay condición.
var conditionedElements = jQuery('[data-condition]');
conditionedElements.each(function() {
 //evaluamos la condición.
 // Parse the string back into a proper JSON object
 var condition = JSON.parse(jQuery.parseJSON(jQuery(this).data('condition')));
 var currentElement = this;
 var notvisible = 0;
 //ojo que pueden ser dos condiciones con que una de las dos diga que no es visible=> no es visible
jQuery.each(condition[0], function(key,data){
 	if(key != 'not_empty'){
		//if  the input type is radio.
  	var id=jQuery('[name='+key+']:first').closest('.question_bloq').attr('id');
  	if(jQuery("#"+id+" :radio:checked").attr('value') == data){
    										//
  		}
  		else{
  				notvisible = 1+notvisible;
  		}
  }
//Ahora hay que poner la lógica del not_empty alterando el notvisible a su valor correspondiente.
 if(key == 'not_empty'){


		if(jQuery('#input_'+data).val()!=''){
			 notvisible =0;//1+notvisible;
			}else{
						notvisible =1+notvisible;
    		    }
    }
//Ahora tenemos que poner la lógica de or_condition.

if(key == 'or_condition'){
var conditions = [];
var visible = 0;
	for (i=0; i<data.length; ++i) {
		//console.log(data[i]);

		for(var property in data[i]){
			//console.log(data[i][property]);
			var thisPropConds = data[i][property];
			//console.log(property);
			//console.log(thisPropConds.length);
////////////////////////////////////////////////////////////////////////////////
				for (j=0; j<thisPropConds.length; ++j) {
	if(property != 'not_empty'){
						//Hacemos los checks aquí.
						var id=jQuery('[name='+property+']:first').closest('.question_bloq').attr('id');
						if(jQuery("#"+id+" :radio:checked").attr('value') == thisPropConds[j]){
								  visible = visible +1;
							}
							else{

							}
				}else{
					//console.log('or_cond con not_empty');

					if(property == 'not_empty'){

						if(jQuery('#input_'+thisPropConds[j]).val()!=''){

							console.log(thisPropConds[j]);
							console.log(currentElement);
							 visible  =visible +1 ;//1+notvisible;
							}else{
										//notvisible =1+notvisible;
										}
						}
					}
				}



	////////////////////////////////////////////////////////////////////////////////
if(visible){
	notvisible = 0;
}else{
	notvisible = 1;
}

				}
		}
	}//FIN or_condition

//INI not_be
if(key == 'not_be'){
var conditions = [];
var invisible = 0;
	for (i=0; i<data.length; ++i) {
		//console.log(data[i]);

		for(var property in data[i]){
			//console.log(data[i][property]);
			var thisPropConds = data[i][property];
			//console.log(property);
			//console.log(thisPropConds.length);
////////////////////////////////////////////////////////////////////////////////
				for (j=0; j<thisPropConds.length; ++j) {
	if(property != 'not_empty'){
						//Hacemos los checks aquí.
						var id=jQuery('[name='+property+']:first').closest('.question_bloq').attr('id');
						if(jQuery("#"+id+" :radio:checked").attr('value') == thisPropConds[j]){
								  invisible = invisible +1;
							}
							else{

							}
				}else{
					if(property == 'not_empty'){

						if(jQuery('#input_'+thisPropConds[j]).val()!=''){
							 visible  =visible +1 ;//1+notvisible;
							 console.log('El input: '+jQuery(this));
							 console.log('es visible, porque');
							 console.log('#input_'+thisPropConds[j]+' tiene valor distinto de 0');
							}else{
										//notvisible =1+notvisible;
										}
						}
					}
				}



	////////////////////////////////////////////////////////////////////////////////
if(invisible){
	notvisible = 1;
}else{
	notvisible = 0;
}

				}
		}
	}//FIN not_be




//FIN not_be

});

if(notvisible){
							jQuery(currentElement).removeClass('visible');
							jQuery(currentElement).addClass('hidden');
	}else{
				jQuery(currentElement).addClass('visible');
				jQuery(currentElement).removeClass('hidden');
				}
});






}

//Vamos a hacer una renumeración con el cambio.
//variable y recorremos preguntas asignando número y saltando si tiene la clase hidden.

function numerate_fields(){
var question_number = 1;
jQuery('.question_number').each(function(){
if(jQuery(this).parent().hasClass('hidden')){
				  		//
 }else{
			jQuery(this).text(question_number);
			question_number = 1 + question_number;
			}
});
//Hacemos el apaño del added.
jQuery('.question_number_added').each(function(){
	if(jQuery(this).parent().hasClass('hidden')){
				  		//
		}else{
				  var valueQPrev = jQuery(this).parent().prev().find('.question_number').html();
				  jQuery(this).text(valueQPrev+' -1');
				  }
});
}

//Si estamos en el edit profile por defecto.
function give_wrapper_display(){
if(jQuery('#editaccwrapper').length){
	jQuery('#editaccwrapper').accordion({
				collapsible: true,
				//event: "click hoverintent",
				active : 'none'
    		});
  jQuery('#ncaccwrapper2').accordion({
  			collapsible: true,
  			//event: "click hoverintent",
  			active : 'none'
  			});
 jQuery('#ncaccwrapper3').accordion({
				collapsible: true,
				//event: "click hoverintent",
				active : 'none'
				});
 jQuery('.wpua-edit-container > p,.wpua-edit-container > div,.wpua-edit-container > input').wrapAll('<div id="myavatarwrap" />');

 jQuery('.wpua-edit-container').accordion({
				collapsible: true,
 			  //event: "click hoverintent",
				active : 'none'
    		});
	jQuery('#your-profile>table,#your-profile>h3').css('display','none');
 }
}

//La siguiente es una relación entre inputs puesta directamnete a mano.
function specific_input_relations(){
if(jQuery('#input_pre_gradMedRec_Unknown').length){
	jQuery("#input_pre_gradMedRec_Unknown").blur(function(){
  if(jQuery(this).val() == ''){
  	 jQuery('#id_bloq_pre_grad').addClass('hidden');
     jQuery('#id_bloq_pre_grad').removeClass('visible');
    }else{
    	jQuery('#id_bloq_pre_grad').addClass('visible');
    	jQuery('#id_bloq_pre_grad').removeClass('hidden');
   	}
  });
 }
}


function hiddeUnnecesaryCompulsoryMessages(){
jQuery('.compulsoryLocator').each(function(){
  var element = jQuery(this).find('input').first();
  var name = element.attr('name');
  var type = element.attr('type');
  var value = '';
  if(type == 'text'){
    value = element.val();
  }
  if(type == 'radio'){
    value = jQuery('input[name='+name+']:checked').val();
  }
//ahora comprobamos el valor y si es '' hacemos invisible el label.
  if(value != ''){
    var dataLocator = jQuery(this).data('locator');
    console.log(dataLocator);
    jQuery('[data-relevance="'+dataLocator+'"]').hide();
  }
  if(value == ''){
    var dataLocator = jQuery(this).data('locator');
    console.log(dataLocator);
    jQuery('[data-relevance="'+dataLocator+'"]').show();
  }
 });
}



/*-- Supersocializer part: A veces los botones salen sin el texto */
function supersocializerTexts(){

if(jQuery('ul.the_champ_login_ul').length){
jQuery('ss.theChampLoginSvg.theChampGoogleLoginSvg').ready(function(){
	jQuery('ss.theChampLoginSvg.theChampGoogleLoginSvg').html('Gmail');
	});


jQuery('ss.theChampLoginSvg.theChampFacebookLoginSvg').ready(function(){
		jQuery('ss.theChampLoginSvg.theChampFacebookLoginSvg').html('Facebook');
	});

jQuery('ss.theChampLoginSvg.theChampTwitterLoginSvg').ready(function(){
		jQuery('ss.theChampLoginSvg.theChampTwitterLoginSvg').html('Twitter');
	});

jQuery('ss.theChampLoginSvg.theChampLinkedinLoginSvg').ready(function(){
		jQuery('ss.theChampLoginSvg.theChampLinkedinLoginSvg').html('LinkedIn');
	});
	}

	}



function 	userProfClinicsLoader(){
//Vamos a cargar los autosuggest en dos inputs:
// #input_o_userProfRelatedClinic (en basic de profesional)
// #input_p_clinicChosen_Which (en el basic/registro de paciente)
// #input_g_clinicChosen_WhichClinic (en el pre de paciente)
// #input_post_clinicSx (en el post de paciente)

$inputsToAutoClinicComplete = jQuery('#input_o_userProfRelatedClinic,#input_p_clinicChosen_Which,#input_g_clinicChosen_WhichClinic,#input_post_clinicSx');

if($inputsToAutoClinicComplete.length){
	$inputsToAutoClinicComplete.each(function(){
	$self = jQuery(this);
	$self.autocomplete({
    		source: function (request, response) {
				var	urlToAjax = location.protocol + '//' +window.location.host+ '/wp-admin/admin-ajax.php?action=getAllClinics';
			  jQuery.ajax({
      							dataType: "json",
      							type : 'Get',
      							url: urlToAjax , //'https://www.nuevocristalino.es
      							data: {"s":request.term},
      							success: function(data) {
        								             console.log(request.term);
																	   response(data);
            											}
        							});
    																				}
											}).focus(function() {
															             jQuery(this).autocomplete("search",' ');
															});
	 });
  }
}


//Funciones ajax para generar el link y para enviar el email con el link.
function 	linksGeneratorInputsLoader(){
jQuery('#page_patientform_id,#clinic_id,#linkgen_iol_id').combobox();
//Añadimos aquí mismo la función que genera el link dinámicamente.
jQuery('#generateLink').on('click', function(){
	//vamos a quitar el link anterior nada más hacer click para que no haya equívocos.
	jQuery("#generatedLink-wrapper").html('Generating the link.../Generando el enlace/');

	var	urlToAjax = location.protocol + '//' +window.location.host+ '/wp-admin/admin-ajax.php?action=getLink';

  var formID = jQuery('#page_patientform_id').val();
	var clinic_ID = jQuery('#clinic_id').val();
	var iol_ID = jQuery('#linkgen_iol_id').val();
	var u_email = jQuery('#u_email').val();

	jQuery.ajax({
							type : 'Get',
							url: urlToAjax , //'https://www.nuevocristalino.es
							data: {"page_form_ID":formID, "clinic_id":clinic_ID, "iol_id": iol_ID, "u_email":u_email },
							success: function(data) {
               			jQuery('#generatedLink-wrapper').html('<a href="'+data+'" class="noGotoMain" target="_blank">'+data+'</a>');
										}
							});
	});

jQuery('#sendLink').on('click',function(){
var	urlToAjax = location.protocol + '//' +window.location.host+ '/wp-admin/admin-ajax.php?action=sendLink';
var linkToBeSent = jQuery('#generatedLink-wrapper a').attr("href");
var u_email = jQuery('#u_email').val();

jQuery.ajax({
						 type : 'Get',
						 url: urlToAjax , //'https://www.nuevocristalino.es
						 data: {"linkToBeSent":linkToBeSent, "u_email":u_email },
						 success: function(data) {
 									 jQuery('#generatedLink-wrapper').html('<div>'+data+'</div>');
													 }
									 });
 });
}


function customConfigEditer(){
		jQuery('#clinic_id,#linkgen_iol_id').combobox();
}
