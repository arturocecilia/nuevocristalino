<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->
    </div><!-- #page -->
    
<!-- <div id="fakeDiv">&nbsp;</div> -->

<script>
            //<?php echo 'En teoría el post id es: '.$post->ID; ?>

</script>

<div id="footer-wrap">
         <footer id="colophon" role="contentinfo"> <!--  NOS CARGAMOS ESTE TAMBIÉN-->
         
       
	    <!--<div id="mVisitedWrapper"> -->
               
                      		<!-- Inicio de las Lentes m‡s visitadas-->
           		<div id="mVisitedIols" class="mod-footer">
           		<?php 

                $lentisMplusX       = 4584;
                $lentisMplusToricX  = 7639;
                //$zeissAtLisaTri     = 4600;
                $finevision			= 4920;
                $medicontur			= 9902;
                $alconRestor        = 4622;
                //$tecnisMulti        = 7621;       		  


           		  $mVIols =  array(
           		  					$lentisMplusX,
                                    $lentisMplusToricX,
                                    //$zeissAtLisaTri,
                                    $finevision,
									$medicontur,      
                                    $alconRestor
                                    //$tecnisMulti
                                    );
               ?>
               <?php echo '<h3>'._x('Lentes más Vistas:','Footer','iol_theme').'</h3>'?>
               <?php echo '<ul>'; ?>
               <?php foreach ($mVIols as $iolID){  
               
			    echo '<li>';
				echo '<a href="'.get_permalink($iolID).'" rel="bookmark" title="Permanent Link to '.get_the_title($iolID).'">'.get_the_title($iolID).'</a>';
			    echo '</li>';
               }?>

               <?php echo '</ul>';?>  		           		
           		</div>    
           <!-- Fin de las lentes m‡s visitadas -->           
                       
                       
                  	
          	<!-- Inicio de Cl’nicas m‡s visitadas -->
           	<div id="mVisitedClinics" class="mod-footer">
           		<?php 
           		  $argsClinics = array(	'post_type'=>_x('clinica','CustomPostType Name','clinica'),
										'meta_key'=>'nivelPrefClinicaMD',
           		  					   	'orderby'=>'meta_value_num',
           		  					   	'order' => 'DESC',
           		  					   	'post_parent' => '0',
           		  					    'posts_per_page'=>'5');
   				/*
				     'orderby' => 'nivel-pref-clinica',
           		  	 'post_parent' => '0',//Sólo queremos que salgan clínicas Padre 
           		  	 'order' => 'DESC',
				*/

           		  
           		  $mVClinics = new WP_Query($argsClinics);
                  


               ?>
               <?php if ($mVClinics->have_posts()) : ?>
               <?php echo '<h3>'._x('Clínicas Más Vistas:','Footer','iol_theme').' </h3>'; ?>
               <?php echo '<ul>'; ?>
               <?php while ($mVClinics->have_posts()) : $mVClinics->the_post(); ?>    
               <!-- do stuff ... -->
				 <!-- Display the Title as a link to the Post's permalink. -->
				 
			 <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?echo _x('ver','title footer','iol_theme'); ?> <?php the_title_attribute(); ?>"><?php the_title();
			?></a>
			 </li>
               <?php endwhile; ?>
               <?php echo '</ul>';?>
               <?php endif; ?>     		
           		</div>   
           		<!-- Fin de las cl’nicas m‡s visitadas -->        
             <?php wp_reset_postdata(); ?>

        <!-- </div>  -->       
        	
             <?php 
                    $permaSiteMap = get_permalink(8398);
             ?>

            <!-- InfoLegal -->
            <div id="corporativeLinks" class="site-info mod-footer">
                <h3><?php echo _x('Legal','Footer','iol_theme'); ?></h3>
                <?php  wp_nav_menu(array('theme_location'=>'Menu-footer')); ?>

            </div>
            
            <!-- Más sobre Nuevo Cristalino -->
            <div id="masNCfooter">
              <h3><?php echo _x('Más sobre Nuevo Cristalino','Footer','iol_theme'); ?></h3>
              <?php  wp_nav_menu(array('theme_location'=>'Menu-footer2')); ?>
              <div id="logo-andomed"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/footer/andomed.png" alt="Andomed" /></div>
            </div>           
  <?php /*          
            <!--<div id="logos">
            	<a href="http//:www.andomed.com"><img src="<?php //bloginfo('template_directory'); ?>/images/content/andomed.png" alt="logo Andomed" /></a>
                <div id="redes">
                    <a href="#"><img src="<?php //bloginfo('template_directory'); ?>/images/content/twitter-nuevo-cristalino.png" alt="twitter Nuevo Cristalino" /></a>
                    <a href="#"><img src="<?php //bloginfo('template_directory'); ?>/images/content/facebook-nuevo-cristalino.png" alt="facebook Nuevo Cristalino" /></a>
                    <a href="#"><img src="<?php //bloginfo('template_directory'); ?>/images/content/youtube-nuevo-cristalino.png" alt="youtube Nuevo Cristalino" /></a>
                 </div> -->
            
            <div style="clear:both;height:0px;">&nbsp;</div>
                
            <!--</div>  ESTE DIV SOBRABA-->
            
*/ ?>
            
        </footer> <!-- ESTA TAG TAMBIÉN SOBRABA POR ESO NO LLEGABA HASTA EL FINAL #colophon -->
            <div style="clear:both;height:0px; display:none;">&nbsp;</div>
     </div><!-- A ver si este también sobraba...-->

