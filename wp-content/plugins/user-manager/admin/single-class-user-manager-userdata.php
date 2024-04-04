<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class User_Manager_UserData {

	
	private $form;
	
	private $section;
	
	private $userID;

	
	public function __construct( $form, $section = NULL ) {

		$this->form = $form;
		$this->section = $section;

	}
   
   //Function for displaying the inputs with the info of the userID.
   //Take into account that if the userData is not actual userData when this function is used with the hook add_signup_meta
   public function get_user_data_form($userData){
   		
   		
   		if(array_key_exists('ID',$userData)){
   			$userID = $userData->ID;//Then this function is being used with no user as parameter.
   			}else{
   			$userID = NULL;
   				} 
   		
   		//we get all the user metadata in a single array to save queries.
   		//if no user ID is provided => The user is not logged in or the array does not provide it=> eg. if used in the registration form, the empty form will be displayed.
   		if($userID != NULL){
   			$currentUserMetadata = get_user_meta($userID);
   			
   		  $currentUserMetadataArray = array_map( function( $a ){ return $a[0]; }, $currentUserMetadata );
   			}
   		else{
   				$currentUserMetadataArray = array("");
   			}
			
			//If this functioon is used in a registration form that has beeen posted but with errors... we will be displaying the previous values (they are posted)
			//We privilege $_POST over $currentUserMetadataArray.
			if (!empty($_POST))
				{
					$currentUserMetadataArray = array_merge($currentUserMetadataArray,$_POST);
					}
			
			//we put into nc_userdata all the inputs and labels of the current form in order to loop over them and generate the proper form.
			   		$nc_userdata = $this->get_user_inputs_labels_in_form_section();
			
	 foreach ( $nc_userdata as $question_user_data ) 
			{
				
				//if the type of record is just text:
				$title_labels = array('question','set-title');
				
				if(in_array($question_user_data->record_type,$title_labels)){
					    echo '<div class="row" id="w_'.$question_user_data->key.'">';
							echo '<div class="question-header">'.$question_user_data->es_ES.'</div>';
							continue;						
						}
				if($question_user_data->record_type == 'comun-question'){
							echo '<div class="comun-question">'.$question_user_data->es_ES.'</div>';					
					}		
						
						
				//We check if the $question_user_data->user_data_key is in the current user metadata array if not=>''.
					if(array_key_exists ($question_user_data->user_data_key,$currentUserMetadataArray)){
						$userMetaValue = $currentUserMetadataArray[$question_user_data->user_data_key];
						}else{
							$userMetaValue ='';
							
							}
						
				
	  	switch ($question_user_data->input_type){
							//si es un input	  	
	  	case 'input':
	  	
	  	  				echo '<div class="row" id="w_'.$question_user_data->key.'">';
	  	  				echo '<label>'.$question_user_data->es_ES.'</label>';
	  						echo '<input type="text" name="'.$question_user_data->user_data_key.'" value="'.$userMetaValue.'" />';
	  						echo '</div>';
	  			
	  			if($question_user_data->record_type == 'value_st_last'){
	  				//Closing the div opened in the set-title
	  				echo '</div>';
	  				}
	  						
	  				break;
	  	case 'radio':
	  	

	  				  echo '<label>'.$question_user_data->es_ES.'</label>';
	  					echo '<input type="radio" name="'.$question_user_data->user_data_key.'" value="'.$question_user_data->user_data_key_value.'" '.checked($question_user_data->user_data_key_value,$userMetaValue,false).' />';									
	  					  					  				
	  			if($question_user_data->record_type == 'result_last_radio'){
						//Closing the div opened in the question.
	  				echo '</div>';
	  				}	  
	  	break;
	  	
	  	
	  	
	  	} 
	
	
}
   	}
	
		//Function for saving/updating the metadata of a form-section.
		//This is for wp-signup => so they should be core values
		public function save_register_user_data_form($user){
		
			global $wpdb;
			
			$nc_register_meta = array();
		
			$nc_user_fields = $this->get_user_fields_in_form_Section();
		
			foreach($nc_user_fields as $user_field){
					//update_usermeta( $userID, $user_field, $_POST[$user_field] );
					 if ( isset( $_POST[$user_field] ) ) {
							//$user[$user_field]=$_POST[$user_field];
							$nc_register_meta[$user_field] = $_POST[$user_field];
					}
				}
			$user['nc_register_meta'] = $nc_register_meta;
			
		
		
		return $user;
		
		} 

		//Function for saving/updating the metadata of a form-section.
		public function save_update_user_data_form($userID){
		
			global $wpdb;
			
			echo 'save_update_user_data_form ejecutada';
			
			
			if($this->section != NULL){
   				$condSection = "and section='".$this->section."'";
   			}else{
   				$condSection ='';
   				}
			
			
			$nc_user_fields = $wpdb->get_col(
																						"SELECT `user_data_key` 
																						 FROM  nc_userdata
																										where `form` = '".$this->form."'
																												and `user_data_key` !=''
																												".$condSection."
    																										group by `form`,`section`,`user_data_key`"
																						);
		
			
		
			foreach($nc_user_fields as $user_field){
				if ( isset( $_POST[$user_field] ) ) {
					update_user_meta( $userID, $user_field, $_POST[$user_field] );
					}
				}
		
	
		
		}
		
		//function for updating the user_metadata with the signup keys added in the registration
		public function custom_register_new_user_meta(  $user_id, $email, $meta ) {

			if ( count($meta['nc_register_meta']) ) {
						// loop through array of custom meta fields
						foreach ( $meta['nc_register_meta'] as $key => $value ) {
						// and set each one as a meta field
						update_user_meta( $user_id, $key, $value );
						}
			}

		}
		
		
		
		

		//function for getting the user fields of this instance (this->form,this->section)
		private function get_user_fields_in_form_Section(){
				global $wpdb;
				
				if($this->section != NULL){
   				$condSection = "and section='".$this->section."'";
   			}else{
   				$condSection ='';
   				}
			
			
			$nc_user_fields = $wpdb->get_col(
																						"SELECT `user_data_key` 
																						 FROM  nc_userdata
																										where `form` = '".$this->form."'
																												and `user_data_key` !=''
																												".$condSection."
    																										group by `form`,`section`,`user_data_key`"
																						);
			  //echo $nc_user_fields;
				return $nc_user_fields;
			}

		//function for getting all the user_inputs (and titles) within the form.
		private function get_user_inputs_labels_in_form_section(){
		  
		  global $wpdb;
		  
		  $condSection = '';
   		
   		if($this->section != ''){
   			$condSection = "and section='".$this->section."'";
   			}
   		
   		$form_user_data_query = "	SELECT `id`,`form`,`section`,`category`,`html_info`,`input_type`,`record_type`,
																									 `key`,`parent`,`condition`,`user_data_key`,`user_data_key_value`,`relevance`,`es_ES` 
																						FROM nc_userdata
																									WHERE form = '".$this->form."'
																									".$condSection." ";
   		
   		$nc_userdata = $wpdb->get_results($form_user_data_query);
   		
   		return $nc_userdata;
   	}
   		

}
