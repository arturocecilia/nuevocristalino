<?php 
/*Filtro análogo a filterIolEngine para clínicas*/
	
	//echo 'Está pasando por filterClinicaEngine';
	
	//En el caso de clínicas no hay meta_query, todo son taxonomías :).
    //$meta_query_clinica = array();
    $tax_query_clinica = array();

    $clinicaUndefinedMetadataSelector[] = 'fake';

    //echo 'Pasando por filterClinicaEngine.php';



//-1 Femto Faco

    $femtoFacoN =_x('femto-faco','taxo-name','clinica');

	if(array_key_exists($femtoFacoN,$_GET)){
        if($_GET[$femtoFacoN] != $femtoFacoN.'-se'){
        
        $args[$femtoFacoN] = $_GET[$femtoFacoN];
        $text = _x('Dispone de Femto faco: ','FilterClinicaEngine','clinica_cpt_display');
        //echo  $text;
        $value = get_term_by( 'slug', $args[$femtoFacoN], $femtoFacoN)->name ;
        //echo 'Y el valor es:'.$value;
        $clinicaAudit[] = array('text'=>$text,'value'=>$value);
        }
       
    }
     else{
        $clinicaNotEspecified[] = array('mens'=>_x('Disponibilidad de operación de femto faco.','FilterClinicaEngine','clinica_cpt_display'));
        $clinicaUndefinedTaxonomyDataSelector[] = 'input[name="'.$femtoFacoN.'"]';
     }


//-0 Seguros

    $segurosN =_x('seguros','taxo-name','clinica');

	if(array_key_exists($segurosN,$_GET)){
        if($_GET[$segurosN] != $segurosN.'-se'){
        
        $args[$segurosN] = $_GET[$segurosN];
        $text = _x('Tiene el seguro concertado: ','FilterClinicaEngine','clinica_cpt_display');
        //echo  $text;
        $value = get_term_by( 'slug', $args[$segurosN], $segurosN)->name ;
        //echo 'Y el valor es:'.$value;
        $clinicaAudit[] = array('text'=>$text,'value'=>$value);
        }
       
    }
     else{
        $clinicaNotEspecified[] = array('mens'=>_x('Seguros concertados.','FilterClinicaEngine','clinica_cpt_display'));
        $clinicaUndefinedTaxonomyDataSelector[] = 'input[name="'.$femtoFacoN.'"]';
     }

//-0.5 Posibilidad de Financiación

    $financiacionN =_x('financiacion','taxo-name','clinica');

	if(array_key_exists($financiacionN,$_GET)){
        if($_GET[$financiacionN] != $financiacionN.'-se'){
        
        $args[$financiacionN] = $_GET[$financiacionN];
        $text = _x('Posibilidad de financiación: ','FilterClinicaEngine','clinica_cpt_display');
        //echo  $text;
        $value = get_term_by( 'slug', $args[$financiacionN], $financiacionN)->name ;
        //echo 'Y el valor es:'.$value;
        $clinicaAudit[] = array('text'=>$text,'value'=>$value);
        }
       
    }
     else{
        $clinicaNotEspecified[] = array('mens'=>_x('Posibilidad de financiacion.','FilterClinicaEngine','clinica_cpt_display'));
        $clinicaUndefinedTaxonomyDataSelector[] = 'input[name="'.$financiacionN.'"]';
     }



     //0 En primer lugar vamos a añadir el tema la restricción de la lente.
     

   $lImp =  _x('lente-implantada','param-name','clinica');

   if(array_key_exists($lImp,$_GET) && $_GET[$lImp] != '0'){
        if($_GET[$lImp] != $lImp.'-se'){
        
        $idLens = $_GET[$lImp];
        $idConnectedClinics = array();
        
        //vamos a seleccionar los ids de las clínicas que están linkadas con la lente cuyo id tenemos.
        $linkedClinics = new WP_Query( array(
  										     'connected_type' => 'lente_to_clinica',
  											 'connected_items' => $idLens,
  											 'nopaging' => true,
										) );
		
		
		while ( $linkedClinics->have_posts() ) : $linkedClinics->the_post();

			$idConnectedClinics[] =  get_the_ID();

         endwhile;								
        
        //Sabemos que filterClinicsEngine se le llama desde ajax y desd pre_get_posts.
        //Si se hace desde ajax args está definida si se hace desde pre_get_posts la que está definida es $query
        
        //echo 'El valorde $query';
        //var_dump($query);
        if($args){
        	$args['post__in'] = $idConnectedClinics;//$_GET[$tITN];
        }else{
        	$query->set('post__in',$idConnectedClinics );
        }
        
        //$query->set('post__in',$idConnectedClinics);
        //add_query_arg('post__in',$idConnectedClinics);
        //var_dump($idConnectedClinics);
        //echo 'Constraint de lente detectada en filterClinics';
        
        $text = _x('Lente Intraocular a implantar: ','FilterClinicaEngine','clinica_cpt_display');
        //echo  $text;
        $value = get_the_title($idLens); ;
        //echo 'Y el valor es:'.$value;
        $clinicaAudit[] = array('text'=>$text,'value'=>$value);
        }
    }
     else{
        $clinicaNotEspecified[] = array('mens'=>_x('Modelo de Lente Intraocular a Implantar','FilterClinicaEngine','clinica_cpt_display'));
        $clinicaUndefinedTaxonomyDataSelector[] = 'input[name="'.$lImp.'"]';
     }


