<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>


<?php 
/*-- Algunas trads --*/

$locale = get_locale();

$lang = substr($locale,0,2);

switch ($lang) {
    case 'es':
        $austria = 'Austria';
        $usa = 'EE.UU';
        break;
    case 'en':
        $austria = 'Austria';
        $usa = 'USA';
        break;
    case 'de':
        $austria = 'Österreich';
        $usa = 'USA';
        break;
    case 'fr':
        $austria = 'Autriche';
        $usa = 'USA';
        break;

}

?>




	</div><!-- #main .wrapper -->
    </div><!-- #page -->
    <div id="line-footer-forum"></div>
    <div id="footer-wrap-forum">
    	<div id="gradient-footer"></div>
            <footer id="colophon" role="contentinfoforum">
                <div class="site-info-forum">
                	<div class="list-footer-forum" id="list-topic-forum">
                    	<h3><?php echo _x('Popular Topics', 'Footer Forum','iol_theme'); ?></h3>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/footer/footer-sep.png" alt="widget1" />
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('widget1-forum-footer') ) : ?> <?php endif; ?>  
                    </div>
                    <div class="list-footer-forum" id="list-forum">
                    	<h3><?php echo _x('Foros Nuevo Cristalino', 'Footer Forum','iol_theme'); ?></h3>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/footer/footer-sep.png" alt="separator" />
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('widget2-forum-footer') ) : ?><?php endif; ?> 
                    </div>
                    <div class="list-footer-forum" id="list-countries-forum">
                    	<h3><?php echo _x('Dónde está Nuevo Cristalino','Footer Forum','iol_theme'); ?></h3>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/footer/footer-sep.png" alt="separator" />
                        <ul>
                        	<li><a href="http://www.neuelinsen.com"><?php echo _x('Alemania', 'Footer Forum','iol_theme'); ?></a></li>
                            <li><a href="http://www.nuevocristalino.mx"><?php echo 'México';?></a></li>
                            <li><a href="http://www.newlens.co.uk"><?php echo _x('Inglaterra', 'Footer Forum','iol_theme'); ?></a></li>
                            <li><a href="http://www.nuevocristalino.cl"><?php echo _x('Chile', 'Footer Forum','iol_theme'); ?></a></li>
                            <li><a href="http://www.nuevocristalino.co"><?php echo _x('Colombia', 'Footer Forum','iol_theme'); ?></a></li>
														<li><a href="http://www.neuelinsen.at"><?php echo $austria; ?></a></li>
														<li><a href="http://www.mylifestylelens.com"><?php echo $usa; ?></a></li>
                            <!-- <li><a href="#"><?php echo _x('Polonia', 'Footer Forum','iol_theme')?></a></li> -->
                        </ul>
                    </div>
					<div id="list-about-forum">
                    	<h3><?php echo _x('Más Sobre Nuevo Cristalino','Footer Forum','iol_theme'); ?></h3>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/footer/footer-sep.png" alt="logo Andomed" />
                    	<?php  wp_nav_menu(array('theme_location'=>'Menu-footer')); ?>
                        <a href="http://www.andomed.com"><img class="logo-footer" src="<?php echo get_stylesheet_directory_uri(); ?>/images/footer/andomed.png" alt="Andomed" /></a>
                    </div>
                </div><!-- .site-info -->
            </footer><!-- #colophon -->
        <div id="gradient-bottom-footer"></div>
    </div>


<?php wp_footer(); ?>
</body>
</html>