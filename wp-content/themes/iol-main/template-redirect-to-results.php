<?php /* 
Template Name: Template	 Redirect to results
*/ 


if(iolSurgeryForm($_POST)){
    echo 'Inserción realizada con éxito';
    }else{
        echo 'Lamentamos comentarle que ha habido un error';    
    }

$idResult = 2881;
$resultPostOpTestPageUrl =  get_permalink( $idResult );

/*
var_dump(get_page_by_title( 'Resultados de la operación de Cataratas y Presbicia con lente intraocular' ));
echo 'hola';
echo $resultPostOpTestPageUrl; 
*/
wp_redirect($resultPostOpTestPageUrl.'?fromPost=Yes');

//echo 'vamos a ver si hacemos el debug de ';
exit();

?>