<?php
/*
 * Template Name: Template Buscador Iol
 * Description: Este es el template para las p‡ginas de mis ojos.
*/


 get_header('buscador-iol');



?>


<noscript>
  <style type="text/css">.startsUgly { display: block; }</style>
</noscript>


<?php


    $currentPage = (get_query_var('paged'))? (get_query_var('paged')) : 1;

?>




    <div id="primary" class="site-content-archive-lentes">

    <?php
        //metemos el segundo de los banners

                $langDetect = substr(get_locale(), 0, 2);
                $langLocale = strtolower(substr(get_locale(), 3, 2));

        if ($langDetect == 'es') {

        //echo 	$langDetect;
        ?>


	<?php
        }

    ?>




<!-- .archive-header -->

     <div id="preButtonSet" >
   	 <form class="startsUgly">
    		<label class="labelIolName"><?php echo _x('Búsqueda de lente por nombre:', 'Archive Lente Intraocular', 'iol_cpt_display'); /* Buscar lente por nombre: */ ?> </label>
    		<input id="iolName" type="text">
   	 </form>
    <!-- Vamos a meter un botón que nos permita refrescar la búsqueda -->
    	<button id="searchReset">
    		<?php echo _x('Resetear Búsqueda', 'Archive Lente Intraocular', 'iol_cpt_display'); ?>
    	</button>
    </div>


		<div id="content" role="main">

            <!-- Vamos a poner estos dos divs para tener sincronizado el marcado de la página estática con la viene de ajax-->
            <div id="AjaxContainerFixer" style="min-height:200px;"><div id="IOL_Filtradas">

            <?php
                    $url =  home_url($wp->request);
                    //echo $url;
                    $pos = strrpos($url, '/page/');
                    //echo 'posicion:'.$pos;
                    if ($pos) {
                        $base = substr($url, 0, $pos);
                    } else {
                        $base = $url;
                    }
            ?>

			<?php
            //echo 'Comprobación de herencia de valor de viewType';
            $Grid = true;


            if (array_key_exists('viewType', $_GET)) {
                if ($_GET['viewType']== 'Grid') {
                    $Grid= true;
                }
            } else {
                $Grid= true;
            }

            ?>

            <?php
            //Aquí no nos vale con el main loop de inicio. Tenemos que definir el nuestro de lios.
            $tax_RestricActiveIol = array(
                               'taxonomy'=> _x('estatus-comercial', 'taxo-name', 'iol'),
                               'terms'   => array(_x('retirada', 'taxo-value-slug', 'iol-scaffold')), //$adiciones_filter,//array('alta'),
                               'field' => 'slug',
                               'operator' => 'NOT IN',
                                );

            $bIOLargs =  array('post_type'=> _x('lente-intraocular', 'CustomPostType Name', 'iol'),
                               'posts_per_page' => 12,
                               'orderby'=> 'meta_value_num',
                               'order'=>'DESC',
                               'meta_key'=>'nivelPrefLenteMD',
                               'paged' => $currentPage,
                               'tax_query' => array($tax_RestricActiveIol)
                               );




            $wp_query = new WP_Query($bIOLargs);

            ?>


            <?php if ($wp_query->have_posts()) : ?>

    			<?php while ($wp_query->have_posts()) : $wp_query->the_post();?>

                 <?php
                         if ($Grid) {
                             get_template_part('content-grid-lente-intraocular-buscador-iol', get_post_format());
                         } else {
                             get_template_part('content-archive-lente-intraocular-buscador-iol', get_post_format());
                         }

                        ?>
                    <?php	/* get_template_part( 'content-archive-lente-intraocular', get_post_format() );*/ ?>

    			<?php endwhile;?>

    		<?php else : ?>

            <?php
                echo '<div class="NoIolWrapper">
                      <div class="innerNoneIolWrapper">
                            <div id="NoIolImg">
                            <img src="'.content_url().'/uploads/2013/08/noencontrado.png" />
                            </div>
                      <div class="NoIol">
                            <p class="mensNotTitle">'._x("No hay ninguna Lente Intraocular con los criterios de filtrado actuales.", "Archive Lente Intraocular", "iol_cpt_display").'</p>
                            <p class="mensNotMessage">'._x("Proceda a realizar una nueva búsqueda cambiando los criterios.", "Archive Lente Intraocular", "iol_cpt_display").'</p>
                      </div>
                        <div style="clear:both;height:0px;">&nbsp;</div>
                      </div>
                      </div>';
                ?>

            <?php endif; ?>

                                <!-- Cerramos a continuación los dos divs auxiliares que nos vienen desde ajax-->

         <!-- Vamos a poner en este div todos los ids de los inputs que hay que deshabilitar -->
		<?php

