//Funciones necesarias para el API de Gmaps.
	//gmapsClinicsLoader()
	//getAllClinicsCoordsAddMapWith()
	//getWithinDistanceClinicsCoordsAddMap()

//variables para checkear si el usuario ha dado permiso y su posición ya se ha obtenido.
//Estas variables no están sujetas al onload ni nada puesto que se comparten de ser posible entre la página de clinicas
//y el single clinic.

var userLatitude;
var userLongitude;

//Variable para registrar si es la primera vez que se muestran las clínicas en el mapa.

var firstLoad;

firstLoad = 0;
console.log('El first load es: ' + firstLoad);

//var userUndefined;

//Estas dos variables vendrán dadas por la versión del país del site.

console.log(site.Country);

if(site.Country){
    //console.log('Lo ha cogido y es: '+site.Country);
    switch(site.Country)
        {
            case 'es_ES':
                         var referenceLatitude   =   40.416944;
                         var referenceLongitude  =   -3.703611;  
            break;
            case 'es_MX':
                         var referenceLatitude   =   19.432602;
                         var referenceLongitude  =   -99.133205;  
            break;
            case 'en_GB':
                         var referenceLatitude   =   51.504851;
                         var referenceLongitude  =   -0.078692;              
            break;
            case 'de_DE':
                         var referenceLatitude   =   52.520005;
                         var referenceLongitude  =   13.404954;              
            break;

            case 'es_CO':
                         var referenceLatitude   =   4.598056;
                         var referenceLongitude  =   -74.075833;              
            break;

            case 'fr_FR':
                         var referenceLatitude   =   48.865633;
                         var referenceLongitude  =   2.321236;              
            break;

            case 'es_CL':
                         var referenceLatitude   =   -33.469120;
                         var referenceLongitude  =   -70.641997;              
            break;

            case 'de_AT':
                         var referenceLatitude   =   48.208174;
                         var referenceLongitude  =   16.373819;              
            break;

            case 'en_US':
                         var referenceLatitude   =   39.50;
                         var referenceLongitude  =   -98.35;              
            break;

            
            default:
                         var referenceLatitude   =   40.416944;
                         var referenceLongitude  =   -3.703611;  
            
            }
        }else{
            var referenceLatitude   =   40.416944;
            var referenceLongitude  =   -3.703611;  
            }


var directionTextLatitude;
var directionTextLongitude;

var geocoder = null;
var map;

//Coords de la clínica.
var clinicLatitude;
var clinicLongitude;
var clinicTitle;

jQuery(document).ready(function (){
	//de primeras mostramos todas las clínicas que hay en España (en la versión).
	//le damos la opción de verlas en relación a su ubicación actual.


    //Dada la tasa de rebote... Creo que vamos a tratar de cargar esto sólo cuando se acceda a la página de Clínicas.
    if(jQuery('#singleClinicTemplate').length || jQuery('#clinicasIolUrl').length){
		gmapsClinicsLoader();
	}
		//updateGeocode();
	}
);




//Esta función carga toda la lógica necesaria para el funcionamiento de un GMaps geolocalizado.

function gmapsClinicsLoader(){

	//Este es el loader correspondiente a la página de selección de clínicas
	if(jQuery('#clinicasIolUrl').length){
		
			
    	//Si las variables globales de posición del usuario están definidas es que el usuario ha dado ya su geolocation.
    	if( !userLatitude && !userLongitude ){ //!userLatitude && !userLongitude
    	    //Esta función Ajax llama a la server function para coger todas las clínicas.
    	    //una vez las ha cogido, llama a otra función para meterlas en el mapa.
    	    console.log('El usuario no ha concretado su ubicación');
    		getAllClinicsCoordsAddMap();
    	}
		else{
			//
			console.log('el usuario ha concretado su ubicación');
			getWithinDistanceClinicsCoordsAddMap();
		}
    	
    	////Cargamos la función para el clickeo del botón y cambio en el select.
    	jQuery('#comboboxDistanceToClinic').combobox({
    		        select: function (event, ui) {
    					//alert('seleccion');
        				getWithinDistanceClinicsCoordsAddMap();
    		        	}
        });
        
	   jQuery('div.geoExplanation #geoButton').on('click',function(){
			getWithinDistanceClinicsCoordsAddMap(true);
			return false;
			});
			
		jQuery('#triggerUbicacion').on('click', function(){
			
			var stringLocation = jQuery('#direccion').val();
			if(stringLocation == ''){
				alert('Ha de introducir al menos algo relacionado con la dirección de su ubicación actual');
				return false;
			}
			getmaploc(stringLocation);
			return false; 		
		});
		
		jQuery('#showAllButton').on('click',function(){
			    getAllClinicsCoordsAddMap();
			    return false;
		});		
           
       }
       //Vamos a cargar ahora la lógica de single map.
       
       	if(jQuery('#singleClinicTemplate').length){
       	//el de setUser coords
       	jQuery('#mapSet #triggerUbicacion').on('click',function(){
       		var stringLocation = jQuery('#direccion').val();
       		//Creo que esta es la función que habrá que tocar.- CAMBIO
			getmaplocClinic(stringLocation);
			return false; 		
       	
       	});
       	//El cálculo de ruta.
       	jQuery('#routeToClinic').on('click', function(){
       		 calcRouteToClinic();
       		 return false;
       	});
       	
       	jQuery('#mapSet #geoButton').on('click',function(){
       		getUserCoordsClinic();
       	});
       	
       	
       	updateGeocode();
       	
       	
       	}
       

}


