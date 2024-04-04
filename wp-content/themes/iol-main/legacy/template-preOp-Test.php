<?php
/*
 * Template Name: Template Pre-Op Test
 * Description: Este es el template para la página del teste Preoperatorio para la selección de lentes
*/

get_header(); ?>



<?php 
 //Cuidado con el path a la carpeta y cuidado con el 1er param de la función, no es el nombre del plugin sino el text_domain.
 $plugin_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';//basename( 
/* echo $plugin_dir;
 echo '<br />';
 echo get_locale() ;
 echo '<br />';
 echo 'Resultado de load_plugin_textdomain: '.load_plugin_textdomain('iol', false, $plugin_dir );
 */ 
   ?>



<!-- <p>Comprobación de salida de strings desde .po .mo</p> -->
<div id="test-title">
    <h1 class="testIni"><?php echo _x('VEA QUÉ LENTES INTRAOCULARES SON ADECUADAS PARA USTED','Template Pre-Op Test','iol_theme'); ?></h1>
    <!-- <span class="returnToTest"><a href="<?php /*echo  get_site_url().'/como-elegir-la-lente-intraocular/'; */ ?>">Repetir el Test >></a></span>
    <div style="clear: both;height: 0px;">&nbsp;</div>
    -->
</div>

    <!-- Parte central del contenido -->
	<div id="primary" class="site-content test">


		<div id="content" role="main">  

         <?php if (have_posts()) : while (have_posts()) : the_post();?>
         <?php    the_content(); ?>
         <!-- Link para edición -->
         <?php edit_post_link('edit', '<p>', '</p>'); ?>
 
         <?php endwhile; endif; ?>
        
			
  <script>
  jQuery(function() {

  });
  </script>

   <div id="progressBar" class="jquery-ui-like">
     <div id="actualProgressBar"></div>
     <div id="innerProgressBar">&nbsp;</div> 
   </div>

<?php 
 /*Los links a las páginas de partida irán por id */
 //Resultado Test de Pacinete  => 233

?>

<div id="testLioDiv">
   <form id="testLIO" method="GET" action="<?php echo esc_url( get_permalink( 233 ) );?>" >
 


<div id="tabs" class="startsUgly">
  <ul>
    <li><a href="#tabs-1"><span class="titTab1"><?php echo _x('PRIMER BLOQUE','Template Pre-Op Test','iol_theme'); ?></span> <br ><span class="titTab2"> <?php echo _x('de Preguntas','Template Pre-Op Test','iol_theme'); ?></span></a></li>
    <li><a href="#tabs-2"><span class="titTab1"><?php echo _x('SEGUNDO BLOQUE','Template Pre-Op Test','iol_theme'); ?></span> <br ><span class="titTab2"> <?php echo _x('de Preguntas','Template Pre-Op Test','iol_theme'); ?></span></a></li>
    <li><a href="#tabs-3"><span class="titTab1"><?php echo _x('TERCER BLOQUE','Template Pre-Op Test','iol_theme'); ?></span> <br ><span class="titTab2"> <?php echo _x('de Preguntas','Template Pre-Op Test','iol_theme'); ?></span></a></li>
  </ul>
 


