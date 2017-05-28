<?php
/**
 * The template for displaying all single posts.
 *
 * @package travelogue
 */

get_header(); ?>


<?php while ( have_posts() ) : the_post(); ?>

    <article <?php post_class('content-area content '); ?> id="post-<?php the_ID(); ?>">

		<?php get_template_part( 'content', 'single' ); ?>

        <?php
            wp_link_pages( array(
                'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'travelogue' ) . '</span>',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
            ) );
        ?>

        <?php
            // If comments are open or we have at least one comment, load up the comment template
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
        ?>
    </article>

    <div class="divider_30"></div>

    <?php $prev_post = get_previous_post(); ?>
    <?php $next_post = get_next_post(); ?>

    <div class="pagination grid">
        <?php if($prev_post){ ?>
        <figure class="single-item-effect half">
            <?php if(get_the_post_thumbnail($prev_post->ID, 'travelogue_posts_965x320')){
                echo get_the_post_thumbnail($prev_post->ID, 'travelogue_posts_965x320');
            }else{ ?>
                <img src="http://placehold.it/965x350/7f8c8d/ffffff" alt="Featured image missing"/>
            <?php } ?>
            <figcaption>
                <div class="figcaption-border">
                    <h2><i class="fa fa-angle-left"></i> <?php echo __('Previous ','travelogue'); ?><span><?php echo __('Post','travelogue'); ?></span></h2>
                    <p><?php echo get_the_title( $prev_post->ID ); ?></p>
                    <a href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php echo __('View more ','travelogue'); ?></a>
                    <div class="figure-overlay"></div>
                </div>
            </figcaption>
        </figure>
        <?php } ?>
        <?php if($next_post){ ?>
        <figure class="single-item-effect half">
            <?php if(get_the_post_thumbnail($next_post->ID, 'travelogue_posts_965x320')){
                echo get_the_post_thumbnail($next_post->ID, 'travelogue_posts_965x320');
            }else{ ?>
                <img src="http://placehold.it/965x350/7f8c8d/ffffff" alt="Featured image missing"/>
            <?php } ?>
            <figcaption>
                <div class="figcaption-border">
                    <h2><?php echo __('Next ','travelogue'); ?><span><?php echo __('Post','travelogue'); ?></span> <i class="fa fa-angle-right"></i> </h2>
                    <p><?php echo get_the_title( $next_post->ID ); ?></p>
                    <a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo __('View more ','travelogue'); ?></a>
                    <div class="figure-overlay"></div>
                </div>
            </figcaption>
        </figure>
        <?php } ?>
        <div class="clearfix"></div>
    </div>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>