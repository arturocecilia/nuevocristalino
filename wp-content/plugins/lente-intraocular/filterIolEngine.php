<?php
    //Este archivo te genera los arrays tax_query y meta_query que contienen la información de filtrado tanto de taxonomías como de metadatos dada una query string.
    
    $meta_query = array();
    $tax_query = array();



    //Creamos un array audit auxiliar que nos permita facilitar el logeo-> Ya está definida en el plugin como variable global.


    /*0 añadimos la taxonomía de tipo de lente intraocular si está en la query*/
    
    $tLensTN =_x('tipo-lente-intraocular','taxo-name','iol');

    if(array_key_exists($tLensTN,$_GET)){
        if($_GET[$tLensTN] != $tLensTN.'-se'){
        $args[$tLensTN] = $_GET[$tLensTN];
        $text = _x('Tipo de lente intraocular:','FilterIolEngine','iol_cpt_display');
        //echo  $text;
        $value = get_term_by( 'slug', $args[$tLensTN], $tLensTN)->name ;
        //echo 'Y el valor es:'.$value;
        $iolAudit[] = array('text'=>$text,'value'=>$value);
        }
       
    }
     else{
        $NotEspecified[] = array('mens'=>_x('El tipo de LIO: Pseudofáquica, fáquica...','FilterIolEngine','iol_cpt_display'));
        $UndefinedTaxonomyDataSelector[] = 'select[name="'.$tLensTN.'"]';
     }
     
    /*0 vamos a hacer que no salgan las que están retiradas siempre que se haga un filtrado*/
    $tax_RestricActive = array(
                               'taxonomy'=> _x('estatus-comercial','taxo-name','iol'),
                               'terms'   => array(_x('retirada','taxo-value-slug','iol-scaffold'),_x('en-estudio','taxo-value-slug','iol-scaffold')), //$adiciones_filter,//array('alta'),
                               'field' => 'slug',
                               'operator' => 'NOT IN',
                                );        
      if(current_user_can('manage_options')) {
         // echo _x('retirada','taxo-value-slug','iol-scaffold');
      }
        


        //Añadimos en nuestro array $tax_query la condición generada por las adiciones.
    array_push($tax_query,$tax_RestricActive);


    /* 1 diseOptic siempre va a estar definido puesto que viene de un select list-> en el filterForm hemos puesto el valor de la taxonomía así que va sincronizado */
    
    $dOptTN = _x('diseno-optica','taxo-name','iol');

    if(array_key_exists($dOptTN,$_GET)){
        if($_GET[$dOptTN] != $dOptTN.'-se'){
        $args[$dOptTN] = $_GET[$dOptTN];
        $text = _x('Diseño de óptica:','FilterIolEngine','iol_cpt_display');
        $value =  get_term_by('slug',$args[$dOptTN],$dOptTN)->name;
        $iolAudit[] = array('text'=>$text,'value'=>$value);
        }
    }else{
        $NotEspecified[] = array('mens'=>_x("El diseño de la óptica: monofocal, multifocal...",'FilterIolEngine','iol_cpt_display'));
        $UndefinedTaxonomyDataSelector[] = 'select[name="'.$dOptTN.'"]';
    }

    /* 1Bis diseOptic siempre va a estar definido puesto que viene de un select list-> en el filterForm hemos puesto el valor de la taxonomía así que va sincronizado */
    
    $asfericidadTN = _x('asfericidad','taxo-name','iol');

    if(array_key_exists($asfericidadTN,$_GET)){
        if($_GET[$asfericidadTN] != $asfericidadTN.'-se'){
        $args[$asfericidadTN] = $_GET[$asfericidadTN];
        $text = _x('Asfericidad:','Right Archive Lente Intraocular','iol_cpt_display');
        $value =  get_term_by('slug',$args[$asfericidadTN],$asfericidadTN)->name;
        $iolAudit[] = array('text'=>$text,'value'=>$value);
        }
    }else{
        $NotEspecified[] = array('mens'=>_x("Asfericidad de la lente: asférica, esférica.",'FilterIolEngine','iol_cpt_display'));
        $UndefinedTaxonomyDataSelector[] = 'select[name="'.$asfericidadTN.'"]';
    }




    /* 2 toricidad también porque viene de input type=radio */
    $toriTN = _x('toricidad','taxo-name','iol');

    if(array_key_exists($toriTN,$_GET)){
        if($_GET[$toriTN] != $toriTN.'-se')
        {
        // La clave de args¿¿¿¿¿
         $args[$toriTN] = $_GET[$toriTN];    
         //echo 'Los args de toricidad son:'.$args['toricidad'].'<br />';
         $text = _x("Toricidad:",'FilterIolEngine','iol_cpt_display');
         $value = get_term_by('slug',$args[$toriTN],$toriTN)->name;
         //echo 'El value name de toricidad es:'.$value.'<br />';
         $iolAudit[] = array('text'=>$text,'value'=>$value);
        }
    }else{
         $NotEspecified[] = array('mens'=>_x("La toricidad de la lente",'FilterIolEngine','iol_cpt_display'));
         $UndefinedTaxonomyDataSelector[] = 'input[name="'.$toriTN.'"]';
    }
    // 3 Respecto a filtros al ser un checkbox hay que hacer un proceso distinto puesto que no sabes a priori que valores te van a llegar
    //En el tema de los filtros no son dicotómicos sino aditivos. Esto es, no es que NO tengan el filtro sino que SÍ lo tienen.

    $filtrTN = _x('filtros','taxo-name','iol');
    $luTVS = _x('luz-ultravioleta','taxo-value-slug','iol-scaffold');
    $laTVS = _x('luz-azul','taxo-value-slug','iol-scaffold');

    if(!array_key_exists ($filtrTN.'-se',$_GET) or array_key_exists ($luTVS,$_GET) or array_key_exists ($laTVS,$_GET) )
    {
    	$filtros = array();
		$text = _x("Filtros incluidos:",'FilterIolEngine','iol_cpt_display');
        $values= array();
        
        if(array_key_exists ($luTVS,$_GET)){ 
            $filtros[]= array('taxonomy'=>$filtrTN,
            				  'field'=>'slug',
            				  'terms'=> array($_GET[$luTVS])
            					);
         
            $values[] = get_term_by('slug',$_GET[$luTVS],$filtrTN)->name;
        }
        if(array_key_exists ($laTVS,$_GET)){
        
            $filtros[]= array('taxonomy'=>$filtrTN,
            				  'field'=>'slug',
            				  'terms'=> array($_GET[$laTVS])
            					);
            $values [] = get_term_by('slug',$_GET[$laTVS],$filtrTN)->name;
            
        } 
        //Salvo que esté 'filtros-se' en la querystring siempres pasa por aquí luego hay que meter lo siguiente en un condicional.            			
        if(count($filtros)){	                      
           $valueText = join(', ',$values);
           $iolAudit[] = array('text'=>$text,'value'=>$valueText);
        
           foreach($filtros as $filtro){
			 array_push($tax_query,$filtro);
           }     
         }
        }else{
              $NotEspecified[] = array('mens'=>_x('Los filtros','FilterIolEngine','iol_cpt_display'));
              $UndefinedTaxonomyDataSelector[] = '#filtrosFilter input'; 
        }

    /*4 la Adición de Cerca- Como siempre será positiva podemos utilizar el - a módo de separador */
    if(array_key_exists ('adicion-cercaTV',$_GET)){
        //Primero sacamos los 2 límites y luego con meta_query hacemos la query.
        $pos = strpos($_GET['adicion-cercaTV'], ' ');
        $add_inf = substr($_GET['adicion-cercaTV'], 0, $pos);
        
        if(is_numeric($add_inf)){
                   // echo 'La adición inferior recogida:'.$add_inf.'Sí es numérica <br />';
                }
        $textInf = _x("Adición <b>mayor o igual</b> a:",'FilterIolEngine','iol_cpt_display');
        $valueInf = $add_inf;


        //$audit['Adición Inferior Recogida'] = $add_inf;

        $last_space = strrpos($_GET['adicion-cercaTV'], ' ');
        $pos_guion = strpos($_GET['adicion-cercaTV'], '-',strpos($_GET['adicion-cercaTV'],'diopt'));
        $add_sup_lenght = $last_space - $pos_guion - 1;
         
        $add_sup =substr($_GET['adicion-cercaTV'], $pos_guion +1 , $add_sup_lenght);
        
                if(is_numeric($add_sup)){
                  //  echo 'La adición superior recogida:'.$add_sup.'Sí es numérica <br />';
                }

        //$audit['Adición Superior Recogida'] = $add_sup;

        $textSup = _x('Adición <b>menor o igual</b> a:','FilterIolEngine','iol_cpt_display');
        $valueSup = $add_sup; 
        //Esta línea de a continuación igual deberíamos extraerala de la bbdd directamente.
        $adiciones = array(0.5, 1, 1.5, 2, 2.5, 3, 3.5, 3.75, 4, 4.5, 5);
        $adiciones_filter = array();
        
        foreach($adiciones as $adicion)
        {
            if(($adicion < $add_inf) or ($adicion > $add_sup)){
         //       echo 'La adición: |'.$adicion.'|es menor o igual que nuestro: |'.$add_inf.'|&nbsp;&nbsp;&nbsp; o mayor o igual que nuestro:|'.$add_sup.'| Por eso no la incluimos<br />';
        //        if(is_numeric($adicion)){
          //          echo 'La variable de comparación:'.$adicion.'Sí es numérica';
            //    }
                continue;
            }
            else{
                $adicion_mod= str_replace('.','-',strval($adicion));
                array_push($adiciones_filter,$adicion_mod);
            }
        }

        //$audit['Valores de Adición Recogidos por el Slider'] = $adiciones_filter;
        $iolAudit[] = array('text'=>$textInf,'value'=>$valueInf);
        $iolAudit[] = array('text'=>$textSup,'value'=>$valueSup);
        $tax_Add = array(
                         'taxonomy'=> _x('adicion-cerca','taxo-name','iol'),
                         'terms'   => $adiciones_filter,//array('alta'),
                         'field' => 'slug',
                         'operator' => 'IN',
                         );        
        
        //Añadimos en nuestro array $tax_query la condición generada por las adiciones.
        array_push($tax_query,$tax_Add);
        }
        else{
               $NotEspecified[] = array('mens'=>_x('Adición de cerca de la lente','FilterIolEngine','iol_cpt_display'));
               $UndefinedMetaDataSelector[] = '#amount-add';
        }

       /*5 Condición del fabricanteURL => Simpre va a estar definido  */

       $flTN = _x('fabricante-lente','taxo-name','iol');

     if(array_key_exists($flTN,$_GET)){
        if($_GET[$flTN] != $flTN.'-se'){
            $args[$flTN] = $_GET[$flTN];
			$text = _x('Fabricante:','Right Archive Lente Intraocular','iol_cpt_display');
			$value = $args[$flTN];
			$iolAudit[] = array('text'=>$text, 'value'=>$value); 
        }
     }else{
            $NotEspecified[]=array('mens'=>_x('El fabricante','FilterIolEngine','iol_cpt_display'));
            $UndefinedTaxonomyDataSelector[] = 'select[name="'.$flTN.'"]';
     }