<!-- Iniciamos el Formulario -->

 
  <!-- Primer Bloque de Preguntas -->
  <div id="tabs-1">
      <!-- 1a Preg -->
      <?php   
      if (get_query_var('tQ1')){
	        $Result_tQ1 = get_query_var('tQ1');
        }
         else{
             $Result_tQ1 = "S/E";
         }

         //print_r($wp_query->query_vars);
         ?>
    <div id="pb1">
        <span id="p1" class="pregunta"><?php echo _x('1.&nbsp; ¿Cómo de importante es para usted no depender de las gafas después de la cirugía?','Template Pre-Op Test','iol_theme');?></span>
        <div id="r1" class="respuesta">
             <input type="radio" name="tQ1" id="idR1Q1" value="1" /><label for="idR1Q1"><?php echo _x('Importante','Template Pre-Op Test','iol_theme'); ?></label>
             <input type="radio" name="tQ1" id="idR2Q1" value ="2" /> <label for="idR2Q1"><?php echo _x('No es Importante','Template Pre-Op Test','iol_theme'); ?> </label>
        </div>
     </div>

    <div id="pb2">
        <span id="p2" class="pregunta"><?php echo _x('2.&nbsp; ¿Cuál es la graduación de sus gafas antes de las cataratas? O la actual de no tener opacificación del cristalino?','Template Pre-Op Test','iol_theme');?></span>
        <div id="r2" class="respuesta">
             <input type="radio" name="tQ2" id="idR1Q2" value="1" /><label class="ui-corner-right" for="idR1Q2"><?php echo _x('Más de -4 dioptrías de miopía','Template Pre-Op Test','iol_theme'); ?> </label>
             <input type="radio" name="tQ2" id="idR2Q2" value ="2" /> <label for="idR2Q2"><?php echo _x('De - 0,5 a - 4 dioptrías de miopía','Template Pre-Op Test','iol_theme'); ?> </label>
             <input type="radio" name="tQ2" id="idR3Q2" value ="3" /> <label for="idR3Q2"><?php echo _x('Entre + 0,5 y + 3 dioptrías de hipermetropía','Template Pre-Op Test','iol_theme'); ?> </label>
             <input type="radio" name="tQ2" id="idR4Q2" value ="4" /> <label for="idR4Q2"><?php echo _x('Más de + 3 dioptrías de hipermetropía','Template Pre-Op Test','iol_theme'); ?> </label>
             <input type="radio" name="tQ2" id="idR5Q2" value ="5" /> <label for="idR5Q2"><?php echo _x('No lo sabe','Template Pre-Op Test','iol_theme'); ?> </label>
        </div>
     </div>
   

   </div>
  <!-- Segundo Bloque de Preguntas --> 
  <div id="tabs-2">
     <div id="pb3">
        <span id="p3" class="pregunta"><?php echo _x('3.&nbsp; ¿Tiene otras enfermedades oculares?','Template Pre-Op Test','iol_theme');?></span>
        <div id="r3" class="respuesta">
             <input type="radio" name="tQ3" id="idR1Q3" value="1" />  <label for="idR1Q3"><?php echo _x('Glaucoma','Template Pre-Op Test','iol_theme'); ?> </label>
             <input type="radio" name="tQ3" id="idR2Q3" value ="2" /> <label for="idR2Q3"><?php echo _x('DMAE','Template Pre-Op Test','iol_theme'); ?> </label>
             <input type="radio" name="tQ3" id="idR3Q3" value ="3" /> <label for="idR3Q3"><?php echo _x('Uveítis','Template Pre-Op Test','iol_theme'); ?> </label>
             <input type="radio" name="tQ3" id="idR4Q3" value ="4" /> <label for="idR4Q3"><?php echo _x('Degeneración corneal','Template Pre-Op Test','iol_theme'); ?> </label>
             <input type="radio" name="tQ3" id="idR5Q3" value ="5" /> <label for="idR5Q3"><?php echo _x('Otras','Template Pre-Op Test','iol_theme'); ?> </label>
             <input type="radio" name="tQ3" id="idR6Q3" value ="6" /> <label for="idR6Q3"><?php echo _x('Ninguna','Template Pre-Op Test','iol_theme'); ?> </label>
        </div>
     </div>

     <div id="pb4">
        <span id="p4" class="pregunta"><?php echo _x('4.&nbsp; Tras la cirugía ¿cómo de importante es para usted ver de lejos sin gafas: conduciendo, jugando al golf...?','Template Pre-Op Test','iol_theme');?></span>
        <div id="r4" class="respuesta">
             <input type="radio" name="tQ4" id="idR1Q4" value="1" /><label for="idR1Q4"><?php echo _x('Muy importante','Template Pre-Op Test','iol_theme'); ?></label>
             <input type="radio" name="tQ4" id="idR2Q4" value ="2" /> <label for="idR2Q4"><?php echo _x('No es Importante','Template Pre-Op Test','iol_theme'); ?> </label>
        </div>
     </div>


     <div id="pb5">
        <span id="p5" class="pregunta"><?php echo _x('5.&nbsp; Tras la cirugía ¿cómo de importante es para usted ver de cerca sin gafas: leyendo?','Template Pre-Op Test','iol_theme');?></span>
        <div id="r5" class="respuesta">
             <input type="radio" name="tQ5" id="idR1Q5" value="1" /><label for="idR1Q5"><?php echo _x('Importante','Template Pre-Op Test','iol_theme'); ?></label>
             <input type="radio" name="tQ5" id="idR2Q5" value ="2" /> <label for="idR2Q5"><?php echo _x('No es Importante','Template Pre-Op Test','iol_theme'); ?> </label>
        </div>
     </div>


  </div>

  <!-- Tercer Bloque de Preguntas --> 
  <div id="tabs-3">
      <!-- PREGUNTAR LUDGER ¡¡¡¡-->

       <div id="pb6">
        <span id="p6" class="pregunta"><?php echo _x('6.&nbsp; Si necesitase gafas tras la cirugía, ¿en cuál de las siguientes actividades podrías aceptar gafas?','Template Pre-Op Test','iol_theme');?></span>
        <div id="r6" class="respuesta">
             <input type="radio" name="tQ6" id="idR1Q6" value="1" /><label for="idR1Q6"><?php echo _x('Leyendo letra pequeña','Template Pre-Op Test','iol_theme'); ?></label>
             <input type="radio" name="tQ6" id="idR2Q6" value ="2" /> <label for="idR2Q6"><?php echo _x('Trabando con el ordenador o cocinando','Template Pre-Op Test','iol_theme'); ?> </label>
             <input type="radio" name="tQ6" id="idR3Q6" value ="3" /> <label for="idR3Q6"><?php echo _x('Conduciendo','Template Pre-Op Test','iol_theme'); ?> </label>
        </div>
     </div>

     <div id="pb7">
        <span id="p7" class="pregunta"><?php echo _x('7.&nbsp; Si vieses bien tanto de lejos como de cerca durante el día, ¿podrías aceptar efectos como halos y destellos durante la noche?','Template Pre-Op Test','iol_theme');?></span>
        <div id="r7" class="respuesta">
             <input type="radio" name="tQ7" id="idR1Q7" value="1" /><label for="idR1Q7"><?php echo _x('Si','Template Pre-Op Test','iol_theme'); ?></label>
             <input type="radio" name="tQ7" id="idR2Q7" value ="2" /> <label for="idR2Q7"><?php echo _x('No','Template Pre-Op Test','iol_theme'); ?> </label>
        </div>
     </div>

     <div id="pb8">
        <span id="p8" class="pregunta"><?php echo _x('8.&nbsp; Si viese bien durante el día sin necesidad de gafas, tanto de lejos como de cerca, incluso trabajando con el ordendor, ¿podría aceptar las gafas para leer letra muy pequeña?','Template Pre-Op Test','iol_theme');?></span>
        <div id="r8" class="respuesta">
             <input type="radio" name="tQ8" id="idR1Q8" value="1" /><label for="idR1Q8"><?php echo _x('Si','Template Pre-Op Test','iol_theme'); ?></label>
             <input type="radio" name="tQ8" id="idR2Q8" value ="2" /> <label for="idR2Q8"><?php echo _x('No','Template Pre-Op Test','iol_theme'); ?> </label>
        </div>
     </div>

     <div id="pb9">
        <span id="p9" class="pregunta"><?php echo _x('9.&nbsp; Hay muchas situaciones en las que es necesario ver bien a diferentes distancias. En el caso de que decidiese eliminar la dependencia de las gafas, ¿en qué tipo de escenario consideraría más importante lograr una independendencia total?','Template Pre-Op Test','iol_theme');?></span>
        <div id="r9" class="respuesta">
            <input type="radio" name="tQ9" id="idR1Q9" value="1" /><label for="idR1Q9"><?php echo _x('Leer, ver un mapa, coser...','Template Pre-Op Test','iol_theme'); ?></label>
            <input type="radio" name="tQ9" id="idR2Q9" value="2" /><label for="idR2Q9"><?php echo _x('Estar con el ordenador, leer un menú, ver precios de productos, leer letra de tamaño grande','Template Pre-Op Test','iol_theme'); ?></label>
            <input type="radio" name="tQ9" id="idR3Q9" value="3" /><label for="idR3Q9"><?php echo _x('Ver la televisión, limpiar, realizar actividades dentro y fuera de la casa ¿?','Template Pre-Op Test','iol_theme'); ?></label>
            <input type="radio" name="tQ9" id="idR4Q9" value="4" /><label for="idR4Q9"><?php echo _x('Conducir, jugar al golf, ver carteles ¿?','Template Pre-Op Test','iol_theme'); ?></label>
            <input type="radio" name="tQ9" id="idR5Q9" value="5" /><label for="idR5Q9"><?php echo _x('Conducir por la noche, ver una película en el cine','Template Pre-Op Test','iol_theme'); ?></label>
        </div>
     </div>

     <div id="pb10">
        <span id="p10" class="pregunta"><?php echo _x('En cuanto a su personalidad... ¿Cómo se considera usted?','Template Pre-Op Test','iol_theme');?></span>
        <div id="r10" class="respuesta">
 <!-- Pregunta--><input type="radio" name="tQ10" id="idR1Q10" value="1" /><label for="idR1Q10"><?php echo _x('Abierto, sencillo...','Template Pre-Op Test','iol_theme'); ?></label>
                 <input type="radio" name="tQ10" id="idR2Q10" value ="2" /> <label for="idR2Q10"><?php echo _x('Perfeccionista, doy y espero siempre lo mejor','Template Pre-Op Test','iol_theme'); ?> </label>
        </div>
     </div>
      
        </div>
