<?php
/*
 * Template Name: Template Post-Op Test
 * Description: Este es el template para las páginas de mis ojos.
*/


get_header(); ?>

	<div id="primary" class="site-content post-op-test-content">
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
<form id="post-op-form" method="post" action="<?php echo  get_permalink( 2887 ) ;  ?>">

<!-- A esta página se podrá acceder también desde otros lugares 



-->
	<!-- 1 Ini -->
	<div class="bloq b1bloq startsUgly">
    
		<div class="post-img">1.</div>
		<label class="bl b1bl"><?php  echo _x('¿Hace cuánto se operó de cataratas o de presbicia con lente intraocular?','Template PostOp Test','iol_theme'); ?></label>
		<div id="surgeryTime">
			<input type="radio"  name="surgeryTime" value="less3" id="less3" >
				<label for="less3"><?php  echo _x('Menos de 3 meses','Template PostOp Test','iol_theme'); ?></label>
			</input>
			<input type="radio" name="surgeryTime" value="bet36"  id="bet36">
				<label for="bet36"><?php  echo _x('Entre 3 y 6 meses','Template PostOp Test','iol_theme'); ?></label>
			</input>
			<input type="radio" name="surgeryTime" value="more6"  id="more6">
				<label for="more6"><?php  echo _x('Más de 6 meses','Template PostOp Test','iol_theme'); ?></label>
			</input>
		</div>
</div>
<!-- 1 Fin -->

<!-- 2 Ini -->
	<div class="bloq b2bloq startsUgly">
    	<div class="post-img">2.</div>
		<label class="bl b2bl"><?php  echo _x('Se operó...','Template PostOp Test','iol_theme'); ?></label>
		<div id="surgeryEye">
			<input type="radio" name="surgeryEye" value="oe" id="oe">
				<label for="oe"><?php  echo _x('Un ojo','Template PostOp Test ','iol_theme'); ?></label>
			</input>
			<input type="radio" name="surgeryEye" value="be" id="be">
				<label for="be"><?php  echo _x('Los dos ojos','Template PostOp Test','iol_theme'); ?></label>
			</input>
		</div>
	</div>
<!-- 2 Fin -->

<!-- 3 Ini -->
	<div class="bloq b3bloq startsUgly">
    	<div class="post-img">3.</div>
		<label class="bl b3bl"><?php  echo _x('¿Qué tipo de Lente Intraocular (LIO) se le implantó?','Template PostOp Test','iol_theme'); ?></label>
		<div id="surgeryIol">
			<input type="radio" name="surgeryIol" value="me" id="me" >
				<label for="me"><?php  echo _x('Una LIO Monofocal Esférica','Template PostOp Test','iol_theme'); ?></label>
			</input>
			<input type="radio" name="surgeryIol" value="ma" id="ma">
				<label for="ma"><?php  echo _x('Una LIO Monofocal Asférica','Template PostOp Test','iol_theme'); ?></label>
			</input>
			<input type="radio" name="surgeryIol" value="mt" id="mt">
				<label for="mt"><?php  echo _x('Una LIO Monofocal Tórica','Template PostOp Test','iol_theme'); ?></label>
			</input>
			<input type="radio" name="surgeryIol" value="mu" id="mu">
				<label for="mu"><?php  echo _x('Una LIO Multifocal','Template PostOp Test','iol_theme'); ?></label>
			</input>
			<input type="radio" name="surgeryIol" value="mut" id="mut">
				<label for="mut"><?php  echo _x('Una LIO Multifocal Tórica','Template PostOp Test','iol_theme'); ?></label>
			</input>
			<input type="radio" name="surgeryIol" value="aco" id="aco">
				<label for="aco"><?php  echo _x('Una LIO Acomodativa','Template PostOp Test','iol_theme'); ?></label>
			</input>
			<input type="radio" name="surgeryIol" value="add" id="add">
				<label for="add"><?php  echo _x('Una LIO Add-On','Template PostOp Test','iol_theme'); ?></label>
			</input>
			<input type="radio" name="surgeryIol" value="icl" id="iclTest">
				<label for="iclTest"><?php  echo _x('Una LIO ICL','Template PostOp Test','iol_theme'); ?></label>
			</input>
			<input type="radio" name="surgeryIol" value="oth" id="oth">
				<label for="oth"><?php  echo _x('Otro tipo','Template PostOp Test','iol_theme'); ?></label>
			</input>
			<input type="radio" name="surgeryIol" value="dk" id="dk">
				<label for="dk"><?php  echo _x('No lo sé','Template PostOp Test','iol_theme'); ?></label>
			</input>
		</div>
	</div>
