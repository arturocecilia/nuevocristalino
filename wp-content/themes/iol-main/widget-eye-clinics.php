<?php 
	
	
	if(get_locale() == 'es_ES'){


			}
	
	if((get_locale() == 'es_ES')){ //&&(current_user_can('manage_options'))		
		$control = 1;
		$titleMainClinics = 'Clínicas especializadas:';
		$vv= 4029; //vallmedicvision
		$vlaser = 3961;//vistalaser
		$v10= 3963;//visiondiez
		//$eurocanarias = 8770;
		//$salva = 8780;
		
		$argsQueryClinicas = array(
									'post__in' => array($vv,$vlaser,$v10,$eurocanarias),//,$salva
									'post_type'=> _x('clinica','CustomPostType Name','clinica'),
									'orderby'   => 'meta_value_num',
									'meta_key'  => 'nivelPrefClinicaMD',
									'order'     => 'DESC'
									);

		}
	
	if($control){
		

		$queryClinicas = new WP_Query($argsQueryClinicas);
		//var_dump($queryClinicas);
	// The Loop
		if ( $queryClinicas->have_posts() ) {
			
			

			
			
			
			    echo '<aside id="mainClinics" class="mainClinics">';
				echo '<h3 class="widget-title clinicTitle">'.$titleMainClinics.'</h3>';
						echo '<div class="mainClinicWrapper">';
									
						while ( $queryClinicas->have_posts() ) {
								$queryClinicas->the_post();

			//En lugar del title voy a poner las localizaciones donde está la clínica.
			
			$ids = get_pages(array(
									'parent'=> get_the_ID(),
									'post_type'=> _x('clinica','CustomPostType Name','clinica')));
			
			if($ids){
				$clinicas = wp_list_pluck($ids,'ID');
			}else{
				$clinicas = array(get_the_ID());
			}
			$stringClinica = '';
			$aux = 0;
			if(count($clinicas) > 1){
			//Recorremos ahora el array de ids.
			foreach($clinicas as $IdClinica){
				
				$provClinica = wp_get_post_terms($IdClinica,_x('ubicacion','taxo-name','clinica'),array("fields" => "names"))[0];//,array("fields" => "names")		
				if($aux == 0){
					$stringClinica = '<a href="'.get_the_permalink($IdClinica).'">'.$provClinica.'</a>';
				}else{
					$stringClinica = $stringClinica.'&nbsp;-&nbsp;'.'<a href="'.get_the_permalink($IdClinica).'">'.$provClinica.'</a>';
				}
				$aux= $aux+1;
			}
			} else{
				$provClinica = wp_get_post_terms($clinicas[0],_x('ubicacion','taxo-name','clinica'),array("fields" => "names"))[0];//,array("fields" => "names")		
				$stringClinica = $stringClinica.'&nbsp;'.'<a href="'.get_the_permalink($clinicas[0]).'">'.$provClinica.'</a>';
			}



							echo '<div class="singleMainClinicLogo"><a href="'.get_the_permalink().'">'.get_the_post_thumbnail(get_the_ID(),'post-thumbnail').'</a></div>';
							
							echo '<div class="singleMainClinicTitle link">';
							echo '<a href="'.get_the_permalink().'">';
							 echo $stringClinica;
							echo '</a></div>';
							
							echo '<div class="endSingleMainClinic" style="height:25px;">&nbsp;</div>';
						    
									}
									
						echo '</div>';
							echo '</aside>';
					} else {
							// no posts found
							}
		
		}
?>