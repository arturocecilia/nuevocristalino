<?php

/**
 * Single View
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header('forum'); ?>

	<?php do_action( 'bbp_before_main_content' ); ?>

	<?php do_action( 'bbp_template_notices' ); ?>
	<?php //echo('single-view.php'); ?>
	<div id="bbp-view-<?php bbp_view_id(); ?>" class="bbp-view">
		<h1 class="entry-title"><?php bbp_view_title(); ?></h1>
		<div class="entry-content">

			<?php bbp_get_template_part( 'content', 'single-view' ); ?>

		</div>
	</div><!-- #bbp-view-<?php bbp_view_id(); ?> -->

	<?php do_action( 'bbp_after_main_content' ); ?>

 <div id="widget-forum">
        	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('widgets-forum') ) : ?>  
      <?php endif; ?> 
        </div>
<?php get_footer('forum'); ?>
