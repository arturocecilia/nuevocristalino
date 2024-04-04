<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>

		<div class="entry-content">
            
			<?php the_content(); ?>
		
		
		
		<div class="downloadLink">
	<!-- [download_link_extended] -->
	
<?php
	$download = 'Download'; //'Herunterladen';	//Download
	
	switch(get_locale()){
		case 'de_DE':
		$download = 'Herunterladen';
		break;
		case  'es_ES':
		$download = 'Descargar';
		break;
	}
	

?>
	<a href="<?php echo get_permalink(get_the_ID()).'/?wpdmdl='.get_the_ID(); ?>"> <?echo $download; ?></a>
	</div>	
		
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<footer class="entry-meta">
		</footer><!-- .entry-meta -->
 			<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
	</article><!-- #post -->