function updateGeocode(){

	//Vamos a intentar el reverseGeocoding.
	//var latlng = new google.maps.LatLng(40.416944,-3.703611);
	
	//En el pannel de info vamos a poner las que se están utilizando.
	var uLatitude;
	var uLongitude;
	
	if(!userLatitude || !userLongitude){
		uLatitude  =  referenceLatitude; 
		uLongitude =  referenceLongitude;
		}
		else{
			uLatitude  = userLatitude; 
		    uLongitude = userLongitude;
			}
	var latlng = new google.maps.LatLng(uLatitude,uLongitude);
	
	geocoder = new google.maps.Geocoder();
	geocoder.geocode({'latLng': latlng}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      
      if (results[1]) {
      
        /*map.setZoom(11);
        marker = new google.maps.Marker({
            position: latlng,
            map: map
        });
        infowindow.setContent(results[1].formatted_address);
      
        infowindow.open(map, marker);
      */
      //alert(results[1].formatted_address);
      jQuery('#userGeoInfoSpanValue').html(results[1].formatted_address);
      jQuery('#distanceValue').html(jQuery('#comboboxDistanceToClinic').val());
      
      } else {
      jQuery('#userGeoInfoSpanValue').html('Sin ubicación de referencia');
      }
    } else {
      jQuery('#userGeoInfoSpanValue').html('Geocoder failed due to: ' + status);
    }
  });

}




//Función que:
	//1. Contacta con el servidor y recibe todas las coordenadas de las clínicas.
	//2. Crea el mapa de GMaps con las clínicas recibidas del Servidor
function getAllClinicsCoordsAddMap(){
	//vamos a hacer una consulta ajax que nos devuelva un javascript object con las clínicas y sus coordenadas.
	//Una vez se reciba la respuesta, como es un proceso asíncrono, se pasará a cargar el mapa.
	//Si no se hace de esa manera se generan errores.
	
	//Si ya hay seleccionada una ubicación de referencia.
	var uLatitude;
	var uLongitude;
	
	if(!userLatitude || !userLongitude){
		uLatitude  =  referenceLatitude; 
		uLongitude =  referenceLongitude;
		}
		else{
			uLatitude  = userLatitude; 
		    uLongitude = userLongitude;
			}



			jQuery.ajax({
			    //dataType: "json",
			    url: the_ajax_script.ajaxurl,
			    data: 'action=getClinicsCoords',
			    success: function (response) {
			        var clinicas = jQuery.parseJSON(response);
			        //Devuelve el objeto Json con los marcadores correspondientes.
			        console.log("getAllClinicsCoordsAddMap ejecutándose");
			        console.log('Parece que no ha cogido nada:' + clinicas);
			        createMapAddMarquersToGeoOrNot(clinicas, uLatitude, uLongitude);
			    },
			    complete: function (response) {

			        jQuery('#divMapa').fadeTo('slow', 1);
			        updateGeocode();
			    },
			    beforeSend: function () {
			        //jQuery('#divMapa').fadeOut('slow');
			        jQuery('#divMapa').fadeTo('slow', 0.1);
			    }
			});
}

