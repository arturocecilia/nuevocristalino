<?php

    $iol =_x('lente-intraocular','CustomPostType Name','iol');

    //$page = array_key_exists('page',$_GET) ? $_GET['page'] : 1;
           //Primero vemos como obtener las variables.
    $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
    //echo $page;

    $espacios = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    $responses = array();       
	        $responses['tQ1']  = get_query_var('tQ1')  ? get_query_var('tQ1'): 0;
	        $responses['tQ2']  = get_query_var('tQ2')  ? get_query_var('tQ2'): 0;
	        $responses['tQ3']  = get_query_var('tQ3')  ? get_query_var('tQ3'): 0;
	        $responses['tQ4']  = get_query_var('tQ4')  ? get_query_var('tQ4'): 0;
	        $responses['tQ5']  = get_query_var('tQ5')  ? get_query_var('tQ5'): 0;
	        $responses['tQ6']  = get_query_var('tQ6')  ? get_query_var('tQ6'): 0;
	        $responses['tQ7']  = get_query_var('tQ7')  ? get_query_var('tQ7'): 0;
	        $responses['tQ8']  = get_query_var('tQ8')  ? get_query_var('tQ8'): 0;
	        $responses['tQ9']  = get_query_var('tQ9')  ? get_query_var('tQ9'): 0;
	        $responses['tQ10'] = get_query_var('tQ10') ? get_query_var('tQ10'): 0;
                                                                                                                           
            //echo 'Valor detectado¡¡¡¡'.$tQ1.'<br />'; 

         //Empezamos con la lógica del filtrado -> En principio se plantea según las exclusiones.
         
         //Mono, Monovision, Multi tri, Multi bi, accomoda, esfericas, toricas, Filtro, LAL, Add-on, low add, high add						

         //$MultiTrifo = ;

         //Hacemos bucle para recorrer todas las preguntas.

         //Crearemos un array con las taxonomías afectadas por las respuestas del test.
         //Hay que controlar los valores puesto que estarán relacionados con los slugs.

         $taxoClasifT = array('monofocal','monovision','multifocal-trifocal_baja-adicion','multifocal-bifocal_alta-adicion','acomodativa','esferica','torica','luz-azul','ajustable-por-luz','add-on');
         /* ---------------------------
         
         (Monovision)(Monofocal)(multifocal-trifocal_baja-adicion)(multifocal-bifocal_alta-adicion)(acomodativa)(esferica)(torica)(luz-azul)(ajustable-por-luz)(add-on)
		     1           2                        3                               4                      5          6         7       8           9             10
          
         
          */                  							

         
         //Iremos recorriendo una por una las preguntas del test, asignando un 1 en cada categoría que quede excluida por la respuesta.
         //El resultado final es un array con el número de exclusiones correspondientes a cada categoría.
         //Además habrá un valor de exclusión que no dependerá de la pregunta sino de la clasificación anterior.
         $testClasiScore = array();
         $testClasiScore[] = array(0,0,0,0,0,0,0,0,0,0);
         $emptyAnswer = array(0,0,0,0,0,0,0,0,0,0);

         $qT1R1clasi  = array(0,0,0,0,0,0,0,0,0,0);
         $qT1R2clasi  = array(0,1,1,1,1,0,0,0,0,0);

         $qT2R1clasi = array(0,0,0,0,0,0,0,0,0,0);
         $qT2R2clasi = array(0,0,1,1,1,0,0,0,0,0);
         $qT2R3clasi = array(0,0,0,0,0,0,0,0,0,0);
         $qT2R4clasi = array(0,0,0,0,0,0,0,0,0,0);
         $qT2R5clasi = array(0,0,0,0,0,0,0,0,0,0);

         $qT3R1clasi = array(0,0,1,1,1,0,0,0,0,0);
         $qT3R2clasi = array(0,0,1,1,1,0,0,0,0,0);
         $qT3R3clasi = array(0,0,1,1,1,0,0,0,0,0);
         $qT3R4clasi = array(0,0,1,1,1,0,0,0,0,0);
         $qT3R5clasi = array(0,0,1,1,1,0,0,0,0,0);
         $qT3R6clasi = array(0,0,0,0,0,0,0,0,0,0);

         $qT4R1clasi = array(0,0,1,0,0,0,0,0,0,0);
         $qT4R2clasi = array(0,0,0,0,0,0,0,0,0,0);

         $qT5R1clasi = array(1,0,0,0,1,0,0,0,0,0);
         $qT5R2clasi = array(0,1,1,1,1,0,0,0,0,1);

         $qT6R1clasi = array(0,0,0,0,0,0,0,0,0,0);
         $qT6R2clasi = array(0,0,0,0,0,0,0,0,0,0);
         $qT6R3clasi = array(0,0,1,1,1,0,0,0,0,0);

         $qT7R1clasi = array(0,0,0,0,0,0,0,0,0,0);
         $qT7R2clasi = array(0,0,1,1,0,0,0,0,0,0);

         $qT8R1clasi = array(1,1,0,0,0,0,0,0,0,0);
         $qT8R2clasi = array(1,1,1,1,1,0,0,0,0,0);

         $qT9R1clasi = array(1,0,1,0,1,0,0,0,0,0);
         $qT9R2clasi = array(1,0,0,1,0,0,0,0,0,0);
         $qT9R3clasi = array(1,0,0,0,0,0,0,0,0,0);
         $qT9R4clasi = array(1,1,0,0,0,0,0,0,0,0);
         $qT9R5clasi = array(1,1,1,1,0,0,0,0,0,0);

         $qT10R1clasi = array(0,0,0,0,0,0,0,0,0,0);
         $qT10R2clasi = array(0,1,1,1,1,0,0,0,0,0);


      //   echo 'Respuestas al test';
      //   echo '<br />';

         foreach($responses as $clave => $valor){
             
             switch ($clave){
                 case 'tQ1':
                    switch($valor){
                        case 0:
                        $testClasiScore[] = $emptyAnswer;
                        break;
                        case 1:
                        $testClasiScore[] = $qT1R1clasi;
                        break;
                        case 2:
                        $testClasiScore[] = $qT1R2clasi;
                        break;
                     }
                     break;
                 case 'tQ2':
                   switch ($valor){
                       case 0:
                        $testClasiScore[] = $emptyAnswer;
                       break;
                       case 1:
                        $testClasiScore[] = $qT2R1clasi;
                       break;
                       case 2:
                        $testClasiScore[] = $qT2R2clasi;
                       break;
                       case 3:
                        $testClasiScore[] = $qT2R3clasi;
                       break;
                       case 4:
                        $testClasiScore[] = $qT2R4clasi;
                       break;
                       case 5:
                        $testClasiScore[] = $qT2R5clasi;
                       break;
                   }
                 break;
                  case 'tQ3':
                   switch($valor){
                       case 0:
                        $testClasiScore[] = $emptyAnswer;
                       break;
                       case 1:
                        $testClasiScore[] = $qT3R1clasi;
                       break;
                       case 2:
                        $testClasiScore[] = $qT3R2clasi;
                       break;
                       case 3:
                        $testClasiScore[] = $qT3R3clasi;
                       break;
                       case 4:
                        $testClasiScore[] = $qT3R4clasi;
                       break;
                       case 5:
                        $testClasiScore[] = $qT3R5clasi;
                       break;
                       case 6:
                        $testClasiScore[] = $qT3R6clasi;
                       break;
                   }
                  break;
                  case 'tQ4':
                   switch($valor){
                       case 0:
                        $testClasiScore[] = $emptyAnswer;
                       break;
                       case 1:
                        $testClasiScore[] = $qT4R1clasi;
                       break;
                       case 2:
                        $testClasiScore[] = $qT4R2clasi;
                       break;
                   }
                  break;
                  case 'tQ5':
                   switch($valor){
                       case 0:
                        $testClasiScore[] = $emptyAnswer;
                       break;
                       case 1:
                        $testClasiScore[] = $qT5R1clasi;
                       break;
                       case 2:
                        $testClasiScore[] = $qT5R2clasi;
                       break;
                   }
                  break;
                  case 'tQ6':
                   switch($valor){
                       case 0:
                        $testClasiScore[] = $emptyAnswer;
                       break;
                       case 1:
                        $testClasiScore[] = $qT6R1clasi;
                       break;
                       case 2:
                        $testClasiScore[] = $qT6R2clasi;
                       break;
                       case 3:
                        $testClasiScore[] = $qT6R3clasi;
                       break;
                   }
                  break;
                  case 'tQ7':
                   switch($valor){
                       case 0:
                        $testClasiScore[] = $emptyAnswer;
                       break;
                       case 1:
                        $testClasiScore[] = $qT7R1clasi;
                       break;
                       case 2:
                        $testClasiScore[] = $qT7R2clasi;
                       break;
                   }
                  break;
                  case 'tQ8':
                   switch($valor){
                       case 0:
                        $testClasiScore[] = $emptyAnswer;
                       break;
                       case 1:
                        $testClasiScore[] = $qT8R1clasi;
                       break;
                       case 2:
                        $testClasiScore[] = $qT8R2clasi;
                       break;
                   }
                  break;
                  case 'tQ9':
                   switch($valor){
                       case 0:
                        $testClasiScore[] = $emptyAnswer;
                       break;
                       case 1:
                        $testClasiScore[] = $qT9R1clasi;
                       break;
                       case 2:
                        $testClasiScore[] = $qT9R2clasi;
                       break;
                       case 3:
                        $testClasiScore[] = $qT9R3clasi;
                       break;
                       case 4:
                        $testClasiScore[] = $qT9R4clasi;
                       break;
                       case 5:
                        $testClasiScore[] = $qT9R5clasi;
                       break;
                   }
                  break;
                 case 'tQ10':
                   switch($valor){
                       case 0:
                        $testClasiScore[] = $emptyAnswer;
                       break;
                       case 1:
                        $testClasiScore[] = $qT10R1clasi;
                       break;
                       case 2:
                        $testClasiScore[] = $qT10R2clasi;
                       break;
                   }
                   break;

             }
             
         //    echo $espacios.' '.$clave.'&nbsp;&nbsp;=>&nbsp;&nbsp;'.$valor.'<br />';
         }
         

         //Cargamos los resultados de las preguntas en un array.
        
         $testConclusion = array();

         for($y=0;$y<10;$y++){
          $llave = $taxoClasifT[$y];
          $testConclusion[$llave] = indexSum($testClasiScore,$y);
          //$ExclusionMSG .= '&nbsp;'.$llave.' =>'.indexSum($testClasiScore,$y).'&nbsp;';
          //echo $llave.' =>'.indexSum($testClasiScore,$y).'<br />';
          //$testConclusion[] = indexSum($testClasiScore,0);
         }
         
     //      var_dump($testClasiScore);
        /*
         echo '<br />';
         echo 'Resultados del test: 0 Pasa; >0 no pasa.';
         echo '<br/>';
         echo '<br/>';

         echo $espacios.$taxoClasifT[0].'&nbsp;&nbsp;=>&nbsp;&nbsp;'.indexSum($testClasiScore,0).'<br />';
         echo $espacios.$taxoClasifT[1].'&nbsp;&nbsp;=>&nbsp;&nbsp;'.indexSum($testClasiScore,1).'<br />';
         echo $espacios.$taxoClasifT[2].'&nbsp;&nbsp;=>&nbsp;&nbsp;'.indexSum($testClasiScore,2).'<br />';
         echo $espacios.$taxoClasifT[3].'&nbsp;&nbsp;=>&nbsp;&nbsp;'.indexSum($testClasiScore,3).'<br />';
         echo $espacios.$taxoClasifT[4].'&nbsp;&nbsp;=>&nbsp;&nbsp;'.indexSum($testClasiScore,4).'<br />';          
         echo $espacios.$taxoClasifT[5].'&nbsp;&nbsp;=>&nbsp;&nbsp;'.indexSum($testClasiScore,5).'<br />';
         echo $espacios.$taxoClasifT[6].'&nbsp;&nbsp;=>&nbsp;&nbsp;'.indexSum($testClasiScore,6).'<br />';
         echo $espacios.$taxoClasifT[7].'&nbsp;&nbsp;=>&nbsp;&nbsp;'.indexSum($testClasiScore,7).'<br />';
         echo $espacios.$taxoClasifT[8].'&nbsp;&nbsp;=>&nbsp;&nbsp;'.indexSum($testClasiScore,8).'<br />';
         echo $espacios.$taxoClasifT[9].'&nbsp;&nbsp;=>&nbsp;&nbsp;'.indexSum($testClasiScore,9).'<br />';
         */

    //   echo '<br />';
    //   echo 'Exclusiones producidas en las preguntas:';
    //   echo '<br />';
    //   echo '<br />';

     //  foreach ($testClasiScore as $resp){
           
     //    foreach ($resp as $R){
     //        echo $R.$espacios.$espacios;
     //    }
     //    echo '<br />';
     //  }
       

         //Seleccionamos las llaves con valor > 0;

         $exclusiones = array();
         
         foreach($testConclusion as $key=>$value) {
             if($value > 0) {
                 //variable temporal para hacer pruebas
                $ExclusionMSG .= $key.'['.$value .']'.' ';
                $exclusiones[] = $key;
                }
             }
    //     echo '<br />Resultados del test: <br />';
    //     print_r($testConclusion);    
    //     echo '<br /><br />';

         //array('Monovision','Monofocal','MultiTri_LowAdd','MultiBi_HightAdd','Acomodat','Asferic','Toric','FiltrLU','LAL','AddOn');

         //Generamos el tax_query en función de los valores de $testConclusion.
         $rt_tax_query = array();
         
         if(in_array("monofocal", $exclusiones))
         {
             $rt_tax_query[]= array(
                                    'taxonomy' => _x('diseno-optica','taxo-name','iol'),
                                    'field' => 'slug',
                                    'terms' => array(_x('monofocal','taxo-monof-slug','iol')),
                                    'operator' => 'NOT IN'
             );
         }
         
         if(in_array('multifocal-trifocal_baja-adicion',$exclusiones)){
            $rt_tax_query[]= array(
                                    'taxonomy' => _x('diseno-optica','taxo-name','iol'),
                                    'field' => 'slug',
                                    'terms' => array(_x('multifocal-trifocal','taxo-value-slug','iol-scaffold')),
                                    'operator' => 'NOT IN'
             );
             
             $rt_tax_query[]= array(
                                    'taxonomy' => _x('adicion-cerca','taxo-name','iol'),
                                    'field' => 'slug',
                                    'terms' => array(0.5, 1, 1.5, 2, 2.5),
                                    'operator' => 'NOT IN'
             );
         }

         if(in_array('multifocal-bifocal_alta-adicion',$exclusiones)){
            $rt_tax_query[]= array(
                                    'taxonomy' => _x('diseno-optica','taxo-name','iol'),
                                    'field' => 'slug',
                                    'terms' => array(_x('multifocal-bifocal','taxo-value-slug','iol-scaffold')),
                                    'operator' => 'NOT IN'
             );
             
             $rt_tax_query[]= array(
                                    'taxonomy' => _x('adicion-cerca','taxo-name','iol'),
                                    'field' => 'slug',
                                    'terms' => array(2.5, 3, 3.5, 4, 4.5, 5),
                                    'operator' => 'NOT IN'
             );
         }

         if(in_array("acomodativa", $exclusiones))
         {
             $rt_tax_query[]= array(
                                    'taxonomy' => _x('diseno-optica','taxo-name','iol'),
                                    'field' => 'slug',
                                    'terms' => array(_x('acomodativa','taxo-value-slug','iol-scaffold')),
                                    'operator' => 'NOT IN'
             );
         }

         if(in_array("asferica", $exclusiones))
         {
             $rt_tax_query[]= array(
                                    'taxonomy' => _x('asfericidad','taxo-name','iol'),
                                    'field' => 'slug',
                                    'terms' => array(_x('asferica','taxo-value-slug','iol')),
                                    'operator' => 'NOT IN'
             );
         }
         
         if(in_array("torica", $exclusiones))
         {
             $rt_tax_query[]= array(
                                    'taxonomy' => _x('toricidad','taxo-name','iol'),
                                    'field' => 'slug',
                                    'terms' => array(_x('torica','taxo-value-slug','iol-scaffold')),
                                    'operator' => 'NOT IN'
             );
         }
         
         if(in_array("luz-azul", $exclusiones))
         {
             $rt_tax_query[]= array(
                                    'taxonomy' => _x('filtros','taxo-name','iol'),
                                    'field' => 'slug',
                                    'terms' => array(_x('luz-azul','taxo-value-slug','iol-scaffold')),
                                    'operator' => 'NOT IN'
             );
         }

         //Añadimos la condición de que no esté retirada del mercado.
             $rt_tax_query[] = array(
                               'taxonomy'=> _x('estatus-comercial','taxo-name','iol'),
                               'terms'   => array('retirada'), //$adiciones_filter,//array('alta'),
                               'field' => 'slug',
                               'operator' => 'NOT IN',
                                );   




         
         $args = array('post_type'=>$iol,
                      'post_status' => 'publish',
                      'posts_per_page' =>3,
                      'paged' => $page,
    //Vamos a ordenar siempre por orden de preferencia ascendente.
    				  'orderby'=>'meta_value_num',//nivelPrefLenteMD
    				  'meta_key'=>'nivelPrefLenteMD',
    				  'order'=>'DESC'
                      ); 
         /*
         echo 'Vector condiciones <br />';
         print_r($rt_tax_query);
         echo 'Fin vector condiciones <br />';
         */

         $args['tax_query'] = $rt_tax_query;

         //var_dump($args);

         $queryRTest = new WP_Query($args);
                    
    //Sacamos la query.

     //   echo $queryRTest->request;




     //Función para sumar un array multidimensional por índice.

     function indexSum($array, $index){
         
         $elemCount = count($array);
         $sum = 0;
         
         for($t=0;$t<$elemCount;$t++){
             $sum += $array[$t][$index];
         }
         return $sum;
     }





     /*
     
          //Loop.

         // The Loop
    /*if ( $queryRTest->have_posts() ) {
	    while ( $queryRTest->have_posts() ) {
	    	$queryRTest->the_post();
            $id= get_the_id();
		    echo '<li>' . get_the_title() . '=>'.get_the_term_list($id, _x('tipo','taxo-name','iol')).'</li>';
	    }
    } else {
    }*/
     
     
    
?>
