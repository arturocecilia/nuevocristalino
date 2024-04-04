<?php

/**
 * bbPress - Forum Archive
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header(); //'forum'?>

		<?php //echo 'iol/archive-forum.php';?>

	<?php do_action('bbp_before_main_content'); ?>

	<?php do_action('bbp_template_notices'); ?>

	<div id="forum-front" class="bbp-forum-front">
		<h1 class="entry-title"><?php echo _x('Foros de NuevoCristalino', 'bbpress_forum', 'bbpress-forum') ?> <?php //bbp_forum_archive_title();?></h1>


<div style="margin-top:20px;margin-bottom:20px">Mensaje foro</div>

		<div class="entry-content">

			<?php bbp_get_template_part('content', 'archive-forum'); ?>

		</div>

	</div><!-- #forum-front -->



	<?php do_action('bbp_after_main_content'); ?>

<?php
      //veremos como meter esto con los widgets deseados
      /*get_sidebar();*/

       ?>
 <div id="widget-forum">

 <?php

  //include(get_stylesheet_directory() . '/facebook-like.php');

  ?>


        	<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('widgets-forum')) : ?>
      <?php endif; ?>
        </div>
<?php get_footer(); //'forum'?>
