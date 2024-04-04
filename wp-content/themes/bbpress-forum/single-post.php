<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<div id="primary" class="site-content-blog">


<!-- Título del blog -->
<div class="title-blog-wrapper"><div><?php echo _x('Blog de lentes intraoculares Presbicia y cataratas', 'single-post', 'iol_last'); ?> </div></div>
<!-- -->


<!-- Metemos aquí el menú del blog-->

<?php wp_nav_menu(array('menu'=>'menu-blog')); ?>

<!-- Fin del menú del blog -->

		<div id="content-blog" role="main">
			<?php while (have_posts()) : the_post(); ?>

				<?php get_template_part('content-SingleBlog', get_post_format()); ?>



<!-- -->
 <?php
  include(get_stylesheet_directory() . '/share-nc-post.php');
  echo '<div style="height:30px;">&nbsp;</div>';
  ?>

<!-- -->



				<nav class="nav-single">
					<h3 class="assistive-text"><?php _e('Post navigation', 'twentytwelve'); ?></h3>
					<span class="nav-previous"><?php previous_post_link('%link', '<span class="meta-nav">' . _x('&larr;', 'Previous post link', 'twentytwelve') . '</span> %title'); ?></span>
					<span class="nav-next"><?php next_post_link('%link', '%title <span class="meta-nav">' . _x('&rarr;', 'Next post link', 'twentytwelve') . '</span>'); ?></span>
				</nav><!-- .nav-single -->
                <?php edit_post_link(__('Edit', 'twentytwelve'), '<p class="edit-link">', '</p>'); ?>

            	<?php comments_template('', true); ?>

			<?php endwhile; // end of the loop.?>

		</div><!-- #content -->
        <div id="widgetblog">

	<?php

        include('adsense-unit-lateral-cuadrado.php')
    ?>


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
      //Aquí vamos a meter el doble vertical banner también.
     if (get_locale() == 'de_DE') {
         echo '<div class="ebookpodcastvertical">';
         include('ebook-podcast.php');
         echo '</div>';
     }




$eslang = array('es_ES','es_MX','es_CL','es_CO');
if (in_array(get_locale(), $eslang)) {
    echo '<div class="ebookpodcastvertical">';
    include('es-ebook-podcast.php');
    echo '</div>';
}



      ?>




 <?php
  include(get_stylesheet_directory() . '/facebook-like.php');
  ?>

      <!-- añadimos el widget-surgeons.php-->
    <?php

        //			include(get_stylesheet_directory() . '/widget-surgeons.php')

        ?>
    <!-- Fin añadido widget -->








						<!-- Añadimos el de ventajas de registro-->

				        <?php
                                    if ((!is_user_logged_in()) || (current_user_can('manage_options'))) {
                                        //	include(get_stylesheet_directory() . '/widget-advregister.php');
                                    }
                            ?>
				    <!-- Fin del de ventajas de registro -->




            <div id="blog-blocks">
				<?php
                 // Custom widget Area Start
                 if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('widgetsblog')) : ?>
                <?php endif;
                // Custom widget Area End
                ?>
        	</div>

    <?php
        //Añadimos el full Yarpp Side.
        include('nc-yarpp-full-side.php');
    ?>

        </div>
	</div><!-- #primary -->

<?php get_footer(); ?>
