<?php 

# Custom Comments

function travelogue_custom_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'div';
        $add_below = 'div-comment';
    }
?>
    <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body fullwidth single_comment parent">
    <?php endif; ?>
    <div class="comment-author vcard one_sixth comment_author">
    <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, 130 ); ?>
    <?php printf( __( '<div class="author_name text-center">%s</div>' ), get_comment_author_link() ); ?>
    </div>
    <?php if ( $comment->comment_approved == '0' ) : ?>
        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
        <br />
    <?php endif; ?>

    <div class="comment-meta commentmetadata sixth_one comment_body relative">
        <?php comment_text(); ?>
        <span class="date">
        <?php
            /* translators: 1: date, 2: time */
            printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?><?php edit_comment_link( __( '(Edit)' ), '  ', '' );
        ?>
        </span>
        <div class="reply_button green float-right">
            <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        </div>
    </div>
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <div class="clearfix"></div>
    <?php endif; ?>
<?php } ?>