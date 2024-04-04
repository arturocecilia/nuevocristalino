<?php
/*
 * Template Name: Template Update Clinical Info
 * Description: Este es el template para las páginas que no tienen menús
 */

get_header(); ?>

	<div id="primary" class="site-process-customuser"> <!-- primary-quienes lo dejamos en primary-->
        <div id="content" role="main">
	            
<?php 
	
	//Ponemos la lógica del procesamiento de datos y mandaremos vía url un mensaje con la info sobre el proceso que se ha hecho.
	
	 $current_user = wp_get_current_user();
    /**
     * @example Safe usage: $current_user = wp_get_current_user();
     * if ( !($current_user instanceof WP_User) )
     *     return;
     */
   
   /* echo 'Username: ' . $current_user->user_login . '<br />';
    echo 'User email: ' . $current_user->user_email . '<br />';
    echo 'User first name: ' . $current_user->user_firstname . '<br />';
    echo 'User last name: ' . $current_user->user_lastname . '<br />';
    echo 'User display name: ' . $current_user->display_name . '<br />';
    echo 'User ID: ' . $current_user->ID . '<br />';
    */
    
    
    //Vamos a utilizar la misma url para procesar los formularios pre y post op.
    
    //Aquí procesamos el preop.
    if(isset($_POST['formpre'])){
    
    /*-- Las Variables --*/
    $preOpvars = array(	
							'preedad',
							'presexo',
							'presintvis',
							'prehenfocu',
							'preprococu',
							'premedocu',
							'prehistmedsis',
							'premedsis',
							'preantfami',
							'prestatpsi',
							'prelifestyle',
							'pregrad',
							'prendepsx',
							'prendepgl',
							'prendepgc',
							'prendepgi',
							'preprefaceptg',
							'preprefacephalos',
							'preprefacepgpeq',
							'preprefacepgact',
							'prepersonalidad',
							'preaddcomments'
							);
	/*-- Necesitamos saber los defaults para ver estar seguros de que no ha metido nada --*/						
	
			$preOpUserVarTextDefaults  = array(
							'preedad'		=>	'',
							'presexo'		=>	'',
							'presintvis' 	=> 	'Descríbanos su visión',
							'prehenfocu'	=> 	'Escriba las enfermedades que ha sufrido en sus ojos.',
							'preprococu'	=>	'Escriba las operaciones de ojos a las que se ha sometido.',
							'premedocu'		=>	'Escriba las medicaciones oculares',
							'prehistmedsis'	=>	'Enfermedades del resto del cuerpo.',
							'premedsis'		=>	'Medicación tratamientos del resto del cuerpo',
							'preantfami'	=>	'Antecedentes de enfermedades familiares, oculares y no oculares',
							'prestatpsi'	=>	'Información sobre su carácter y estatus psicológico',
							'prelifestyle'	=>	'Información sobre su estilo de vida',
							'pregrad'		=>	'Escríbanos su graduación y la información de pruebas de la que disponga',
							'prendepsx'		=>	'',
							'prendepgl'		=>	'',
							'prendepgc'		=>	'',
							'prendepgi'		=>	'',
							'preprefaceptg'		=>	'',
							'preprefacephalos'		=>	'',
							'preprefacepgpeq'		=>	'',
							'preprefacepgact'		=>	'',
							'prepersonalidad'		=>	'',
							'preaddcomments'		=>	''
	
			
		);
	
	/*-- Primero registramos la variable de check si es que está indicada. Si la variable check ya está puesta--*/
							

	
	

	
	/*-- Recorremos las variables y si alguna está definida y no está vacía, rellenamos el  usermeta asociado --*/							
	
		$chequeo = get_user_meta( $current_user->ID ,'allok' , true) ? get_user_meta( $current_user->ID ,'allok' , true): FALSE;
	
	if(!$chequeo){
	    foreach($preOpvars as $key){
		
			if( isset($_POST[$key]) )
			{
				if(($_POST[$key] != $preOpUserVarTextDefaults[$key]) && ( $_POST[$key] != '' )){
					update_usermeta( $current_user->ID, $key, $_POST[$key] );
					//echo 'Metadato: '.$key.' actualizado. a valor:'.$_POST[$key].'<br />';
				}
			}				
		}
     }
		if(isset($_POST['allok'])){
			update_usermeta($current_user->ID, 'allok', 'ok' );	
			//echo 'Se han bloqueado los datos del usuario';
			
			}
							

    //Probamos con un display.
    
    foreach($preOpvars as $key){
		//$preOpUserVarValue[$key]	= 	get_user_meta($cuser_ID, $preOpvars[$key],true);	
		//$preOpUserVarText[$key] 	=	$preOpUserVarValue[$key] ? $preOpUserVarValue[$key]:  $preOpUserVarTextEmpty[$key];
		
		$currentUserData = esc_attr( get_user_meta( $current_user->ID, $key, true  ) );
		$msg = $currentUserData ? $currentUserData : 'No se ha definido';		
		//echo $preOpUserVarTextTitles[$key].' : '.$msg.'<br />';

		}
    
    
    //Hacemos la redirección a los datos del usuario.
    
    //Procesamos la variable botón desde la que se ha envíado y añadimos el hash correspondiente.
    $hash = '';
    
    if(isset($_POST['submitfullhist'])){
	    $hash = 'submitfullhist';
    }
    
    if(isset($_POST['smithist'])){
	    $hash = 'smithist';
    }
    
    if(isset($_POST['smitexplo'])){
	    $hash = 'smitexplo';
    }
    if(isset($_POST['smitexpect'])){
	    $hash = 'smitexpect';
    }
    
    
    
    $idPClinicalPre = get_permalink(10835).'#'.$hash;
   	wp_redirect($idPClinicalPre);
    
    }
	
	//Aquí procesamos el postop.
	if(isset($_POST['formpost'])){
		
		
		    /*-- Las Variables --*/
    $postOpvars = array(	
							'surgerytime',
							'surgeryeye',
							'surgeryiol',
							'ddriving',
							'ndriving',
							'ivision',
							'newspaper',
							'prices',
							'needle',
							'dglasses',
							'nglasses',
							'currentvision',
							'satiol',
							'age',
							'provincia',
							'clinic',
							'comments'
							);
	/*-- Necesitamos saber los defaults para ver estar seguros de que no ha metido nada --*/						
	
			$postOpUserVarTextDefaults  = array(
							'surgerytime'		=>	'',
							'surgeryeye'		=>	'',
							'surgeryiol'		=>	'',
							'ddriving'			=>	'',
							'ndriving'			=>	'',
							'ivision'			=>	'',
							'newspaper'			=>	'',
							'prices'			=>	'',
							'needle'			=>	'',
							'dglasses'			=>	'',
							'nglasses'			=>	'',
							'currentvision'		=>	'',
							'satiol'			=>	'',
							'age'				=>	'',
							'provincia'			=>	'',
							'clinic'			=>	'',
							'comments'			=>	''
			
		);
	
	/*-- Primero registramos la variable de check si es que está indicada. Si la variable check ya está puesta--*/
							

	
	

	
	/*-- Recorremos las variables y si alguna está definida y no está vacía, rellenamos el  usermeta asociado --*/							
	
		$chequeoPost = get_user_meta( $current_user->ID ,'allpostok' , true) ? get_user_meta( $current_user->ID ,'allpostok' , true): FALSE;
	
	if(!$chequeoPost){
	    foreach($postOpvars as $key){
		
			if( isset($_POST[$key]) )
			{
				if(($_POST[$key] != $postOpUserVarTextDefaults[$key]) && ( $_POST[$key] != '' )){
					update_usermeta( $current_user->ID, $key, $_POST[$key] );
					//echo 'Metadato: '.$key.' actualizado. a valor:'.$_POST[$key].'<br />';
				}
			}				
		}
     }
		if(isset($_POST['allpostok'])){
			update_usermeta($current_user->ID, 'allpostok', 'ok' );	
			//echo 'Se han bloqueado los datos del usuario';
			
			}
							

    //Probamos con un display.
    
   /* foreach($postOpvars as $key){
		$postOpUserVarValue[$key]	= 	get_user_meta($cuser_ID, $postOpvars[$key],true);	
		$postOpUserVarText[$key] 	=	$postOpUserVarValue[$key] ? $postOpUserVarValue[$key]:  $postOpUserVarTextEmpty[$key];
		
		$currentUserData = esc_attr( get_user_meta( $current_user->ID, $key, true  ) );
		$msg = $currentUserData ? $currentUserData : 'No se ha definido';		
		echo $postOpUserVarTextTitles[$key].' : '.$msg.'<br />';

		}*/
		
		
		
		
		
		    $idPClinicalPost = get_permalink(10854);//.'#'.$hash;
			wp_redirect($idPClinicalPost);
		
		
		
		
		
	}
	
	
?>	        
	        
	        
	        
	        
	        
	        

		</div><!-- #content -->

		<div id="rightcustomcontent">Parte de la derecha</div>


	</div><!-- #primary -->
	
	
	
	

<?php get_footer(); ?>