//Función necesaria para la generación de un mapa de clínicas en las que aparecen las que se encuentran dentro de una distancia dada.
//	- Primero sacamos los parámetros necesarios.
//	- Luego mandamos los parámetros a una función ajax para obtener el array de clínicas que cumplen esa condición.
//	- Esa función onSucces creará el mapa.

function getWithinDistanceClinicsCoordsAddMap(forzar){
	
	if(typeof(forzar)=='undefined')
	  {forzar= false}
	//Chequeamos el valor de las variables Latitud y Longitud

	var distanceToClinic;
	var qStringACW;
	
	if( jQuery('#comboboxDistanceToClinic').val()){
  		 distanceToClinic = jQuery('#comboboxDistanceToClinic').val();
		}else{
		 distanceToClinic = 1500;
		}
	
	//Si no estaban definidas las variables absolutas de ubicación del usuario (Procedemos a intentar cargarlas).
	
	//cuidado, esta función se dispara con el botón.AQUI¡¡¡¡
	
	if( (!userLatitude || !userLongitude || forzar) ){
			getUserCoordsGetClinicasWithinCreateMap(distanceToClinic);
			return;
		}
		else{
		  qStringACW = 'action=getClinicsCoordsWithinDistance&distanceToClinic=' + distanceToClinic +'&userLatitude='+getLatitude()+'&userLongitude='+getLongitude();
			//Con la  queristring ya creada.
			//alert(userLatitude);
			ajaxGetClinicasWithinCreateMap(qStringACW);	
			return;
		}
		return;
}


//Función que dados los parámetros del select y del usuario (si geolocalizado unos y si no, los por defecto).
//obtiene los datos de las clínicas y las añade a un mapa que también crea.

function ajaxGetClinicasWithinCreateMap(qStringACW){
    jQuery.ajax({
        //dataType: "json",
        url: the_ajax_script.ajaxurl,
        data: qStringACW,
        success: function (response) {

            var clinicas = jQuery.parseJSON(response);

            console.log('ajaxGetClinicasWithinCreateMap ejecutada');
            createMapAddMarquersToGeoOrNot(clinicas);
        },
        complete: function (response) {
            //	alert('Función completada'+ response);
            jQuery('#divMapa').fadeTo('slow', 1);

            updateGeocode();
        },
        beforeSend: function () {
            // Handle the beforeSend event
            //jQuery('#divMapa').html('<p>Loading :)</p>');//fadeOut('slow');
            jQuery('#divMapa').fadeTo('slow', 0.1);
        }
    });
}


//Función que crea el mapa esté geolocalizado el usuario o no.

