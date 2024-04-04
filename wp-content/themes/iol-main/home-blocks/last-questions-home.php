<?php


?>
<!-- Blog & QA -->

<div class="homeBloqQA">
  <div class="introQA">
    <span class="black-text bold"><?php echo _x('Últimas preguntas de', 'Home Page', 'iol_theme');?> </span>
    <span class="orange-text bold"><?php echo _x('Pregunta al Cirujano', 'Home Page', 'iol_theme');?></span>
  </div>

  <div class="questionsBlock">
    <?php

global $capsule;
$relQAsite_ID = $capsule->table('nc_sites_groups')
                      ->where('group_site_key', get_locale())
                      ->first()
                      ->qa_site_id;

switch_to_blog($relQAsite_ID);

register_taxonomy('dwqa-question_category', 'dwqa-question');
register_taxonomy('dwqa-question_tag', 'dwqa-question');


add_filter('get_the_terms', 'wpse_limit_terms');
      $argsQA = array(
                      'post_type'=> 'dwqa-question',
                      'posts_per_page' => 2,
                      'post_status'    => 'publish'
                      );

      $queryQA =  new WP_Query($argsQA);

          $countQA = 0;
          echo '<ul class="qaHomeList">';
          while (($queryQA->have_posts()) && ($countQA < 2)) {
              $queryQA->the_post();
              $qaID = $queryQA->post->ID;
              $countQA = $countQA +1;

              echo '<li>';
              echo '<div class="qaImgCat '.get_idImgSingleQA($qaID).'">&nbsp;</div>';
              echo '<div class="qaTitle"><a href="'.get_permalink($qaID).'">'.get_the_title($qaID).'</a></div>';
              echo '<div class="qaContent"><a href="'.get_permalink($qaID).'">'.truncateCustom(get_the_content($qaID), $qaID, 60).'</a></div>';
              echo '<div class="qaLabels question-tags">'.get_the_term_list($qaID, 'dwqa-question_tag').'</div>';
              echo '</li>';
          }
          echo '</ul>';


remove_filter('get_the_terms', 'wpse_limit_terms');
          // Restore original Post Data
          wp_reset_postdata();
restore_current_blog();
      ?>



  </div>


</div>



<!-- Blog & QA -->
