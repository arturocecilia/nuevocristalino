<?php
/*
 * Template Name: Template Buscador Clínicas
 * Description: Este es el template para las páginas de mis ojos.
 */

get_header('clinicas'); ?>

	<div id="primary" class="site-content-clinicas primary-buscador-clinicas">
		<div id="content" role="main" class="template-bucador-clinicas">

            <!-- Div auxiliar para detectar clinicaWitouthVTypeTemplate-->



			<?php while ( have_posts() ) : the_post(); ?>

							<h1 class="entry-title"><?php the_title();?></h1>

				<?php //the_content(); ?>

			<?php endwhile; // end of the loop. ?>

            <!-- Metemos aquí la parte de las clínicas con Geolocation-->

   <div id="titleWrapper">
	    <div id="titleBlue"><?php echo _x('Filtrado según distancia a una ubicación concreta:', 'template-buscador-clinicas','iol_last');?></div>
   		<div id="titleOrange"><?php echo _x('Filtrado según Lente y Comunidad:', 'template-buscador-clinicas','iol_last');?></div>
   </div>
   <div id="divContenedor">
            <div id="divInfo">

                <!-- Ini geolocationEntry -->
				<div class="geolocationEntry">
					<!-- Ini geoExplanation Set -->
					<div class="geoExplanation">
						<!-- Ini Button Ubicar -->
						<div class="stringGeoLocation">
							<input type="text" id="direccion" />
							<button id="triggerUbicacion"><?php echo _x('Ubicar la dirección introducida', 'template-buscador-clinicas','iol_last');?></button>
						</div>

						<div style="clear:both; height:0px;">&nbsp;</div>

							<!-- Inicio distance -->
                        <div class="geoButtons">
                            <label class="geoLabel"><?php echo _x('Máxima distancia a ubicación:', 'template-buscador-clinicas','iol_last');?></label>
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
                                        $distanceToClinicList = array(1000,1,3,5,6,10,25,50, 75,100,150,200, 1000, 1500);

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
					<!-- Fin distance -->







					    <!-- Inicio Button DetectarUbicación -->
						<div class="buttonGeolocation">
						<button id="geoButton"><?php echo _x('Detectar mi ubicación', 'template-buscador-clinicas','iol_last');?></button>
						</div>
						<!-- Fin Button DetectarUbicación -->

		<div style="clear:both; height:0px;">&nbsp;</div>


		<!-- Inicio de Info sobre Geolocalización -->
		<div class="userGeoInfo">
				    <span class="geoMainTitle">&nbsp;<?php echo _x('Mostrando', 'template-buscador-clinicas','iol_last');?>
					<?php echo _x('ubicación seleccionada:', 'template-buscador-clinicas','iol_last');?></span>
					<span class="userGeoInfoSpanValue">&nbsp;</span>
					<span class="distanceTitle">&nbsp;<?php echo _x('Distancia:', 'template-buscador-clinicas','iol_last');?> </span>
					<span class="distanceValue">&nbsp;</span>
					<span class="distUnit">&nbsp;<?php echo _x('km', 'template-buscador-clinicas','iol_last');?></span>
					<!-- <span id="userGeoLatLng"></span> -->
		</div>
					<!-- Fin sobre info de geolocalización -->




						<!-- Fin Ubicar -->
                        <div class="left-info-entry">


					<div style="clear:both; height:0px;">&nbsp;</div>
				</div>
				<!-- Fin geolocationEntry -->
						<!-- Fin del combobox abanico de distancias-->
					</div>
					<!-- Fin geoButtons -->


					</div>

            </div>



					<!-- Div para evitar efecto extraño en descarga -->
					<div style="clear:both;height:0px;">&nbsp;</div>

            <!-- <div id="divCoordenadas"> &nbsp;</div> -->


				<div style="clear:both;display:none;">&nbsp;</div>
       




<!-- cierre de contenedor -->
</div>
<!-- cierre de contenedor -->



<div id="divContenedorRight">
     <?php
            /*-- Modificaremos este filtrado--*/
             include( ABSPATH . 'wp-content/plugins/clinica/right-form-buscador-clinica.php');
     ?>
				<div style="clear:both; height:0px;">&nbsp;</div>
</div>

  <div id="showAll">
  	<button id="showAllButton"><?php echo _x('Mostrar Todas', 'template-buscador-clinicas','iol_last');?></button>
  </div>

					<div style="clear:both; height:0px;">&nbsp;</div>


            <div id="divMapa"> &nbsp;</div>


				<div style="clear:both;">&nbsp;</div>










            <!-- Fin de parte de clínicas con Geolocation -->
			<!-- Ini Clinic List -->

			<div class="clinicListsWrapper">
			<!--	<div id="geoSelectedListWrapper">
                	<h3><?php echo _x('Clinicas dentro de la distancia seleccinada', 'Template Clinicas Lentes Intraoculares','iol_theme');?></h3>
                	<div class="geoSelectedList"></div>
                </div>
            -->

                <div id="sponsoredListWrapper">
                	<h3><?php echo _x('Clinicas más visitadas', 'template-buscador-clinicas','iol_last');?></h3>
                    <div class="sponsoredList">
                                        <?php

                       $args = array('post_type'=>_x('clinica','CustomPostType Name','clinica'),
                            'post_status' => 'publish',
                            'showposts'=>10,
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


    <!-- Metemos a la derecha el listado de la derecha -->

    <div id="rightBuscadorClinicas">
    	<h2>RESULTADOS DE LA BÚSQUEDA</h2>

     <div class="rightBCWrapper1">
    	<div class="rightBCWrapper2">
    	<!-- 	<div id="infoClinicSearch">		info sobre lo realizado    		</div> -->


    						<!-- Inicio de Info sobre Geolocalización -->
			<div class="userGeoInfo">
				<div id="rightGeoTitle">Clínicas según Ubicación Concreta: </div>
				    <span class="geoMainTitle"><?php echo _x('Mostrando', 'template-buscador-clinicas','iol_last');?> </span>
					<span id="userGeoInfoSpanTitle"><?php echo _x('ubicación seleccionada:', 'template-buscador-clinicas','iol_last');?></span>
					<span id="userGeoInfoSpanValue">&nbsp;</span>
					<span id="distanceTitle">&nbsp;<?php echo _x('Distancia:', 'template-buscador-clinicas','iol_last');?> </span>
					<span id="distanceValue">&nbsp;</span>
					<span class="distUnit"><?php echo _x('km', 'template-buscador-clinicas','iol_last');?></span>
					<!-- <span id="userGeoLatLng"></span> -->

		    <div id="geoCond">&nbsp;</div>
		    </div>


					<!-- Fin sobre info de geolocalización -->
					<div style="clear:both;height:0px;">&nbsp;</div>

        	<div class="resultLCom">
				<div id="resultLComTile"><?php echo _x('Clínicas según lente y Comunidad', 'template-buscador-clinicas','iol_last');?></div>

				<div id="clinicCond">&nbsp;</div>

			</div>




         </div>


					<div style="clear:both;height:0px;">&nbsp;</div>

         </div>
    </div>


    <!-- Fin del listado de la derecha -->







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
<?php get_footer('clinicas'); ?>