/*-- PASAMOS AHORA A LOS FILTROS AVANZADOS  -- */
     
     /*6 Diámetro de Óptica*/
         if(array_key_exists ('diamOpticD',$_GET)){
        //Primero sacamos los 2 límites y luego con meta_query hacemos la query.
        $pos = strpos($_GET['diamOpticD'], ' ');
        $diamOpt_inf = substr($_GET['diamOpticD'], 0, $pos);
        $textInf = _x('Diámetro de óptica <b> igual o superior</b> a: ','FilterIolEngine','iol_cpt_display');
        $valueInf = $diamOpt_inf;
        
        $last_space = strrpos($_GET['diamOpticD'], ' ');
        $pos_guion = strpos($_GET['diamOpticD'], '-');
        $diamOpt_sup_lenght = $last_space - $pos_guion - 1;
         
        $diamOpt_sup =substr($_GET['diamOpticD'], $pos_guion +1 , $diamOpt_sup_lenght);

		$textSup = _x('Diametro de óptica <b>igual o inferior</b> a:','FilterIolEngine','iol_cpt_display');
		$valueSup = $diamOpt_sup;

        $iolAudit[] = array('text'=>$textInf,'value'=>$valueInf);
        $iolAudit[] = array('text'=>$textSup,'value'=>$valueSup);

        /*Vamos ahora con el meta_query*/
        $meta_diamOpt = array(
                              'key'=>'diamOpticD',
                              'value'=> array($diamOpt_inf, $diamOpt_sup),//floatval($diamOpt_sup),//array((float) $diamOpt_inf, (float)$diamOpt_sup),
                              'compare'=> 'BETWEEN' ,
                              'type'=>'DECIMAL'                              
                                );
         array_push($meta_query,$meta_diamOpt);
        }else{
             $NotEspecified[] = array('mens'=>_x('Diámetro de la óptica','FilterIolEngine','iol_cpt_display'));
             $UndefinedMetaDataSelector[] = '#amount-diamOptic';
        }


    /*7 Diámetro Total*/
         if(array_key_exists ('diamTotD',$_GET)){//Primero sacamos los 2 límites y luego con meta_query hacemos la query.
        $pos = strpos($_GET['diamTotD'], ' ');
        $diamTot_inf = substr($_GET['diamTotD'], 0, $pos);
       
        $textInf = _x('Diámetro total <b>igual o superior</b> a:','FilterIolEngine','iol_cpt_display');
        $valueInf = $diamTot_inf;
       
        $last_space = strrpos($_GET['diamTotD'], ' ');
        $pos_guion = strpos($_GET['diamTotD'], '-');
        $diamTot_sup_lenght = $last_space - $pos_guion - 1;
         
        $diamTot_sup =substr($_GET['diamTotD'], $pos_guion +2 , $diamTot_sup_lenght-1);

		$textSup = _x('Diámetro total <b>igual o inferior</b> a:','FilterIolEngine','iol_cpt_display');
		$valueSup = $diamTot_sup;
		
        //Primero sacamos los 2 límites y luego con meta_query hacemos la query.

        $iolAudit[] = array('text'=>$textInf,'value'=>$valueInf);
        $iolAudit[] = array('text'=>$textSup,'value'=>$valueSup);

        
        $meta_diamTot = array(
                               'key'=> 'diamTotD',
                               'value'=> array($diamTot_inf,$diamTot_sup),
                               'compare'=> 'BETWEEN',
                               'type'=>'DECIMAL');

        array_push($meta_query,$meta_diamTot);
        }else{
             $NotEspecified[] = array('mens'=>_x('Diámetro total','FilterIolEngine','iol_cpt_display'));
             $UndefinedMetaDataSelector[] = '#amount-diamTot';
        }
     /*Meto aquí el de tamaño de Incisión*/

         if(array_key_exists ('tamaInciD',$_GET)){//Primero sacamos los 2 límites y luego con meta_query hacemos la query.
        $pos = strpos($_GET['tamaInciD'], ' ');
        $tamInci_inf = substr($_GET['tamaInciD'], 0, $pos);

		$textInf = _x('Tamaño de Incisión <b>igual o superior</b> a:','FilterIolEngine','iol_cpt_display');
        $valueInf = $tamInci_inf;        
        
        //echo 'El tamaño de incisión inferior recogido es: |'.$tamInci_inf.'|<br />';
        $last_space = strrpos($_GET['tamaInciD'], ' ');
        $pos_guion = strpos($_GET['tamaInciD'], '-');
        $tamInci_sup_lenght = $last_space - $pos_guion - 1;
         
        $tamInci_sup =substr($_GET['tamaInciD'], $pos_guion +2 , $tamInci_sup_lenght-1);
        //echo 'El tamaño de incisión inferior recogido es: |'.$tamInci_sup.'|<br />';

		$textSup = _x('Tamaño de Incisión <b>igual o inferior</b> a:','FilterIolEngine','iol_cpt_display');
		$valueSup = $tamInci_sup;

        $iolAudit[] = array('text'=>$textInf,'value'=>$valueInf);
        $iolAudit[] = array('text'=>$textSup,'value'=>$valueSup);

        //Primero sacamos los 2 límites y luego con meta_query hacemos la query.
        
        $meta_tamInci = array(
                               'key'=> 'tamaInciD',
                               'value'=> array($tamInci_inf,$tamInci_sup),
                               'compare'=> 'BETWEEN',
                               'type'=>'DECIMAL');


        array_push($meta_query,$meta_tamInci);
        }else{
              $NotEspecified[] =array('mens'=>_x('Tamaño de la incisión','FilterIolEngine','iol_cpt_display'));
              $UndefinedMetaDataSelector[] = '#amount-tamaInci';
        }


     /*8 Bordes Cuadrados -> Input radios => habrá que hacer ver como organizamos las restricciones de taxo terms*/
     /*En bordes cuadrados o la quieres con bordes cuadrados en cuyo caso lo señalas o la quieres sín y lo señalas o bien te es indiferente,
     en cuyo caso no lo señalas.*/

     $seTN = _x('bordes-cuadrados','taxo-name','iol');

     if(array_key_exists($seTN,$_GET)){
         if($_GET[$seTN] != $seTN.'-se')
         {
         // La clave de args¿¿¿¿¿
          $args[$seTN] = $_GET[$seTN];    
		  $text = _x('Bordes Cuadrados:','FilterIolEngine','iol_cpt_display');
		  //get_term_by('slug',$args['diseno-optica'],'diseno-optica')->name;
		  $value = get_term_by('slug',$args[$seTN],$seTN)->name;
		  
          $iolAudit[] = array('text'=>$text,'value'=>$value);
		  
         }
     }else{
           $NotEspecified[] = array('mens'=>_x('Bordes','FilterIolEngine','iol_cpt_display')); 
           $UndefinedTaxonomyDataSelector[] = 'input[name="'.$seTN.'"]';
     }
     /*9 Asfericidad => Slider como los diámetros*/
      if(array_key_exists ('asfericiD',$_GET)){
        //Primero sacamos los 2 límites y luego con meta_query hacemos la query.
        $pos = strpos($_GET['asfericiD'], ' ');
        $asferic_inf = substr($_GET['asfericiD'], 0, $pos);
        //echo '<p>Asferic Inferior: '.$asferic_inf.'a</p>';
		$textInf = _x('Asfericidad igual o superior a:','FilterIolEngine','iol_cpt_display');
		$valueInf = $asferic_inf;
        
        $last_space = strrpos($_GET['asfericiD'], ' ');
        //Estamos teniendo problemas con los Negativos :) porque luego son detectados como guion

        $pos_guion = strpos($_GET['asfericiD'], '-',strpos($_GET['asfericiD'],'um'));
        $asferic_sup_lenght = $last_space - $pos_guion - 2;
         
        $asferic_sup =substr($_GET['asfericiD'], $pos_guion +2 , $asferic_sup_lenght);
     
        $textSup = _x('Asfericidad igual o inferior a:','FilterIolEngine','iol_cpt_display');
        $valueSup = $asferic_sup;
        
        $iolAudit[] = array('text'=>$textInf,'value'=>$valueInf);
        $iolAudit[] = array('text'=>$textSup,'value'=>$valueSup);
        
        $meta_asferic = array(
                              'key'=>'asfericiD',
                              'value'=> array($asferic_inf,$asferic_sup),//floatval($diamOpt_sup),//array((float) $diamOpt_inf, (float)$diamOpt_sup),
                              'compare'=> 'BETWEEN' ,
                              'type'=>'DECIMAL'
                              );
        array_push($meta_query,$meta_asferic);
        }else{
              $NotEspecified[] =array('mens'=>_x('Valor numérico de Asfericidad','FilterIolEngine','iol_cpt_display'));
              $UndefinedMetaDataSelector[] = '#amount-asferic';
        }
        
    /*10 Principio Óptico */
   
     $poTN = _x('principio-optico','taxo-name','iol');
     $refTVN = _x('refractiva','taxo-value-slug','iol-scaffold');
     $difTVN = _x('difractiva','taxo-value-slug','iol-scaffold');
     $mixTVN = _x('mixta','taxo-value-mixta','iol-scaffold');

    if(!array_key_exists ($poTN.'-se',$_GET))
    {
      $ppOptico = array();
      $text = _x('Principios ópticos de lente incluidos:','FilterIolEngine','iol_cpt_display');
      //Una sola tax query con los slugs incluidos para generar el IN.
      $slugs = array();
      //Los valores incluidos para el iolAudit.
      $value = array();
    //Hay que contemplar la posibilidad de que se metan varios valores.
        if(array_key_exists ($refTVN,$_GET)){ 
            //Aquí va a haber que matchear el valor con el incluido en refractiva en el SetUp.
            //$args['principio-optico'] =  $_GET['refractiva'];
            //$value = get_term_by('slug',$args['bordes-cuadrados'],'diseno-optica')->name;

            $slugs[] =  $_GET[$refTVN];
            
            //$_GET['refractiva'];
            $value[]=  get_term_by('slug',$_GET[$refTVN],$poTN)->name;
            
        }
        if(array_key_exists ($difTVN,$_GET)){
            //$args['principio-optico'] =  $_GET['difractiva'];

            $slugs[] = $_GET[$difTVN]; 				   
        	$value[] =  get_term_by('slug',$_GET[$difTVN],$poTN)->name;
        }
        if(array_key_exists ($mixTVN,$_GET)){
              // $args['principio-optico'] =  $_GET['mixta'];
            $slugs[] = $_GET[$mixTVN];             
        	$value[]=  get_term_by('slug',$_GET[$mixTVN],$poTN)->name;
        }
        
        if(count($slugs)){
        $valueText = join(', ',$value);
        $iolAudit[] = array('text'=>$text, 'value'=>$valueText);
        
        $tax_Ppoptico = array(
                         'taxonomy'=> $poTN,
                         'terms'   => $slugs,
                         'field' => 'slug',
                         'operator' => 'IN',
                         );                                 
        //Añadimos en nuestro array $tax_query la condición generada por los principios ópticos.

        array_push($tax_query,$tax_Ppoptico);
        }
    }else{
          $NotEspecified[] = array('mens'=>_x('Principio Óptico','FilterIolEngine','iol_cpt_display'));
          $UndefinedTaxonomyDataSelector[] = '#ppOpticoFilter input';
    }
    
    
    
    if(array_key_exists('nivel-pref-lente',$_GET)  || ((isset($_COOKIE['ncpatient']))  && ($_COOKIE['ncpatient'] == 'ncpatient') ) ){
        
            //$query->set('nivel-pref-lente', 5);            
            
     $tax_nPref = array(
                         'taxonomy'=> 'nivel-pref-lente',
                         'terms'   => 5,
                         'field' => 'slug',
                         'operator' => 'IN',
                         );                                 
        //Añadimos en nuestro array $tax_query la condición generada por los principios ópticos.

        array_push($tax_query,$tax_nPref);
            
        }
    
    
    
    /* 11 Diseño de Lente */

    $dlenTN = _x('diseno','taxo-name','iol'); 

    if(array_key_exists($dlenTN,$_GET)){
        if($_GET[$dlenTN] != $dlenTN.'-se'){ //_x( ,'info-mens','iol_display')
           $args[$dlenTN] = $_GET[$dlenTN];
		   $text = _x('Diseño de Lente:','Right Archive Lente Intraocular','iol_cpt_display');
		   $value = $args[$dlenTN];
		   
           $iolAudit[] = array('text'=>$text,'value'=>$value);
        }
      }
      else{
           $NotEspecified[] = array('mens'=>_x('Diseño de la lente: Monobloque, 3-piezas...','FilterIolEngine','iol_cpt_display'));
           $UndefinedTaxonomyDataSelector[] = 'select[name="'.$dlenTN.'-lente"]';
      }
      
      
           
     /* 12 Material de la Lente */
     $msTN = _x('material','taxo-name','iol');

    if(array_key_exists($msTN,$_GET)){
        if($_GET[$msTN] != $msTN.'-se'){
            $args[$msTN] = $_GET[$msTN];
            $text = _x('Material:','FilterIolEngine','iol_cpt_display');
            $value = $_GET[$msTN];
            
            $iolAudit[] = array('text'=>$text, 'value'=>$value);
            
        }
      }else{
            $NotEspecified[] = array('mens'=>_x('El Material','FilterIolEngine','iol_cpt_display'));
            $UndefinedTaxonomyDataSelector[] = 'select[name="'.$msTN.'"]';
      }
    /* 13 Inyector */
    $injTN = _x('inyector','taxo-name','iol');

     if(array_key_exists($injTN,$_GET)){
         if($_GET[$injTN] != $injTN.'-se')
         {
          $args[$injTN] = $_GET[$injTN];    
          $text=_x('Inyector:','info-mens','iol_display');
          $value =$args[$injTN];
          
          $iolAudit[] = array('text'=>$text, 'value'=>$value);
         }
     }
     else{
          $NotEspecified[] = array('mens'=>_x('Uso de Inyector','FilterIolEngine','iol_cpt_display'));
          $UndefinedTaxonomyDataSelector[] = 'input[name="'.$injTN.'"]';
     }
     /* 14 Precargada */
    $preLTN = _x('precargada','taxo-name','iol');

    if(array_key_exists($preLTN,$_GET)){
        if($_GET[$preLTN] != $preLTN.'-se')
         {
          $args[$preLTN] = $_GET[$preLTN];    
          $text =_x('Precargada:','info-mens','iol_display');
          $value =$args[$preLTN];
           
          $iolAudit[] = array('text'=>$text, 'value'=>$value);
         }
         
     }else{
          $NotEspecified[] = array('mens'=>_x('Si es precargada','FilterIolEngine','iol_cpt_display'));
          $UndefinedTaxonomyDataSelector[] = 'input[name="'.$preLTN.'"]';
     }
     /* 15 Diseño Hápticos */
     $dHaptTN = _x('diseno-hapticos','taxo-name','iol');

      if(array_key_exists($dHaptTN,$_GET)){
        if($_GET[$dHaptTN] != $dHaptTN.'-se'){
            $args[$dHaptTN] = $_GET[$dHaptTN];
            $text = _x('Diseño de Hápticos:','FilterIolEngine','iol_cpt_display');
            $value = $args[$dHaptTN];
            
            
            $iolAudit[] = array('text'=>$text, 'value'=>$value);
        
        }
      }else{
           $NotEspecified[] = array('mens'=>_x('Diseño de los hápticos','FilterIolEngine','iol_cpt_display'));
           $UndefinedTaxonomyDataSelector[] = 'input[name="'.$dHaptTN.'"]';
      }
      // RANGOS DE DIOPTRÍAS 
      //1º Las Esféricas.
     if(array_key_exists ('dioptEsfD',$_GET)){

        
        //Primero sacamos los 2 límites y luego con meta_query hacemos la query.
        $pos = strpos($_GET['dioptEsfD'], ' ');
        $dioptEsf_inf = substr($_GET['dioptEsfD'], 0, $pos);
        
        $textInf = _x('Dioptrías esféricas disponibles inferiores o iguales a:','FilterIolEngine','iol_cpt_display');
        $valueInf = $dioptEsf_inf;  
          
      
        //echo 'El límite inferior es:'.$dioptEsf_inf.'<br />';
        $last_space = strrpos($_GET['dioptEsfD'], ' ');
        $pos_guion = strpos($_GET['dioptEsfD'], '-',strpos($_GET['dioptEsfD'],'diop'));
        $dioptEsf_sup_lenght = $last_space - $pos_guion - 2;
         
        $dioptEsf_sup =substr($_GET['dioptEsfD'], $pos_guion +2 , $dioptEsf_sup_lenght);

        $textSup = _x('Dioptrías esféricas disponibles superiores o iguales a:','FilterIolEngine','iol_cpt_display');
        $valueSup = $dioptEsf_sup;  

		$iolAudit[] = array('text'=>$textInf,'value'=>$valueInf);
		$iolAudit[] = array('text'=>$textSup,'value'=>$valueSup);
		
		
        //Vamos ahora con el meta_query hay que tener en cuenta que ésta no es como el resto. 
        
        $meta_dioptEsfDesde = array(
                              'key'=>'esfDesdeD',
                              'value'=> $dioptEsf_inf,
                              'compare'=> '<=' ,//>= El valor desde de la lente ha de ser menor o igual que el señalado en el slider (TIENE QUE CUBRIR EL DESDE SEÑALADO, para lo que ha de ser inferior)
                              'type'=>'DECIMAL'                              
                                );

        $meta_dioptEsfHasta = array(
                              'key'=>'esfHastaD',
                              'value'=> $dioptEsf_sup,
                              'compare'=> '>=' ,//<= El valor hasta de la lente ha de ser mayor o igual que el señalado en el slider (TIENE QUE GARANTIZAR EL HASTA SEÑALADO PARA LO QUE HA DE SER SUPERIOR)
                              'type'=>'DECIMAL'                              
                                );

        array_push($meta_query,$meta_dioptEsfDesde);
        array_push($meta_query,$meta_dioptEsfHasta);
        }else{
              $NotEspecified[] =array('mens'=>_x('Dioptrías de esfera','FilterIolEngine','iol_cpt_display'));
              $UndefinedMetaDataSelector[] = '#amount-esfera';
        }
        
     
        //2º Las Cilíndricas
     if(array_key_exists ('dioptCilD',$_GET)){
            
        //Primero sacamos los 2 límites y luego con meta_query hacemos la query.
        $pos = strpos($_GET['dioptCilD'], ' ');
        $dioptCil_inf = substr($_GET['dioptCilD'], 0, $pos);
        
        $textInf = _x('Dioptrías Cilíndricas disponibles inferiores o iguales a:','FilterIolEngine','iol_cpt_display');
        $valueInf = $dioptCil_inf;
        
        //echo 'Las dioptrías inferiores del cilindro marcadas en el slider son:|'.$dioptCil_inf.'<br />';

        $last_space = strrpos($_GET['dioptCilD'], ' ');
        $pos_guion = strpos($_GET['dioptCilD'], '-',strpos($_GET['dioptCilD'],'diop'));
        $dioptCil_sup_lenght = $last_space - $pos_guion - 2;
         
        $dioptCil_sup =substr($_GET['dioptCilD'], $pos_guion +2 , $dioptCil_sup_lenght);

		$textSup  = _x('Dioptrías cilíndricas disponibles superiores o iguales a:','FilterIolEngine','iol_cpt_display');
		$valueSup = $dioptCil_sup;
		
        $iolAudit[] = array('text'=>$textInf,'value'=> $valueInf );
        $iolAudit[] = array('text'=>$textSup,'value'=> $valueSup );

        //Vamos ahora con el meta_query hay que tener en cuenta que ésta no es como el resto. 
        $meta_dioptCilDesde = array(
                              'key'=>'cilDesdeD',
                              'value'=> $dioptCil_inf,//floatval($diamOpt_sup),//array((float) $diamOpt_inf, (float)$diamOpt_sup),
                              'compare'=> '<=' ,//>=
                              'type'=>'DECIMAL'                              
                                );

        $meta_dioptCilHasta = array(
                              'key'=>'cilHastaD',
                              'value'=> $dioptCil_sup,//floatval($diamOpt_sup),//array((float) $diamOpt_inf, (float)$diamOpt_sup),
                              'compare'=> '>=' ,//<=
                              'type'=>'DECIMAL'                              
                                );
        
        array_push($meta_query,$meta_dioptCilDesde);
        array_push($meta_query,$meta_dioptCilHasta);
        
        }else{
              $NotEspecified[] =array('mens'=>_x('Dioptrías cilíndricas','FilterIolEngine','iol_cpt_display'));
              $UndefinedMetaDataSelector[] = '#amount-cilinder';  
        }
        


        ?>
        