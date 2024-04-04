<?php

///////////////////// INICIO DEL CUSTOM TEST ///////////////////////////////        
		?>	      
		<!-- El posteo de la info no va a ir a la misma página para evitar problemas de refresco y tal -->

<!-- <form action="<?php echo get_permalink(10836)?>" method="post"> -->
	
	
	<?php 
		
		//La variable $user no es el current es el que viene de la función.
		$cuser_ID = $user->ID;
		
		$preedad = get_user_meta( $cuser_ID ,'' , true);
		
		$presexo = get_user_meta( $cuser_ID ,'' , true);
		
		$preOpvars = array(	
							'preedad',
							'presexo',
							'presintvis',
							'prehenfocu',
							'preprococu',
							'premedocu',
							'prehistmedsis',
							'premedsis',
							'preantfami',
							'prestatpsi',
							'prelifestyle',
							'pregrad',
							'prendepsx',
							'prendepgl',
							'prendepgc',
							'prendepgi',
							'preprefaceptg',
							'preprefacephalos',
							'preprefacepgpeq',
							'preprefacepgact',
							'prepersonalidad',
							'preaddcomments'
							);
		
		$textTitleBloqs = array(
			
		'anamWrapper'	=>	_x('ANAMNESIS/HISTORIA', 'Template CustomTest Iol','iol_theme'),
		'dademba' 		=>	_x('Datos demográficos básicos', 'Template CustomTest Iol','iol_theme'),
		'histgen' 		=>	_x('Historia General', 'Template CustomTest Iol','iol_theme'),
		'caractstpsi'	=>	_x('Caracter, status psicológico', 'Template CustomTest Iol','iol_theme'),
		'histsoc'		=>	_x('Historia Social', 'Template CustomTest Iol','iol_theme'),
		'prueresult'	=>	_x('PRUEBAS-RESULTADOS DE EXPLORACIÓN', 'Template CustomTest Iol','iol_theme'),
		'gradprue'		=>	_x('Graduación y pruebas', 'Template CustomTest Iol','iol_theme'),
		'expectvisu'	=>	_x('EXPECTATIVAS VISUALES TRAS LA OPERACIÓN', 'Template CustomTest Iol','iol_theme'),
		'pregexpectvisu'=>	_x('Preguntas sobre sus aspiraciones visuales tras la cirugía', 'Template CustomTest Iol','iol_theme'),
		'valorreal'		=>	_x('VALORACIÓN DE LA INFORMACIÓN Y PROPUESTA DE TIPO DE LENTE INTRAOCULAR', 'Template CustomTest Iol','iol_theme'),
		'valorbis'		=>	_x('Valoración realizada:', 'Template CustomTest Iol','iol_theme'),
		'valorpending'	=>	_x('valoración de la información aportada por el usario', 'Template CustomTest Iol','iol_theme')
		);
		$preOpUserVarTextDefaults  = array(
							'preedad'		=>	'',
							'presexo'		=>	'',
							'presintvis' 	=> 	_x('Descríbanos su visión', 'Template CustomTest Iol','iol_theme'),
							'prehenfocu'	=> 	_x('Escriba las enfermedades que ha sufrido en sus ojos.', 'Template CustomTest Iol','iol_theme'),
							'preprococu'	=>	_x('Escriba las operaciones de ojos a las que se ha sometido.', 'Template CustomTest Iol','iol_theme'),
							'premedocu'		=>	_x('Escriba las medicaciones oculares', 'Template CustomTest Iol','iol_theme'),
							'prehistmedsis'	=>	_x('Enfermedades del resto del cuerpo.', 'Template CustomTest Iol','iol_theme'),
							'premedsis'		=>	_x('Medicación tratamientos del resto del cuerpo', 'Template CustomTest Iol','iol_theme'),
							'preantfami'	=>	_x('Antecedentes de enfermedades familiares, oculares y no oculares', 'Template CustomTest Iol','iol_theme'),
							'prestatpsi'	=>	_x('Información sobre su carácter y estatus psicológico', 'Template CustomTest Iol','iol_theme'),
							'prelifestyle'	=>	_x('Información sobre su estilo de vida', 'Template CustomTest Iol','iol_theme'),
							'pregrad'		=>	_x('Escríbanos su graduación y la información de pruebas de la que disponga', 'Template CustomTest Iol','iol_theme'),
							'prendepsx'		=>	'',
							'prendepgl'		=>	'',
							'prendepgc'		=>	'',
							'prendepgi'		=>	'',
							'preprefaceptg'		=>	'',
							'preprefacephalos'		=>	'',
							'preprefacepgpeq'		=>	'',
							'preprefacepgact'		=>	'',
							'prepersonalidad'		=>	'',
							'preaddcomments'	=>	_x('Escriba cualquier comentario adicional que pueda ser de interés y no haya comentado en en el formulario.', 'Template CustomTest Iol','iol_theme')
			
		);
		
		
		$preOpUserVarTextTitles  = array(
	'preedad' => _x('Edad', 'Template CustomTest Iol','iol_theme'),
	'presexo'=> _x('Sexo', 'Template CustomTest Iol','iol_theme'),
	/*------------------*/
	'h'	=> 	 	_x('Hombre', 'Template CustomTest Iol','iol_theme'),
	'm'	=>	 	_x('Mujer', 'Template CustomTest Iol','iol_theme'),
	/*------------------*/
	'presintvis'=> 	_x('¿Cómo es su visón? Descríbanos como ve de la manera más completa posible: en función de la distancia, de la iluminación...', 'Template CustomTest Iol','iol_theme'),
	'prehenfocu'=> 	_x('¿Ha tenido o tiene alguna enfermedad ocular?', 'Template CustomTest Iol','iol_theme'),
	'preprococu'=> 	_x('¿Se ha sometido a algún tipo de cirugía ocular con anterioridad? En caso positivo, describa cuales y hace cuánto tiempo', 'Template CustomTest Iol','iol_theme'),
	'premedocu'=> 	_x('¿Ha recibido o está recibiendo alguna medicación para los ojos? En caso afirmativo díganos cual.', 'Template CustomTest Iol','iol_theme'),
	'prehistmedsis'=> 	_x('¿Ha tenido o tiene alguna enfermedad no ocular?¿Se ha sometido a algún tipo de cirugía?', 'Template CustomTest Iol','iol_theme'),
	'premedsis'=> 	_x('¿Está siguiendo algún tipo de tratamiento con medicación no ocular? Descríbanoslo, si en el pasado ha seguido alguno que considere relevante, díganoslo también.', 'Template CustomTest Iol','iol_theme'),
	'preantfami'=> 	_x('Antecedentes de enfermedades familiares, oculares y no oculares', 'Template CustomTest Iol','iol_theme'),
	'prestatpsi'=> 	_x('¿Se considera una persona ansiosa, nerviosa? Coméntenos si identifica en usted algún rasgo psicológico relevante.', 'Template CustomTest Iol','iol_theme'),
	'prelifestyle'=> 	_x('¿Cuál es su trabajo?¿A qué dedica su tiempo libre? Denos información sobre su estilo de vida.', 'Template CustomTest Iol','iol_theme'),
	'pregrad'=> 	_x('Escríbanos su graduación y la información de pruebas de la que disponga', 'Template CustomTest Iol','iol_theme'),
	'prendepsx'=> 	_x('¿Cómo de importante es para usted no tener dependencia de las gafas tras la cirugía?', 'Template CustomTest Iol','iol_theme'),
	'prendepgl'=> 	_x('¿Cómo es de importante no necesitar gafas para ver de lejos, p.ejemplo: conducir,…?', 'Template CustomTest Iol','iol_theme'),
	'prendepgc'=> 	_x('¿Cómo es de importante no necesitar gafas para ver de cerca, p.ejemplo: leyendo,…?', 'Template CustomTest Iol','iol_theme'),
	'prendepgi'=> 	_x('¿Cómo es de importante no necesitar gafas para ver a distancia intermedia, p.ejemplo: ordenador,…?', 'Template CustomTest Iol','iol_theme'),
	'preprefaceptg'=> 	_x('¿Si necesitase gafas tras la cirugía, ¿en cuál de las siguientes actividades podrías aceptar gafas?', 'Template CustomTest Iol','iol_theme'),
	/*----------------------*/
	'leyletp'	=>  	_x('Leyendo letra pequeña', 'Template CustomTest Iol','iol_theme'),
	'trabord' 	=>  	_x('Trabajando con el ordenador, cocinando...', 'Template CustomTest Iol','iol_theme'),
	'conduc' 	=>  	_x('Conduciendo', 'Template CustomTest Iol','iol_theme'),
	'ning' 		=>  	_x('En ninguna de las anteriores', 'Template CustomTest Iol','iol_theme'),
	'igual' 	=>  	_x('No tengo especial preferencia', 'Template CustomTest Iol','iol_theme'),
	/*----------------------*/	
	'preprefacephalos'=> 	_x('¿Si vieses bien tanto de lejos como de cerca durante el día, ¿podrías aceptar efectos como halos y destellos durante la noche?', 'Template CustomTest Iol','iol_theme'),
	/*----------------------*/
	'hsi'=> 	_x('Sí', 'Template CustomTest Iol','iol_theme'),
	'hdepend'=> 	_x('Depende, no he experimentado nunca visión con halos', 'Template CustomTest Iol','iol_theme'),
	'hnonunc'=> 	_x('No en ningún caso toleraría halos', 'Template CustomTest Iol','iol_theme'),
	'hnotclear'=> 	_x('No lo tengo claro, depende de la magnitud de los halos.', 'Template CustomTest Iol','iol_theme'),		
	/*----------------------*/
	'preprefacepgpeq'=> _x('Si viese bien durante el día sin necesidad de gafas, tanto de lejos como de cerca, incluso trabajando con el ordenador, ¿podría aceptar las gafas para leer letra muy pequeña?', 'Template CustomTest Iol','iol_theme'),
	/*----------------------*/
	'gsi'		=>  _x('Sí', 'Template CustomTest Iol','iol_theme'),
	'gdepend'	=>  _x('Depende, de lo que entiendan por "pequeña"', 'Template CustomTest Iol','iol_theme'),
	'gnonunc'	=>  _x('No, en ningún caso toleraría el uso de gafas', 'Template CustomTest Iol','iol_theme'),
	'gnotclear'	=>  _x('No lo tengo claro.', 'Template CustomTest Iol','iol_theme'),
	/*----------------------*/
	'preprefacepgact'=> _x('Hay muchas situaciones en las que es necesario ver bien a diferentes distancias. En el caso de que decidiese eliminar la dependencia de las gafas, ¿en qué tipo de escenario consideraría más importante lograr una independencia total?', 'Template CustomTest Iol','iol_theme'),
	/*----------------------*/
	'leermapco'	=>	 _x('Leer, ver un mapa, coser...', 'Template CustomTest Iol','iol_theme'),
	'ordleermenuprec' =>  _x('Estar con el ordenador, leer un menú, ver precios de productos, leer letra de tamaño grande', 'Template CustomTest Iol','iol_theme'),
	'tvlimp' =>  _x('Ver la televisión, limpiar, realizar actividades dentro y fuera de la casa', 'Template CustomTest Iol','iol_theme'),
	'condcart' =>  	_x('Conducir, ver carteles', 'Template CustomTest Iol','iol_theme'),
	'condnight' =>  _x('Conducir por la noche, ver una película en el cine', 'Template CustomTest Iol','iol_theme'),
	/*----------------------*/	
	'prepersonalidad'=> _x('En cuanto a su personalidad... ¿Cómo se considera usted?', 'Template CustomTest Iol','iol_theme'),
	/*-----------------------*/
	'absenc' => 	_x('Abierto, sencillo...', 'Template CustomTest Iol','iol_theme'),
	'perfmejor' => 	_x('Perfeccionista, doy y espero siempre lo mejor', 'Template CustomTest Iol','iol_theme'),
	/*-----------------------*/
	'preaddcomments'	=>	_x('Escriba cualquier comentario adicional que pueda ser de interés y no haya comentado en en el formulario.', 'Template CustomTest Iol','iol_theme')		
		);
		