$cssUndefinedMetaDataSelector = '';
if ($UndefinedMetaDataSelector) {
    $cssUndefinedMetaDataSelector =  join(", ", $UndefinedMetaDataSelector);
} ?>
		<div id="inputSelectorsToDisable" style="display:none;"><?php echo $cssUndefinedMetaDataSelector;?></div>

         </div></div>

        <?php


     //Procesamos la query string para quitar el parámetro page en caso de que nos venga puesto.
     //Además tenemos que garantizar la continuidad en el link de paginación de los parámetros que nos vengan en la query string =>
     //Por ejemplo cuando las consultas no se hagan por ajax los parámetros le vienen de la url del navegador.
     $qString = $_SERVER['QUERY_STRING'];
     $qString = str_replace('?', '', $qString);
     parse_str($qString, $aParams);//explode("&",$qString );

     foreach ($aParams as $key => $value) {
         $aParams[$key] = urlencode($aParams[$key]);
     }

     /*
     foreach($data as $key => $value)
{
  $data[$key]['transaction_date'] = date('d/m/Y',$value['transaction_date']);
}
*/
     //print_r($aParams);

     if (array_key_exists('page', $aParams)) {
         unset($aParams['page']);
     } else {
     }

        //No queremos mostrar toda una ristra de páginas porque puede romper la maquetación, como máximo 5.
        if ($wp_query->max_num_pages > 6) {
            $maxNumPages = 6;
        } else {
            $maxNumPages =$wp_query->max_num_pages;
        }

        //$base= home_url($wp->request)  ;//$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
        //Añadimos la paginación al archive template.
        echo '<div style="clear:both; height:0px;">&nbsp;</div>';
     echo '<div id="PaginationWrapper" ><div id="LinkPages"  class="archiveLenteIntraocularAjaxer">'.paginate_links(
         array(
                                                         'current' => $currentPage,
                                                         'base' => $base.'%_%',
                                                         'total' => $wp_query->max_num_pages,
                                                         'prev_next' =>true,
                                                         'show_all' => true,
                                                         'format' => '/page/%#%/',//'/?page=%#%',//'/page/%#%',//'/?page=%#%',
                                                         'prev_text'=>'<',
                                                         'next_text'=>'>',
                                                         'add_args' => $aParams
                                                          )
                                                          ).'</div></div></br>';

     echo '<div id="PaginationWrapperBis" ><div id="LinkPagesBis"  class="archiveLenteIntraocularAjaxer">'.paginate_links(
         array(
                                                         'current' => $currentPage,
                                                         'base' => $base.'%_%',
                                                         'total' => $maxNumPages,
                                                         'prev_next' =>true,
                                                         'show_all' => false,
                                                         'end_size'=>'1',
                                                         'mid_size'=>'1',
                                                         'format' => '/page/%#%/',//'/?page=%#%',//'/page/%#%',//'/?page=%#%',
                                                         'prev_text'=>'<',
                                                         'next_text'=>'>',
                                                         'add_args' => $aParams
                                                          )
                                                          ).'</div></div></br>';

        ?>


		</div><!-- #content -->

		<!-- Gif que va en sustitución de la lista de lentes intraoculares durante la petición ajax ->images/ajax-loader.gif -->
        <div id="loadingGif">
            <div id="loaderDiv"><img src="<?php echo get_stylesheet_directory_uri()."/images/newAjaxLoader.gif";  ?>" />
            </div>
        </div>

		<?php
          //Vamos a poner un div auxiliar que nos permita identificar que estamos en el Archive template.
          //En la página de explicación de pacientes teníamos uno en el template: id= tipoIolTemplate.
          //aquí será archiveIolTemplate y en el single: singleIolTemplate, en todos va ubicado dentro de content.

          echo '<div id="archiveIolTemplate" style="display:none; visibility:hidden;">&nbsp;</div>';
          echo '<div id="currentQueryString" style="display:none; visibility:hidden;">&nbsp;</div>';

        ?>
	</div><!-- #primary -->