//1 Número de cirugías intraoculares.

    $numCTN =_x('numero-cirugias-intraoculares','taxo-name','clinica');

	if(array_key_exists($numCTN,$_GET)){
        if($_GET[$numCTN] != $numCTN.'-se'){
        
        $args[$numCTN] = $_GET[$numCTN];
        $text = _x('Numero de cirugías intraoculares al año: ','FilterClinicaEngine','clinica_cpt_display');
        //echo  $text;
        $value = get_term_by( 'slug', $args[$numCTN], $numCTN)->name ;
        //echo 'Y el valor es:'.$value;
        $clinicaAudit[] = array('text'=>$text,'value'=>$value);
        }
       
    }
     else{
        $clinicaNotEspecified[] = array('mens'=>_x('Número de operaciones intraoculares.','FilterClinicaEngine','clinica_cpt_display'));
        $clinicaUndefinedTaxonomyDataSelector[] = 'input[name="'.$numCTN.'"]';
     }
     
//2 Tipo de operaciones intraocular.

    $tOTN = _x('tipo-operaciones-intraoculares','taxo-name','clinica');

   if(array_key_exists($tOTN,$_GET)){
        if($_GET[$tOTN] != $tOTN.'-se'){
        $args[$tOTN] = $_GET[$tOTN];
        $text = _x('Tipo de operación intraocular: ','FilterClinicaEngine','clinica_cpt_display');
        //echo  $text;
        $value = get_term_by( 'slug', $args[$tOTN], $tOTN)->name ;
        //echo 'Y el valor es:'.$value;
        $clinicaAudit[] = array('text'=>$text,'value'=>$value);
        }
       
    }
     else{
        $clinicaNotEspecified[] = array('mens'=>_x('Ubicación de la Clínica.','FilterClinicaEngine','clinica_cpt_display'));
        $clinicaUndefinedTaxonomyDataSelector[] = 'input[name="'.$tOTN.'"]';
     }
//3 Equipamiento de la clínica -> equipamiento-clinica

    $eCTN = _x('equipamiento-clinica','taxo-name','clinica');
    
   if(array_key_exists($eCTN,$_GET)){
        if($_GET[$eCTN] != $eCTN.'-se'){
        $args[$eCTN] = $_GET[$eCTN];
        $text = _x('Equipamiento de la clínica: ','FilterClinicaEngine','clinica_cpt_display');
        //echo  $text;
        $value = get_term_by( 'slug', $args[$eCTN], $eCTN)->name ;
        //echo 'Y el valor es:'.$value;
        $clinicaAudit[] = array('text'=>$text,'value'=>$value);
        }
       
    }
     else{
        $clinicaNotEspecified[] = array('mens'=>_x('Equipamiento de la clínica','FilterClinicaEngine','clinica_cpt_display'));
        $clinicaUndefinedTaxonomyDataSelector[] = 'input[name="'.$eCTN.'"]';
     } 
     
//4 Tipo de implante -> equipamiento-clinica    

   $tITN =  _x('tipo-de-implante','taxo-name','clinica');

   if(array_key_exists($tITN,$_GET)){
        if($_GET[$tITN] != $tITN.'-se'){
        $args[$tITN] = $_GET[$tITN];
        $text = _x('Tipo de implante de interés: ','FilterClinicaEngine','clinica_cpt_display');
        //echo  $text;
        $value = get_term_by( 'slug', $args[$tITN], $tITN)->name ;
        //echo 'Y el valor es:'.$value;
        $clinicaAudit[] = array('text'=>$text,'value'=>$value);
        }
       
    }
     else{
        $clinicaNotEspecified[] = array('mens'=>_x('Tipo de implante de interés','FilterClinicaEngine','clinica_cpt_display'));
        $clinicaUndefinedTaxonomyDataSelector[] = 'input[name="'.$tITN.'"]';
     }

