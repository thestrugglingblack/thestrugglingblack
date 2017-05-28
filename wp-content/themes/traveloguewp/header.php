<?php
/**
 * The header for our theme.
 *
 * @package travelogue
 */

global $post;
global $travelogue_redux_options;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php if (isset($travelogue_redux_options['travelogue_favicon']['url'])) {?>
    <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>
        <link rel="shortcut icon" href="<?php echo esc_attr($travelogue_redux_options['travelogue_favicon']['url'] ); ?>">
    <?php } ?>
<?php } ?>


<?php wp_head(); ?>
</head>

<?php
    #Page meta boxes
    $page_custom_title          = get_post_meta( get_the_ID(), 'title', true );
    $page_custom_subtitle       = get_post_meta( get_the_ID(), 'subtitle', true );
    $youtube_video_id           = get_post_meta( get_the_ID(), 'travelogue-youtube-video-id', true );
    $youtube_video_start_at     = get_post_meta( get_the_ID(), 'travelogue-youtube-start-at', true );
    $youtube_video_mute         = get_post_meta( get_the_ID(), 'travelogue-youtube-mute', true );
    $post_subtitle              = get_post_meta( get_the_ID(), 'post_subtitle', true );
    if (isset($travelogue_redux_options['travelogue_sidebar_effect'])) {
        $travelogue_sidebar_effect  = $travelogue_redux_options['travelogue_sidebar_effect'];
    }else{
        $travelogue_sidebar_effect  = '';
    }
    $select_bg_video_revslider  = get_post_meta( get_the_ID(), 'select_bg_video_revslider', true );
    $select_revslider_shortcode = get_post_meta( get_the_ID(), 'select_revslider_shortcode', true );
    $hide_title_subtitle        = get_post_meta( get_the_ID(), 'hide_title_subtitle', true );

    #Page featured image           
    //if ( has_post_thumbnail(get_the_ID()) ) {
    $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'travelogue_header_1280x720' );
    //}



    #Page custom class
    $page_custom_class = get_post_meta( get_the_ID(), 'travelogue-custom-class', true );

    #Page header effect
    $page_header_effect = get_post_meta( get_the_ID(), 'travelogue-header-effect', true );
    if(is_category() || is_tag() || is_search() || is_author() || is_archive()){
        $page_header_effect = 'intro-effect-sidefixed';
    }elseif(is_single()){
        $page_header_effect = 'intro-effect-push';
    }elseif(is_home() || empty($page_header_effect)){
        $page_header_effect = 'intro-effect-grid';
    }elseif (is_page_template('template/template-contact.php') || is_404()) {
        $page_header_effect = '';
    }


    $body_class = '';
    if($page_header_effect == 'intro-effect-jam3'){
        $page_custom_class = 'homepage index-home index-gallery';
    }elseif($page_header_effect == 'intro-effect-side'){
        $page_custom_class = 'index-about';
    }elseif($page_header_effect == 'intro-effect-side'){
        $page_custom_class = 'index-about';
    }elseif($page_header_effect == 'intro-effect-grid'){
        $body_class = 'homepage index-home index';
    }


    if(is_category() || is_search() || is_archive()){
        $page_custom_class = 'index-category';
    }elseif(is_tag()){
        $page_custom_class = 'index-category index-tags-page';
    }elseif(is_single()){
        $page_custom_class = 'index-single';
    }elseif(is_author()){
        $page_custom_class = 'index-category index-author st-effect-1';
    }elseif(is_404()){
        $page_custom_class = 'index-contact p404 st-effect-1';
    }elseif(is_home()){
        $page_custom_class = 'homepage index-home index';
    }



    #Custom class for contact page
    if (is_page_template('template/template-contact.php')) {
        $contact_class = 'index-contact';
    }else{
        $contact_class = '';
    }
?>