<?php
            echo '<div id="rightBuscadorIol">';

            echo '<div id="right" class="filter-right">';
                include(ABSPATH . 'wp-content/plugins/lente-intraocular/right-buscador-iol.php');
            echo '</div>';

            echo '</div>';



    ?>

<!-- Vamos a poner aquí toda la información relativa a la búsqueda realizada-->
<!-- Lo haremos dumpeando el contenido de $iolAudit -->
<!-- Directamnete cuando se descargue el archive.php y mediante javascript en la respuesta ajax -->

<div id="iolInfoPannel" class="draggable">
    <div  class="resizable">
        <div id="resizableTitle">
                        <span id="dragger" class="ui-icon ui-icon-arrow-4-diag">&nbsp;</span>
        <h4 id="expanderHead" style="cursor:pointer;"><span class="infoIolHeaderTitle"><?php echo _x("Información sobre la Búsqueda realizada", "Archive Lente Intraocular", "iol_cpt_display"); ?></span> <span id="expanderSign" class="ui-icon ui-icon-carat-1-e">&nbsp;</span>
        </h4>
        <!-- Vamos a meter aquí un botón que permita "cerrar"-> comprimir y mandar arriba a la izquierda el panel de información -->
         <div id="iolActionsContainer">
         	<button id="iolInfoPannelClose"><?php echo _x("Cerrar", "Archive Lente Intraocular", "iol_cpt_display"); ?></button>
         	<button id="iolInfoPannelMini"><?php echo _x("Minimizar", "Archive Lente Intraocular", "iol_cpt_display"); ?></button>
         	<button id="iolInfoPannelMaxi"><?php echo _x("Maximizar", "Archive Lente Intraocular", "iol_cpt_display"); ?></button>
         </div>
        <!-- Fin del button -->
            <div style="height: 0px; clear: both;">&nbsp;</div>
        </div>
            <div id="expanderContent" style="display:none">
                <?php

                if (count($iolAudit)) {
                    echo '<div id="numLentes"> ';
                    printf(_x("Hay &nbsp; %d lentes encontradas", "Archive Lente Intraocular", "iol_cpt_display"), $wp_query->found_posts);
                    echo '</div>';

                    echo '<div id="titleExplanation">'._x("Las lentes mostradas cumplen las siguientes características:.", "Archive Lente Intraocular", "iol_cpt_display").'</div>';

                    echo '<ul>';
                    foreach ($iolAudit as $infoFilter) {
                        echo '<li><span class="auditVariableName">'.$infoFilter['text'].'</span><span class="auditVariableValue">'.$infoFilter['value'].'</span></li>';
                    }
                    echo '</ul>';

                    //Añadimos las variables que no se han especificado. -> El array not specified está cargado desde el rightform pero
                    //habrá que cargarlo desde el iolengine
                    echo '<br />';
                    echo '<div id="titleNotIncludedExplanation">'._x("Variables que no se han especificado:", "Archive Lente Intraocular", "iol_cpt_display").'</div>';
                    echo '<ul>';
                    foreach ($NotEspecified as $NS) {
                        //echo var_dump($NotEspecified);
                        echo '<li><span class="notProvidedMens">'.$NS['mens'].'</span></li>';
                    }
                    echo '</ul>';
                } else {
                    echo _x("No hay ninguna restricción impuesta a las lentes, se están mostrando todas las disponibles.", "Archive Lente Intraocular", "iol_cpt_display");
                }
                   ?>
            </div>
    </div>
</div>



    <!-- Diav auxiliar para detectar que estamos en un archive iol template -->
   	<div id="archiveIolTemplate"> &nbsp;</div>
<?php wp_reset_query();?>
<?php get_footer('buscador-iol'); ?>
