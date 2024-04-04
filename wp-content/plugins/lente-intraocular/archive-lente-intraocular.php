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

<noscript>
  <style type="text/css">.startsUgly { display: block; }</style>
</noscript>


<?php  
  

    $currentPage = (get_query_var('paged'))? (get_query_var('paged')) : 1;//max(1, get_query_var('paged'));//(get_query_var('paged'))? (get_query_var('paged')) : 1;;//$_GET['page'] ? $_GET['page'] : 1;;//(get_query_var('page'))? (get_query_var('page')) : 1;//(get_query_var('page')) ? get_query_var('page') : 1; //$_GET['paged'] ? $_GET['paged'] : 1;
    
     //$currentPage = get_query_var('paged');
  
     
   //Necesitamos además restringir más la query 

   //echo  $GLOBALS['wp_query']->request;
/*if(current_user_can('manage_options')){
	echo 'por aquí';
	if(isset($_COOKIE['ncpatient'])){
		echo 'cookie detectada';
	}else{
		echo 'cookie no detectada';
	}
}*/

?>	

 
    <div id="primary" class="site-content-archive-lentes">
    
            <div class="archive-header">
				<h1 class="archive-title"><?php echo  _x('LAS LENTES INTRAOCULARES RESULTANTES DE SU BÚSQUEDA SON:','Archive Lente Intraocular','iol_cpt_display'); ?></h1>
			</div><!-- .archive-header -->
            
     <div id="preButtonSet" >
   	 <form class="startsUgly">
    		<label class="labelIolName"><?php echo _x('Búsqueda de lente por nombre:','Archive Lente Intraocular','iol_cpt_display'); ?> </label>
    		<input id="iolName" type="text">
   	 </form> 
   	 <!-- Vamos a meter un link de ayuda que nos explique como se utiliza -->
    	<div id="helpTitle">
    	
            <?php 
                //get_page_by_title( 'Ayuda para la Búsqueda de Lentes Intraoculares' )->ID; 2838
            ?>
     		<a href="<?php echo get_permalink(2838); ?>" data-idToReplace="content" data-idToGet ="content" data-selectorsNotToFade="" data-scrollTop="">
     		
     		<style>
     		#de_DE #preButtonSet #searchReset{
	margin-top: 10px;
	}
#de_DE 	#comboViewType{
	top:-165px !important;
}

    		#de_AT #preButtonSet #searchReset{
	margin-top: 10px;
	}
