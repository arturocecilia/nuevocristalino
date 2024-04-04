<?php
/*
 * Template Name: Template Clinicas Lentes Intraoculares
 * Description: Este es el template para las páginas de mis ojos.
 */

get_header(); ?>

	<div id="primary" class="site-content-clinicas">
		<div id="content" role="main" class="template-clinicas">
            
            <!-- Div auxiliar para detectar clinicaWitouthVTypeTemplate-->



			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php //comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

            <!-- Metemos aquí la parte de las clínicas con Geolocation-->
            
            <div id="divContenedor">
            <div id="divInfo">
				
                <div class="entry-clinicMap"><?php echo _x('Clínicas oftalmológicas para cirugía intraocular en España y Andorra:', 'Template Clinicas Lentes Intraoculares','iol_theme');?></div>
                
                <!-- Ini geolocationEntry -->	
				<div class="geolocationEntry">
					<!-- Ini geoExplanation Set -->
					<div class="geoExplanation">
						<!-- Inicio Button DetectarUbicación -->
						<div class="buttonGeolocation">
						<button id="geoButton"><?php echo _x('Detectar ubicación', 'Template Clinicas Lentes Intraoculares','iol_theme');?></button>
						</div>
						<!-- Fin Button DetectarUbicación -->						
						<!-- Ini Button Ubicar -->
						<div class="stringGeoLocation">
							<input type="text" id="direccion" />
							<button id="triggerUbicacion"><?php echo _x('Ubicarme', 'Template Clinicas Lentes Intraoculares','iol_theme');?></button>
						</div>
						<!-- Fin Ubicar -->
                        <div class="left-info-entry">
				
						<!-- Inicio geoButtons -->
                        <div class="geoButtons">
                            <label class="geoLabel"><?php echo _x('Máxima distancia:', 'Template Clinicas Lentes Intraoculares','iol_theme');?></label>
                            <!-- Aquí irá un combobox con un abanico de distancias-->
                              <div class="ui-widget startsUgly" id="comboDistanceToClinic">
                              
                                <?php
                                //Vamos a ver si traemos el parámetro vía GET...
                                if (array_key_exists('distanceToClinic',$_GET)){
                                        $Result_distanceToClinic = $_GET["distanceToClinic"];
                                        }
                                    else{
                                         //Aquí ponemos el número de elementos mostrados por defecto.
                                        $Result_distanceToClinic = 1550;//Lo cambiamos desde 1500 para poder identificar que no se ha especificado distancia,
                                        //esto es, que es la primera vez que se descarga la página.
                                        }
                                ?>
                              
                                <select id="comboboxDistanceToClinic" name="distanceToClinic">
                                    <?php     
                                        //Vamos a darle a elegir entre las siguientes distancias:
                                        $distanceToClinicList = array(1,3,5,6,10,25,50, 75,100,150,200,1000, 1500);
    
                                        foreach ($distanceToClinicList as $distance ) {
                                           if($distance == $Result_distanceToClinic)
                                            {
                                             echo '<option selected="selected" value = "' . $distance . '">' . $distance . ' Km </option>';   
                                            }
                                            else{
                                            echo '<option value = "' . $distance . '">' . $distance . ' Km </option>';                  
                                            }
                                        }    
                                    ?>
                                </select>
                            </div>
					</div>
					<!-- Fin geoExplanation Set -->
					<div style="clear:both; display:none;">&nbsp;</div>
				</div>
				<!-- Fin geolocationEntry -->					
						<!-- Fin del combobox abanico de distancias-->
					</div>					
					<!-- Fin geoButtons -->

					
					</div>
							
            </div>

					<!-- Inicio de Info sobre Geolocalización -->	
				    <div class="userGeoInfo">
				    <span class="geoMainTitle"><?php echo _x('Mostrando', 'Template Clinicas Lentes Intraoculares','iol_theme');?> </span>
					<span id="userGeoInfoSpanTitle"><?php echo _x('ubicación seleccionada:', 'Template Clinicas Lentes Intraoculares','iol_theme');?></span>
					<span id="userGeoInfoSpanValue">&nbsp;</span>
					<span id="distanceTitle">&nbsp;<?php echo _x('Distancia:', 'Template Clinicas Lentes Intraoculares','iol_theme');?> </span>
					<span id="distanceValue">&nbsp;</span>
					<span class="distUnit"><?php echo _x('km', 'Template Clinicas Lentes Intraoculares','iol_theme');?></span>
					<!-- <span id="userGeoLatLng"></span> -->
					</div>
					<!-- Fin sobre info de geolocalización -->
                    
                    <div id="showAll">
  						<button id="showAllButton"><?php echo _x('Mostrar Todas', 'Template Clinicas Lentes Intraoculares','iol_theme');?></button>
  					</div>
					<!-- Div para evitar efecto extraño en descarga -->
					<div style="clear:both;height:0px;">&nbsp;</div>
            <div id="divMapa"> &nbsp;</div>
            <!-- <div id="divCoordenadas"> &nbsp;</div> -->
			
			
				<div style="clear:both;display:none;">&nbsp;</div>
        </div>
				<div style="clear:both;display:none;">&nbsp;</div>
            
            <!-- Fin de parte de clínicas con Geolocation -->
			<!-- Ini Clinic List -->
			<div class="clinicListsWrapper">
				<div id="geoSelectedListWrapper">
                	<h3><?php echo _x('Clinicas dentro de la distancia seleccinada', 'Template Clinicas Lentes Intraoculares','iol_theme');?></h3>
                	<div class="geoSelectedList"></div>
                </div>
                <div id="sponsoredListWrapper">
                	<h3><?php echo _x('Clinicas más visitadas', 'Template Clinicas Lentes Intraoculares','iol_theme');?></h3>
                    <div class="sponsoredList">
                                        <?php 
                    
                       $args = array('post_type'=>_x('clinica','CustomPostType Name','clinica'),
                            'post_status' => 'publish',
                            'showposts'=>5,
                            'orderby'=> 'nivel-pref-clinica',
                            'order'=>'ASC',
                            'orderby' => 'meta_value_num',
                            'post_parent' => '0',
                            'meta_key' => 'nivelPrefClinicaMD',
                            'order' =>'DESC'); //
                                 
                       $sponsoredClinics = new WP_Query( $args );
                    //Pasamos a generar la ul list.   
                       echo '<ul>';
                    
                        if ( $sponsoredClinics->have_posts() ) {
                            while ( $sponsoredClinics->have_posts() ) {
                                $sponsoredClinics->the_post(); 
                                
                                // Post Content here
                                echo '<li> <a href="'.get_permalink().'">'.get_the_title().'</a></li>';
                                
                                //
                            } // end while
                        } // end if
                        echo '</ul>';
                    ?>
                    </div>
                </div>
