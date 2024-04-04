<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>


<?php //var_dump($wp_query); ?>

<?php // echo 'Post type desde wp_query'.$wp_query->post_type; ?>

<?php $postTypeRequired = get_query_var('post_type');?>


<?php //SI WP identifica el post type iremos mostrando las distitnas opciones ?>  


<?php 
    //////////////////////////////////////////
    //CPT ==> clinica 
    //////////////////////////////////////////
 ?>
<?php  if ( $postTypeRequired == 'clinica' ) { ?><br>  
<!-- Aquí poemos el contenido central del archive clínica, puesto que sólo se me ocurre que el usuario haya acabado aquí buscando una clínica desde la página de clínicas -->

<!-- Inicio contenido central de archive clínica -->

<?php   
$currentPage = (get_query_var('paged'))? (get_query_var('paged')) : 1;//(get_query_var('page')) ? get_query_var('page') : 1; //$_GET['paged'] ? $_GET['paged'] : 1;
?>	
    <div id="primary" class="site-content-archive-clinica">
    
    <div class="archive-header">
				<h1 class="archive-title">
                <?php echo '404 => '.$postTypeRequired; ?>
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
                      404 => '.$postTypeRequired.'
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

<?php  include('clinicaPluginTemplates/right-archive-clinica.php');  ?>



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



<!-- Fin contenido central e archive clínica -->

<?php  } ?>

<?php 
    //////////////////////////////////////////
    //FINALIZACIÓN CPT ==> clinica 
    //////////////////////////////////////////
 ?>




<?php 
    //////////////////////////////////////////
    //CPT ==> lente-intraocular 
    //////////////////////////////////////////
 ?>