<body <?php body_class($page_custom_class . ' ' . $travelogue_sidebar_effect . ' ' . $contact_class . ' ' . $body_class); ?>>
    <div id="container" class="container <?php echo $page_header_effect; ?>">

        <!-- Nav Menu Button -->
        <a data-effect="<?php echo $travelogue_sidebar_effect; ?>" class="cd-primary-nav-trigger" id="trigger-menu" href="#0">
          	<span class="cd-menu-icon"></span>
        </a>

        <!-- YouTube Button -->
        <?php if ($select_bg_video_revslider == 'bg_video' && isset($youtube_video_id)){ ?>
            <a class="sound <?php if($youtube_video_mute == 'true'){echo 'off';}else{echo 'on';} ?> hidden" href="#" id="sound">
                <span class="travelogue-icon-sound fa fa-volume-<?php if($youtube_video_mute == 'true'){echo 'off';}else{echo 'up';} ?>"></span>
            </a>
        <?php } ?>

        <!-- Search form -->
        <?php get_search_form(); ?>

        <!-- Header -->
        <header class="header">
            <div class="bg-img">
                <!-- Header Image Backgroud -->
                <?php if($thumbnail_src) { ?>
                    <img class="async-image" src="#" data-src="<?php echo $thumbnail_src['0']; ?>" alt="" />
                <?php }elseif(is_404() && $travelogue_redux_options['bg_page_404']['url']){ ?>
                    <img class="async-image" src="#" data-src="<?php echo esc_attr( $travelogue_redux_options['bg_page_404']['url'] ); ?>" alt="" />
                <?php }elseif(is_search() && $travelogue_redux_options['travelogue_enable_custom_bg_search_results'] && $travelogue_redux_options['placeholder_1280x720_results']['url']){ ?>
                    <img class="async-image" src="#" data-src="<?php echo $travelogue_redux_options['placeholder_1280x720_results']['url']; ?>" alt="" />
                <?php }else{ ?>
                    <img class="async-image" src="#" data-src="http://placehold.it/1280x720/7f8c8d/ffffff" alt="" />
                <?php } ?>
                
                <?php if ($select_bg_video_revslider =='bg_revslider') {
                    $revslider = '[rev_slider '.$select_revslider_shortcode.']';
                    echo do_shortcode($revslider);
                } 
                ?>

                <!-- Header Video Backgroud -->
                <?php if ($select_bg_video_revslider == 'bg_video' && isset($youtube_video_id)){ ?>
                    <div class='video-bg'></div>
                    <a class="player" data-property="{videoURL:'<?php echo esc_attr( $youtube_video_id ); ?>',containment:'.video-bg',autoPlay:true, mute:<?php echo $youtube_video_mute; ?>, startAt:<?php echo $youtube_video_start_at; ?>,opacity:1,ratio:'16/9',showControls:false,showYTLogo:false}"></a>
                <?php } ?>


            </div>
            <!-- <div class="title hidden" id="title"> -->
            <div class="title" id="title">
                <?php if(is_author()){
                    echo '<p class="subline">'.get_avatar( get_the_author_meta( 'ID' ), 128 ).'</p>';
                } ?>
                <h1 class="<?php if ($hide_title_subtitle == 'no') { echo 'hide_title'; } ?>">
                <?php 
                    if ($page_custom_title) {
                        echo $page_custom_title;
                    }elseif(is_category()){
                        printf( __( 'Category Archives: %s', 'travelogue' ), single_cat_title( '', false ) );  
                    }elseif(is_tag()){
                        printf( __( 'Tag Archives: %s', 'travelogue' ), single_tag_title( '', false ) );  
                    }elseif(is_search()){
                        printf( __( 'Search Results for: %s', 'travelogue' ), get_search_query() );  
                    }elseif(is_single()){
                        the_title();
                    }elseif(is_author()){
                        printf( __( '%s', 'travelogue' ), get_the_author() );
                    }elseif(is_404()){
                        echo __( '404', 'travelogue' );
                    }elseif(is_archive()){
                        the_archive_title();
                    }else{
                        the_title();
                    }
                ?>
                </h1>
                <p class="subline <?php if ($hide_title_subtitle == 'no') { echo 'hide_title'; } ?>">
                    <?php echo $page_custom_subtitle; ?>
                    <?php 
                    if (is_author()) {
                        echo the_author_posts() . __(' posts found.');
                    }elseif(is_404()){
                        echo __( 'Don’t panic! It is ok, this happens from time to time. <br> Just blame the cat and search for something!', 'travelogue' );
                    } ?>
                </p>
                <?php if (is_page_template('template/template-contact.php')) { 
                    echo do_shortcode('[contact_form][/contact_form]'); 
                } ?>
            </div>
            <div class="overlay hidden" id="overlay"></div>
        </header>


        <?php //Hide trigger btn on contact page and 404 page ?>
        <?php if (is_page_template('template/template-contact.php') || is_404()) { 
            //Hide Scroll Down Button
        }else{ ?>
            <!-- Scroll Down Button -->
            <button class="trigger scroll-down-pulse"><span></span></button>
        <?php } ?>


        <?php //Title/subtile for article pages ?>
        <?php #if (is_single() or $page_header_effect = 'intro-effect-push') { ?>
        <?php if (is_single()) { ?>
        <div class="title">                 
            <h1 class="black"><?php echo the_title(); ?></h1>
            <h2 class="subline"><?php echo esc_attr( $post_subtitle ); ?></h2>
        </div>
        <?php } ?>


        <!-- Sidebar Menu -->
        <div class="st-container <?php echo $travelogue_sidebar_effect; ?>" id="st-container">
            <div class="st-menu <?php echo $travelogue_sidebar_effect; ?>">
            	<!-- <div class="<?php #echo $travelogue_sidebar_effect; ?>"> -->
            		<div class="fullwidth site-infos">
            			<div class="logo">
                            <a href="<?php echo get_site_url(); ?>">
                                <?php if(isset($travelogue_redux_options['travelogue_logo']['url'])){ ?>
                                    <img src="<?php echo esc_attr( $travelogue_redux_options['travelogue_logo']['url'] ); ?>" alt="<?php echo get_bloginfo(); ?>" />
                                <?php }else{ ?>
                                    <?php echo esc_attr(get_bloginfo()); ?>
                                <?php } ?>
                            </a>
            			</div>
            			<h3 class="section-title"><?php echo get_bloginfo('name'); ?></h3>
            			<span class="section-description"><?php echo get_bloginfo('description'); ?></span>
            		</div>

                    <nav class="fullwidth sidebar-navigation-menu">
                        <?php 
                        if (has_nav_menu( 'primary' )) {
                            wp_nav_menu( 
                                array( 
                                    'theme_location'    => 'primary',
                                    'walker'            => new travelogue_walker_nav_menu()
                                    ) 
                            );
                        }else{
                            wp_list_pages();
                        }
                        ?>
                    </nav>

                    <div class="clearfix"></div>
                    <?php get_sidebar(); ?>
                    <div class="clearfix"></div>

                    <?php if(isset($travelogue_redux_options['travelogue_footer_text'])){ ?>
            		    <div class="fullwidth bottom-links">
            		        <p><?php echo $travelogue_redux_options['travelogue_footer_text']; ?></p>
            		    </div>
                    <?php } ?>
            </div>
        </div>