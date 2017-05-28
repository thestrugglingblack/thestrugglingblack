<?php
/* Custom metabox for Pages */

function travelogue_page_add_meta_box() {

    add_meta_box( 'page-options', __( 'Page Options', 'travelogue' ), 'travelogue_show_metabox_callback', 'page', 'normal', 'high' );

}
add_action( 'add_meta_boxes', 'travelogue_page_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function travelogue_show_metabox_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'page_options_nonce', 'page_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */

    $title                      = get_post_meta( $post->ID, 'title'                         , true );
    $subtitle                   = get_post_meta( $post->ID, 'subtitle'                      , true );
    $custom_class               = get_post_meta( $post->ID, 'travelogue-custom-class'       , true );
    $effect                     = get_post_meta( $post->ID, 'travelogue-header-effect'      , true );
    $select_bg_video_revslider  = get_post_meta( $post->ID, 'select_bg_video_revslider'     , true );
    $select_revslider_shortcode = get_post_meta( $post->ID, 'select_revslider_shortcode'    , true );
    $hide_title_subtitle        = get_post_meta( $post->ID, 'hide_title_subtitle'           , true );
    $youtube_video_id           = get_post_meta( $post->ID, 'travelogue-youtube-video-id'   , true );
    $youtube_video_start_at     = get_post_meta( $post->ID, 'travelogue-youtube-start-at'   , true );
    $youtube_video_mute         = get_post_meta( $post->ID, 'travelogue-youtube-mute'       , true );


    echo "<div class='avstudio-metabox'>";

    echo "<style>";
    echo ".metabox-page { float:left;width:100%;padding:10px 0 }";
    echo ".metabox-page label { margin-right:20px;font-weight:bold;width:20%;display:inline-block }";
    echo ".metabox-page .left { margin-right:20px;width:20%;float:left}";
    echo ".metabox-page .right { width:70%;float:left}";
    echo "</style>";

    echo "<div class='metabox-page'>";
    echo "<label for='title-field'>".__( 'Title', 'travelogue' )."</label>";
    echo '<input type="text" name="title-fields" value="' . esc_attr( $title ) . '" size="70" />';
    echo "</div>";

    echo "<div class='metabox-page'>";
    echo "<label for='subtitle-field'>".__( 'Subtitle', 'travelogue' )."</label>";
    echo '<input type="text" name="subtitle-fields" value="' . esc_attr( $subtitle ) . '" size="70" />';
    echo "</div>";

    echo "<div class='metabox-page'>";
    echo "<label for='travelogue-custom-class'>".__( 'Custom Class', 'travelogue' )."<br /><small>".__( 'Note: Custom class will be added to <body>.', 'travelogue' )."</small></label>";
    echo '<input type="text" name="travelogue-custom-class" value="' . esc_attr( $custom_class ) . '" size="70" />';
    echo "</div>";

    echo "<div class='metabox-page'>";
    echo "<label for='subtitle-field'>".__( 'Header Effect', 'travelogue' )."<br /><small>".__( 'Note: Set the transition between header and the content of the page.', 'travelogue' )."</small></label>";
    echo '<select name="effect">';
    echo '<option value="intro-effect-grid" '.($effect == 'intro-effect-grid' ? 'selected=""' : '').'>Default - Intro Effect Grid</option>';
    echo '<option value="none" '.($effect == 'none' ? 'selected=""' : '').'>None</option>';
    echo '<option value="intro-effect-push" '.($effect == 'intro-effect-push' ? 'selected=""' : '').'>Intro Effect Push</option>';
    echo '<option value="intro-effect-sidefixed" '.($effect == 'intro-effect-sidefixed' ? 'selected=""' : '').'>Intro Effect Sidefixed</option>';
    echo '<option value="intro-effect-side" '.($effect == 'intro-effect-side' ? 'selected=""' : '').'>Intro Effect Side</option>';
    echo '<option value="intro-effect-fadeout" '.($effect == 'intro-effect-fadeout' ? 'selected=""' : '').'>Intro Effect Fadeout</option>';
    echo '<option value="intro-effect-jam3" '.($effect == 'intro-effect-jam3' ? 'selected=""' : '').'>Intro Effect Jam</option>';
    echo '</select>';
    echo "</div>";

    echo "<div class='metabox-page'>";
    echo "<label for='hide_title_subtitle'>".__( 'Show title and subtitle', 'travelogue' )."<br /><small>".__( 'Note: Show or hide title and subtitle from full-header section.', 'travelogue' )."</small></label>";
    echo '<select id="hide_title_subtitle" name="hide_title_subtitle">';
    echo '<option value="yes" '.($hide_title_subtitle == 'yes' ? 'selected=""' : '').'>Yes</option>';
    echo '<option value="no" '.($hide_title_subtitle == 'no' ? 'selected=""' : '').'>No</option>';
    echo '</select>';
    echo "</div>";

    echo "<div class='metabox-page'>";
    echo "<label for='select_bg_video_revslider'>".__( 'Background type', 'travelogue' )."<br /><small>".__( 'Note: Header image/video or revolution slider.', 'travelogue' )."</small></label>";
    echo '<select id="select_bg_video_revslider" name="select_bg_video_revslider">';
    echo '<option value="bg_image" '.($select_bg_video_revslider == 'bg_image' ? 'selected=""' : '').'>Image Background - Default</option>';
    echo '<option value="bg_video" '.($select_bg_video_revslider == 'bg_video' ? 'selected=""' : '').'>Video Background - YouTube Video</option>';
    echo '<option value="bg_revslider" '.($select_bg_video_revslider == 'bg_revslider' ? 'selected=""' : '').'>Revolution Slider Background</option>';
    echo '</select>';
    echo "</div>";










    echo "<div class='bg_video_inputs_group'>";
    echo "<div class='metabox-page'>";
    echo "<label for='travelogue-youtube-video-id'>".__( 'YouTube Video ID', 'travelogue' )."<br /><small>".__( 'Note: Leave this field empty to disable Video on background.', 'travelogue' )."</small></label>";
    echo '<input type="text" name="travelogue-youtube-video-id" value="' . esc_attr( $youtube_video_id ) . '" size="70" />';
    echo "</div>";

    echo "<div class='metabox-page'>";
    echo "<label for='travelogue-youtube-start-at'>".__( 'Video Start At', 'travelogue' )."<br /><small>".__( 'Note: Eg: 4 - The video will start from the 4th second.', 'travelogue' )."</small></label>";
    echo '<input type="text" name="travelogue-youtube-start-at" value="' . esc_attr( $youtube_video_start_at ) . '" size="70" />';
    echo "</div>";

    echo "<div class='metabox-page'>";
    echo "<label for='travelogue-youtube-mute'>".__( 'Mute Video', 'travelogue' )."<br /><small>".__( 'Enable or Disable sound of YouTube video background.', 'travelogue' )."</small></label>";
    echo '<select name="travelogue-youtube-mute">';
    echo '<option value="true" '.($youtube_video_mute == 'true' ? 'selected=""' : '').'>Yes - Mute Audio</option>';
    echo '<option value="false" '.($youtube_video_mute == 'false' ? 'selected=""' : '').'>No - Unmute Audio</option>';
    echo '</select>';
    echo "</div>";
    echo "</div>";

    global $wpdb;
    $limit_small    = 0;
    $limit_high     = 50;
    $tablename      = $wpdb->prefix . "revslider_sliders";
    $sql            = $wpdb->prepare( "SELECT * FROM $tablename LIMIT %d, %d", $limit_small, $limit_high);
    $sliders        = $wpdb->get_results($sql, ARRAY_A);

    // echo $wpdb->prefix;
    
    echo "<div class='bg_revslider_inputs_group'>";
    echo "<div class='metabox-page'>";
    echo "<label for='select_revslider_shortcode'>".__( 'Select Revolution Slider', 'travelogue' )."</label>";
    echo '<select id="select_revslider_shortcode" name="select_revslider_shortcode">';
    echo '<option>Choose a slider</option>';
    foreach($sliders as $slide){
        echo $slide['alias'];
        echo '<option value="'.$slide['alias'].'" '.($select_revslider_shortcode == $slide['alias'] ? 'selected=""' : '').'>'.$slide['title'].'</option>';
    }
    echo "</select>";
    echo "</div>";
    echo "</div>";


    echo "<div style='clear:both'></div>";
    echo "</div>";
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function travelogue_save_page_meta_box( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['page_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['page_nonce'], 'page_options_nonce' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Sanitize user input.
    $subtitle                   = sanitize_text_field( $_POST['subtitle-fields'] );
    $title                      = sanitize_text_field( $_POST['title-fields'] );
    $custom_class               = sanitize_text_field( $_POST['travelogue-custom-class'] );
    $youtube_video_id           = sanitize_text_field( $_POST['travelogue-youtube-video-id'] );
    $youtube_video_start_at     = sanitize_text_field( $_POST['travelogue-youtube-start-at'] );
    $youtube_video_mute         = sanitize_text_field( $_POST['travelogue-youtube-mute'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'subtitle'                      , $subtitle );
    update_post_meta( $post_id, 'title'                         , $title );
    update_post_meta( $post_id, 'travelogue-custom-class'       , $custom_class );
    update_post_meta( $post_id, 'travelogue-header-effect'      , sanitize_text_field( $_POST['effect'] ) );
    update_post_meta( $post_id, 'select_revslider_shortcode'    , sanitize_text_field( $_POST['select_revslider_shortcode'] ) );
    update_post_meta( $post_id, 'select_bg_video_revslider'     , sanitize_text_field( $_POST['select_bg_video_revslider'] ) );
    update_post_meta( $post_id, 'hide_title_subtitle'           , sanitize_text_field( $_POST['hide_title_subtitle'] ) );
    update_post_meta( $post_id, 'travelogue-youtube-video-id'   , $youtube_video_id );
    update_post_meta( $post_id, 'travelogue-youtube-start-at'   , $youtube_video_start_at );
    update_post_meta( $post_id, 'travelogue-youtube-mute'       , sanitize_text_field( $_POST['travelogue-youtube-mute'] ) );

}
add_action( 'save_post', 'travelogue_save_page_meta_box' );
















function travelogue_post_add_meta_box() {

    add_meta_box( 'page-options', __( 'Post Options', 'travelogue' ), 'travelogue_show_post_metabox_callback', 'post', 'normal', 'high' );

}
add_action( 'add_meta_boxes', 'travelogue_post_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function travelogue_show_post_metabox_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'page_options_nonce', 'page_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */

    $post_subtitle = get_post_meta( $post->ID, 'post_subtitle', true );


    echo "<div class='avstudio-metabox'>";

    echo "<style>";
    echo ".metabox-page { float:left;width:100%;padding:10px 0 }";
    echo ".metabox-page label { margin-right:20px;font-weight:bold;width:20%;display:inline-block }";
    echo ".metabox-page .left { margin-right:20px;width:20%;float:left}";
    echo ".metabox-page .right { width:70%;float:left}";
    echo "</style>";

    echo "<div class='metabox-page'>";
    echo "<label for='post_subtitle'>".__( 'Subtitle', 'travelogue' )."</label>";
    echo '<input type="text" name="post_subtitle" value="' . esc_attr( $post_subtitle ) . '" size="70" />';
    echo "</div>";

    echo "<div style='clear:both'></div>";
    echo "</div>";
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function travelogue_save_post_meta_box( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['page_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['page_nonce'], 'page_options_nonce' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'post' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Sanitize user input.
    $post_subtitle = sanitize_text_field( $_POST['post_subtitle'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'post_subtitle', $post_subtitle );

}
add_action( 'save_post', 'travelogue_save_post_meta_box' );
