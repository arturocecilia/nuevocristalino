<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

/* Demomento no lo voy a introducir, razón:
-->  Está todo el contenido superfluo cacheado con anterioridad.

if(is_Not_Ajax()){
    get_header();}
    else{
        get_header('ajax');
    }
    */

    get_header('single-lente-intraocular');

     ?>



<?php /* $GLOBALS['DebugMyPlugin']->panels['main']->addMessage('I Want To Say:','Hello World'); */?>

     <?php include('left-single-lente-intraocular.php');?>


   <div id="primary" class="site-content-single single-lente">

      <div id="preButtonSetSingle" class="noArchive startsUgly">
        <!-- Vamos a meter un link de ayuda que nos explique como se utiliza -->
    	<div id="helpTitle" class="startsUgly">

        <?php /*get_page_by_title( 'Ayuda para la Búsqueda de Lentes Intraoculares' )->ID*/ ?>
     		<a href="<?php echo get_permalink(2838); ?>" data-idToReplace="content article" data-idToGet ="content" data-selectorsNotToFade="" data-scrollTop="">
     	<?php	
     		 //Lo anterior eran los valores por defecto. Queremos que el usuario perciba el concepto de "Versi—n".
            $langChange = substr(get_locale(),0,2);
            
            if($langChange =="es"){
             $helpCM	= 'AYUDA BÚSQUEDA LENTES';      
            }
            
            if(get_locale() == 'en_GB'){
              $helpCM	= 'IOL SEARCH HELP';
            }
            
            if(get_locale() == 'en_US'){
			   $helpCM	= 'IOL SEARCH HELP';
            }
            if($langChange == 'de'){
            $helpCM	= 'HILFE IOL-SUCHE';
            }
            
            echo $helpCM; 
            ?>
     		
     		
     		
     		</a> 
    	</div>
      </div>

       <div id="loadingGif"><img src="<?php echo plugins_url( "images/ajax-loader.gif" , __FILE__ ); ?>" alt="ajax-loader" /></div>
		<div id="content" role="main" class="single-content-lente-intraocular">
            <div id="ajaxResponse"></div>
			<?php while ( have_posts() ) : the_post(); ?>
             
             <?php 
             $lensID = get_the_ID();
             
         	 include('content-lente-intraocular.php'); 
         	 
         	 ?>
         	 
         	 

         	 
         	             

