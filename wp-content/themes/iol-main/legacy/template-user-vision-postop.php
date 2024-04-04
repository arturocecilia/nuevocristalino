<?php
/*
 * Template Name: Template User Vision Postop
 * Description: Este es el template para las páginas que no tienen menús
 */
 
 get_header(); ?>

	<div id="primary" class="site-content-customuser site-content uservisionpostop post-op-test-content">
		<div id="content" role="main">

<!-- Aquí metemos el cuestionario tal cual -->
			<?php while ( have_posts() ) : the_post(); ?>
				
				<!-- entry-header -->
 				<div class="entry-header">
 					<h1 class="entry-title">
 						<?php the_title();?>
 					</h1>
 				</div>
				<?php the_content();?>
				<?php /*get_template_part( 'content', 'page' );*/ ?>
				 <?php /* comments_template( '', true ); */ ?>
			<?php endwhile; // end of the loop. ?>


<!-- INICIO DEL FORMULARIO POST-OPERATORIO --get_page_by_title( 'Redirect to Test Results' ) -->
<form id="post-op-form" method="post" action="<?php echo  get_permalink( 10836 ) ;  ?>">

<!-- A esta página se podrá acceder también desde otros lugares 

-->

<input name="formpost" value="formpost" type="hidden" />
<?php
		$cuser_ID = get_current_user_id();
		
		
		$postOpvars = array(	
							'surgerytime',
							'surgeryeye',
							'surgeryiol',
							'ddriving',
							'ndriving',
							'ivision',
							'newspaper',
							'prices',
							'needle',
							'dglasses',
							'nglasses',
							'currentvision',
							'satiol',
							'age',
							'provincia',
							'clinic',
							'comments'
							);
			$postOpUserVarTextDefaults  = array(
							'surgerytime'		=>	'',
							'surgeryeye'		=>	'',
							'surgeryiol'		=>	'',
							'ddriving'			=>	'',
							'ndriving'			=>	'',
							'ivision'			=>	'',
							'newspaper'			=>	'',
							'prices'			=>	'',
							'needle'			=>	'',
							'dglasses'			=>	'',
							'nglasses'			=>	'',
							'currentvision'		=>	'',
							'satiol'			=>	'',
							'age'				=>	'',
							'provincia'			=>	'',
							'clinic'			=>	'',
							'comments'			=>	''
		);
		
		
				$textTitleBloqs = array(
			
						'basicq'	=>	_x('Preguntas básicas sobre la operación', 'Template CustomTest Iol','iol_theme'),
						'usogafas'	=>	_x('Dependencia actual de las gafas.', 'Template CustomTest Iol','iol_theme'),
						'resulsatis'=>	_x('Resultado y satisfacción tras la operación', 'Template CustomTest Iol','iol_theme'),
						'infoadic'	=>	_x('Información adicional (Le recordamos que sólo ha de rellenarla si lo desea)','Template CustomTest Iol','iol_theme')

		);
		
		
		
		$postOpUserVarTextTitles  = array(
	'surgerytime' => _x('¿Hace cuánto se operó de cataratas o de presbicia con lente intraocular?','Template PostOp Test','iol_theme'),
	/*-------------------*/
	'less3' =>	_x('Menos de 3 meses','Template PostOp Test','iol_theme'),
	'bet36' =>	_x('Entre 3 y 6 meses','Template PostOp Test','iol_theme'),
	'more6' =>	_x('Más de 6 meses','Template PostOp Test','iol_theme'),

	/*-------------------*/
	'surgeryeye' =>_x('Se operó...','Template PostOp Test','iol_theme'),
	/*-------------------*/
	'oe' => _x('Un ojo','Template PostOp Test ','iol_theme'),
	'be' => _x('Los dos ojos','Template PostOp Test','iol_theme'),
	/*-------------------*/
	'surgeryiol' => _x('¿Qué tipo de Lente Intraocular (LIO) se le implantó?','Template PostOp Test','iol_theme'),
	/*-------------------*/
	'me'		=> 	_x('Una LIO Monofocal Esférica','Template PostOp Test','iol_theme'),
	'ma'		=> 	_x('Una LIO Monofocal Asférica','Template PostOp Test','iol_theme'),
	'mt'		=>	_x('Una LIO Monofocal Tórica','Template PostOp Test','iol_theme'),
	'mu'		=>  _x('Una LIO Multifocal','Template PostOp Test','iol_theme'),
	'mut' 		=>	_x('Una LIO Multifocal Tórica','Template PostOp Test','iol_theme'),
	'aco'		=>  _x('Una LIO Acomodativa','Template PostOp Test','iol_theme'),
	'add'		=>  _x('Una LIO Add-On','Template PostOp Test','iol_theme'),
	'iclTest' 	=>	_x('Una LIO ICL','Template PostOp Test','iol_theme'),
	'oth'		=>	 _x('Otro tipo','Template PostOp Test','iol_theme'),
	'dk'		=>	 _x('No lo sé','Template PostOp Test','iol_theme'),
	/*-------------------*/
	'ddriving'	=>	_x('Conducir de día (Visión de lejos con buena iluminación)','Template PostOp Test','iol_theme'),
	/*-------------------*/
	'ldym'		=>	_x('Sí, muchísima','Template PostOp Test','iol_theme'),
	'ldyq'		=>	_x('Sí, bastante','Template PostOp Test','iol_theme'),
	'ldys'		=>	_x('Sí, alguna','Template PostOp Test','iol_theme'),
	'ldnn'		=>	_x('No, ninguna','Template PostOp Test','iol_theme'),
	/*-----------------*/
	'ndriving'	=>	_x('Conducir de noche (Visión de lejos con poca iluminación)','Template PostOp Test','iol_theme'),
	'ndym'		=>	_x('Sí, muchísima','Template PostOp Test','iol_theme'),
	'ndyq'		=>	_x('Sí, bastante','Template PostOp Test','iol_theme'),
	'ndys'		=>	_x('Sí, alguna','Template PostOp Test','iol_theme'),
	'ndnn'		=>	_x('No, ninguna','Template PostOp Test','iol_theme'),
	/*-----------------*/
	'ivision'	=>	_x('Trabajar con el ordenador, usar el teléfono, ver el GPS de su coche... (uso de visión intermedia) ','Template PostOp Test','iol_theme'),
	/*-----------------*/
	'ivym'		=>	_x('Sí, muchísima','Template PostOp Test','iol_theme'),
	'ivyq'		=>	_x('Sí, bastante','Template PostOp Test','iol_theme'),
	'ivys'		=>	_x('Sí, alguna','Template PostOp Test','iol_theme'),
	'ivnn'		=>	_x('No, ninguna','Template PostOp Test','iol_theme'),
	/*-----------------*/
	'newspaper'	=>	 _x('Leer el periódico, revistas:','Template PostOp Test','iol_theme'),
	'newym'		=>	 _x('Sí, muchísima','Template PostOp Test','iol_theme'),
	'newyq'		=>	 _x('Sí, bastante','Template PostOp Test','iol_theme'),
	'newys'		=> _x('Sí, alguna','Template PostOp Test','iol_theme'),
	'newnn'		=> _x('No, ninguna','Template PostOp Test','iol_theme'),
	/*-------------------*/
	'prices'	=> 	_x('Ver los precios de los productos en el ticket cuando está de compras:','Template PostOp Test','iol_theme'),
	/*-------------------*/
	'pricesym'	=>  _x('Sí, muchísima','Template PostOp Test','iol_theme'),
	'pricesyq'	=>    _x('Sí, bastante','Template PostOp Test','iol_theme'),
	'pricesys'	=>	_x('Sí, alguna','Template PostOp Test','iol_theme'),
	'pricesnn'	=>	_x('No, ninguna','Template PostOp Test','iol_theme'),
	/*-------------------*/
	'needle'  	=> _x('Ver al enhebrar la aguja o al realizar trabajos manuales de similar precisión:','Template PostOp Test','iol_theme'),
	/*-------------------*/
	'needleym'	=> _x('Sí, muchísima','Template PostOp Test','iol_theme'),
	'needleyq'	=> _x('Sí, bastante','Template PostOp Test','iol_theme'),
	'needleys'	=> _x('Sí, alguna','Template PostOp Test','iol_theme'),
	'needlenn'	=> _x('No, ninguna','Template PostOp Test','iol_theme'),
	/*-------------------*/
	'dglasses'	=> _x('¿Con qué frecuencia usa gafas para ver de lejos?','Template PostOp Test','iol_theme'),
	/*-------------------*/
	'dga'		=> _x('Siempre','Template PostOp Test','iol_theme'),
	'dgs'		=> _x('En ocasiones','Template PostOp Test','iol_theme'),
	'dgn'		=> _x('Nunca','Template PostOp Test','iol_theme'),
	/*--------------------*/
	'nglasses'	=> _x('¿Con qué frecuencia usa gafas para leer?','Template PostOp Test','iol_theme'),
	/*--------------------*/
	'nga'		=> _x('Siempre','Template PostOp Test','iol_theme'),
	'ngs'		=> _x('En ocasiones','Template PostOp Test','iol_theme'),
	'ngn'		=> _x('Nunca','Template PostOp Test','iol_theme'),
	/*--------------------*/
	'currentvision'	=>  _x('¿Tiene la sensación de que su visión actual le genera dificultades, en cualquier sentido, para llevar a cabo su estilo de vida?','Template PostOp Test','iol_theme'),
	/*--------------------*/
	'cvym'	=> _x('Sí, muchísima','Template PostOp Test','iol_theme'),
	'cvyq'	=> _x('Sí, bastante','Template PostOp Test','iol_theme'),
	'cvys'	=> _x('Sí, alguna','Template PostOp Test','iol_theme'),
	'cvnn'	=> _x('No, ninguna','Template PostOp Test','iol_theme'),
	/*---------------------*/
	'satiol'=> _x('¿Esta usted satisfecho con su visión actual, tras habérsele implantado una lente intraocular?','Template PostOp Test','iol_theme'), 
	/*---------------------*/
	'satym' => _x('Sí, muy satisfecho','Template PostOp Test','iol_theme'),
	'satyq' => _x('Sí, bastante satisfecho','Template PostOp Test','iol_theme'),
	'satys' => _x('Sí, satisfecho','Template PostOp Test','iol_theme'),
	'satn'  => _x('No','Template PostOp Test','iol_theme'),
	'satnn' => _x('No, nada satisfecho','Template PostOp Test','iol_theme'),
	/*-----------------------*/
	'age'	=>	_x('¿Qué edad tiene?','Template PostOp Test','iol_theme'),
	'provincia'=> _x('¿De qué provincia/region es usted?','Template PostOp Test','iol_theme'),
	'clinic'	=>	_x('¿En qué clinica se ha operado?','Template PostOp Test','iol_theme'),
	'comments'	=>_x('Rellene cualquier comentario u observación','Template PostOp Test','iol_theme')

		);
		
		
		
	
	foreach($postOpvars as $key){
		$postOpUserVarValue[$key]	= 	get_user_meta($cuser_ID, $key,true);
		//echo 'El usermetada '.$key.' es igual a: '.$preOpUserVarValue[$key].'<br />';
		$postOpUserVarText[$key] 	=	$postOpUserVarValue[$key] ? $postOpUserVarValue[$key]:  $postOpUserVarTextDefaults[$key];
		}
	
	
				
							?>





