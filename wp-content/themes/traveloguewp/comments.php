<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package travelogue
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area travelogue_comments comments">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) { ?>
		<h2 class="comments-title">
			<?php
				printf( _nx( '<span class="green">1 comment </span><span class="black">so far</span>', '<span class="green">%1$s comments </span><span class="black">so far</span>', get_comments_number(), 'comments title', 'travelogue' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'travelogue' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'travelogue' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'travelogue' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<div class="comment-list">
			<?php wp_list_comments( 'type=comment&callback=travelogue_custom_comments' ); ?>
		</div><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'travelogue' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'travelogue' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'travelogue' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php } // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'travelogue' ); ?></p>
	<?php endif; ?>

	<div class="travelogue_comment_form">
		<!-- <h2><span class="green">Submit </span><span class="black">a comment</span></h2> -->
		<?php 
			$args = array(
			  'id_form'           => 'commentform',
			  'id_submit'         => 'submit',
			  'title_reply'       => __( 'Leave a <span class="green">Reply</span>' ),
			  'title_reply_to'    => __( 'Leave a <span class="green">Reply to %s</span>' ),
			  'cancel_reply_link' => __( 'Cancel <span class="green">Reply</span>' ),
			  'label_submit'      => __( 'Post Comment' ),

			  'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) .
			    '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
			    '</textarea></p>',

			  'must_log_in' => '<p class="must-log-in">' .
			    sprintf(
			      __( 'You must be <a href="%s">logged in</a> to post a comment.' ),
			      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
			    ) . '</p>',

			  'logged_in_as' => '<p class="logged-in-as">' .
			    sprintf(
			    __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
			      admin_url( 'profile.php' ),
			      $user_identity,
			      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
			    ) . '</p>',

			  'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.' ) . '</p>',

			  'comment_notes_after' => '<p class="form-allowed-tags">' .
			    sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ),
			      ' <code>' . allowed_tags() . '</code>'
			    ) . '</p>',

			  'fields' => apply_filters( 'comment_form_default_fields', array(


			    'author' =>
			      '<li>' .
			      '<span><label for="author">' . __( 'What\'s your name?', 'travelogue' ) . '</label></span>' .
			      '<input class="focus-me" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
			      '" size="30" /><li>',
			    'email' =>
			      '<li class="one_half comment_email">' .
			      '<span><label for="email">' . __( 'What\'s your email address?', 'travelogue' ) . '</label></span>' .
			      '<input class="focus-me" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
			      '" size="30" /><li>',
			    'url' =>
			      '<li class="one_half comment_url">' .
			      '<span><label for="url">' . __( 'What\'s your website?', 'travelogue' ) . '</label></span>' .
			      '<input class="focus-me" id="url" name="url" type="text" value="' . esc_attr(  $commenter['comment_author_url'] ) .
			      '" size="30" /><li>'
			    )
			  ),
			);
			 
			comment_form($args);
		?>
	</div>



</div><!-- #comments -->