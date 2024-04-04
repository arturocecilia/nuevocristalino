

<div id="left" class="site-single-iol-left pteNoDisplay">





    <?php
        $fabricante = get_the_terms($post->ID, _x('fabricante-lente', 'taxo-name', 'iol'));

        if ($fabricante && ! is_wp_error($fabricante)) :
            $taxo_fabricantes = array();
            foreach ($fabricante as $term) {
                $taxo_fabricantes[] = $term->name;
            }
            $Result_Fabricante = join("", $taxo_fabricantes);
     ?>

    <p class="beers draught">
	<?php echo _x('MÁS LENTES DE:', 'Left Single Lente Intraocular', 'iol_cpt_display'); ?> <span><?php echo $Result_Fabricante; ?></span>
    </p>
       <?php endif; ?>

    <?php
          //Hay que añadir el pt=yes si nos viene definido.
          //en teoría habría que añadir un string u otro en función de si trae querystring o no. Pero al ser single IOL ya sabemos que nó.
          if (!isset($_GET['pt']) || ($_GET['pt'] == 'yes')) {
              //$pt="?pt=yes";
              $pt="";
          } else {
              //$pt="?pt=no";
              $pt="";
          }

    ?>

    <div id="lista-lentes-single">
           <ul>
       <?php /* Ponemos el contenido para dado un fabricante sacar sus lentes */
            $tax_RestricActive = array(
                               'taxonomy'=> _x('estatus-comercial', 'taxo-name', 'iol'),
                               'terms'   => array(_x('retirada', 'taxo-value-slug', 'iol-scaffold'),_x('en-estudio', 'taxo-value-slug', 'iol-scaffold')), //$adiciones_filter,//array('alta'),
                               'field' => 'slug',
                               'operator' => 'NOT IN'
                                );

            $current_ID = get_the_ID();
            $args = array(
                          'post_type' => _x('lente-intraocular', 'CustomPostType Name', 'iol'),
                          _x('fabricante-lente', 'taxo-name', 'iol') => str_replace('+', '-', $Result_Fabricante),
                          'post__not_in' => array($current_ID),
                          'tax_query' => array($tax_RestricActive),
                          'orderby' => 'meta_value_num',
                          'meta_key'=> 'nivelPrefLenteMD',
                          'order'=>'DESC',
                          'posts_per_page' => 6
             );

//             echo 'sip '.str_replace('+','',$Result_Fabricante).'Oeoe';
            $the_query = new WP_Query($args);

            /*if(current_user_can('manage_options')){
                var_dump($the_query->request);
            }*/

            // The Loop
            while ($the_query->have_posts()) : $the_query->the_post();
                    echo '<li><a href="'.get_permalink().$pt.'">';
                    echo get_the_title();
                    echo '</a></li>';
            endwhile;
        ?>
        </ul>
        <br>
    </div>

            <?php if ($rgpe = false) {
            ?>
    <h3 class="noMobile"><?php echo _x('CONTACTE CON', 'Left Single Lente Intraocular', 'iol_cpt_display'); ?> <span><?php echo $Result_Fabricante; ?></span></h3>
    <div id="contact-single-lente" class="noMobile">

    	<?php //if (function_exists('serveCustomContactForm')) { serveCustomContactForm(3); }?>

    	            <?php
            switch (get_locale()) {
                    case 'es_ES':
                            $idFormLen = 11220;
                        break;
                    case 'es_CL':
                            $idFormLen = 11744;
                        break;
                    case 'es_MX':
                            $idFormLen = 11428;
                        break;
                    case 'es_CO':
                            $idFormLen = 11819;
                        break;
                    case 'en_GB':
                            $idFormLen = 11600;
                        break;
                    case 'en_US':
                            $idFormLen = 11494;
                        break;
                    case 'de_DE':
                            $idFormLen = 11546;
                        break;
                    case 'de_AT':
                            $idFormLen = 11697;
                        break;
                    case 'fr_FR':
                            $idFormLen = 11650;
                        break;
                    default:
                            $idFormLen = 11220;
                }

            if (function_exists('ccf_output_form')) {
                ccf_output_form($idFormLen);
            } ?>


    </div>

    <?php
        } ?>
    


</div>