<div id="basic">
	<h3><?php echo $textTitleBloqs['basicq']; ?></h3>
<table>
	<tbody>

	<!-- 1 Ini -->
	
    <tr>
	<th>
		<label class="bl b1bl"><?php  echo $postOpUserVarTextTitles['surgerytime']; ?></label>
	</th>
	<td>
	<select name="surgerytime" id="surgerytime">
			<option value="" <?php selected('',$postOpUserVarText['surgerytime']); ?> ></option>
			<option value="less3" <?php selected('less3',$postOpUserVarText['surgerytime']); ?>>
				<?php echo $postOpUserVarTextTitles['less3']; ?> 
				</option>
			<option value="bet36" <?php selected('bet36',$postOpUserVarText['surgerytime']); ?>>
				<?php  echo $postOpUserVarTextTitles['bet36']; ?>
			</option>
			<option value="more6" <?php selected('more6',$postOpUserVarText['surgerytime']); ?>>
				<?php  echo $postOpUserVarTextTitles['more6'];  ?>
			</option>
		</select>
	</td>
	<tr>	

<!-- 1 Fin -->

<!-- 2 Ini -->

    	<tr>
    	<th>
		<label><?php  echo $postOpUserVarTextTitles['surgeryeye']; ?></label>
    	</th>
		<td>
		<select name="surgeryeye" id="surgeryeye">
			<option value="" <?php selected('',$postOpUserVarText['surgeryeye']); ?> ></option>
			<option value="oe" <?php selected('oe',$postOpUserVarText['surgeryeye']); ?>>
				<?php  echo $postOpUserVarTextTitles['oe']; ?>
			</option>
			<option value="be" <?php selected('be',$postOpUserVarText['surgeryeye']); ?>>
				<?php  echo $postOpUserVarTextTitles['be']; ?>
			</input>
		</select>
		</td>
		</tr>
