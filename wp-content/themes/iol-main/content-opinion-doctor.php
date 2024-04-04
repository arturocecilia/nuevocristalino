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

		<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->

        <div id="volver">
        	<a href="<?php echo get_post_type_archive_link(_x('opinion-doctor', 'CustomPostType Name', 'opinion-doctor')); ?>"><?php echo _x('VOLVER A OPINIONES DE DOCTORES', 'Content Opinion Doctor', 'iol_theme'); ?> &gt; &gt;</a>
        </div>

		<div class="entry-content">

			<?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve')); ?>
			<?php wp_link_pages(array( 'before' => '<div class="page-links">' . __('Pages:', 'twentytwelve'), 'after' => '</div>' )); ?>
		</div><!-- .entry-content -->

                <!-- Link para edición -->
        <?php edit_post_link('edit', '<p>', '</p>'); ?>

	</article><!-- #post -->



<!--

		<footer class="entry-meta">
			<?php //twentytwelve_entry_meta();?>
			<?php edit_post_link(__('Edit', 'twentytwelve'), '<span class="edit-link">', '</span>'); ?>
			<?php if (is_singular() && get_the_author_meta('description') && is_multi_author()) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries.?>
				<div class="author-info">
					<div class="author-avatar">
						<?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('twentytwelve_author_bio_avatar_size', 68)); ?>
					</div><!-- .author-avatar -->
					<div class="author-description">
						<h2><?php printf(__('About %s', 'twentytwelve'), get_the_author()); ?></h2>
						<p><?php the_author_meta('description'); ?></p>
						<div class="author-link">
							<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author">
								<?php printf(__('View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentytwelve'), get_the_author()); ?>
							</a>
						</div><!-- .author-link	-->
					</div><!-- .author-description -->
				</div><!-- .author-info -->
			<?php endif; ?>
		</footer><!-- .entry-meta -->
