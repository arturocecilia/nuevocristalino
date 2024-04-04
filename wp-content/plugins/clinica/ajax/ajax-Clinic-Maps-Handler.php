<?php
function getClinicsCoords(){

//Tenemos que devolver un objeto javascript con las clínicas y sus coordenadas.

$args = array('post_type'=>_x('clinica','CustomPostType Name','clinica'),
              'post_status' => 'publish',
              'posts_per_page' => -1, //problema que estaba ocurriendo, el parámetro por defecto era 4.
              //Cogía los 4 primeros y comprobaba que estaban dentro del rango.
              //Igual el que estaba dentro del rango era uno que tenía un index muy elevado...
              'post_status' => 'publish',
              'orderby'     => 'meta_value_num',
              'meta_key'    =>  'nivelPrefClinicaMD',
              'order'       => 'DESC'
);

$clinicas= array();
$clinicasCoordsQuery = new WP_Query( $args );

if ( current_user_can('manage_options')){
    //var_dump($clinicasCoordsQuery->request);
}

//Vamos generando el objeto javascript gracias al loop.
    if ( $clinicasCoordsQuery->have_posts() ) {
    
	    while ( $clinicasCoordsQuery->have_posts() ) {
	    	$clinicasCoordsQuery->the_post();
            
            
            //Si es padre no la metemos aquí.
            
            $id = get_the_id();
                    if ( current_user_can('manage_options')){
              //  var_dump($id);
        }      
            
            $args_children_check = array(
            								'post_parent' => $id
            								);
            //if(!get_children($args_children_check)){
			// get_post_meta( $id, 'latitudD', true );//'esto tiene posts'.$id;
		    $clinicas[ get_the_title($id)] = array('latitud'  => get_post_meta( $id, 'latitudD', TRUE ), 
		    									   'longitud' => get_post_meta($id, 'longitudD', TRUE),
		    									   'link'     => get_permalink($id),
                                                   'parent'   =>  wp_get_post_parent_id($id),
                                                   'apMaps'	  =>  get_post_meta($id, 'apMapsD', TRUE)
		    									  );
		    									  
		    			//}						  
		    									  
         
        }

        if ( current_user_can('manage_options')){
               // var_dump($clinicas);
        }        

        	echo json_encode($clinicas);

        
    } else {
    	echo _x('No hay clínicas todavía',"Filter_template","clinica_display");
    }

die();
}

//Función que recibirá vía Get una latitud('userLatitude'), una longitud('userLongitude') y una distancia.
//Hará una query a la bbdd y filtrará sólo aquellas clínicas que estén dentro del radio y lo hará en el formato
//json normal
 