<!-- 2 Fin -->

<!-- 3 Ini -->
	
		<tr>
		<th>
		<label><?php  echo  $postOpUserVarTextTitles['surgeryiol']; ?></label>
		</th>
		<td>
		<select name="surgeryiol" id="surgeryiol">
			<option value="" <?php selected('',$postOpUserVarText['surgeryiol']); ?> ></option>
			<option value="me" id="me" <?php selected('me',$postOpUserVarText['surgeryiol']); ?> >
				<?php  echo $postOpUserVarTextTitles['me']; ?>
			</option>
			<option value="ma" id="ma" <?php selected('ma',$postOpUserVarText['surgeryiol']); ?>>
				<?php  echo $postOpUserVarTextTitles['ma']; ?>
			</option>
			<option value="mt" id="mt" <?php selected('mt',$postOpUserVarText['surgeryiol']); ?>>
				<?php  echo $postOpUserVarTextTitles['mt']; ?>
			</option>
			<option value="mu" id="mu" <?php selected('mu',$postOpUserVarText['surgeryiol']); ?>>
				<?php  echo $postOpUserVarTextTitles['mu']; ?>
			</option>
			<option value="mut" id="mut" <?php selected('mut',$postOpUserVarText['surgeryiol']); ?>>
				<?php  echo $postOpUserVarTextTitles['mut']; ?>
			</option>
			<option value="aco" id="aco" <?php selected('aco',$postOpUserVarText['surgeryiol']); ?>>
				<?php  echo $postOpUserVarTextTitles['aco']; ?>
			</option>
			<option value="add" id="add" <?php selected('add',$postOpUserVarText['surgeryiol']); ?>>
				<?php  echo $postOpUserVarTextTitles['add']; ?>
			</option>
			<option value="iclTest" id="iclTest" <?php selected('iclTest',$postOpUserVarText['surgeryiol']); ?>>
				<?php  echo $postOpUserVarTextTitles['iclTest']; ?>
			</option>
			<option value="oth" id="oth" <?php selected('oth',$postOpUserVarText['surgeryiol']); ?>>
				<?php  echo $postOpUserVarTextTitles['oth']; ?>
			</option>
			<option value="dk" id="dk" <?php selected('dk',$postOpUserVarText['surgeryiol']); ?>>
				<?php  echo $postOpUserVarTextTitles['dk']; ?>
			</option>
		</select>
		</td>
		</tr>

