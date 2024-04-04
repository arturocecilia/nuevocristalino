<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

    <?php
        //En primer lugar detectamos si es visualización de paciente o no.
        if(!isset($_GET['pt']) ||$_GET['pt']=='yes'){
            $pt= "?pt=yes";
        }else{
            $pt="?pt=no";
        }    
    
    ?>

   <div class="archive-lente-wrapper">

	<div id="post-<?php the_ID(); ?>" <?php post_class('iolCrossLang'); ?>>	

     <?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'twentytwelve' ); ?>
		</div>
		<?php endif; ?>
		<div class="entry-header iol-entry-header">
            <div class="featured-iol-archive-image">			
                <?php the_post_thumbnail(); ?>
			</div>
            <?php if ( is_single() ) : ?>
            <div class="title-iol-archive">
			<h1 class="entry-title"><?php the_title(); ?></h1>
            </div>
			<?php else : ?>
            <div class="title-iol-archive">
                <!--
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
                -->
            </div>
			<?php endif; // is_single() ?>
		</div><!-- .entry-header -->


		<div class="entry-content iol-entry-content">
            <h1 class="archive-iol-title">
				<a href="<?php echo the_permalink().$pt; ?>" class="nWindIol" target="_blank" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php the_excerpt(); /* __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) */ ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
            
         <?php
			//fabricante
			if ($fabricante = get_the_term_list( $post->ID, _x('fabricante-lente','taxo-name','iol'))){
				echo'
					<div class="bloq-single-lente">
						<div class="label">'._x("Fabricante de la Lente:","Content Archive Lente Intraocular","iol_theme").'</span></div>
						<div class="value">'.strip_tags($fabricante).'</div>
					</div>';
			} ?>

         <div class="iol-entry-meta">

           <a href="<?php the_permalink();?><?php echo '?pt=no';?>" class="nWindIol" target="_blank"><?php echo _x('Abrir lente en ventana nueva', 'Content Archive Lente Intraocular Paciente','iol_theme');?></a>
           <?php  /* edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' );*/ ?>
		</div><!-- .entry-meta -->

            
            </div><!-- .entry-content -->



        <div style="clear: both; height: 0px;">&nbsp;</div>
	</div><!-- #post -->
        <div style="clear: both; height: 0px;">&nbsp;</div>
</div>