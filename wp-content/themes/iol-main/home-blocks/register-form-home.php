<?php ?>

<div id="preophomeblock"> <!-- INI preop block-->



  <?php

      echo '<div class="quickformwrapper">';
      echo '<h4 class="quickformtitle">'._x('¿Estás pensando en Operarte de la Vista?', 'iol_main', 'iol-main').'</h4>';
      echo '<h5 class="quickformsubtitle">'._x('Regístrate en NuevoCristalino. Es gratis', 'iol_main', 'iol-main').'.</h5>';

      echo do_shortcode('[quick_form_signup display="home"]');

      echo '</div>';
?>





      </div><!-- FIN preop block -->