<!-- 3 Fin -->

<!-- 4 Ini -->

<div class="bloq">
		<div class="post-img">4.</div>
        <div class="t4bEntry"><?php  echo _x('De las tareas que le señalamos a continuación, ¿tiene algún tipo de dificultad en llevarlas a cabo a causa de su visión?','Template PostOp Test','iol_theme'); ?> 
        </div>
        <!-- 4.1 Pregunta -->
        <div class="b41bloq b4bloq  startsUgly">
        <label class="b41bl b4bl"><?php  echo _x('Conducir de día (Visión de lejos con buena iluminación)','Template PostOp Test','iol_theme'); ?></label>
        <div id="dDriving">
            <input type="radio" name="dDriving" value="ldym" id="ldym">
                <label for="ldym"><?php  echo _x('Sí, muchísima','Template PostOp Test','iol_theme'); ?></label>
            </input>
            <input type="radio" name="dDriving" value="ldyq" id="ldyq">
                <label for="ldyq"><?php  echo _x('Sí, bastante','Template PostOp Test','iol_theme'); ?></label>
            </input>
            <input type="radio" name="dDriving" value="ldys" id="ldys">
                <label for="ldys"><?php  echo _x('Sí, alguna','Template PostOp Test','iol_theme'); ?></label>
            </input>
            <input type="radio" name="dDriving" value="ldnn" id="ldnn">
                <label for="ldnn"><?php  echo _x('No, ninguna','Template PostOp Test','iol_theme'); ?></label>
            </input>
        </div>
        </div>
        <!-- Fin 4.1 pregunta-->
        
        <!-- 4.2 pregunta -->
        <div class="b42bloq b4bloq startsUgly">
        <label class="b42bl b4bl"><?php  echo _x('Conducir de noche (Visión de lejos con poca iluminación)','Template PostOp Test','iol_theme'); ?></label>
        <div id="nDriving">
            <input type="radio" name="nDriving" value="ndym" id="ndym">
                <label for="ndym"><?php  echo _x('Sí, muchísima','Template PostOp Test','iol_theme'); ?></label>
            </input>
            <input type="radio" name="nDriving" value="ndyq" id="ndyq">
                <label for="ndyq"><?php  echo _x('Sí, bastante','Template PostOp Test','iol_theme'); ?></label>
            </input>
            <input type="radio" name="nDriving" value="ndys" id="ndys">
                <label for="ndys"><?php  echo _x('Sí, alguna','Template PostOp Test','iol_theme'); ?></label>
            </input>
            <input type="radio" name="nDriving" value="ndnn" id="ndnn">
                <label for="ndnn"><?php  echo _x('No, ninguna','Template PostOp Test','iol_theme'); ?></label>
            </input>
        </div>
        </div>
        <!-- Fin 4.2 pregunta-->
        
        <!-- 4.3 Pregunta -->
        <div class="b43bloq b4bloq startsUgly">
        <label class="b43bl b4bl"><?php  echo _x('Trabajar con el ordenador, usar el teléfono, ver el GPS de su coche... (uso de visión intermedia) ','Template PostOp Test','iol_theme'); ?></label>
        <div id="iVision">
            <input type="radio" name="iVision" value="ivym" id="ivym">
                <label for="ivym"><?php  echo _x('Sí, muchísima','Template PostOp Test','iol_theme'); ?></label>
            </input>
            <input type="radio" name="iVision" value="ivyq" id="ivyq">
                <label for="ivyq"><?php  echo _x('Sí, bastante','Template PostOp Test','iol_theme'); ?></label>
            </input>
            <input type="radio" name="iVision" value="ivys" id="ivys">
                <label for="ivys"><?php  echo _x('Sí, alguna','Template PostOp Test','iol_theme'); ?></label>
            </input>
            <input type="radio" name="iVision" value="ivnn" id="ivnn">
                <label for="ivnn"><?php  echo _x('No, ninguna','Template PostOp Test','iol_theme'); ?></label
            ></input>
        </div>
        </div>
        <!-- Fin 4.3 pregunta-->
        
        <!-- 4.4 pregunta -->
        <div class="b44bloq b4bloq startsUgly">
        <label class="b44bl b4bl"><?php  echo _x('Leer el periódico, revistas:','Template PostOp Test','iol_theme'); ?></label>
        <div id="newspaper">
            <input type="radio" name="newspaper" value="newym" id="newym">
                <label for="newym"><?php  echo _x('Sí, muchísima','Template PostOp Test','iol_theme'); ?></label>
            </input>
            <input type="radio" name="newspaper" value="newyq" id="newyq">
                <label for="newyq"><?php  echo _x('Sí, bastante','Template PostOp Test','iol_theme'); ?></label>
            </input>
            <input type="radio" name="newspaper" value="newys" id="newys">
                <label for="newys"><?php  echo _x('Sí, alguna','Template PostOp Test','iol_theme'); ?></label>
            </input>
            <input type="radio" name="newspaper" value="newnn" id="newnn">
                <label for="newnn"><?php  echo _x('No, ninguna','Template PostOp Test','iol_theme'); ?></label>
            </input>
        </div>
        </div>
        <!-- Fin 4.4 pregunta-->

        <!-- 4.5 pregunta -->
        <div class="b45bloq b4bloq startsUgly">
            <label class="b45bl b4bl "><?php  echo _x('Ver los precios de los productos en el ticket cuando está de compras:','Template PostOp Test','iol_theme'); ?></label>
            <div id="prices">
                <input type="radio" name="prices" value="pricesym" id="pricesym">
                    <label for="pricesym"><?php  echo _x('Sí, muchísima','Template PostOp Test','iol_theme'); ?></label>
                </input>
                <input type="radio" name="prices" value="pricesyq" id="pricesyq">
                    <label for="pricesyq"><?php  echo _x('Sí, bastante','Template PostOp Test','iol_theme'); ?></label>
                </input>
                <input type="radio" name="prices" value="pricesys" id="pricesys">
                    <label for="pricesys"><?php  echo _x('Sí, alguna','Template PostOp Test','iol_theme'); ?></label>
                </input>
                <input type="radio" name="prices" value="pricesnn" id="pricesnn">
                    <label for="pricesnn"><?php  echo _x('No, ninguna','Template PostOp Test','iol_theme'); ?></label>
                </input>
        </div>
        </div>
        <!-- Fin 4.5 pregunta-->
        
        <!-- 4.6 pregunta -->
        <div class="b46bloq b4bloq startsUgly">
        <label class="b46bl b4bl"><?php  echo _x('Ver al enhebrar la aguja o al realizar trabajos manuales de similar precisión:','Template PostOp Test','iol_theme'); ?></label>
        <div id="needle">
            <input type="radio" name="needle" value="needleym" id="needleym">
                <label for="needleym"><?php  echo _x('Sí, muchísima','Template PostOp Test','iol_theme'); ?></label>
            </input>
            <input type="radio" name="needle" value="needleyq" id="needleyq">
                <label for="needleyq"><?php  echo _x('Sí, bastante','Template PostOp Test','iol_theme'); ?></label>
            </input>
            <input type="radio" name="needle" value="needleys" id="needleys">
                <label for="needleys"><?php  echo _x('Sí, alguna','Template PostOp Test','iol_theme'); ?></label>
            </input>
            <input type="radio" name="needle" value="needlenn" id="needlenn">
                <label for="needlenn"><?php  echo _x('No, ninguna','Template PostOp Test','iol_theme'); ?></label>
            </input>
        </div>
        </div>
        <!-- Fin 4.6 pregunta-->
    </div>

