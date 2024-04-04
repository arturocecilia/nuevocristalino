





 <div style="clear:both; height:0px;">&nbsp;</div>
	<div id="primary" class="site-content-home">
		<div id="content" role="main">

  <?php
    if(in_array(get_locale(), array('es_ES','es_MX','es_CL','es_CO'))){
      echo '<div class="quickformwrapper">';
      echo '<h4 class="quickformtitle">Encuentra la lente intraocular idónea para tí.</h4>';
          echo do_shortcode( '[quick_form_signup forms_sections=\'({\"form\":\"ncquicksignup_general\",\"section\":\"general\"})\'] ');//({\"form\":\"ncquicksignup_general\",\"section\":\"general\"});
      echo '<span class="qa-explic">Con cualquier duda recuerda que puedes escribirnos también a info@nuevocristalino.es </span>';
      echo '</div>';
      }
     ?>


        	<div id="sliderMBloqsWrapper" class ="sliderMBlWrapp">

           <!-- INICIO DE LA GUIA -->



            <div id="slider">

				<div id="mainBar">
            	<a href="#">
                	<span class="mainPhotoLink">
                		<?php
                		$arrayLang = array('es_ES','es_CL','es_MX','es_CO');

                		if(in_array(get_locale(),$arrayLang)){

                		 echo '<strong>Lentes Intraoculares:</strong> La solución definitiva a las cataratas y la presbicia';

                		}else{
                			echo _x('LENTES INTRAOCULARES: La solución definitiva a las cataratas y la presbicia','Home Page','iol_theme');
                			}?>

                		</span>
                </a>
                </div>
                <div id="guiaContainer">
                	<a id="buscador" href="<?php echo $permaMod; ?>" >
                		<div id="buscadorBloqC">
	                		<span class="roscoNumber">
	                			<span class="innerNumber">4</span>
	                		</span>
    	                    <span class="roscoTitle">
    	                    	<span class="innerTitle"><?php echo _x('Buscador de Lentes','Home Page','iol_theme');?></span>
    	                    </span>
    	                    <span class="spanClearer">&nbsp;</span>
    	                    <span class="roscoExplicacion">
    	                    	<span class="innerExplicacion"><?php echo _x('Vea todas las Lentes Intraoculares Disponibles','Home Page','iol_theme');?></span>
    	                    </span>
                		</div>
                	</a>
                	<a id="informacion" href="<?php echo $permalink;?>">
                		<div id="informacionBloqC">
                			<span class="roscoNumber">
                				<span class="innerNumber">1</span>
                			</span>
                			<span class="roscoTitle">
                				<span class="innerTitle"><?php echo _x('Explicación Básica','Home Page','iol_theme');?></span>
                			</span>
    	                    <span class="spanClearer">&nbsp;</span>
    	                    <span class="roscoExplicacion">
    	                    	<span class="innerExplicacion"><?php echo _x('Comprenda qué son las Lentes Intraoculares y qué tipos hay','Home Page','iol_theme');?></span>
    	                    </span>
                		</div>

                	</a>
                	<div id="roscoClearer"></div>
                	<a id="test" href="<?php echo get_page_link(227); ?>">
                		<div id="testBloqC">
                  			<span class="roscoExplicacion">
                			  <span class="innerExplicacion"><?php echo _x('Complete el test y vea que lentes se le sugieren','Home Page','iol_theme');?></span>
                			 </span>
                			<span class="roscoNumber">
                				<span class="innerNumber">2</span>
                			</span>
                			<span class="roscoTitle">
                				<span class="innerTitle"><?php echo _x('Test para el Paciente','Home Page','iol_theme');?></span>
                			</span>
                			<span class="spanClearer">&nbsp;</span>
                		</div>
                	</a>
                	<a id="simulador" href="<?php echo $permalinkSim;?>">
                		<div id="simuladorBloqC">
                			<span class="roscoExplicacion">
                				<span class="innerExplicacion"><?php echo _x('Vea una simulación de su resultado visual con varios tipos de lentes','Home Page','iol_theme');?></span>
                			</span>
                			<span class="roscoNumber">
                				<span class="innerNumber">3</span>
                			</span>
                			<span class="roscoTitle">
                				<span class="innerTitle"><?php echo _x('Simulador','Home Page','iol_theme');?></span>
                			</span>
                			<span class="spanClearer">&nbsp;</span>
						</div>
                	</a>

                </div>



            </div>





            <!-- FIN DE LA GUÍA -->

            </div>

            <div style="clear: both; height: 0px;">&nbsp;</div>

         <div id="block-grey">
         	<div id="grey-in">
            	<div class="grey">
                	<div id="grey1" class="grey-first">
                    	<h2><a href="<?php echo $permaOpPresbi; ?>"><?php echo _x('Soluciones para la Vista Cansada','Home Page','iol_theme'); ?></a></h2>
                    </div>
                    <div class="grey-second">
                    	<p><?php echo  _x('Conozca que opciones hay hoy en día para no necesitar gafas de cerca.','Home Page','iol_theme'); ?></p>
                    </div>
                </div>
                <div class="grey">
                	<div id="grey2" class="grey-first">
                    	<h2><a href="<?php echo get_page_link(109); ?>"><?php echo _x('Nueva cirugía de cataratas con LÁSER','Home Page','iol_theme');?></a></h2>
                    </div>
                    <div class="grey-second">
                    	<p><?php echo  _x('Conozca la útima técnica disponible para quitar las cataratas con Láser.','Home Page','iol_theme'); ?></p>
                    </div>
                </div>
                <div class="grey">
                	<div id="grey3" class="grey-first">
                    	<h2><a href="<?php echo get_page_link(404); ?>"><?php echo _x('Clínicas especializadas en mi cirugía','Home Page','iol_theme');?></a></h2> <!-- Dónde me puedo operar-->
                    </div>
                    <div class="grey-second">
                    	<p><?php echo  _x('Vea una lista de clínicas especializadas en lentes intraoculares.','Home Page','iol_theme'); ?></p>
                    </div>
                </div>
                <div class="grey-last">
                	<div id="grey4" class="grey-first">
                    	<h2><a href="<?php echo $permalinkTest; ?>"><?php echo _x('Vea las lentes adecuadas para su caso.','Home Page','iol_theme');?></a></h2>
                    </div>
                    <div class="grey-second">
                    	<p><?php echo  _x('Realice el test para saber qué tipo de lente es la más adecuada para usted.','Home Page','iol_theme'); ?></p>
                    </div>
                </div>
                <div style="clear:both; height:0px;">&nbsp;</div>
            </div>
         </div>


