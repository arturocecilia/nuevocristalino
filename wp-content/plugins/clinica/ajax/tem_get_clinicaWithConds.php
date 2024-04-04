<?php 

include( ABSPATH . 'wp-content/plugins/clinica/filterClinicaEngine.php');


//var_dump($tax_query_clinica);
$args = array('post_type'=>_x('clinica','CustomPostType Name','clinica'),
              'posts_per_page' => -1,//-1, //problema que estaba ocurriendo, el par‡metro por defecto era 4.
              //Cog’a los 4 primeros y comprobaba que estaban dentro del rango.
              //Igual el que estaba dentro del rango era uno que ten’a un index muy elevado...
              'post_status' => 'publish',
              'orderby'     => 'meta_value_num',
              'meta_key'    =>  'nivelPrefClinicaMD',
              'order'       => 'DESC',
              'tax_query'	=> $tax_query_clinica
			);
              
$clinicas= array();
$clinicasCoordsQuery = new WP_Query( $args );


	 
     
     //var_dump($clinicasCoordsQuery);
     
     //$clinicasCoordsQuery->set('tax_query',$tax_query_clinica);


//Vamos generando el objeto javascript gracias al loop.
    if ( $clinicasCoordsQuery->have_posts() ) {
    
	    while ( $clinicasCoordsQuery->have_posts() ) {
	    	$clinicasCoordsQuery->the_post();
            //no sŽ por quŽ si no pones lo anterior hace un bucle infinito.
            $id = get_the_id();
            
		    //Hacemos el condicional de la distancia
		    if( 1 ){
                //echo 'Lo cumple';
		    $clinicas[ get_the_title($id)] = array('latitud'    =>  get_post_meta( $id, 'latitudD',  TRUE ), 
		    									  'longitud'    =>  get_post_meta( $id, 'longitudD', TRUE ),
		    									  'link'        =>  get_permalink( $id),
                                                  'parent'      =>  wp_get_post_parent_id($id),
                                                  'apMaps'		=>  get_post_meta($id, 'apMapsD', TRUE)
                                                  );
        	}
        
        }
        
        
    } 
		echo json_encode($clinicas);

?>