foreach($preOpvars as $key){
		$preOpUserVarValue[$key]	= 	get_user_meta($cuser_ID, $key,true);
		//echo 'El usermetada '.$key.' es igual a: '.$preOpUserVarValue[$key].'<br />';
		$preOpUserVarText[$key] 	=	$preOpUserVarValue[$key] ? $preOpUserVarValue[$key]:  $preOpUserVarTextDefaults[$key];
		}
		
		
		
		
		
				
	    //echo $user_url ? $user_url : 'No website';
		
	?>
	
	<h2><?php echo _x('Historia Oftalmológica-Médica Preoperatoria:','Template CustomTest Iol','iol_theme'); ?></h2>

		<div id="anamWrapper">
			<h3><?php echo $textTitleBloqs['anamWrapper']; ?></h3>
			
			<table class="form-table">
				<tbody>
	 <tr><td colspan="2"><span class="tqbloq"><?php echo $textTitleBloqs['dademba']; ?></span></td></tr>
					 <!-- Datos demográficos básicos -->
					<!-- Edad-->
					<tr>
						<th><label><?php echo $preOpUserVarTextTitles['preedad']; ?></label></th>
						<!--Edad -->
						<td>
							<input type="text" id="edad" name="preedad" value="<?php echo $preOpUserVarText['preedad']; ?>" />
						</td>
					</tr>
					<!-- Sexo-->
					<tr>
						<th><label><?php echo $preOpUserVarTextTitles['presexo']; ?></label></th>
						<td>
							<select name="presexo" id="sexo">
	<option val="" <?php selected('',$preOpUserVarText['presexo']); ?> ></option>
	<option val="h" <?php selected('h',$preOpUserVarText['presexo']); ?> ><?php echo $preOpUserVarTextTitles['h']; ?></option>
	<option val="m" <?php selected('m',$preOpUserVarText['presexo']); ?> ><?php echo $preOpUserVarTextTitles['m']; ?></option>									
							</select>
						</td>
					</tr>
					
					<!-- Historia Médica Ocular -->
					
					<!-- Síntomas visuales-->
					<tr class="med">
						<th><label><?php echo $preOpUserVarTextTitles['presintvis']; ?></label></th>
						<!-- ¿Cómo es su visón? Descríbanos como ve de la manera más completa posible: en función de la distancia, de la iluminación...-->
						<td>
							<textarea name="presintvis" id="sintvis"><?php echo $preOpUserVarText['presintvis']; ?></textarea>
							
						</td>
					</tr>


