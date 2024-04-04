<?php
/**
Template Name: Template	 Blog
 */

get_header();//'BLOG'
?>

	<div id="primary" class="site-content-blog">


<!-- Título del blog -->
<div class="title-blog-wrapper"><div><?php echo _x('Blog de lentes intraoculares Presbicia y cataratas', 'iol_main', 'iol-main'); ?></div></div>
<!-- -->


<!-- Metemos aquí el menú del blog-->

<?php wp_nav_menu(array('menu'=>'menu-blog')); ?>

<!-- Fin del menú del blog -->




		<div id="content-blog" role="main">
        <?php
//foreach((get_the_page()) as $page) {
    //echo $page->paget_ID . ' ';
//}
?>
			<?php

 if (current_user_can('manage_options')) {
     //   load_textdomain('theme-my-login' , get_site_url() . 'wp/content/plugins/theme-my-login/languages/theme-my-login-de_DE');
         //    echo _e('NOTICE:','theme-my-login');
 }
            ?>

            <?php /* Define the query object $wp_query */ ?>
			<?php

                $temp = $wp_query;
                $wp_query= null;
                $wp_query = new WP_Query();
                $wp_query->query('posts_per_page=6'.'&paged='.$paged);
             ?>
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part('content-blog', get_post_format()); ?>
				<?php comments_template('', true); ?>
			<?php endwhile; // end of the loop.?>

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





    <!-- añadimos el widget-surgeons.php-->
    <?php

        //			include(get_stylesheet_directory() . '/widget-surgeons.php')

        ?>
    <!-- Fin añadido widget -->



	<?php

        include('adsense-unit-lateral-cuadrado.php')
    ?>



        	<div id="login-blog">
            	<?php
                 // Custom widget Area Start
                 if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('registerform')) : ?>
                <?php endif;
                // Custom widget Area End
                ?>

            </div>




 <?php
  //include(get_stylesheet_directory() . '/facebook-like.php');

  ?>




		<!-- añadimos el widget-surgeons.php-->
    <?php
                        //include(get_stylesheet_directory() . '/widget-eye-clinics.php')
        ?>
    <!-- Fin añadido widget -->

            <div id="blog-blocks">

<?php


                            bg_recent_comments();
?>



				<?php
                 // Custom widget Area Start
                 if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('widgetsblog')) : ?>
                <?php endif;
                // Custom widget Area End
                ?>
        	</div>

        </div>
	</div><!-- #primary -->


<?php get_footer(); ?>