<!-- 4 Fin-->

<!-- 5 Ini -->
<div class="bloq b5bloq startsUgly">
	<div class="post-img">5.</div>
    <label class="bl b5bl"><?php  echo _x('¿Con qué frecuencia usa gafas para ver de lejos?','Template PostOp Test','iol_theme'); ?></label>
    <div id="dGlasses">
        <input type="radio" name="dGlasses" value="dga" id="dga" >
            <label for="dga"><?php  echo _x('Siempre','Template PostOp Test','iol_theme'); ?></label>
        </input>
        <input type="radio" name="dGlasses" value="dgs" id="dgs">
            <label for="dgs"><?php  echo _x('En ocasiones','Template PostOp Test','iol_theme'); ?></label>
        </input>
        <input type="radio" name="dGlasses" value="dgn" id="dgn">
            <label for="dgn"><?php  echo _x('Nunca','Template PostOp Test','iol_theme'); ?></label>
        </input>
    </div>
</div>
<!-- 5 Fin -->

<!-- 6 Ini -->
<div class="bloq b6bloq startsUgly">
    <div class="post-img">6.</div>
    <label class="bl b6bl"><?php  echo _x('¿Con qué frecuencia usa gafas para leer?','Template PostOp Test','iol_theme'); ?></label>
    <div id="nGlasses">
        <input type="radio" name="nGlasses" value="nga" id="nga">
            <label for="nga"><?php  echo _x('Siempre','Template PostOp Test','iol_theme'); ?></label>
        </input>
        <input type="radio" name="nGlasses" value="ngs" id="ngs">
            <label for="ngs"><?php  echo _x('En ocasiones','Template PostOp Test','iol_theme'); ?></label>
        </input>
        <input type="radio" name="nGlasses" value="ngn" id="ngn">
            <label for="ngn"><?php  echo _x('Nunca','Template PostOp Test','iol_theme'); ?></label>
        </input>
    </div>
