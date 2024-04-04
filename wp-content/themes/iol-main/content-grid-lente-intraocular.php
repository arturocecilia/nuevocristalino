
<div id="iolGridWrapper">
    <a class="iolGridUnit startsUgly nWindIol" target="_blank" href="<?php the_permalink();?>">
        <div class="iolGridImage">		
                <?php the_post_thumbnail(); ?>
        </div>
        
        <div class="iolGridTitle">
            <?php the_title(); ?>
        </div>
        <?php  $postID = get_the_ID(); ?> 
        <div class="iolGridFabricante">
    
        <?php echo _x('Fabricante:','Content Grid','iol_theme').strip_tags(get_the_term_list($postID, _x('fabricante-lente','taxo-name','iol'))); ?>
        </div>
    </a>
</div>