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

<div id="footer-wrap">
         <footer id="colophon" role="contentinfo"> <!--  NOS CARGAMOS ESTE TAMBIÉN-->


	    <!--<div id="mVisitedWrapper"> -->

        		<!-- Inicio de las Lentes m‡s visitadas-->
           		<div id="mVisitedIols" class="mod-footer">
           		<?php
           		  $argsIols = array('post_type'=>_x('lente-intraocular','CustomPostType Name','iol'),
           		  					'meta_key'=>'nivelPrefLenteMD',
           		  					'orderby' =>'meta_value_num',
           		  					'order'=>'DESC',
           		  					'posts_per_page'=>'5');
    /*
      'orderby' => 'nivel-pref-lente',
           		  					   'order' => 'DESC',

    */

/*global $wp_query;
$wp_query=new WP_Query($argsIols);*/

wp_reset_postdata();
wp_reset_query();


           		  $mVIols = new WP_Query($argsIols);
								
               ?>
               <?php if ($mVIols->have_posts()) : ?>
              <?php echo '<div class="titlefooterwrapper"><span class="priortitlefooter">&nbsp;</span><h3 class="titletextfooter">'._x('Lentes más Vistas:','Footer','iol_theme').'</h3><span class="aftertitlefooter">&nbsp;</span><span class="floatFixer">&nbsp;</span></div>'?>
               <?php echo '<ul>'; ?>
               <?php while ($mVIols->have_posts()) : $mVIols->the_post(); ?>


							 <!-- do stuff ... -->
				 <!-- Display the Title as a link to the Post's permalink. -->
			 <li>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo _x('ver','title footer','iol_theme'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			 </li>
               <?php endwhile; ?>
               <?php echo '</ul>';?>
               <?php endif; ?>
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
              <?php echo '<div class="titlefooterwrapper"><span class="priortitlefooter">&nbsp;</span><h3 class="titletextfooter">'._x('Clínicas Más Vistas:','Footer','iol_theme').'</h3><span class="aftertitlefooter">&nbsp;</span><span class="floatFixer">&nbsp;</span></div>'; ?>
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


        <!-- </div>  -->

             <?php
                    $permaSiteMap = get_permalink(8398);
             ?>

            <!-- InfoLegal -->
            <div id="corporativeLinks" class="site-info mod-footer">
                <h3><?php echo '<div class="titlefooterwrapper"><span class="priortitlefooter">&nbsp;</span><h3 class="titletextfooter">'._x('Legal','Footer','iol_theme').'</h3><span class="aftertitlefooter">&nbsp;</span><span class="floatFixer">&nbsp;</span></div>'; ?></h3>
                <?php  wp_nav_menu(array('theme_location'=>'Menu-footer')); ?>

            </div>

            <!-- Más sobre Nuevo Cristalino -->
            <div id="masNCfooter">
                            <?php echo '<div class="titlefooterwrapper"><span class="priortitlefooter">&nbsp;</span><h3 class="titletextfooter">'._x('Más sobre Nuevo Cristalino','Footer','iol_theme').'</h3><span class="aftertitlefooter">&nbsp;</span><span class="floatFixer">&nbsp;</span></div>'; ?>
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



<?php wp_footer(); ?>
</body>
</html>
