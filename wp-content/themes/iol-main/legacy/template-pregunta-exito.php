<?php
/*
 * Template Name: Template Pregunta Exito
 * Description: Este es el template para las páginas que no tienen menús
 */

get_header(); ?>

	<div id="primary" class="site-content-not-menus"> <!-- primary-quienes lo dejamos en primary-->
        <div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php /*comments_template( '', true );*/ ?>
			<?php endwhile; // end of the loop. ?>

        <?php /* Añadimos links para dar opciones a donde ir */ 
            //Blog, Q&A, Foro
                $permaBlog      =   get_permalink(  31  );
            ?>            
      <div id="qSugLinks"> 
       <ul>
          <li>	
            <a href="<?php echo $permaBlog;?>"><?php echo _x('Ir al Blog Nuevo Cristalino','alt header single iol','iol_theme'); ?></a>
          </li>    
          <li>
            <a href="<?php echo get_bloginfo('url').'/'._x('foro-de-lentes-intraoculares-presbicia-y-cataratas','foro-slug','iol_theme'); ?>"><?php echo _x('Ir al Foro de Nuevo Cristalino','alt header single iol','iol_theme');?></a>
         </li>
           <li>   
              <a href="<?php echo get_site_url().'/'._x('preguntas-de-lentes-intraoculares-presbicia-y-cataratas','qa-slug','iol_theme'); ?>"><?php echo _x('Ir a pregunte al Cirujano','alt header single iol','iol_theme'); ?></a>
          </li> 
       </ul>
</div>
            <div>
            
            </div>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>