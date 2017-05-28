<?php
/**
* Plugin Name: ModelTheme Framework
* Plugin URI: http://modeltheme.com/
* Description: ModelTheme Framework required by Travelogue Theme.
* Version: 1.0 (18-JUN-2016)
* Author: ModelTheme
* Author http://modeltheme.com/
* Text Domain: smartowl
*/


$plugin_dir = plugin_dir_path( __FILE__ );





/**

||-> Function: Dynamic Featured Image for 'portfolio' CPT only

*/
// function modeltheme_allowed_post_types() {
//     return array('portfolio'); //show DFI only in post
// }
// add_filter('dfi_post_types', 'modeltheme_allowed_post_types');





/**
||-> Function: ModelTheme Feed
*/
add_action('wp_dashboard_setup', 'modeltheme_dashboard_widgets');
function modeltheme_dashboard_widgets() {
    global $wp_meta_boxes;
    wp_add_dashboard_widget('modeltheme_posts_feed', 'ModelTheme Feed', 'modeltheme_custom_dashboard_help');
}

function modeltheme_custom_dashboard_help() {
    echo '<div class="rss-widget">';
        wp_widget_rss_output(array(
             'url'          => 'http://modeltheme.com/feed/',
             'title'        => 'MODELTHEME_FEED',
             'items'        => 5,
             'show_summary' => 1,
             'show_author'  => 0,
             'show_date'    => 1
        ));
    echo '</div>';
}


/**
||-> Function: require_once() plugin necessary parts
*/
require_once('inc/demo-importer/redux.php'); // DEMO IMPORTER


/**
||-> Function: LOAD PLUGIN TEXTDOMAIN
*/
function modeltheme_load_textdomain(){
    $domain = 'modeltheme';
    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

    load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
    load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'modeltheme_load_textdomain' );


/**
||-> ... Custom functions here ...
*/









?>