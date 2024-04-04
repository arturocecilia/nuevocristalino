<?php
/*
 * Template Name: Template NoRegistereduestionnaires
 * Description: Este es el template para las páginas que no tienen menús
 */



 get_header();
?>

 <div id="primary" class="noregquestionnaires"> <!-- primary-quienes lo dejamos en primary-->
       <div id="content" role="main" style="position:inherit;">

<div id="specificNoRegQHeader">

  <div id="questionphotoTitle">
      <span class="orange"><?php echo _x('Queremos saber cómo ves.', 'template-noregisteredquestionnaires', 'iol_last'); ?> </span>
      <span class="black"><?php echo _x('Cuéntanos tu opinión sobre el resultado de tu operación.', 'template-noregisteredquestionnaires', 'iol_last'); ?></span>
  </div>

</div>
<div class="specificNoRegQHeaderFiller">&nbsp;
</div>

<div class="floatFixer">&nbsp;</div>

<?php while (have_posts()) : the_post(); ?>


  <?php get_template_part('content', 'page'); ?>


<?php //echo do_shortcode('[TheChamp-Sharing style="background-color:#000;"  url="http://mywebsite.com/example.php"]')?>

  <?php /*comments_template( '', true );*/ ?>
<?php endwhile; // end of the loop.?>

<!--
<div id="noRegFormInfoWrapper">

				<form id="preNonRegQuest" method="GET">


			<label>¿De qué te has operado?</label>
					<input type="hidden" name="p_preOrPost" value="p_preOrPost_Post">
					<input type="submit" name="p_sxInteres" value="p_sxInteres_Cat">
					<input type="submit" name="p_sxInteres" value="p_sxInteres_Cle">

				</form>

</div>
-->

<div id="quickMensPostOp">
      <span class="mssage"><?php echo _x('Ayuda a otros usuarios interesados en tu operación.', 'template-noregisteredquestionnaires', 'iol_last'); ?></span>
</div>



</div><!-- #content -->

<!-- Image links de las operaciones-->

<?php
//ids NoReg Postops.
$idCuestCLE = 15371;
$idCuestLASIK = 15383;
$idCuestICL = 15382;
$idCuestCAT = 15364;

?>


<div id="opTypeLinksWrapper">

  <div class="specificNoRegQHeaderFiller noMobile">&nbsp;
  </div>

  <div class="floatFixer">&nbsp;</div>
<div id="cuest-cle"><a href="<?php echo get_permalink($idCuestCLE)?>"><span><?php echo _x('Operación con reemplazo de cristalino sin cataratas', 'template-noregisteredquestionnaires', 'iol_last'); ?></span></a></div>
<div id="cuest-cataratas"><a href="<?php echo get_permalink($idCuestCAT)?>"><span><?php echo _x('Operación de cataratas (con cualquier tipo de lente intraocular)', 'template-noregisteredquestionnaires', 'iol_last');?></span></a></div>
<div class="floatFixer noMobile" style="height:30px;">&nbsp;</div>
<div id="cuest-lasik"><a href="<?php echo get_permalink($idCuestLASIK)?>"><span><?php echo _x('Operación con láser excímer sobre córnea (LASIK, PRK, etc.)', 'template-noregisteredquestionnaires', 'iol_last'); ?></span></a></div>
<div id="cuest-icl"><a href="<?php echo get_permalink($idCuestICL)?>"><span><?php echo _x('Operación con lente intraocular ICL', 'template-noregisteredquestionnaires', 'iol_last'); ?></span></a></div>

<div class="floatFixer">&nbsp;</div>
</div>
<div class="floatFixer">&nbsp;</div>


<!-- Mensaje para compartir y mensaje para que se registren -->


<?php //echo '<div id="rssPostWrapper">'._x('Si conoces a alguien que ya se ha operado y puede dar el testimonio de su operación, compártelo esta página usando una red social:','template-noregisteredquestionnaires','iol_last').' </div>';?>
<?php echo '<div class="centered">'; ?>
<?php //echo do_shortcode('[TheChamp-Sharing]')?>
<?php echo '</div>'; ?>



</div><!-- #primary -->

<?php get_footer(); ?>