function createMapAddMarquersToGeoOrNot(clinicas, cLatitude, cLongitude){

    firstLoad += 1;
    console.log('El firstLoad es ahora: ' + firstLoad);

    console.log("createMapAddMarquersToGeoOrNot ejecutada por primera vez");
	
	if(!cLatitude || !cLongitude){
		cLatitude = getLatitude();
		cLongitude = getLongitude();
	}
	
	
	var divMapa=document.getElementById('divMapa');
	//capa para mostrar las coordenadas (definida tambien en el HTML)
	var divCoordenadas=document.getElementById('divCoordenadas');
			
	//creamos un objeto (para Google Maps) con las coordenadas obtenidas por el API de HTML5
	var objCoordenadasRef = new google.maps.LatLng(cLatitude,cLongitude); //userLatitude,userLongitude
		
	//opciones del mapa
	var objOpciones={
				mapTypeId:		google.maps.MapTypeId.ROADMAP,	//mapa de carretera
				zoom: 			5,								//acercamiento
				mapTypeControl:	true,							//mostrar controles para cambiar el tipo de mapa
				center: 		objCoordenadasRef					//centramos el mapa en las coordenadas obtenidas
			};
			
	//dibujamos el mapa de la ubicacion (en la capa divMapa)
	var objMapa=new google.maps.Map(divMapa,objOpciones);
	var markers = new Array();
	var clinicaCoord = new Array();

	//Anotamos la referencia sea esta la ubicación del usuario o la por defecto.
				markersRef = new google.maps.Marker({
														title:		'Ubicación de Referencia',//clinica,	//agregamos un tooltip al punto
														position:	objCoordenadasRef,//objCoordenadas,//clinicaCoord,
														map:		objMapa,//este es el mapa que anteriormente creamos
														icon: 		"http://maps.google.com/mapfiles/ms/icons/orange-dot.png",
														zIndex: 	0
																					});
														/*{
        														path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
        														strokeColor: "red",
        														scale: 3
        														},*/
							
			
	//Vamos a intentar añadir los marcadores de manera dinámica.
	jQuery(".geoSelectedList").empty();
	var list = jQuery(".geoSelectedList").append('<ul></ul>').find('ul');
	
		for(var clinica in clinicas){
           //Sólo pondremos en el mapa clínicas que sean "hijos" => DEPENDERÁ DEL PAÍS.... igual en uno no hay grupos ni filiales... sino que son sólo indep.
           //Creamos por lo tanto un check por país.
		    var checkCountryHijos = false; 

            switch (site.Country)
            {
                //En el caso de españa sólo queremos que muestre los hijos
                case 'es_ES':
                    checkCountryHijos = true;
                    break;

                default:
                    checkCountryHijos = false;
               
                
            }

            //Aquí parece que es donde se mete la lista de clínicas.
            //Probamos sacando al parent.
            
            //Si es el la primera load sólo cargamos los padres en la lista.
            if (clinicas[clinica].parent == 0 && firstLoad <= 1) {//firstLoad < 3 && checkCountryHijos
                //Pero en la lista pondremos clínicas padres.
                console.log(clinicas[clinica].parent+'Metida');
                list.append('<li><a href="' + clinicas[clinica].link + '">' + clinica + '</a></li>');
               // continue;

            }
            if(checkCountryHijos){
            //Si ya ha habido load sólo ponemos los hijos
            if(clinicas[clinica].parent != 0 && firstLoad > 1){ //(firstLoad == 3|| firstLoad > 3) 
         
                console.log(clinicas[clinica].parent+'Metida'); 
                list.append('<li><a href="' + clinicas[clinica].link + '">' + clinica + '</a></li>');    
            }
            }else{
                                list.append('<li><a href="' + clinicas[clinica].link + '">' + clinica + '</a></li>');
               // continue;
            }

            			
				clinicaCoord[clinica] = new google.maps.LatLng(clinicas[clinica].latitud,clinicas[clinica].longitud);
			
				
				markers[clinica] = new google.maps.Marker({
							title:		clinica,//clinica,	//agregamos un tooltip al punto
							position:	clinicaCoord[clinica],//objCoordenadas,//clinicaCoord,
							map:		objMapa,//este es el mapa que anteriormente creamos
							icon: 		"http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
							zIndex: 	2
							});
	//Vamos a rellenar la ul list con las clínicas seleccionadas.				
				


            
				
							
			}

	


			return;	

}

		

//Función que nos defina las coordenadas del usuario y en caso de no permitirse geoLocation nos coloque las de la puerta del sol.
//Entre otras cosas hacemos esto porque cada vez que llamamos a navigator.geolocation hay un pop up.

function getUserCoordsGetClinicasWithinCreateMap(distanceToClinic){

        console.log("getUserCoordsGetClinicasWithinCreateMap ejecutada por primera vez");

	if( (!userLatitude || !userLongitude ) ||(userLatitude == directionTextLatitude) || (userLongitude == directionTextLongitude) ){
			//Para dar al usuario la idea de que está ocurriendo algo por debajo.
            jQuery('#divMapa').html(jQuery('#loadingGif').html());
			//intentamos obtener las coordenadas del usuario
			navigator.geolocation.getCurrentPosition(function(objPosicion){
			jQuery('fadeOut').fadeOut('slow');
			//Asignamos las coordenadas del usuario a las variables globales definidas:
			userLatitude = objPosicion.coords.latitude;
			userLongitude = objPosicion.coords.longitude;
			
			qStringACW = 'action=getClinicsCoordsWithinDistance&distanceToClinic=' + distanceToClinic + '&userLatitude='+getLatitude()+'&userLongitude='+getLongitude();
			//Con la  queristring ya creada.
			//alert(userLatitude);
			ajaxGetClinicasWithinCreateMap(qStringACW);
			
			 },
			 function(objError){
			//manejamos los errores devueltos por Geolocation API
			switch(objError.code){
				//no se pudo obtener la informacion de la ubicacion
				case objError.POSITION_UNAVAILABLE:
					divMapa.innerHTML='La información de su posición no está disponible.';
				break;
				//timeout al intentar obtener las coordenadas
				case objError.TIMEOUT:
					divMapa.innerHTML='Tiempo de espera agotado.';
				break;
				//el usuario no desea mostrar la ubicacion
				case objError.PERMISSION_DENIED:
					divMapa.innerHTML='Acceso denegado.';
				break;
				//errores desconocidos
				case objError.UNKNOWN_ERROR:
					divMapa.innerHTML='Error desconocido.';
				break;
			}
			//Si ha habido error o no ha sido posible detectar la ubicación apuntamos con las coordenadas a la puerta del sol.
			userLatitude =  40.416944;
			userLongitude = -3.703611;
			
		});		 
			return;
	}else{
		jQuery('fadeOut').fadeOut('slow');
		 qStringACW = 'action=getClinicsCoordsWithinDistance&distanceToClinic=' + distanceToClinic + '&userLatitude='+getLatitude()+'&userLongitude='+getLongitude();
			//Con la  queristring ya creada.
			//alert(userLatitude);
			ajaxGetClinicasWithinCreateMap(qStringACW);
	}
	return;
}

