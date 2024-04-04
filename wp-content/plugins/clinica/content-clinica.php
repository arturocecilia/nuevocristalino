<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<!-- Div auxiliar para detectar que es el template del single clinica -->
	<div id="singleClinicTemplate" style="display:none;">&nbsp;</div>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="entry-header">
        <h1 class="entry-title" itemprop="name" ><?php the_title(); ?></h1>
        </div>
        <div id="volver">
        	<a href="<?php 
                        echo get_permalink( 404 );/*get_site_url().'/clinicas-lentes-intraoculares/';*/ 
                          ?>">
                                <?php echo _x('VOLVER A PÁGINA PRINCIPAL DE CLÍNICAS','Content Clinica','clinica_cpt_display'); ?> &gt; &gt;</a>
        </div>

        <div class="entry-content">
   			<?php echo '<div class="featured-image-content">'.get_the_post_thumbnail(get_the_ID(),'post-thumbnail', array('itemprop' => 'logo')).'</div>'; ?>
   			<?php //echo 'aquí meteremos el mapa con la geolocalización'; ?>
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
            
            <div style="clear:both;"></div>
            
            <!-- Si es un grupo con varias clínicas, y de la que se está haciendo el display es la padre hacemos una entradilla -->
            
            <?php 
            	//Sacamos si la clínica tiene padre.
            	$parent_Clinic = $post->post_parent;

                //Sacamos si la clínica tiene hijos.
                $args = array(
						'post_parent' => $post->ID,
						'post_type' => _x('clinica','CustomPostType Name','clinica'),
						);

				$child_Clinics = get_children( $args );
                
    			//Si es la padre vamos a cargar las coordenadas de las hijas en un json dentro de un div con display none.
    			$isParent = '';
			        			
    			if($child_Clinics){
    			$isParent = 'yes';
    			$cClinicCoords = array();
    			$count = 0;
    			foreach($child_Clinics as $cClinic){
    			//echo get_post_meta($cClinic->ID, 'latitudD');
    			//echo $cClinic->title;
    				$cClinicCoords[$count]['lat']  = $cClinic->latitudD;//get_post_meta($cClinic->ID, 'latitudD');
    				$cClinicCoords[$count]['long'] = $cClinic->longitudD;//get_post_meta($cClinic->ID, 'longitudD'); 
    				$cClinicCoords[$count]['name'] = get_the_title($cClinic->ID);//get_the_title($cClinic->ID);
    				$count += 1;
    			}
    			
    			echo '<div id="singleClinicCoordChilds" style="display:none;">'.json_encode($cClinicCoords).'</div>';
    			
				}
				// Vamos a dejar esto sin efecto por el momento... echo '<div class="introClinicParent">'._x('Información del Grupo:','clinica template','clinica').'</div>';
    
            ?>
            
            
            
            
            <div id="campos-clinicas">
        
        	<?php 
			//Dirección
			if (get_post_meta( $post->ID, 'direccionD',TRUE) && (get_post_meta( $post->ID, 'direccionD',TRUE) != '//') ){
				
				$direccionD = get_post_meta( $post->ID, 'direccionD',TRUE);
				echo'
					<div class="bloq-single-clinica">
						<div class="label-clinic">'._x("Dirección:","Content Clinica","clinica_cpt_display").'</div>
						<div class="value-clinic" itemprop="address">'.strip_tags($direccionD).'</div>
					</div>';
			}?>
            
            
                
            <?php 
			//Teléfono de contacto
			if ( get_post_meta( $post->ID, 'telfContactoD',TRUE) && (get_post_meta( $post->ID, 'telfContactoD',TRUE)!= '//') ){
				
				$telfContactoD = get_post_meta( $post->ID, 'telfContactoD',TRUE);
				echo'
					<div class="bloq-single-clinica">
						<div class="label-clinic">'._x("Telefóno de Contacto:","Content Clinica","clinica_cpt_display").'</div>
						<div class="value-clinic" itemprop = "telephone">'.strip_tags($telfContactoD).'</div>
					</div>';
			}?>
            
            <?php 
			//Email de contacto
			if (get_post_meta( $post->ID, 'emailContactoD',TRUE) && get_post_meta( $post->ID, 'emailContactoD',TRUE) != '//' ){
			    
			    $emailContactoD = get_post_meta( $post->ID, 'emailContactoD',TRUE);
				echo'
					<div class="bloq-single-clinica">
						<div class="label-clinic">'._x("Email de contacto:","Content Clinica","clinica_cpt_display").'</div>
						<div class="value-clinic">'.strip_tags($emailContactoD).'</div>
					</div>';
			}?>
            
            <?php 
			//Horario
			if ( get_post_meta( $post->ID, 'horarioD',TRUE) && (get_post_meta( $post->ID, 'horarioD',TRUE) != '//') ){
			
				$horarioD = get_post_meta( $post->ID, 'horarioD',TRUE);
				
				echo'
					<div class="bloq-single-clinica">
						<div class="label-clinic">'._x("Horario:","Content Clinica","clinica_cpt_display").'</div>
						<div class="value-clinic">'.strip_tags($horarioD).'</div>
					</div>';
			}?>
            
            <?php 
			//Director Médico
			if ( get_post_meta( $post->ID, 'directorMedicoD',TRUE) && (get_post_meta( $post->ID, 'directorMedicoD',TRUE)!= '//') ){
			
   			   $directorMedicoD = get_post_meta( $post->ID, 'directorMedicoD',TRUE);
				
				echo'
					<div class="bloq-single-clinica">
						<div class="label-clinic">'._x("Director Médico:","Content Clinica","clinica_cpt_display").'</div>
						<div class="value-clinic">'.strip_tags($directorMedicoD).'</div>
					</div>';
			}?>
            
            <?php 
			//Doctores
			if ( get_post_meta( $post->ID, 'doctoresD',TRUE) && (get_post_meta( $post->ID, 'doctoresD',TRUE)!= '//') ){
			
			    $doctoresD = get_post_meta( $post->ID, 'doctoresD',TRUE);
				
				echo'
					<div class="bloq-single-clinica">
						<div class="label-clinic">'._x("Doctores:","Content Clinica","clinica_cpt_display").'</div>
						<div class="value-clinic">'.strip_tags($doctoresD).'</div>
					</div>';
			}?>

            <?php 
			//Sitio Web
			if ( get_post_meta( $post->ID, 'webClinicD',TRUE) && (get_post_meta( $post->ID, 'webClinicD',TRUE)!= '//') ){
			
			    $webClinicD = get_post_meta( $post->ID, 'webClinicD',TRUE);
				
				echo'
					<div class="bloq-single-clinica">
						<div class="label-clinic">'._x("Sitio Web:","Content Clinica","clinica_cpt_display").'</div>
						<div class="value-clinic"><a style="text-decoration:none;" href="'.strip_tags($webClinicD).'">'.strip_tags($webClinicD).'</a></div>
					</div>';
			}?>



			
			<div style="clear:both;">&nbsp;</div>
			<!-- Fin de los campos de clínicas -->			
	        </div>
		
		<?php 
			// Vamos a mostrar sus clínicas hijas si es padre con un link a su single clinic.
			//La clínica o tiene padre o tiene hijos sólo hay dos niveles.
			//------------------------------------- //
			
			//Si la clínica tiene padre:
			if( $parent_Clinic ){
				echo '<div class="clinicParent">';
				echo '<div class="clinicParentTile">'._x('Este centro oftalmológico forma parte del grupo de clínicas','Content Clinica','clinica_cpt_display').'&nbsp;';
				echo '<a href="'.get_permalink( $parent_Clinic ).'">'.get_the_title($parent_Clinic).'</a>';
			 	echo '</div>';
				echo '</div>';
			}
			
			//Si la clínica tiene hijos:
			
			
			if($child_Clinics){
				echo '<div class="clinicChilds">';
				echo '<div class="clinicChildIntro" style="display:block;">'._x('Clínicas :','Content Clinica','clinica_cpt_display').' &nbsp;';
				echo '<ul class="estilada">';
				
		foreach($child_Clinics as $clinic){
			echo '<li class="childClinicTitle">';
			echo '<a href="'.get_permalink( $clinic ).'">'.get_the_title($clinic).'</a>';				
			echo '<div class="childClinicDirection">'.strip_tags(get_post_meta( $clinic->ID, 'direccionD',TRUE));
 			echo '&nbsp;&nbsp;-&nbsp;&nbsp;'.strip_tags(get_the_term_list( $clinic->ID, _x('ubicacion','taxo-name','clinica'))).'</div>';
 			echo '<div class="childClinicPhone">Telf:&nbsp;'.strip_tags(get_post_meta( $clinic->ID, 'telfContactoD',TRUE)).'</div>';
						
			echo '<div class="childClinicProvincia"></div>';
												
					echo '</li>';
				}
				echo '</ul>';

			 	echo '</div>';
				echo '</div>';
			}
			
			
			
       /* if(isset($kids) && !empty($kids) && count($kids) >= 1)
        {
            $parents[] = $single->ID;
        }*/
			
		?>
			
		<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
            

            
       <!-- Ini Map Set -->
       <div id="mapSet">     
            <div class="entry-clinicMap">
            <?php printf( _x("Vea&nbsp;%s &nbsp;en el mapa:",'Content Clinica','clinica_cpt_display'), get_the_title()) ; ?> 
            
            </div>
            
            <!-- Ini Inserción de botones para gestión de ubicación -->
      		<!-- Ini geolocationEntry -->	
				<div class="geolocationEntry">
					<!-- Ini geoExplanation Set -->
					<div class="geoExplanation">
						<!-- Inicio Button DetectarUbicación -->
						<div class="buttonGeolocation">
						<button id="geoButton"><?php  echo _x("Detectar ubicación","Content Clinica","clinica_cpt_display"); ?></button>
						</div>
						<!-- Fin Button DetectarUbicación -->						
						<!-- Ini Button Ubicar -->
						<div class="stringGeoLocation">
							<input type="text" id="direccion" />
							<button id="triggerUbicacion"><?php  echo _x("Ubicarme","Content Clinica","clinica_cpt_display"); ?></button>
						</div>
						<!-- Fin Ubicar -->
						
						<?php 
                    	 // Si es padre habrá varias clínicas y no mostraremos este botón
                        if($isParent != 'yes'){
                        	 echo '<div id="routeClinic">
                               <button id="routeToClinic">';
                        	 echo _x("Mostrar ruta a la clínica desde ubicación","Content Clinica","clinica_cpt_display");
                        	 echo  '</button>
                        		</div>';
                        }
                        ?>
					
					
					</div>
					<!-- Fin geoExplanation Set -->
					<div style="clear:both; display:none;">&nbsp;</div>
				</div>
				<!-- Fin geolocationEntry -->
      		<!-- Fin de Inserción de ubicación -->
            
				<div style="clear:both; display:none;">&nbsp;</div> 
				
					<!-- Inicio de Info sobre Geolocalización -->	
				    <div class="userGeoInfo">
				    <span class="geoMainTitle"><?php  echo _x("Mostrando:","Content Clinica","clinica_cpt_display"); ?></span>
					<span id="userGeoInfoSpanTitle"><?php  echo _x("Ubicación seleccionada:","Content Clinica","clinica_cpt_display"); ?></span>
					<span id="userGeoInfoSpanValue">&nbsp;</span>
					<span id="distanceTitle">&nbsp;<?php  echo _x("Distancia:","Content Clinica","clinica_cpt_display"); ?> </span>
					<span id="distanceValue">&nbsp;</span>
					<span class="distUnit"><?php  echo _x("km","Content Clinica","clinica_cpt_display"); ?></span>
                    
					<!-- <span id="userGeoLatLng"></span> -->
					</div>
					<!-- Fin sobre info de geolocalización -->	
                    <div id="buttonSingleClinic">
                        <button id="onlyClinic">
                            <?php echo _x("Mostrar clínica en mapa","Content Clinica","clinica_cpt_display"); ?>
                        </button>
            		</div>
				
				
				           
            <div id="divSingleClinicMapa">
            	Aquí va el gMaps con la clínica
            </div>
            
            <!-- Metemos el panel de direcciones-->
            <div id="directions-panel"></div>
            <!-- Fin del pannel de direcciones -->
            
			<div style="clear:both; display:none;">&nbsp;</div> 
      </div>
      <!-- Fin Map Set -->

      		
      		
      		<!-- <div id="map-canvas"></div>     
      		<div id="map-string"></div> -->
      		<div id="mapSeparator" style="height:75px;">&nbsp;</div>
        </div>
        
        
      
      
	</article><!-- #post -->
	

	<script>
		//La lógica es la siguiente2: si el nivel de preferencia es mayor que 2 se muestra un mapa con la ubicación de la clínica
		//como centro.
		//Si el nivel de preferencia es mayor que 3 se muestra el mapa y una opción que permita saber como se va a la clínica desde
		//la ubicación en la que se encuentra el usuario.
		
