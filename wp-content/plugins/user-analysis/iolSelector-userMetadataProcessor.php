<?php

//iolSelector-userMetadataProcessor    => se usan los datos del usuario de acuerdo a la lógica del TEST (ANTIGUO).
//iolSelector-proUserMetadataProcessor => se usan los datos de usuario de acuerdo al NUEVO ALGORITMO ESCALABLE.

    $iol =_x('lente-intraocular','CustomPostType Name','iol');

	 $user_IOLSel = get_current_user_id();



    //$page = array_key_exists('page',$_GET) ? $_GET['page'] : 1;
           //Primero vemos como obtener las variables.
    $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
    //echo $page;

    $espacios = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    $responses = array(); 
    
    /*Tendremos que sustituir las respuestas del test por valores metadatas de usuario*/
          
	        $responses['tQ1']  =  0;
	        /*-- Conversor de pregunta test 1 a user metadata --*/
	        
	        $pre_expectImpNoGlassAftSx = get_user_meta($user_IOLSel, 'pre_expectImpNoGlassAftSx', true);
	        
	        switch($pre_expectImpNoGlassAftSx){
	        	
	        	case 'pre_expectImpNoGlassAftSx_VeryImp':
	        				$responses['tQ1'] = 1;
	        	break;

	        	case 'pre_expectImpNoGlassAftSx_NotImp':
	        				$responses['tQ1'] = 2;
	        	break;
	        	default:
  								$responses['tQ1'] = 0;
						break;        	
	        	}
	        
	        $responses['tQ2']  =  0;
	        
	        
	        $pre_gradSelect = get_user_meta($user_IOLSel, 'pre_gradSelect', true);
	        
	        switch($pre_gradSelect){
	        	
	        	case 'pre_gradSelect_More4Miop':
	        		$responses['tQ2'] = 1;
	        	break;

	        	case 'pre_gradSelect_05to4Miop':
	        	$responses['tQ2'] = 2;
	        	break;
	        	
	        	case 'pre_gradSelect_Bet05to3Hiper':
	        	$responses['tQ2'] = 3;
	        	break;
	        	
	        	case 'pre_gradSelect_More3Hiper':
	        	$responses['tQ2'] = 4;
	        	break;
	        	
	        	case 'pre_gradSelect_Unknown':
	        	$responses['tQ2'] = 5;
	        	break;
	        	
	        	default:
	        	$responses['tQ2'] = 0;
	        	break;


	        	
	        	}
	        
	        $responses['tQ3']  = 0;
	        
	        $pre_presenOculDisea =  get_user_meta($user_IOLSel, 'pre_presenOculDisea', TRUE);
	        
	        
	        switch($pre_presenOculDisea){
	        	
	        	case 'pre_presenOculDisea_Cat':
	        		$responses['tQ3'] = 6;
	        	break;
	        	
	        	case 'pre_presenOculDisea_Gla':
	        	$responses['tQ3'] = 1;
	        	break;
	        	
	        	case 'pre_presenOculDisea_DryEye':
	        	$responses['tQ3'] = 7;
	        	break;
	        	
	        	case 'pre_presenOculDisea_AMD':
	        	$responses['tQ3'] = 2;
	        	break;
	        	
	        	case 'pre_presenOculDisea_Uveitis':
	        	$responses['tQ3'] = 3;
	        	break;
	        	
	        	case 'pre_presenOculDisea_CorneDeg':
	        	$responses['tQ3'] = 4;
	        	break;

	        	case 'pre_presenOculDisea_Strabi':
	        	$responses['tQ3'] = 8;
	        	break;	        		        	       	

	        	case 'pre_presenOculDisea_VitrDetach':
	        	$responses['tQ3'] = 9;
	        	break;	   
	        	
	        	case 'pre_presenOculDisea_Several':
	        	$responses['tQ3'] = 10;
	        	break;	   

	        	case 'pre_presenOculDisea_None':
	        	$responses['tQ3'] = 6;
	        	break;	  

	        	case 'pre_presenOculDisea_Other':
	        	$responses['tQ3'] = 5;
	        	break;	   

						default:
						$responses['tQ3'] = 0;
						break;
	        	
	        	}
	        
	        
	        $responses['tQ4']  = 0;
	        
	        $pre_expectImpNoGlassFar =  get_user_meta($user_IOLSel, 'pre_expectImpNoGlassFar', TRUE);
	        
	        switch($pre_expectImpNoGlassFar){
	        	
	        	case 'pre_expectImpNoGlassFarSx_VeryImp':
	        			$responses['tQ4']  = 1;
	        	break;
	        	
	        	case 'pre_expectImpNoGlassFarSx_NotImp':
	        		$responses['tQ4']  = 2;
	        	break;
	        	
	        	default:
	        		$responses['tQ4']  = 0;
	        	break;
	        	
	        	}
	        
	         $responses['tQ5']  =  0;
	         
	         $pre_expectImpNoGlassNear = get_user_meta($user_IOLSel, 'pre_expectImpNoGlassNear',TRUE);
	         
					switch($pre_expectImpNoGlassNear){
						
						case 'pre_expectImpNoGlassNear_Imp':
							$responses['tQ5'] = 1;
						break;
						
						case 'pre_expectImpNoGlassNear_NotImp':
							$responses['tQ5'] = 2; 
						break;
						
					  default:
	        		$responses['tQ5']  = 0;
	        	break;
						
						}

						$responses['tQ6']  = 0;

					$pre_asumeGlassWhere = get_user_meta($user_IOLSel,'pre_asumeGlassWhere',TRUE);
					
					switch($pre_asumeGlassWhere){
						
						case 'pre_asumeGlassWhere_ReadingSmallLet':
							$responses['tQ6'] = 1;
						break;
						
						case 'pre_asumeGlassWhere_PC';
							$responses['tQ6'] = 2;						
						break;
						
						case 'pre_asumeGlassWhere_Driving':
							$responses['tQ6'] = 3;
						break;
						
						default:
							$responses['tQ6'] = 0;
						break;
						
						}

					
					$responses['tQ7']  = 0;

					$pre_asumeHalos = get_user_meta($user_IOLSel,'pre_asumeHalos',TRUE);


					switch($pre_asumeHalos){
						
						case 'pre_asumeHalos_Yes':
							$responses['tQ7'] = 1;
						break;
						
						case 'pre_asumeHalos_No':
							$responses['tQ7'] = 2;
						break;
						
						default:
							$responses['tQ7'] = 0;
						break;
						
						
						}

					$responses['tQ8']  = 0;
					
					$pre_asumeGlassNightVSmallRead = get_user_meta($user_IOLSel,'pre_asumeGlassNightVSmallRead',TRUE);
					
					switch($pre_asumeGlassNightVSmallRead){
						
						case 'pre_asumeGlassNightVSmallRead_Yes':
						$responses['tQ8'] =1;
						break;
						
						case 'pre_asumeGlassNightVSmallRead_No':
						$responses['tQ8'] =2;
						break;
						
						default:
						$responses['tQ8'] =0;
						break;
						
						}
						
						$responses['tQ9']  = 0;

						$pre_indeGlassPriority = get_user_meta($user_IOLSel,'pre_indeGlassPriority',TRUE);


						switch($pre_indeGlassPriority){
	
								case 'pre_indeGlassPriority_Near';
											$responses['tQ9']  = 1;
								break;

								case 'pre_indeGlassPriority_Interme';
											$responses['tQ9']  = 2;
								break;
	
								case 'pre_indeGlassPriority_TV';
											$responses['tQ9']  = 3;
								break;
	
								case 'pre_indeGlassPriority_Golf';
											$responses['tQ9']  = 4;
								break;
		
								case 'pre_indeGlassPriority_Ndriving';
											$responses['tQ9']  = 5;
								break;
	
								default:
											$responses['tQ9']  = 0;
								break;
						}


							$responses['tQ10']  = 0;

							$pre_personality  = get_user_meta($user_IOLSel,'pre_personality',TRUE);

						switch($pre_personality){
	
								case 'pre_personality_Open':
											$responses['tQ10']  = 1;	
								break;
	
								case 'pre_personality_Perfec':
											$responses['tQ10']  = 2;
								break;
	
								default:
											$responses['tQ10']  = 0;
								break;
						}

						//Añadimos la parte de toricidad
						$responses['tQ11']  = 0;

						$pre_toricity  = get_user_meta($user_IOLSel,'pre_gradAstig1dptSelect',TRUE);

						switch($pre_toricity){
	
								case 'pre_gradAstig1dptSelect_No':
											$responses['tQ11']  = 1;	
								break;
	
								case 'pre_gradAstig1dptSelect_Yes':
											$responses['tQ11']  = 2;
								break;
	
								default:
											$responses['tQ11']  = 0;
								break;
						}						














	        
	        
	        
					








	        
	        




	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	        
	       
	        
	        
	       /* $responses['tQ8']  = get_query_var('tQ8')  ? get_query_var('tQ8'): 0;
	        $responses['tQ9']  = get_query_var('tQ9')  ? get_query_var('tQ9'): 0;
	        $responses['tQ10'] = get_query_var('tQ10') ? get_query_var('tQ10'): 0;
           */                                                                                                                
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
         //$testClasiScore[] = array(0,0,0,0,0,0,0,0,0,0);
         $emptyAnswer = array(0,0,0,0,0,0,0,0,0,0);

         $qT1R1clasi  = array(0,0,0,0,0,0,0,0,0,0);
         $qT1R2clasi  = array(0,1,1,1,1,0,0,0,0,0);

         $qT2R1clasi = array(0,0,0,0,0,0,0,0,0,0);
         $qT2R2clasi = array(0,0,1,1,1,0,0,0,0,0);
         $qT2R3clasi = array(0,0,0,0,0,0,0,0,0,0);
         $qT2R4clasi = array(0,0,0,0,0,0,0,0,0,0);
         $qT2R5clasi = array(0,0,0,0,0,0,0,0,0,0);

         $qT3R1clasi  = array(0,0,1,1,1,0,0,0,0,0);
         $qT3R2clasi  = array(0,0,1,1,1,0,0,0,0,0);
         $qT3R3clasi  = array(0,0,1,1,1,0,0,0,0,0);
         $qT3R4clasi  = array(0,0,1,1,1,0,0,0,0,0);
         $qT3R5clasi  = array(0,0,1,1,1,0,0,0,0,0);
         $qT3R6clasi  = array(0,0,0,0,0,0,0,0,0,0);
         $qT3R7clasi  = array(0,0,1,1,1,0,0,0,0,0);//Dry eye
         $qT3R8clasi  = array(0,0,1,1,1,0,0,0,0,0);//Starbismus
         $qT3R9clasi  = array(0,0,1,1,1,0,0,0,0,0);//Vitreous Detach
         $qT3R10clasi = array(0,0,1,1,1,0,0,0,0,0);//Several
         																					

         $qT4R1clasi = array(0,0,1,0,0,0,0,0,0,0);
         $qT4R2clasi = array(0,0,0,0,0,0,0,0,0,0);

         $qT5R1clasi = array(1,0,0,0,1,0,0,0,0,0);//incoherencia si contesta a la 5 ya te cargas las acomodativas.
         $qT5R2clasi = array(0,1,1,1,1,0,0,0,0,1);

         $qT6R1clasi = array(0,0,0,0,0,0,0,0,0,0);
         $qT6R2clasi = array(0,0,0,0,0,0,0,0,0,0);
         $qT6R3clasi = array(0,0,1,1,1,0,0,0,0,0);//?

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

				//Añadimos la modificación tórica
				 $qT11R1clasi = array(0,0,0,0,0,0,1,0,0,0); //Estás excluyendo
         $qT11R2clasi = array(0,0,0,0,0,0,-1,0,0,0);//Estás restringiendo

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
                       /*Añadidas desde el preop profile*/
                       case 7:
                        $testClasiScore[] = $qT3R7clasi;
                       break;
                       case 8:
                        $testClasiScore[] = $qT3R8clasi;
                       break;
                       case 9:
                        $testClasiScore[] = $qT3R9clasi;
                       break;
                       case 10:
                        $testClasiScore[] = $qT3R10clasi;
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
                   
                 case 'tQ11':

                   switch($valor){
                       case 0:
                        $testClasiScore[] = $emptyAnswer;
                       break;
                       case 1:
                        $testClasiScore[] = $qT11R1clasi;
                       break;
                       case 2:
                        $testClasiScore[] = $qT11R2clasi;
                       break;
                   }
                   break;

             }
             
         
         }
         
         
         //Cargamos los resultados de las preguntas en un array.
        
        if(current_user_can('manage_options')){
         $testConclusion = array();

         
         for($y=0;$y<10;$y++){
          $llave = $taxoClasifT[$y];
          $testConclusion[$llave] = indexSum($testClasiScore,$y);
          //$ExclusionMSG .= '&nbsp;'.$llave.' =>'.indexSum($testClasiScore,$y).'&nbsp;';
          //echo $llave.' =>'.indexSum($testClasiScore,$y).'<br />';
          //$testConclusion[] = indexSum($testClasiScore,0);
         }
                 

       echo '<br />';
       echo 'Exclusiones producidas en las preguntas:';
       echo '<br />';
       echo '<br />';
				$count = 1;
				echo '<table style="font-size:11px;">';
				echo '<tr >';
				
				echo '<th>&nbsp;&nbsp;&nbsp;&nbsp;</th>';
				foreach($taxoClasifT as $tax){
					echo '<th>&nbsp;&nbsp;'.$tax.'&nbsp;&nbsp;</th>';
					}
				echo '</tr>';
       foreach ($testClasiScore as $resp){
           echo '<tr style="border:1px solid grey;"><td style="width:70px;">Preg. nº'.$count.':&nbsp;&nbsp;&nbsp;</td>';
           $count = $count +1;
    	     foreach ($resp as $R){
      		      echo '<td style="text-align:center; padding-top:5px; padding-bottom:5px;">'.$R.'</td>';
		        }
        
         echo '</tr>';
       }
       
       echo '<tr style="border:2px solid grey;">';
       echo  '<td>Resultado:</td>';
       foreach($testConclusion as $key=>$value){
       		echo '<td style="text-align:center; padding-top:5px; padding-bottom:5px;">&nbsp;&nbsp;'.$value.'&nbsp;&nbsp;</td>';
       	}
       echo '</tr>';
       echo '</table>';
       echo '<br /><br />';
     }
       

         //Seleccionamos las llaves con valor > 0;

         $exclusiones = array();
         
         foreach($testConclusion as $key=>$value) {
             if($value > 0) {
                 //variable temporal para hacer pruebas
                $ExclusionMSG .= $key.'['.$value .']'.' ';
                $exclusiones[] = $key;
                }
             if($value < 0){
             		$InclusionesMSG .= $key.'['.$value .']'.' ';
                $inclusiones[] = $key;
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
         
         
         if(in_array("torica", $inclusiones))
         {
             $rt_tax_query[]= array(
                                    'taxonomy' => _x('toricidad','taxo-name','iol'),
                                    'field' => 'slug',
                                    'terms' => array(_x('torica','taxo-value-slug','iol-scaffold')),
                                    'operator' => 'IN'
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
                      'posts_per_page' =>20,
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