function getLatitude(){
	if( !userLatitude){
	  return referenceLatitude;
	}else{
		return userLatitude;
	}
}

function getLongitude(){

	if( !userLongitude){
	  return referenceLongitude;
	}else{
		return userLongitude;
	}
}


function createClinicMap(cLatitude,cLongitude, title,user){
	
	//alert('createClinicMap Triggered');

	//Cuando la clínica que se esté mostrando en el single clinic sea una padre, no se va a mostrar el botón de ruta.
	//y estará almacenado en un div un array con los valores de las coordenadas de las clínicas hijo y el título.

    

	if(typeof(user)=='undefined'){
		user=false;
		}
		else{
		user=true;}

	//Vaciamos el panel de direcciones por si estuviese relleno.
	jQuery('#directions-panel').html('');

	var divMapa=document.getElementById('divSingleClinicMapa');
				
	//Si no es padre hacemos lo de siempre;			
	if(!jQuery('#singleClinicCoordChilds').length){		
	//creamos un objeto (para Google Maps) con las coordenadas obtenidas por el API de HTML5
	var objCoordenadasRef  = new google.maps.LatLng(cLatitude,cLongitude); //userLatitude,userLongitude
	
	
	var objCoordenadasUser = new google.maps.LatLng(getLatitude(),getLongitude()); //userLatitude,userLongitude
	//opciones del mapa
	var objOpciones={
				mapTypeId:		google.maps.MapTypeId.ROADMAP,	//mapa de carretera
				zoom: 			5,								//acercamiento
				mapTypeControl:	true,							//mostrar controles para cambiar el tipo de mapa
				center: 		objCoordenadasRef					//centramos el mapa en las coordenadas obtenidas
			};
			
	//dibujamos el mapa de la ubicacion (en la capa divMapa)
	var objMapa=new google.maps.Map(divMapa,objOpciones);


	//Anotamos la referencia sea esta la ubicación del usuario o la por defecto.
				markersRef = new google.maps.Marker({
														title:		title,//clinica,	//agregamos un tooltip al punto
														position:	objCoordenadasRef,//objCoordenadas,//clinicaCoord,
														map:		objMapa,//este es el mapa que anteriormente creamos
														icon: 		"http://maps.google.com/mapfiles/ms/icons/orange-dot.png",
														zIndex: 	0
							});
	//Añadimos la posición del usuario.
				markersUser = new google.maps.Marker({
														title:		title,//clinica,	//agregamos un tooltip al punto
														position:	objCoordenadasUser,//objCoordenadas,//clinicaCoord,
														map:		objMapa,//este es el mapa que anteriormente creamos
														icon: 		"http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
														zIndex: 	0
							});							
	}else{
	
	//alert('Is parent');
	
	var jsonCoords = JSON.parse(jQuery('#singleClinicCoordChilds').html());
	//alert(jsonCoords);
		//creamos un objeto (para Google Maps) con las coordenadas obtenidas por el API de HTML5
	var objCoordenadasRef  = new google.maps.LatLng(cLatitude,cLongitude); //userLatitude,userLongitude
	
	
	var objCoordenadasUser = new google.maps.LatLng(getLatitude(),getLongitude()); //userLatitude,userLongitude
	//opciones del mapa
	var objOpciones={
				mapTypeId:		google.maps.MapTypeId.ROADMAP,	//mapa de carretera
				zoom: 			5,								//acercamiento
				mapTypeControl:	true,							//mostrar controles para cambiar el tipo de mapa
				center: 	    objCoordenadasUser //objCoordenadasRef					//centramos el mapa en las coordenadas del USER --> CAMBIO
			};
			
	//dibujamos el mapa de la ubicacion (en la capa divMapa)
	var objMapa=new google.maps.Map(divMapa,objOpciones);


	//Ahora añadiremos de manera dinámica los marcadores asociados a las clínicas hijo.
	
	for(var cObject in jsonCoords){
			//alert(jsonCoords[cObject]['lat']);
			var objCoordenadasRefClinic  = new google.maps.LatLng(jsonCoords[cObject]['lat'],jsonCoords[cObject]['long']);
			
			markersRef = new google.maps.Marker({
														title:		jsonCoords[cObject]['name'],//clinica,	//agregamos un tooltip al punto
														position:	objCoordenadasRefClinic,//objCoordenadas,//clinicaCoord,
														map:		objMapa,//este es el mapa que anteriormente creamos
														icon: 		"http://maps.google.com/mapfiles/ms/icons/orange-dot.png",
														zIndex: 	0
							});
			
			
	   }
	
	
	//Anotamos la referencia sea esta la ubicación del usuario o la por defecto.
				
	//Añadimos la posición del usuario.
				markersUser = new google.maps.Marker({
														title:		title,//clinica,	//agregamos un tooltip al punto
														position:	objCoordenadasUser,//objCoordenadas,//clinicaCoord,
														map:		objMapa,//este es el mapa que anteriormente creamos
														icon: 		"http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
														zIndex: 	0
							});
							
							

	
	
	}
	jQuery('#divSingleClinicMapa').fadeTo('slow','1');
	
	
   //ponemos una leyenda en el markersRef
   //objMapa.addOverlay(markersRef);
   //GEvent.addListener(markersRef, "click", function(){
   	//	markersRef.openInfoWindowHtml('this is it');
   //});
}



