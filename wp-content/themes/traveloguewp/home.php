<?php

get_header(); 

#Global Variable for Theme Options
global $travelogue_redux_options;

// Grid Class Small/Big
$travelogue_posts_layout = 'small';
if (isset($travelogue_redux_options['travelogue_posts_layout'])) {
    $travelogue_posts_layout = $travelogue_redux_options['travelogue_posts_layout'];
}

// Placeholder Big
$placeholder_big = 'http://placehold.it/965x320';
if (isset($travelogue_redux_options['placeholder_965x320']['url'])) {
    $placeholder_big = $travelogue_redux_options['placeholder_965x320']['url'];
}

// Placeholder Small
$placeholder_small = 'http://placehold.it/480x320'; 
if (isset($travelogue_redux_options['placeholder_480x320']['url'])) {
    $placeholder_small = $travelogue_redux_options['placeholder_480x320']['url']; 
}
?>

<article class="content">
    <div class="">
        <div class="grid" id="content">

        <?php
        ?>
        <?php if ( have_posts() ) : ?>

            <?php /* Start the Loop */ ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php 
                $post_subtitle          = get_post_meta( get_the_ID(), 'post_subtitle', true ); 
                $thumbnail_src_big      = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'travelogue_posts_965x320' );
                $thumbnail_src_small    = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'travelogue_posts_480x320' );
                    
                ?>

                <figure class="single-item-effect post <?php echo esc_attr($travelogue_posts_layout); ?>">
                    <?php if ( has_post_thumbnail()) { 
                        if ( $travelogue_posts_layout == 'small' ) { ?>
                            <img src="<?php echo esc_url($thumbnail_src_small[0]); ?>" alt="Featured image 1"/>
                        <?php }else{ ?>
                            <img src="<?php echo esc_url($thumbnail_src_big[0]); ?>" alt="Featured image 2"/>
                        <?php } 
                    }else{  
                        if ( $travelogue_posts_layout == 'small' ) { ?>
                            <img src="<?php echo esc_url($placeholder_small); ?>" alt="Featured image missing 3"/>
                        <?php }else{ ?>
                            <img src="<?php echo esc_url($placeholder_big); ?>" alt="Featured image missing 4"/>
                        <?php } 
                    } ?>
                    <figcaption>
                        <div class="figcaption-border">
                            <h2><?php the_title() ?></h2>
                            <p><?php echo esc_attr( $post_subtitle ); ?></p>
                            <a href="<?php the_permalink(); ?>"></a>
                            <div class="figure-overlay"></div>
                        </div>
                    </figcaption>                                               
                </figure>
                   
            <?php endwhile; ?>
        <?php else : ?>
            <?php get_template_part( 'content', 'none' ); ?>
        <?php endif; ?>


        <div class="travelogue-pagination">             
            <div class="travelogue-paginate" id="nav-below">
                <?php travelogue_pagination(); ?>
            </div>
        </div>
        </div>
    </div>
</article>

<?php
get_footer();
?>