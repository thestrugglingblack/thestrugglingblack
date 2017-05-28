<?php
/**
 * travelogue functions and definitions
 *
 * @package travelogue
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}



/* Include TGM plugin */
require get_template_directory().'/inc/tgm/include_plugins.php';

if ( ! function_exists( 'travelogue_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function travelogue_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on travelogue, use a find and replace
	 * to change 'travelogue' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'travelogue', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'travelogue' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'travelogue_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // travelogue_setup
add_action( 'after_setup_theme', 'travelogue_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function travelogue_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'travelogue' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'travelogue_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function travelogue_scripts() {
	wp_enqueue_style( 'travelogue-style', get_stylesheet_uri() );

	/* CSS and JS files for shortcode modal */
	wp_enqueue_style( "travelogue-normalize-css", get_template_directory_uri().'/css/normalize.css' );
	wp_enqueue_style( "travelogue-fontawesome-css", get_template_directory_uri().'/css/font-awesome.min.css' );
	wp_enqueue_style( "travelogue-core-css", get_template_directory_uri().'/css/core.css' );
	wp_enqueue_style( "travelogue-gallery-css", get_template_directory_uri().'/css/gallery.css' );
    wp_enqueue_style( "travelogue-responsive-css", get_template_directory_uri().'/css/responsive.css' );
    wp_enqueue_style( "travelogue-ie11-css", get_template_directory_uri().'/css/ie11.css' );
	#wp_enqueue_style( "travelogue-owl-css", get_template_directory_uri().'/css/owl.carousel.css' );

	wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'travelogue-classie-js', get_template_directory_uri() . '/js/classie.js', array(), '1.0.1', true );
    wp_enqueue_script( 'travelogue-sidebar-effects-js', get_template_directory_uri() . '/js/sidebarEffects.js', array(), '1.0', true );
    wp_enqueue_script( 'travelogue-cbpFWTabs-js', get_template_directory_uri() . '/js/cbpFWTabs.js', array(), '1.0', true );
    #Page template contact
    if ( is_page_template('template/template-contact.php') ) {
        wp_enqueue_script( 'travelogue-modernizr-form-custom-js', get_template_directory_uri() . '/js/modernizr.form.custom.js', array(), '1.0', true );
        wp_enqueue_script( 'travelogue-stepsForm-js', get_template_directory_uri() . '/js/stepsForm.js', array(), '1.0', true );
        wp_enqueue_script( 'travelogue-contact-js', get_template_directory_uri() . '/js/contact.js', array(), '1.0', true );
        wp_enqueue_script( 'travelogue-form-js', get_template_directory_uri() . '/js/jquery.form.js', array(), '1.0', true );
    }elseif(is_404()){
        wp_enqueue_script( 'travelogue-modernizr-form-custom-js', get_template_directory_uri() . '/js/modernizr.form.custom.js', array(), '1.0', true );
        wp_enqueue_script( 'travelogue-custom-js', get_template_directory_uri() . '/js/custom.js', array(), '1.0', true );
    }else{
        wp_enqueue_script( 'travelogue-modernizr-custom-js', get_template_directory_uri() . '/js/modernizr.custom.js', array(), '2.6.2', true );
        wp_enqueue_script( 'travelogue-modernizr-custom-gallery-js', get_template_directory_uri() . '/js/modernizr.custom.gallery.js', array(), '2.7.1', true );
        wp_enqueue_script( 'travelogue-custom-js', get_template_directory_uri() . '/js/custom.js', array(), '1.0', true );
        wp_enqueue_script( 'travelogue-transition-js', get_template_directory_uri() . '/js/transition.js', array(), '1.0', true );
        wp_enqueue_script( 'travelogue-jquery-infinitescroll.js', get_template_directory_uri() . '/js/jquery.infinitescroll.js', array(), '2.0.2', true );
        wp_enqueue_script( 'travelogue-modernizr-isotope-js', get_template_directory_uri() . '/js/isotope/modernizr-isotope.js', array(), '1.0', true );
        wp_enqueue_script( 'travelogue-isotope-pkgd-js', get_template_directory_uri() . '/js/isotope/isotope.pkgd.min.js', array(), '1.0', true );
        wp_enqueue_script( 'travelogue-imagesloaded-pkgd-js', get_template_directory_uri() . '/js/isotope/imagesloaded.pkgd.min.js', array(), '1.0', true );
        #wp_enqueue_script( 'travelogue-owl-js', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), '1.0', true );

    }
    #Page template gallery
    if ( is_page_template('template/template-gallery.php') ) {
        wp_enqueue_script( 'travelogue-cbpGridGallery-js', get_template_directory_uri() . '/js/cbpGridGallery.js', array(), '1.0', true );
    }

    $select_bg_video_revslider = get_post_meta( get_the_ID(), 'select_bg_video_revslider', true );
    $youtube_video_id = get_post_meta( get_the_ID(), 'travelogue-youtube-video-id', true );
    if (isset($select_bg_video_revslider)) {
        if ($select_bg_video_revslider == 'bg_video' || isset($youtube_video_id)) {
            wp_enqueue_script( 'travelogue-jquery-YTPlayer.js', get_template_directory_uri() . '/js/jquery.mb.YTPlayer.js', array(), '1.0', true );
            wp_enqueue_script( 'travelogue-youtube-video.js', get_template_directory_uri() . '/js/youtube-video.js', array(), '1.0', true );
        }
    }


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'travelogue_scripts' );


function travelogue_enqueue_ie_css() {
    // Register stylesheet
    wp_register_style( 'css-ie', get_template_directory_uri() . '/css/ie.css' );
    wp_register_style( 'css-ie9', get_template_directory_uri() . '/css/ie9.css' );
    // Apply IE conditionals
    $GLOBALS['wp_styles']->add_data( 'css-ie', 'conditional', 'IE' );
    $GLOBALS['wp_styles']->add_data( 'css-ie9', 'conditional', 'gte IE 9' );
    // Enqueue stylesheet
    wp_enqueue_style( 'css-ie' );
    wp_enqueue_style( 'css-ie9' );
}
add_action( 'wp_enqueue_scripts', 'travelogue_enqueue_ie_css' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/* ========= LOAD - REDUX - FRAMEWORK ===================================== */
require_once(dirname(__FILE__).'/redux-framework/travelogue-config.php');

/* ========= CUSTOM - POST - TYPES ===================================== */
require get_template_directory() . '/inc/post_types/custom-posts.php';

/* ========= CUSTOM - META - BOXES ===================================== */
require get_template_directory() . '/inc/post_types/meta-boxes.php';

/* ========= SHORTCODE MANAGER ===================================== */
require get_template_directory() . '/inc/shortcode-manager/shortcodes.core.php';
require get_template_directory() . '/inc/shortcode-manager/shortcode-manager.class.php';

/* ========= SHORTCODES ===================================== */
require get_template_directory() . '/inc/shortcodes/shortcodes.php';

/* ========= WIDGETS ===================================== */
require get_template_directory() . '/inc/widgets/widgets.php';

/* ========= CUSTOM COMMENTS ===================================== */
require get_template_directory() . '/inc/custom-comments.php';

/* ========= CUSTOM NAV WALKER ===================================== */
require get_template_directory() . '/inc/custom-nav-walker.php';

/* ========= DYNAMIC INLINE STYLE ===================================== */
require get_template_directory() . '/inc/dynamic-style.php';

/* ========= Add support post thumbnail ===================================== */
add_theme_support( "post-thumbnails" );

/* ========= RESIZE IMAGES ===================================== */
add_image_size( 'travelogue_posts_965x320', 965, 320, true ); #blog posts thumbnails 965x320
add_image_size( 'travelogue_posts_480x320', 480, 320, true ); #blog posts thumbnails 480x320
add_image_size( 'travelogue_header_1920x1080', 1920, 1080, true ); #1080p
add_image_size( 'travelogue_header_1280x720', 1280, 720, true ); #720p
add_image_size( 'travelogue_gallery_90x90', 90, 90, true ); #90x90


function travelogue_add_editor_styles() {
    add_editor_style( 'css/custom-editor-style.css' );
}
add_action( 'after_setup_theme', 'travelogue_add_editor_styles' );

/* ========= CUSTOM FUNCTIONS ===================================== */
function travelogue_post_excerpt_limit($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit) {
		array_pop($words);
	}
	return implode(' ', $words);
}

/* ========= CUSTOM PAGINATION ===================================== */
if ( ! function_exists( 'travelogue_pagination' ) ) {
    function travelogue_pagination($query = null) {

        if (!$query) {
            global $wp_query;
            $query = $wp_query;
        }
        
        $big = 999999999; // need an unlikely integer
        $current = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : '1');
        echo paginate_links( 
            array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'current' => max( 1, $current ),
                'total' => $query->max_num_pages,
                'prev_text'    => __('&#171;','urbanpoint'),
                'next_text'    => __('&#187;','urbanpoint'),
            ) 
        );
    }
}

// REMOVE REDUX FRAMEWORK NOTICES
function travelogue_remove_redux_notices() { // Be sure to rename this function to something more unique
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
    }
}
add_action('init', 'travelogue_remove_redux_notices');