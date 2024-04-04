<?php
/*
 * Template Name: Template Mis Ojos
 * Description: Este es el template para las páginas de mis ojos.
 */

get_header(); ?>


    <div id="submisojos" class="submenu-pages">
    	<h2><?php echo _x('MIS OJOS','Template Mis Ojos','iol_theme'); ?></h2>
        <?php  wp_nav_menu(array('theme_location'=>'menu-anatomia-ojo')); ?>
    </div>

	<div id="primary" class="site-content-page-template mis-ojos">
    
    	
		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php /* comments_template( '', true );*/ ?>
			<?php endwhile; // end of the loop. ?>

        </div><!-- #content -->
	</div><!-- #primary -->
    
    <!-- Div auxiliar para identificar el template de Mis Ojos -->
    <div id="templateMisOjos">&nbsp;</div>
    


    <div id="leftWrapper">
    <?php
        //Añadimos el full Yarpp Bottom.
        include('nc-yarpp-full-side.php');

    ?>
    </div>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>