//vamos a ver el acceso a latlang por string.
//Esta función cargará la ubicación del usuario y las clínicas en distancia en nuestro mapa.


function getmaploc(stringLocation) {
    geocoder = new google.maps.Geocoder();
    var myOptions = {
        zoom : 8,
        mapTypeId : google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("divMapa"), myOptions);

    geocoder.geocode({
        address : stringLocation //'cairo'
    }, function(results, status) {
        console.log(results);
        if(status == google.maps.GeocoderStatus.OK) {
        //Aquí es donde hay que añadir el código que ha de aplicarse si el usuario introduce la ubicación mediante string.
        //Básicamente lo que sabemos es que tenemos en results[0].geometry.location la latitud y longitud.
            
            //Vamos pues a definir las variables user... con la ubicación seleccionada y a lanzar la función más global que podamos.
            
            userLatitude = results[0].geometry.location.lat();
            userLongitude = results[0].geometry.location.lng();            
            
            directionTextLatitude  = userLatitude;
            directionTextLongitude = userLongitude;
            
            
            getWithinDistanceClinicsCoordsAddMap();
                    
        } else {
            alert("Geocode was not successful for the following reason: " + status);
        }

    });
}

//Vamos a crear una función que directamente almacene las coordenadas de la clínica.
//Esta función se disparará en primer lugar.	
function setClinicCoordsTitle(tLatitude,tLongitude,tTitle){
	clinicLatitude  = tLatitude;
	clinicLongitude = tLongitude;
	clinicTitle = tTitle;
	//alert(tLatitude+' '+ tLongitude);
}

