


//Validación del formulario utilizando el jquery validator.

function postOpFormValidation(){
if(jQuery("#post-op-form").length){
jQuery("#post-op-form").validate(
	{
    messages: {
    			//Aquí vienen los ids o names de los inputs
    			email: {
    					//Aquí vienen los mensajes para las validaciones correspondientes.
      					//required: "Necesitamos tener constancia de su buena fe",
      					email: "Escriba una direcci&oacute;n de email en formato v&aacute;lido"
    					},
    			age:	{
    					minlength : "Por favor introduzca una edad de al menos 2 caracteres"
    					}
  				}
	}
);
}
}
//Hay que hacer lo de siempre con la sentencia anterior, wrappearla en una función y ejecutarla también en las llamadas ajax-
jQuery(document).ready(function(){

postOpFormValidation();

});

//Creamos las transiciones para mejorar la experiencia de usuario.

jQuery('#surgeryTime').on("change", 
    function (){
                //alert(jQuery(this).children(':checked').val());
                jQuery(this).children('label').animate(
                                        {   color: "#008000",//"#FFFFFF",//,
                                            opacity: 0.5
                                        },
                                        { 
                                        duration: 1000, 
                                        complete: function() {
                                            // Animation complete.
                                            //jQuery(this).css('color', 'yellow');
                                            console.log('Transición finalizada');
                                        }});
                });
                
                /*
                //,
                                            //left: "+=50"
                                            //height: "toggle"
                */