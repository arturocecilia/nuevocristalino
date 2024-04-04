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
        	
        	//alert(pathToImagFolder);   
           //alert('Simloader ejecutada');
            jQuery("#sym").symlens({
                easeOut : "easeInExpo",
                easeIn : "easeOutExpo",
                duration: 1000,
                width: 800, //obligatorio
                height: 450, //obligatorio
                images : [ //obligatorio
                ["normal-day", ""+ pathToImagFolder + "normal-day.png"], //http://www.nuevocristalino.es/wp-content/themes/iol/images/
                ["normal-night", ""+ pathToImagFolder + "normal-night.png"],
                ["presbicia-day", "" + pathToImagFolder + "presbicia-day.png"],
                ["presbicia-night", "" + pathToImagFolder + "presbicia-night.png"],                
                ["cataratas-day", "" + pathToImagFolder + "cataratas-day.png"],
                ["cataratas-night", "" + pathToImagFolder + "cataratas-night.png"],
                ["cataratasFull-day", "" + pathToImagFolder + "cataratasFull-day.png"],
                ["cataratasEnd-day", "" + pathToImagFolder + "cataratasEnd-day.png"],
                ["monofocal-day", "" + pathToImagFolder + "presbicia-day.png"],
                ["multifocal-day", "" + pathToImagFolder + "normal-day.png"]
                ]       
            });
               
            jQuery( '#sym-control').buttonset();
            
            jQuery( '#scenarios').buttonset();
            
            jQuery( '#scenarios input[type="radio"]').each(function (index,element){
            
            		//queremos que cambie el dash de los botones.
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
            				var currentPrev = currentImage;
            				var currentNew = currentPrev.split('-')[0] + '-' + thisScenario;
            				jQuery( "#sym" ).symlens('drawImage',currentNew);//attr('id')
            				currentImage = currentNew;
            				});            				
            		});
            	
            });
            
            
            jQuery('#sym-control input[type="radio"]').each(function(index, element){
               jQuery(element).on('click', function(){
               		//alert('sym-clickeado');
                    jQuery( "#sym" ).symlens('drawImage',jQuery(this).data('image'));//attr('id')
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