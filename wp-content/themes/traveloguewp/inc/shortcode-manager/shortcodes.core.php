<?php 
function travelogue_enqueue_admin_scripts( $hook ) {
    global $wp_version, $post_ID;


    /* CSS and JS files for shortcode modal */

    wp_enqueue_style( "av-modal-component-css", get_template_directory_uri().'/css/admin/component.css' );
    wp_enqueue_style( "av-fontawesome-css", get_template_directory_uri().'/css/admin/font-awesome.min.css' );
    wp_enqueue_style( "travelogue-custom-css", get_template_directory_uri().'/css/admin/custom.css' );
    wp_enqueue_script( "av-classie-js", get_template_directory_uri().'/js/admin/classie.js' );
    wp_enqueue_script( "av-modalEffects-js", get_template_directory_uri().'/js/admin/modalEffects.js' );
    wp_enqueue_script( "travelogue-custom-js", get_template_directory_uri().'/js/admin/custom.js', '', '', true );
    /* Color picker */

    if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
        wp_enqueue_style( "av-colorpicker-css", get_template_directory_uri().'/css/colorpicker.css' );
        wp_enqueue_script( "av-colorpicker-js", get_template_directory_uri().'/js/colorpicker.js' , array( 'jquery' ) );
    }

    

    

}
add_action('admin_enqueue_scripts', 'travelogue_enqueue_admin_scripts');


/* Add shortcode button on WordPress editor */

add_action( 'init', 'travelogue_buttons' );
function travelogue_buttons() {
    // Load the TinyMCE plugin : av-plugin.js
    add_filter( "mce_external_plugins", "travelogue_add_buttons" );
    // add new buttons
    add_filter( 'mce_buttons', 'travelogue_register_buttons' );
}
function travelogue_add_buttons( $plugin_array ) {
    $plugin_array['avstudio'] = get_template_directory_uri() . '/js/admin/av-plugin.js';
    return $plugin_array;
}
function travelogue_register_buttons( $buttons ) {
    array_push( $buttons, 'av-shortcodes' ); // dropcap', 'recentposts
    return $buttons;
}

/* Add html in dashboard head for modal shortcode */
global $pagenow;

if ( 'post.php' == $pagenow || 'post-new.php' == $pagenow ) {
    add_action( 'in_admin_header', 'travelogue_modal_shortcode_html' );
}