<?php

//Vamos con los call to action para que los usuarios se registren.

if( in_array(get_locale(),array('es_ES','es_MX','es_CL','es_CO')) ){//current_user_can('manage_options')

include('calltoaction-home.php');

	}
?>






<!-- Empezamos con lo nuevo -->

<div id="interaction-bloq">

			<div id="forum-bloq-home">
				<div id="forum-bloq-home-intro">
				<span class="black-text bold">
					<?php echo _x('Aclara tus dudas o comparte tu experiencia','Home Page','iol_theme'); ?> </span>
					<span class="orange-text bold">
					<?php echo _x('con otros usuarios','Home Page','iol_theme'); ?>
					</span>
				</div>

					<?php echo do_shortcode('[bbp-topic-form]'); ?>
			</div>

			<div id="qa-bloq-home">
				<div id="forum-bloq-home-intro">
				<span class="black-text bold"><?php echo _x('Regístrate y pregúntale','Home Page','iol_theme'); ?> </span> <span class="orange-text bold"><?php echo _x('a un cirujano','Home Page','iol_theme'); ?></span>
				</div>

					<?php echo do_shortcode( '[qa_ask_question]');?>

				<div id="qa-exp"><?php echo _x('Al realizar la pregunta se te va a solicitará registrarte. Para que te sea contestada por un cirujano, tendrás que rellenar un rápido cuestionario pre o postperatorio con el fin de recibir una respuesta más específica para tu caso.','Home Page','iol_theme'); ?></div>

				<div id="social-login-wrapper">

					<?php echo do_shortcode("[TheChamp-Login]");?>

				</div>


			</div>
			<div style="clear:both; height:0px;">&nbsp;</div>
</div>
<!--  Empezamos con lo nuevo -->


