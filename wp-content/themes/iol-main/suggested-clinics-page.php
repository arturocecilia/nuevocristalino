<?php


    // Find connected clinics
    $connected = new WP_Query( array(
                                    'connected_direction' => 'from',
                                    'connected_type' => 'pageToClinica',
                                    'connected_items' => get_queried_object(),
                                    'nopaging' => true,
                                    'orderby'=> 'meta_value_num',
                                    'meta_key' => 'nivelPrefClinicaMD',
                                    'order' => 'DESC'
                                    ) );

                  /*

	                      		$query->set('orderby','meta_value_num');//nivelPrefLenteMD
    		$query->set('meta_key','nivelPrefClinicaMD');
    		$query->set('order','DESC');
                  */


    // Display connected pages
    if ( $connected->have_posts() ) :
     ?>


    <div id="pageClinics">

    <h3 class="clinicListTitle"><?php echo _x('Vea clínicas especializadas en:','suggested-clinics-page','iol_theme').'&nbsp;'.get_the_title(); ?> </h3>
  	<div id="sLensClinicsContainer">

          <ul class="sugClinicList">
            <?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
                     <li>
                       <div class="sugClinic">
                        <div class="sugClinicImage"> <?php echo get_the_post_thumbnail(); /* the_post_thumbnail('thumbnail');*/ ?> </div>
                        <div class="metaDataBlog">
                          <span class="sugClinicTitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
                          <span class="locationClinicList"><?php echo get_post_meta( get_the_ID(), 'direccionD',TRUE);?></span>
                          <span class="telfClinicList"><?php echo get_post_meta( get_the_ID(), 'telfContactoD',TRUE).' - '.get_post_meta( get_the_ID(), 'horarioD',TRUE);?></span>
                          <span class="sugClinicMas"><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php echo _x('+informacion','Single Lente Intraocular','iol_cpt_display'); ?></a></span>
                        </div>
                           <div style="clear:both; height: 0px;">&nbsp;</div>
                       </div>
                    </li>


                    <?php endwhile; ?>
              </ul>

           </div>
        </div>

            <?php
                   // Prevent weirdness
                wp_reset_postdata();


  echo '<div class="moreClinics" id="mCLens"><a href="'.get_post_type_archive_link( _x('clinica','CustomPostType Name','clinica') ).'">'._x('Ver más clínicas que realicen esta intervención','Suggested Clinics','iol_theme').'>></a></div>';

            endif;
            ?>
