<?php


 
 function clinica_show_posted_values(){

     //echo 'pasando por la función clinica_show_posted_values';
     

    // $permalink_structure = get_option('permalink_structure');
    // echo $permalink_structure;

    global $clinicaAudit;
    global $clinicaUndefinedMetaDataSelector;
    global $clinicaUndefinedTaxonomyDataSelector;
    
    
    global $clinicaPluginDirectory;
    
    //Vamos a hacer el motor de queries dados unos par‡metros determinados desde el filter form.
    $clinica =_x('clinica','CustomPostType Name','clinica');

    //Par‡metros de partida incluyendo el de paginaci—n.
    
    //Vamos a analizar el valor con el que viene la variable page -> Es lo que nos va a escupir la funci—n paginate-links
    $page = array_key_exists('page',$_GET) ? $_GET['page'] : 1;//(get_query_var('page')) ? get_query_var('page') : 1; //$_GET['paged'] ? $_GET['paged'] : 1;  

    //Vemos también el tipo de vista seleccionado por el usuario.
    $viewType = $_GET['viewType'] ? $_GET['viewType'] : 4;
    if($viewType!= 'Grid'){
        $viewTypeNumber = $viewType;
        $Grid=false;
    }else{
        $Grid= true;
        $viewTypeNumber = 12;
    }


    $args = array('post_type'=>_x('clinica','CustomPostType Name','clinica'),
                  'post_status' => 'publish',
                  'posts_per_page' => $viewTypeNumber,
                  //como resultado de ajax sólo queremos que salgan las clínicas padres.
                  'post_parent'=> 0,
                  
                  //'orderby'=> 'nivel-pref-clinica',
                  //'order'=>'ASC',
                  'orderby','meta_value_num',
                  'meta_key','nivelPrefClinicaMD',
                  'order','DESC',
                  'paged' =>$page,
                  'ajax' => 'AJAX'); //
                  

    require($clinicaPluginDirectory.'filterClinicaEngine.php');

    
    $args['tax_query']  = $tax_query_clinica;
    //$args['meta_query'] = $meta_query_clinica;
    
           
    $clinicaQueryFilter = new WP_Query( $args );
       
    require('ajaxClinicaTemplate.php');

   

   /* Restore original Post Data */
   die();
 }

 $queryFilter=NULL;
?>