function travelogue_modal_shortcode_html() {
    global $_wp_admin_css_colors, $av_sm;;
    $current_scheme = get_user_option('admin_color');
    ?>

    <div class="md-modal md-effect-3" id="shortcodes-modal">
        <div class="md-content">
            <h3><i class="fa fa-cogs"></i><?php echo __('Shortcodes Manager', 'travelogue'); ?></h3>
            <div>
                <div class="shortcode-menu">
                    <ul id="av-shortcode-menu">
                        <?php

                        if ( $av_sm->shortcodes ) {
                            foreach ($av_sm->shortcodes as $shortcode_tag => $shortcode) {
                                $icon = '';
                                if ( isset($shortcode['icon']) ) {
                                    $icon = '<i class="fa '.$shortcode['icon'].'"></i>';
                                }

                                echo '<li><a href="#'.$shortcode_tag.'"> '.$icon.' '.$shortcode['label'].'</a></li>';
                            }
                        }

                        ?>
                    </ul>
                </div>
                <div class="shortcode-content">
                    <?php

                    if ( $av_sm->shortcodes ) {
                            foreach ($av_sm->shortcodes as $shortcode_tag => $shortcode) {
                                echo '<div id="'.$shortcode_tag.'" class="shortcode-container hide">';
                                $icon = '';
                                if ( isset($shortcode['icon']) ) {
                                    $icon = '<i class="fa '.$shortcode['icon'].'"></i>';
                                }
                                echo "<h2>{$icon}{$shortcode['label']}</h2>";
                                echo "<div class='shortcode-field'>";
                                if ( isset($shortcode['fields']) ) {
                                    foreach ($shortcode['fields'] as $name => $field_info) {                                    
                                        echo "<div class='label-container'><label for='{$name}'>{$field_info['label']}</label></div>";
                                        echo "<div class='input-container'>";
                                        switch ( $field_info['type'] ) {
                                            case 'text':
                                                $default = isset($field_info['default']) ? $field_info['default'] : '';
                                                echo '<input type="text" name="'.$name.'" date-default="'.$default.'" class="shortcode-input" value="'.$default.'">';
                                                break;
                                            case 'color':
                                                $default = isset($field_info['default']) ? $field_info['default'] : '#fff';
                                                echo '<div class="colorSelector" data-color="'. esc_attr( $default ) .'"><div style="background-color: '. esc_attr( $default ) .'"></div></div>';
                                                echo '<input class="shortcode-input" date-default="'.$default.'" type="text" name="background-color" value="' . esc_attr( $default ) . '" size="10" style="display:block;float:left;margin-left:20px;margin-top:5px;"/>';
                                                break;
                                            case 'textarea':
                                                $default = isset($field_info['default']) ? $field_info['default'] : '';
                                                echo '<textarea name="'.$name.'" class="shortcode-input" date-default="'.$default.'">'.$default.'</textarea>';
                                                break;
                                            case 'select':
                                                echo "<select name='{$name}' date-default='".$default."' class='shortcode-input'>";
                                                foreach ($field_info['options'] as $value => $text) {
                                                    if ( isset($field_info['default']) && $text == $field_info['default'] ) {
                                                        echo "<option value='{$value}' selected=''>{$text}</option>";
                                                    }else{
                                                        echo "<option value='{$value}'>{$text}</option>";
                                                    }
                                                }
                                                echo "</select>";
                                                break;                                          
                                            default:
                                                # code...
                                                break;
                                        }
                                        echo "</div>";
                                        echo "<div class='clearfix'></div>";                                        
                                    }
                                }
                                if ( isset($shortcode['content']) ) {
                                    echo "<div class='label-container'><label for='shortcode-content'>". __('Content', 'travelogue') ."</label></div>";
                                    echo "<div class='input-container'>";
                                    echo '<textarea name="shortcode-content" class="shortcode-input"></textarea>';
                                    echo "</div>";
                                }
                                echo "<div class='clearfix'></div>";
                                echo "</div>";
                                echo "<div class='insert-button'><button class='insert-shortcode'>". __('Insert Shortcode', 'travelogue') ."</button></div>";

                            echo '</div>';
                            }
                        }

                    ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="md-overlay"></div>

    <script type="text/javascript">

        jQuery( document ).ready(function() {
            var selected_color = jQuery('#colorSelector').attr('data-color');

            jQuery('.input-container > .colorSelector').each(function(){
                var selected_color = jQuery(this).attr('data-color');
                var element = jQuery(this);
                jQuery(this).ColorPicker({
                    color: selected_color,
                    onChange: function (hsb, hex, rgb) {
                        element.find('div').css('backgroundColor', '#' + hex);
                        element.parent().find('input').val('#' + hex);
                    }
                }); 
            });

            jQuery('.md-overlay').click(function( evt ){
                evt.preventDefault();
                jQuery('#shortcodes-modal').removeClass('md-show');
            })
            jQuery('#av-shortcode-menu li a').click(function( evt ){
                evt.preventDefault();
                jQuery('#av-shortcode-menu li.active').removeClass('active');
                jQuery(this).parent().addClass('active');
                var id_shitem = jQuery(this).attr('href');
                jQuery('.shortcode-container.show').removeClass('show').addClass('hide');
                jQuery(id_shitem).removeClass('hide');
                jQuery(id_shitem).addClass('show');
            });


        });

        

        console.log(tinymce.editors);

    </script>

    <?php

}