//5 información adicional de la clínica => Lo voy a convertir en checkbox...
// posibilidad-de-financiacion
// posibilidad-de-hospitalizacion
// quirofanos-propios
// seguros
//mas-info-clinica 

    $mITN = _x('mas-info-clinica','taxo-name','clinica');

      
    if(!array_key_exists ('-se',$_GET))//Igual debería incluir en el condicional que se cumpla también que esté presente
    //en el querystring alguno de los valores de los inputs del checkbox pero bueno.
    {
    	$MasInfoClinica = array();
		$text = _x("Más información sobre la clínica: ",'FilterClinicaEngine','clinica_cpt_display');
        $values= array();
        

        if(array_key_exists (_x('posibilidad-de-hospitalizacion','taxo-value-slug','clinica-scaffold'),$_GET)){
        
            $MasInfoClinica[]= array('taxonomy'=>$mITN,
            				  'field'=>'slug',
            				  'terms'=> array($_GET[_x('posibilidad-de-hospitalizacion','taxo-value-slug','clinica-scaffold')])
            					);
            $values [] = get_term_by('slug',$_GET[_x('posibilidad-de-hospitalizacion','taxo-value-slug','clinica-scaffold')],$mITN)->name;
            
        } 
         if(array_key_exists (_x('laser-propio','taxo-value-slug','clinica-scaffold'),$_GET)){
        
            $MasInfoClinica[]= array('taxonomy'=>$mITN,
            				  'field'=>'slug',
            				  'terms'=> array($_GET[_x('laser-propio','taxo-value-slug','clinica-scaffold')])
            					);
            $values [] = get_term_by('slug',$_GET[_x('laser-propio','taxo-value-slug','clinica-scaffold')],$mITN)->name;
            
        }
        
         if(array_key_exists (_x('quirofanos-propios','taxo-value-slug','clinica-scaffold'),$_GET)){
        
            $MasInfoClinica[]= array('taxonomy'=>$mITN,
            				  'field'=>'slug',
            				  'terms'=> array($_GET[_x('quirofanos-propios','taxo-value-slug','clinica-scaffold')])
            					);
            $values [] = get_term_by('slug',$_GET[_x('quirofanos-propios','taxo-value-slug','clinica-scaffold')],$mITN)->name;
            
        }
        
         //Concatenamos las informaciones adicionales.
         if(count($MasInfoClinica)){
             
             	   
                                     
           $valueText = join(', ',$values);
           $clinicaAudit[] = array('text'=>$text,'value'=>$valueText);

           foreach($MasInfoClinica as $mInfo){
			 array_push($tax_query_clinica,$mInfo);
           }     
         }   
        
        
        }
       else{
        $clinicaNotEspecified[] = array('mens'=>_x('Información adicional de la clínica.','FilterClinicaEngine','clinica_cpt_display'));
        $clinicaUndefinedTaxonomyDataSelector[] = '#mas-info-clinica input';
     }
        

//Seguimos con los filtros de ubicación -> ubicacion-parent, ubicacion-child.


if(array_key_exists('ubicacion-parent',$_GET) or array_key_exists('ubicacion-child',$_GET) or get_query_var('ubicacion') ){
    	
    	$ubicacion = array();
		$text = _x("Localizacion: ",'FilterClinicaEngine','clinica_cpt_display');
        $values= array();
        
        if($_GET['ubicacion-parent'] != 'ubicacion-parent-se'){
        
        $ubicacion[]= array('taxonomy'=>_x('ubicacion','taxo-name','clinica'),
            				    'field'=>'slug',
            				    'terms'=> array($_GET['ubicacion-parent'])
            					);
        $values[] = get_term_by( 'slug', $_GET['ubicacion-parent'], _x('ubicacion','taxo-name','clinica'))->name ;
        }
        else{
            //
        }
        
        //Hemos añadido también la opción de que no esté definida, en el caso de algunas versiones de países la ubicación-child no lo estará.
        if(($_GET['ubicacion-child'] != 'ubicacion-child-se') && ($_GET['ubicacion-child']!= NULL)){
        
        $ubicacion[]= array('taxonomy'=>_x('ubicacion','taxo-name','clinica'),
            				    'field'=>'slug',
            				    'terms'=> array($_GET['ubicacion-child'])
            					);
        $values[] = get_term_by( 'slug', $_GET['ubicacion-child'], _x('ubicacion','taxo-name','clinica'))->name ;
       
           /* if(current_user_can('manage_options'))
                {
                    echo 'está pasando por aquí1';
                    var_dump($_GET['ubicacion-child']);
                }
                */

        }
        else{
              /*  if(current_user_can('manage_options'))
                {
                    echo 'está pasando por aquí2';
                }*/

        }
        
        if(get_query_var('ubicacion')){
         $ubicacionUrl = get_query_var('ubicacion'); 
         $values[] = $ubicacionUrl;
         $ubicacion[] = $ubicacionUrl;
          
        }
        
        //Concatenamos las dos ubicaciones.
         if(count($ubicacion)){	   
           
          if($ubicacionUrl){                 
            $valueText = $ubicacionUrl;  
           }else{
           	$valueText = join(', ',$values);//$values;//
			}

           $clinicaAudit[] = array('text'=>$text,'value'=>$valueText);
           
           foreach($ubicacion as $ubic){
               //echo $ubic.' como ubicación';
			 array_push($tax_query_clinica,$ubic);

              //var_dump($tax_query_clinica);
           }     
         }        
       
    }
     else{
        $clinicaNotEspecified[] = array('mens'=> _x('Ubicación de la Clínica.','FilterClinicaEngine','clinica_cpt_display'));
        $clinicaUndefinedTaxonomyDataSelector[] = 'select[name="ubicacion-parent"], select[name="ubicacion-child"]';
     }
?>     