</div>

       <div id="submitTest"><input type="button" class="submitTest" onClick="submit_Test()" value="<?php echo _x('Enviar Test','Template Pre-Op Test','iol_theme'); ?>" /></div>

</form>
</div>           

		</div><!-- #content -->

        <!-- Vamos a meter el right content dentro de Primary -->

        <!-- Parte del lateral del contenido -->
        <div id="right" class="rightTestColumn">
            <h4 id="masNC"><?php echo _x('MÁS SOBRE NUEVO CRISTALINO:','Template Pre-Op Test','iol_theme'); ?></h4>
            <div id="testFollowWrapper">
                  <div id="follow">
                	<a href=""><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/content/simbol-facebook.png" alt="facebook" />
                    Follow us on twitter</a>
                    <div style="clear:both;">&nbsp;</div>
                    <a href=""><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/content/simbol-twitter.png" alt="twitter" />
                    Follow us on facebook</a>
                    <div style="clear:both;">&nbsp;</div>
                </div>
            </div>
            
            
            <?php if($rgdp = false){ ?> 
            
            <div id="contacto-test">
             <h4><?php echo _x('CONTÁCTENOS:','Template Pre-Op Test','iol_theme'); ?></h4>
            <div class="formulario-test">
	            
            <?php    
            switch (get_locale()) {
					case 'es_ES':
							$idFormTest = 11253;
						break;
					case 'es_CL':
							$idFormTest = 11752;
						break;		
					case 'es_MX':
							$idFormTest = 11452;
				    break;
					case 'es_CO':
							$idFormTest = 11835;
				    break;

					case 'en_GB':
							$idFormTest = 11610;
				    break;
					case 'en_US':
							$idFormTest = 11501;
				    break;				    
					case 'de_DE':
							$idFormTest = 11554;
				    break;
					case 'de_AT':
							$idFormTest = 11704;
				    break;
					case 'fr_FR':
							$idFormTest = 11657;
				    break;
	    
					default:
							$idFormTest = 11253;					
				} 
			
			
			 if ( function_exists( 'ccf_output_form' ) ) {
	        	
						ccf_output_form( $idFormTest );
					
						}
			?>
            
            
            
            </div>
            </div>
            <?php } ?>
        </div>


        <!-- -->
	</div><!-- #primary -->

   

<?php /*get_sidebar();*/ ?>
<?php get_footer(); ?>