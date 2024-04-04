<?php



add_shortcode( 'selecttest', 'uda_selecttest' );

function uda_selecttest($test_to_display = null){
  if((is_user_logged_in()) && (in_array(get_locale(),array('es_ES','es_MX','es_CL','es_CO'))) ){
  	 	$cUserId = get_current_user_id();
  	 	$userType = get_user_meta($cUserId,'ncusertype',TRUE);
  	 	$userSx = get_user_meta($cUserId,'p_sxInteres',TRUE);

      //
      if(in_array(get_locale(),array('es_ES','es_MX','es_CL','es_CO'))){
        $tests = array(
                        'p_sxInteres_Cat'=> 13886,//'1',
                        'p_sxInteres_Cle'=> 13887,//'2',
                        'p_sxInteres_Icl'=> 13674//'3'
                  );

      if(array_key_exists($userSx,$tests)){
        //return do_shortcode('[mlw_quizmaster quiz='.$tests[$userSx].']');
        return '<div class="linkToIolTest"><a href="'.get_permalink($tests[$userSx]).'">'.get_the_title($tests[$userSx]).'</a></div>';
      }else{
          return _x('En este momento, no disponemos de ningún test que le sea de utilidad de acuerdo a la información que nos ha aportado','user-tests-knowledge','user-analysis');
      }
      }
    }

}
 ?>
