<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

   <div class="archive-clinica-wrapper">

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	

     <?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'twentytwelve' ); ?>
		</div>
		<?php endif; ?>
		<div class="entry-header clinica-entry-header">
            <div class="featured-clinica-archive-image">			
                <?php the_post_thumbnail(); ?>
			</div>
            <?php if ( is_single() ) : ?>
            <div class="title-clinica-archive">
			<h1 class="entry-title"><?php the_title(); ?></h1>
            </div>
			<?php else : ?>
            <div class="title-clinica-archive">
                <!--
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
                -->
            </div>
			<?php endif; // is_single() ?>
			<?php if ( comments_open() ) : ?>
				<div class="comments-link">
					<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'twentytwelve' ) . '</span>', __( '1 Reply', 'twentytwelve' ), __( '% Replies', 'twentytwelve' ) ); ?>
				</div><!-- .comments-link -->
			<?php endif; // comments_open() ?>
		</div><!-- .entry-header -->

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">

			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content clinica-entry-content">
            <h1 class="archive-clinica-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>

            <!-- Metemos los metadatos que queremos que salgan en la búsqueda-->
            <?php 
             $id = get_the_ID();
             
             echo '<div class="clinica-metadata">'; 
			 //echo '<span class="clinica-meta-value">'.get_the_title().'</span>';
             echo '<div style="height:0px;clear:both;">&nbsp;</div>';
             echo '<span class="clinicTitle">'._x("Dirección:","Content Clinica","clinica_cpt_display").' </span><span class="clinica-meta-value">'.get_post_meta( $id, 'direccionD',TRUE).'</span>';
             echo '<div style="height:0px;clear:both;">&nbsp;</div>';
             echo '<span class="clinicTitle">'._x("Telefóno de Contacto:","Content Clinica","clinica_cpt_display").'</span><span class="clinica-meta-value">'.get_post_meta( $id, 'telfContactoD',TRUE).'</span>';
             echo '<div style="height:0px;clear:both;">&nbsp;</div>';
             echo '<span class="clinicTitle">'._x("Horario:","Content Clinica","clinica_cpt_display").'</span><span class="clinica-meta-value">'.get_post_meta( $id, 'horarioD',TRUE).'</span>';
             echo '<div style="height:0px;clear:both;">&nbsp;</div>';
             /*A continuación ponemos la información de más clínicas del grupo*/
             
             //Si la clínica tiene hijos:
			
			$args = array(
						'post_parent' => $id,
						'post_type' => _x('clinica','CustomPostType Name','clinica'),
						);

			$child_Clinics = get_children( $args );
			$prov_child_clinics= array();
			
			if($child_Clinics){
				echo '<div class="clinicChilds">';		
			    echo '<span class="provTitle">'._x('Clínicas en: ','Content Archive Clinica','iol_theme').'&nbsp;</span>';
			 //wp_list_pluck($child_clinics, '');
				foreach($child_Clinics as $clinic){
					$prov_child_clinics[] = strip_tags(get_the_term_list( $clinic->ID, _x('ubicacion','taxo-name','clinica')));		
					}
					$resultProv = array_unique($prov_child_clinics);
					echo '<span class="clinica-meta-value">'.implode ( '&nbsp;,' , $resultProv ).'</span>';
					
             	
             	echo '</div>';
             }
             /* */
             echo '<div style="height:0px;clear:both;">&nbsp;</div>';
             echo '</div>';


            ?>


			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
	
            
         <div class="clinica-entry-meta">
           <a href="<?php the_permalink(); ?>"><?php _x('Ver más información de la clínica','Content Archive Clinica','iol_theme'); ?> </a>
			<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->

            
            </div><!-- .entry-content -->
		<?php endif; ?>


        <div style="clear: both; height: 0px;">&nbsp;</div>
	</div><!-- #post -->
        <div style="clear: both; height: 0px;">&nbsp;</div>
</div>