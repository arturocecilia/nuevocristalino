<?php 
 
 
 function iol_show_posted_values(){

    // echo 'En chrome ni siquiera llega aquí';

    // $permalink_structure = get_option('permalink_structure');
    // echo $permalink_structure;

    global $iolAudit;
    global $UndefinedMetaDataSelector;
    global $UndefinedTaxonomyDataSelector;
    
    
    global $iolPluginDirectory;
    
    //Vamos a hacer el motor de queries dados unos parámetros determinados desde el filter form.
    $iol =_x('lente-intraocular','CustomPostType Name','iol');

    //Parámetros de partida incluyendo el de paginación.
    
    //Vamos a analizar el valor con el que viene la variable page -> Es lo que nos va a escupir la función paginate-links
    $page = array_key_exists('page',$_GET) ? $_GET['page'] : 1;//(get_query_var('page')) ? get_query_var('page') : 1; //$_GET['paged'] ? $_GET['paged'] : 1;  

    //Vemos también el tipo de vista seleccionado por el usuario.
    $viewType = $_GET['viewType'] ? $_GET['viewType'] : 4;
    
    $buscador = $_GET['buscador'] ? TRUE : FALSE ;
    


    if($viewType!= 'Grid'){
        $viewTypeNumber = $viewType;
	    $Grid=false;
    }else{
        $Grid= true;
        $viewTypeNumber = 12;
    }





    $args = array('post_type'=>$iol,
                  'post_status' => 'publish',
                  'posts_per_page' => $viewTypeNumber,
                  'orderby'=> 'meta_value_num',
                  'order'=>'DESC',
                  'meta_key'=>'nivelPrefLenteMD',
                  'paged' =>$page,
                  'ajax' => 'AJAX'); //
                  

    require($iolPluginDirectory.'filterIolEngine.php');


    //var_dump($meta_query);
    //echo  var_dump($tax_query);

    
    $args['tax_query']  = $tax_query;
    $args['meta_query'] = $meta_query;
    
    //var_dump($args);
           
    $queryFilter = new WP_Query( $args );
    //echo '<br /><br /><br /><br />';
    //var_dump($queryFilter->request);
    //$iolAudit[] = array('text'=>'Los argumentos que se han pasado: <br />','value'=>$queryFilter->query_vars);
    
    //$iolAudit[] = array('text'=>'La query que finalmente se ha llevado a cabo: <br /><br />', 'value'=> '<div id="infoQuery">'.$queryFilter->request.'</div>');

    //echo var_dump($queryFilter->query_vars);

    //echo var_dump($queryFilter->request);
       
    require('ajaxTemplate.php');

    
    //echo 'Número de lentes Encontradas: '.$queryFilter['found-posts'].'<br />';

   /* Restore original Post Data */
   die();
 }

 $queryFilter=NULL;

?>