<!-- <tr><span class="tqbloq">Historia Ocular</span></tr> -->
					<tr class="high">
						<th><label><?php echo $preOpUserVarTextTitles['prehenfocu']; ?></label></th>
						<!--¿Ha tenido o tiene alguna enfermedad ocular? -->
						<td>
							<textarea id="henfocu" name="prehenfocu"><?php echo $preOpUserVarText['prehenfocu']; ?></textarea>
						</td>
					</tr>
					<!-- Procedmientos oculares-->
					<tr class="high">
						<th><label><?php echo $preOpUserVarTextTitles['preprococu']; ?></label></th>
						<!-- ¿Se ha sometido a algún tipo de cirugía ocular con anterioridad? En caso positivo, describa cuales y hace cuánto tiempo -->
						<td>
							<textarea name="preprococu" id="prococu"><?php echo $preOpUserVarText['preprococu']; ?></textarea>
							
						</td>
					</tr>
					<!-- Medicación ocular-->
					<tr class="high">
						<th><label><?php echo $preOpUserVarTextTitles['premedocu']; ?></label></th>
						<!-- ¿Ha recibido o está recibiendo alguna medicación para los ojos? En caso afirmativo díganos cual. -->
						<td>
							<textarea name="premedocu" id="medocu"><?php echo $preOpUserVarText['premedocu']; ?></textarea>
							
						</td>
					</tr>
				
 				<tr><td colspan="2"><span class="tqbloq"><?php echo $textTitleBloqs['histgen']; ?></span></td></tr>
 					<!-- Historia General -->
					<!-- Historia médica Sistémica -->
					<tr class="high">
						<th><label><?php echo $preOpUserVarTextTitles['prehistmedsis']; ?></label></th>
						<!-- ¿Ha tenido o tiene alguna enfermedad no ocular?¿Se ha sometido a algún tipo de cirugía? -->
						<td>
							<textarea id="histmedsis" name="prehistmedsis"><?php echo $preOpUserVarText['prehistmedsis']; ?></textarea>
						</td>
					</tr>
					<!-- Medicación sistémica -->
					<tr class="high">
						<th><label><?php echo $preOpUserVarTextTitles['premedsis']; ?></label></th>
						<!-- ¿Está siguiendo algún tipo de tratamiento con medicación no ocular? Descríbanoslo, si en el pasado ha seguido alguno que considere relevante, díganoslo también. -->
						<td>
							<textarea name="premedsis" id="medsis"><?php echo $preOpUserVarText['premedsis']; ?></textarea>
							
						</td>
					</tr>

					<!-- Antedentes familiares-->
				<tr><td colspan="2"><span class="tqbloq"><?php echo $preOpUserVarTextTitles['preantfami']; ?></span></td></tr> 
				 
					<tr class="med">
						<th><label><?php echo $preOpUserVarTextTitles['preantfami']; ?></label></th>
						<!-- ¿Algún familiar suyo ha tenido alguna enfermedad (tanto ocular como no ocular) relevante? En caso afirmativo díganos cual.-->
						<td>
							<textarea  name="preantfami" id="antfami"><?php echo $preOpUserVarText['preantfami']; ?></textarea>
							
						</td>
					</tr>

					<!-- Estatus Psicológico-->
			<tr><td colspan="2"><span class="tqbloq"><span class="tqbloq"><?php echo $textTitleBloqs['caractstpsi']; ?></span></td></tr>
			<!-- Caracter, status psicológico-->
					<tr>
						<th><label><?php echo $preOpUserVarTextTitles['prestatpsi']; ?></label></th>
						<!-- ¿Se considera una persona ansiosa, nerviosa? Coméntenos si identifica en usted algún rasgo psicológico relevante. -->
						<td>
							<textarea  name="prestatpsi" id="statpsi"><?php echo $preOpUserVarText['prestatpsi']; ?></textarea>
							
						</td>
					</tr>
								<!-- Historia Social-->
					
				<tr><td colspan="2"><span class="tqbloq"><?php echo $textTitleBloqs['histsoc']; ?></span></td></tr>
				<!-- Historia Social -->
					<tr class="med">
						<th><label><?php echo $preOpUserVarTextTitles['prelifestyle']; ?></label></th>
						<!-- ¿Cuál es su trabajo?¿A qué dedica su tiempo libre? Denos información sobre su estilo de vida. -->
						<td>
							<textarea  name="prelifestyle" id="lifestyle"><?php echo $preOpUserVarText['prelifestyle']; ?></textarea>
							
						</td>
					</tr>
				<!--	
				<tr class="lastsubmit">
					<td colspan="2">
					<input type="submit" name="smithist" value="Actualizar ANAMNESIS/HISTORIA" />
					</td>
				</tr>
				-->
				</tbody>
			</table>
			
			</div>

