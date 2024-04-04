<?php
/*
 * Template Name: Template mapaWeb
 * Description: Este es el template para las páginas de mis ojos.
*/

get_header(); ?>


    <div id="primary" class="site-content-page-template-ContentOnly">

 		<!-- Content de Inicio -->
		<div id="content" role="main" class="mapaWeb">

			<?php while (have_posts()) : the_post(); ?>

            <!-- Bloques de Mi Lente Intraocular; Buscadores IOL; Buscador Clínicas;  -->
            <div class="siteMapBlock">
              <ul>
              <?php
              //Empezamos por reproducir el menú superior.
                wp_list_pages(
                            array(
                                    'include'=> array(2349,227,2891,412,9638),
                                    'exclude' => '',
                                    'title_li' => '<h2>' . _x('MI LENTE INTRAOCULAR', 'menu-site', 'iol_theme') . '</h2>'
                                    )
                );

              ?>
               </ul>
                <ul class="buscadorLio">
               <?php
                    wp_list_pages(
                            array(
                                    'include'=> array(5254),
                                    'exclude' => '',
                                    'title_li' => '<h2>' . _x('BUSCADOR DE LIO', 'mapa-web-title', 'iol_theme') . '</h2>'
                                    )
              );
                ?>
               </ul>
               <ul class="buscadorClinica">
               <?php
                    wp_list_pages(
                            array(
                                    'include'=> array(404),
                                    'exclude' => '',
                                    'title_li' => '<h2>' . _x('BUSCADOR DE CLÍNICAS', 'mapa-web-title', 'iol_theme') . '</h2>'
                                    )
                );
                ?>
               </ul>
               <ul class="lentesPremium">
               <?php
                    wp_list_pages(
                            array(
                                    'include'=> array(343),
                                    'exclude' => '',
                                    'title_li' => '<h2>' . _x('LENTES INTRAOCULARES PREMIUM', 'mapa-web-title', 'iol_theme') . '</h2>'
                                    )
                );
                ?>
               </ul>

               <ul class="resultados">
              <?php
              //Empezamos por reproducir el menú superior.
                wp_list_pages(
                            array(
                                    'include'=> array(2869,2881),
                                    'exclude' => '',
                                    'title_li' => '<h2>' . _x('RESULTADOS OPERACIÓN CON LIO', 'mapa-web-title', 'iol_theme') . '</h2>'
                                    )
                );

              ?>
               </ul>

           <!-- POSTS DEL BLOG -->
        <?php
            //for each category, show all posts
            $cat_args=array(
                            'orderby' => 'name',
                            'order' => 'ASC'
                            );
            $categories=get_categories($cat_args);

            foreach ($categories as $category) {
                $args=array(
                                'showposts' => -1,
                                'category__in' => array($category->term_id),
                                'ignore_sticky_posts'=>1,//caller_get_posts
                                'post_type'=>'post'
                                 );
                $postsWP = new WP_Query($args);
                $posts = $postsWP->get_posts();

                if ($posts) {
                    echo '<ul>';
                    echo '<li class="pagenav">';
                    echo '<h2><a href="' . get_category_link($category->term_id) . '" title="' . sprintf(__("View all posts in %s"), $category->name) . '" ' . '>' . $category->name.'</a> </h2> ';
                    echo '<ul>';
                    foreach ($posts as $post) {
                        setup_postdata($post); ?>

          <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                <?php the_title(); ?>
             </a>
          </li>

<?php
                    } // foreach($posts
                    echo '</ul>';
                    echo '</li>';
                    echo '</ul>';
                } // if ($posts
            } // foreach($categories
