<?php


//$userArgs

$fieldNumber = count($user_data_keys);


	  	echo 	  '<table class="widefat fixed" cellspacing="0">
    							<thead>
    									<tr>
            							<th id="user-name" class="manage-column column-columnname" scope="col">Form key</th>';
            						
            							for($i=0;$i < $fieldNumber;$i++){
            								echo '<th id="user-value'.$i.'" class="manage-column column-columnname" scope="col">'.$user_data_keys[$i].'</th>';
            								}
            							
           	 							
				echo '</tr></thead><tfoot><tr>';

				echo '<th class="manage-column column-columnname" scope="col"></th>';
            							for($i=0;$i < $fieldNumber;$i++){
            								echo '<th class="manage-column column-columnname" scope="col"></th>';
            								}            
				echo '</tr></tfoot><tbody>';
				
				
				
				foreach($userFilledFields as $user){
				
								echo '<tr class="alternate">';
								//En el primer campo va el link para sacar toda la info almacenada del usuario
								
								$fullUserInfo = admin_url( 'users.php?page=user-manager-show-user-data&user-id-to-be-displayed='.$user->id );
								echo '<td class="column-columnname"><a target="_blank" href="'.$fullUserInfo.'">'.$user->user_login.'</a></td>';//get_user_meta($user->id,'user_login',true)
								
										for($i=0;$i < $fieldNumber;$i++){
            								echo '<th id="user-value'.$i.'" class="manage-column column-columnname" scope="col">'.get_user_meta($user->id,$user_data_keys[$i],true).' : '._x(get_user_meta($user->id,$user_data_keys[$i],true),'user_manager','user-manager').'</th>';
            				}
				
								echo '</tr>';
				}
				
				
    
?>