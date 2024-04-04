<?php
/*
 * Template Name: Template Iol Simulator
 * Description: Este es el template para las páginas de mis ojos.
*/

get_header(); ?>
<!-- <link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/dot-luv/jquery-ui.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>  -->
<div id="primary" class="site-content-simulator">
		<div id="content" role="main">

<!-- Aquí metemos el cuestionario tal cual -->


				<!-- entry-header -->
 				<div class="entry-header">

 					<h1 class="entry-title">
 						<?php the_title();?>
 					</h1>
 				</div>
				<?php /* Vamos a poner el contenido en este template the_content(); */ ?>

            <div id="simulatorIntro">


			<?php while ( have_posts() ) : the_post(); ?>

			          <?php   the_content();?>

			<?php endwhile; // end of the loop. ?>

            </div>


<!-- Buttonset para seleccionar escenarios -->
            <form id="simulatorForm">
<div id="scenarios" class="startsUgly">
	<input type="radio" id="day" data-scenario="day" name="scenario" checked="checked" value="day"><label for="day"><?php echo _x('De día','Template Iol Simulator','iol_theme'); ?></label></input>
	<input type="radio" id="night" data-scenario ="night"  name="scenario" value="night" ><label for="night"><?php echo _x('De noche','Template Iol Simulator','iol_theme'); ?></label></input>
</div>


  <div id="sym" style="position: relative; margin: auto;">
  </div>
 <div id="menu-simulator-container">
 		<div id="menu-simulator-title">
        	<div id="menu-title-conditions" class="simulator-title">
            	<?php echo _x('CONDICIONES OCULARES','Template Iol Simulator','iol_theme'); ?>
            </div>
            <div id="menu-title-vision" class="simulator-title">
            	<?php echo _x('VISIÓN RESULTANTE CON LENTES INTRAOCULARES','Template Iol Simulator','iol_theme'); ?>
            </div>
        </div>
        <div style="clear:both; height:0px;">&nbsp;</div>
        <div id="conditionsWrapper">
            <div id="conditions">
            <div id="simulator-options-conditions">
               <input type="radio" id="normal" data-image="normal-day" class="botonSim" name="sym-control" value="normal" /><label for="normal"><?php echo _x('Visión Normal','Template Iol Simulator','iol_theme'); ?></label> <!-- -condition -->
               <input type="radio" id="presbicia" data-image="presbicia-day" class="botonSim" name="sym-control" value="presbicia" /><label for="presbicia"><?php echo _x('Visión con Presbicia','Template Iol Simulator','iol_theme');?></label>
               <input type="radio" id="cataratas" data-image="cataratas-day" class="botonSim" name="sym-control" value="cataratas" /><label for="cataratas"><?php echo _x('Visión con Cataratas','Template Iol Simulator','iol_theme');?></label>
            </div>
           </div>
               <!-- Botonoes de astigmatismo -->

                <div id="astigButtons" class="startsUgly">
                    <input type="radio" id="astigmatismo" data-image="astigmatismo-day" name="astigmatismo" class="botonSim" value="astigmatismo" /><label for="astigmatismo"><?php echo _x('Sí','Template Iol Simulator','iol_theme'); ?></label>
                    <input type="radio" id="astigmatismo_no" data-image="normal-day" name="astigmatismo" class="botonSim" value="astigmatismo_no" checked="checked" /><label for="astigmatismo_no"><?php echo _x('No','Template Iol Simulator','iol_theme'); ?></label>
                    <span class="astigText"><?php echo _x('Tengo Astigmatismo','Template Iol Simulator','iol_theme'); ?></span>
                </div>

          </div>

        <div id="vision-result">
          <input type="radio" id="monofocal_Esferica"  data-image="monofocal_Esferica-day" class="botonSim" name="sym-control" value="monofocal_Esferica" /><label for="monofocal_Esferica"><?php echo _x('LIO Monofocal Esférica','Template Iol Simulator','iol_theme'); ?></label>
          <input type="radio" id="monofocal_Asferica"  data-image="monofocal_Asferica-day" class="botonSim" name="sym-control" value="monofocal_Asferica" /><label for="monofocal_Asferica"><?php echo _x('LIO Monofocal Asférica','Template Iol Simulator','iol_theme'); ?></label>
          <input type="radio" id="multifocal_Bifocal"  data-image="multifocal_Bifocal-day" class="botonSim" name="sym-control" value="multifocal_Bifocal" /><label for="multifocal_Bifocal"><?php echo _x('LIO Multifocal Bifocal','Template Iol Simulator','iol_theme'); ?></label>
          <input type="radio" id="multifocal_Trifocal"  data-image="multifocal_Trifocal-day" class="botonSim" name="sym-control" value="multifocal_Trifocal" /><label for="multifocal_Trifocal"><?php echo _x('LIO Multifocal Trifocal','Template Iol Simulator','iol_theme'); ?></label>
          <!--  <input type="radio" id="monofocal_Torica"  data-image="monofocal_Torica-day" class="botonSim" name="sym-control" value="monofocal_Torica" /><label for="monofocal_Torica"><?php echo _x('LIO Monofocal Tórica','Template Iol Simulator','iol_theme'); ?></label> -->
          <!--  <input type="radio" id="multifocal_Torica"  data-image="multifocal_Torica-day" class="botonSim" name="sym-control" value="multifocal_Torica" /><label for="multifocal_Torica"><?php echo _x('LIO Multifocal Tórica','Template Iol Simulator','iol_theme'); ?></label> -->
          <input type="radio" id="monofocal_Esferica_Torica"  data-image="monofocal_Esferica_Torica-day" class="botonSim toric" name="sym-control" value="monofocal_Esferica_Torica" /><label class="toric" for="monofocal_Esferica_Torica"><?php echo _x('LIO Monofocal Esférica Tórica','Template Iol Simulator','iol_theme'); ?></label>
          <input type="radio" id="monofocal_Asferica_Torica"  data-image="monofocal_Asferica_Torica-day" class="botonSim toric" name="sym-control" value="monofocal_Asferica_Torica" /><label class="toric" for="monofocal_Asferica_Torica"><?php echo _x('LIO Monofocal Asférica Tórica','Template Iol Simulator','iol_theme'); ?></label>
          <input type="radio" id="multifocal_Bifocal_Torica"  data-image="multifocal_Bifocal_Torica-day" class="botonSim toric" name="sym-control" value="multifocal_Bifocal_Torica" /><label class="toric" for="multifocal_Bifocal_Torica"><?php echo _x('LIO Multifocal Bifocal Tórica','Template Iol Simulator','iol_theme'); ?></label>
          <input type="radio" id="multifocal_Trifocal_Torica"  data-image="multifocal_Trifocal_Torica-day" class="botonSim toric" name="sym-control" value="multifocal_Trifocal_Torica" /><label class="toric" for="multifocal_Trifocal_Torica"><?php echo _x('LIO Multifocal Trifocal Tórica','Template Iol Simulator','iol_theme'); ?></label>


        </div>
