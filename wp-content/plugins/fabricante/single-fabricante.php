<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>






   <div id="primary" class="site-content-fabricantes" itemscope itemtype="http://schema.org/Organization">
		<div id="content" role="main">

		<?php
            //Vamos a meter el banner de NuevoCristalino dise�ado para la p�gina de fabricantes

            //if(current_user_can('manage_options')){
                $langDetect = substr(get_locale(), 0, 2);
                $langLocale = strtolower(substr(get_locale(), 3, 2));
                ?>




			<?php while (have_posts()) : the_post(); ?>

				<?php get_template_part('content-fabricante', get_post_format()); ?>

				<nav class="nav-single">
					<h3 class="assistive-text"><?php _e('Post navigation', 'twentytwelve'); ?></h3>
					<span class="nav-previous"><?php previous_post_link('%link', '<span class="meta-nav">' . _x('&larr;', 'Previous post link', 'twentytwelve') . '</span> %title'); ?></span>
					<span class="nav-next"><?php next_post_link('%link', '%title <span class="meta-nav">' . _x('&rarr;', 'Next post link', 'twentytwelve') . '</span>'); ?></span>
				</nav><!-- .nav-single -->




		</div><!-- #content -->
	</div><!-- #primary -->

	<?php
       // if(current_user_can('manage_options')){

        echo '<div id="changeModeBloqFabWrapper">';
        echo '<div id="changeModeBloq" class="singleFab"><div class="contenidoMode">&nbsp;</div></div>';
        echo '&nbsp;</div>';

    //}


    ?>

    <div id="single-fab">
    	<div id="lista-lentes">
        	<h4 ><?php the_title(); ?></h4>

            <?php
                  //Generamos el slug del fabricante.
                  //Hay que hacer el substring para quitar lo de lentes intraoculares
                  $arrARemplazar = array('Lentes Intraoculares ', 'Abbott Medical Optics','Intraokularlinsen ','Implants intraoculaires ','Implants Intraoculaires ','Intraocular Lenses');

                  $fab_slug = sanitize_title(str_replace($arrARemplazar, "", get_the_title()));//the_title();

                  if (current_user_can('manage_options')) {
                      //    var_dump($lentes_fabricante->request);
                  //var_dump($fab_slug);
                 // var_dump(get_the_title());
                  }

                  if ($fab_slug == 'bauschlomb') {
                      $fab_slug ='bausch-lomb';
                  }



                  //Creamos el objeto WP_Query con las lentes del fabricante. Showposts limita el n�mero de posts que retorna la query.
                 $tax_queryLF = array(
                                 array(
                                       'taxonomy'=> _x('estatus-comercial', 'taxo-name', 'iol'),
                                       'terms'   => array(_x('retirada', 'taxo-value-slug', 'iol-scaffold'),_x('en-estudio', 'taxo-value-slug', 'iol-scaffold') ), //$adiciones_filter,//array('alta'),
                                       'field' => 'slug',
                                       'operator' => 'NOT IN'
                                        ));


                  //Queremos que si est� en modo paciente s�lo saque las lentes seleccionadas.
                  if (array_key_exists('ncpatient', $_COOKIE)) {
                      $tax_queryLF =	array(
                                            'relation' => 'AND',
                                              array(
                                                       'taxonomy'=> 'nivel-pref-lente',
                                                       'terms'   =>  5, //$adiciones_filter,//array('alta'),
                                                       'field' => 'slug',
                                                       'operator' => 'IN'
                                                    ),
                                        $tax_queryLF[0]
                                        );
                  }



                  $argsLF = array(      'post_type'=> _x('lente-intraocular', 'CustomPostType Name', 'iol'),
                                        _x('fabricante-lente', 'taxo-name', 'iol')=>$fab_slug,
                                        'showposts'=>5,
                                        'tax_query'=>$tax_queryLF,//A continuaci�n metemos la ordenaci�n.
                                        'orderby' => 'meta_value_num',
                                        'meta_key'=> 'nivelPrefLenteMD',
                                        'order'=>'DESC'
                                     );
                  $lentes_fabricante = new WP_Query($argsLF);




                  //Hacemos un custom loop para sacar el marcado asociado a las lentes del fabricante.
                  while ($lentes_fabricante->have_posts()):$lentes_fabricante->the_post();

                    //Seguimos con los dos modos.
                    if (array_key_exists('ncpatient', $_COOKIE) && ((get_post_meta($post->ID, 'simpleLensName', true)!='') && (get_post_meta($post->ID, 'simpleLensName', true)!='//'))) {
                        $titleFabLens = get_post_meta($post->ID, 'simpleLensName', true);
                    } else {
                        $titleFabLens =get_the_title();
                    }

                     echo '<div class="lente">';
                     echo '<span class="image">'. the_post_thumbnail('thumbnail').'</span>';
                     echo '<span class="title">'.$titleFabLens.'</span>';//the_title()
                     echo '<div class="link">';
                     echo '<a href="'.get_permalink().'">'._x('Ver lente', 'Content Archive Lente Intraocular', 'iol_theme').'</a>';
                     echo '</div>';
                     echo '</div>';
                    // echo '<br />';
                     //echo the_ID();

                  endwhile;

            ?>

        </div>


        <?php if ($rgpe = false) {
                ?>

        <div id="contacto-fab">
        	<h4><?php echo _x('CONTACTE CON EL FABRICANTE', 'Single Fabricante', 'miscelaneous_cpt_display'); ?></h4>
            <div class="formulario-fab">
                <?php /*HABR� QUE PONER ESTO EN CADA CASOOOOO */ ?>
            <?php
            switch (get_locale()) {
                    case 'es_ES':
                            $idFormFab = 11204;
                        break;
                    case 'es_CL':
                            $idFormFab = 11737;
                        break;
                    case 'es_MX':
                            $idFormFab = 11418;
                        break;
                    case 'es_CO':
                            $idFormFab = 11809;
                        break;
                    case 'en_GB':
                            $idFormFab = 11590;
                        break;
                    case 'en_US':
                            $idFormFab = 11486;
                        break;
                    case 'de_DE':
                            $idFormFab = 11536;
                        break;
                    case 'de_AT':
                            $idFormFab = 11689;
                        break;
                    case 'fr_FR':
                            $idFormFab = 11643;
                        break;
                    default:
                            $idFormFab = 11204;
                }


                if (function_exists('ccf_output_form')) {
                    ccf_output_form($idFormFab);
                } ?>


            </div>

        </div>

    <?php
            } ?>

    </div>


	<?php endwhile; // end of the loop.?>


<?php get_footer(); ?>
