	<?php

#Global Variable for Theme Options
global $travelogue_redux_options;

$travelogue_gallery_layout      = esc_attr( $travelogue_redux_options['travelogue_gallery_layout'] );
$gallery_placeholder_big        = esc_attr( $travelogue_redux_options['gallery_placeholder_965x320']['url'] );
$gallery_placeholder_small      = esc_attr( $travelogue_redux_options['gallery_placeholder_480x320']['url'] ); 
$gallery_placeholder_next_prev  = esc_attr( $travelogue_redux_options['gallery_placeholder_next_prev']['url'] ); 
$placeholder_1280x720           = esc_attr( $travelogue_redux_options['placeholder_1280x720']['url'] ); 


wp_reset_postdata();
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$args = array(
		'posts_per_page'   => -1,
		'post_type'        => 'gallery',
		'post_status'      => 'publish',
		'paged' => $paged,
		);
$gallery_items = get_posts($args);

?>


<!-- Gallery items -->
<article class="content">
	<div class="">
		<div id="grid-gallery" class="grid-gallery">

			<!-- Grid resized images -->
			<section class="grid-wrap">
				<div class="grid" id="isotope-container">
                <?php
                 foreach ($gallery_items as $gallery_item) { 
                    $terms = get_the_terms( $gallery_item->ID , 'gallery_category' ); 
                    $thumbnail_src_big = wp_get_attachment_image_src( get_post_thumbnail_id( $gallery_item->ID ), 'travelogue_posts_965x320' );
                    $thumbnail_src_small = wp_get_attachment_image_src( get_post_thumbnail_id( $gallery_item->ID ), 'travelogue_posts_480x320' );
                    ?> 

					<figure class="single-item-effect 
                    <?php echo $travelogue_gallery_layout; ?>
					<?php if ($terms) {
    						foreach ( $terms as $term ) {
    							echo $term->slug;
    						}
                        }
					?>">

                    <?php if ( has_post_thumbnail($gallery_item->ID)) { 
                        if ( $travelogue_gallery_layout == 'small' ) { ?>
                            <img src="<?php echo $thumbnail_src_small[0]; ?>" alt="Featured image 1"/>
                        <?php }else{ ?>
                            <img src="<?php echo $thumbnail_src_big[0]; ?>" alt="Featured image 2"/>
                        <?php } 
                    }else{  
                        if ( $travelogue_gallery_layout == 'small' ) { ?>
                            <img src="<?php echo $gallery_placeholder_small; ?>" alt="Featured image missing 3"/>
                        <?php }else{ ?>
                            <img src="<?php echo $gallery_placeholder_big; ?>" alt="Featured image missing 4"/>
                        <?php } 
                    } ?>

						<figcaption>
							<div class="figcaption-border">
								<h2><?php echo $gallery_item->post_title; ?></h2>
								<p>
                                    <?php
                                        $excerpt = get_post_field('post_content', $gallery_item->ID);
                                        echo travelogue_post_excerpt_limit($excerpt,20);
                                    ?></p>
								<div class="figure-overlay"></div>
							</div>
						</figcaption>												
					</figure>
                <?php } ?>
				</div>
			</section>


			<!-- Grid full images -->
			<section class="slideshow">
				<ul>
				<?php foreach ($gallery_items as $gallery_item) { 
                    $terms = get_the_terms( $gallery_item->ID , 'gallery_category' );
					$thumbnail_src_full = wp_get_attachment_image_src( get_post_thumbnail_id( $gallery_item->ID ), 'full' );
				?>
					<li class="<?php if ($terms) { foreach ( $terms as $term ) { echo $term->slug; } } ?>">
						<figure>
							<figcaption>
								<h2><?php echo $gallery_item->post_title; ?></h2>
								<p><?php echo get_post_field('post_content', $gallery_item->ID); ?></p>
							</figcaption>

                            <?php if ( has_post_thumbnail($gallery_item->ID)) { ?>
                                <img src="<?php echo $thumbnail_src_full[0]; ?>" alt="Featured image 1"/>
                            <?php }else{ ?>
                                <img src="<?php echo $placeholder_1280x720; ?>" alt="Featured image missing 2"/>
                            <?php } ?>
						</figure>
					</li>
				<?php } ?>
				</ul>

				<!-- Preview items -->
				<nav class="gallery-nav">
					<div class="prev-container">									
						<ul>
						<?php foreach ($gallery_items as $gallery_item) { 
                            $terms = get_the_terms( $gallery_item->ID , 'gallery_category' ); 
							$travelogue_gallery_90x90 = wp_get_attachment_image_src( get_post_thumbnail_id( $gallery_item->ID ), 'travelogue_gallery_90x90' );
						?>
							<li class="<?php if ($terms) { foreach ( $terms as $term ) { echo $term->slug; } } ?>">
								<div>
									<p class="gallery-title"><?php echo $gallery_item->post_title; ?></p>
									<p class="gallery-subtitle"><?php echo get_post_field('post_content', $gallery_item->ID); ?></p>
								</div>

                                <?php if ( has_post_thumbnail($gallery_item->ID)) { ?>
                                    <img src="<?php echo $travelogue_gallery_90x90['0']; ?>" alt="Featured image 1"/>
                                <?php }else{ ?>
                                    <img src="<?php echo $gallery_placeholder_next_prev; ?>" alt="Featured image missing 2"/>
                                <?php } ?>
							</li>
						<?php } ?>
						</ul>
						<span class="icon nav-prev"></span>
					</div>
					<!-- Next items -->
					<div class="nex-container">									
						<ul>
						<?php foreach ($gallery_items as $gallery_item) {
                            $terms = get_the_terms( $gallery_item->ID , 'gallery_category' ); 
							$travelogue_gallery_90x90 = wp_get_attachment_image_src( get_post_thumbnail_id( $gallery_item->ID ), 'travelogue_gallery_90x90' );
						?>
							<li class="<?php if ($terms) { foreach ( $terms as $term ) { echo $term->slug; } } ?>">
								<div>
									<p class="gallery-title"><?php echo $gallery_item->post_title; ?></p>
									<p class="gallery-subtitle"><?php echo get_post_field('post_content', $gallery_item->ID); ?></p>
								</div>
                                <?php if ( has_post_thumbnail($gallery_item->ID)) { ?>
                                    <img src="<?php echo $travelogue_gallery_90x90['0']; ?>" alt="Featured image 1"/>
                                <?php }else{ ?>
                                    <img src="<?php echo $gallery_placeholder_next_prev; ?>" alt="Featured image missing 2"/>
                                <?php } ?>
							</li>
						<?php } ?>
						</ul>
						<span class="icon nav-next"></span>
					</div>
					<span class="icon nav-close"></span>
				</nav>
				<div class="info-keys icon"></div>
			</section>
		</div>
	</div>
</article>



<!-- Filter NAV's -->
<div id="filter-nav">
	<nav id="filter-main-nav">
		<ul>
			<li><a href="#" data-filter="*"><?php echo esc_attr__('All', 'travelogue'); ?></a></li>
			<?php 
				$gallery_categories = get_terms( 'gallery_category' );
				if ( ! empty( $gallery_categories ) && ! is_wp_error( $gallery_categories ) ){
					foreach ( $gallery_categories as $gallery_category ) { ?>
						<li><a href="#" data-filter=".<?php echo $gallery_category->slug; ?>"><?php echo $gallery_category->name; ?></a></li>
					<?php }
				}
			?>
			<li class="filter-title"><?php echo esc_attr__('Filters', 'travelogue'); ?></li>
		</ul>
	</nav>
	<a href="#" class="filter-nav-trigger"><span class="fa fa-filter"></span></a>
</div>
<?php wp_reset_query(); ?> 