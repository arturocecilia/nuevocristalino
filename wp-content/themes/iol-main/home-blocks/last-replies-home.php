<?php ?>


<!-- Ini Foro-->

  <div class="homeBloqForo">
  <div class="introForo">
    <span class="black-text bold"><?php echo _x('Última actividad en el', 'Home Page', 'iol_theme'); ?> </span>
    <span class="orange-text bold"><?php echo _x('Foro', 'Home Page', 'iol_theme'); ?></span>
  </div>
  <div class="forosBlock">

        <?php

        global $capsule;



        $relForumSite_ID = $capsule->table('nc_sites_groups')
                              ->where('group_site_key', get_locale())
                              ->first()
                              ->forum_site_id;



        switch_to_blog($relForumSite_ID);


      $argsForo = array(
                                      'post_type'=> 'reply',
                                      'posts_per_page' => 2
                                      );

      $queryForo =  new WP_Query($argsForo);


          echo '<ul class="foroHomeList">';
          while ($queryForo->have_posts()) {
              $queryForo->the_post();


              $answerTopicId = $queryForo->post->post_parent;
              $answerForumId = wp_get_post_parent_id($answerTopicId);


              echo '<li>';
              echo '<img class="imgForum" src = '.get_forumFeatImg($answerForumId).' class="qaImgCat"/>';
              echo '<div class="homeForumContentWrapper">';
              echo '<div class="qaTitle forumTitle"><a href="'.get_permalink($answerForumId).'">Foro: '.get_the_title($answerForumId).'</a></div>';
              echo '<div class="foroTitle qaTitle"><a href="'.get_permalink($answerTopicId).'">Hilo: '.get_the_title($answerTopicId).'</a></div>';
              echo '<div class="qaContent"><a href="'.get_permalink($answerTopicId).'#post-'.$queryForo->post->ID.'">'.truncateCustom(get_the_content($queryForo->post->ID), $queryForo->post->ID, 60).'</a></div>';
              echo '<div class="qaLabels question-tags"></div>'; //'.get_the_term_list($queryForo->post->ID, 'question_tag').'
              echo '</div>';

              echo '</li>';
          }
          echo '</ul>';



          // Restore original Post Data
          wp_reset_postdata();
restore_current_blog();
      ?>


  </div>

</div>


<!-- Fin Foro-->