<?php 
    // Find connected clinics
    $connected = new WP_Query( array(
                                    'connected_direction' => 'from',
                                    'connected_type' => 'lente_to_clinica',
                                    'connected_items' => get_queried_object(),
                                    'nopaging' => true,
                                    ) );
                                    
                                    
    // Display connected pages
    if ( $connected->have_posts() ) :
     ?>
     <br><br>
     <h3 class="clinicsIntro"><?php echo _x('¿DONDE ME PUEDEN PONER ESTA LENTE EN ESPAÑA?','Single Lente Intraocular','iol_cpt_display'); ?></h3>
    
     
     <!-- Inicio CA y Provincia-->
     
     <!-- inicio CA -->
     <div id="caProvSLens">
     <?php
                 //Lo anterior eran los valores por defecto. Queremos que el usuario perciba el concepto de "Versi—n".
            $langChange = substr(get_locale(),0,2);
            
            $vClinics = 'View clinics in location';
                        
            if($langChange =="es"){
            $vClinics 	= 'Ver Clínicas en Ubicación';   
            }
            
            if(get_locale() == 'en_GB'){
            $vClinics = 'View clinics in location';            
            }
            
            if(get_locale() == 'en_US'){
            $vClinics = 'View clinics in location';
            }
            
            if($langChange == 'de'){
                 $vClinics = 'Finden Sie Kliniken in Ihrer Nähe';
            }
            
            ?>
     
     
     
       		<div id="sLensClinics">
     			<button><?php echo $vClinics; ?></button> 
     		</div>
     
     	
     
     <!-- Inicio de Ubicacion: Comunidad Autónoma -> Son 2 comboboxes: La primera de términos padre y la segunda de términos hijo... lo suyo sería que apareciesen sólo los términos hijos del seleccionado-->
        <div class="ui-widget startsUgly">
        <label  class="cliniBSetTitle"><?php echo _x('Comunidad Autónoma:','Single Lente Intraocular','clinica_cpt_display');?></label>
        <select id="combobox-singleLens-ubicacion-parent" name="ubicacion-parent">
        <?php
        
        $comAutos = get_terms( array(_x('ubicacion','taxo-name','clinica')), array( 'parent' => 0 , 'hide_empty'=> 0 ) );
        $provincesInScope = get_terms( array(_x('ubicacion','taxo-name','clinica')), array('hierarchical'=> FALSE, 'hide_empty'=> 0 ));
        
        if  ($comAutos) {
			echo '<option selected="selected" value = "ubicacion-parent-se" id="comAutoDefault">'._x('Sin Especificar','Single Lente Intraocular','clinica_cpt_display').'</option>';
        foreach ($comAutos as $taxonomy ) {
                  echo '<option value = "' . $taxonomy->slug . '">' . $taxonomy->name . '</option>';                  
                    }    
            }            
         ?>
        </select>
        </div>
        

         <!-- Fin de Ubicacion Comunidad Autónoma -->
     <!-- Fin CA -->
     
     	<!-- Inicio Provincia -->
     	
     	  <!-- Inicio Provincia-->
        <div class="ui-widget startsUgly" id="provincia">
        <label  class="cliniBSetTitle"><?php echo _x('Provincia:','Single Lente Intraocular','clinica_cpt_display');?></label>
        <select id="combobox-singleLens-ubicacion-child" name="ubicacion-child">
        <?php
        if  ($provincesInScope) {
               echo '<option value = "ubicacion-parent-se" id="comAutoDefaultSe">'._x('Sin Especificar','Single Lente Intraocular','clinica_cpt_display').'</option>';
             foreach ($provincesInScope as $taxonomy ) {
                        echo '<option value = "' . $taxonomy->slug . '">' . $taxonomy->name . '</option>';                                  
                }
                
            if($provinciaTermSlug == "ubicacion-child-se"){
                echo '<option selected="selected" value = "ubicacion-child-se">'._x("Sin Especificar","Single Lente Intraocular","clinica_cpt_display").'</option>';
                }else{
                 echo '<option value = "ubicacion-child-se">'._x("Sin Especificar","Single Lente Intraocular","clinica_cpt_display").'</option>';
                }    
            }            
         ?>
        </select>
        </div>
         <!-- Fin Provincia -->

     	
     	<!-- Fin Provincia y CA-->
     	

     	
     	
             <div style="clear:both; height:0px;">&nbsp;</div>
             
             </div>
       <!-- Ini script común CA y Provincia -->

       <!-- Fin Script Común -->
     
     
     <div id="singleLensClinics">

		<!-- El loading-->
       <div id="loadingGif">
            <div id="loaderDiv">
                <img src="<?php echo plugins_url( "images/ajax-loader.gif" , __FILE__ ); ?>" alt="ajax-loader" />
            </div>
        </div> 
     	<!-- -->
     	
     	<div id="sLensClinicsContainer">
    	
          <ul class="sugClinicList">
            <?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
                     <li>
                       <div class="sugClinic">
                        <div class="sugClinicImage"> <?php echo get_the_post_thumbnail(); /*the_post_thumbnail('thumbnail'); */ ?> </div>
                        <div class="metaDataBlog">
                          <span class="sugClinicTitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
                          <span><?php echo get_post_meta( get_the_ID(), 'direccionD',TRUE);?></span>
                          <span><?php echo get_post_meta( get_the_ID(), 'telfContactoD',TRUE).' - '.get_post_meta( get_the_ID(), 'horarioD',TRUE);?></span>
                          <span class="sugClinicMas"><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php echo _x('Ver información de la clínica','Single Lente Intraocular','iol_cpt_display'); ?></a></span>
                        </div>
                           <div style="clear:both; height: 0px;">&nbsp;</div>
                       </div>
                    </li>
                    
                    <?php $clinicIds[] = get_the_ID() ; ?>
                    
                    <?php endwhile; ?>
              </ul>  
                  <?php echo '<input hidden id="listIds" value="'.json_encode($clinicIds).'" />'; ?>
                
           </div>     
        </div>          
               
            <?php 
                   // Prevent weirdness
                wp_reset_postdata();

                  
  echo '<div class="moreClinics" id="mCLens"><a href="'.get_post_type_archive_link( _x('clinica','CustomPostType Name','clinica') ).'?'._x('lente-implantada','param-name','clinica').'='.$lensID.'">'._x('Ir al buscador con esta lente para Ver más Clínicas','Single Lente Intraocular','iol_cpt_display').'>></a></div>';

            endif;
            ?>
		
			<?php  endwhile;  ?>

		<?php 
		  //Vamos a poner un div auxiliar que nos permita identificar que estamos en el Archive template.
		  //En la página de explicación de pacientes teníamos uno en el template: id= tipoIolTemplate.
		  //aquí será archiveIolTemplate y en el single: singleIolTemplate, en todos va ubicado dentro de content.
		  
		  echo '<div id="singleIolTemplate" style="display:none;">&nbsp;</div>';
		   
		?>

 	<!-- Div auxiliar donde almacenamos el postId del post que se está mostrando. Esto es necesario para el caso de que se quiera
   	cambiar el filtro.-->
   	<?php 
   		echo '<div id="postId" style="display:none;">'.get_the_ID().'</div>';
   	?>
	
		
        </div><!-- #content -->
	</div><!-- #primary -->
 

    <?php 
            //Vamos a Desacoplar el tema de la "Versión de NuevoCristalino" de los pos mos. Razón: Sólo hay que tocar 6 plantillas.

            //include('change-version-single-iol.php');
           
            
            
			//	   if($_COOKIE['ncpatient']){
                    echo '<div id="right" class="filter-right patient-filter single-lente pteDisplay">';
                    //Incluimos antes los botones.
					echo '<div id="changeFilter">';
					   
                       echo '<a data-action="getSingleAdvForm" href="#" >';
                       //echo $filtAvanzado;
                       $paciente = 1;
      					include(ABSPATH . 'wp-content/plugins/lente-intraocular/change-version-single-iol.php');
                       echo '</a>';

                    echo '</div>';
                    	include('single-patient-form.php');  
                    echo  '</div>';
             //    }
                 
           //      if(!$_COOKIE['ncpatient']){
                  echo '<div id="right" class="filter-right single-lente pteNoDisplay">';
            	//Incluimos antes los botones.
					echo '<div id="changeFilter">';

                       echo '<a data-action="getSinglePatientForm" href="#" >';
                      // echo $filtSimple;
                      $paciente = 0;
   					include(ABSPATH . 'wp-content/plugins/lente-intraocular/change-version-single-iol.php');
                       echo '</a>';
                    
                    echo '</div>';
                         
				//Incluimos el form
            	include('right-single-lente-intraocular.php');
            	
            	                /*-- Vamos a meter aquí otro banner de Refractive Academy --*/
                
                

			//Vamos a meter el banner de NuevoCristalino diseñado para la página de fabricantes
			
			//if(current_user_can('manage_options')){
				$langDetect = substr(get_locale(), 0 ,2);
				$langLocale = strtolower(substr(get_locale(), 3 ,2));
				
				
		            
                /*-- Fin del Right Banner de RA--*/

            	
            	
            	
            	
            	
            	
            	
            	
            	
            	
            	
                //echo '</div>';
                
                
                //Vamos a añadir aquí el form de contacto.
             echo  '<h3 style="display:none;" class="mobile contactSingleLente">'._x('CONTACTE CON','Left Single Lente Intraocular','iol_cpt_display');
             echo '<span> '.$Result_Fabricante.'</span></h3>';
    		 echo '<div style="display:none;" id="contact-single-lente" class="mobile">';
    	
    	if (function_exists('serveCustomContactForm')) { serveCustomContactForm(3); }
    		echo '</div>';
			echo '</div>';
                
                
                
              //   }
            echo '		 <!-- Vamos a poner en este div todos los ids de los inputs que hay que deshabilitar -->';
		    $cssUndefinedMetaDataSelector =  join(", ",$UndefinedMetaDataSelector); 
	        echo '<div id="inputSelectorsToDisable" style="display:none; visibility: hidden;">';
	        echo $cssUndefinedMetaDataSelector.'</div>';
          //  }
             ?>


<?php

wp_reset_postdata();
get_footer('singleiol');


 ?>