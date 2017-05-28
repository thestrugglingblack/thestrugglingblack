<?php
/**
||-> FUNCTION: GET DYNAMIC CSS
*/
add_action('wp_enqueue_scripts', 'travelogue_dynamic_css' );
function travelogue_dynamic_css(){

	global $travelogue_redux_options;

	// Enqueue Style Inline
	wp_enqueue_style(
	   'travelogue-custom-style',
	    get_template_directory_uri() . '/css/custom-editor-style.css'
	);

    $html = '';


    // PAGE LOADER
    if (isset($travelogue_redux_options['travelogue_enable_loader'])) {
        $html .= '
        			.bg-img{
			            background: url('.esc_attr( $travelogue_redux_options['travelogue_loading_animation']['url'] ).') no-repeat center center <?php echo '.esc_attr($travelogue_redux_options['travelogue_loading_bg']).';
			        }';
   	}

   	if(isset($travelogue_redux_options['header_buttons_border']['border-color'])){
   		$header_buttons_border = $travelogue_redux_options['header_buttons_border']['border-color'];
   	}else{
   		$header_buttons_border = '#ffffff';
   	}

   	if(isset($travelogue_redux_options['url_links_color']['regular'])){
   		$url_links_color = $travelogue_redux_options['url_links_color']['regular'];
   	}else{
   		$url_links_color = '#339999';
   	}

   	if (isset($travelogue_redux_options['css-code'])) {
   		$custom_css_theme_options_panel = $travelogue_redux_options['css-code'];
   	}else{
   		$custom_css_theme_options_panel = '';
   	}

    // CUSTOM CSS FROM THEME OPTIONS
    $html .= $custom_css_theme_options_panel;

    // THEME OPTIONS STYLESHEET
    $html .= '
    			.cd-primary-nav-trigger.is-clicked .cd-menu-icon:before, 
			    .cd-primary-nav-trigger.is-clicked .cd-menu-icon:after,
			    .cd-primary-nav-trigger .cd-menu-icon:before,
			    .cd-primary-nav-trigger .cd-menu-icon:after,
			    .cd-primary-nav-trigger .cd-menu-icon{
			        background-color: '.esc_attr($header_buttons_border).';
			    }
			    button.trigger span:before,
			    .fa-search:before,
			    .travelogue-icon-search,
			    .travelogue-icon-sound,
			    body .cd-primary-nav-trigger,
			    body .sound,
			    button.trigger{
			        color: '.esc_attr($header_buttons_border).';
			    }
			    a:before{
			        border-bottom: 2px solid '.esc_attr($url_links_color).';
			    }';

    wp_add_inline_style( 'travelogue-custom-style', $html );
}
?>