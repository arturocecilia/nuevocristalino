<?php
/*
 * Template Name: Template Modelos de Lente Intraocular
 * Description: Este es el template para las páginas de mis ojos.
*/


get_header(); ?>

	<div id="primary" class="site-content-modelos-lentes">

     <div id="preButtonSet" class="noArchive startsUgly">

   	 <!-- Vamos a meter un link de ayuda que nos explique como se utiliza -->
    	<div id="helpTitle" class="startsUgly">
            <?php
           //El tema del cambio de versión

           $langChange = substr(get_locale(), 0, 2);


            if ($langChange =="es") {
                $helpCM	= 'AYUDA BÚSQUEDA LENTES';
            }

            if (get_locale() == 'en_GB') {
                $helpCM	= 'IOL SEARCH HELP';
            }

            if (get_locale() == 'en_US') {
                $helpCM	= 'IOL SEARCH HELP';
            }

            if ($langChange == 'de') {
                $helpCM	= 'HILFE IOL-SUCHE';
            }


            ?>
     		<a href="<?php echo get_permalink(2838); ?>" data-idToReplace="content article" data-idToGet ="content" data-selectorsNotToFade="" data-scrollTop="">
     		<?php echo $helpCM;?>

     		</a>
    	</div>

    	     		<style>
     		#de_DE #preButtonSet #searchReset{
	margin-top: 10px;
	}

			#de_AT #preButtonSet #searchReset{
	margin-top: 10px;
	}

     		</style>

    <!-- Vamos a meter un botón que nos permita refrescar la búsqueda -->
    	<button id="searchReset" onclick="location.reload();">
    		<?php echo _x('Resetear Búsqueda', 'Template Modelos de Lente Intraocular', 'iol_theme'); ?>
    	</button>
    </div>


		<div id="content" role="main">

			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part('content', 'page'); ?>
				<?php /*comments_template( '', true );*/ ?>
			<?php endwhile; // end of the loop.?>

      <!-- Utilizaremos estos divs auxiliares. El primero como contenedor de información y evitar así tener strings a ser localizadas en el js. -->
      <!-- El segundo para identificar unívocamente el template -->
      <div id="archiveUrl" style="display:none;"><?php echo get_post_type_archive_link(_x('lente-intraocular', 'CustomPostType Name', 'iol')) ?></div>
      <div id="tipoIolTemplate" style="display:none;">&nbsp;</div>
      <div id="modelosIol" style="display:none;">&nbsp;</div>




	<style>

		/*-- Añadimos el stilo de los formularios insertados en páginas qa--*/


#callToQuestion div.contenidoCallToQuestion{
	margin-bottom: 50px;
}


#question-form > label{
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 315px;
	margin-left:180px;
  margin-top: 30px;
}

#question-form > label img{
	display: inline;
	margin-top: 0px;
}

div.qatemplatebottom{
	margin-bottom: 50px;
}

div.qatemplatebottom #question-taxonomies{
	margin-top: 15px;
	margin-bottom: 15px;
	display: none;
}
div.qatemplatebottom #question-tags-label{
	padding-left: 20px;
}

div.qatemplatebottom input.qa-edit-submit{
	padding-top: 10px;
	padding-bottom: 10px;
	color: white;
	display: block;
	margin-left: auto;
	margin-right: auto;
	width: 300px;
	padding-left: 60px;
	padding-right: 60px;
	margin-top: 10px;
	font-size: 13px;
	background: #015995; /* Old browsers */
	background: -moz-linear-gradient(top, #015995 40%, #003c65 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(40%,#015995), color-stop(100%,#003c65)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  #015995 40%,#003c65 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #015995 40%,#003c65 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #015995 40%,#003c65 100%); /* IE10+ */
	background: linear-gradient(to bottom,  #015995 40%,#003c65 100%); /* W3C */
}

div.qatemplatebottom .wp-editor-container textarea.wp-editor-area{
	height: 250px;
}

div.qatemplatebottom .quicktags-toolbar {

  border: 1px solid #dedede;
}
div.qatemplatebottom  #question-title-label{
	width: 90px;
}

div.qatemplatebottom  #question-title-td{
	width: 90%;
}
div.qatemplatebottom  #question-title{
	width: 400px;
}

div.qatemplatebottom  div.qatitle{
	color:#003b60;
	font-family: 'negotiatefree';
    font-size: 18px;
    text-transform: uppercase;
    line-height: 1.4;
    margin-bottom: 15px;
}

div.qatitle span.nota{
	font-size:13px;
	text-transform: none;
}

div.qatemplatebottom.templatecx{
	width: 90%;
	margin-left: auto;
	margin-right: auto;
}


@media (max-width: 640px){

 div.qatemplatebottom #question-title{
	max-width:90%;
	margin-left:auto;
	margin-right:auto;
	}
	div.qatemplatebottom input.qa-edit-submit{
		padding-left:auto;
		padding-right:auto;
		}

	#question-form > label{
		margin-left:auto;
		margin-right:auto;
		text-align:center;
		}

}




	</style>



		</div><!-- #content -->
	</div><!-- #primary -->

      <?php

            //include(ABSPATH . 'wp-content/plugins/lente-intraocular/change-version-template-modelos-iol.php');
          //  if($_COOKIE['ncpatient']){
                    echo '<div id="right" class="filter-right patient-filter modelos-lente pteDisplay">';
                    //Incluimos antes los botones.
                    echo '<div id="changeFilter">';
                        echo '<a  href="#" >';//data-action="getAdvForm"
                        //echo .$filtAvanzado.
                        $paciente = true;
                    include(ABSPATH . 'wp-content/plugins/lente-intraocular/change-version-template-modelos-iol.php');

                        echo '</a>';

                    echo '</div>';

                    include(ABSPATH . 'wp-content/plugins/lente-intraocular/archive-patient-form.php');

                    echo  '</div>';

                 //}
       //     }
        //    else{
            //include('right-single-lente-intraocular.php');
      //      if(!$_COOKIE['ncpatient']){
            echo '<div id="right" class="filter-right modelos-lente pteNoDisplay">';
            //Inluimos antes que el form los botones.
            echo '<div id="changeFilter">';

                      echo '<a  href="#" >';//data-action="getPatientForm"
                      //.$filtSimple.
                      $paciente = 0;
                      include(ABSPATH . 'wp-content/plugins/lente-intraocular/change-version-template-modelos-iol.php');

                      echo '</a>';


            echo '</div>';
                //Incluimos el form
                //include('iolPluginTemplates/right-archive-lente-intraocular.php');
                include(ABSPATH . 'wp-content/plugins/lente-intraocular/right-archive-lente-intraocular.php');

            echo '</div>';
       //     }
   //   	}


      ?>
    <!-- </div> -->

    <?php
        //Añadimos el full Yarpp Bottom.
        include('nc-yarpp-full-bottom.php');

    ?>

<?php /* get_sidebar();*/ ?>
<?php get_footer(); ?>
