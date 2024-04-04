<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>


   <div class="archive-lente-wrapper">

	<div id="post-<?php get_the_ID(); ?>" <?php post_class(); ?>>	

		<div class="entry-header iol-entry-header">
            <div class="featured-iol-archive-image">			
                <?php echo get_the_post_thumbnail(); ?>
			</div>
		</div>
		<div class="entry-content iol-entry-content">
            <h1 class="archive-iol-title">
				<a href="<?php echo get_permalink( get_the_ID() ); ?>"  rel="bookmark"><?php  echo get_the_title(); ?></a>
			</h1>
			<?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
	
            
         <div class="iol-entry-meta">
           <a href="<?php echo get_permalink( get_the_ID() ); ?>"><?php echo _x('Ver lente','Content Test Lente Intraocular','iol_theme'); ?></a>
			<?php /* edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' );*/ ?>
		</div><!-- .entry-meta -->

            
            </div><!-- .entry-content -->


        <div style="clear: both; height: 0px;">&nbsp;</div>
	</div><!-- #post -->
        <div style="clear: both; height: 0px;">&nbsp;</div>
</div>