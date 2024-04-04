<?php
/*
 * Template Name: Template PostOp Test Result
 * Description: Este es el template para las páginas de mis ojos.
*/


get_header(); ?>



	<div id="primary" class="postOpTestResults" >


<div id="resultPosOpTitle">

<?php 
	
		echo '<h1>';
		the_title();
		echo'</h1>';//'Mensaje de agradecimiento por haber rellenado el formulario';

	
	
	// en esta página vamos a mostrar los resultados de los test.
	if(isset($_GET['fromPost'])){
		//vamos a llevar a cabo el proceso del Post.
		
		//iolSurgeryForm($_POST);
			
		}else{
		echo '<h1>';
		//the_title();
		echo'</h1>';//'Mensaje de agradecimiento por haber rellenado el formulario';
		}
		
	/*	if (isset($_COOKIE['conteo'])) {
    $conteo = $_COOKIE['conteo'] + 1;
} else {
    $conteo = 1;
}*/

?>
</div>
	
	
	
		<div id="content" class="site-content-testResult" role="main">


   			<?php while ( have_posts() ) : the_post(); ?>				
				<?php the_content();?>



   
   
   <?php 
   
   $count = 1;
   
   $arrayIds = array('satIol','dDriving','nDriving','iVision','newspaper','prices','needle','dGlasses','nGlasses', 'currentVision');
   $arrayLabelTexts =  array(
   						_x('Nivel de Satisfacción de los pacientes operados en función del tipo de lente intraocular seleccionado','Template PostOp Test Result','iol_theme'),
   						_x('Dificultad para conducir de día (sin gafas)','Template PostOp Test Result','iol_theme'),
   						_x('Dificultad para conducir de noche (sin gafas)','Template PostOp Test Result','iol_theme'),
   						_x('Dificultad para trabajar con el ordenador, usar el teléfono, ver el GPS del coche...(visión intermedia sin gafas)','Template PostOp Test Result','iol_theme'),
   						_x('Dificultad para leer el periódico','Template PostOp Test Result','iol_theme'),
   						_x('Dificultad para leer los precios de los productos en el ticket cuando está de compras','Template PostOp Test Result','iol_theme'),
   						_x('Dificultad al enhebrar la aguja o realizar trabajos de similar precisión','Template PostOp Test Result','iol_theme'),
   						_x('Frecuencia con la que usa gafas para ver de lejos','Template PostOp Test Result','iol_theme'),
   						_x('Frecuencia con la que usa gafas para leer','Template PostOp Test Result','iol_theme'),
   						_x('Dificultades con las que se encuentra el paciente para llevar a cabo su estilo de vida','Template PostOp Test Result','iol_theme')
   					);  
   
   
   
      //<!-- Inicio Tab Estandar -->
      
      $pathToTheme = get_theme_root_uri().'/iol/';
      
      foreach($arrayIds as $id){

     echo '
     <div class="tabLabel"><span style="display:block; margin-right: 5px; float:left;"><img src="'.get_stylesheet_directory_uri().'/images/templates/lista.png" /></span>'.$arrayLabelTexts[$count-1].'</div>';
     
     //http://nuevocristalino.es/wp-content/themes/twentytwelve La parte de los resultados sólo la mostramos para la primera respuesta. Luego les decimos que si quieren verlo han de estar logeados.
     if ( is_user_logged_in() || $count == 1 ) {
     
          echo '
     <div class="resultsTest startsUgly">
        <div id="'.$id.'">
            <ul class="startsUgly">
                <li><a href="#tabs'.$count.'-me">'._x("Monofocal Esférica","Template PostOp Test Result","iol_theme").'</a></li>
                <li><a href="#tabs'.$count.'-ma">'._x("Monofocal Asférica.","Template PostOp Test Result","iol_theme").'</a></li>
                <li><a href="#tabs'.$count.'-mt">'._x("Monofocal Tórica.","Template PostOp Test Result","iol_theme").'</a></li>
                <li><a href="#tabs'.$count.'-mu">'._x("Multifocal.","Template PostOp Test Result","iol_theme").'</a></li>
                <li><a href="#tabs'.$count.'-mut">'._x("Multifocal Tórica.","Template PostOp Test Result","iol_theme").'</a></li>
                <li><a href="#tabs'.$count.'-aco">'._x("Acomodativa.","Template PostOp Test Result","iol_theme").'</a></li>
                <li><a href="#tabs'.$count.'-add">'._x("Add On.","Template PostOp Test Result","iol_theme").'</a></li>
                <li><a href="#tabs'.$count.'-icl">'._x("ICL.","Template PostOp Test Result","iol_theme").'</a></li>
                <!-- <li><a href="#tabs-oth">'._x("Otro tipo.","Template PostOp Test Result","iol_theme").'</a></li> -->
 				<!-- <li><a href="#tabs-dk">'._x("No lo sabe.","Template PostOp Test Result","iol_theme").'</a></li> -->
             </ul>
                    <div id="tabs'.$count.'-me" class="panel">
                        <!-- <p>Monofocal Esférica</p> -->
                        <div id="ajaxResult'.$count.'-me" class="grafico" style="width: 550px; height: 300px;"></div>
                        <div id="loading'.$count.'-me" class="tabLoader">
                        <img src="'.$pathToTheme.'/images/newAjaxLoader.gif" title="" alt="" style="display:none;" />
                        </div> 
                    </div>
                    <div id="tabs'.$count.'-ma" class="panel">
                        <!-- <p>Monofocal Asférica</p> -->
                        <div id="ajaxResult'.$count.'-ma"  class="grafico"></div>
                        <div id="loading'.$count.'-ma" class="tabLoader">
                        <img src="'.$pathToTheme.'/images/newAjaxLoader.gif" title="" alt="" style="display:none;" />
                        </div>
                    </div>
                    <div id="tabs'.$count.'-mt" class="panel">
                        <!-- <p>Monofocal Tórica</p> -->
                        <div id="ajaxResult'.$count.'-mt" class="grafico"></div>
                        <div id="loading'.$count.'-mt" class="tabLoader">
                        <img src="'.$pathToTheme.'/images/newAjaxLoader.gif" title="" alt="" style="display:none;" />
                        </div>                        
                    </div>
                    <div id="tabs'.$count.'-mu" class="panel">
                        <!-- <p>Multifocal</p> -->
                        <div id="ajaxResult'.$count.'-mu" class="grafico"  style="width: 550px; height: 300px;"></div>
                        <div id="loading'.$count.'-mu" class="tabLoader">
                        <img src="'.$pathToTheme.'/images/newAjaxLoader.gif" title="" alt="" style="display:none;" />
                        </div>
                    </div>
                    <div id="tabs'.$count.'-mut" class="panel">
                        <!-- <p>Multifocal Tórica</p> -->
                        <div id="ajaxResult'.$count.'-mut"  class="grafico"></div>
                        <div id="loading'.$count.'-mut" class="tabLoader">
                        <img src="'.$pathToTheme.'/images/newAjaxLoader.gif" title="" alt="" style="display:none;" />
                        </div>                        
                    </div>

                    <div id="tabs'.$count.'-aco" class="panel">
                        <!-- <p>Acomodativa</p> -->
                        <div id="ajaxResult'.$count.'-aco"  class="grafico"></div>
                        <div id="loading'.$count.'-aco" class="tabLoader">
                        <img src="'.$pathToTheme.'/images/newAjaxLoader.gif" title="" alt="" style="display:none;" />
                        </div>                        
                    </div>

                    <div id="tabs'.$count.'-add" class="panel">
                        <!-- <p>Add On</p> -->
                        <div id="ajaxResult'.$count.'-add"  class="grafico"></div>
                        <div id="loading'.$count.'-add" class="tabLoader">
                        <img src="'.$pathToTheme.'/images/newAjaxLoader.gif" title="" alt="" style="display:none;" />                  
                        </div>
                    </div>
                    
                    <div id="tabs'.$count.'-icl" class="panel">
                        <!-- <p>ICL</p> -->
                        <div id="ajaxResult'.$count.'-icl"  class="grafico"></div>
                        <div id="loading'.$count.'-icl" class="tabLoader">
                        <img src="'.$pathToTheme.'/images/newAjaxLoader.gif" title="" alt="" style="display:none;" />
                        </div>                        
                    </div>
                    
                    <!-- <div id="tabs-dk">
                        <!-- <p>No lo sabe</p>
                    </div> -->

        </div>
        </div>
   
   <!-- Final Tab Estándar -->';

     }
     else{
         echo '<span class="notLogedIn">'._x("Para ver el resultado a esta pregunta de los pacientes operados ha de hacer","Template PostOp Test Result text","iol_theme").' <a href="'.wp_login_url(get_page_link(get_the_ID())).'">login</a>.</span>';
     }
   $count = $count +1;
   }
   
     
   ?>
   
   
   <!-- Div auxiliar para ejecución de scripts específicos -->
   <div id="templatePostOpTestResult">&nbsp;</div>
   
   
   <script type="text/javascript" src="https://www.google.com/jsapi"></script>

   <script type="text/javascript">
      //IGUAL HAY QUE VOLVERLO A PONER¡¡¡ google.load("visualization", "1", { packages: ["corechart"] , 'callback': function (){resultPostOpTabsLoader();}});
      
      // setTimeout(function(){google.load('visualization', '1', {'callback':'function(){console.log("bla bla");}', 'packages':['corechart']})}, 1000);
      // google.load("visualization", "1", { packages: ["corechart"],"callback" : function(){ resultPostOpTabsLoader();} });
        
       jQuery(document).ready(function(){
       //google.setOnLoadCallback(function () { drawChart(gFormatData); });
       });
       

 
           /*var options = {
               title: 'My Daily Activities'
           };

           var chart = new google.visualization.PieChart(document.getElementById('piechart'));
           chart.draw(data, options);*/

       

    </script>

    <!-- <div id="piechart" style="width: 900px; height: 500px;"></div> -->

		<div id="visualization">&nbsp;</div>
	
		</div><!-- #content -->
	
        <?php 
            //Lista de Páginas.
            $idComoElegirLIO = 227;
            $idModelosLIO    = 412;

        ?>
        
    <div id="right" class="test-result">
        <div class="BlowTestResult">
        	<a href="<?php echo get_permalink($idComoElegirLIO); ?>"><img alt="<?php echo _x('Realice el test para averiguar qué lente intraocular es más adecuada para usted.','alt post test result','iol_theme'); ?>" src="<?php echo get_stylesheet_directory_uri(); ?>/images/comun/test_iol-<?php echo get_locale(); ?>.jpg"></a>
        </div>
        <div class="BlowTestResult">
        	<a href="<?php echo get_permalink($idModelosLIO); ?>"><img alt="<?php echo _x('Busque el modelo de lente intraocular según las características que desee.','alt post test result','iol_theme'); ?>" src="<?php echo get_stylesheet_directory_uri(); ?>/images/comun/link_filter_iol-<?php echo get_locale(); ?>.jpg"></a>
        </div>
        <div class="BlowTestResult">
        	<a href="<?php echo get_site_url().'/'._x('preguntas-de-lentes-intraoculares-presbicia-y-cataratas','qa-slug','iol_theme');?>"><img alt="<?php echo _x('Pregunte sus dudas al cirujano refractivo.','alt post test result','iol_theme'); ?>" src="<?php echo get_stylesheet_directory_uri(); ?>/images/comun/ad-qa-<?php echo get_locale()?>.jpg"></a>
        </div>
        <div class="BlowTestResult">
        	<a href="<?php echo get_bloginfo('url').'/'._x('foro-de-lentes-intraoculares-presbicia-y-cataratas','foro-slug','iol_theme'); ?>"><img alt="<?php echo _x('Comparta su caso en el foro de Nuevo Cristalino.','alt post test result','iol_theme'); ?>" src="<?php echo get_stylesheet_directory_uri(); ?>/images/comun/ad-forum-<?php echo get_locale()?>.jpg"></a>
        </div>
        <div class="BlowTestResult">
        	<a href="<?php echo get_permalink(31); ?>"><img alt="<?php echo _x('Visite el blog de Nuevo Cristalino.','alt post test result','iol_theme');?>" src="<?php echo get_stylesheet_directory_uri(); ?>/images/comun/ad-blog-<?php echo get_locale();?>.jpg"></a>
        </div>
    </div>


    </div><!-- #primary -->

        <!-- Añadimos la opción de que haya comentarios -->
<?php if($rgdp = false){ ?>
        <!-- Ponemos un div auxiliar para identificar -->
        <div style="height:0px;clear: both;" id="templatePostOp"> &nbsp;</div>
        		<div id="postOpTestCommentsWrapper">
        		<div class="titlePostOpResultComments">
        			<p><?php echo _x('Comentarios de pacientes sometidos a una intervención intraocular:','Template Post-op Test Result','iol_theme');?> </p>
        		</div>
        		<?php comments_template( '/postOp-Test-Result-Comments.php', true ); ?>
				</div>
<?php } ?>
			<?php endwhile; // end of the loop. ?>



<?php /*get_sidebar();*/ ?>
<?php get_footer(); ?>