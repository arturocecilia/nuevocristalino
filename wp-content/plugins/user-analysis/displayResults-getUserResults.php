<?php

function getUserMetadata(){



    if(isset($_GET["uMetaDataKey"]) && isset($_GET["filterUserMetaDataKey"]) && isset($_GET["filterUserMetaDataValue"]) && isset($_GET["filterUserMetaDataValueId"]) && isset($_GET["dataudisplaynottintoaccount"])){

       global $wpdb;

	   $uMetaDataKey  = $_GET['uMetaDataKey'];
	   $filterUserMetaDataKey = $_GET["filterUserMetaDataKey"];
	   $filterUserMetaDataValue = $_GET['filterUserMetaDataValue'];

	   //var_dump($filterUserMetaDataValue);
	   $actualUserDataValueId = $_GET['filterUserMetaDataValueId'];
	   $dataudisplaynottintoaccount = $_GET["dataudisplaynottintoaccount"];
	   $userskeyvalueexcluded = $_GET["userskeyvalueexcluded"];
	   $userskeyvalueincludedonly = $_GET['userskeyvalueincludedonly'];



	   $filterQ = '';
	   $qDataNotTIntoAccount = '';
	   $usersExcludedQ ='';
	   $usersIncludedOnlyQ = '';


	   if($dataudisplaynottintoaccount != 'undefined'){

	   	$DatasNotTIntoAccount = 	json_decode(stripslashes(html_entity_decode($dataudisplaynottintoaccount)));

	   	$qDataNotTIntoAccount = 'and wp_usermeta.meta_value not in("'.implode("\",\"",$DatasNotTIntoAccount).'")';

	   	}


	   if(($filterUserMetaDataKey != 'undefined') && ($filterUserMetaDataValue != 'undefined')){


	   		$filterQ = 'AND
												wp_users.id in (
																				select wp_users.ID
																				from  wp_users INNER JOIN wp_usermeta
																						on (wp_users.id = wp_usermeta.user_id)
    																				where wp_usermeta.meta_key ="'.$filterUserMetaDataKey.'"
    																					and wp_usermeta.meta_value = "'.$filterUserMetaDataValue.'"
																				)';

	   	}

	   	if(($userskeyvalueexcluded != 'undefined')&&($userskeyvalueexcluded != '')){

	   		$Datasuserskeyvalueexcluded = json_decode(stripslashes(html_entity_decode($userskeyvalueexcluded)));

	   		$usersExcludedQ = '';


	   		//var_dump($Datasuserskeyvalueexcluded);


	   		if(!empty($Datasuserskeyvalueexcluded)){




	   		foreach($Datasuserskeyvalueexcluded as $key=>$value){

	   			$valueAdapted = '';

	   			if(count($value)>1){

	   				$valueAdapted = "('".implode('\',\'',$value)."')";

	   			}else{
	   				$valueAdapted = "('".$value[0]."')";

	   				}

	   				//var_dump($valueAdapted);


	   				$usersExcludedQ .= 'AND
												wp_users.id NOT in (
																				select wp_users.ID
																				from  wp_users INNER JOIN wp_usermeta
																						on (wp_users.id = wp_usermeta.user_id)
    																				where wp_usermeta.meta_key ="'.$key.'"
    																					and wp_usermeta.meta_value in '.$valueAdapted.'
																				)';


	   			}

	   			}

	   		}

	   		//ini included only

	   			   	if(($userskeyvalueincludedonly != 'undefined')&&($userskeyvalueincludedonly != '')){


                $Datasuserskeyvalueincludedonly = json_decode(stripslashes(html_entity_decode($userskeyvalueincludedonly)));


	   		$usersIncludedOnlyQ = '';


	   		//var_dump($Datasuserskeyvalueexcluded);


	   		if(!empty($Datasuserskeyvalueincludedonly)){


	   		foreach($Datasuserskeyvalueincludedonly as $key=>$value){

	   			$valueAdapted = '';




	   			if(count($value)>1){

	   				$valueAdapted = "('".implode('\',\'',$value)."')";



	   			}else{
	   				$valueAdapted = "('".$value[0]."')";

	   				}

	   				//var_dump($valueAdapted);


	   				$usersIncludedOnlyQ .= 'AND
												wp_users.id in (
																				select wp_users.ID
																				from  wp_users INNER JOIN wp_usermeta
																						on (wp_users.id = wp_usermeta.user_id)
    																				where wp_usermeta.meta_key ="'.$key.'"
    																					and wp_usermeta.meta_value in '.$valueAdapted.'
																				)';


	   			}

	   			}

	   		}


	   		//end included only






	   $queryR = 'SELECT wp_usermeta.meta_value as userMeta, count(*) as qt FROM wp_users INNER JOIN wp_usermeta ON (wp_users.id = wp_usermeta.user_id) where wp_usermeta.meta_key = "'.$uMetaDataKey.'" '.$filterQ.' '.$usersExcludedQ.' '.$qDataNotTIntoAccount.' '.$usersIncludedOnlyQ.' group by wp_usermeta.meta_key, wp_usermeta.meta_value';

	   //echo $queryR;

       $results =  $wpdb->get_results( $queryR );

       if(current_user_can('manage_options')){
     		//	echo $queryR;

       	}

       //echo 	grab_uniqueKey_fromUserDataKeyValue('pat');


				//No hace falta: load_textdomain( 'user-manager', plugin_dir_path('user-manager/languages/user-manager-'.get_locale().'mo') );


             $data = Array ();
             //Esta primera asignación son las columnas, luego vendrán los datos

						 if(!is_null($filterUserMetaDataKey)){
							 $filterUserMetaDataKey = _x('Filtro Aplicado','displayresults-getuserresults','user-analysis');
						 }

						 if(!is_null($actualUserDataValueId)){
							 $actualUserDataValueId = _x('Ninguno','displayresults-getuserresults','user-analysis');
						 }

             $data [] = Array ($filterUserMetaDataKey, $actualUserDataValueId );//$uMetaDataKey-->ESTABA MAL!!!!

								//filterUserMetaDataKey //

								$hintCount = 0;
             foreach ( $results as $result )
                {
                	$hintCount = $hintCount +1;

                    $frecuencia = $result->qt;
                    $respuesta = $result->userMeta;
                    if($frecuencia == '' || $respuesta == ''  ){

                      }
                    else{

                    	if($hintCount == 1){
                    		$hint = '('._x('Pregunta:','displayresults-getuserresults','iol_last').' '._x($uMetaDataKey, 'user_manager','user-manager').')';
                    	}else{
                    		$hint = '';
                    		}

					 	 $data[] = Array(_x(grab_uniqueKey_fromUserDataKeyValue($result->userMeta),'user_manager','user-manager').' '.$hint, $result->qt);
					     }
                 }

                if(current_user_can('manage_options')){
									//		var_dump($data);
									}


    header('content-type: application/json');
    echo json_encode($data);


    die();


}}
?>
