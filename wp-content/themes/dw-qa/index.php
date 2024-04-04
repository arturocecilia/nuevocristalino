<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<div class="dwqa-questions-archive">
				<?php do_action('dwqa_before_questions_archive') ?>

					<div class="dwqa-questions-list">
					<?php do_action('dwqa_before_questions_list') ?>
					<?php if (dwqa_has_question()) : ?>
						<?php while (dwqa_has_question()) : dwqa_the_question(); ?>
							<?php if (get_post_status() == 'publish' || (get_post_status() == 'private' && dwqa_current_user_can('edit_question', get_the_ID()))) : ?>
								<?php dwqa_load_template('content', 'question') ?>
							<?php endif; ?>
						<?php endwhile; ?>
					<?php else : ?>
						<?php dwqa_load_template('content', 'none') ?>
					<?php endif; ?>
					<?php do_action('dwqa_after_questions_list') ?>
					</div>
					<div class="dwqa-questions-footer">
						<?php dwqa_question_paginate_link() ?>
						<?php if (dwqa_current_user_can('post_question')) : ?>
							<div class="dwqa-ask-question"><a href="<?php echo dwqa_get_ask_link(); ?>"><?php _e('Ask Question', 'dwqa'); ?></a></div>
						<?php endif; ?>
					</div>

				<?php do_action('dwqa_after_questions_archive'); ?>
			</div>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
