<?php

/**
 * Single User
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header();//'forum' ?>

	<?php do_action( 'bbp_before_main_content' ); ?>

	<div id="bbp-user-<?php bbp_current_user_id(); ?>" class="bbp-single-user">
			<h1 class="entry-title"><?php echo _x('Foros de NuevoCristalino','single-forum','iol_last'); ?> <?php //bbp_forum_title(); ?></h1>
		<div class="entry-content">


			<?php bbp_get_template_part( 'content', 'single-user' ); ?>

		</div><!-- .entry-content -->
	</div><!-- #bbp-user-<?php bbp_current_user_id(); ?> -->

	<?php do_action( 'bbp_after_main_content' ); ?>

 <div id="widget-forum">
        	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('widgets-forum') ) : ?>
      <?php endif; ?>
        </div>
<?php get_footer();//'forum' ?>