<!-- Fin Bloque Anamnesis -->

<!-- Inicio Bloque Exploración -->


		<div id="exploWrapper">
			<h3><?php echo $textTitleBloqs['prueresult']; ?></h3>
			<!-- PRUEBAS-RESULTADOS DE EXPLORACIÓN-->
			<table class="form-table">
				<tbody>
					<tr><td colspan="2"><span class="tqbloq"><?php echo $textTitleBloqs['gradprue']; ?></span></td></tr>
					<!-- Graduación y pruebas -->
					<!-- Graduación-->
					<tr class="high">
						<th><label><?php echo $preOpUserVarTextTitles['pregrad']; ?></label></th>
				<!-- Graduación. Si tiene cataratas necesitaríamos la graduación previa. (Miopía/Hipermetropía/Astigmatismo/Adición...) Denos la información de la que disponga. -->		
						<td>
							<textarea  id="grad" name="pregrad"><?php echo $preOpUserVarText['pregrad'];?></textarea>
						</td>
					</tr>
			<!-- no incluimos los submit -->		
			<!--	<tr class="lastsubmit">
					<td colspan="2">
					<input type="submit" name="smitexplo" value="Actualizar GRADUACIÓN/RESULTADOS DE EXPLORACION" />
					</td>
				</tr>	
			-->		
					
					
				</tbody>
			</table>
		</div>

