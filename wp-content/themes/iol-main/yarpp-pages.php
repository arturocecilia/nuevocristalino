<?php
/*
YARPP Template: Pages
Author: mitcho (Michael Yoshitaka Erlewine)
Description: A simple example YARPP template.
*/

?>

<?php if (have_posts()) {
    ?>

	<div class="leftmenutitlewrapper">
	<span class="priorleftmenutitle">&nbsp;</span>
<h3 id="yarppQuestions" class="yarppTitle"><?php echo _x('Contenidos Relacionados:', 'yarpp', 'iol_theme'); ?></h3>
<span class="afterleftmenutitle">&nbsp;</span>
</div>


<?php if (have_posts()):?>
<ol>
	<?php while (have_posts()) : the_post(); ?>
	<li class="yarppPagesItems yarppItems">
 <?php
          /*$args = array(
                        'post_type' => 'attachment',
                        'numberposts' => 1,
                        'post_status' => null,
                        'post_parent' => $post->ID
            );

  $attachments = get_posts( $args );

     if ( $attachments ) {

           $imgAttach = wp_get_attachment_image( $attachments[0]->ID, array(32,32), FALSE );
       }
       else{
           $imgAttach="";
       }*/
     ?>

        <a href="<?php the_permalink() ?>" rel="bookmark" >
            <?php /*echo $imgAttach;*/ ?> <span class="text"><?php the_title(); ?></span>
        </a><!-- (<?php the_score(); ?>)--></li>
	<?php endwhile; ?>
</ol>
<?php else: ?>
<p>No related posts.</p>
<?php endif; ?>
<?php
}?>
