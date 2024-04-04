<?php
/*
 * Template Name: Template myinteraction
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
         $cu_user_ID = ($cu_user->ID) ? $cu_user->ID : 0;

//2. Generación de WP_Queries específicas.


//Parte de QA
           $argsQAQuestions =  array(
                                  'post_type' => 'question',
                                  'author' => $cu_user_ID,//124,
                                  'posts_per_page' => -1
                                );
          $argsQAAnswers =  array(
                                   'post_type' => 'answer',
                                   'author' => $cu_user_ID,//149,//$cu_user_ID,//124,
                                  'posts_per_page' => -1
                                                     );
//Parte de Forums

           $argsFTopics = array(
                                  'post_type' => 'topic',
                                  'posts_per_page' => 10,
                                  'author' => $cu_user_ID//141
                                );
           $argsFResponses =  array(
                                   'post_type' => 'reply',
                                   'posts_per_page' => 10,
                                   'author' =>  $cu_user_ID//141
                                    );
//Parte de Comments
           $argsComments = array(
                                    'posts_per_page' => 10,
                                    'user_id' => $cu_user_ID//11
                                    );




function looperInteraction($wpPosts,$title){
          // The Loop

          if ( $wpPosts->have_posts() ) {
           echo '<h3 class="mycontent-section">'.$title.'</h3>';
           echo '<ul class="mycontent-dcolumn">';
           while ( $wpPosts->have_posts() ) {
             $wpPosts->the_post();
             echo '<li><a href="'.get_the_permalink().'">' . get_the_title() . '</a></li>';
           }
           echo '</ul>';
          } else {
           // no posts found

          }

}

function displayComments($comments, $title){

  if( $comments ) {
     echo '<h3 class="mycontent-section">'.$title.'</h3>';
      echo '<ul class="mycontent-dcolumn">';
  	foreach( $comments as $comment ) {
             echo '<li><a href="'.get_the_permalink($comment->comment_post_ID).'">' . get_comment_excerpt($comment->comment_ID) . '</a></li>';
  	}
     echo '</ul>';
  }



}



// The Queries
$wpQAQuestions = new WP_Query($argsQAQuestions);
$wpQAAnswers = new WP_Query($argsQAAnswers);
$wpFTopics = new WP_Query($argsFTopics);
$wpFResponses = new WP_Query($argsFResponses);
$wpCommentsClass = new WP_Comment_Query;
$wpComments = $wpCommentsClass->query($argsComments);

//vamos haciendo el display ahora.
$qaQuestionsTitle = _x('PREGUNTAS REALIZADAS','template-myinteraction',	'iol_last');
looperInteraction($wpQAQuestions, $qaQuestionsTitle);
wp_reset_postdata();
$qaAnswersTitle =  _x('RESPUESTAS REALIZADAS','template-myinteraction',	'iol_last');
looperInteraction($wpQAAnswers, $qaAnswersTitle);
wp_reset_postdata();
$fTopicsTitle =  _x('HILOS CREADOS','template-myinteraction',	'iol_last');
looperInteraction($wpFTopics, $fTopicsTitle);
wp_reset_postdata();
$responsesTitle =  _x('RESPUESTAS DADAS EN LOS FOROS','template-myinteraction',	'iol_last');
looperInteraction($wpFResponses, $responsesTitle);
wp_reset_postdata();
//Comentarios
$commentsTitle =  _x('COMENTARIOS REALIZADOS','template-myinteraction',	'iol_last');
displayComments($wpComments, $commentsTitle);
//var_dump($wpComments);


         }else{
           echo _x('Para que puedas ver tu actividad tienes que haber iniciado sesión','template-myinteraction',	'iol_last');
         }


      ?>


 		</div><!-- #content -->



 	</div><!-- #primary -->

     <!-- Aquí iba el left menu lo hemos subido para el responsive-->



 <?php //get_sidebar(); ?>
 <?php get_footer(); ?>
