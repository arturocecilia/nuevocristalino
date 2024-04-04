<?php
/*
 * Template Name: Template Resultado búsquedas de paciente.
 * Description: Este es el template de la página que muestra el resultado de las búsquedas hechas por el paciente.
 */


get_header(); ?>

<noscript>
  <style type="text/css">.startsUgly { display: block; }</style>
</noscript>

<?php
    //Aquí vamos a meter todo el código de proceso.
    //vamos a crear un nuevo objeto WP_Query.
    $args = array('post_type'=> _x('lente-intraocular','CustomPostType Name','iol'));
    //La página actual de la búsqueda la sacaremos aprovechando las rewrite rules-get_query_var de wordpress:
    $currentPage = (get_query_var('page'))? (get_query_var('page')) : 1;
    $args['paged']=$currentPage;
    //Empezamos con el procesamiento de los inputs que nos vienen desde el formulario.
    if (isset($_GET['tipo-lente'])) {
    //The parameter you need is present
    $tipoLente = $_GET['tipo-lente'];

    //En función del input type="radio" con name="tipo-lente" le iremos dirigiendo hacia un valor de taxonomía de "tipo-lente-intraocular" y "diseno-optica".
    switch ($tipoLente) {

    case 'monofocal':
        $args['diseno-optica'] = 'monofocal';   
        echo 'El diseño de la óptica es monofocal';     
        break;
    case 'monofocal-asferica':
        $args['diseno-optica'] = 'monofocal-asferica';        
        break;
    case 'multifocal-bifocal':
        $args['diseno-optica'] = 'multifocal-bifocal';          
        break;
    case 'multifocal-trifocal':
        $args['diseno-optica'] = 'multifocal-trifocal';   
        break;
    case 'acomodativa':
        $args['diseno-optica'] = 'acomodativa';   
        break;
    case 'ajustable-por-luz':
        $args['diseno-optica'] = 'ajustable-por-luz';   
        break;
    case 'add-on-monofocal':
        $args['diseno-optica'] = 'monofocal';
        $args['tipo-lente-intraocular'] = 'Add-On';
        break;
    case 'add-on-multifocal':
        $args['diseno-optica'] = 'multifocal';
        $args['tipo-lente-intraocular'] = 'Add-On';        
        break;
     case 'icl':
        $args['tipo-lente-intraocular'] = 'icl';         
        break;
     case 'verisyse':
        $args['tipo-lente-intraocular'] = 'verisyse';
        break;
    }
    }
    //Ahora especificamos el valor recibido de toricidad desde el input type="radio" con name = "correcAstig".
       if (isset($_GET['correcAstig'])) {
           $toricidad = $_GET['correcAstig'];
          switch ($toricidad) {
              case 'toricidad-si':
                $args['toricidad'] = 'torica';        
              break;
            case 'toricidad-no':
                $args['toricidad'] = 'no-torica';          
            break;
            }
       }
    //Ahora incluiremos los filtros:
    if (isset($_GET['luz-ultravioleta']) && isset($_GET['luz-azul']) ) {
        $args['filtros'] = array('luz-ultravioleta','luz-azul');
    }
    else{
         if (isset($_GET['luz-ultravioleta'])){
             $args['filtros'] = 'luz-ultravioleta';
         }
         if(isset($_GET['luz-azul'])){
             $args['filtros'] = 'luz-azul';
         }

    }

    $iol_paciente = new WP_Query($args);

    //var_dump($iol_paciente->query_vars);

   // echo '<br /><br /><br /><br /><br />EEEEEE'.(get_query_var('page')).'<br /><br /><br /><br /><br />';

   // echo  $iol_paciente->request;
