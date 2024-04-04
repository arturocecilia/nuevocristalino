<?php
/*
 * Template Name: Template Pre-Op Test Result
 * Description: Este es el template para la página del teste Preoperatorio para la selección de lentes
*/

get_header(); ?>

<?php 
  //get_site_url().'/como-elegir-la-lente-intraocular/' 227
?>

<div id="test-title">
    <h1><?php echo _x('VEA QUÉ LENTES INTRAOCULARES SON ADECUADAS PARA USTED','Template Pre-Op Test Result','iol_theme'); ?></h1>
    <span class="returnToTest"><a href="<?php echo get_permalink(227) ;?>"><?php echo _x('Repetir el Test','Template Pre-Op Test Result','iol_theme'); ?> >></a></span>
    <div style="clear: both;height: 0px;">&nbsp;</div>
</div>


	<div id="primary" class="site-content test">
		<div id="content" role="main">

     <?php /*Aqu’ incluiremos a nuestra funci—n para el proceso: Crearemos un nuevo objeto wp_query */
    

          //$currentPage = (get_query_var('paged'))? (get_query_var('paged')) : 1;

          //include('iolTestProcesor.php');
          include(ABSPATH . 'wp-content/plugins/lente-intraocular/iolTestProcesor.php');
  
     ?>

			<!--  Ofrecemos volver al Test: 
            <a href="<?php /*echo esc_url( get_permalink( get_page_by_title( _x('Test de lentes Intraoculares','page_name','iol_Test') ) ) );*/ ?>">Volver al Test</a>
		    -->


            <?php 



            //echo 'paged es:'.$currentPage.'y punto <br />';

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
           // echo $base;

            ?>
        <!-- Mostramos las lentes Intraoculares adecuadas para el paciente segœn el test rellenado -->
        
<?php   
        // The Loop para queryRTest
        if ( $queryRTest->have_posts() ) {

            echo '<div class="preOptestResultNumber">';
            echo '<span>';
            printf(_x('A continuación le mostramos &nbsp;<strong>%d</strong>&nbsp; lentes intraoculares recomendadas de acuerdo a sus respuestas.','Template Pre-Op Test Result','iol_theme'),$queryRTest->found_posts);
            //echo 'Exclusiones (Temporal) => '.$ExclusionMSG;
            echo '<br /></span>';
            echo '</div>';

	        while ( $queryRTest->have_posts() ) {
		            $queryRTest->the_post();
                    
                      
            echo '<div class="archive-lente-wrapper">';
	        echo '<div class="post-'.get_the_ID().' lente-intraocular type-lente-intraocular status-publish hentry" id="post-'.get_the_ID().'">';	

     		echo '<div class="entry-header iol-entry-header">';
            echo '<div class="featured-iol-archive-image">';			
            echo     get_the_post_thumbnail(get_the_ID());			
            echo '</div>';

            echo '</div>';

		    echo '<div class="entry-content iol-entry-content">';
            echo '<h1 class="archive-iol-title">';
				
            echo '<a href="'.get_permalink(get_the_ID()).'" title="'.get_the_title().'">'.get_the_title().'</a>';
			
            echo '</h1>';
			echo the_excerpt();
				
            
            echo '<div class="iol-entry-meta">';
            echo '<a href="'.get_permalink(get_the_ID()).'" title="'.get_the_title().'">'._x('Ver lente','Template Pre-Op Test Result','iol_theme').'</a>';
            echo '<br>';
            echo '<a href="'.get_permalink(get_the_ID()).'" title="'.get_the_title().'" class="newW">'._x('Abrir lente en ventana nueva', 'Content Archive Lente Intraocular Paciente','iol_theme').'</a>';
	   	    
            echo '</div>';
            
            echo '</div>';
		
            echo '
                <div style="clear: both; height: 0px;">&nbsp;</div>
	            </div><!-- #post -->
                <div style="clear: both; height: 0px;">&nbsp;</div>
            </div>';
                }
            } else {
	        // no posts found
            echo '<div class="preOptestResultNumber">';
            echo '<span>';
            printf (_x('A continuación le mostramos &nbsp;<strong> %d</strong>&nbsp; lentes intraoculares recomendadas de acuerdo a sus respuestas.<br />','Template Pre-Op Test Result','iol_theme'),$queryRTest->found_posts);
            //echo 'Exclusiones (Temporal) => '.$ExclusionMSG;
            echo '</span>';
            echo '</div>';

            
            //echo 'No se han encontrado lentes intraocularesÁÁ';
            echo'
            <div class="NoIolWrapper">
              <div class="innerNoneIolWrapper">
              <div id="NoIolImg">
              <img src="http://www.nuevocristalino.es/wp-content/uploads/2013/08/noencontrado.png">
              </div>
              <div class="NoIol">
                <p class="mensNotTitle">'._x("No hay ninguna Lente Intraocular con los criterios de filtrado actuales.","Template Pre-Op Test Result","iol_theme").'</p>
                <p class="mensNotMessage">'._x("Proceda a realizar una nueva búsqueda cambiando los criterios.","Template Pre-Op Test Result","iol_theme").'</p>
              </div>
              <div style="clear:both;height:0px;">&nbsp;</div>
              </div>
              </div>';
            
            
            }

     /*-- Prueba para ver si arreglamos el pagination */
     $currentPage = (get_query_var('paged'))? (get_query_var('paged')) : 1;

     $qString = $_SERVER['QUERY_STRING'];
     $qString = str_replace('?','',$qString);
     parse_str($qString,$aParams);//explode("&",$qString );      


      if(array_key_exists ('page',$aParams)){
         unset($aParams['page']);
        } else{
         
        }



               echo '<br><div id="PaginationWrapper"><div id="LinkPages" class="testPagination">'.paginate_links(array(
                                                          'current' => $currentPage,/*$page,*/
                                                          'base' => $base.'%_%',
                                                          'total' => $queryRTest->max_num_pages,
                                                          'format' => '/page/%#%/',//.$qString,
                                                          'prev_next' =>TRUE,
                                                          'show_all' => TRUE,
                                                          'prev_text'=>'<',
                                                          'next_text'=>'>',
                                                          'add_args' => $aParams)
                                                          ).'</div></div></br>';

        wp_reset_postdata();