<!-- Fin Bloque Exploración -->

<!-- Inicio Expectativas Post Operatorias -->


		<div id="expectWrapper">
			<h3><?php echo $textTitleBloqs['expectvisu']; ?></h3>
			<!-- EXPECTATIVAS VISUALES TRAS LA OPERACIÓN -->
			<table class="form-table">
				<tbody>
					<tr><td colspan="2"><span class="tqbloq"><?php echo $textTitleBloqs['pregexpectvisu']; ?></span></td></tr>
					<!-- Preguntas sobre sus aspiraciones visuales tras la cirugía-->
					
					
					<!-- NoDepTrasSx-->
					<tr>
		<th><label><?php echo $preOpUserVarTextTitles['prendepsx']; ?></label></th>
		<!-- ¿Cómo de importante es para usted no tener dependencia de las gafas tras la cirugía? -->
						<td>
							<textarea type="text" id="ndepsx" name="prendepsx">
							<?php echo $preOpUserVarText['prendepsx']; ?>
							</textarea>
						</td>
					</tr>
					<!-- NoDepGafaLejos-->
					<tr>
		<th><label><?php echo $preOpUserVarTextTitles['prendepgl']; ?></label></th>
		<!-- ¿Cómo es de importante no necesitar gafas para ver de lejos, p.ejemplo: conducir,…? -->
						<td>
							<textarea type="text" id="ndepgl" name="prendepgl" >
							<?php echo $preOpUserVarText['prendepgl']; ?>
							</textarea>
						</td>
					</tr>
					<!-- NoDepGafaCerca-->
					<tr>
		<th><label><?php echo $preOpUserVarTextTitles['prendepgc']; ?></label></th>
		<!-- ¿Cómo es de importante no necesitar gafas para ver de cerca, p.ejemplo: leyendo,…? -->
						<td>
							<textarea type="text" id="ndepgc" name="prendepgc">
							<?php echo $preOpUserVarText['prendepgl']; ?>
							</textarea>
						</td>
					</tr>
					<!-- NoDepGafaIntermed-->
					<tr>
		<th><label><?php echo $preOpUserVarTextTitles['prendepgi']; ?></label></th>
		<!-- ¿Cómo es de importante no necesitar gafas para ver a distancia intermedia, p.ejemplo: ordenador,…? -->
						<td>
							<textarea type="text" id="ndepgc" name="prendepgi">
							<?php echo $preOpUserVarText['prendepgi']; ?>
							</textarea>
						</td>
					</tr>
					<!--Preg aceptacion gafas-->
					<tr>
					
					<th><label><?php echo $preOpUserVarTextTitles['preprefaceptg']; ?></label></th>
					<!-- ¿Si necesitase gafas tras la cirugía, ¿en cuál de las siguientes actividades podrías aceptar gafas? -->
						<td>
							<select name="preprefaceptg" id="prefaceptg">
	<option val="" <?php selected('',$preOpUserVarText['preprefaceptg']); ?> ></option>