?>


    <div id="primary" class="site-content-archive-lentes">
       
            <div class="archive-header">
				<h1 class="archive-title"><?php echo _x('LAS LENTES INTRAOCULARES RESULTANTES DE SU BÚSQUEDA SON:','Template Resultado Busquedas de Paciente','iol_theme'); ?></h1>
			</div><!-- .archive-header -->
        <!-- Gif que va en sustitución de la lista de lentes intraoculares durante la petición ajax ->images/ajax-loader.gif -->
        <div id="loadingGif"><div id="loaderDiv"><img src="<?php echo get_stylesheet_directory_uri().'/iolPluginTemplates/images/newAjaxLoader.gif'; ?>" /></div></div> 

		<div id="content" role="main">
              
            <!-- Vamos a poner estos dos divs para tener sincronizado el marcado de la página estática con la viene de ajax-->
            <div id="AjaxContainerFixer" style="min-height:200px;"><div id="IOL_Filtradas">

            <?php 
                    $url =  home_url($wp->request);
                    //echo $url;
                    $pos = strrpos ($url , '/busqueda-de-lentes-intraoculares-del-paciente')+ strlen('/busqueda-de-lentes-intraoculares-del-paciente') ; 
                    //echo '<br />Desde el 0 hasta:'.$pos.'!!!!!';
                    $numPag1Cifra = substr($url, -2, 1); // Si el número de página es de una cifra
                    $numPag2Cifras = substr($url, -3, 2); // Si el número de página es de una cifra
                   
                    $base = substr ( $url ,0 ,$pos );

                   // echo 'Esta es la base¡¡¡¡'.$base.'&nbsp;  Qué ha pasado¡¡¡¡<br />'; 
                    //echo 'posicion:'.$pos;
                   /* if(is_numeric() or is_numeric())
                    {
                    $base = substr ( $url ,0 ,$pos );                        
                    }
                    else{
                        $base = $url;
                    }*/
            ?> 

            <?php if ( $iol_paciente->have_posts() ) : ?>

    			<?php while ( $iol_paciente->have_posts() ) : $iol_paciente->the_post();?>

                    <?php	get_template_part( 'content-archive-lente-intraocular-paciente', get_post_format() ); ?>

    			<?php endwhile;?>
                       
    		<?php else : ?>
    
            <?php   
                echo '<div class="NoIolWrapper">
                      <div class="innerNoneIolWrapper">
                            <div id="NoIolImg">
                            <img src="'.content_url().'/uploads/2013/08/noencontrado.png" />
                            </div>
                      <div class="NoIol">
                            <p class="mensNotTitle">'._x('No hay ninguna Lente Intraocular con los criterios de filtrado actuales.','Template Resultado Busquedas de Paciente','iol_theme').'</p>
                            <p class="mensNotMessage">'._x('Proceda a realizar una nueva búsqueda cambiando los criterios.','Template Resultado Busquedas de Paciente','iol_theme').'</p>
                      </div>
                        <div style="clear:both;height:0px;">&nbsp;</div>
                      </div>
                      </div>';
                ?>
		    
            <?php endif; ?>

                                <!-- Cerramos a continuación los dos divs auxiliares que nos vienen desde ajax-->
         </div></div>

        <?php 
        //Tenemos que añadir los parámetros que traemos.
            //Procesamos la query string para quitar el parámetro page en caso de que nos venga puesto.
            $qString = $_SERVER['QUERY_STRING'];
            $qString = str_replace('?','',$qString);
            parse_str($qString,$aParams);//explode("&",$qString );        
     
     //print_r($aParams);
          
/*             if(array_key_exists ('page',$aParams)){
                unset($aParams['page']);
             } else{
         
            }
            */

        //$base= home_url($wp->request)  ;//$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
        //Añadimos la paginación al archive template.
        echo '<div style="clear:both; height:0px;">&nbsp;</div>';
     echo '<br><div id="PaginationWrapper"><div id="LinkPages"  class="archiveLenteIntraocularAjaxer">'.paginate_links(array(
                                                         'current' => $currentPage,
                                                         'base' => $base.'%_%',//.'%_%',
                                                         'total' => $iol_paciente->max_num_pages,
                                                         'prev_next' =>TRUE,
                                                         'show_all' => TRUE,
                                                         'format' => '/%#%/',//'/?page=%#%',//'/page/%#%/',//'/?page=%#%',//'/page/%#%',//'/?page=%#%',
                                                         'prev_text'=>'<',
                                                         'next_text'=>'>',
                                                         'add_args' => $aParams
                                                          )
                                                          ).'</div></div></br>';
        
        ?>




            

		</div><!-- #content -->
	</div><!-- #primary -->
    <div id="right" class="filter-right patient-filter">
        <?php  include('patient-form.php');  ?>
   </div>
<?php wp_reset_query();?>
<?php get_footer(); ?>