<?php

//We have the following table containing the logic of the algorythm

//user_data_key 						user_data_key_value					user_data_key_Values  			-- Filter Criteria 1 -- Filter Criteria 2 --
//JSON_IOL_Type_Definition	  	 empty								[{}] -> Auxiliar regiter with the definition of the Filter Criteria according to taxonomies in JSON Format.
//data_key_value_1					 compulsory/optional				Impact on Criteria 1				-- Impact on Criteria 2 --...


//We have the following Impacts on Criteria:
					//	0								--> 0	=> No impact
					// 	*user_data_key* --> 1 => IMPACT: The defined Rule Applies
					//	*mens_code*			--> Mens to be added to the result in some circunstances


//There are three entry points:
	// - the output of get_user_meta().
	// - the select distinct user_data_keys
	// - the  query for getting the columns
	// - the query for getting an associative array with columns => JSON_IOL_Type_Definition

// 1) if they do not match -> Warning.

/* 2)
			for(OUTPUT of QUERYCOLUMNS){
			select distinct COLUMN_X
			from (select * from TABLE where user_data_key_value in (OUTPUT from get_user_meta())) table 1;
					where user_data_key != JSON_IOL_Type_Definition
			}
			AN ASSOCIATIVE ARRAY(COLUMN => ARRAY OF VALUES) is generated
*/

/* 3)
			FOREACH(COLUMN_ARRAY_RESULTS as ARRAY){

				if(1 in ARRAY_ARRAY_RESULTS)
				ARRAY_EXCLUSIONS (PUSH COLUMN)
				if(code coment in ARRAY_RESULTS)
				ARRAY_COMMENTS (PUSH COLUMNS COMENT)

			}
*/

/*

foreach(ARRAY_COLUMNS_RULES as COLUMNA_Rule)
{
IF(COLUMNA_RULE->COLUMNA in A)
foreach(COLUMNA_RULE as COLUMNA=>JSON_OBJECT){

	  foreach(JSON_OBJECT as KEY=>VALUE){
	  tax_query= array(f($key,$value))
	  }

}
}


	El resultado del proceso es un objeto WP_Query.

	*/


global $wpdb;
$currentUser = wp_get_current_user();

//Sacamos las columnas que tienen restricciones.



$queryGetRestrictorColumns = 'SELECT COLUMN_NAME
															FROM INFORMATION_SCHEMA.COLUMNS
															WHERE TABLE_SCHEMA = "'.DB_NAME.'"
																		AND TABLE_NAME = "nc_iol_selector"
																		AND COLUMN_NAME not in
																		("linked_question_key","question_linked_to_usermeta","term_key","term_desc_es","ID_Sel")';


$arrayConds =  $wpdb->get_col($queryGetRestrictorColumns);

//vamos a tratar de optimizar un poco el asunto.


//sacamos los valores de los user meta que hay en la tabla.

$queryGetUserDataKeys = 'SELECT DISTINCT(`linked_question_key`) FROM `nc_iol_selector` where `linked_question_key` != "-" ';

$arrayUserDataKeys = $wpdb->get_col($queryGetUserDataKeys);



//a partir del array aterior vamos a sacar los userDataKeysValues poniendo Not Specified si no est� definido.

$neededKeysValues = array();
$actualUserValues = array();

