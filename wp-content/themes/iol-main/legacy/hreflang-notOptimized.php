<?php

global $ncWPSites;
global $ncWPSitesSEO;
global $siteCountry;
global $ncWPSitesCountry;

//Aquí vamos a mostrar a google la canonización según países.
$ncWPSites = array(
                'es_ES'     =>      1,
                'es_MX'     =>      2,
                'en_GB'     =>      3,
                'de_DE'     =>      4,
                'es_CO'     =>      5,
                //'fr_FR'     =>      6,
                'es_CL'     =>      7,
                'de_AT'     =>      8,
                'en_US'     =>      9
                );


/*--  Vamos a aplicar esto sólo si no es una petición AJAX por el tema de recursos -- */


if( !(! empty( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) && strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ]) == 'xmlhttprequest') ) {

        //Sacamos el ID actual

        $id_MainQ = get_queried_object_id();

        //Esto es válido si es un single post type: page, post, iol
  function hrefLangGenerator($id_MainQ){
    global $ncWPSitesSEO;
    global $ncWPSites;
    global $query_string;

    $post_typeT = get_post_type( $id_MainQ );
    
//Primero hacemos el chequeo de si estamos en la home.
if( is_home() ){

    foreach($ncWPSites as $key=>$value){
    
        switch_to_blog($value);
        echo '<link rel="alternate" hreflang="'.$ncWPSitesSEO[$key].'" href="'.  get_site_url( $value ).'" /> ';
        restore_current_blog();

    }
    return;
}

//Segundo vamos a ver que sea single y que el post type sea uno de los que tiene relación directa: post, page, lente-intraocular, fabricante

if(is_page()){
    foreach($ncWPSites as $key=>$value){
        switch_to_blog($value);
            echo '<link rel="alternate" hreflang="'.$ncWPSitesSEO[$key].'" href="'. get_permalink( $id_MainQ ).'" /> ';
        restore_current_blog();
        }
        return;
}


if(is_single() && ($post_typeT == _x('lente-intraocular','CustomPostType Name','iol') || $post_typeT == _x('fabricante','CustomPostType Name','fabricante') || $post_typeT == 'post' )){
   
    if( $post_typeT == _x('lente-intraocular','CustomPostType Name','iol') ){
   
    foreach($ncWPSites as $key=>$value){
        switch_to_blog($value);

            $currentLang = $key;//;
            //echo 'Pasa por el single de hrefLang';

            $rootCurrentUrlSite = get_site_url($value);
            //echo 'La url del blog site es:'.$rootCurrentUrlSite;
           
            $rawUrl = get_permalink( $id_MainQ );

            if(mb_substr($key, 0, 2) != mb_substr(get_locale(), 0, 2) ){
                
                 $slugIOL = '/'.nameWPTermContextIOL( _x('lente-intraocular','slug','iol') , $currentLang,'slug','iol');
           
            }
            else{
                $slugIOL ='';
            }
            $iolLink =  str_replace ( $rootCurrentUrlSite , $rootCurrentUrlSite.$slugIOL , $rawUrl);

            echo '<link rel="alternate" hreflang="'.$ncWPSitesSEO[$key].'" href="'. $iolLink.'" /> ';
        restore_current_blog();
        }
      }
     

   if( $post_typeT == _x('fabricante','CustomPostType Name','fabricante')  ){
   
    foreach($ncWPSites as $key=>$value){
        switch_to_blog($value);

            $currentLang = $key;//;
            $rootCurrentUrlSite = get_site_url($value);

           $rawUrl = get_permalink( $id_MainQ );
           if(mb_substr($key, 0, 2) != mb_substr(get_locale(), 0, 2) ){
               $slugFabricante = '/'.nameWPTermContextIOL( _x('fabricante-de-lentes-intraoculares','taxo-slug','fabricante') , $currentLang,'taxo-slug','fabricante');
           }else{
               $slugFabricante = '';
           }


            $fabricanteLink =  str_replace ( $rootCurrentUrlSite , $rootCurrentUrlSite.$slugFabricante , $rawUrl);
            echo '<link rel="alternate" hreflang="'.$ncWPSitesSEO[$key].'" href="'. $fabricanteLink.'" /> ';

        restore_current_blog();
        }
      }


    if(  $post_typeT == 'post'  ){
   
    foreach($ncWPSites as $key=>$value){
        switch_to_blog($value);


            echo '<link rel="alternate" hreflang="'.$ncWPSitesSEO[$key].'" href="'. get_permalink( $id_MainQ ).'" /> ';

        restore_current_blog();
        }
      }


     return;
    }
 // When any custom taxonomy archive page is being displayed.
 



   
     
if(is_tax()){

  if(current_user_can( 'manage_options' )){
    
      if ( get_query_var( 'paged' ) ) {
        
       $paginada = TRUE;
      }

    }

    $iolTaxos = get_object_taxonomies(_x('lente-intraocular','CustomPostType Name','iol'), 'names');
    




    if(is_tax($iolTaxos)){
 
	
    /* PARSEANDO LA URL----> */
    //Creamos un array a partir de la url.
    $arrayCopy = wp_parse_args($query_string);
    //Ponemos el puntero interno en último lugar.
    end($arrayCopy);
    //En taxo name ponemos la key del elemento donde está el puntero => El último y será la taxonomía
    $taxoName = key($arrayCopy);
    //Sacamos el término de la taxonomía.
    $termName = $arrayCopy[$taxoName];
    //
    $rootCurrentUrl = get_site_url($value);
    /* Con Funciones Built-In de WP */


    


        //Si es simultáneamente archivo y taxonomía es que es la url del archive con parámetros de taxonomía

        if(is_archive()){

            $singleTaxo = False;

     foreach($ncWPSites as $key=>$value){
        switch_to_blog($value);
    
        $currentLang = $key;//;
        $rootCurrentUrlSite = get_site_url($value);

        //Sacamos el término localizado.
        $taxoNameLoca = nameWPTermContextIOL( _x($taxoName,'taxo-name','iol') , $currentLang,'taxo-name','iol');
        $termNameLoca = nameWPTermContextIOL( _x($termName,'taxo-value-slug','iol-scaffold') , $currentLang,'taxo-value-slug','iol-scaffold');
        $slugIOL = nameWPTermContextIOL( _x('lente-intraocular','slug','iol') , $currentLang,'slug','iol');
        //echo $taxoNameLoca;
        //Solucionamos el problema con la ñ, por no tocar más cosas.
        if (strpos($taxoNameLoca,'diseno') !== false) {
            //O diseño a secas, o diseño-optica, o diseño-hapticos
            $taxoNameLoca = str_replace("diseno", "diseño", $taxoNameLoca);
        }

        if(strpos($taxoNameLoca,'tipo-lente-intraocular')!== false) {
            $taxoNameLoca = str_replace("tipo-lente-intraocular", "tipo-lente", $taxoNameLoca);
        }

        if(strpos($taxoNameLoca,'typ-intraokularlinse')!== false) {
            $taxoNameLoca = str_replace("typ-intraokularlinse", "typ", $taxoNameLoca);
        }

        if(strpos($taxoNameLoca,'hersteller-intraokularlinse')!== false) {
            $taxoNameLoca = str_replace("hersteller-intraokularlinse", "hersteller", $taxoNameLoca);
        }
        //echo 'El slug IOL ES: '.$slugIOL ;

        $doHrefLangInTaxo = TRUE;

        
        if( $doHrefLangInTaxo  && !$paginada ){ //is_wp_error( $taxoTermLink ) //el get_term_link no estaba localizando "lente-intraocular"
            //Si da error es que la taxonomía no está registrada:
            
            echo '<link rel="alternate" hreflang="'.$ncWPSitesSEO[$key].'" href="'.$rootCurrentUrlSite.'/'.$slugIOL.'/'.$taxoNameLoca.'/'.$termNameLoca.'" /> ';

        restore_current_blog();
        continue;
        }
    
    
      //  echo '<link rel="alternate" hreflang="'.$ncWPSitesSEO[$key].'" href="'.$taxoTermLink.'" /> ';

    
          restore_current_blog();
        }

        }
        else{
        foreach($ncWPSites as $key=>$value){

                if(in_array($taxoName,$iolTaxos)){
    



        switch_to_blog($value);
        //echo 'esta página es tax';
        $currentLang = $key;//;
        //create_iol_taxonomies();

        //Sacamos el término localizado.
        $taxoNameLoca = nameWPTermContextIOL( _x($taxoName,'taxo-name','iol') , $currentLang,'taxo-name','iol');
        $termNameLoca = nameWPTermContextIOL( _x($termName,'taxo-value-slug','iol-scaffold') , $currentLang,'taxo-value-slug','iol-scaffold');
        
        $doHrefLangInTaxo = TRUE;



        if( $doHrefLangInTaxo  && !$paginada ){ //is_wp_error( $taxoTermLink ) //el get_term_link no estaba localizando "lente-intraocular"
            //Si da error es que la taxonomía no está registrada:
            //Cogemos la url quitamos el siteurl
            //quitamos el term value
            //Cogemos lo que hay entre medias y lo pasamos por el nameWPTerm...

			//Nos quedamos con el primer elemento hasta el param de la url.
            $urlIni = strtok(urldecode($_SERVER["REQUEST_URI"]),'?');
            
            //Al la url depurada anterior le quitamos la parte del nombre del término.
            //Esto funciona porque no habrá url rewrite rule en el término, será directamente el name
            $urlNoTermVal = str_replace($termName, '', $urlIni);
            
            //Nos quedamo a continuación sólo con el slug de la taxonomía que sí que puede tener rewrite rule.
            $urlOnlyTaxoSlug = str_replace($rootCurrentUrl,'',$urlNoTermVal);
            $urlOnlyTaxoSlug1 = str_replace('//','',$urlOnlyTaxoSlug);        
            $urlOnlyTaxoSlugEnd  = substr($urlOnlyTaxoSlug1, 1);
            
            //Con lo anterior ya hemos sacado el slug que corresponde con lo que sólo tenemos que sacar el equivalente
            //en los otros idiomas.
            
            $urlOnlyTaxoSlugEndLoca = nameWPTermContextIOL( $urlOnlyTaxoSlugEnd ,$currentLang, 'slug', 'iol');

                    //Solucionamos el problema con la ñ, por no tocar más cosas.


            $rootUrl = get_site_url($value);
            
            //$taxoTermUrl = '/'.$taxoNameLoca.'/'.$termNameLoca;
            //Replicamos la estructura de permalinks.
            
            echo '<link rel="alternate" hreflang="'.$ncWPSitesSEO[$key].'" href="'.$rootUrl.'/'.$urlOnlyTaxoSlugEndLoca.'/'.$termNameLoca.'" /> ';

        restore_current_blog();
        continue;
        }
    
    
      //  echo '<link rel="alternate" hreflang="'.$ncWPSitesSEO[$key].'" href="'.$taxoTermLink.'" /> ';

    
          restore_current_blog();
        }
            }
            }
        }
}

if(is_post_type_archive(_x('lente-intraocular','CustomPostType Name','iol'))){

   //Sacamos un array key value pair con los parámetros si es que los tiene.
   
   // $qStringArray = wp_parse_args($query_string);
        /*
   
       foreach($ncWPSites as $key=>$value){
        switch_to_blog($value);
            $currentLang = $key;
            //echo 'La currentLang del blog es:'.$currentLang.'<br />';
            //Necesitamos el name del cpt en ese idioma.
            $translatedCPT = directNameWP_CPT( _x('lente-intraocular','CustomPostType Name','iol') , $currentLang,'iol');
            //echo 'El translated CPT es:'.$translatedCPT.'<br />';
            $qStringArrayCopy = $qStringArray;
            //Quitamos el argumento post type que no sé porqué lo añade en el global querystring...
            unset($qStringArrayCopy['post_type']);
            //cargamos las keys en un array:
            $taxosQS    =   array_keys($qStringArrayCopy);
            //var_dump($taxosQS);
            //cargamos los valores
            $valuesQS   =   array_values($qStringArrayCopy);
            //var_dump($valuesQS);

            if(count($taxosQS))
                array_walk($taxosQS,'nameWPTaxoIOL',$currentLang);
            if(count($valuesQS))
                array_walk($valuesQS,'nameWPTermsIOL',$currentLang);

            $qsProcessed = array_combine($taxosQS,$valuesQS);
            
            $qsFinal    = http_build_query($qsProcessed);
            //echo 'La qs final es: '.$qsFinal;

            $archiveUrl =  get_post_type_archive_link( $translatedCPT );
            //echo 'El archive url final es: '.$archiveUrl;

            $urlFinal = $archiveUrl.'?'.$qsFinal;

            echo '<link rel="alternate" hreflang="'.$ncWPSitesSEO[$key].'" href="'.$urlFinal.'" /> ';
        restore_current_blog();
        
        }
        */

}


if(is_archive()){
//echo 'esta página es archive';
    if(current_user_can( 'manage_options' )){
    //echo 'esta página es archive';
    }
 }




}

        //Llamamos a la función hrefLangGenerator que luego estará en el functions.

        hrefLangGenerator($id_MainQ);


        }


$sCount = get_locale();

switch($sCount){
    
    case 'es_ES':
        $siteCountry = 'España';
        unset($ncWPSitesCountry[0]);
    break;
    case 'es_MX':
        $siteCountry = 'México';
        unset($ncWPSitesCountry[1]);
    break;
    case 'en_GB':
        $siteCountry = 'United Kingdom';
        unset($ncWPSitesCountry[2]);
    break;
    case 'de_DE':
        $siteCountry = 'Deutschland';
        unset($ncWPSitesCountry[3]);
    break;
    case 'es_CO':
           $siteCountry = 'Colombia';
        unset($ncWPSitesCountry[4]);
    break;

    case 'fr_FR':
          $siteCountry = 'France';
        unset($ncWPSitesCountry[5]);
    break;

    case 'es_CL':
          $siteCountry = 'Chile';
        unset($ncWPSitesCountry[6]);
    break;

    case 'de_AT':
          $siteCountry = 'Österreich';
        unset($ncWPSitesCountry[7]);
    break;

    case 'en_US':
          $siteCountry = 'United States';
        unset($ncWPSitesCountry[8]);
    break;

}




//echo 'eL SITE COUN'.$sCount.' y el siteCountry'.$siteCountry;



?>