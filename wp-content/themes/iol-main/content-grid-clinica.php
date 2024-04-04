
<div id="iolGridWrapper" class="clinicaTemplate">
    <a class="iolGridUnit startsUgly" href="<?php the_permalink();?>">
        <div class="iolGridImage">		
                <?php the_post_thumbnail(); ?>
        </div>
        
        <div class="iolGridTitle">
            <?php the_title(); ?>
        </div>
        <?php  $postID = get_the_ID(); ?> 
        <div class="iolGridFabricante">
    
        <?php echo _x('Ubicación:','Content Grid Clinica','iol_theme').strip_tags(get_the_term_list($postID, _x('ubicacion','taxo-name','clinica'))); ?>
        </div>
    </a>
</div>