function getClinicsCoordsWithinDistance(){
	 

//Cargamos los valores que en teoría deberían venir en la querystring	

		if (array_key_exists('distanceToClinic',$_GET)){
   						$distanceToClinic = $_GET["distanceToClinic"];
						}
       		else{
           	 //Aquí ponemos el número de elementos mostrados por defecto.
             			$distanceToClinic = 1500;
         	}
		//userLatitude
		if (array_key_exists('userLatitude',$_GET)){
   						$userLatitude = $_GET["userLatitude"];
						}
       		else{
           	 //Aquí ponemos el número de elementos mostrados por defecto.
             			$userLatitude = 40.416944;
         	}
		//userLatitude
		if (array_key_exists('userLongitude',$_GET)){
   						$userLongitude = $_GET["userLongitude"];
						}
       		else{
           	 //Aquí ponemos el número de elementos mostrados por defecto.
             			$userLongitude = -3.703611;
         	}

$args = array('post_type'=>_x('clinica','CustomPostType Name','clinica'),
              'posts_per_page' => -1, //problema que estaba ocurriendo, el parámetro por defecto era 4.
              //Cogía los 4 primeros y comprobaba que estaban dentro del rango.
              //Igual el que estaba dentro del rango era uno que tenía un index muy elevado...
              'post_status' => 'publish',
              'orderby'     => 'meta_value_num',
              'meta_key'    =>  'nivelPrefClinicaMD',
              'order'       => 'DESC'
			);
              
$clinicas= array();
$clinicasCoordsQuery = new WP_Query( $args );


if ( current_user_can('manage_options')){
    //var_dump($clinicasCoordsQuery->request);
}
//Vamos generando el objeto javascript gracias al loop.
    if ( $clinicasCoordsQuery->have_posts() ) {
    
	    while ( $clinicasCoordsQuery->have_posts() ) {
	    	$clinicasCoordsQuery->the_post();
            //no sé por qué si no pones lo anterior hace un bucle infinito.
            $id = get_the_id();
            
            //var_dump(distance(get_post_meta( $id, 'latitudD', TRUE ), get_post_meta($id, 'longitudD', TRUE), $userLatitude, $userLongitude, "K"));

		    //Hacemos el condicional de la distancia
		    if(distance(get_post_meta( $id, 'latitudD', TRUE ), get_post_meta($id, 'longitudD', TRUE), $userLatitude, $userLongitude, "K")< $distanceToClinic ){
                //echo 'Lo cumple';
            $args_children_check = array(
            								'post_parent' => $id
            								);
            //if(!get_children($args_children_check)){  
		    $clinicas[ get_the_title($id)] = array('latitud'    => get_post_meta( $id, 'latitudD', TRUE ), 
		    									  'longitud'    => get_post_meta($id, 'longitudD', TRUE),
		    									  'link'        => get_permalink($id),
                                                  'parent'      =>  wp_get_post_parent_id($id),
                                                  'apMaps'		=>  get_post_meta($id, 'apMapsD', TRUE)
                                                  );
                                               //   }
        	}
        
        }
        
        if ( current_user_can('manage_options')){
            
            //var_dump($clinicas);
        }
        	//echo 'Distancia entre la primera y la segunda clínica en km';
        	//echo distance($clinicas['Visión10']['latitud'], $clinicas['Visión10']['longitud'], $clinicas['Vallmedic Visión']['latitud'], $clinicas['Vallmedic Visión']['longitud'], "K");
        	//echo 'Otra <br />';
			//echo distanceGeoPoints($clinicas['Visión10']['latitud'], $clinicas['Visión10']['longitud'], $clinicas['Vallmedic Visión']['latitud'], $clinicas['Vallmedic Visión']['longitud']);
			
			//echo 'Latitud: '.$clinicas['Vision10']=>'latitud'.'Longitud: '. $clinicas['Vision10']=>'longitud';
			//$clinicas['Clinica1'] = array('latitud' => 23 , 'longitud' => 43 );
			//$clinicas['Clinica2'] = array('latitud' => 24 , 'longitud' => 42 );
        	echo json_encode($clinicas);
        	//echo var_dump($clinicas);
        	
        	//foreach($clinicas as  $c){
        	//  var_dump($c);
        //	}
        
    } else {
    	echo _x('No hay clínicas dentro de la distancia seleccionada',"Filter_template","clinica_display");
    }

die();

	

}


//Función para medir las distancias entre dos puntos dadas sus coordenadas.
function distance($lat1, $lon1, $lat2, $lon2, $unit) 
{ 
   $theta = $lon1 - $lon2; 
   $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
   $dist = acos($dist); 
   $dist = rad2deg($dist); 
   $miles = $dist * 60 * 1.1515;
   $unit = strtoupper($unit);

   if ($unit == "K") 
   {
      return ($miles * 1.609344); 
   } 
   else 
   {
      return $miles;
   }
}

// Miles
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "m");

// Kilometres
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K");