//		latitud: , longitud:

if(typeof(createClinicMap) == "function"){
		//Esta función muestra en divSingleClinicMapa	  
		createClinicMap(<?php echo get_post_meta( $post->ID, 'latitudD', TRUE ); ?>,
						<?php echo get_post_meta( $post->ID, 'longitudD', TRUE ); ?>, 
						"<?php echo $post->post_title;?>");
		//cambio
		jQuery('#onlyClinic').on("click",function(){
			createClinicMap(<?php echo get_post_meta( $post->ID, 'latitudD', TRUE ); ?>,
							<?php echo get_post_meta( $post->ID, 'longitudD', TRUE ); ?>, 
							"<?php echo $post->post_title;?>");
		});
		setClinicCoordsTitle(<?php echo get_post_meta( $post->ID, 'latitudD', TRUE ); ?>,
						<?php echo get_post_meta( $post->ID, 'longitudD', TRUE ); ?>,
						"<?php echo $post->post_title;?>");
		//Esta función ofrecerá mostrar el recorrido desde la ubicación del usuario.
		
		
		
		/*jQuery('#routeToClinic').on('click',function(){
				showRoute()
			});*/
		
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;

function initialize() {
  /*directionsDisplay = new google.maps.DirectionsRenderer();
  var chicago = new google.maps.LatLng(41.850033, -87.6500523);
  var mapOptions = {
    zoom:7,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    center: chicago
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  directionsDisplay.setMap(map);
  */
}


google.maps.event.addDomListener(window, 'load', initialize);
		
		}
		
	</script>
