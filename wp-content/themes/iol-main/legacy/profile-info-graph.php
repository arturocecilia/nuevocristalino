<?php



//Logica de perfil de usuario por puntos.
//Parte estática
//El usuario es paciente : Es pre o post
// num de inputs de perfil basicProfile
//+ num de inputs de pre o post medica info.

//Según vaya rellenando antes de dar al save se van sumando inputs al recuento..

//código copiado de user-analisys/user-data-checker


//Todos los Formularios que se tienen en cuenta para el profile_count.
//En función de la versión del país lo quitaremos


 if((is_user_logged_in()) && (in_array(get_locale(),array('es_ES','es_MX','es_CL','es_CO')))){

global $wpdb;
$cUserId = get_current_user_id();

$userType = get_user_meta($cUserId,'ncusertype',TRUE);
$userSx = get_user_meta($cUserId,'p_sxInteres',TRUE);
$userPreOrPost = get_user_meta($cUserId,'p_preOrPost',TRUE);

//Creamos un preOrPostOpposite para la query en la que nos quitamso algunos inputs que dependan del valor.
$userPreOrPostOpposite = ($userPreOrPost == 'p_preOrPost_Post') ? 'p_preOrPost_Pre' :'p_preOrPost_Post';


$titleForms = array(
                    "basicProfile" => _x('Perfil básico de usuario','profile-info-graph','iol_last'),
                    "qpls" => _x('Información preoperatoria','profile-info-graph','iol_last'),
                    "prols" => _x('Información postoperatoria','profile-info-graph','iol_last'),
                    "catques9sf" => _x('Questionario Catquest-9SF','profile-info-graph','iol_last')
                    );
$idForms = array(
                    "basicProfile" => 12644, //id de las páginas.
                    "qpls" => 12628,
                    "prols" => 12629,
                    "catques9sf" => 13823
);



if($userType == 'pat'){
 $user_role = array('patient','both');

	//Para "protegernos" de alguien que se registre como prof y luego cambie y no rellene si es pre or post.
  if($userPreOrPost == ''){
  	  $arrayFormsArrays = array(
                        "basicProfile" => array("addProfileBasicData","addPatProfileBasicData")
                        );
  	}


  //Si es pre o post los formularios a entrar en la valoración no son los mismos.

  if($userPreOrPost == 'p_preOrPost_Pre'){

      $arrayFormsArrays = array(
                        "basicProfile" => array("addProfileBasicData","addPatProfileBasicData"),
                        "qpls" => array("qpls"),
                        );


                      }


  if($userPreOrPost == 'p_preOrPost_Post'){

    $arrayFormsArrays = array(
                        "basicProfile" => array("addProfileBasicData","addPatProfileBasicData"),
                        "prols" => array("prols")
                        );

      if(get_locale() == 'es_MX'){
               $arrayFormsArrays["catques9sf"] = array("catques9sf") ;
          }

  }


 }

if( $userType == 'prof'){
 $user_role = array('prof','both');
 $arrayFormsArrays = array(
                     "basicProfile" => array("addProfileBasicData","addProfProfileBasicData")
                     );
 }



//Con la siguiente query sacas todos los inputs sin tener en cuenta si son opcionales o no.
$userFormKeysInfo = array();



foreach($arrayFormsArrays as $key => $value){

	//echo 'profileInfoGraph';

$condAtFly = 'and `condition` not like "%'.$userPreOrPostOpposite.'%" '; //Al ser un filtro de no cumplimiento lo puedes poner en todos sin que afecte.

$queryGetUserMetadataKeys =	'SELECT `user_data_key`
                     				 FROM `nc_userdata`
                    							WHERE `form` in ("'.implode("\",\"",$value).'")
                          										and `input_type` = "input"
                          										and `record_type` not in("autofilled")
                                              and `user_role` in ("'.implode("\",\"",$user_role).'")
                                              and `key` NOT LIKE "%which%"
                                              and `key` NOT LIKE "%Which%"
                                              '.$condAtFly .'
                     				UNION
                     									 SELECT distinct(`user_data_key`)
                     									 FROM `nc_userdata`
                     												WHERE parent in(
                    			  																SELECT `key`
                    																				FROM `nc_userdata`
                    																						WHERE `form` in ("'.implode("\",\"",$value).'")
                              																					and `input_type` = "radio"
                                                                        and `key` NOT LIKE "%which%"
                                                                        and `key` NOT LIKE "%Which%"
                                                                        and `user_role` in ("'.implode("\",\"",$user_role).'")
                                                                        '.$condAtFly .'
                                                                        )';


$userMetadataKeys = $wpdb->get_col( $queryGetUserMetadataKeys);


if(is_user_logged_in()){
//	echo $queryGetUserMetadataKeys;
	}

if(($key == 'basicProfile') && (current_user_can('manage_options'))){
   //var_dump($userMetadataKeys);
}


$numTotalInputs = count($userMetadataKeys);

$userFormKeysInfo[$key]['NumInputs'] = $numTotalInputs;
$userFormKeysInfo[$key]['ArrayInputs'] = $userMetadataKeys;

}

//var_dump($userFormKeysInfo);


$sum = 0;
$fail = 0;

//vamos a generar un array análogo a $userFormDataKeysInfo con el data que ha sido dado por el user tanto en número como en keys.
$userFormDataKeysInfoData = array();


if(count($userFormKeysInfo>1)){
foreach($userFormKeysInfo as $key=>$value){

//echo 'Valueeeeee '.$value["NumInputs"].'<br /><br />';
$userFormDataKeysInfoData[$key]["ArrayInputs"] = array();
 foreach($value["ArrayInputs"] as $ukey){
                    if(get_user_meta( $cUserId, $ukey, TRUE ) != ''){
                  				$sum+=1;
                          array_push($userFormDataKeysInfoData[$key]['ArrayInputs'],$ukey);
                  				}else{
                  							//$arrayKeysEmpty[$ukey] = '';
                  							$fail +=1;
                  					}
          }

$userFormDataKeysInfoData[$key]["NumInputs"] = count($userFormDataKeysInfoData[$key]["ArrayInputs"]);

                  			}

                        }
if(($key == 'basicProfile') && (current_user_can('manage_options'))){
	//echo '<br /><br />Oleeee: <br />';
//var_dump($userFormDataKeysInfoData);
}
}

