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


 /*-- https://codex.wordpress.org/Creating_Options_Pages --*/

class User_Manager_Show_User_Data {

   /**
   * Holds the values to be used in the fields callbacks
   */
    //private $options;


	public function __construct( ) {

        //add_action( 'admin_menu', array( $this, 'add_user_manager_settings_page' ) ); //add_plugin_page
        //add_action( 'admin_init', array( $this, 'user_manager_settings_page_init' ) ); //page_init

	}


	    /**
     * Add options page
     */
    public function add_user_manager_show_user_data_page() //add_plugin_page()
    {
        // This page will be under "User Menu"

        add_users_page('User Manager-Show User Data',
        								'View Full User Data',
        								'manage_options',
        								'user-manager-show-user-data',
        								array( $this,'create_user_manager_show_user_data_page'));


    }

    public function add_user_manager_show_users_data_with_form_filled(){

    	   add_users_page('User Manager-View UsersData with Filled Forms',
        								'View Users-Filled Forms',
        								'manage_options',
        								'user-manager-view-users-filled-forms',
        								array( $this,'create_user_manager_show_users_data_with_form_filled_page'));


    	}


		/*Función para mostrar todos los datos relevantes del usuario*/
	  public function show_relevant_user_data($userId,$forms_sections,$lang){

	  	$labels_and_metas = $this->get_user_label_and_meta_in_form_sections($forms_sections,$lang);



	  	echo 	  '<table class="widefat fixed" cellspacing="0">
    							<thead>
    									<tr>
            							<th id="form-header" class="manage-column column-columnname" scope="col">Form key</th>
           	 							<th id="section-header" class="manage-column column-columnname" scope="col">Section key</th>
            							<th id="label-header" class="manage-column column-columnname" scope="col">Label del Metadato</th>
            							<th id="value-key" class="manage-column column-columnname" scope="col">key del MetadataValue</th>
           								<th id="value-text" class="manage-column column-columnname" scope="col">Label del metadato</th>
								     </tr>
    							</thead>
    							<tfoot>
									   <tr>

							            <th class="manage-column column-columnname" scope="col"></th>
            							<th class="manage-column column-columnname" scope="col"></th>
            							<th class="manage-column column-columnname scope="col"></th>
            							<th class="manage-column column-columnname scope="col"></th>
    								</tr>
    							</tfoot>

	    					<tbody>';



	  	foreach($labels_and_metas as $label_meta){

	  		$valueMeta = get_user_meta($userId,$label_meta->user_data_key,true);

	  		if($valueMeta && ($valueMeta != '')){
	  					echo '<tr class="alternate">';
	  					echo '<td class="column-columnname">'.$label_meta->form.'</td>';
	  					echo '<td class="column-columnname">'.$label_meta->section.'</td>';

	  					//Si es la respuesta a una pregunta el valor que importa es el del  padre.
	  					if($label_meta->pregunta != ''){
	  					echo '<td class="column-columnname">'._x($label_meta->pregunta,'user_manager','user-manager').'</td>';
	  					}else{
	  						echo '<td class="column-columnname">'.$label_meta->label.'</td>';
	  						}




	  					echo '<td class="column-columnname">'.$valueMeta.'</td>';
	  					echo '<td class="column-columnname">'._x($valueMeta,'user_manager','user-manager').'</td>';

	  					echo '</tr>';
	  				}
	  		}

	  	  echo  '</tbody></table>';


	  	}

	  		//we are going to create a function to get whatever cumulative info from the form table.
		private function get_user_label_and_meta_in_form_sections($forms_sections,$lang){
				global $wpdb;

				$nc_form_section_fields = array();
			if(count($forms_sections)){



			foreach($forms_sections as $form_section){

				if($form_section['section'] != NULL){
   				$condSection = "and section='".$form_section['section']."'";
   			}else{
   				$condSection ='';
   				}


			$nc_form_section_fields_temp = $wpdb->get_results(
																						"SELECT `form`,`section`,`parent` as pregunta,`".$lang."` as label,`user_data_key`
																						 FROM  nc_userdata
																										where `form` = '".$form_section['form']."'
																												and `user_data_key` !=''
																												".$condSection."
    																										group by `form`,`section`,`user_data_key`
    																										order by `id`"
																						);

			$nc_form_section_fields = array_merge($nc_form_section_fields,$nc_form_section_fields_temp);
							}
			}

				return $nc_form_section_fields;
			}