</div>
<!-- 6 Fin -->

<!-- 7 Ini -->
<div class="bloq b7bloq startsUgly">
    <div class="post-img">7.</div>
    <label class="bl b7bl"><?php  echo _x('¿Tiene la sensación de que su visión actual le genera dificultades, en cualquier sentido, para llevar a cabo su estilo de vida?','Template PostOp Test','iol_theme'); ?></label>
        <div id="currentVision">
        <input type="radio" name="currentVision" value="cvym" id="cvym">
            <label for="cvym"><?php  echo _x('Sí, muchísima','Template PostOp Test','iol_theme'); ?></label>
        </input>
        <input type="radio" name="currentVision" value="cvyq" id="cvyq">
            <label for="cvyq"><?php  echo _x('Sí, bastante','Template PostOp Test','iol_theme'); ?></label>
        </input>
        <input type="radio" name="currentVision" value="cvys" id="cvys">
            <label for="cvys"><?php  echo _x('Sí, alguna','Template PostOp Test','iol_theme'); ?></label>
        </input>
        <input type="radio" name="currentVision" value="cvnn" id="cvnn">
            <label for="cvnn"><?php  echo _x('No, ninguna','Template PostOp Test','iol_theme'); ?></label>
        </input>
    </div>
</div>
<!-- 7 Fin-->


<!-- 8 Ini -->
<div class="bloq b8bloq startsUgly">
    <div class="post-img">8.</div>
    <label class="bl b8bl"><?php  echo _x('¿Esta usted satisfecho con su visión actual, tras habérsele implantado una lente intraocular?','Template PostOp Test','iol_theme'); ?></label>
    <div id="satIol">
        <input type="radio" name="satIol" value="satym" id="satym">
            <label for="satym"><?php  echo _x('Sí, muy satisfecho','Template PostOp Test','iol_theme'); ?></label>
        </input>
        <input type="radio" name="satIol" value="satyq" id="satyq">
            <label for="satyq"><?php  echo _x('Sí, bastante satisfecho','Template PostOp Test','iol_theme'); ?></label>
        </input>
        <input type="radio" name="satIol" value="satys" id="satys">
            <label for="satys"><?php  echo _x('Sí, satisfecho','Template PostOp Test','iol_theme'); ?></label>
        </input>
        <input type="radio" name="satIol" value="satn" id="satn">
            <label for="satn"><?php  echo _x('No','Template PostOp Test','iol_theme'); ?></label>
        </input>
        <input type="radio" name="satIol" value="satnn" id="satnn">
            <label for="satnn"><?php  echo _x('No, nada satisfecho','Template PostOp Test','iol_theme'); ?></label>
        </input>
    </div>
</div>
<!-- Fin 8 -->

<!-- Vamos a añadir ahora 3 inputs en texto libre -->
    <br />
    <p><?php  echo _x('El test que se le ha presentado es completamente anónimo, y las siguientes preguntas son recogidas únicamente para poder analizar la credibilidad del testimonio (no serán almacenadas ni procesadas con posterioridad para otro fin).','Template PostOp Test','iol_theme'); ?></p>
    <p><em><?php  echo _x('En nombre de todas las personas con presbicia o cataratas le agradecemos su colaboración.','Template PostOp Test','iol_theme'); ?></em></p>