//los 100 puntos
$difFormPoints = array();


$totalFormPointsNum = 0;
$actualUserPointsNum = 0;
if(count($userFormKeysInfo>1)){
foreach($userFormKeysInfo as $key=>$value){

  $totalFormPointsNum = $totalFormPointsNum + $value["NumInputs"];
}
}

foreach($userFormDataKeysInfoData as $key => $value){
 $actualUserPointsNum = $actualUserPointsNum + $value["NumInputs"];

}
foreach($userFormDataKeysInfoData as $key => $value){

  $difFormPoints[$key]["NumInputs"] = $userFormKeysInfo[$key]["NumInputs"]-$userFormDataKeysInfoData[$key]["NumInputs"];
  $difFormPoints[$key]["ArrayInputs"] = array_diff($userFormKeysInfo[$key]["ArrayInputs"], $userFormDataKeysInfoData[$key]["ArrayInputs"]);
}
if($actualUserPointsNum != 0){
  $valueFilledForms = ($actualUserPointsNum/$totalFormPointsNum);

  }else{
      $valueFilledForms = 0;
  }

if(current_user_can('manage_options')){
//var_dump($difFormPoints['basicProfile']);
}

/*
echo $totalFormPointsNum.' presentes!!<br />';
echo $actualUserPointsNum.' rellenados!!<br />';


var_dump($difFormPoints['basicProfile']["ArrayInputs"]);
*/
echo '<div class="left-profileuser">';
echo '<div class="circle-profile-wrapper">';

if((is_user_logged_in()) && (in_array(get_locale(),array('es_ES','es_MX','es_CL','es_CO','de_DE','de_AT','en_GB','en_US','fr_FR')))){
  $cUserP = get_userdata($cUserId);
  echo '<div class="username-graph"><span>'._x('Usuario:','profile-info-graph','iol_last').' </span>'.$cUserP->user_login.'</div>';
}else{

}

echo '<div class="circle-profile" data-thickness="25">&nbsp;';
echo '<strong></strong>';
//Aquí ponemos un resumen del estatus de los forms.
echo '<div id="profile-graph-info">';