<!-- 3 Fin -->

</tbody>
</table>
</div>
<!-- Fin Básic -->

<!-- 4 Ini -->

<div id="results">

        <h3><?php  echo _x('De las tareas que le señalamos a continuación, ¿tiene algún tipo de dificultad en llevarlas a cabo a causa de su visión?','Template PostOp Test','iol_theme'); ?> 
        </h3>
        <table>
	        <tbody>
        <!-- 4.1 Pregunta -->
			<tr>
			<th>
        <label ><?php  echo  $postOpUserVarTextTitles['ddriving']; ?></label>
			</th>
			<td>
        <select name="ddriving" id="ddriving">
   			<option value="" <?php selected('',$postOpUserVarText['ddriving']); ?> > </option>
            <option value="ldym" id="ldym" <?php selected('ldym',$postOpUserVarText['ddriving']); ?>  >
                <?php  echo  $postOpUserVarTextTitles['ldym']; ?>
            </option>
            <option value="ldyq" id="ldyq" <?php selected('ldyq',$postOpUserVarText['ddriving']); ?> >
                <?php  echo  $postOpUserVarTextTitles['ldyq']; ?>
            </option>
            <option value="ldys" id="ldys" <?php selected('ldys',$postOpUserVarText['ddriving']); ?> >
                <?php  echo  $postOpUserVarTextTitles['ldys']; ?>
            </option>
            <option value="ldnn" id="ldnn" <?php selected('ldnn',$postOpUserVarText['ddriving']); ?> >
                <?php  echo  $postOpUserVarTextTitles['ldnn']; ?>
            </option>
        </select>
			</td>
			</tr>
        <!-- Fin 4.1 pregunta-->
        
        <!-- 4.2 pregunta -->
        <tr>
		<th>
        <label><?php  echo $postOpUserVarTextTitles['ndriving']; ?></label>
		</th>
		<td>
        <select name="ndriving" id="ndriving">
   			<option value="" <?php selected('',$postOpUserVarText['ndriving']); ?> > </option>
            <option value="ndym" id="ndym" <?php selected('ndym',$postOpUserVarText['ndriving']); ?> >
               <?php  echo $postOpUserVarTextTitles['ndym']; ?>
            </option>
            <option value="ndyq" id="ndyq" <?php selected('ndyq',$postOpUserVarText['ndriving']); ?> >
               <?php  echo $postOpUserVarTextTitles['ndyq']; ?>
            </option>
            <option value="ndys" id="ndys" <?php selected('ndys',$postOpUserVarText['ndriving']); ?> >
               <?php  echo $postOpUserVarTextTitles['ndys']; ?>
            </option>
            <option value="ndnn" id="ndnn" <?php selected('ndnn',$postOpUserVarText['ndriving']); ?> >
               <?php  echo $postOpUserVarTextTitles['ndnn']; ?>
            </option>
        </select>
        </td>
		</tr>
        <!-- Fin 4.2 pregunta-->
        
        <!-- 4.3 Pregunta -->
		<tr>
		<th>
	    <label><?php  echo $postOpUserVarTextTitles['ivision']; ?></label>
		</th>
	    <td>
        <select name="ivision" id="ivision">
   			<option value="" <?php selected('',$postOpUserVarText['ivision']); ?> ></option>
            <option  value="ivym" id="ivym" <?php selected('ivym',$postOpUserVarText['ivision']); ?> >
               <?php  echo $postOpUserVarTextTitles['ivym']; ?>
            </option>
            <option value="ivyq" id="ivyq" <?php selected('ivyq',$postOpUserVarText['ivision']); ?> >
               <?php  echo $postOpUserVarTextTitles['ivyq']; ?>
            </option>
            <option value="ivys" id="ivys" <?php selected('ivys',$postOpUserVarText['ivision']); ?> >
               <?php  echo $postOpUserVarTextTitles['ivys']; ?>
            </option>
            <option value="ivnn" id="ivnn" <?php selected('ivnn',$postOpUserVarText['ivision']); ?> >
               <?php  echo $postOpUserVarTextTitles['ivnn']; ?>
            </option>
        </select>
	    </td>
        </tr>
        <!-- Fin 4.3 pregunta-->
        
        <!-- 4.4 pregunta -->
        <tr>
	    <th>
        <label><?php  echo _x('Leer el periódico, revistas:','Template PostOp Test','iol_theme'); ?></label>
	    </th>
	    <td>
        <select name="newspaper" id="newspaper">
   			<option value="" <?php selected('',$postOpUserVarText['newspaper']); ?> ></option>
            <option value="newym" id="newym" <?php selected('newym',$postOpUserVarText['newspaper']); ?> >
               <?php  echo $postOpUserVarTextTitles['newym']; ?>
            </option>
            <option value="newyq" id="newyq" <?php selected('newyq',$postOpUserVarText['newspaper']); ?> >
               <?php  echo $postOpUserVarTextTitles['newyq']; ?>
            </option>
            <option value="newys" id="newys" <?php selected('newys',$postOpUserVarText['newspaper']); ?> >
               <?php  echo $postOpUserVarTextTitles['newys']; ?>
            </option>
            <option value="newnn" id="newnn" <?php selected('newnn',$postOpUserVarText['newspaper']); ?> >
               <?php  echo $postOpUserVarTextTitles['newnn']; ?>
            </option>
        </select>
	    </td>
        </tr>
        <!-- Fin 4.4 pregunta-->

        <!-- 4.5 pregunta -->
        <tr>
	        <th>
            <label><?php  echo $postOpUserVarTextTitles['prices']; ?></label>
	        </th>
	        <td>
            <select name="prices" id="prices">
       			<option value="" <?php selected('',$postOpUserVarText['prices']); ?> ></option>
                <option value="pricesym" id="pricesym" <?php selected('pricesym',$postOpUserVarText['prices']); ?> >
                    <?php  echo $postOpUserVarTextTitles['pricesym']; ?>
                </option>
                <option value="pricesyq" id="pricesyq" <?php selected('pricesyq',$postOpUserVarText['prices']); ?> >
                    <?php  echo $postOpUserVarTextTitles['pricesyq']; ?>
                </option>
                <option value="pricesys" id="pricesys" <?php selected('pricesys',$postOpUserVarText['prices']); ?> >
                    <?php  echo $postOpUserVarTextTitles['pricesys']; ?>
                </option>
                <option value="pricesnn" id="pricesnn" <?php selected('pricesnn',$postOpUserVarText['prices']); ?> >
                    <?php  echo $postOpUserVarTextTitles['pricesnn']; ?>
                </option>
        </select>
        </td>
        </tr>
        <!-- Fin 4.5 pregunta-->
        
        <!-- 4.6 pregunta -->
        <tr>
	     <th>
        <label><?php  echo $postOpUserVarTextTitles['needle']; ?></label>
	     </th>
	     <td>
        <select name="needle" id="needle">
   			<option value="" <?php selected('',$postOpUserVarText['needle']); ?> ></option>
            <option value="needleym" id="needleym" <?php selected('needleym',$postOpUserVarText['needle']); ?> >
                    <?php  echo $postOpUserVarTextTitles['needleym']; ?>
            </option>
            <option value="needleyq" id="needleyq" <?php selected('needleyq',$postOpUserVarText['needle']); ?> >
                    <?php  echo $postOpUserVarTextTitles['needleyq']; ?>
            </option>
            <option value="needleys" id="needleys" <?php selected('needleys',$postOpUserVarText['needle']); ?> >
                    <?php  echo $postOpUserVarTextTitles['needleys']; ?>
            </option>
            <option value="needlenn" id="needlenn" <?php selected('needlenn',$postOpUserVarText['needle']); ?> >
                    <?php  echo $postOpUserVarTextTitles['needlenn']; ?>
            </option>
        </select>
        </td>
        </tr>
    
    
    
    
    
    
        <!-- Fin 4.6 pregunta-->
    </tbody>
    </table>
    
    
    </div>
    
    


