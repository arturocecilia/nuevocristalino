<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">

			<?php if (is_single()) : ?>
			<h1 class="entry-title" itemprop="name model">

			<?php

            //if(current_user_can('manage_options')){

            //Añadimos el nombre simplificado si estamos en modo paciente y si no está ni vacío ni con //
            if ((array_key_exists('ncpatient', $_COOKIE)) && (get_post_meta($post->ID, 'simpleLensName', true) != '//') && (get_post_meta($post->ID, 'simpleLensName', true) != '')) {
                echo get_post_meta($post->ID, 'simpleLensName', true);
            } else {
                the_title();
            }
            //}

            ?>

			<?php //the_title();?>

			</h1>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'twentytwelve'), the_title_attribute('echo=0'))); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php endif; // is_single()?>
		</header><!-- .entry-header -->

		<?php if (is_search()) : // Only display Excerpts for Search?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
        <?php
                //the_post_thumbnail();
                $args = array();
                $varUrlThumb =  wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);
                //Hay que cambiar rel="lightbox" por data
                echo  '<a data-lightboxplus="lightboxplus" class="singleIOLFeatImage" href="'.$varUrlThumb[0].'" title="'.get_the_title().'">'.get_the_post_thumbnail(get_the_ID(), 'medium', array('itemprop' => 'image')).'</a>';
                ?>
		<div class="entry-content" itemprop="description">
			<!-- Aquí es donde hay que volcar todos los contenidos -->

            <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve')); ?>

            <!-- Mostramos los datos de una manera sistematizada -->

<!-- Metemos aquí la info para pacientes y si o el content o el content de paciente tienen info hacemos que no se muestren los campos -->

         	 <?php
                 $showCamposLentes = "";

                 if ((get_the_content($post->ID)!= '')) {//isset($_COOKIE["ncpatient"]) &&
                     //(get_post_meta($post->ID, 'simpleLensDesc', TRUE) != '//') && (get_post_meta($post->ID, 'simpleLensDesc', TRUE) != '') &&
                     $showCamposLentes = 'pteNoDisplay';
                 }

                 //Vamos a añadir el contenido de info de paciente en el siguiente div.
                 echo '<div id="iolPatientInfo" data-iolid="'.$lensID.'">&nbsp;</div>';

              ?>