foreach($difFormPoints as $key=>$value){

	if($key == 'basicProfile'){
		$classMessage = 'addprofilebasicdata';
	}else{
		$classMessage =  $key;
		}

  if($difFormPoints[$key]["NumInputs"] == 0){
    echo '<div class="profile-graph-forms-data"><a href="'.get_permalink($idForms[$key]).'">'.$titleForms[$key].'</a> : OK!</div>';
      }
        else{
              echo '<div id="'.$classMessage.'-profile-mens" class="profile-graph-forms-data"><a href="'.get_permalink($idForms[$key]).'#clean">'.$titleForms[$key].'</a> <span>'.$difFormPoints[$key]["NumInputs"].' '._x('faltan','profile-info-graph','iol_last').'</span></div>';
            }
}

if(is_user_logged_in() ){
echo '<div class="profile-graph-mens">'._x('Recuerde que tiene que salvar el cuestionario al acabar apretando el botón que pone Save/Guardar','profile-info-graph','iol_last').'</div>';
}else{
echo '<div class="profile-graph-mens">'._x('Tiene que logearse para ver la información sobre su perfil.','profile-info-graph','iol_last').'</div>';

}

echo '</div>';

echo '</div>';
echo '</div>';

echo '<div id="profile-graph-setup" data-value="'.$valueFilledForms.'" ></div>'; //data-value="0.6"
//info sobre los forms
echo '<div id="init-info-profil-graph"';

foreach($difFormPoints as $key=>$value){


  echo 'data-'.$key.'_total_forms="'.$totalFormPointsNum.'" ';
  echo 'data-'.$key.'_total_completed_forms="'.$actualUserPointsNum.'" ';

 echo 'data-'.$key.'_total="'.$userFormKeysInfo[$key]["NumInputs"].'" ';
 echo ' data-'.$key.'_completed="'.$userFormDataKeysInfoData[$key]["NumInputs"].'"';
 echo ' data-'.$key.'_remaining="'.$value["NumInputs"].'"';

 if($key == 'basicProfile'){
   echo 'data-addProfileBasicData_total_forms="'.$totalFormPointsNum.'" ';
   echo 'data-addProfileBasicData_total_completed_forms="'.$actualUserPointsNum.'" ';

  echo 'data-addProfileBasicData_total="'.$userFormKeysInfo[$key]["NumInputs"].'" ';
  echo ' data-addProfileBasicData_completed="'.$userFormDataKeysInfoData[$key]["NumInputs"].'"';
  echo ' data-addProfileBasicData_remaining="'.$value["NumInputs"].'"';
 }

}
echo '>&nbsp;</div>';
echo '&nbsp;</div>';
 ?>

<script>
//función para actualizar el graph.
//El id del form coincide con la clave



/*jQuery('.circle-profile').circleProgress({
    value: 0.75,
    fill: {  fill: {gradient: [['#0681c4', .5], ['#4ac5f8', .5]], gradientAngle: Math.PI / 4}} // gradient: ['#fdebd6', '#FEA63C']
}).on('circle-animation-progress', function(event, progress, stepValue) {
    jQuery(this).find('strong').text(String(stepValue.toFixed(2)).substr(1));
});*/

value = jQuery("#profile-graph-setup").data("value");

jQuery('.circle-profile').circleProgress({
    value: value,
    startAngle: Math.PI,
    fill: {color: '#FEA63C'}
}).on('circle-animation-progress', function(event, progress) {

    jQuery(this).find('strong').html(parseInt(100 * value) + '<i>%</i>');
});



</script>



<style>
 .left-profileuser {
   float: none;
     padding-right: 0px;
     width: 220px;
     background: transparent;
     padding-bottom: 10px;
     max-width: 250px;
   }

.circle-profile{
  text-align:center;
}

#profile-graph-info{
  margin-top: 15px;
}

.profile-graph-forms-data{
  text-align: left;
      padding-left: 5px;
      margin-bottom: 5px;
      margin-top: 3px;
}
.profile-graph-forms-data a{
    text-decoration: none !important;
    font-size: 12px;
    }
.profile-graph-forms-data > span {
  font-size:12px;
}

.profile-graph-mens{
  font-size: 12px;
  margin-top: 10px;
}

@media (max-width: 640px){

  .left-profileuser{
    display:none;
  }

}

</style>