<!-- 4 Fin-->

<!-- 5 Ini -->

<div id="usogafas">
<h3><?php echo $textTitleBloqs['usogafas']; ?></h3>
<table>
	<tbody>
<tr>
	<th>
    <label><?php  echo $postOpUserVarTextTitles['dglasses']; ?></label>
	</th>
	<td>
    <select name="dglasses" id="dglasses">
		<option value="" <?php selected('',$postOpUserVarText['dglasses']); ?> > </option>
        <option value="dga" id="dga" <?php selected('dga',$postOpUserVarText['dglasses']); ?> >
                            <?php  echo $postOpUserVarTextTitles['dga']; ?>
        </option>
        <option value="dgs" id="dgs"  <?php selected('dgs',$postOpUserVarText['dglasses']); ?> >
                            <?php  echo $postOpUserVarTextTitles['dgs']; ?>
        </option>
        <option value="dgn" id="dgn"  <?php selected('dgn',$postOpUserVarText['dglasses']); ?> >
                            <?php  echo $postOpUserVarTextTitles['dgn']; ?>
        </option>
    </select>
	</td>
</tr>
<!-- 5 Fin -->

<!-- 6 Ini -->
<tr>
	<th>
    <label><?php  echo $postOpUserVarTextTitles['nglasses']; ?> </label>
	</th>
	<td>
    <select name="nglasses" id="nglasses">
		<option value="" <?php selected('',$postOpUserVarText['nglasses']); ?> > </option>
        <option value="nga" id="nga"  <?php selected('nga',$postOpUserVarText['nglasses']); ?> >
        <?php  echo $postOpUserVarTextTitles['nga']; ?>
        </option>
        <option value="ngs" id="ngs" <?php selected('ngs',$postOpUserVarText['nglasses']); ?> >
        <?php  echo $postOpUserVarTextTitles['ngs']; ?>
        </option>
        <option value="ngn" id="ngn" <?php selected('ngn',$postOpUserVarText['nglasses']); ?> >
        <?php  echo $postOpUserVarTextTitles['ngn']; ?>
        </option>
    </select>
	</td>