</div>
        </form>


        <?php $pathToImagFolder = get_theme_root_uri().'/iol/images/'; ?>

<div id="auxPathToFolder" style="display:none;"><?php echo $pathToImagFolder; ?></div>

		<script>

		</script>


		<style>
		#sym{
			width: 800px;
			overflow: hidden;
		}

		#cataractBloq{
    		margin-left: 30px;
    		margin-top: 20px;
    		text-align: center;
    		width: 750px;
		}

		#cataractSliderWrapper{
			width: 200px;
			float: left;
			font-size: 0.75em;
		}

		#cataractSlider{
			width: 175px;
		}
		#cataractSliderWrapper label{
			font-size: 12px;
		}

		#cataractBloq #monof{
			width: 200px;
			float: left;
		}

    	#cataractBloq #multif{
			width: 200px;
			float: left;
    	}

		</style>

<script>




</script>



			<?php while ( have_posts() ) : the_post(); ?>


			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<!-- Ponemos un div auxiliar para identificar -->
<div style="display:none;height:0px;" id="templateIolSimulator"> &nbsp;</div>

 <!-- Lo quitamos de momento 
 <div id="right" class="rightIolSimulator">

 </div>
 	-->
<!-- Añadimos el div de clearizacion -->

    <?php
        //Añadimos el full Yarpp Bottom.
        include('nc-yarpp-full-bottom.php');

    ?>


<div style="clear:both; height:0px; display:none;">&nbsp;</div>



<?php get_footer(); ?>