<!-- Seguimos ahora con el bloque del cirujano -->
<div id="bloque-cirujano">

	&nbsp;<a href="<?php echo get_permalink(12697); ?>">
		<div id="cirujano-text-bloq">
	<span class="black-text bold size-1"><?php echo _x('Tu asesor personal para la','Home Page','iol_theme'); ?> </span><br />
	<span class="orange-text bold size-2 orange-2"><?php echo _x('Cirugía de Cataratas','Home Page','iol_theme'); ?></span>
	<span class="text-explicacion">
		<?php echo _x('En NuevoCristalino estamos para ayudarte. Si estás pensando en operarte de cataratas, presbicia u otro defecto refractivo con lente intraocular, te ponemos en contacto con los cirujanos especialistas en esta cirugía.','Home Page','iol_theme'); ?>
	</span>
	<span class="black-text bold size-0 precontact"><?php echo _x('Contacta por diferentes canales:','Home Page','iol_theme'); ?></span>
	<span class="cirujano-asesor-canales">
		&nbsp;
	</span>
<?php
      if(get_locale() == 'es_MX'){

          echo '<span id="canales-detalles">
                    <ul class="contactChanels">
                      <li>nuevocristalinomx@gmail.com</li>
                      <li>|</li>
                      <li>+52 1 5539846753</li>
                      <li>|</li>
                      <li>nuevocristalinomx</li>
                      </ul>
          </span>';

          }
  ?>


	</div>
	</a>


</div>


<!-- Fin del bloque del cirujano -->


<!-- Ahora el bloque de  patologías asociadas -->
<div id="patologias">

	<div class="patologias-text-bloq">
		<span class="black-text bold size-1"><?php echo _x('Patologías asociadas a la','Home Page','iol_theme'); ?> </span>
		<span class="orange-text bold size-2 orange-2"><?php echo _x('Cirugía de Cataratas','Home Page','iol_theme'); ?></span>
		<span class="text-explicacion"><?php echo _x('La cirugía intraocular con implante de lente intraocular es la cirugía que más se realiza en el mundo (sin contar la asociada al parto). Para un cirujano experto es algo rutinario. Conviene, eso sí, estar al tanto de algunas condiciones que pueden darse en su postoperatorio.','Home Page','iol_theme');?></span>
		<div class="patologia-buttons">
			<a href="<?php echo get_permalink(10346); ?>"><?php echo _x('Moscas volantes/Miodesopsias','Home Page','iol_theme'); ?></a>
			<a href="<?php echo get_permalink(9419); ?>"><?php echo _x('Ojo seco','Home Page','iol_theme'); ?></a>
		</div>
		<div style="clear:both;height:0px;">&nbsp;</div>
	</div>


</div>


<!-- Fin del bloque de patologías asociadas-->