</tr>
<!-- 6 Fin -->
</tbody>
</table>

</div>



<div id="satisresoperacion">
	
	<h3><?php echo $textTitleBloqs['resulsatis']; ?></h3>
<!-- 7 Ini -->
<table>
	<tbody>
<tr>
<th>
    <label><?php  echo $postOpUserVarTextTitles['dglasses']; ?> </label>
</th>
<td>
    <select name="currentvision" id="currentvision">
		<option value="" <?php selected('',$postOpUserVarText['currentvision']); ?> > </option>
        <option value="cvym" id="cvym" <?php selected('cvym',$postOpUserVarText['currentvision']); ?> >
			<?php  echo $postOpUserVarTextTitles['cvym']; ?>
        </option>
        <option value="cvyq" id="cvyq" <?php selected('cvyq',$postOpUserVarText['currentvision']); ?> >
         	<?php  echo $postOpUserVarTextTitles['cvyq']; ?>
        </option>
        <option value="cvys" id="cvys" <?php selected('cvys',$postOpUserVarText['currentvision']); ?> >
			<?php  echo $postOpUserVarTextTitles['cvys']; ?>
        </option>
        <option value="cvnn" id="cvnn" <?php selected('cvnn',$postOpUserVarText['currentvision']); ?> >	
			<?php  echo $postOpUserVarTextTitles['cvnn']; ?>
        </option>
    </select>