	    /**
     * Options page callback
     */
    public function create_user_manager_show_user_data_page() //create_admin_page()
    {

        //INI

        echo '<br />';
				echo '<h3>Seleccione a continuación los datos que desea visualizar:</h3>';

				echo '<form action="" method="POST">';

				echo '<div class="admin-input-wrapper" style="height:40px;">';
				echo '<label for="user-id-to-be-displayed">Id del usuario cuya información desea ver: &nbsp;&nbsp;</label>';
				echo '<input type="text" name="user-id-to-be-displayed" /><br />';
				echo '</div>';

        echo '<div class="admin-input-wrapper" style="height:40px;">';
				echo '<label for="user-name-to-be-displayed">Nombre del usuario cuya información desea ver: &nbsp;&nbsp;</label>';
				echo '<input type="text" name="user-name-to-be-displayed" /><br />';
				echo '</div>';


				echo '<div class="admin-input-wrapper" style="height:40px;">';
				echo '<label name="form-section-to-display">Introduzca si lo desea (si no, saldrán todos) los formularios específicos que desea ver: &nbsp;&nbsp;</label>';
				echo '<input type="text" name="form-section-to-display"/>';
				echo '</div>';
				echo '<input type="submit" value="View User Data">';

				echo '</form>';


				if ( ! empty( $_POST ) ) {

	if(isset($_POST['user-id-to-be-displayed']) || isset($_POST['user-name-to-be-displayed']) ){


    if($_POST['user-id-to-be-displayed']!= '' ){
           $userDataID =  $_POST['user-id-to-be-displayed'];
    }

    if($_POST['user-name-to-be-displayed'] != ''){
      $userNameEntered = $_POST['user-name-to-be-displayed'];
      $userRequested =  get_user_by('login',$userNameEntered);
      $userDataID =  $userRequested->ID;
      if(!$userRequested){
        $userRequested = get_user_by( 'display_name',$userNameEntered);//display_name
        $userDataID = $userRequested->ID;
/*echo '1';
        var_dump($userRequested );*/
          if(!$userRequested){
            $userRequested = get_user_by( 'user_nicename',$userNameEntered);//display_name
            $userDataID = $userRequested->ID;
/*echo '2';
            var_dump($userRequested );*/
          }


      }
    }


		$user_manager_option = get_option( 'user_manager_option_name' );

		if(isset($_POST['form-section-to-display'])&&($_POST['form-section-to-display'] != '')){
			$forms_sections =  json_decode( stripslashes($_POST['form-section-to-display']), true);

			}else{
		$forms_sections =  json_decode($user_manager_option['all_user_forms_sections_name_json'],true);
		}
		$lang = 'es_ES';

		echo '<br /><h3>Viendo los datos del usuario: '.get_user_meta($userDataID,'nickname',true).'</h3><br/>';

		$this->show_relevant_user_data($userDataID,$forms_sections,$lang);
		}


				}

				//Vamos a replicar lo mismo para poder hacerlo sin el post sino coon el get.
				if ( isset($_GET['user-id-to-be-displayed']) ) {

	 //Replica para GET

	 	$userDataID =  $_GET['user-id-to-be-displayed'];
		$user_manager_option = get_option( 'user_manager_option_name' );

		if(isset($_POST['form-section-to-display'])&&($_GET['form-section-to-display'] != '')){
			$forms_sections =  json_decode( stripslashes($_GET['form-section-to-display']), true);

			}else{
		$forms_sections =  json_decode($user_manager_option['all_user_forms_sections_name_json'],true);
		}
		$lang = 'es_ES';

		echo '<br /><h3>Viendo los datos del usuario: '.get_user_meta($userDataID,'nickname',true).'</h3><br/>';

		$this->show_relevant_user_data($userDataID,$forms_sections,$lang);

	 //Fin replica para GET

				}


        //FIN


    }