<div id="post-check">
            
    <div class="aditQuestion">
    <label><?php  echo _x('¿Qué edad tiene?','Template PostOp Test','iol_theme'); ?></label>
    <input type="text" id="age" minlength="2" name="age" required />
    </div>
    
    <div class="aditQuestion">
    <label><?php  echo _x('¿Cuál es su nombre? (No rellene el apellido)','Template PostOp Test','iol_theme'); ?></label>
    <input type="text" id="uName" name="uName" required/>
    </div>
    
    <div class="aditQuestion">
    <label><?php  echo _x('¿De qué provincia es usted?','Template PostOp Test','iol_theme'); ?></label>
    <input type="text" id="provincia" name="provincia" required />
    </div>
    
    <div class="aditQuestion">
    <label><?php  echo _x('¿En qué clinica se ha operado?','Template PostOp Test','iol_theme'); ?></label>
    <input type="text" id="clinic" name="clinic" required />
    </div>
    
    <div class="aditQuestion">
    <label><?php  echo _x('Rellene cualquier comentario u observación','Template PostOp Test','iol_theme'); ?></label>
    <textarea id="comments" name="comments" required ></textarea>
    </div>
    
    <div class="aditQuestion">
    <label><?php  echo _x('Escriba una dirección de email válida','Template PostOp Test','iol_theme'); ?></label>
    <input type="email" id="email" name="email" required />
    </div>
    
</div>

<!-- Fin de los 3 inputs libres-->

</form>
<!-- FIN DEL FORMUALRIO POST-OPERATORIO -->

<div id="submitPostOpButton">
	<button type="submit" onclick="enviarPostOpTest();">
		<?php  echo _x('Enviar','Template PostOp Test','iol_theme'); ?>
	</button>
</div>


		</div><!-- #content -->
	</div><!-- #primary -->

<!-- Ponemos un div auxiliar para identificar -->
<div style="display:none;height:0px;" id="templatePostOp"> &nbsp;</div>

<?php /*get_sidebar();*/
	
	//echo '<div id="right" class="rightSurgeryPostOp">'; 
	      //aquí vamos a mostrar los resultados 
	//echo '<a href="';
	//echo esc_url( get_permalink( get_page_by_title( 'Resultados de la operación de Cataratas y Presbicia con lente intraocular' ) ) );
	//echo '">Aquí vamos a mostrar un link </a>';
	//echo  '</div>';

 ?>
 
 <div id="right" class="rightSurgeryPostOp">
 	<div id="bloq-post-right1">
        <h3><?php echo _x('VER ESTADÍSTICAS DE RESULTADOS:','Template PostOp Test','iol_theme'); ?></h3>
        <a href="<?php echo get_permalink( 2881 ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/comun/post-results-<?php echo get_locale(); ?>.png" alt="<?php echo _x('Estadísticas de los resultados del test post-operatorio','alt template post op','iol_theme'); ?>" /></a>
    </div>
    
<?php    if($rgdp = false){ ?>
    <div id="bloq-post-right2">
    	<h3><?php echo _x('CONTACTE CON NOSOTROS:','Template PostOp Test','iol_theme'); ?></h3>
        <div id="contact-post">
        <?php if (function_exists('serveCustomContactForm')) { serveCustomContactForm(5); } ?>
        </div>
    </div>
    <?php } ?>
    
    
    <div id="bloq-post-right3">
    	<a href="<?php echo get_permalink(227); ?>"><img src= "<?php echo get_stylesheet_directory_uri(); ?>/images/comun/test_iol-<?php echo get_locale(); ?>.jpg" alt="<?php echo _x('Realice el test para averiguar qué lente intraocular es más adecuada para usted.','alt template post op','iol_theme'); ?>" /></a>
        <a href="<?php echo get_bloginfo('url')._x('preguntas-de-lentes-intraoculares-presbicia-y-cataratas','qa-slug','iol_theme'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/comun/ad-qa-<?php echo get_locale(); ?>.jpg" alt="<?php echo _x('Pregunte sus dudas al cirujano refractivo','alt template post op','iol_theme'); ?>" /></a>
    </div>
 </div>

<!-- Añadimos el Yarpp Con wrapper para identificarlo luego -->
<div class="postOpYarpp">
    <?php
        //Añadimos el full Yarpp Bottom.
        include('nc-yarpp-full-bottom.php');

    ?>
</div>

<!-- Añadimos el div de clearizacion -->

<div style="clear:both; height:0px; display:none;">&nbsp;</div> 
 
<?php get_footer(); ?>