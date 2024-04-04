<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
<style>
	h1{
		font-size: 18px;
	}
	p{
		font-size: 15px;
		color: #666;
		margin-top: 5px;
	}
	#primary{
		    float: none;
    width: 100%;
    background: white;
	}
	.under-construction{
	max-width: 90%;
		height: 350px;
		margin-top:50px;
		text-align: center;
	}
	.under-construction img{
	max-width: 90%;
}
</style>
<div class="wrap">
	<div id="primary" class="content-area">
		<div class="under-construction">
			<h1>We are currently working on this feature</h1>
			<p>This will be enabled again on November the 2nd</p>
			<br />
<img src="https://www.nuevocristalino.es/wp-content/themes/iol-proms/images/under-construction.jpg" />
		</div> <div id="root">&nbsp;</div>

	</div><!-- #primary -->




	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
