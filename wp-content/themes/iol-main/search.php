<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); //'blog'?>

	<section id="primary" class="site-content-blog">

		<!-- Título del blog -->
		<div class="title-blog-wrapper"><h1><?php echo _x('Blog de lentes intraoculares Presbicia y cataratas', 'iol_main', 'iol-main');?></h1></div>
		<!-- -->

		<div id="content-blog" role="main">

		<?php if (have_posts()) : ?>

			<header class="page-header">
				<h3 class="search-title"><?php printf(__('Search Results for: %s', 'twentytwelve'), '<span>' . get_search_query() . '</span>'); ?></h3>
			</header>

			<?php twentytwelve_content_nav('nav-above'); ?>

			<?php /* Start the Loop */ ?>
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part('content-blog', get_post_format());//content-search?>
			<?php endwhile; ?>

			<?php twentytwelve_content_nav('nav-below'); ?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e('Nothing Found', 'twentytwelve'); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentytwelve'); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		<?php endif; ?>

		</div><!-- #content -->
        <div id="widgetblog">
        	<div id="search">
            	<?php
                 // Custom widget Area Start
                 if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('search')) : ?>
                <?php endif;
                // Custom widget Area End
                ?>
            </div>
        	<div id="login-blog">
            	<?php
                 // Custom widget Area Start
                 if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('registerform')) : ?>
                <?php endif;
                // Custom widget Area End
                ?>

            </div>

						<?php

                                  //      include(get_stylesheet_directory() . '/widget-advregister.php');

                        ?>
				<!-- Fin del de ventajas de registro -->

            <div id="blog-blocks">

							<?php


                                                        bg_recent_comments();
                            ?>
        	</div>
	</section><!-- #primary -->


<?php get_footer(); ?>
