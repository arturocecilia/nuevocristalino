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
	</div><!-- #main .wrapper -->
    </div><!-- #page -->
    <div id="line-footer-blog"></div>
    <div id="footer-wrap-blog">
        <footer id="colophon" role="contentinfo">
            <div class="site-info-qa">
                <?php  wp_nav_menu(array('theme_location'=>'Menu-footer')); ?>
            </div><!-- .site-info -->
            <div id="logos">
            	<a href="http://www.andomed.com"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/footer/andomed-logo-footer.png" alt="logo Andomed" /></a>
                <!--<div id="redes"> -->
                    <!--<a href="#"><img src="<?php //bloginfo('template_directory'); ?>/images/footer/twitter-nuevo-cristalino.png" alt="twitter Nuevo Cristalino" /></a>
                    <a href="#"><img src="<?php //bloginfo('template_directory'); ?>/images/footer/facebook-nuevo-cristalino.png" alt="facebook Nuevo Cristalino" /></a>
                    <a href="#"><img src="<?php //bloginfo('template_directory'); ?>/images/footer/youtube-nuevo-cristalino.png" alt="youtube Nuevo Cristalino" /></a> -->
                 <!--</div> -->
                
            </div>
        </footer><!-- #colophon -->
    </div>


<?php wp_footer(); ?>
</body>
</html>