</td>
</tr>
<!-- 7 Fin-->


<!-- 8 Ini -->
<tr>
    <th>
    <label><?php  echo $postOpUserVarTextTitles['satiol']; ?> </label>
    </th>
    <td>
    <select id="satiol" name="satiol">
		<option value="" <?php selected('',$postOpUserVarText['satiol']); ?> ></option>
        <option value="satym" id="satym" <?php selected('satym',$postOpUserVarText['satiol']); ?> >
        <?php  echo $postOpUserVarTextTitles['satym']; ?> 
        </option>
        <option value="satyq" id="satyq" <?php selected('satyq',$postOpUserVarText['satiol']); ?> >
        <?php  echo $postOpUserVarTextTitles['satyq']; ?> 
        </option>
        <option value="satys" id="satys" <?php selected('satys',$postOpUserVarText['satiol']); ?> >
        <?php  echo $postOpUserVarTextTitles['satys']; ?> 
        </option>
        <option value="satn" id="satn" <?php selected('satn',$postOpUserVarText['satiol']); ?> >
        <?php  echo $postOpUserVarTextTitles['satn']; ?> 
        </option>
        <option value="satnn" id="satnn" <?php selected('satnn',$postOpUserVarText['satiol']); ?> >
        <?php  echo $postOpUserVarTextTitles['satnn']; ?> 
        </option>
    </select>
    </td>
</tr>
</tbody>
</table>

<!-- Fin 8 -->

</div>


<!-- Vamos a añadir ahora 3 inputs en texto libre -->
    <br />
    <p><em><?php  echo _x('En nombre de todas las personas con presbicia o cataratas le agradecemos su colaboración.','Template PostOp Test','iol_theme'); ?></em></p>


<div id="addinfo">
	<h3><?php echo $textTitleBloqs['infoadic']; ?></h3>
        <table>
	        <tbody>    
    <tr>
    <th>
    <label><?php echo $postOpUserVarTextTitles['age']; ?></label>
    </th>
    <td>
    <input type="text" id="age" minlength="2" name="age" value="<?php echo $postOpUserVarText['age']; ?>">
    </td>
    </tr>
    
    
    <tr>
    <th>
	    <label><?php echo $postOpUserVarTextTitles['provincia']; ?>
    </th>
	<td>
    	<input type="text" id="provincia" name="provincia" value="<?php echo $postOpUserVarText['provincia']; ?>" />
				
	</td>
    </tr>
    
    <tr>
	 <th>
    <label>
		    <?php echo $postOpUserVarTextTitles['clinic']; ?>
	 </th>
	 <td>
	 <input type="text" id="clinic" name="clinic" value="<?php echo $postOpUserVarText['clinic']; ?>"/>
	 			
	
	 </td>
    </tr>
    
    <tr>
    <th>
    <label>
    	    <?php echo $postOpUserVarTextTitles['comments']; ?>
    	</label>
    </th>
    <td>
	    <textarea id="comments" name="comments" ><?php echo $postOpUserVarText['comments']; ?>
	    </textarea>
    </td>
    </tr>
