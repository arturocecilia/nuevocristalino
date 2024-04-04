<?php 

//función que retorna un array con todas las clínicas.
/*
if(current_user_can('manage_options')){
	echo 'fichero incluido';
	}*/


function getAllClinics(){
	
	
if (!empty($_GET['s'])) {
  // Do something.
  
	}
	$clinicArgs = array(
													'post_type'=> _x('clinica','CustomPostType Name','clinica'),
													'posts_per_page' => -1,
													'orderby' => 'post_title',
													'order'=> 'ASC'
													);
													
	$clinicQuery =  new WP_Query($clinicArgs);
	
	$clinicList = wp_list_pluck( $clinicQuery->posts, 'post_title' );//'ID'
	
	$clinicListToReturn = array();
	
	if ((!empty($_GET['s'])) && ($_GET['s']!= ' ')) {
  // Do something.
  $s = $_GET['s'];
   
   //echo $s;
   
  foreach($clinicList as $clinicName){
  	
  	if(strpos(strtolower ($clinicName), strtolower ($s)) !== false){
  		array_push($clinicListToReturn,$clinicName); 
 		
  		}
  	
  	}
  
}else{

	$clinicListToReturn = $clinicList;
	}
	
		$clinicUnspecified = '-- Si no aparece debajo ponga el nombre libremente --';
		
		//$clinicListToReturn = array_unshift($clinicListToReturn,$clinicUnspecified);
		
 //$clinicListToReturn = array_map(htmlentities,$clinicListToReturn);
	
	$clinicListToReturn = [$clinicUnspecified] + $clinicListToReturn;
	
	echo json_encode($clinicListToReturn);

	exit;
	
	}


?>