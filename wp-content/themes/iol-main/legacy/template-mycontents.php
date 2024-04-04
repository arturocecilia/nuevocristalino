<?php
/*
 * Template Name: Template mycontents
 * Description: Este es el template para la plantilla de mis contenidos
 */



 get_header(); ?>


   <style>

   	.page-template-template-udm-profiles-leftMenu-php form#loginform{
   		margin-top:25px;
   		}

   	div.linkToIolProSelector a{
     background: #ffa82d;
     color: #fff;
     width: 320px;
     font-weight: bold;
     font-size: 14px;
     padding-top: 5px;
     padding-bottom: 5px;
     display: block;
     text-align: center;
     text-decoration: none;
     margin-left: auto;
     margin-right: auto;
     padding-left: 20px;
     padding-right: 20px;
     border-radius: 3px;
     border: 1px solid #d2d2d2;
 }

h3.mycontent-section{
  display:block;
  padding-bottom: 10px;
  padding-top: 15px;
}

   </style>

   <?php
   if(is_user_logged_in() ){
           //Classes en función de las características del usuario.
     $userSpecificClasses = '';
     $userSpecificClasses .= profileShowInfo(array('infotype'=>'usertype','outputtype'=>'literal')).' ';
     $userSpecificClasses .= profileShowInfo(array('infotype'=>'preorpost','outputtype'=>'literal')).' ';
     //Classes en función de si el usuario ha rellenado o no los forms.
     $userFormCompletion = '';
     $userFormCompletion .= checkIfUserHasSavedForm(array('keyform'=>'qpls','outputtype'=>'class')).' ';
     $userFormCompletion .= checkIfUserHasSavedForm(array('keyform'=>'prols','outputtype'=>'class')).' ';
     }else{
     $userSpecificClasses = '';
     $userFormCompletion = '';
     }

     $userLoggedClass = returnClassLogged();
   ?>








     <div class="submenu-pages <?php echo $userSpecificClasses.' '.$userFormCompletion.' '.$userLoggedClass; ?>" style="clear:left;">



     	<h2><?php echo _x('Mi Área Personal','intranet','iol_theme'); ?></h2>
         	<?php  wp_nav_menu(array('theme_location'=>'menu-mync')); ?>

 <!--  De momento lo quito porque confunde más que aporta
       <h2><?php echo _x('Mi perfil de usuario','intranet','iol_theme'); ?></h2>
         	<?php wp_nav_menu(array('theme_location'=>'menu-mync-myprofile')); ?>
 -->
     </div>




 	<div id="primary" class="site-content-page-template udm-profiles-left-menu mync">


 		<div id="content" role="main">

<style>

ul.mycontent-dcolumn{
  list-style-type: none;
}

ul.mycontent-dcolumn li{
                        line-height:1.5em;
                        float:left;
                        display:inline;
                        width:48%;
                        padding-right: 1%;
                         text-indent: -5px;
}

ul.mycontent-dcolumn li:before {
  content: "- ";
  text-indent: -5px;
}
ul.mycontent-dcolumn li a{
  color:#505050;
  text-decoration: none;
}



div.info-mycontents h2{
  color:#003b61;
  font-size:17px;
  margin-bottom: 15px;
}

div.info-mycontents ul li{
  margin-left: 20px;
height: 20px;
font-size: 14px;
}


</style>





      <?php while ( have_posts() ) : the_post(); ?>
 				<?php get_template_part( 'content', 'page' ); ?>

        <!-- Link para edición -->
    <?php edit_post_link('edit', '<p>', '</p>'); ?>