foreach($arrayUserDataKeys as $userDataKey){

	$cUserValue = get_user_meta($currentUser->ID, $userDataKey,TRUE );

	//echo $userDataKey.' <br/>';


	if($cUserValue == ''){
		$cUserValue = 'EMPTY';
	}{
		$cUserValue = $cUserValue;
		$actualUserValues[] = $cUserValue;
		}
	$neededKeysValues[$userDataKey] = $cUserValue;

	}
	//En teor�a deber�amos hacer ya un array de log con la informaci�n de los datos que no han sido aportados.

	//ahora vamos a crear un array con los UserKeyValues para crear ir haciendo una query columna a columna.


	$userKeyValuesQ = implode('","',$actualUserValues);

	//echo $userKeyValuesQ;

	$resultUserFilterExlusions = array();
	$resultKeyValuesExclusors = array();

	$qSample = 'SELECT distinct (`monovision`) FROM `nc_iol_selector` WHERE `term_key` in("'.$userKeyValuesQ.'")';

	foreach($arrayConds as $cond){

		$queryCondTotal = 'SELECT distinct (`'.$cond.'`) FROM `nc_iol_selector` WHERE `term_key` in("'.$userKeyValuesQ.'")';

		$queryCondRestric = 'SELECT `term_key` FROM `nc_iol_selector` WHERE `term_key` in("'.$userKeyValuesQ.'") and `'.$cond.'` = 1';

		$resultUserFilterExlusions[$cond] = $wpdb->get_col($queryCondTotal);//Qu� taxonom�as se han excluido.

		$resultKeyValuesExclusors[$cond] = $wpdb->get_col($queryCondRestric);//Qu� metadatakeys han excluido

	//	echo $cond.' es: '.implode(",",$resultKeyValuesExclusor[$cond]).'<br />';

		}

//ahora trabajanos con $result[$cond]

//1. Seleccionamos las restricciones que contienen 1.

$filterExclusionsActive =  array();
$filterExclusionsInactive = array();
$jSonsActives = array();
$jSonsInactives = array();
$taxQueryInclusions = array();
$taxQueryExclusions = array();


foreach($resultUserFilterExlusions as $key=>$value){

	if(in_array(1,$value )){

		$filterExclusionsActive[] = $key;

	}else{
		$filterExclusionsInactive[] = $key;
		}

	}

//vamos a poner ahora en formato matrix los valores que han excluido cada condici�n.


//AUDIT

if((1) && (current_user_can('manage_options'))){
	$countExlusors = 0;
echo '<table style="border:1px solid grey; padding:3px;">';
foreach($resultKeyValuesExclusors as $key=>$value){
	echo '<tr style="border:1px solid grey;">';
	echo '<td style="min-width:270px; padding:5px;">num: '.$countExlusors.' '.$key.'</td>';
		echo '<td style="max-width:450px; padding:5px;">'.implode(", ",$value).'</td>';

	echo '</tr>';
$countExlusors +=1;
	}
echo '</table>';
}



foreach($filterExclusionsInactive as $filterColumnActive){ //Columnas-condiciones que no han tenido un 1

	$jSonsActivesQ = 'SELECT `'.$filterColumnActive.'` FROM `nc_iol_selector` WHERE `term_key` = "JSON_IOL_Type_Definition"';

	$jSonsActives[] = $wpdb->get_var($jSonsActivesQ);

 }


 foreach($filterExclusionsActive as $filterColumnInactive){//Columnas-condiciones que s� han tenido un 1


	$jSonsInactivesQ = 'SELECT `'.$filterColumnInactive.'` FROM `nc_iol_selector` WHERE `term_key` = "JSON_IOL_Type_Definition"';

	$jSonsInactives[] = $wpdb->get_var($jSonsInactivesQ);

 }






//funci�n para parsear un json object de inclusions
function taxQueryGenerator ($jSonsActives, $relation){//$condition,

	$taxQueryInclusions = array();
	$taxQueryInclusions['relation']= $relation;

foreach($jSonsActives as $jsonRestrictionsStrings){//jSonsActives es un jsonstring array de Objetos.--> Coges cada string de columna

	$jsonRestrictionArray = json_decode($jsonRestrictionsStrings);

		$taxQueryInclusionsAux = array();
    $taxQueryInclusionsAux['relation'] = 'AND';//'OR';//'AND'; //Concatenas los arrays de taxonom�as dentro de una condici�n

	foreach($jsonRestrictionArray as $restrictObj){ //$jsonRestrictionArray es un array de objetos.

		$restrictionsFromJsonObj = get_object_vars($restrictObj);



	foreach($restrictionsFromJsonObj as $key=>$value){

		$taxQueryInclusionsAux[] = array(
                                    'taxonomy' => _x($key,'taxo-name','iol'),
                                    'field' => 'slug',
                                    'terms' => array(_x($value,'taxo-value-slug','iol-scaffold')),
                                    //'operator' => $condition//'IN'//aqu� est� el tema de las inclusiones.
             );
			}


		}
$taxQueryInclusions[] = 	$taxQueryInclusionsAux;


	}

	return $taxQueryInclusions;

	}

