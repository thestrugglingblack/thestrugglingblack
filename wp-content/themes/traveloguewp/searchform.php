<div id="travelogue-search" class="travelogue-search">
    <form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <input class="travelogue-search-input" value="<?php echo get_search_query(); ?>" placeholder="<?php _e( 'Enter your search term...', 'travelogue' ); ?>" type="text" name="s" id="search">
        <input class="travelogue-search-submit" id="searchsubmit" type="submit" value="<?php echo esc_attr_x( '', 'submit button' ); ?>" />
        <span class="travelogue-icon-search fa fa-search"></span>
    </form>
</div>