<?php endwhile; // end of the loop. ?>


        <?php
  //en el filtrado vamos a hacer lo siguiente:
  //1º Obtener las variables filtros y generar defaults y generar warnings.
  //Crear los WP_Query para cada tipo de contenido : Páginas, Artículos, Preguntas y Hilos.
  //Si no hay datos del usuario se le dan defaults y punto. De esta manera se puede mejorar poco a poco.

        if(is_user_logged_in ()){
         $cu_user = wp_get_current_user();
         if($cu_user->ID){

           //1. Recopilación de datos del Usuario
           $sxInt     = ($cu_user->p_sxInteres) ?   $cu_user->p_sxInteres : '';
           $uType     = ($cu_user->ncusertype)  ?   $cu_user->ncusertype : '';
           $preOrPost = ($cu_user->p_preOrPost)  ?   $cu_user->p_preOrPost : '';

           echo '<div class="info-mycontents">';
           echo '<h2>'._x('La información de su perfil básico:','template-mycontents','iol_last').'</h2>';
           echo do_shortcode('[profileshowinfo infotype="generaluserinfo" outputtype="generaldescription" ]');
           echo '</div>';
           //2. Generación de WP_Queries específicas.



           $argsPages =  array(
                                  'post_type' => 'page',
                                  'posts_per_page' => 10
                                );
           $argsPosts = array(
                                  'post_type' => 'post',
                                  'posts_per_page' => 10
                                );
           $argsQuestions =  array(
                                   'post_type' => 'question',
                                   'posts_per_page' => 10
                                    );
           $argsTopics = array(
                                    'post_type'=>'topic',
                                    'posts_per_page' => 10
                                    );

        //Adaptación del parámetro prePost para la query.
        //Queremos el valor opuesto, si es pre queremos el valor postoperatorio porque irá en un NOT IN.
        if($preOrPost != ''){
          $preOrPostNotIn = 'p_preOrPost_Pre' ? 'postoperatorio' : 'preoperatorio';

        }

          switch ($sxInt){
            //
              case 'p_sxInteres_Cat':
                   $tax_query_pages = array(
                                            array(
                                                  'taxonomy' => 'post_tag',
                                                  'field'    => 'slug',
                                                  'terms'    => array( 'lentes-intraoculares','cataratas' )
                                                ),
                                                array(
                                                      'taxonomy' => 'post_tag',
                                                      'field'    => 'slug',
                                                      'terms'    => array( $preOrPostNotIn ), //postoperatorio
                                                      'operator' => 'NOT IN'
                                                    )
                                            );

                   $tax_query_posts = array(
                                            array(
                                                    'taxonomy' => 'category',
                                                    'field'    => 'slug',
                                                    'terms'    => array( 'cataratas' ),
                                                  ),
                                             array(
                                                    'taxonomy' => 'post_tag',
                                                    'field'    => 'slug',
                                                    'terms'    => array($preOrPostNotIn),
                                                    'operator' => 'NOT IN'
                                                  )
                                            );
                    $tax_query_questions = array(
                                                array(
                                                    'taxonomy' => 'question_category',
                                                    'field'    => 'slug',
                                                    'terms'    => array( 'preguntas-cataratas')
                                                  ),
                                                  array(
                                                         'taxonomy' => 'post_tag',
                                                         'field'    => 'slug',
                                                         'terms'    => array($preOrPostNotIn),
                                                         'operator' => 'NOT IN'
                                                       )

                                                  );
                    $post_parent_topics = 2939;
                    $tax_query_topics = false;


              break;
            //
            case 'p_sxInteres_Cle':
                 $tax_query_pages = array(
                                          array(
                                                'taxonomy' => 'post_tag',
                                                'field'    => 'slug',
                                                'terms'    => array( 'lentes-intraoculares-multifocales','presbicia','cristalino-disfuncional' ),
                                                'operator' => 'IN'
                                              ),
                                          array(
                                                     'taxonomy' => 'post_tag',
                                                     'field'    => 'slug',
                                                     'terms'    => array($preOrPostNotIn),
                                                     'operator' => 'NOT IN'
                                                   )
                                        );

                 $tax_query_posts = array(
                                           'relation' => 'OR',
                                             array(
                                                   'taxonomy' => 'category',
                                                   'field'    => 'slug',
                                                   'terms'    => array( 'lentes-intraoculares','presbicia' ),
                                                     ),
                                             array(
                                                   'taxonomy' => 'post_tag',
                                                   'field'    => 'slug',
                                                   'terms'    => array( 'lentes-intraoculares-multifocales','cristalino-disfuncional' )
                                                       )
                                           );
                 $tax_query_questions = array(
                                             array(
                                                   'taxonomy' => 'question_category',
                                                   'field'    => 'slug',
                                                   'terms'    => array( 'preguntas-presbicia')
                                                 ),
                                               array(
                                                        'taxonomy' => 'post_tag',
                                                        'field'    => 'slug',
                                                        'terms'    => array($preOrPostNotIn),
                                                        'operator' => 'NOT IN'
                                                      )

                                             );
                $post_parent_topics = 2335;
                $tax_query_topics = false;

            break;
            //
            case 'p_sxInteres_Icl':
                 $tax_query_pages = array(
                                          array(
                                            'taxonomy' => 'post_tag',
                                            'field'    => 'slug',
                                            'terms'    => array( 'lentes-faquicas','lentes-icl' ),
                                          ),
                                          array(
                                                 'taxonomy' => 'post_tag',
                                                 'field'    => 'slug',
                                                 'terms'    => array($preOrPostNotIn),
                                                 'operator' => 'NOT IN'
                                               )

                                        );

                  $tax_query_posts = array(
                                              array(
                                              'taxonomy' => 'post_tag',
                                              'field'    => 'slug',
                                              'terms'    => array( 'lentes-icl')
                                            ),
                                            array(
                                                   'taxonomy' => 'post_tag',
                                                   'field'    => 'slug',
                                                   'terms'    => array($preOrPostNotIn),
                                                   'operator' => 'NOT IN'
                                                 )
                                            );

                  $tax_query_questions = array(
                                              array(
                                              'taxonomy' => 'question_tag',
                                              'field'    => 'slug',
                                              'terms'    => array( 'icl','lente-icl')
                                            ),
                                            array(
                                                   'taxonomy' => 'post_tag',
                                                   'field'    => 'slug',
                                                   'terms'    => array($preOrPostNotIn),
                                                   'operator' => 'NOT IN'
                                                 )
                                            );

                  $post_parent_topics = false;
                  $tax_query_topics = array(
                                              array(
                                              'taxonomy' => 'post_tag',
                                              'field'    => 'slug',
                                              'terms'    => array( 'lentes-icl')
                                                    )
                                            );

            break;
            default:
                $tax_query_pages     = FALSE;
                $tax_query_posts     = FALSE;
                $tax_query_questions = FALSE;
                $tax_query_topics    = FALSE;
                $post_parent_topics = false;

            break;
          }
          //Añadimos la restricción basada en el dato o datos correspondientes del perfil de usuario.
          //PAGES
          if($tax_query_pages){
            $argsPages['tax_query'] = $tax_query_pages;

            //var_dump($argsPages['tax_query']);
          }
          //POSTS
          if($tax_query_posts){
            $argsPosts['tax_query'] = $tax_query_posts;
          }
          //QUESTIONS
          if($tax_query_questions){
            $argsQuestions['tax_query'] = $tax_query_questions;
          }
          //TOPICS
          if($tax_query_topics){
            $argsTopics['tax_query'] = $tax_query_topics;
          }
          if($post_parent_topics){
            $argsTopics['post_parent'] = $post_parent_topics;
          }



function looper($wpPages,$title){
          // The Loop
          if ( $wpPages->have_posts() ) {
           echo '<h3 class="mycontent-section">'.$title.'</h3>';
           echo '<ul class="mycontent-dcolumn">';
           while ( $wpPages->have_posts() ) {
             $wpPages->the_post();
             echo '<li><a href="'.get_the_permalink().'">' . get_the_title() . '</a></li>';
           }
           echo '</ul>';
          } else {
           // no posts found
          }

}



// The Queries
$wpPages = new WP_Query($argsPages);
$wpPosts = new WP_Query($argsPosts);
$wpQuestions = new WP_Query($argsQuestions);
$wpTopics = new WP_Query($argsTopics);

//vamos haciendo el display ahora.
$pagesTitle = _x('PÁGINAS','template-mycontents','iol_last');
looper($wpPages, $pagesTitle);
wp_reset_postdata();
$postsTitle = _x('ARTÍCULOS','template-mycontents','iol_last');
looper($wpPosts, $postsTitle);
wp_reset_postdata();
$questionsTitle = _x('PREGUNTAS','template-mycontents','iol_last');
looper($wpQuestions, $questionsTitle);
wp_reset_postdata();
$topicsTitle = _x('HILOS DE FOROS','template-mycontents','iol_last');
looper($wpTopics, $topicsTitle);
wp_reset_postdata();





         }else{
           echo _x('Para poder disfrutar de unos datos filtrados de acuerdo a su perfil ha de haberse registrado e iniciado sesión','template-mycontents','iol_last');
         }

          //$sxInteres = get_user_meta();
        }

      ?>


 		</div><!-- #content -->



 	</div><!-- #primary -->

     <!-- Aquí iba el left menu lo hemos subido para el responsive-->



 <?php //get_sidebar(); ?>
 <?php get_footer(); ?>
