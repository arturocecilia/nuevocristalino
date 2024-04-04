<?php

function getPostOpTestResults(){
    
    if(isset($_GET["question"]) && isset($_GET["surgeryIol"])){
      
       global $wpdb;

	   $question   = $_GET['question'];
	   $surgeryIol = $_GET['surgeryIol'];
	   
	   $queryR = 'select '.$question.' as question, count(*) as qt from result_iol_surgery where surgeryIol = "'.$surgeryIol.'" AND checked= "1" group by '.$question;
	   
       $results =  $wpdb->get_results( $queryR );
       
       //echo  $queryR; 
        
/*       foreach ( $results as $result ) 
        {
	        echo $result->satIol;
         }*/
        $tipoIolraw = array('me','ma','mt','mu','mut','aco','add','icl','oth','dk');
        $tipoIolprocessed = array(_x('Monofocal Esférica',"Template PostOp Test Result","iol_theme"), 
                                  _x('Monofocal Asférica.',"Template PostOp Test Result","iol_theme"),
                                  _x('Monofocal Tórica.',"Template PostOp Test Result","iol_theme"), 
                                  _x('Multifocal.',"Template PostOp Test Result","iol_theme"),
                                  _x('Mutifocal Tórica.',"Template PostOp Test Result","iol_theme"),
                                  _x('Acomodativa.',"Template PostOp Test Result","iol_theme"),
                                  _x('Add-On.',"Template PostOp Test Result","iol_theme"),
                                  _x('ICL.',"Template PostOp Test Result","iol_theme"),
                                  _x('Otro tipo.',"Template PostOp Test Result","iol_theme"),
                                  _x('No lo sabe.',"Template PostOp Test Result","iol_theme"));

        //Hay que preparar un array también para convertir el name de los inputs en el texto correspondiente.
        	
	
        //Hay que poner el string equivalente al name del input.
        if($question == 'satIol'){
        	 $qrRaw = array('satIol', 'satym','satyq','satys','satn', 'satnn' );
        	 $qrProcessed = array(_x('Nivel de Satisfacción tras la Operación','Template PostOp Test Result','iol_theme'),_x('Muy satisfecho','Template PostOp Test','iol_theme'), _x('Bastante satisfecho','Template PostOp Test','iol_theme'),_x('Satisfecho','Template PostOp Test','iol_theme'),_x('No Satisfecho','Template PostOp Test','iol_theme'), _x('Nada satisfecho','Template PostOp Test','iol_theme'));
             }
        if($question == 'dDriving'){
        
        //echo 'si es dDriving';
        	$qrRaw = array('dDriving','ldym','ldyq','ldys','ldnn');
        	$qrProcessed = array(_x('Dificultad para conducir de día (Sin gafas)','Template PostOp Test Result','iol_theme'),_x('Muchísima Dificultad','Template PostOp Test Result','iol_theme'),_x('Bastante Dificultad','Template PostOp Test Result','iol_theme'),_x('Alguna Dificultad','Template PostOp Test Result','iol_theme'),_x('Ninguna Dificultad','Template PostOp Test Result','iol_theme'));
         }
        if($question == 'nDriving'){
                //echo 'si es nDriving';
        	$qrRaw = array('nDriving','ndym','ndyq','ndys','ndnn');
        	$qrProcessed = array(_x('Dificultad para conducir de noche (Sin gafas)','Template PostOp Test Result','iol_theme'),_x('Muchísima Dificultad','Template PostOp Test Result','iol_theme'),_x('Bastante Dificultad','Template PostOp Test Result','iol_theme'),_x('Alguna Dificultad','Template PostOp Test Result','iol_theme'),_x('Ninguna Dificultad','Template PostOp Test Result','iol_theme'));
         } 
   
        if($question == 'iVision'){
        
        	$qrRaw = array('iVision','ivym','ivyq','ivys','ivnn');
        	$qrProcessed = array(_x('Dificultad para trabajar con el ordenador, usar el teléfono, ver el GPS del coche...(visión intermedia sin gafas)','Template PostOp Test Result','iol_theme'),_x('Muchísima Dificultad','Template PostOp Test Result','iol_theme'),_x('Bastante Dificultad','Template PostOp Test Result','iol_theme'),_x('Alguna Dificultad','Template PostOp Test Result','iol_theme'),_x('Ninguna Dificultad','Template PostOp Test Result','iol_theme'));
         }
   
    
        if($question == 'newspaper'){
        //echo 'si es newsaper';
        	$qrRaw = array('newspaper','newym','newyq','newys','newnn');
        	$qrProcessed = array(_x('Dificultad para leer el periódico','Template PostOp Test Result','iol_theme'),_x('Muchísima Dificultad','Template PostOp Test Result','iol_theme'),_x('Bastante Dificultad','Template PostOp Test Result','iol_theme'),_x('Alguna Dificultad','Template PostOp Test Result','iol_theme'),_x('Ninguna Dificultad','Template PostOp Test Result','iol_theme'));
         }
         
        if($question == 'prices'){
        //echo 'si son prices';
        	$qrRaw = array('prices','pricesym','pricesyq','pricesys','pricesnn');
        	$qrProcessed = array(_x('Dificultad para leer los precios de los productos en el ticket cuando está de compras','Template PostOp Test Result','iol_theme'),_x('Muchísima Dificultad','Template PostOp Test Result','iol_theme'),_x('Bastante Dificultad','Template PostOp Test Result','iol_theme'),_x('Alguna Dificultad','Template PostOp Test Result','iol_theme'),_x('Ninguna Dificultad','Template PostOp Test Result','iol_theme'));
         }         
         
        if($question == 'needle'){
        //echo 'si es needle';
        	$qrRaw = array('needle','needleym','needleyq','needleys','needlenn');
        	$qrProcessed = array(_x('Dificultad al enhebrar la aguja o realizar trabajos de similar precisión','Template PostOp Test Result','iol_theme'),_x('Muchísima Dificultad','Template PostOp Test Result','iol_theme'),_x('Bastante Dificultad','Template PostOp Test Result','iol_theme'),_x('Alguna Dificultad','Template PostOp Test Result','iol_theme'),_x('Ninguna Dificultad','Template PostOp Test Result','iol_theme'));
         }         

        if($question == 'dGlasses'){
        //echo 'si es needle';
        	$qrRaw = array('dGlasses','dga','dgs','dgn');
        	$qrProcessed = array(_x('Frecuencia con qué usa las gafas para ver de lejos','Template PostOp Test Result','iol_theme'),_x('Siempre','Template PostOp Test','iol_theme'),_x('En ocasiones','Template PostOp Test','iol_theme'),_x('Nunca','Template PostOp Test','iol_theme'));
         }
         
        if($question == 'nGlasses'){
        //echo 'si es needle';
        	$qrRaw = array('nGlasses','nga','ngs','ngn');
        	$qrProcessed = array(_x('Frecuencia con qué usa las gafas para leer','Template PostOp Test Result','iol_theme'),_x('Siempre','Template PostOp Test','iol_theme'),_x('En ocasiones','Template PostOp Test','iol_theme'),_x('Nunca','Template PostOp Test','iol_theme'));
         }          		
			
        if($question == 'currentVision'){
        //echo 'si es needle';
        	$qrRaw = array('currentVision','cvym','cvyq','cvys','cvnn');
        	$qrProcessed = array(_x('Dificultades para llevar a cabo el su estilo de vida sin gafas.','Template PostOp Test Result','iol_theme'),_x('Muchas','Template PostOp Test','iol_theme'),_x('Bastantes','Template PostOp Test','iol_theme'),_x('Alguna','Template PostOp Test','iol_theme'),_x('Ninguna','Template PostOp Test','iol_theme'));
         }
         			
		
			
			
			
					
 	                        
         	 
             $data = Array ();
             //Esta primera asignación son las columnas
             $data [] = Array (str_replace($qrRaw,$qrProcessed,$question), str_replace($tipoIolraw,$tipoIolprocessed,$surgeryIol) );

             foreach ( $results as $result ) 
                {
                    $frecuencia = $result->qt;
                    $respuesta = $result->question;
                    if($frecuencia == '' || $respuesta == ''  ){
                     
                      }
                    else{
					 	 $data[] = Array(str_replace($qrRaw,$qrProcessed,$result->question), $result->qt);
					     }
                 }

    header('content-type: application/json');
    echo json_encode($data);


    die();


}}
?>