<?php
/*
* Template Name: Dynamic Blog
*/
get_header(); 

#Global Variable for Theme Options
global $travelogue_redux_options;

$travelogue_posts_layout    = esc_attr( $travelogue_redux_options['travelogue_posts_layout'] );
$placeholder_big            = esc_attr( $travelogue_redux_options['placeholder_965x320']['url'] );
$placeholder_small          = esc_attr( $travelogue_redux_options['placeholder_480x320']['url'] ); 

?>

<article class="content">
    <div class="">
        <div class="grid" id="content">

<?php
wp_reset_postdata();
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$args = array(
        'posts_per_page'   => -1,
        'post_type'        => 'post',
        'post_status'      => 'publish',
        'paged' => $paged,
        );
$posts = new WP_Query( $args );
//$posts = get_posts($args);
?>
        <?php if ( $posts->have_posts() ) : ?>

            <?php /* Start the Loop */ ?>
            <?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
                <?php 
                $post_subtitle          = get_post_meta( get_the_ID(), 'post_subtitle', true ); 
                $thumbnail_src_big      = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'travelogue_posts_965x320' );
                $thumbnail_src_small    = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'travelogue_posts_480x320' );
                    
                ?>

                <figure class="single-item-effect post <?php echo $travelogue_posts_layout; ?>">
                    <?php if ( has_post_thumbnail()) { 
                        if ( $travelogue_posts_layout == 'small' ) { ?>
                            <img src="<?php echo $thumbnail_src_small[0]; ?>" alt="Featured image 1"/>
                        <?php }else{ ?>
                            <img src="<?php echo $thumbnail_src_big[0]; ?>" alt="Featured image 2"/>
                        <?php } 
                    }else{  
                        if ( $travelogue_posts_layout == 'small' ) { ?>
                            <img src="<?php echo $placeholder_small; ?>" alt="Featured image missing 3"/>
                        <?php }else{ ?>
                            <img src="<?php echo $placeholder_big; ?>" alt="Featured image missing 4"/>
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