<?php if ( $postTypeRequired == 'lente-intraocular' ) { ?><br>  
<p>Estabas tratando de encontrar una lente intraocular</p><br>  
<!-- Inicio Contenido Archive Estándar por si está buscando una lente intraocular -->
<noscript>
  <style type="text/css">.startsUgly { display: block; }</style>
</noscript>



<?php  
  

    $currentPage = (get_query_var('paged'))? (get_query_var('paged')) : 1;//max(1, get_query_var('paged'));//(get_query_var('paged'))? (get_query_var('paged')) : 1;;//$_GET['page'] ? $_GET['page'] : 1;;//(get_query_var('page'))? (get_query_var('page')) : 1;//(get_query_var('page')) ? get_query_var('page') : 1; //$_GET['paged'] ? $_GET['paged'] : 1;
    
     //$currentPage = get_query_var('paged');
  
     
   //Necesitamos además restringir más la query 

   //echo  $GLOBALS['wp_query']->request;

?>	

 
    <div id="primary" class="site-content-archive-lentes">
            <div class="archive-header">
				<h1 class="archive-title">LAS LENTES INTRAOCULARES RESULTANTES DE SU BÚSQUEDA SON:</h1>
			</div><!-- .archive-header -->
        <!-- Gif que va en sustitución de la lista de lentes intraoculares durante la petición ajax ->images/ajax-loader.gif -->
        <div id="loadingGif"><div id="loaderDiv"><img src="<?php echo plugins_url( "images/newAjaxLoader.gif" , __FILE__ ); ?>" /></div></div> 

		<div id="content" role="main">
              
            <!-- Vamos a poner estos dos divs para tener sincronizado el marcado de la página estática con la viene de ajax-->
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


            <?php if ( have_posts() ) : ?>

    			<?php while ( have_posts() ) : the_post();?>
                  
                 <?php    if(isset($_GET['pt'])){
                               get_template_part( 'content-archive-lente-intraocular-paciente', get_post_format() );
                        }
                    else{
                               get_template_part( 'content-archive-lente-intraocular', get_post_format() );
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
                            <p class="mensNotTitle">No hay ninguna Lente Intraocular con los criterios de filtrado actuales.</p>
                            <p class="mensNotMessage">Proceda a realizar una nueva búsqueda cambiando los criterios.</p>
                      </div>
                        <div style="clear:both;height:0px;">&nbsp;</div>
                      </div>
                      </div>';
                ?>
		    
            <?php endif; ?>

                                <!-- Cerramos a continuación los dos divs auxiliares que nos vienen desde ajax-->
                                
         <!-- Vamos a poner en este div todos los ids de los inputs que hay que deshabilitar -->
		<?php 	$cssUndefinedMetaDataSelector =  join(", ",$UndefinedMetaDataSelector); ?> 
		<div id="inputSelectorsToDisable" style="display:none;"><?php echo $cssUndefinedMetaDataSelector;?></div>                       
                                
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


        //$base= home_url($wp->request)  ;//$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
        //Añadimos la paginación al archive template.
        echo '<div style="clear:both; height:0px;">&nbsp;</div>';
     echo '<br><div id="PaginationWrapper"><div id="LinkPages"  class="archiveLenteIntraocularAjaxer">'.paginate_links(array(
                                                         'current' => $currentPage,
                                                         'base' => $base.'%_%',
                                                         'total' => $wp_query->max_num_pages,
                                                         'prev_next' =>TRUE,
                                                         'show_all' => TRUE,
                                                         'format' => '/page/%#%/',//'/?page=%#%',//'/page/%#%',//'/?page=%#%',
                                                         'prev_text'=>'<',
                                                         'next_text'=>'>',
                                                         'add_args' => $aParams
                                                          )
                                                          ).'</div></div></br>';
        
        ?>
            

		</div><!-- #content -->
		<?php 
		  //Vamos a poner un div auxiliar que nos permita identificar que estamos en el Archive template.
		  //En la página de explicación de pacientes teníamos uno en el template: id= tipoIolTemplate.
		  //aquí será archiveIolTemplate y en el single: singleIolTemplate, en todos va ubicado dentro de content.
		  
		  echo '<div id="archiveIolTemplate" style="display:none; visibility:hidden;">&nbsp;</div>';
          echo '<div id="currentQueryString" style="display:none; visibility:hidden;">&nbsp;</div>';
		   
		?>
	</div><!-- #primary -->

<?php  

            if(isset($_GET['pt'])){
                    echo '<div id="right" class="filter-right">';//patient-filter single-lente
                    //Incluimos antes los botones.
					echo '<div id="changeFilter">';
						echo '<button id="advLoader" type="radio" data-action="getAdvForm">Menú Avanzado</button>';
    					echo '<button id="patientLoader"type="radio" data-action= "getPatientForm">Menú Sencillo</button>';
					echo '</div>';
					//Incluimos después el formulario.
                    include('iolPluginTemplates/archive-patient-form.php');  
                    echo  '</div>';
            }
            else{
            //include('right-single-lente-intraocular.php');
            echo '<div id="right" class="filter-right">';
            //Inluimos antes que el form los botones.
			echo '<div id="changeFilter">';
				echo '<button id="advLoader" type="radio" data-action="getAdvForm">Menú Avanzado</button>';
    			echo '<button id="patientLoader"type="radio" data-action= "getPatientForm">Menú Sencillo</button>';
			echo '</div>';
				//Incluimos el form
	        	include('iolPluginTemplates/right-archive-lente-intraocular.php');
	        echo '</div>';              
            }

	
	?>

<!-- Vamos a poner aquí toda la información relativa a la búsqueda realizada-->
<!-- Lo haremos dumpeando el contenido de $iolAudit -->
<!-- Directamnete cuando se descargue el archive.php y mediante javascript en la respuesta ajax -->
<?php 
//$iolAudit[] = array('text'=>'La query global que se ha ejecutado es: <br /><br />','value'=>'<div id="infoQuery">'.$wp_query->request.'</div>'); 
?>


<div id="iolInfoPannel" class="draggable">
    <div  class="resizable">
        <div id="resizableTitle">
                        <span id="dragger" class="ui-icon ui-icon-arrow-4-diag">&nbsp;</span>
        <h4 id="expanderHead" style="cursor:pointer;"><span class="infoIolHeaderTitle">Información sobre la Búsqueda realizada</span> <span id="expanderSign" class="ui-icon ui-icon-carat-1-e">&nbsp;</span>
        </h4>
        <!-- Vamos a meter aquí un botón que permita "cerrar"-> comprimir y mandar arriba a la izquierda el panel de información -->
         <div id="iolActionsContainer">
         	<button id="iolInfoPannelClose">Cerrar</button>
         	<button id="iolInfoPannelMini">Minimizar</button>
         	<button id="iolInfoPannelMaxi">Maximizar</button>        
         </div>
        <!-- Fin del button -->
            <div style="height: 0px; clear: both;">&nbsp;</div>
        </div>
            <div id="expanderContent" style="display:none">
                <?php 
                 
                if(count($iolAudit)) 
                   {
                       echo '<div id="numLentes"> Hay &nbsp;'.$wp_query->found_posts.' lentes encontradas</div>';

                        echo '<div id="titleExplanation"> Las lentes mostradas cumplen las siguientes características:</div>';
	                      
                        echo '<ul>';
                        foreach($iolAudit as $infoFilter){
                           
                            echo '<li><span class="auditVariableName">'.$infoFilter['text'].'</span><span class="auditVariableValue">'.$infoFilter['value'].'</span></li>';

                        }
                        echo '</ul>';
                   
                   //Añadimos las variables que no se han especificado. -> El array not specified está cargado desde el rightform pero
                   //habrá que cargarlo desde el iolengine
                   echo '<br />';
                   echo '<div id="titleNotIncludedExplanation">Variables que no se han especificado:</div>';
                   echo '<ul>';
                   	foreach($NotEspecified as $NS){
                   		//echo var_dump($NotEspecified);
                   		echo '<li><span class="notProvidedMens">'.$NS['mens'].'</span></li>';
                   	}
                   echo '</ul>';
                   }
                   else{
                        echo 'No hay ninguna restricción impuesta a las lentes, se están mostrando todas las disponibles.';     
                   }
                   ?>
            </div>
    </div>
</div>

    <!-- Diav auxiliar para detectar que estamos en un archive iol template -->
   	<div id="archiveIolTemplate"> &nbsp;</div>
<?php wp_reset_query();?>


<!-- Fin Contenido Archive Estándar por si está buscando una lente intraocular -->
<?php  } ?>


<?php 
    //////////////////////////////////////////
    //FINALIZACIÓN CPT ==> lente-intraocular 
    //////////////////////////////////////////
 ?>



<?php 
    //////////////////////////////////////////
    //CPT ==> != clinica y lente-intraocular 
    //////////////////////////////////////////
 ?>



<? if(($postTypeRequired != 'clinica') && ($postTypeRequired != 'lente-intraocular')) { ?>

<!-- Contenido estandar por si no estba buscando una clínica ni una lente intraocular -->
	<div id="primary" class="site-content">
		<div id="content" role="main">
			<article id="post-0" class="post error404 no-results not-found">
				
                <header class="entry-header">
					<h1 class="entry-title"><?php echo _x( 'Lo sentimos, no podemos ofrecerle la página que está buscando', 'not found','iol_theme' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php echo _x( 'Puede realizar una búsqueda interna en el site sobre el recurso en el que estaba interesado:', 'not found','iol_theme' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
                <br><br>
                <!--  ---- -->
                <?php /* Añadimos links para dar opciones a donde ir */ 
                            $permaBlog      =   get_permalink(  31  );
                    echo '<p>'._x('Igual quiere ir al área:','not found','iol_theme').'</p>';
                            ?>
                <br><br><br>
              <div id="qSugLinks"> 
                <ul>
                    <li><a href="<?php echo $permaBlog;?>"><?php echo _x('Ir al Blog Nuevo Cristalino','alt header single iol','iol_theme'); ?></a></li>    
                    <li><a href="<?php echo get_bloginfo('url').'/'._x('foro-de-lentes-intraoculares-presbicia-y-cataratas','foro-slug','iol_theme'); ?>"><?php echo _x('Ir al Foro de Nuevo Cristalino','alt header single iol','iol_theme');?></a></li>
                    <li><a href="<?php echo get_site_url().'/'._x('preguntas-de-lentes-intraoculares-presbicia-y-cataratas','qa-slug','iol_theme'); ?>"><?php echo _x('Ir a pregunte al Cirujano','alt header single iol','iol_theme'); ?></a></li> 
                </ul>
            </div>
                    <!-- ----- -->
            <div id="siteMapProp">
                <p><?php echo _x('En nuestro Mapa del Sitio podrá encontrar un acceso a todos los recursos que NuevoCristalino pone a su disposición:','not found','iol_theme'); ?></p>
                <?php 
                    echo '<a href="'.get_permalink(8398).'">'._x('Mapa del Site','Footer','iol_theme').'</a>';
                ?>
            </div>
                <p>
                  <?php echo _x('Como siempre puede ponerse en contacto con nosotros en:','not found','iol_theme'); ?>
                  <?php echo '<span style="color:#003B61;">'._x('info@nuevocristalino.com','not found','iol_theme').'</span>';?> 
                </p>

			</article><!-- #post-0 -->
		</div><!-- #content -->
	</div><!-- #primary -->

<!-- Fin de contenido estandar -->

<?php  } ?>  

    
<?php 
    //////////////////////////////////////////
    //FINALIZACIÓN CPT ==> != Clínica y lente-intraocular 
    //////////////////////////////////////////
 ?>

<?php get_footer(); ?>


