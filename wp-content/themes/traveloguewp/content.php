<?php
/**
 * @package travelogue
 */

#Post width
if(is_category() || is_tag() || is_search() || is_author() || is_archive()){
    $post_width = 'big';
}else{
	$post_width = 'small';
}

#Global Variable for Theme Options
global $travelogue_redux_options;

$post_subtitle = get_post_meta( get_the_ID(), 'post_subtitle', true );
$placeholder_big   = esc_attr( $travelogue_redux_options['placeholder_965x320']['url'] );
$placeholder_small = esc_attr( $travelogue_redux_options['placeholder_480x320']['url'] ); 

?>

<figure class="single-item-effect <?php echo $post_width; ?>">
<?php 
$post_subtitle          = get_post_meta( get_the_ID(), 'post_subtitle', true ); 
$thumbnail_src_big      = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'travelogue_posts_965x320' );
$thumbnail_src_small    = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'travelogue_posts_480x320' );
    
?>

<?php if ( has_post_thumbnail() ) {  ?>
    <img src="<?php echo $thumbnail_src_small[0]; ?>" alt="Featured image"/>
<?php }else{ ?>
    <img src="<?php echo $placeholder_small; ?>" alt="Featured image missing"/>
<?php } ?>
    <figcaption>
        <div class="figcaption-border">
            <h2><?php the_title() ?></h2>
            <p><?php echo $post_subtitle; ?></p>
            <a href="<?php the_permalink(); ?>"></a>
            <div class="figure-overlay"></div>
        </div>
    </figcaption>                                               
</figure>