<option val="leyletp" <?php selected('leyletp',$preOpUserVarText['preprefaceptg']); ?> ><?php echo $preOpUserVarTextTitles['leyletp']; ?></option>
					<!-- Leyendo letra pequeña -->
<option val="trabord"  <?php selected('trabord',$preOpUserVarText['preprefaceptg']); ?> ><?php echo $preOpUserVarTextTitles['trabord']; ?></option>
								<!-- Trabajando con el ordenador, cocinando... -->
<option val="conduc" <?php selected('conduc',$preOpUserVarText['preprefaceptg']); ?> ><?php echo $preOpUserVarTextTitles['conduc']; ?></option>
								<!-- Conduciendo -->
<option val="ning"  <?php selected('ning',$preOpUserVarText['preprefaceptg']); ?> ><?php echo $preOpUserVarTextTitles['ning']; ?></option>
								<!-- En ninguna de las anteriores -->
<option val="igual" <?php selected('igual',$preOpUserVarText['preprefaceptg']); ?> ><?php echo $preOpUserVarTextTitles['igual']; ?></option>
								<!-- No tengo especial preferencia -->
							</select>
						</td>
					</tr>					

					<!--Preg aceptacion halos-->
					<tr>
					
					<th><label><?php echo $preOpUserVarTextTitles['preprefacephalos']; ?></label> </th>
					<!-- ¿Si vieses bien tanto de lejos como de cerca durante el día, ¿podrías aceptar efectos como halos y destellos durante la noche? -->
				<td>
				<select name="preprefacephalos" id="prefacephalos">
					<option val="" <?php selected('',$preOpUserVarText['preprefacephalos']); ?>  ></option>
					<option val="hsi" <?php selected('hsi',$preOpUserVarText['preprefacephalos']); ?> ><?php echo $preOpUserVarTextTitles['hsi']; ?></option>
					<!-- Sí -->
					<option val="hdepend" <?php selected('hdepend',$preOpUserVarText['preprefacephalos']); ?> ><?php echo $preOpUserVarTextTitles['hdepend']; ?></option>
					<!-- Depende, no he experimentado nunca visión con halos -->
					<option val="hnonunc" <?php selected('hnonunc',$preOpUserVarText['preprefacephalos']); ?> ><?php echo $preOpUserVarTextTitles['hnonunc']; ?></option>
					<!-- No en ningún caso toleraría halos -->
					<option val="hnotclear" <?php selected('hnotclear',$preOpUserVarText['preprefacephalos']); ?> ><?php echo $preOpUserVarTextTitles['hnotclear']; ?></option>
					<!-- No lo tengo claro, depende de la magnitud de los halos. -->
				</select>
						</td>
					</tr>					
							
				<!--Preg aceptacion gafa cerca-->
					<tr>
					
					<th><label><?php echo $preOpUserVarTextTitles['preprefacepgpeq']; ?></label></th>
				<!-- Si viese bien durante el día sin necesidad de gafas, tanto de lejos como de cerca, incluso trabajando con el ordenador, ¿podría aceptar las gafas para leer letra muy pequeña? -->	
				<td>
				<select name="preprefacepgpeq" id="prefacepgpeq">
					<option val="" <?php selected('',$preOpUserVarText['preprefacepgpeq']); ?> ></option>
					<option val="gsi" <?php selected('gsi',$preOpUserVarText['preprefacepgpeq']); ?> ><?php echo $preOpUserVarTextTitles['gsi']; ?></option>
					<!-- Sí -->
					<option val="gdepend" <?php selected('gdepend',$preOpUserVarText['preprefacepgpeq']); ?> ><?php echo $preOpUserVarTextTitles['gdepend']; ?></option>
					<!-- Depende, de lo que entiendan por "pequeña" -->
					<option val="gnonunc" <?php selected('gnonunc',$preOpUserVarText['preprefacepgpeq']); ?> ><?php echo $preOpUserVarTextTitles['gnonunc']; ?></option>
					<!-- No, en ningún caso toleraría el uso de gafas -->
					<option val="gnotclear" <?php selected('gnotclear',$preOpUserVarText['preprefacepgpeq']); ?> ><?php echo $preOpUserVarTextTitles['gnotclear']; ?></option>
					<!-- No lo tengo claro.-->
				</select>
						</td>
					</tr>			

				<!--Preg aceptacion gafa cerca-->
					<tr>
					
					<th><label><?php echo $preOpUserVarTextTitles['preprefacepgact']; ?></label></th>
					<!-- Hay muchas situaciones en las que es necesario ver bien a diferentes distancias. En el caso de que decidiese eliminar la dependencia de las gafas, ¿en qué tipo de escenario consideraría más importante lograr una independencia total? -->
				<td>
				<select name="preprefacepgact" id="prefacepgact">
					<option val="" <?php selected('',$preOpUserVarText['preprefacepgact']); ?> ></option>
					<option val="leermapco" <?php selected('leermapco',$preOpUserVarText['preprefacepgact']); ?> ><?php echo $preOpUserVarTextTitles['leermapco']; ?></option>
					<!-- Leer, ver un mapa, coser... -->
					<option val="ordleermenuprec" <?php selected('ordleermenuprec',$preOpUserVarText['preprefacepgact']); ?> ><?php echo $preOpUserVarTextTitles['ordleermenuprec']; ?></option>
					<!-- Estar con el ordenador, leer un menú, ver precios de productos, leer letra de tamaño grande -->
					<option val="tvlimp" <?php selected('tvlimp',$preOpUserVarText['preprefacepgact']); ?>><?php echo $preOpUserVarTextTitles['tvlimp']; ?></option>
					<!-- Ver la televisión, limpiar, realizar actividades dentro y fuera de la casa -->
					<option val="condcart" <?php selected('condcart',$preOpUserVarText['preprefacepgact']); ?> ><?php echo $preOpUserVarTextTitles['condcart']; ?></option>
					<!-- Conducir, ver carteles -->
					<option val="condnight" <?php selected('condnight',$preOpUserVarText['preprefacepgact']); ?> ><?php echo $preOpUserVarTextTitles['condnight']; ?></option>
					<!-- Conducir por la noche, ver una película en el cine -->					
				</select>
						</td>
					</tr>

				<!--Preg personalidad-->
					<tr>
					
					<th><label><?php echo $preOpUserVarTextTitles['prepersonalidad']; ?></label></th>
					<!-- En cuanto a su personalidad... ¿Cómo se considera usted? -->
				<td>
				<select name="prepersonalidad" id="personalidad">
					<option val="" <?php selected('',$preOpUserVarText['prepersonalidad']); ?> ></option>
					<option val="absenc"  <?php selected('absenc',$preOpUserVarText['prepersonalidad']); ?> ><?php echo $preOpUserVarTextTitles['absenc']; ?></option>
					<!-- Abierto, sencillo... -->
					<option val="perfmejor"  <?php selected('perfmejor',$preOpUserVarText['prepersonalidad']); ?> ><?php echo $preOpUserVarTextTitles['perfmejor']; ?></option>
					<!-- Perfeccionista, doy y espero siempre lo mejor-->	
				</select>
						</td>
					</tr>
					
			<!-- Comentarios adicionales -->
					<tr>
		<th><label><?php echo $preOpUserVarTextTitles['preaddcomments']; ?></label></th>
		<!-- ¿Cómo es de importante no necesitar gafas para ver a distancia intermedia, p.ejemplo: ordenador,…? -->
						<td>
							<textarea id="preaddcomments" name="preaddcomments"><?php echo $preOpUserVarText['preaddcomments']; ?>							</textarea>
						</td>
					</tr>
					
			<!-- Fin comentarios adicionales -->		
					
		<!-- Reseteo de AllOk -->
					<tr>
		<th><label><?php echo 'Desbloquear'; ?></label></th>
		<!-- ¿Cómo es de importante no necesitar gafas para ver a distancia intermedia, p.ejemplo: ordenador,…? -->
						<td>
			<?php 
				
				$allOk = get_user_meta($cuser_ID, 'allok',true) ? get_user_meta($cuser_ID, 'allok',true) : '';
				
			?>				
				<select name="allok" id="allok">
					<option val="ok" <?php selected($allOk, 'ok'); ?> >Bloqueados</option>
					<option val="" <?php selected($allOk, ''); ?> >No Bloqueados</option>

				</select>
						</td>
					</tr>
					
		<!-- Reseteo de AllOk -->			
					
		<!-- No incluimos los submit -->			
		<!-- 	<tr class="lastsubmit">
					<td colspan="2">
					<input type="submit" name="smitexpect" value="Actualizar EXPECTATIVAS VISUALES" />
					</td>
				</tr>	
	      -->
		
				</tbody>
			</table>
		</div>