</tbody>
</table>
    
</div>

<!-- Fin de los 3 inputs libres-->


<input id="allpostok" type="submit" name="allpostok" value="<?php echo _x('He revisado mi información. Está OK. Este ha sido el resultado de mi operación. Espero le sirva a alguien.', 'Template CustomTest Iol','iol_theme'); ?>" />


<div id="submitPostOpButton" class="postopvision">
	<input type="submit" value="<?php  echo _x('Guardar','Template PostOp Test','iol_theme'); ?>" />
		
</div>

</form>
<!-- FIN DEL FORMUALRIO POST-OPERATORIO -->




		</div><!-- #content -->
	</div><!-- #primary -->

 
 <div id="right" class="rightSurgeryPostOp">
 <!-- 	<div id="bloq-post-right1">
        <h3><?php echo _x('VER ESTADÍSTICAS DE RESULTADOS:','Template PostOp Test','iol_theme'); ?></h3>
        <a href="<?php echo get_permalink( 2881 ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/comun/post-results-<?php echo get_locale(); ?>.png" alt="<?php echo _x('Estadísticas de los resultados del test post-operatorio','alt template post op','iol_theme'); ?>" /></a>
    </div>
    -->
    <div id="bloq-post-right2">
    	<h3><?php echo _x('CONTACTE CON NOSOTROS:','Template PostOp Test','iol_theme'); ?></h3>
        <div id="contact-post">
        <?php if (function_exists('serveCustomContactForm')) { serveCustomContactForm(5); } ?>
        </div>
    </div>
    <div id="bloq-post-right3">
    	<a href="<?php echo get_permalink(227); ?>"><img src= "<?php echo get_stylesheet_directory_uri(); ?>/images/comun/test_iol-<?php echo get_locale(); ?>.jpg" alt="<?php echo _x('Realice el test para averiguar qué lente intraocular es más adecuada para usted.','alt template post op','iol_theme'); ?>" /></a>
        <a href="<?php echo get_bloginfo('url')._x('preguntas-de-lentes-intraoculares-presbicia-y-cataratas','qa-slug','iol_theme'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/comun/ad-qa-<?php echo get_locale(); ?>.jpg" alt="<?php echo _x('Pregunte sus dudas al cirujano refractivo','alt template post op','iol_theme'); ?>" /></a>
    </div>
 </div>

<script>
	jQuery('#basic,#results,#usogafas,#satisresoperacion, #addinfo').accordion({
      collapsible: true,
      //event: "click hoverintent",
      active : 0
    });
	jQuery('#addinfo').accordion({
      collapsible: true,
      //event: "click hoverintent",
      active : 'none'
    });
    
 </script>

    <?php
	    $chequeoPost = get_user_meta( $cuser_ID ,'allpostok' , true);// ? get_user_meta( $cuser_ID ,'allok' , true): FALSE ;
	    
	    //echo 'El chequeo es: '.$chequeo;
	    
	    if($chequeoPost == 'ok'){
		    ?>
		    
		    <script>
			    jQuery('form input, form textarea, form select').attr('disabled',true);
			    jQuery('form input, form textarea, form select').prop('readonly',true);
		    </script>
		    
		    <?php
			    
	    }
	    
    ?>





<!-- Añadimos el Yarpp Con wrapper para identificarlo luego -->
<div class="postOpYarpp">
    <?php
        //Añadimos el full Yarpp Bottom.
      //  include('nc-yarpp-full-bottom.php');

    ?>
</div>

<!-- Añadimos el div de clearizacion -->

<div style="clear:both; height:0px; display:none;">&nbsp;</div> 
 
<?php get_footer(); ?>