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
    </div><!-- #main #buscadorIol-->
    </div><!-- #page -->
    <!-- </div> #pageBuscadorIolWrapper-->
    
<div id="footer-wrap" class="footerClinicas">
         <footer id="colophon" role="contentinfo"> <!--  NOS CARGAMOS ESTE TAMBIƒN-->
                
	    <!--<div id="mVisitedWrapper"> -->
               
        		<!-- Inicio de las Lentes màs visitadas-->
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
				echo '<a href="'.get_permalink($iolID).'" rel="bookmark" title="'.get_the_title($iolID).'">'.get_the_title($iolID).'</a>';
			    echo '</li>';
               }?>

               <?php echo '</ul>';?>  			           		
           		</div>    
           <!-- Fin de las lentes màs visitadas -->    
               
                  	
          	<!-- Inicio de ClÕnicas màs visitadas -->
           	<div id="mVisitedClinics" class="mod-footer">
           		<?php 
           		  $argsClinics = array(	'post_type'=>_x('clinica','CustomPostType Name','clinica'),
										'meta_key'=>'nivelPrefClinicaMD',
           		  					   	'orderby'=>'meta_value_num',
           		  					   	'order' => 'DESC',
           		  					   	'post_parent' => '0',
           		  					    'posts_per_page'=>'5');
           		  
           		  $mVClinics = new WP_Query($argsClinics);
               ?>
               <?php if ($mVClinics->have_posts()) : ?>
               <?php echo '<h3>'._x('Clínicas Más Vistas:','Footer','iol_theme').' </h3>'; ?>
               <?php echo '<ul>'; ?>
               <?php while ($mVClinics->have_posts()) : $mVClinics->the_post(); ?>    
               <!-- do stuff ... -->
				 <!-- Display the Title as a link to the Post's permalink. -->
				 
			 <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title();
			?></a>
			 </li>
               <?php endwhile; ?>
               <?php echo '</ul>';?>
               <?php endif; ?>     		
           		</div>   
           		<!-- Fin de las clÕnicas màs visitadas -->        


        <!-- </div>  -->       
        	
            <!-- InfoLegal -->
            <div id="corporativeLinks" class="site-info mod-footer">
                <h3><?php echo _x('Legal','Footer','iol_theme'); ?></h3>
                <?php  wp_nav_menu(array('theme_location'=>'Menu-footer')); ?>
                  </div>
            
            <!-- M‡s sobre Nuevo Cristalino -->
            <div id="masNCfooter">
              <h3><?php echo _x('Más sobre Nuevo Cristalino','Footer','iol_theme'); ?></h3>
              <?php  wp_nav_menu(array('theme_location'=>'Menu-footer2')); ?>
              <div id="logo-andomed"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/footer/andomed.png" alt="Andomed" /></div>
            </div>           
            
        </footer> <!-- ESTA TAG TAMBIƒN SOBRABA POR ESO NO LLEGABA HASTA EL FINAL #colophon -->
            <div style="clear:both;height:0px; display:none;">&nbsp;</div>
     </div><!-- A ver si este tambiŽn sobraba...-->
   
    <div class="nav_up" id="nav_up"></div>        

    <div  class="nav_down" id="nav_down"></div>
<!-- Fin de los botones del scroll -->		

<?php wp_footer(); ?>


</body>
</html>