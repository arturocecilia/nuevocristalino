<?php
/*
 * Template Name: Template UDA IOLSelector
 * Description: Este es el template para mostrar la lista de IOLs de acuerdo al perfil pre op del paciente.
 */

get_header(); ?>


  <style>

  	.page-template-template-udm-profiles-leftMenu-php form#loginform{
  		margin-top:25px;
  		}

  </style>


    <div class="submenu-pages" style="clear:left;">



    	<h2><?php echo _x('Mi Área Personal','intranet','iol_theme'); ?></h2>
        	<?php  wp_nav_menu(array('theme_location'=>'menu-mync')); ?>
  <!--    <h2><?php echo _x('Mi perfil de usuario','intranet','iol_theme'); ?></h2>
        	<?php wp_nav_menu(array('theme_location'=>'menu-mync-myprofile')); ?>
-->
    </div>




	<div id="primary" class="site-content-page-template udm-profiles-left-menu">













		<div id="content" role="main">

   <?php /*Aqu’ incluiremos a nuestra funci—n para el proceso: Crearemos un nuevo objeto wp_query */


if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		?>

		<h1 class="entry-title"><?php the_title(); ?></h1>

	<br /><br />
		<?php
		// Post Content here
		the_content();

		echo '<br />';
		//
	} // end while
} // end if


          //$currentPage = (get_query_var('paged'))? (get_query_var('paged')) : 1;

          //include('iolTestProcesor.php');
          include(ABSPATH . 'wp-content/plugins/user-analysis/iolSelector-userMetadataProcessor.php');

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


















	</div><!-- #primary -->

    <!-- Aquí iba el left menu lo hemos subido para el responsive-->



<?php //get_sidebar(); ?>
<?php get_footer(); ?>