<div style="clear:both;display:none;">&nbsp;</div>
			</div>
			<!-- Fin ClinicListWrapper -->
<div style="clear:both;display:none;">&nbsp;</div>
                  
        <div class="moreClinics"><a href="<?php echo get_post_type_archive_link(_x('clinica','CustomPostType Name','clinica'));?>"><?php echo _x('Ver más Clínicas', 'Template Clinicas Lentes Intraoculares','iol_theme');?> >></a></div>

		</div><!-- #content -->
	</div><!-- #primary -->
    
    <!-- <div id="filtros-clinicas"> -->
    
     <?php 
            //Lo incluiremos desde la carpeta de plugins

            //include( 'clinicaPluginTemplates/OLD_right-archive-clinica.php');
         
             include( ABSPATH . 'wp-content/plugins/clinica/right-archive-clinica.php');
         
     ?>


    <!-- </div> -->

      <!-- Utilizaremos estos divs auxiliares. El primero como contenedor de información y evitar así tener strings a ser localizadas en el js. -->
      <!-- El segundo para identificar unívocamente el template -->
      <div id="archiveClinicaUrl" style="display:none;"><?php echo get_post_type_archive_link(_x('clinica','CustomPostType Name','clinica')) ?></div>
      <div id="clinicasIolUrl" style="display:none;">&nbsp;</div>
	  <!-- A continuacion la referencia la icono de loading -->
	  <div id="loadingGif" style="display:none;">
            <div id="loaderDiv">
                <img src="<?php echo get_bloginfo('stylesheet_directory')."/images/ajax-loader.gif"; ?>" alt="ajax-loader" />
            </div>
      </div> 

<?php //get_sidebar(); ?>
<?php get_footer(); ?>