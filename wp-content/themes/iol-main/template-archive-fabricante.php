<?php
/*
 * Template Name: Template Archive Fabricante
 * Description: Este es el template para las p�ginas de mis ojos.
*/

get_header(); ?>




    <div class="submenu-pages" style="clear:left;">

      <div class="leftmenutitlewrapper">
      <span class="priorleftmenutitle">&nbsp;</span>
    	<h2><?php echo _x('Fabricantes','Template Tipos Lente Intraocular','iol_theme'); ?></h2>
      <span class="afterleftmenutitle">&nbsp;</span>
    </div>
        	<?php  wp_nav_menu(array('menu'=>'submenu-fabricantes')); ?>

          <div id="provseparator">&nbsp;</div>


<?php if(in_array(get_locale(),array('es_ES'))){ ?>
          <div class="leftmenutitlewrapper">
          <span class="priorleftmenutitle">&nbsp;</span>
          <h2><?php echo _x('Proveedores','Template Tipos Lente Intraocular','iol_theme'); ?></h2>
          <span class="afterleftmenutitle">&nbsp;</span>
          </div>

          <?php  wp_nav_menu(array('menu'=>'menu-proveedores')); ?>
  <?php  } ?>
    </div>








	<section id="primary" class="site-content-page-template site-content-fabri-archi">
		<div id="content" role="main">
       		<?php while ( have_posts() ) : the_post(); ?>
            <header class="archive-header">
            	<h1><?php echo the_title();?></h1>
            </header><!-- .archive-header -->
            <div id="content-fabri">




				<?php the_content(); ?>

       			<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<p class="edit-link">', '</p>' ); ?>

			<?php endwhile; // end of the loop. ?>
            </div>


		</div><!-- #content -->
	</section><!-- #primary -->

		<!-- Ini SubFabri -->

		<!-- Fin SubFabri -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