function distanceGeoPoints ($lat1, $lng1, $lat2, $lng2) {

    $earthRadius = 3958.75;

    $dLat = deg2rad($lat2-$lat1);
    $dLng = deg2rad($lng2-$lng1);


    $a = sin($dLat/2) * sin($dLat/2) +
       cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
       sin($dLng/2) * sin($dLng/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $dist = $earthRadius * $c;

    // from miles
    $meterConversion = 1609;
    $geopointDistance = $dist * $meterConversion;

    return $geopointDistance;
}

// YOUR CODE HERE
//echo distanceGeoPoints(22,50,22.1,50.1);


function getLensClinics(){

	$iDs = json_decode($_GET["iDs"]);
		
    $tax_query_clinica = array();
	$ubicacion = array();
	/* -- Ubicacion Parent-- */
	if($_GET['uParent'] != 'ubicacion-parent-se'){
        
        $ubicacion[]= array('taxonomy'=>_x('ubicacion','taxo-value-slug','clinica-scaffold'),
            				    'field'=>'slug',
            				    'terms'=> array($_GET['uParent'])
            					);
        }
	
	/* -- Ubicación Child-- */
	if($_GET['uChild'] != 'ubicacion-child-se'){
        
        $ubicacion[]= array('taxonomy'=>_x('ubicacion','taxo-value-slug','clinica-scaffold'),
            				    'field'=>'slug',
            				    'terms'=> array($_GET['uChild'])
            					);     					
	}
	
	 foreach($ubicacion as $ubic){
               //echo $ubic.' como ubicación';
			 array_push($tax_query_clinica,$ubic);

              //var_dump($tax_query_clinica);
           }     
//   var_dump($tax_query_clinica);
	
	$argsClinics = array('post__in'=> $iDs,
						 'post_type'=> 'clinica',
						 'tax_query' => $tax_query_clinica,
						 'orderby' =>'meta_value_num',
						 'meta_key' => 'nivelPrefClinicaMD',
						 'order' => 'DESC',
                         'post_parent' => 0
	);
	
	
	$wpQClinics = new WP_Query($argsClinics);
	
	//Copiado literalmente del single-lente-intraocular.php
	echo '<ul class="sugClinicList">';
  if ( $wpQClinics->have_posts() ) {
    while ( $wpQClinics->have_posts() ) : $wpQClinics->the_post();
     echo '<li>';
     echo '<div class="sugClinic">';
      echo '<div class="sugClinicImage">'.get_the_post_thumbnail().'</div>'; /* get_the_ID(),'thumbnail' */
       echo '<div class="metaDataBlog">';
     echo '<span class="sugClinicTitle"><a href="'.get_permalink(get_the_ID()).'">'.get_the_title().'</a></span>';
     echo '<span>'.get_post_meta( get_the_ID(), 'direccionD',TRUE).'</span>';
     echo '<span>'.get_post_meta( get_the_ID(), 'telfContactoD',TRUE).' - '.get_post_meta( get_the_ID(), 'horarioD',TRUE).'</span>';
     echo '<span class="sugClinicMas"><a href="'.get_permalink(get_the_ID()).'">'._x('Ver información de la clínica','template','iol_display').'</a></span>';
     echo '</div>';
     echo '<div style="clear:both; height: 0px;">&nbsp;</div>';
     echo '</div>';
     echo '</li>';
                    
    $clinicIds[] = get_the_ID() ;
                    
    endwhile;
    }else {
           $clinicIds[] ='';
			echo '<li>';
            echo '<div class="sugClinicNoLens">';
			  echo '<span class="spanNoLens"> - No se han encontrado clínicas</span>';
			ECHO '</div>';
			echo '</li>';
			// no posts found
		}
		
     echo '<input hidden id="listIds" value="'.json_encode($clinicIds).'" />';
     echo '</ul>';
	
			
	die();

}


/*-- Añadimos la función del buscador de Clínicas --*/

function getClinicsWithConds(){

        if ( current_user_can('manage_options')){
            
            include('tem_get_clinicaWithConds.php');
        }


	die();
}



?>