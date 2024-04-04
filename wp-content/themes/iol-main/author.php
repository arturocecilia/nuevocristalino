<?php
/**
 * The template for displaying Author Archive pages.
 *
 * Used to display archive-type pages for posts by an author.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header('blog'); ?>

	<section id="primary" class="site-content-author">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

			<?php
				/* Queue the first post, that way we know
				 * what author we're dealing with (if that is the case).
				 *
				 * We reset this later so we can run the loop
				 * properly with a call to rewind_posts().
				 */
				the_post();
			?>



            <!-- Antes de poner cualquier información sobre el perfil tenemos que garantizar que el usuario ha permitido que sea pública-->
            
            <?php if(get_the_author_meta( 'pPublic' ) == 'TRUE' ):?>

            <!-- Primero cogemos la categoría profesional para cambiar un poco la apariencia del perfil, la cargamos en una variable que acompañará a los divs que se desee
                para darle un aspecto diferente.
            -->
           <?php
               if ( get_the_author_meta( 'catPro' ) ){                   
                   $speClass = get_the_author_meta( 'catPro' ); 
                    }
               ?>
           	<header class="author-header <?php echo $speClass;?>">
				<h1 class="author-title">
                        <!-- Nombre del doctor, optometrista... conviene que sea el real para que esté indexado...-->
                        <?php echo esc_attr( get_the_author() ); ?>
                </h1>
			</header><!-- .author-header -->

            <!-- Conenedor de los detalles del autor -->
            <div class="authorDetails <?php echo $speClass;?>">
                
                <!-- Empezamos por el avatar si lo tiene, que lo tenga o no lo chequeamos con el input radio en el que da permiso a mostrar su imagen "de haberla subido" -->
                <div id="image-links-author">
                 <?php 
                        if(get_the_author_meta( 'imgProp' )== 'TRUE'){
                        echo '<div class="imgProfile">';
                            echo get_avatar(get_the_author_meta( 'ID' ),150);
                        echo '</div>';
                        }
                 ?> 
                 
                 <!-- 4º Email de contacto -->
                      <?php 
                         if(get_the_author_meta( 'emailContact' )){
                            echo '<div id="details-author">';
                            echo '<div class="dBloq4">';
                             echo '<img src="';
							 	//echo bloginfo("template_directory");
							 	echo get_stylesheet_directory_uri().'/images/blog/email-icon.jpg" alt="email"/>';
                             echo '<span class="value4">'.get_the_author_meta( 'emailContact' ).'</span>';
                            echo '</div>';
							echo '<div style="clear:both; height:0px;">&nbsp;</div>';
                            }
                       ?>
                 <!-- 5º Link a perfil en LinkedIn -->
                      <?php 
                         if(get_the_author_meta( 'linkedIn' )){
                            
                            echo '<div class="dBloq5">';
                             echo '<img src="';
							 	//echo bloginfo("template_directory");
							 	echo get_stylesheet_directory_uri().'/images/blog/linkedin-icon.jpg" alt="linkedin"/>';
                             echo '<span class="value5"><a href="'.get_the_author_meta( 'linkedIn' ).'">Ver perfil de Linkedin</a></span>';
                            echo '</div>';
							echo '</div>';
                            }
                       ?>
                </div>
                <!-- Vamos comprobando detalle a detalle si está definido de no estarlo no mostramos el bloque-->
                <div id="first-bloq-author">
                <div id="metadatos-author">
                <!-- 1º Cargo que ocupa -->
                    <?php if(get_the_author_meta( 'cargoPro' )):?>
                        <div class="dBloq1">
                        	<span class="value1">Cargo que ocupa:</span>
                            <span class="value2"><?php echo get_the_author_meta( 'cargoPro' ); ?></span>
                        </div>    
                    <?php endif;?>
                <!-- 2º Clínicas-Empresas en las que trabaja -->
                    <?php if(get_the_author_meta( 'clinicaEmp' )):?>

                    <!-- En este campo se da la opción de meter hasta 3 e irán separadas por comas -->
                    <!-- Ademas en el campo de después se da también la opción de meter las webs de los sitios con los que tendrán que ir sincronizados-->

                    <!-- Cargamos en un array las urls de haber sido rellenadas de los sitios webs -->
                    <?php 
                         if(get_the_author_meta( 'webClinicaEmp')){   
                             //echo 'El campo webClinicaEmp recogido es:'. get_the_author_meta( 'webClinicaEmp');                         
                                $webClinicaEmpString = get_the_author_meta( 'webClinicaEmp' );
                                $webClinicaEmpArray   = explode(',',$webClinicaEmpString);


                         }else{
                             $webClinicaEmpArray = array('','','');
                         }

                    ?>

                        <?php 
                                $clinicaEmpString = get_the_author_meta( 'clinicaEmp' );
                                $clinicaEmpArray   = explode(',',$clinicaEmpString);

                               // echo 'valor de clinicaEmStrig:=>'.$clinicaEmpString;
                               // var_dump($clinicaEmpArray);
                               // var_dump($webClinicaEmpArray);

                                /*Generamos el marcado correspondientes para cada uno de los valores*/
                                    echo '<div class="dBloq2">';                                 
                                    
                                    for ($i = 0; $i < count($clinicaEmpArray); $i++) {
										echo '<p><span class="value1">'._x('Trabajando actualmente en:','Author','iol_theme').'&nbsp;</span>';
                                     echo '<span class="value2">'.$clinicaEmpArray[$i].'</span></p>';
                                     echo '<p><span class="value1">'._x('Web de la empresa:','Author','iol_theme').'&nbsp;</span>';
                                     echo '<span class="webValue2">'.$webClinicaEmpArray[$i].'</span></p>';

                                     /*Vamos a dejar como máximo meter 3 empresas-clínicas*/
                                     if($i==2){
                                         break;
                                     }

                                    }
                                    echo '</div>';
                        ?>

                    <?php endif;?>
                

                <!-- 3º Pequeña descripción  -->
                    <?php 
                         if(get_the_author_meta( 'descProf')){
                            
                            echo '<div class="dBloq3">';
                             //echo '<span>Igual es mejor no introducir nada sino ponerlo si se ha rellenado y si no, no</span>';
                             echo '<span class="value3">'.get_the_author_meta( 'descProf' ).'</span>';
                            echo '</div>';
                            }

                     ?>
                 </div>   
                 <div id="post-author">
                 	<div id="post-author-title">
                        <div id="image-author-post">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/blog/pencil-icon.jpg" alt="pencil"/>
                        </div>
                        <h2><?php echo _x('POST PUBLICADOS','Author','iol_theme'); ?></h2>
                    </div>


            <?php    
               /*
			// If a user has filled out their description, show a bio on their entries.
			if ( get_the_author_meta( 'description' ) ) : ?>
			<div class="author-info">
				<div class="author-avatar">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentytwelve_author_bio_avatar_size', 60 ) ); ?>
				</div><!-- .author-avatar -->
				<div class="author-description">
					<h2><?php printf( __( 'About %s', 'twentytwelve' ), get_the_author() ); ?></h2>
					<p><?php the_author_meta( 'description' ); ?></p>
				</div><!-- .author-description	-->
			</div><!-- .author-info -->
			<?php endif; */ ?>

            <?php
				/* Since we called the_post() above, we need to
				 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();
			?>


			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
			        <!-- Aquí mostramos lo que queramos de los posts que ha escrito el tipo -->
            	
                    <?php 
                            /*No le veo el sentido a mostrar el contenido entero con el excerpt ya es suficiente*/
                            /*get_template_part( 'content', get_post_format() );*/
							echo '<div id="author-post-date">';
								echo '<div class="date">';
								the_date();
								echo '</div>';
							echo '</div>';
                            echo '<div class="title">';
                            the_Title();
                            echo '</div>';

                            echo '<div class="excerpt">';
                            the_excerpt(); 
                            echo '</div>';


                    ?>

			<?php endwhile; ?>


            <!-- "else:" del chequeo de permiso para mostrar información -->
            <?php else : ?>
                <!-- Habrá que maquetar esto...-->
             <?php echo _x('El autor no dispone de un perfil público','Author','iol_thme'); ?>

            <!-- Pero sí que se hace un resumen de los posts que ha escrito con lo que copiaremos lo del loop -->


            <!-- Fin del endif the permiso de infomración-->
            <?php endif;?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
        </div>
        </div>
			<div style="clear:both;">&nbsp;</div>
		</div><!-- #content -->
	</div>
    </section><!-- #primary -->
    <div class="community">
    	<div id="blog" class="comm-block">
            <?php //get_bloginfo( 'siteurl' ).'/blog-de-lentes-intraoculares-presbicia-y-cataratas' => 31 ?>
        	<a href="<?php echo get_permalink(31); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/comun/anuncio_blog.jpg" alt="<?php echo _x('Visite el Blog de Nuevo Cristalino','alt author','iol_theme'); ?>" /></a>
        </div>
        <div id="ask-oft" class="comm-block">
        	<a href="<?php echo get_bloginfo( 'siteurl' )._x('/preguntas-de-lentes-intraoculares-presbicia-y-cataratas','qa-slug','iol_theme'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/comun/anuncio_qa.jpg" alt="<?php echo _x('Pregunte sus dudas al cirujano.','alt author','iol_theme'); ?>" /></a>
        </div>
        <div id="ask-oft" class="comm-block">
        	<a href="<?php echo get_bloginfo( 'siteurl' )._x('/foro-de-lentes-intraoculares-presbicia-y-cataratas','foro-slug','iol_theme'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/comun/anuncio_forum.jpg" alt="<?php echo _x('Comparta información con otros pacientes en el foro.','alt author','iol_theme'); ?>" /></a>
        </div>
      </div>

<?php /* Igual es mejor por diseño meter un sidebar ... get_sidebar(); */ ?>
<?php get_footer('blog'); ?>