
<form role="search" method="get" id="searchform" class="searchform" action="<?php echo get_site_url().'/'; ?>">
	<div>
		<label class="screen-reader-text" for="s"><?php _x( 'Search for:', 'label' ); ?></label>
		<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" />
		<input type="hidden" value="post" name="post_type" />
		<input type="submit" id="searchsubmit" value="<?php echo __( 'Search'); ?>" />
	</div>
</form>