?>
        </div><!-- #content -->

                <!-- Parte del lateral del contenido -->
        <div id="right" class="rightTestColumn">
            <h4 id="masNC"><?php echo _x("MÁS SOBRE NUEVO CRISTALINO:","Template Pre-Op Test Result","iol_theme"); ?></h4>
            <div id="testFollowWrapper">
            	
            <?php 
            			//links a las redes sociales
            			
            			$locale = get_locale();
            			$text = "Follow us on ";
            			$formId = 0;
            			
            			switch($locale){
            				 
            				 case 'es_ES':
            				   $twitter = 'https://twitter.com/NuevoCristalino';
            				   $facebook = 'https://www.facebook.com/nuevocristalino.es';
            				   $text = 'Síguenos en ';
            				   $formId = '11253';
            				 break;
            				 
            				 case 'es_CO':
            				   $twitter = 'https://twitter.com/NuevoCristalino';
            				   $facebook = 'https://www.facebook.com/nuevocristalino.es';
											 $text = 'Síguenos en ';
											 $formId = '11835';            				 
            				 break;
            				 
            				 case 'es_CL':
            				   $twitter = 'https://twitter.com/NuevoCristalino';
            				   $facebook = 'https://www.facebook.com/nuevocristalino.es';
            				   $text = 'Síguenos en ';
            				   $formId = '11752';
            				 break;
            				 
            				 case 'es_MX':
            				   $twitter = 'https://twitter.com/ncristalinomx';
            				   $facebook = 'https://www.facebook.com/nuevocristalino.mexico';            				 
            				   $text = 'Síguenos en ';
            				   $formId = '11452';
            				 break;
            				 
            				 case 'de_DE':
            				   $twitter = 'https://twitter.com/Neuelinsen';
            				   $facebook = 'https://www.facebook.com/neuelinsen';
            				   $formId = '11554';            				 
            				 break;
            				
            				case 'de_AT':
            				   $twitter = 'https://twitter.com/Neuelinsen';
            				   $facebook = 'https://www.facebook.com/neuelinsen';
            				   $formId = '11704';           				 
            				 break;
            				 
            				 case 'en_GB':
            				   $twitter = 'https://twitter.com/mylifestylelens';
            				   $facebook = 'https://www.facebook.com/mylifestylelens/';
            				   $formId = '11610';             				 
            				 break;            				 
            				 
            				 case 'en_US':
            				   $twitter = 'https://twitter.com/mylifestylelens';
            				   $facebook = 'https://www.facebook.com/mylifestylelens/';
            				   $formId = '11501';             				 
            				 break;
            				 
            				 case 'fr_FR':
            				   $twitter = 'https://twitter.com/NCristallin';
            				   $facebook = 'https://www.facebook.com/nouveaucristallin/';
            				   $formId = '11657';             				 
            				 break;

            				}
            
            ?>	
            	
                  <div id="follow">
                	<a href="<?php echo $twitter; ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/content/simbol-facebook.png" />
                    <?php echo $text; ?>twitter</a>
                    <div style="clear:both;">&nbsp;</div>
                    <a href="<?php echo $facebook; ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/content/simbol-twitter.png" />
                    <?php echo $text; ?>facebook</a>
                    <div style="clear:both;">&nbsp;</div>
                </div>
            </div>
            
            <?php if($rgpd = false) { ?>
            <div id="contacto-test">
             <h4><?php echo _x("CONTÁCTENOS:","Template Pre-Op Test Result","iol_theme"); ?></h4>
            <div class="formulario-test">
                
                <?php if (function_exists('serveCustomContactForm')) { serveCustomContactForm(4); } ?>
                
                
                <?php
                		
                		
                		if ( function_exists( 'ccf_output_form' ) ) {
							    				ccf_output_form( $formId );
										}
                ?>
                
                
            </div>
            </div>
            <?php  } ?>
        </div>


	</div><!-- #primary -->

<?php /*get_sidebar();*/ ?>
<?php get_footer(); ?>