<!-- Vamos a meter aquí los botones del scroll -->

    
   <!-- <div class="samp" style="width:100%; background:green;"> 
    <div style="width:960px; background:yellow; margin:0 auto;">alsdfjaldjfalksdfjadlksj</div>
    
    </div>
    -->
   
    <div class="nav_up" id="nav_up"></div>        

    <div  class="nav_down" id="nav_down"></div>
<!-- Fin de los botones del scroll -->		

<!-- WP-Minify CSS -->


<?php wp_footer(); ?>

	<script>
		//La lógica es la siguienteFooter: si el nivel de preferencia es mayor que 2 se muestra un mapa con la ubicación de la clínica
		//como centro.
		//Si el nivel de preferencia es mayor que 3 se muestra el mapa y una opción que permita saber como se va a la clínica desde
		//la ubicación en la que se encuentra el usuario.
		
//		latitud: , longitud:

		//Esta función muestra en divSingleClinicMapa	  
		createClinicMap(<?php echo get_post_meta( $post->ID, 'latitudD', TRUE ); ?>,
						<?php echo get_post_meta( $post->ID, 'longitudD', TRUE ); ?>, 
						"<?php echo $post->post_title; ?>");
		
		jQuery('#onlyClinic').on("click",function(){
			createClinicMap(<?php echo get_post_meta( $post->ID, 'latitudD', TRUE ); ?>,
							<?php echo get_post_meta( $post->ID, 'longitudD', TRUE ); ?>, 
							"<?php echo $post->post_title; ?>");
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
		
		
		
	</script>
	
<?php 
/*	
			<!-- Inicio de las Lentes m‡s visitadas-->
           		<div id="mVisitedIols" class="mod-footer">
           		<?php 
           		  $argsIols = array('post_type'=>_x('lente-intraocular','CustomPostType Name','iol'),
           		  					'meta_key'=>'nivelPrefLenteMD',
           		  					'orderby' =>'meta_value_num',
           		  					'order'=>'DESC',
           		  					'posts_per_page'=>'5');

           		  
           		  $mVIols = new WP_Query($argsIols);
               ?>
               <?php if ($mVIols->have_posts()) : ?>
               <?php echo '<h3>'._x('Lentes más Vistas:','Footer','iol_theme').'</h3>'?>
               <?php echo '<ul>'; ?>
               <?php while ($mVIols->have_posts()) : $mVIols->the_post(); ?>    
               <!-- do stuff ... -->
				 <!-- Display the Title as a link to the Post's permalink. -->
			 <li>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo _('ver','title footer','iol_theme'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			 </li>
               <?php endwhile; ?>
               <?php echo '</ul>';?>
               <?php endif; ?>     		           		
           		</div>    
           <!-- Fin de las lentes m‡s visitadas -->    

	*/
	
	?>	
	
	
</body>
</html>