<!-- Fin Bloque Expectativas postoperatorias -->



<!-- Metemos el botón de envío de resultados -->

<!--v<input id="fullHist" type="submit" name="submitfullhist" value="Actualizar TODA MI INFORMACIÓN" />
<input id="allok" type="submit" name="allok" value="He revisado mi información. Está OK. Solicito Consejo sobre Lente Intraocular" />
-->
<!-- Fin del botón de envío de resultados-->





<!-- Inicio Bloque Valoración -->


		<div id="valoWrapper">
			<h3><?php echo $textTitleBloqs['valorreal'];?></h3>
			<!-- VALORACIÓN DE LA INFORMACIÓN Y PROPUESTA DE TIPO DE LENTE INTRAOCULAR -->
			<table class="form-table">
				<tbody class="valoration">
					<tr><td><span class="tqbloq"><?php echo $textTitleBloqs['valorbis'];?></span></td></tr>
				<!-- Valoración realizada:-->
					<tr>
						<td>
							<p class="valor">
								<?php //echo $textTitleBloqs['valorpending']; ?>
							<!-- valoración de la información aportada por el usario-->
							
							<textarea id="allok" name="allok">
							<?php echo $preOpUserVarText['valorpending']; ?>
							</textarea>
							</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

<!-- Fin Bloque Exploración -->

<!-- Inicio Expectativas Post Operatorias -->


<!-- </form> -->

<style>
	@media only screen and (max-width: 768px){
#profile-page .form-table textarea {
  	max-width: 90% !important; 
   	width: 90% !important;
}
}
	
</style>


<script>
	
	jQuery('#anamWrapper,#exploWrapper,#expectWrapper, #valoWrapper').accordion({
      collapsible: true,
      //event: "click hoverintent",
      active : 'none'
    });
    
</script>
		      
		      
     
		      
	