//Función para cargar en un mapa las rutas.
function calcRouteToClinic() {
  
  var objStart = new google.maps.LatLng(getLatitude(),getLongitude());//'madrid'; //userLatitude,userLongitude
  var objEnd   = new google.maps.LatLng(clinicLatitude, clinicLongitude); 
  
  directionsDisplay = new google.maps.DirectionsRenderer();
  
  //var chicago = new google.maps.LatLng(41.850033, -87.6500523);
  
  var mapOptions = {
    zoom:7,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    center: objStart //chicago
  }
  
  //Cambiamos las propiedades css del divSingleClinicMapa y directions-panel,
  
  /*jQuery('#divSingleClinicMapa').css('width','60%');
  jQuery('#directions-panel').css('width','38%');
  */
  map = new google.maps.Map(document.getElementById('divSingleClinicMapa'), mapOptions);
  directionsDisplay.setMap(map);
  directionsDisplay.setPanel(document.getElementById('directions-panel'));
  
  
  var objStart = new google.maps.LatLng(getLatitude(),getLongitude());//'madrid'; //userLatitude,userLongitude
  var objEnd   = new google.maps.LatLng(clinicLatitude, clinicLongitude); 
  									  //userLatitude,userLongitude
  
  var request = {
      origin:objStart,
      destination:objEnd,
      travelMode: google.maps.DirectionsTravelMode.DRIVING
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);

      
      
      
    }
  });
}




function getmaplocClinic(stringLocation) {

	//alert('getmaplocClinic disparada');
    geocoder = new google.maps.Geocoder();
    /*var myOptions = {
        zoom : 8,
        mapTypeId : google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("divSingleClinicMapa"), myOptions);
	*/
    geocoder.geocode({
        address : stringLocation //'cairo'
    }, function(results, status) {
        console.log(results);
        if(status == google.maps.GeocoderStatus.OK) {
        //Aquí es donde hay que añadir el código que ha de aplicarse si el usuario introduce la ubicación mediante string.
        //Básicamente lo que sabemos es que tenemos en results[0].geometry.location la latitud y longitud.
            
            //Vamos pues a definir las variables user... con la ubicación seleccionada y a lanzar la función más global que podamos.
            
            userLatitude = results[0].geometry.location.lat();
            userLongitude = results[0].geometry.location.lng();            
            
            directionTextLatitude  = userLatitude;
            directionTextLongitude = userLongitude;
            
             updateGeocode();
            
            
            createClinicMap(clinicLatitude,clinicLongitude, clinicTitle);
            
            //getWithinDistanceClinicsCoordsAddMap();
            //Función para crear mapa con userCoords y clinicCoords.
            
            
                    
        } else {
            alert("Geocode was not successful for the following reason: " + status);
        }

    });
}



function getUserCoordsClinic(){

	if( (!userLatitude || !userLongitude ) ||(userLatitude == directionTextLatitude) || (userLongitude == directionTextLongitude) ){
			//Para dar al usuario la idea de que está ocurriendo algo por debajo.
            jQuery('#divSingleClinicMapa').fadeTo('slow','0.1');//html(jQuery('#loadingGif').html());
			//intentamos obtener las coordenadas del usuario
			
			navigator.geolocation.getCurrentPosition(function(objPosicion){
			//jQuery('fadeOut').fadeOut('slow');
			//Asignamos las coordenadas del usuario a las variables globales definidas:
			userLatitude = objPosicion.coords.latitude;
			userLongitude = objPosicion.coords.longitude;
			
			updateGeocode();
			
			createClinicMap(clinicLatitude,clinicLongitude, clinicTitle);
						
			 },
			 function(objError){
			//manejamos los errores devueltos por Geolocation API
			switch(objError.code){
				//no se pudo obtener la informacion de la ubicacion
				case objError.POSITION_UNAVAILABLE:
					divMapa.innerHTML='La información de su posición no está disponible.';
				break;
				//timeout al intentar obtener las coordenadas
				case objError.TIMEOUT:
					divMapa.innerHTML='Tiempo de espera agotado.';
				break;
				//el usuario no desea mostrar la ubicacion
				case objError.PERMISSION_DENIED:
					divMapa.innerHTML='Acceso denegado.';
				break;
				//errores desconocidos
				case objError.UNKNOWN_ERROR:
					divMapa.innerHTML='Error desconocido.';
				break;
			}
			//Si ha habido error o no ha sido posible detectar la ubicación apuntamos con las coordenadas a la puerta del sol.
			userLatitude =  40.416944;
			userLongitude = -3.703611;
			
		});		 
			return;
	}else{
		jQuery('fadeOut').fadeOut('slow');
		 qStringACW = 'action=getClinicsCoordsWithinDistance&distanceToClinic=' + distanceToClinic + '&userLatitude='+getLatitude()+'&userLongitude='+getLongitude();
			//Con la  queristring ya creada.
			//alert(userLatitude);
			ajaxGetClinicasWithinCreateMap(qStringACW);
	}
	return;
}