#de_AT 	#comboViewType{
	top:-165px !important;
}
     		</style>
     		
     		<?php if(get_locale()=='es_ES'){
     		
     		echo 'AYUDA BUSQUEDA LENTES';}else{
     		echo 'IOL SEARCH HELP';
     		}
     		
     		 ?>
     		
     		
     		</a>
    	</div>
    <!-- Vamos a meter un botón que nos permita refrescar la búsqueda -->
    	<button id="searchReset">
    		<?php echo _x('Resetear Búsqueda','Archive Lente Intraocular','iol_cpt_display'); ?>
    	</button>
    </div>
        

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

			<? 
			//echo 'Comprobación de herencia de valor de viewType';
			$Grid = False;
			if( array_key_exists('viewType',$_GET)){
				  if($_GET['viewType']== 'Grid'){
					  	$Grid= true;
					 }
			 }
			
			?>


            <?php if ( have_posts() ) : ?>

    			<?php while ( have_posts() ) : the_post();?>
                  
                 <?php    if(!isset($_GET['pt']) || $_GET['pt'] == 'yes' ){
                 			 if($Grid){                 			   
                 			   //echo 'el viewType está en grid';
                 			   get_template_part( 'content-grid-lente-intraocular', get_post_format());
                 			 }
                 			 else{
                 			   get_template_part( 'content-archive-lente-intraocular-paciente', get_post_format() );
                 			 }
                          }
                        
                    else{
                    	 if($Grid){
                 			   get_template_part( 'content-grid-lente-intraocular',get_post_format());
                 			 }
                 			 else{
                               get_template_part( 'content-archive-lente-intraocular', get_post_format() );
                        }
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
                            <p class="mensNotTitle">'._x("No hay ninguna Lente Intraocular con los criterios de filtrado actuales.","Archive Lente Intraocular","iol_cpt_display").'</p>
                            <p class="mensNotMessage">'._x("Proceda a realizar una nueva búsqueda cambiando los criterios.","Archive Lente Intraocular","iol_cpt_display").'</p>
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
     
     foreach($aParams as $key => $value){
        $aParams[$key] = urlencode($aParams[$key]);
     }

     /*
     foreach($data as $key => $value)
{
  $data[$key]['transaction_date'] = date('d/m/Y',$value['transaction_date']);
}
*/
     //print_r($aParams);
          
     if(array_key_exists ('page',$aParams)){
         unset($aParams['page']);
         
     } else{
         
     }

        //No queremos mostrar toda una ristra de páginas porque puede romper la maquetación, como máximo 5.
        if($wp_query->max_num_pages > 6){
        	$maxNumPages = 6;
        	}else{
       		 $maxNumPages =$wp_query->max_num_pages; 
        	}

        //$base= home_url($wp->request)  ;//$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
        //Añadimos la paginación al archive template.
        echo '<div style="clear:both; height:0px;">&nbsp;</div>';
     echo '<div id="PaginationWrapper" ><div id="LinkPages"  class="archiveLenteIntraocularAjaxer">'.paginate_links(array(
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

     echo '<div id="PaginationWrapperBis" ><div id="LinkPagesBis"  class="archiveLenteIntraocularAjaxer">'.paginate_links(array(
                                                         'current' => $currentPage,
                                                         'base' => $base.'%_%',
                                                         'total' => $maxNumPages,
                                                         'prev_next' =>TRUE,
                                                         'show_all' => FALSE,
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
        <div id="loadingGif"><div id="loaderDiv"><img src="<?php echo plugins_url( "images/newAjaxLoader.gif" , __FILE__ ); ?>" /></div></div> 
		
		<?php 
		  //Vamos a poner un div auxiliar que nos permita identificar que estamos en el Archive template.
		  //En la página de explicación de pacientes teníamos uno en el template: id= tipoIolTemplate.
		  //aquí será archiveIolTemplate y en el single: singleIolTemplate, en todos va ubicado dentro de content.
		  
		  echo '<div id="archiveIolTemplate" style="display:none; visibility:hidden;">&nbsp;</div>';
          echo '<div id="currentQueryString" style="display:none; visibility:hidden;">&nbsp;</div>';
		   
		?>
	</div><!-- #primary -->

<?php  

            //Vamos a Desacoplar el tema de la "Versión de NuevoCristalino" de los pos mos. Razón: Sólo hay que tocar 6 plantillas.

			//include('change-version-archive-lente-intraocular.php');

           //     if($_COOKIE['ncpatient']){
                    echo '<div id="right" class="filter-right pteDisplay">';//patient-filter single-lente
                    //Incluimos antes los botones.
					echo '<div id="changeFilter" class="startsUgly">';
						//echo '<a data-action="getAdvForm" href="#" >'.$filtAvanzado.'</a>';
						$paciente = TRUE;
					include(ABSPATH . 'wp-content/plugins/lente-intraocular/change-version-template-modelos-iol.php');
                    echo '</div>';

                    

					//Incluimos después el formulario.
                    include('archive-patient-form.php');  
                    echo  '</div>';
             //       }
         //   }
           // else{
            //include('right-single-lente-intraocular.php');
          //  if(!$_COOKIE['ncpatient']){
            echo '<div id="right" class="filter-right pteNoDisplay">';
            //Inluimos antes que el form los botones.
			echo '<div id="changeFilter"  class="startsUgly">';

               		//echo '<a data-action="getPatientForm" href="#" >'.$filtSimple.'</a>';
               		$paciente = 0;
			include(ABSPATH . 'wp-content/plugins/lente-intraocular/change-version-template-modelos-iol.php');
            echo '</div>';
				//Incluimos el form
	        	include('right-archive-lente-intraocular.php');
	        echo '</div>';              
           // }
         //  }



	
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
        <h4 id="expanderHead" style="cursor:pointer;"><span class="infoIolHeaderTitle"><?php echo _x("Información sobre la Búsqueda realizada","Archive Lente Intraocular","iol_cpt_display"); ?></span> <span id="expanderSign" class="ui-icon ui-icon-carat-1-e">&nbsp;</span>
        </h4>
        <!-- Vamos a meter aquí un botón que permita "cerrar"-> comprimir y mandar arriba a la izquierda el panel de información -->
         <div id="iolActionsContainer">
         	<button id="iolInfoPannelClose"><?php echo _x("Cerrar","Archive Lente Intraocular","iol_cpt_display"); ?></button>
         	<button id="iolInfoPannelMini"><?php echo _x("Minimizar","Archive Lente Intraocular","iol_cpt_display"); ?></button>
         	<button id="iolInfoPannelMaxi"><?php echo _x("Maximizar","Archive Lente Intraocular","iol_cpt_display"); ?></button>        
         </div>
        <!-- Fin del button -->
            <div style="height: 0px; clear: both;">&nbsp;</div>
        </div>
            <div id="expanderContent" style="display:none">
                <?php 
                 
                if(count($iolAudit)) 
                   {
                       echo '<div id="numLentes"> ';
                       printf(_x("Hay &nbsp; %d lentes encontradas","Archive Lente Intraocular","iol_cpt_display"),$wp_query->found_posts);
                       echo '</div>';

                        echo '<div id="titleExplanation">'._x("Las lentes mostradas cumplen las siguientes características:","Archive Lente Intraocular","iol_cpt_display").'</div>';
	                      
                        echo '<ul>';
                        foreach($iolAudit as $infoFilter){
                           
                            echo '<li><span class="auditVariableName">'.$infoFilter['text'].'</span> <span class="auditVariableValue">'.$infoFilter['value'].'</span></li>';

                        }
                        echo '</ul>';
                   
                   //Añadimos las variables que no se han especificado. -> El array not specified está cargado desde el rightform pero
                   //habrá que cargarlo desde el iolengine
                   echo '<br />';
                   echo '<div id="titleNotIncludedExplanation">'._x("Variables que no se han especificado:","Archive Lente Intraocular","iol_cpt_display").'</div>';
                   echo '<ul>';
                   	foreach($NotEspecified as $NS){
                   		//echo var_dump($NotEspecified);
                   		echo '<li><span class="notProvidedMens">'.$NS['mens'].'</span></li>';
                   	}
                   echo '</ul>';
                   }
                   else{
                        echo _x("No hay ninguna restricción impuesta a las lentes, se están mostrando todas las disponibles.","Archive Lente Intraocular","iol_cpt_display");     
                   }
                   ?>
            </div>
    </div>
</div>

    <!-- Diav auxiliar para detectar que estamos en un archive iol template -->
   	<div id="archiveIolTemplate"> &nbsp;</div>
<?php wp_reset_query();?>
<?php get_footer(); ?>