<!--MOstramos uno a uno los campos del custom post type mezclados con las taxonomías para que salgan en el mismo orden que en los filtros -->
			<div style="clear:both;"></div>
          <div id="campos-lentes" class="<?php echo $showCamposLentes; ?>"> <!-- pteNoDisplay Lo quitamos hasta que esté hecha la alternativa-->




			<?php
            //diseño de lente
            if ($disenopV = get_the_term_list($post->ID, _x('diseno-optica', 'taxo-name', 'iol'), "", " -- ")) {
                //Hay que meter la particularidad de la Mplus...
                //if(current_user_can('manage_options')){
                if ((strpos($disenopV, " -- ") !== false)) {
                    $disenopV = _x('Multifocal', 'taxo-value-name', 'iol-scaffold');
                    //Cambiamos mediante Javascript la clase que hace parecer que la opción esté seleccionada.
                    echo "<script >if(!!window.jQuery) {
                             jQuery(document).ready(function (){";
                    //echo "activador();";
                    echo "jQuery('label[for=\"multifocal-trifocal\"],label[for=\"multifocal-bifocal\"] ').addClass('ui-state-active')";
                    echo "});
                        }</script>";
                }
                //var_dump($disenopV);
                //}
                echo'
					<div class="bloq-single-lente disenoOptC std">
						<div class="label">'._x('Diseño de Óptica', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
						<div class="value">'.strip_tags($disenopV).'</div>
					</div>';
            }?>

            <?php
            //Rango dioptrías esfera
            if ($formOpticD = get_post_meta($post->ID, 'formOpticD', true) and get_post_meta($post->ID, 'formOpticD', true) != '//') {
                echo'
					<div class="bloq-single-lente formOpticC std">
						<div class="label">'._x('Forma de la óptica (D)', 'admin_display', 'iol').':</div>
            			<div class="value">'.$formOpticD.'</div>
					</div>';
            }
            ?>


            <?php
            //toricidad de lente
            if ($toricidadV = get_the_term_list($post->ID, _x('toricidad', 'taxo-name', 'iol'), '', ' - ', '')) {
                echo'
					<div class="bloq-single-lente toricidadC std">
						<div class="label">'._x('Toricidad de la Lente', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
						<div class="value">'.$toricidadV.'</div>
					</div>';
            }?>

            <?php
            //Filtros de lente
            if ($filtrosV = get_the_term_list($post->ID, _x('filtros', 'taxo-name', 'iol'), '', ' - ', '')) {
                echo'
					<div class="bloq-single-lente filtrosC std">
						<div class="label">'._x('Filtros de la Lente', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
						<div class="value">'.$filtrosV.'</div>
					</div>';
            } ?>

            <?php
            //Adicción
            if ($adicionV = get_the_term_list($post->ID, _x('adicion-cerca', 'taxo-name', 'iol'), '', ' - ', '')) {
                echo'
					<div class="bloq-single-lente addCercaC std">
						<div class="label">'._x('Adicción de la Lente', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
						<div class="value">'.$adicionV.'</div>
					</div>';
            } ?>


            <?php
            //Bordes cuadrados
            if ($bordesV = get_the_term_list($post->ID, _x('bordes-cuadrados', 'taxo-name', 'iol'), '', ' - ', '')) {
                echo'
					<div class="bloq-single-lente bordCuadC std">
						<div class="label">'._x('Bordes Cuadrados', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
						<div class="value">'.$bordesV.'</div>
					</div>';
            }?>

            <?php
            //Asfercidad de la lente
            if ($asfercidadV =  get_the_term_list($post->ID, _x('asfericidad', 'taxo-name', 'iol'), '', ' - ', '')) {
                echo'
					<div class="bloq-single-lente asfericiC std">
						<div class="label">'._x('Afericidad de la Lente', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
						<div class="value">'.$asfercidadV.'</div>
					</div>';
            }?>

            <?php
            //Principio optico
            if ($opticoV = get_the_term_list($post->ID, _x('principio-optico', 'taxo-name', 'iol'), '', ' - ', '')) {
                echo'
					<div class="bloq-single-lente pOpticoC std">
						<div class="label">'._x('Principio Óptico', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
						<div class="value">'.$opticoV.'</div>
					</div>';
            }?>

            <?php
              //Diseno-Estructura de lente.
            if ($disenoV = get_the_term_list($post->ID, _x('diseno', 'taxo-name', 'iol'), '', ' - ', '')) {
                echo
                '<div class="bloq-single-lente disenoC std">
					<div class="label">'._x('Diseño-Estructura de la Lente', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
					<div class="value">'.$disenoV.'</div>
				</div>';
            }
            ?>

            <?php
                //Material de la lente
            if ($materialV = get_the_term_list($post->ID, _x('material', 'taxo-name', 'iol'), '', ' - ', '')) {
                echo
                '<div class="bloq-single-lente materialC std">
					<div class="label">'._x('Material de la Lente', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
					<div class="value">'.$materialV.'</div>
				</div>';
            }
            ?>

            <?php
                //Inyector
            if ($inyectorV = get_the_term_list($post->ID, _x('inyector', 'taxo-name', 'iol'))) {
                echo
                '<div class="bloq-single-lente inyectorC std">
					<div class="label">'._x('Inyector', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
					<div class="value">'.strip_tags($inyectorV).'</div>
				</div> ';
            }
            ?>

            <?php
            //Descripción del Inyector
            if ($inyectorD = get_post_meta($post->ID, 'inyectorD', true) and get_post_meta($post->ID, 'inyectorD', true) != '//') {
                echo'
					<div class="bloq-single-lente inyectorDC std">
						<div class="label">'._x('Inyector (D)', 'admin_display', 'iol').':</div>
            			<div class="value">'.$inyectorD.'</div>
					</div>';
            }
            ?>

            <?php
                //Precargada
            if ($precargadaV=get_the_term_list($post->ID, _x('precargada', 'taxo-name', 'iol'), '', ' - ', '')) {
                echo '
				<div class="bloq-single-lente precargadaC std">
					<div class="label">'._x('Precargada', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
					<div class="value">'.$precargadaV.'</div>
				</div>';
            }
            ?>

            <?php
            //diseño de hápticos
            if ($hapticosV = get_the_term_list($post->ID, _x('diseno-hapticos', 'taxo-name', 'iol'))) {
                echo
                '<div class="bloq-single-lente disenoHapticC std">
					<div class="label">'._x('Diseño de Hápticos', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
					<div class="value"> '.strip_tags($hapticosV).'</div>
				</div>';
            }
            ?>


            <?php
                //Diametro óptico
          /*  if ($dopticoV = get_post_meta($post->ID, 'diamOpticD', TRUE) and get_post_meta($post->ID, 'diamOpticD', TRUE) != '//'){
            echo
                '<div class="bloq-single-lente">
                    <div class="label">'._x('Diámetro Óptico','Single_Template','iol_display').':</div>
                    <div class="value"> '.strip_tags($dopticoV).' </div>
                </div>';
            }
            */
            ?>

           <?php
                //Hay que hacer el cambio para que se muestren los valores de array.
                //Diametro óptico
            if (($dopticoV = get_post_meta($post->ID, 'diamOpticD', true) or get_post_meta($post->ID, 'diamOpticD', true)=='0') && (get_post_meta($post->ID, 'diamOpticD', true)!= '//')) {
                $dopticoRaw = get_post_meta($post->ID, 'diamOpticD', false);
                if (count($dopticoRaw)== 1) {
                    echo
                        '<div class="bloq-single-lente diamOptC std">
					        <div class="label">'._x('Diámetro Óptico', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
					        <div class="value"> '.strip_tags($dopticoV).' </div>
				         </div>';
                } else {
                    echo  '<div class="bloq-single-lente std">
					       <div class="label">'._x('Diámetro Óptico', 'Content Lente Intraocular', 'iol_cpt_display').':</div>';
                    echo '<div class="value"> ';
                    for ($i=0; $i<count($dopticoRaw);$i++) {
                        echo  ' '.strip_tags($dopticoRaw[$i]);
                        if ($i != count($dopticoRaw)-1) {
                            echo ' ; ';
                        }
                    }
                    echo   '</div>';
                    echo   '</div>';
                }
            }
            ?>




            <?php
                //Diametro total
        /*	if ($dtotalV = get_post_meta($post->ID, 'diamTotD', TRUE) and get_post_meta($post->ID, 'diamTotD', TRUE) != '//'){
                echo'
                    <div class="bloq-single-lente">
                        <div class="label">'._x('Diámetro Total','Single_Template','iol_display').':</div>
                        <div class="value"> '.strip_tags($dtotalV).'</div>
                    </div>';
            }*/
            ?>

           <?php
                //Hay que hacer el cambio para que se muestren los valores de array.
                //Diametro óptico
            if (($dtotalV = get_post_meta($post->ID, 'diamTotD', true) or get_post_meta($post->ID, 'diamTotD', true)=='0') &&  (get_post_meta($post->ID, 'diamTotD', true) != '//')) {
                $dtotalRaw = get_post_meta($post->ID, 'diamTotD', false);
                if (count($dtotalRaw) == 1) {
                    echo
                        '<div class="bloq-single-lente diamTotC std">
					        <div class="label">'._x('Diámetro Total', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
					        <div class="value"> '.strip_tags($dtotalV).' </div>
				         </div>';
                } else {
                    echo  '<div class="bloq-single-lente std">
					       <div class="label">'._x('Diámetro Total', 'Content Lente Intraocular', 'iol_cpt_display').':</div>';
                    echo '<div class="value"> ';
                    for ($i=0; $i<count($dtotalRaw);$i++) {
                        echo  ' '.strip_tags($dtotalRaw[$i]);
                        if ($i != count($dtotalRaw)-1) {
                            echo ' ; ';
                        }
                    }
                    echo   '</div>';
                    echo   '</div>';
                }
            }
            ?>



            <?php
            //Rango dioptrías esfera
            if ($esferaV = get_post_meta($post->ID, 'stepEsf', true) and get_post_meta($post->ID, 'stepEsf', true) != '//') {
                echo'
					<div class="bloq-single-lente stepEsfC std">
						<div class="label">'._x('Intervalo de Dioptrías Esfera', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
            			<div class="value">'.strip_tags($esferaV).'</div>
					</div>';
            }
            ?>

            <?php
                //Rango diotrías esfera desde
            if ($esferadesdeV = get_post_meta($post->ID, 'esfDesdeD', true) and get_post_meta($post->ID, 'esfDesdeD', true)!= '//') {
                echo
                    '<div class="bloq-single-lente esfDesdeC std">
						<div class="label">'._x('Rango Dioptrías Esfera desde', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
            			<div class="value">'.strip_tags($esferadesdeV).'</div>
					</div>';
            }
            ?>

            <?php
            //Rango dioptricas esfera hasta
                if ($esferahastaV = get_post_meta($post->ID, 'esfHastaD', true) and get_post_meta($post->ID, 'esfHastaD', true)!= '//') {
                    echo
                    '<div class="bloq-single-lente esfHastaC std">
                        <div class="label">'._x('Rango Dioptrías Esfera hasta', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
                        <div class="value">'.strip_tags($esferahastaV).'</div>
                    </div>';
                }
            ?>

            <?php
            //Rango 0,5 dioptrías esfera desde
            if ($esfera5desdeV = get_post_meta($post->ID, 'esf05DesdeD', true) and get_post_meta($post->ID, 'esf05DesdeD', true)!= '//') {
                echo
                    '<div class="bloq-single-lente esfDesdeC std">
						<div class="label">'._x('Rango 0,5 Dioptrías Esfera desde', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
						<div class="value">'.strip_tags($esfera5desdeV).'</div>
					</div>';
            }
            ?>

            <?php
            //Rango 0,5 dioptrías esfera hasta
            if ($esfera5hastaV = get_post_meta($post->ID, 'esf05HastaD', true) and get_post_meta($post->ID, 'esf05HastaD', true)!= '//') {
                echo'
					<div class="bloq-single-lente esfHastaC std">
						<div class="label">'._x('Rango 0,5 Dioptrías Esfera hasta', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
						<div class="value">'.strip_tags($esfera5hastaV).'</div>
					</div>';
            }
            ?>

            <?php
            //Cinlindro dioptrías desde
                if ($cilindrodesdeV =get_post_meta($post->ID, 'cilDesdeD', true) and get_post_meta($post->ID, 'cilDesdeD', true)!= '//') {
                    echo'
                    <div class="bloq-single-lente cilDesdeC std">
                        <div class="label">'._x('Cilindro Dioptrías desde', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
                        <div class="value">'.strip_tags($cilindrodesdeV).'</div>
                    </div>';
                }
            ?>

            <?php
            //Cilindro dioptrías hasta
            if ($cilindrohastaV = get_post_meta($post->ID, 'cilHastaD', true) and get_post_meta($post->ID, 'cilHastaD', true)!= '//') {
                echo'
					<div class="bloq-single-lente cilHastaC std">
						<div class="label">'._x('Cilindro Dioptrías hasta', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
						<div class="value">'.strip_tags($cilindrohastaV).'</div>
					</div>';
            }?>

            <?php
            if ($intervalosV = get_post_meta($post->ID, 'stepCil', true) and get_post_meta($post->ID, 'stepCil', true)!= '//') {
                echo'
                    <div class="bloq-single-lente stepCilC std">
                        <div class="label">'._x('Intervalos cilindro', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
                        <div class="value">'.strip_tags($intervalosV).'</div>
                    </div>';
            }?>

            <?php
            if ($cteAV = get_post_meta($post->ID, 'cteAD', true) and get_post_meta($post->ID, 'cteAD', true)!= '//') {
                echo'
                    <div class="bloq-single-lente cteAC std">
                        <div class="label">'._x('A', 'Content Lente Intraocular', 'iol_theme').':</div>
                        <div class="value">'.$cteAV.'</div>
                    </div>';
            }?>

            <?php
            if ($acdV = get_post_meta($post->ID, 'acdD', true) and get_post_meta($post->ID, 'acdD', true)!= '//') {
                echo'
                    <div class="bloq-single-lente acdC std">
                        <div class="label">'._x('ACD', 'Content Lente Intraocular', 'iol_theme').':</div>
                        <div class="value">'.$acdV.'</div>
                    </div>';
            }?>

            <?php
            if ($surgeonFactorV = get_post_meta($post->ID, 'surgeonFactorD', true) and get_post_meta($post->ID, 'surgeonFactorD', true)!= '//') {
                echo'
                    <div class="bloq-single-lente surgeonFC std">
                        <div class="label">'._x('Surgeon Factor', 'Content Lente Intraocular', 'iol_theme').':</div>
                        <div class="value">'.$surgeonFactorV.'</div>
                    </div>';
            }?>


			 <?php
            //fabricante
            if ($fabricante = get_the_term_list($post->ID, _x('fabricante-lente', 'taxo-name', 'iol'), '', ' - ', '')) {
                echo'
					<div class="bloq-single-lente fabLenteC std">
						<div class="label">'._x('Fabricante de la Lente', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
						<div class="value" itemprop="brand manufacturer" >'.$fabricante.'</div>
					</div>';


                //Vamos a meter aquí lo del distribuidor.
                if ((get_locale()=='es_ES')) {
                    /*$termsDist = wp_get_post_terms( $post->, 'fabricante-lente',  array("fields" => "names") );

                    var_dump($termsDist);*/
                    $arrayDist = get_the_terms($post->ID, _x('fabricante-lente', 'taxo-name', 'iol'));
                    $fabDist = $arrayDist[0];



                    if ($fabDist->slug == 'physiol') {
                        $arrayDist = get_the_terms($post->ID, _x('fabricante-lente', 'taxo-name', 'iol'));
                        $fabDist = $arrayDist[0];

                        echo '
					<div class="bloq-single-lente fabLenteC std physiol">
						<div class="label">'._x('Distribuidor de la lente', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
						<div class="value" itemprop="brand manufacturer" >
						<img src="http://www.nuevocristalino.es/wp-content/uploads/sources/medicalmix/medicalmix-icon.png" height="28" />
						<a href="http://www.nuevocristalino.es/proveedor-de-lentes-intraoculares/medical-mix/">Medical Mix</a>
						</div>
					</div>';
                        echo '<div style="clear:both;height:0px;">&nbsp;</div>';
                    }

                    //ahora con AVISL Y MEDICONTUR.
                    if ($fabDist->slug == 'medicontur') {
                        $arrayDist = get_the_terms($post->ID, _x('fabricante-lente', 'taxo-name', 'iol'));
                        $fabDist = $arrayDist[0];

                        echo '
					<div class="bloq-single-lente fabLenteC std medicontur">
						<div class="label">'._x('Distribuidor de la lente', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
						<div class="value" itemprop="brand manufacturer" >
						<img src="http://www.nuevocristalino.es/wp-content/uploads/sources/avisl/avisl-icon.png" height="28" />
						<a  href="http://www.nuevocristalino.es/proveedor-de-lentes-intraoculares/advanced-vision-iberia/">Advanced Vision Iberia</a>
						</div>
					</div>';
                        echo '<div style="clear:both;height:0px;">&nbsp;</div>';
                    }
                }
            } ?>




			            <?php
                //Ahora las fuentes
            if ($webSourceV = get_post_meta($post->ID, 'webSourceD', true) and get_post_meta($post->ID, 'webSourceD', true)!= '//') {
                echo'
                    <div class="bloq-single-lente webSourceC">
                        <div class="label">'._x('Website Fuente de la Información', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
                        <div class="value"><a href="'.strip_tags($webSourceV).'" target="_blank">Link Web</a></div>
                    </div>'; //'.strip_tags($webSourceV).'
            }

            if ($docSourceV = get_post_meta($post->ID, 'docSourceD', true) and get_post_meta($post->ID, 'docSourceD', true)!= '//') {
                $contentUrl = content_url();
                echo'
                    <div class="bloq-single-lente sourceDoc">
                        <div class="label">'._x('Documento Fuente de la Información', 'Content Lente Intraocular', 'iol_cpt_display').':</div>
                        <div class="value"><a href="'.$contentUrl.'/uploads/sources/'.strip_tags($docSourceV).'" class="noGotoMain" target="_blank">'.get_the_title($post->ID).'</a></div>
                    </div>';//'.strip_tags($docSourceV).' => en el metadata sólo va la parte que interesa de la url no toda entera
            }



            ?>







          </div>


			<?php wp_link_pages(array( 'before' => '<div class="page-links">' . __('Pages:', 'twentytwelve'), 'after' => '</div>' )); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

		<footer class="entry-meta">

		</footer><!-- .entry-meta -->

    <?php edit_post_link(__('Edit', 'twentytwelve'), '<p class="edit-link">', '</p>'); ?>

	</article><!-- #post -->
            <br>
            <br>
