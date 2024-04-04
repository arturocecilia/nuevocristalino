<?php
  //vamos a poner el "widget customizado" de principales especialistas.

  $idRegisterSite = 66;
  $idsWhyRegisterQA =home_url( '/' ).'preguntas'; //13212
  $idResultPostOp = 13157;
  $idSugerIOL = 13152;
  $idMiNuevoCristalino = 13168;
  $idMisComunicaciones =13213;
  $idMisConocimientos = 13169;//13171;


  if(in_array(get_locale(), array('es_ES','es_MX','es_CL','es_CO','de_DE','de_AT','fr_FR','en_US','en_GB'))){//||(get_locale() == 'es_CO')||(get_locale() == 'es_CL');current_user_can('manage_options')
  ?>
  <aside id="advRegister" class="advRegister">

    <div class="leftmenutitlewrapper">
    <span class="priorleftmenutitle">&nbsp;</span>
    <a href="<?php echo get_permalink($idRegisterSite); ?>"><?php echo _x('Registrate en NuevoCristalino:','widget-advregister','iol_last'); ?></a>
    <span class="afterleftmenutitle">&nbsp;</span>
  </div>



    <div class="advRegisterWrapper">
      <ul class="whyregisterlist">
    		<li class="whyregisterlistitem"><a href="<?php echo $idsWhyRegisterQA; ?>" id="whyqa"><span class="icon">&nbsp;</span><?php echo _x('Preguntar a nuestros <span class="bold">cirujanos colaboradores</span>','widget-advregister','iol_last'); ?> </a></li>



    <li class="whyregisterlistitem"><a href="<?php echo get_permalink($idResultPostOp) ; ?>" id="whyrespostop"><span class="icon">&nbsp;</span><?php echo _x('Acceder a <span class="bold">resultados de usuarios operados</span> de tu misma cirugía','widget-advregister','iol_last'); ?></a></li>

    		<li class="whyregisterlistitem"><a href="<?php echo get_permalink($idMiNuevoCristalino); ?>" id="whyminc"><span class="icon">&nbsp;</span><?php echo _x('Verás una lista de <span class="bold">contenidos del portal filtrados de acuerdo a tu situación</span>.','widget-advregister','iol_last'); ?></a></li>
    		<li class="whyregisterlistitem"><a href="<?php echo get_permalink($idMisComunicaciones);?>" id="whymiscom"><span class="icon">&nbsp;</span><span class="bold"><?php echo _x('Hasta y mientras que lo desees recibirás comunicaciones</span> con la información de interés para tu situación.','widget-advregister','iol_last'); ?></a></li>
    <li class="whyregisterlistitem"><a href="<?php echo get_permalink($idSugerIOL) ; ?>" id="whymilio"><span class="icon">&nbsp;</span><?php echo _x('Recibirás una <span class="bold">lista de lentes intraoculares de acuerdo a tu perfil</a> preoperatorio','widget-advregister','iol_last'); ?></a></li>
    		<li class="whyregisterlistitem"><a href="<?php echo get_permalink($idMisConocimientos); ?>" id="whymiscono"><span class="icon">&nbsp;</span><?php echo _x('Podrás <span class="bold">comprobar si dispones de los conocimientos mínimos</span> para entender tus opciones de cirugía y lente.','widget-advregister','iol_last'); ?></a></li>
    	</ul>
    </div>
    <div style="clear:both;height:5px;">&nbsp;</div>
  </aside>
  <?php
    }
?>
