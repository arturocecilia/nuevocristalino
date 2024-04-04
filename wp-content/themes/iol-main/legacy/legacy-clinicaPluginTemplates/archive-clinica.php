<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Twelve already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>


 
<?php   
$currentPage = (get_query_var('paged'))? (get_query_var('paged')) : 1;//(get_query_var('page')) ? get_query_var('page') : 1; //$_GET['paged'] ? $_GET['paged'] : 1;
?>	
    <div id="primary" class="site-content-archive-clinica">
    
    <div class="archive-header">
				<h1 class="archive-title">
                LAS CLÍNICAS QUE CUMPLEN CON LOS CRITERIOS DE SU BÚSQUEDA 
                </h1>
			</div>
    
        <div id="loadingGif">
            <div id="loaderDiv">
                <img src="<?php echo plugins_url( "images/ajax-loader.gif" , __FILE__ ); ?>" />
            </div>
        </div> 
		<div id="content" role="main">
          
          <!-- Adaptación a AJAX y Paginación --> 
                      <div id="AjaxContainerFixer" style="min-height:200px;"><div id="IOL_Filtradas">

            <?php 
                    $url =  home_url($wp->request);
                    //echo $url;
                    $pos = strrpos ($url , '/page/');  
                    //echo 'posicion:'.$pos;
                    if($pos)
                    {
                    $base = substr ( $url ,0 ,$pos );                        
                    }
                    else{
                        $base = $url;
                    }
            ?> 
          
          
          <!-- Fin adaptación a AJAX y Paginación -->
          
          

            <?php if ( have_posts() ) : ?>
			<!-- <div class="archive-header">
				<h1 class="archive-title">
                LAS CLÍNICAS QUE CUMPLEN CON LOS CRITERIOS DE SU BÚSQUEDA 
                </h1>
			</div> -->
			<!-- .archive-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part( 'content-archive-clinica', get_post_format() );

			endwhile;

			//twentytwelve_content_nav( 'nav-below' );
			?>

		<?php else : ?>
			
			<?php   
                echo '<div class="NoClinicaWrapper">
                      <div class="innerNoneClinicaWrapper">
                            <div id="NoClinicaImg">
                            <img src="'.content_url().'/uploads/2013/08/noencontrado.png" />
                            </div>
                      <div class="NoIol">
                            <p class="mensNotTitle">No hay ninguna Lente Intraocular con los criterios de filtrado actuales.</p>
                            <p class="mensNotMessage">Proceda a realizar una nueva búsqueda cambiando los criterios.</p>
                      </div>
                        <div style="clear:both;height:0px;">&nbsp;</div>
                      </div>
                      </div>';
                ?>
			
			
		<?php endif; ?>
		                                
         </div></div>

        <?php 


     //Procesamos la query string para quitar el parámetro page en caso de que nos venga puesto.
     //Además tenemos que garantizar la continuidad en el link de paginación de los parámetros que nos vengan en la query string => 
     //Por ejemplo cuando las consultas no se hagan por ajax los parámetros le vienen de la url del navegador.
     $qString = $_SERVER['QUERY_STRING'];
     $qString = str_replace('?','',$qString);
     parse_str($qString,$aParams);//explode("&",$qString );        
     
     //print_r($aParams);
          
     if(array_key_exists ('page',$aParams)){
         unset($aParams['page']);
     } else{
         
     }
		
	
        //Añadimos la paginación al archive template.
        echo '<div style="clear:both; height:0px;">&nbsp;</div>';
        
        echo '<br><div id="PaginationWrapper"><div id="LinkPages">'.paginate_links(array(
                                                         'total' => $wp_query->max_num_pages,
                                                         'current' => $currentPage,   
                                                         'prev_next' =>TRUE,
                                                         'base' => $base.'%_%',                  
                                                         'show_all' => TRUE,
                                                         'format' => '/page/%#%/',//'?paged=%#%',
                                                         'prev_text'=>'<',
                                                         'next_text'=>'>',
                                                         'add_args' => $aParams
                                                          )
                                                          ).'</div></div></br>';
        ?>

		</div><!-- #content -->

    <?php 
        //Ponemos un div auxiliar para poder identificar el template, ponemos otro para cargar la query.
        echo '<div id="archiveClinicaTemplate" style="display:none">&nbsp;</div>';
        echo '<div id="currentQueryString" style="display:none; visibility:hidden;">&nbsp;</div>';
        ?>

	</div><!-- #primary -->

<?php  include('right-archive-clinica.php');  ?>











<!-- Metemos la parte del ClinicaInfoPannel -->

<div id="clinicaInfoPannel" class="draggable">
    <div  class="resizable">
        <div id="resizableTitle">
                        <span id="dragger" class="ui-icon ui-icon-arrow-4-diag">&nbsp;</span>
        <h4 id="expanderHead" style="cursor:pointer;"><span class="infoIolHeaderTitle">Información sobre la Búsqueda de Clínicas realizada</span> <span id="expanderSign" class="ui-icon ui-icon-carat-1-e">&nbsp;</span>
        </h4>
        <!-- Vamos a meter aquí un botón que permita "cerrar"-> comprimir y mandar arriba a la izquierda el panel de información -->
         <div id="clinicaActionsContainer">
         	<button id="clinicaInfoPannelClose">Cerrar</button>
         	<button id="clinicaInfoPannelMini">Minimizar</button>
         	<button id="clinicaInfoPannelMaxi">Maximizar</button>        
         </div>
        <!-- Fin del button -->
            <div style="height: 0px; clear: both;">&nbsp;</div>
        </div>
            <div id="expanderContent" style="display:none">
                <?php 
                 
                if(count($clinicaAudit)) 
                   {
                       echo '<div id="numLentes"> Hay &nbsp;'.$wp_query->found_posts.' clínicas encontradas</div>';

                        echo '<div id="titleExplanation"> Las clínicas mostradas cumplen las siguientes características:</div>';
	                      
                        echo '<ul>';
                        foreach($clinicaAudit as $infoFilter){
                           
                            echo '<li><span class="auditVariableName">'.$infoFilter['text'].'</span><span class="auditVariableValue">'.$infoFilter['value'].'</span></li>';

                        }
                        echo '</ul>';
                   
                   //Añadimos las variables que no se han especificado. -> El array not specified está cargado desde el rightform pero
                   //habrá que cargarlo desde el iolengine
                   echo '<br />';
                   echo '<div id="titleNotIncludedExplanation">Variables que no se han especificado:</div>';
                   echo '<ul>';
                   	foreach($clinicaNotEspecified as $NS){
                   		//echo var_dump($NotEspecified);
                   		echo '<li><span class="notProvidedMens">'.$NS['mens'].'</span></li>';
                   	}
                   echo '</ul>';
                   }
                   else{
                        echo 'No hay ninguna restricción impuesta a las clínicas, se están mostrando todas las disponibles.';     
                   }
                   ?>
            </div>
    </div>
</div>

<?php get_footer(); ?>