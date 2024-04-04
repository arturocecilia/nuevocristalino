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

              
                <!--Proveedor-->
            <?php if ($proveedorD = get_post_meta($post->ID, 'proveedorD', TRUE) and get_post_meta($post->ID, 'proveedorD', TRUE) != '//'){ ?>
                <div class="bloq">
                    <div class="label fabricante"><?php echo _x('Proveedor:','Content Proveedor','iol_theme'); ?></div>
                    <div class="value fabricante" itemprop="legalName"><?php echo $proveedorD; /*esc_html( get_post_meta( get_the_ID(), 'fabricanteD', true ) )*/ ?></div>
                </div>
            <?php } ?>

    <?php if ($proveedorDireccionD = get_post_meta($post->ID, 'proveedorDireccionD', TRUE) and get_post_meta($post->ID, 'proveedorDireccionD', TRUE) != '//'){ ?>
                <!--Dirección Fabricante-->
                <div class="bloq">
                    <div class="label fabricante"><?php echo _x('Dirección del Proveedor','Content Proveedor','iol_theme'); ?></div>
                    <div class="value fabricante" itemprop="address"><?php echo $proveedorDireccionD; ?></div>
                </div>
           
              <?php } ?>
                <!-- Display the Details -->

               <!-- Teléfono de contacto del distribuidor -->
               <?php if ($proveedorTelfContactoD = get_post_meta($post->ID, 'proveedorTelfContactoD', TRUE) and get_post_meta($post->ID, 'proveedorTelfContactoD', TRUE) != '//'){ ?>
                <div class="bloq">
                    <div class="label"><?php echo _x('Teléfono de contacto:','Content Proveedor','iol_theme'); ?></div>
                    <div class="value"><?php echo $proveedorTelfContactoD; ?></div>
                </div>
                <?php } ?>
               <!-- Email del distribuidor  -->
                <?php if ($proveedorEmailContactoD = get_post_meta($post->ID, 'proveedorEmailContactoD', TRUE) and get_post_meta($post->ID, 'proveedorEmailContactoD', TRUE) != '//'){ ?>
                <div class="bloq">
                    <div class="label"><?php echo _x('Email de contacto:','Content Proveedor','iol_theme'); ?></div>
                    <div class="value" ><?php echo $proveedorEmailContactoD; ?></div>
                </div>
                <?php } ?>
                
                <?php 
	                
	               /* $myvals = get_post_meta($post->ID);

foreach($myvals as $key=>$val)
{
    echo $key . ' : ' . $val[0] . '<br/>';
}*/
                ?>
               <!-- Web del Fabricante  -->
         <?php if ($proveedorWebD = get_post_meta($post->ID, 'proveedorWebD', TRUE) and get_post_meta($post->ID, 'proveedorWebD', TRUE) != '//'){ ?>
                <div class="bloq">
                    <div class="label"><?php echo _x('Web:','Content Proveedor','iol_theme'); ?></div>
                    <div class="value"><a href="<?php echo $proveedorWebD; ?>" itemprop="url"><?php echo $proveedorWebD; ?></a></div>
                </div>
                <?php } ?>          

			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

      
                <!-- Link para edición -->
        <?php edit_post_link('edit', '<p>', '</p>'); ?>

	</article><!-- #post -->
