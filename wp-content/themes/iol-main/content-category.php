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
			
		</header><!-- .entry-header -->
		
        <footer class="entry-meta">
			<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
	         <p><?php echo _x('ESCRITO POR','blog','iol_theme'); ?>  <?php the_author(); ?> | </p>
    		<?php if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
				<div class="author-info">
					<div class="author-description">
						<h2><?php printf( __( 'About %s', 'twentytwelve' ), get_the_author() ); ?></h2>
						<p><?php the_author_meta( 'description' ); ?></p>
						<div class="author-link">
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentytwelve' ), get_the_author() ); ?>
							</a>
						</div><!-- .author-link	-->
					</div><!-- .author-description -->
				</div><!-- .author-info -->
                
                
			<?php endif; ?>
            <div id="fecha">
            	<?php iol_home_meta();
				 ?>
            </div>
            

		</footer><!-- .entry-meta -->
        <?php /*the_post_thumbnail('full');*/ ?>
        
		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
            <?php /* the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) );*/ ?>
        <div class="leermas-blog">
        	<a href="<?php echo get_permalink(); ?>" ><?php echo _x('Leer más','Content Category','iol_theme');?></a>
        </div>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_post_thumbnail('full');?>
            <?php  the_excerpt();			 
			?>
			<?php /* the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) );*/ ?>
        <div class="leermas-blog">
        	<a href="<?php echo get_permalink(); ?>" ><?php echo _x('Leer más','Content Category','iol_theme');?></a>
        </div>
            
			
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

		
	</article><!-- #post -->
