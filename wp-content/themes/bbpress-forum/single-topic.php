<?php

/**
 * Single Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header(); //'forum'?>

	<?php do_action('bbp_before_main_content'); ?>

	<?php do_action('bbp_template_notices'); ?>

	<?php if (bbp_user_can_view_forum(array( 'forum_id' => bbp_get_topic_forum_id() ))) : ?>





		<?php while (have_posts()) : the_post(); ?>

			<div id="bbp-topic-wrapper-<?php bbp_topic_id(); ?>" class="bbp-topic-wrapper">
								<div class="entry-title"><?php echo _x('Foros de NuevoCristalino', 'single-forum', 'iol_last'); ?>
<?php //bbp_forum_title();?></div>

<?php
include('adsense-unit-responsive.php');

  ?>


<div style="font-size: 24px;
    margin-bottom: 20px;"><?php the_title();?></div>

				<div class="entry-content">

					<?php bbp_get_template_part('content', 'single-topic'); ?>

				</div>
			</div><!-- #bbp-topic-wrapper-<?php bbp_topic_id(); ?> -->

		<?php endwhile; ?>


	<?php elseif (bbp_is_forum_private(bbp_get_topic_forum_id(), false)) : ?>

		<?php bbp_get_template_part('feedback', 'no-access'); ?>

	<?php endif; ?>

	<?php do_action('bbp_after_main_content'); ?>

 <div id="widget-forum">

 <?php
  include(get_stylesheet_directory() . '/facebook-like.php');
  ?>

      <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('widgets-forum')) : ?>
      <?php endif; ?>

    <?php
        //Añadimos el full Yarpp Side.
        //include('nc-yarpp-full-side.php');
    ?>

   </div>
<?php get_footer();//'forum'?>
