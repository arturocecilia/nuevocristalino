//Definimos las funciones necesaarias para "tener una versi�n de paciente".

function versionNC(){
	if(jQuery.cookie('ncpatient')){
		jQuery('.pteNoDisplay').css('display','none');
		//Metemos ahora cambios espec�ficos a�adidos a la visualizaci�n o no de ese div determinado.
		//Single IOL
		if(jQuery('#primary.site-content-single.single-lente').length){
			jQuery('#primary.site-content-single.single-lente').css('width','68%');
		}
			
	}else{
		jQuery('.pteNoDisplay').css('display','block');
		//Reinstauramos los valores anteriores al hipot�tico cambio de propiedades por la cookie de paciente.
		//Single IOL
		if(jQuery('#primary.site-content-single.single-lente').length){
			jQuery('#primary.site-content-single.single-lente').css('width','51%');
		}
		
		
	}
	
}

//Donde se cambia la versi�n? - Al clickear en los links a tal efecto y al cambiar el filtro.