		public function create_user_manager_show_users_data_with_form_filled_page(){

			  global $wpdb;
			        //INI
			  $formsToBeViewedDefault = array('addProfileBasicData','addProfProfileBasicData','addPatProfileBasicData','qpls','prols');

			  $queryGetForms = 'SELECT DISTINCT form FROM `nc_userdata` WHERE 1';

			  $formsToBeViewed = $wpdb->get_col($queryGetForms);

			  if(!$formsToBeViewed){
			  		$formsToBeViewed = $formsToBeViewedDefault;
			  	}

        echo '<br />';
				echo '<h3>Seleccione a continuación los formularios que desea visualizar:</h3>';

				echo '<form action="" method="POST">';

				echo '<div class="admin-input-wrapper" style="height:40px;">';

				echo '<label for="formsusers-to-be-viewed">Formulario cuyos usuarios desea ver: &nbsp;&nbsp;</label>';
				echo '<select name="formsusers-to-be-viewed">';



				foreach($formsToBeViewed as $formToBeViewed){

					echo '<option '.selected($_POST["formsusers-to-be-viewed"],$formToBeViewed).' value="'.$formToBeViewed.'">'.$formToBeViewed.'</option>';

					}
				echo '</select>';

				echo '</div>';


			//INI Field Forms

				echo '<div class="select-fields-wrapper">';

				$formsAndKeys = array();
				$arrayFormKeys = array();


				foreach($formsToBeViewed as $form){

				$queryGetKeysForm = 'select t1.user_data_key, case when t2.'.get_locale().'=\'\' then \'Tiempo Relleno\' else t2.'.get_locale().' end as '.get_locale().' from (SELECT user_data_key, CASE  when `parent` =  \'\' then `key` else `parent` END AS parent FROM `nc_userdata` where `form` = "'.$form.'" and user_data_key != \'\'  group by user_data_key, parent ) t1 left outer JOIN `nc_userdata` t2 on t1.parent = t2.key';

				$arrayFormKeys = $wpdb->get_results($queryGetKeysForm,ARRAY_A);

				$formsAndKeys[$form] = $arrayFormKeys;

				}

				echo '<script>
											jQuery(document).ready(function(){
												var activeForm = jQuery(\'select[name="formsusers-to-be-viewed"]\').val();
												jQuery(\'select[data-secondlevel="yes"],input[data-secondlevel="yes"]\').attr("disabled","true");
												jQuery(\'div[data-formsecondlevel="yes"]\').hide();
												jQuery(\'select[data-form="\'+activeForm+\'"],input[data-form="\'+activeForm+\'"]\').removeAttr("disabled");
												jQuery(\'div[data-formwrapper="\'+activeForm+\'"]\').show();
													}
												);

											jQuery(\'select[name="formsusers-to-be-viewed"]\').on(\'change\',function(){
												var activeForm = jQuery(this).val();
												jQuery(\'select[data-secondlevel="yes"],input[data-secondlevel="yes"]\').attr("disabled","true");
												jQuery(\'div[data-formsecondlevel="yes"]\').hide();
												jQuery(\'select[data-form="\'+activeForm+\'"],input[data-form="\'+activeForm+\'"]\').removeAttr("disabled");
												jQuery(\'div[data-formwrapper="\'+activeForm+\'"]\').show();
												}
					);</script>	';

//Loopeamos sobre cada form y creamos tres selects con los user_data_keys.

				$auxCount = 0;
				foreach($formsAndKeys as $formUserKeys){
							echo '<div data-formsecondlevel="yes" data-formwrapper="'.$formsToBeViewed[$auxCount].'">';
							for($i=1;$i < 4;$i++){
									echo '<div class="select-wrapper" style="max-width:75%;margin-top:10px;">';
									echo 'Campo de filtrado Numº'.$i.' del formulario '.$formsToBeViewed[$auxCount].'<br/>';
									echo '<select style="max-width:90%;" name="user_data_key_'.$formsToBeViewed[$auxCount].'_'.$i.'" data-secondlevel="yes" data-form="'.$formsToBeViewed[$auxCount].'">';
									echo '<option value> -- select an option -- </option>';
									foreach($formUserKeys as $user_data){
													$postVar = 'user_data_key_'.$formsToBeViewed[$auxCount].'_'.$i.'';
													$selected = selected($_POST[$postVar], $user_data['user_data_key']);

									echo '<option style="max-width:90%;" '.$selected.' value="'.$user_data["user_data_key"].'">'._x($user_data[get_locale()],'user_manager','user-manager').'</option>';
									}
									echo '</select>';
									//Vamos a meter la opción de que se puedan meter inptus específicos.
									$stringSpecificValStringName = 'user_data_value-'.$formsToBeViewed[$auxCount].'_'.$i;
									echo '<div class="specifi-value-wrapper" style="margin-top:5px;margin-bottom:15px;">';
									echo '<label for="user_data_value-'.$user_data["user_data_key"].'"> Introduzca si lo desea un valor específico:&nbsp;&nbsp;</label>';
									echo '<input type="text" data-secondlevel="yes"  data-form="'.$formsToBeViewed[$auxCount].'" name="'.$stringSpecificValStringName.'" value="'.$_POST[$stringSpecificValStringName].'" /> Corresponde a: '._x($_POST[$stringSpecificValStringName],'user_manager','user-manager');
									echo '</div>';
									echo '</div>';

							}
							echo '</div>';

				$auxCount = 1+$auxCount;

				}
						echo '<br />';
						echo '</div>';



			//FIN forms



				echo '<input type="submit" value="View Users Data with Filled Forms">';

				echo '</form>';


			//Get the users based on the POST request

				$user_data_keys = array();
				$arrayCond = array();

				if ( ! empty( $_POST ) ) {

						if(isset($_POST['formsusers-to-be-viewed']) ){

						$formsToBeViewed =  $_POST['formsusers-to-be-viewed'];
						$lang = get_locale();


						echo '<br /><h3>Viendo los datos del formulario: '.$formsToBeViewed.'</h3><br/>';

							foreach($_POST as $name=>$value){

							if((strpos($name, 'user_data_key_') !== false) && ($value != '')){
									$user_data_keys[] = $value;
									$specificValue = '';
									//Tenemos  que añadir la  lógica  del valor específico=> Vamos a sacar el valor cuando pase el input name del select asociado.

//user_data_key_addProfileBasicData_1:country
//user_data_value-addProfileBasicData_1:df

									$specificRelated = str_replace('user_data_key_','user_data_value-',$name);


									if($_POST[$specificRelated] != ''){
										$specificValue = $_POST[$specificRelated];
									}else{
										$specificValue = '';
										}

									if($specificValue != ''){
											echo 'Condición aplicada';
											$arrayCond[] = array('key'=>$value,'value'=>$specificValue,'compare'=>'=');
											}
										else{
												$arrayCond[] = array('key'=>$value,'value'=>'','compare'=>'!=');
										}

								}



							}

					$argFilledFieldsUsers = array('meta_query'=>array($arrayCond));


					$userFilledFields = get_users($argFilledFieldsUsers);

					}
				}








			//Fin temp


			include('temp-file-output.php');


			}



public function show_clean_user_survey($userId,$forms_sections,$lang){

        $labels_and_metas = $this->get_user_label_and_meta_in_form_sections($forms_sections,$lang);

        echo 	  '<table class="widefat fixed surveys" cellspacing="0">
                    <thead>
                        <tr>
                            <th id="label-header" class="manage-column column-columnname" scope="col">Pregunta</th>
                            <th id="value-text" class="manage-column column-columnname" scope="col">Resupuesta</th>
                       </tr>
                    </thead>
                    <tfoot>
                       <tr>

                            <th class="manage-column column-columnname scope="col"></th>
                            <th class="manage-column column-columnname scope="col"></th>
                      </tr>
                    </tfoot>

                  <tbody>';



        foreach($labels_and_metas as $label_meta){

          $valueMeta = get_user_meta($userId,$label_meta->user_data_key,true);

          //var_dump($label_meta->user_data_key);

          $arrayKeyExclusionesNoMostrar = array('c_catq_timeDate','ncreg_catQ','ncreg_navq');//Son las user_data_keys
          $arrayRemoveFields = array('user_login','p_preOrPost','p_sxInteres');
          $arrayModificacionesIdNombre = array('post_modelIOL','post_clinicSx');
          $arrayModificacionesIdUser = array('post_surgeonSx');
          //
          if(in_array($label_meta->user_data_key,$arrayModificacionesIdNombre)){
            $valueMeta = get_the_title($valueMeta);
          }

          if(in_array($label_meta->user_data_key,$arrayRemoveFields)){
            $valueMeta = FALSE;
          }


          if(in_array($label_meta->user_data_key,$arrayModificacionesIdUser)){
            $valueMeta = 'Dr./a. '.get_user_meta($valueMeta,'first_name',true).' '.get_user_meta($valueMeta,'last_name',true);
          }

          //Modificamos los value meta si label_meta es lente o clinica.


          if(in_array($label_meta->user_data_key,$arrayKeyExclusionesNoMostrar)){
          //var_dump($label_meta);
          }


          if($valueMeta && ($valueMeta != '') && !(in_array($label_meta->user_data_key,$arrayKeyExclusionesNoMostrar))){

//Metemos aquí condicionantes y exclusiones para la visualización de encuestas.



                echo '<tr class="alternate">';
                //Si es la respuesta a una pregunta el valor que importa es el del  padre.
                if($label_meta->pregunta != ''){
                echo '<td class="column-columnname preg">'._x($label_meta->pregunta,'user_manager','user-manager').'</td>';
                }else{
                  echo '<td class="column-columnname">'.$label_meta->label.'</td>';
                  }
                echo '<td class="column-columnname">'._x($valueMeta,'user_manager','user-manager').'</td>';

                echo '</tr>';
              }
          }

          echo  '</tbody></table>';


        }






}