<!-- Inicio de rehacemos los bloques-->

                <div id="block1" class="redesign">
                	<div class="block1" id="block1right">
                    	<div id="blockpic1" class="multifocales">
                        	<a href="<?php echo get_permalink(12849);?>"></a>
                        </div>
                        <div class="blocktext">
                        	<a href="<?php echo get_permalink(12849);?>" title="">
                            <span class="bloqs-titles"><?php echo _x('¿Cuándo no son aconsejables las lentes multifocales?','Home Page','iol_theme'); ?></span>
                            <span class="bloqs-subtitles"><?php echo _x('Conozca más sobre las lentes de tipo multifocal para ver si son una solución adecuada para usted.','Home Page','iol_theme'); ?></span>
                            </a>
                        </div>
                    </div>
                    <div class="block1" id="block1left">
                    	<div id="blockpic2"  class="icl">
                        	<a href="<?php echo get_permalink(12845);?>">

                            </a>
                        </div>
                        <div class="blocktext">
                        	<a href="<?php echo get_permalink(12845);?>">
                            <span class="bloqs-titles"><?php echo _x('¿Cuándo no me convienen las lentes icl?','Home Page','iol_theme');?></span>
                            <span class="bloqs-subtitles"><?php echo _x('Las lentes ICL corrigen la miopía,hipermetropia y/o astigmatismo. Vea si son recomendables para usted.','Home Page','iol_theme'); ?></span>
                            </a>
                        </div>
                    </div>

                    <div style="clear:both;height:0px;">&nbsp;</div>
                </div>


  <!-- Fin de rehacemos los bloques -->

  <!-- Bloque de doctores en particular-->

  <?php
  	if(0){//get_locale()=='es_ES'
   ?>

  <div id="doctores-particular">

  	<div id="doctores-intro">
		<span class="black-text bold size-1">¿Necesitas ayuda para la elección de la </span>
		<span class="orange-text bold size-2 orange-2">Lente Intraocular?</span>
  	</div>
  	<div id="doctoresLeft">

  	<a href="<?php echo get_permalink(4029); ?>">

  		<div id="doctoresLeftText">
  			<span class="drTitle">Dr.Ludger Hanneken</span>
  			<span class="drDirector">Director Médico de VallmedicVision</span>
  		</div>

  	</a>

  	</div>

		<div id="doctoresRight">
			<a href="<?php echo get_site_url().'/'._x('opiniones-oftalmologos','slug','opinion-doctor'); ?>">
				<span id="opinionesIcon">&nbsp;</span>
				<span id="opinionesText">Conozca la opinión de los cirujanos sobre modelos de lentes</span>
			</a>
		</div>

      <div style="clear:both;height:0px;">&nbsp;</div>

  </div>

  <?php
  		}
  ?>
  <!-- Fin de bloques en particular-->

  <!-- Blog & QA -->

  <div class="homeBloqQA">
  	<div class="introQA">
  		<span class="black-text bold"><?php echo _x('Últimas preguntas de','Home Page','iol_theme');?> </span>
  		<span class="orange-text bold"><?php echo _x('Pregunta al Cirujano','Home Page','iol_theme');?></span>
  	</div>
  	<div class="questionsBlock">
  		<?php

  					// Restore original Post Data
			wp_reset_postdata();


  		$argsQA = array(
  										'post_type'=> 'question',
  										'posts_per_page' => 3,
  										'post_status'    => 'publish'
  										);
  		$queryQA =  new WP_Query($argsQA);

			$countQA = 0;
			echo '<ul class="qaHomeList">';
			while ( ($queryQA->have_posts()) && ($countQA < 3) ) {
							$queryQA->the_post();

								$countQA = $countQA +1;

								echo '<li>';
								echo '<div class="qaImgCat '.get_idImgSingleQA($queryQA->post->ID).'">&nbsp;</div>';
								echo '<div class="qaTitle"><a href="'.get_permalink($queryQA->post->ID).'">'.get_the_title( $queryQA->post->ID ).'</a></div>';
								echo '<div class="qaContent"><a href="'.get_permalink($queryQA->post->ID).'">'.truncateCustom(get_the_content( $queryQA->post->ID ),$queryQA->post->ID,60).'</a></div>';
								echo '<div class="qaLabels question-tags">'.get_the_term_list($queryQA->post->ID, 'question_tag').'</div>';
								//var_dump(get_the_terms($queryQA->the_post(),'question_tag')); //question_category
								echo '</li>';


				}
			echo '</ul>';



			// Restore original Post Data
			wp_reset_postdata();

		?>



  	</div>


  </div>



  <!-- Blog & QA -->




  <!-- Ini Foro-->

    <div class="homeBloqForo">
  	<div class="introForo">
  		<span class="black-text bold"><?php echo _x('Última actividad en el','Home Page','iol_theme'); ?> </span>
  		<span class="orange-text bold"><?php echo _x('Foro','Home Page','iol_theme'); ?></span>
  	</div>
  	<div class="forosBlock">

  	  		<?php
  		$argsForo = array(
  										'post_type'=> 'reply',
  										'posts_per_page' => 3
  										);
  		$queryForo =  new WP_Query($argsForo);


			echo '<ul class="foroHomeList">';
			while ( $queryForo->have_posts() ) {
							$queryForo->the_post();


   							$answerTopicId = $queryForo->post->post_parent;
								$answerForumId = wp_get_post_parent_id( $answerTopicId );


								echo '<li>';
								echo '<img class="imgForum" src = '.get_forumFeatImg($answerForumId).' class="qaImgCat"/>';
								echo '<div class="homeForumContentWrapper">';
								echo '<div class="qaTitle forumTitle"><a href="'.get_permalink($answerForumId).'">Foro: '.get_the_title($answerForumId ).'</a></div>';
								echo '<div class="foroTitle qaTitle"><a href="'.get_permalink($answerTopicId).'">Hilo: '.get_the_title($answerTopicId ).'</a></div>';
								echo '<div class="qaContent"><a href="'.get_permalink($answerTopicId).'#post-'.$queryForo->post->ID.'">'.truncateCustom(get_the_content( $queryForo->post->ID ),$queryForo->post->ID,60).'</a></div>';
								echo '<div class="qaLabels question-tags"></div>'; //'.get_the_term_list($queryForo->post->ID, 'question_tag').'
								echo '</div>';

								echo '</li>';


				}
			echo '</ul>';



			// Restore original Post Data
			wp_reset_postdata();

		?>


  	</div>

  </div>


  <!-- Fin Foro-->



		</div><!-- #content -->
	</div><!-- #primary -->
