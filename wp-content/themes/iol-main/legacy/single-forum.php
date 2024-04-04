<?php

/**
 * Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header(); //'forum' ?>


	<?php do_action( 'bbp_before_main_content' ); ?>

	<?php do_action( 'bbp_template_notices' ); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php if ( bbp_user_can_view_forum() ) : ?>

			<div id="forum-<?php bbp_forum_id(); ?>" class="bbp-forum-content">
				<h1 class="entry-title"><?php echo _x('Foros de NuevoCristalino','single-forum','iol_last'); ?><?php //bbp_forum_title(); ?></h1>
				<div class="entry-content">

					<?php bbp_get_template_part( 'content', 'single-forum' ); ?>

				</div>
			</div><!-- #forum-<?php bbp_forum_id(); ?> -->

		<?php else : // Forum exists, user no access ?>

			<?php bbp_get_template_part( 'feedback', 'no-access' ); ?>

		<?php endif; ?>

	<?php endwhile; ?>

	<?php do_action( 'bbp_after_main_content' ); ?>


<?php /*get_sidebar();*/ ?>
		<div id="widget-forum">


 <?php
  include(get_stylesheet_directory() . '/facebook-like.php');
  ?>



        	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('widgets-forum') ) : ?>
      <?php endif; ?>
        </div>
<?php get_footer();//'forum' ?>