/*
//TRADUCCIÓN!!
$jSonsActives => COLUMNAS QUE NO TIENEN 1 => Columnas que no han sido exluidas (el 1 excluye)
$jSonsInactives => COLUMNAS QUE HAN TENIDO AL MENOS UN 1 => Columnas que han sido excluidas.

taxQueryGenerator ($jSonsActives, $condition,$relation)

OLD: Parámetro $condition: Se refiere a si incluye la lente en la pareja taxonomía término dada en la condición:IN o si la excluye:NOT IN.
	Lo anterior es lo que me ha hecho perder tanto tiempo. No se cumplen las subtax_query simultaneamente con NOT IN, son adiciones de NOT IN.
	La única manera de hacer un NOT IN simultaneo es hacer un IN simultaneo agarrar los IDs y luego hacer un POST NOT IN.
///
Parámetro: $relation es la relación que guardan las columnas con las condiciones entre sí.
Por ejemplo si van a ser de exclusión, esto es no puede ser ninguna columna el parámetro relation deberá ser AND.
Si son de inclusión esto es vale que cumpla las condiciones dada por una columna y también  por la otra el parámetro relation es OR
///

*/
//	$taxQueryInclusions = taxQueryGenerator($jSonsActives, 'IN','OR');//


	//$taxQueryExclusions = taxQueryGenerator($jSonsActives, 'IN','OR'); => Con esta query tiro el servidor, cuando hay muchas columnas active.

//[{"diseno-optica":"monofocal"}] [{"diseno-optica":"monofocal"},{"toricidad":"torica"}] [{"diseno-optica":"multifocal-de-rango-exendido-de-vision"},{"toricidad":"torica"}]

//	$jSonsInactives = array('[{"diseno-optica":"multifocal-bifocal"},{"toricidad":"torica"}]','[{"diseno-optica":"multifocal-trifocal"},{"toricidad":"no-torica"}]');//,'[{"diseno-optica":"monofocal"},{"toricidad":"torica"}]');//,$jSonsInactives[1]

//echo $jSonsInactives[0].$jSonsInactives[1].$jSonsInactives[2].'<br /><br />';

//echo $jSonsInactives[0].'; '.$jSonsInactives[1].';<br />';

	//$taxQueryRaw = taxQueryGenerator($jSonsInactives, 'AND'); //'NOT IN',

////////////////////////////////////////////////////////////////////////////////
// Hay que pregunta a Ludger como lo tiene pensado admite las dos opciones.
////////////////////////////////////////////////////////////////////////////////

//Vamos a tener que meter un quick check del preop

	//$taxQueryRaw = taxQueryGenerator($jSonsActives, 'OR'); //'NOT IN',
	$taxQueryRaw = taxQueryGenerator($jSonsInactives, 'AND'); //'NOT IN',

////////////////////////////////////////////////////////////////////////////////

	    $iol =_x('lente-intraocular','CustomPostType Name','iol');


	    $argsIolSelectorStd = array(	'post_type'=>$iol,
                      					'post_status' => 'publish',
                      					'posts_per_page' =>-1,
                     	 					//'paged' => $page,
    														//Vamos a ordenar siempre por orden de preferencia ascendente.
    				  									'orderby'=>'meta_value_num',//nivelPrefLenteMD
    								  					'meta_key'=>'nivelPrefLenteMD',
    								 					 	'order'=>'DESC'
                      					);

	$array_tax_queries = array();
if(count($taxQueryRaw) > 1){

	//vamos a crear tantos tax_queries como sea necesario.
			for($tax_query_index = 0;$tax_query_index < count($taxQueryRaw)-1;$tax_query_index++){
					$array_tax_queries[] = $taxQueryRaw[$tax_query_index];
					}
}else{
	$array_tax_queries[] = array();//$taxQueryRaw[1]
	//$argsIolSelector['tax_query'] = $taxQueryRaw;
}

$array_posts_in = array();


