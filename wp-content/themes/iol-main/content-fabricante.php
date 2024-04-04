<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'twentytwelve' ); ?>
		</div>
		<?php endif; ?>
		<header class="entry-header">
			
			<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php endif; // is_single() ?>
			<?php if ( comments_open() ) : ?>
				<div class="comments-link">
					<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'twentytwelve' ) . '</span>', __( '1 Reply', 'twentytwelve' ), __( '% Replies', 'twentytwelve' ) ); ?>
				</div><!-- .comments-link -->
			<?php endif; // comments_open() ?>
		</header><!-- .entry-header -->
        <div id="volver">
            <?php //get_site_url().'/fabricantes-de-lentes-intraoculares/' ?>
        	<a href="<?php echo get_permalink(2910); ?>"><?php echo _x('VOLVER A LISTA DE FABRICANTES','Content Fabricante','iol_theme'); ?> &gt; &gt;</a>
        </div>
        

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<!-- Aquí es donde hay que volcar todos los contenidos -->
			<?php echo '<div class="featured-image-content startsUgly">'.get_the_post_thumbnail(get_the_ID(),'post-thumbnail', array('itemprop' => 'logo')).'</div>'; ?>
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>

              
                <!--Fabricante-->
            <?php if ($fabricanteD = get_post_meta($post->ID, 'fabricanteD', TRUE) and get_post_meta($post->ID, 'fabricanteD', TRUE) != '//'){ ?>
                <div class="bloq">
                    <div class="label fabricante"><?php echo _x('Fabricante:','Right Archive Lente Intraocular','iol_cpt_display'); ?></div>
                    <div class="value fabricante" itemprop="legalName"><?php echo $fabricanteD; /*esc_html( get_post_meta( get_the_ID(), 'fabricanteD', true ) )*/ ?></div>
                </div>
            <?php } ?>


                <!-- Display the Details -->
                <!--Distribuidoe en el páis-->
                
            <?php if ($distribNameD = get_post_meta($post->ID, 'distribNameD', TRUE) and get_post_meta($post->ID, 'distribNameD', TRUE) != '//'){ ?>
                <div class="bloq proveedor">
                    <div class="label distribuidor"><?php echo _x('Distribuidor en el país:','Content Fabricante','iol_theme'); ?></div>
                    <div class="value distribuidor">
	                   
	                <?php   
	                	
	    if( get_locale() == 'es_ES' && ( ($post->ID == 9878 ) || ($post->ID == 4903 ) )  ){
		                	
		       	if($post->ID == 9878){
			           	echo '<img src="https://www.nuevocristalino.es/wp-content/uploads/sources/avisl/avisl-icon.png" height="28" />';
		echo '<a class="provFSpan" href="https://www.nuevocristalino.es/proveedor-de-lentes-intraoculares/advanced-vision-iberia/">';		                	
		       			 echo $distribNameD; 
		           	    echo '</a>';
		                	 	}
		                	 	
		                	if($post->ID == 4903){
		                 echo '<img src="https://www.nuevocristalino.es/wp-content/uploads/sources/medicalmix/medicalmix-icon.png" height="28" />'; 
				echo '<a class="provFSpan" href="https://www.nuevocristalino.es/proveedor-de-lentes-intraoculares/medical-mix/">';		                	
		           			 echo $distribNameD; 
		                	echo '</a>';
		                	 	}
		                	 	
	                		}   
							else{   
	                    		 echo $distribNameD; 
	                		}
	                
	                	?>
	                
	                </div>
                </div>
            <?php } ?>
            
                <!-- Dirección del Distribuidor en el país -->
            
        <?php if ($direccionD = get_post_meta($post->ID, 'direccionD', TRUE) and get_post_meta($post->ID, 'direccionD', TRUE) != '//'){ ?>
                <div class="bloq">
                    <div class="label"><?php echo _x('Dirección:','Content Fabricante','iol_theme'); ?></div>
                    <div class="value"><?php echo  $direccionD ; ?></div>
                </div>
            <?php } ?>
               <!-- Teléfono de contacto del distribuidor -->
               <?php if ($telfContactoD = get_post_meta($post->ID, 'telfContactoD', TRUE) and get_post_meta($post->ID, 'telfContactoD', TRUE) != '//'){ ?>
                <div class="bloq">
                    <div class="label"><?php echo _x('Teléfono de contacto:','Content Fabricante','iol_theme'); ?></div>
                    <div class="value"><?php echo $telfContactoD; ?></div>
                </div>
                <?php } ?>
               <!-- Email del distribuidor  -->
                <?php if ($emailContactoD = get_post_meta($post->ID, 'emailContactoD', TRUE) and get_post_meta($post->ID, 'emailContactoD', TRUE) != '//'){ ?>
                <div class="bloq">
                    <div class="label"><?php echo _x('Email de contacto:','Content Fabricante','iol_theme'); ?></div>
                    <div class="value" ><?php echo $emailContactoD; ?></div>
                </div>
                <?php } ?>
                
                   <!-- Web del distribuidor -->
                <?php if ($webDistD = get_post_meta($post->ID, 'webDistD', TRUE) and get_post_meta($post->ID, 'webDistD', TRUE) != '//'){ ?>
                <div class="bloq">
                    <div class="label"><?php echo _x('Web Distribuidor:','Content Fabricante','iol_theme'); ?></div>
                    <div class="value"><a href="<?php echo $webDistD; ?>"><?php echo $webDistD; ?></a></div>
                </div>
                <?php } ?>                
                
                
                
               <!-- Web del Fabricante  -->
                <?php if ($webD = get_post_meta($post->ID, 'webD', TRUE) and get_post_meta($post->ID, 'webD', TRUE) != '//'){ ?>
                <div class="bloq">
                    <div class="label"><?php echo _x('Web:','Content Fabricante','iol_theme'); ?></div>
                    <div class="value"><a href="<?php echo $webD; ?>" itemprop="url"><?php echo $webD; ?></a></div>
                </div>
                <?php } ?>
                
              <?php if ($fabricanteDireccionD = get_post_meta($post->ID, 'fabricanteDireccionD', TRUE) and get_post_meta($post->ID, 'fabricanteDireccionD', TRUE) != '//'){ ?>
                <!--Dirección Fabricante-->
                <div class="bloq">
                    <div class="label fabricante"><?php echo _x('Dirección del Fabricante:','Content Fabricante','iol_theme'); ?></div>
                    <div class="value fabricante" itemprop="address"><?php echo $fabricanteDireccionD; ?></div>
                </div>
           
              <?php } ?>
                
          

			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

      
                <!-- Link para edición -->
        <?php edit_post_link('edit', '<p>', '</p>'); ?>

	</article><!-- #post -->
