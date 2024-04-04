
<div id="left" class="site-content-left">

    <?php 
        $fabricante = get_the_terms( $post->ID, _x('fabricante-lente','taxo-name','iol') );
						
        if ( $fabricante && ! is_wp_error( $fabricante ) ) : 
        	$taxo_fabricantes = array();
    	    foreach ( $fabricante as $term ) {
	    	    $taxo_fabricantes[] = $term->name;
	        }						
	        $Result_Fabricante = join( ", ", $taxo_fabricantes );
     ?>

    <p class="beers draught">
	
    <?php printf(_x('MÁS LENTES DE %s','Left Clinica Oftalmologica','clinica_cpt_display'),$Result_Fabricante ); ?>
    </p>
<br /><br />
       <?php endif; ?>
  
    <div>
           
       <?php /* Ponemos el contenido para dado un fabricante sacar sus lentes */
            $args = array(
	                      'post_type' => _x('lente-intraocular','CustomPostType Name','iol'),
	                      _x('fabricante-lente','taxo-name','iol') => $Result_Fabricante
             );
			$the_query = new WP_Query( $args );

			// The Loop
			while ( $the_query->have_posts() ) : $the_query->the_post();
					echo '<li><a href='.get_permalink($post->ID).'>'.get_the_title().'</a></li><br />';
			endwhile; 
        ?>   
    </div>
</div>	