?>




            <!-- FIN POSTS DEL BLOG -->





             </div>

            <!-- Bloque de Tipos de Lio -->
		    <div class="siteMapBlock">
              <ul>
              <?php
              //Empezamos por reproducir el menú superior.
                wp_list_pages(
                            array(
                                    'include'=> array(245,269,264,289,248,260,274,285,278,281,283),
                                    'exclude' => '',
                                    'title_li' => '<h2>' . _x('TIPOS DE LENTES', 'Home Page', 'iol_theme') . '</h2>'
                                    )
                );

              ?>
               </ul>

                 <ul>
                  <?php

                  $argFabLinks      = array('post_type'=>_x('fabricante', 'CustomPostType Name', 'fabricante'),'posts_per_page' => -1);
                  $FabLinksWP       = new WP_Query($argFabLinks);
                  $FabLinksObjects  =  $FabLinksWP->get_posts();

                  if ($FabLinksObjects) : ?>
                  <li class="pagenav underMapBloq">
                      <h2>
                            <?php  echo _x('FABRICANTES', 'menu-site', 'iol_theme'); ?>
                      </h2>
                        <ul>
                          <?php foreach ($FabLinksObjects as $fablink) : ?>

                      <li><a href="<?php echo get_permalink($fablink->ID); ?>" title="<?php echo $fablink->post_title; ?>"> <?php echo $fablink->post_title; ?></a></li>
                      <?php endforeach; ?>
                        </ul>
                  </li>
                  <?php endif; ?>


               </ul>

                <!-- AÑADIMOS LAS LENTES QUE HAY -->

                           <ul>
                  <?php

                  $argIolLinks      = array('post_type'=>_x('lente-intraocular', 'CustomPostType Name', 'iol'),
                                            'posts_per_page' => -1,
                                            'orderby'=>'meta_value_num',
                                            'meta_key'=>'nivelPrefLenteMD',
                                            'order','DESC'
                                            );

                  $IolLinksWP       = new WP_Query($argIolLinks);
                  $IolLinksObjects  =  $IolLinksWP->get_posts();

                  if ($IolLinksObjects) : ?>
                  <li class="pagenav underMapBloq">
                      <h2>
                            <?php  echo _x('LENTES INTRAOCULARES', 'prefix-fab-slug', 'iol_theme'); ?>
                      </h2>
                        <ul>
                          <?php foreach ($IolLinksObjects as $iollink) : ?>

                      <li><a href="<?php echo get_permalink($iollink->ID); ?>" title="<?php echo $iollink->post_title; ?>"> <?php echo $iollink->post_title; ?></a></li>
                      <?php endforeach; ?>
                        </ul>
                  </li>
                  <?php endif; ?>


               </ul>

                <!-- Fin de las lentes que hay -->


             </div>





		    <div class="siteMapBlock">
                <ul class="surgeriesSiteMap">
              <?php
              //Cirugías
                wp_list_pages(
                            array(
                                    'include' => array( 104 , 109 , 111 , 3635 , 3634 , 116 , 107 ),
                                    'title_li' => '<h2>' . _x('CIRUGÍAS', 'mapa-web-title', 'iol_theme') . '</h2>'
                                    )
                );

              ?>
               </ul>

              <ul class="miOjoSiteMap underMapBloq">
              <?php
              //Cirugías
                wp_list_pages(
                            array(
                                    'include' => array( 317, 319 , 321 , 323  ),
                                    'title_li' => '<h2>' . _x('MI OJO', 'mapa-web-title', 'iol_theme') . '</h2>'
                                    )
                );

              ?>
               </ul>

            <!-- REDES SOCIALES -->
              <ul class="redesSocialesSiteMap underMapBloq">
              <?php
              //Cirugías
   $menu_name = 'Menu-footer2'; // Get the nav menu based on $menu_name (same as 'theme_location' or 'menu' arg to wp_nav_menu)

    if (($locations = get_nav_menu_locations()) && isset($locations[ $menu_name ])) {
        $menu = wp_get_nav_menu_object($locations[ $menu_name ]);

        $menu_items = wp_get_nav_menu_items($menu->term_id);

        $menu_items_IDs = wp_list_pluck($menu_items, 'ID');
//       var_dump($menu_items_IDs);
       /* foreach ( (array) $menu_items as $key => $menu_item ) {
            $title = $menu_item->ID;
            echo $title;
         }*/
    }

    //var_dump($menu_items_IDs);
              //Cirugías

                  ?>
                  <li class="pagenav underMapBloq">
                      <h2>
                            <?php  echo _x('REDES SOCIALES', 'menu-site', 'iol_theme'); ?>
                      </h2>
                        <ul>
                          <?php foreach ((array) $menu_items as $key => $menu_item) {
                      ?>

                      <li><a href="<?php  echo $menu_item->url; ?>" title="<?php echo $menu_item->title; ?>"> <?php echo $menu_item->title; ?></a></li>
                      <?php
                  } ?>
                        </ul>
                  </li>



               </ul>
            <!-- REDES SOCIALES  -->

            <!-- LEGAL -->
              <ul class="legalSiteMap underMapBloq">
              <?php
              //Cirugías
                wp_list_pages(
                            array(
                                    'include' => array( 24, 7682, 7683 , 4931 ),
                                    'title_li' => '<h2>' . _x('LEGAL', 'mapa-web-title', 'iol_theme') . '</h2>'
                                    )
                );

              ?>
               </ul>
            <!-- FIN LEGAL -->


             </div>
            <div style="clear: both; height: auto;">&nbsp;</div>
            <!-- <hr> -->

            <!-- Bloque de Tests -->
		    <div class="siteMapBlock">







             </div>

               <div class="siteMapBlock">


               </div>


			<?php endwhile; // end of the loop.?>




		</div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>