$count = 0;
		foreach($array_tax_queries as $tax_query){
			$argsIolSelectorStd['tax_query'] = array($tax_query);
			$args_tax_postin_tax_query = $argsIolSelectorStd;
			$wpquery_postin_tax_query = new WP_Query($args_tax_postin_tax_query);
			$array_posts_in[] =	wp_list_pluck($wpquery_postin_tax_query->posts, 'ID');

/*-- Vamos a poner aquí el Audit para los SuperAdmin --*/
if(current_user_can('manage_options')){
echo 'Recordamos que si estamos en inactivos esto será un not in y si estamos en activos un post__in:<br /><br />';
echo 'La query numero: '.$count.' que se ejecuta:<br /><br /><br />';
print_r($tax_query);
echo '<br/><br/>Los posts:<br /><br />';
print_r(wp_list_pluck($wpquery_postin_tax_query->posts, 'post_name'));
echo '<br /><br /><br /><br /><br />';
}
/*-- Fin del Audit --*/
			$count = $count +1;
		}



 if($taxQueryRaw['relation'] == 'AND'){
//tienen que ser los que estén en todos los arrays
	 //$ids_selected = array_unique(call_user_func_array('array_merge', $array_posts_in));//array_intersect($array_posts_in);
   //$ids_selected = call_user_func_array('array_intersect',$array_posts_in);
	if(count($array_posts_in)>1){
		$ids_selected = array_unique(call_user_func_array('array_merge', $array_posts_in));//vas a poner un post__not_in
	}else{
		$ids_selected = array_unique($array_posts_in[0]);
	}
$post_not_in = true;
$post_in = false;


 }else{
//quiere decir que es un OR con que esté en uno de los arrays es sufciente


$ids_selected = array_unique(call_user_func_array('array_merge', $array_posts_in));// vas a poner un post_in call_user_func_array('array_intersect',$array_posts_in);
$post_in = true;
$post_not_in = false;
 }


 $argsIolSelectorClean = array(	'post_type'=>$iol,
 													'post_status' => 'publish',
 													'posts_per_page' =>10,
 													'paged' => $page,
 													//Vamos a ordenar siempre por orden de preferencia ascendente.
 													'orderby'=>'meta_value_num',//nivelPrefLenteMD
 													'meta_key'=>'nivelPrefLenteMD',
 													'order'=>'DESC'
 													);

if($post_in){
	if(count($ids_selected) > 0){
				$argsIolSelectorClean['post__in'] = $ids_selected;
			}else{
					$argsIolSelectorClean['post__in'] = array('-1');
		}
}
if($post_not_in){
	$argsIolSelectorClean['post__not_in'] = $ids_selected;
}






       $queryRTest = new WP_Query($argsIolSelectorClean);





//$queryRTest//Este es el final


/*
array(3) {
["relation"]=> string(3) "AND"
[0]=> array(3) {
		["relation"]=> string(3) "AND"
		[0]=> array(4) {
				["taxonomy"]=> string(13) "diseno-optica"
				["field"]=> string(4) "slug"
				["terms"]=> array(1) {
							[0]=> string(19) "multifocal-trifocal"
						     }
				["operator"]=> string(6) "NOT IN"
				}
		[1]=> array(4) {
				["taxonomy"]=> string(9) "toricidad"
				["field"]=> string(4) "slug"
				["terms"]=> array(1) {
							[0]=> string(9) "no-torica"
							}
				["operator"]=> string(6) "NOT IN" }
				}
[1]=> array(3) {
		["relation"]=> string(3) "AND"
		[0]=> array(4) {
				["taxonomy"]=> string(13) "diseno-optica"
				["field"]=> string(4) "slug"
				["terms"]=> array(1) {
							[0]=> string(9) "monofocal"
							}
				["operator"]=> string(6) "NOT IN"
				}
		[1]=> array(4) {
				["taxonomy"]=> string(9) "toricidad"
				["field"]=> string(4) "slug"
				["terms"]=> array(1) {
							[0]=> string(6) "torica"
							}
				["operator"]=> string(6) "NOT IN" } } }

				Lo anterior no devuelve nada => NO HACE SUBQUERIES FUSIONA LAS RESTRICCIONES
*/


?>
