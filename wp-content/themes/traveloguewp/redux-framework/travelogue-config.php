<?php
/**
  ReduxFramework AV Studio Config File
  For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
 * */

if (!class_exists("Redux_Framework_travelogue_config")) {

    class Redux_Framework_travelogue_config {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }
            
            // This is needed. Bah WordPress bugs.  ;)
            if ( defined('TEMPLATEPATH') && strpos( Redux_Helpers::cleanFilePath( __FILE__ ), Redux_Helpers::cleanFilePath( TEMPLATEPATH ) ) !== false) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);    
            }
        }

        public function initSettings() {

            if ( !class_exists("ReduxFramework" ) ) {
                return;
            }       
            
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/plugin/hooks', array( $this, 'remove_demo' ) );
            // Function to test the compiler hook and demo CSS output.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2); 
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field   set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo "<h1>The compiler hook has run!";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
              require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
              $wp_filesystem->put_contents(
              $filename,
              $css,
              FS_CHMOD_FILE // predefined mode settings for WP files
              );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
           /* $sections[] = array(
                'title' => __('Section via hook', 'travelogue'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'travelogue'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );*/

            return $sections;
        }
        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = "Testing filter hook!";

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2);
            }

            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $travelogue_patterns_path = ReduxFramework::$_dir . '../polygon/patterns/';
            $travelogue_patterns_url = ReduxFramework::$_url . '../polygon/patterns/';
            $travelogue_patterns = array();

            if (is_dir($travelogue_patterns_path)) :

                if ($travelogue_patterns_dir = opendir($travelogue_patterns_path)) :
                    $travelogue_patterns = array();

                    while (( $travelogue_patterns_file = readdir($travelogue_patterns_dir) ) !== false) {

                        if (stristr($travelogue_patterns_file, '.png') !== false || stristr($travelogue_patterns_file, '.jpg') !== false) {
                            $name = explode(".", $travelogue_patterns_file);
                            $name = str_replace('.' . end($name), '', $travelogue_patterns_file);
                            $travelogue_patterns[] = array('alt' => $name, 'img' => $travelogue_patterns_url . $travelogue_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct = wp_get_theme();
            $this->theme = $ct;
            $item_name = $this->theme->get('Name');
            $tags = $this->theme->Tags;
            $screenshot = $this->theme->get_screenshot();
            $class = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'travelogue'), $this->theme->display('Name'));
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
            <?php endif; ?>

                <h4>
            <?php echo $this->theme->display('Name'); ?>
                </h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'travelogue'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'travelogue'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'travelogue') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
                <?php
                if ($this->theme->parent()) {
                    printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'travelogue'), $this->theme->parent()->display('Name'));
                }
                ?>

                </div>

            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $pmHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $pmHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            # Section #1: General Settings
            $this->sections[] = array(
                'icon' => 'el-icon-wrench',
                'title' => __('General Settings', 'travelogue'),
                'fields' => array(
                    array(
                        'id' => 'travelogue_logo',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Logo url', 'travelogue'),
                        'compiler' => 'true',
                        'desc' => __('', 'travelogue'),
                        'subtitle' => __('Use the upload button to import media.', 'travelogue'),
                        'default' => array('url' => get_template_directory_uri() . '/images/travelogue_logo.png'),
                    ),
                    array(
                        'id' => 'travelogue_favicon',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Favicon url', 'travelogue'),
                        'compiler' => 'true',
                        'desc' => __('', 'travelogue'),
                        'subtitle' => __('Use the upload button to import media.', 'travelogue'),
                        'default' => array('url' => get_template_directory_uri() . '/images/travelogue_favicon.png'),
                    ),
                    array(
                        'id'       => 'travelogue_enable_loader',
                        'type'     => 'switch', 
                        'title'    => __('Page loading animation', 'travelogue'),
                        'subtitle' => __('Enable or disable page loading animation', 'travelogue'),
                        'default'  => true,
                    ),
                    array(
                        'id' => 'travelogue_loading_animation',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Page loading animation', 'travelogue'),
                        'compiler' => 'true',
                        'output'   => array( 
                            '.bg-img'
                            ),
                        'desc' => __('', 'travelogue'),
                        'subtitle' => __('Use the upload button to import media.', 'travelogue'),
                        'default' => array('url' => get_template_directory_uri() . '/images/loading.gif'),
                    ),
                    array(
                        'id'       => 'travelogue_loading_bg',
                        'type'     => 'color_rgba',
                        'title'    => __( 'Page loading background', 'travelogue' ),
                        'subtitle' => __( 'Pick a background color page loading (default: #ffffff).', 'travelogue' ),
                        'default'  => array( 
                            'color' => '#ffffff', 
                            'alpha' => '1' 
                        ),
                        'mode'     => 'background',
                        'validate' => 'colorrgba',
                    ),
                    array(
                        'id' => 'travelogue_sidebar_effect',
                        'type'     => 'select',
                            'title'    => __('Sidebar Effect', 'travelogue'),
                            'subtitle' => __('Select Sidebar Effect', 'travelogue'),
                            // Must provide key => value pairs for select options
                            'options'  => array(
                                'st-effect-1' => 'Slide - Default',
                                'st-effect-2' => 'Reveal',
                                'st-effect-3' => 'Push content'
                            ),
                            'default'  => 'st-effect-1',
                    ),
                    array(
                        'id' => 'tracking-code',
                        'type' => 'textarea',
                        'required' => array('layout', 'equals', '1'),
                        'title' => __('Tracking Code', 'travelogue'),
                        'subtitle' => __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'travelogue'),
                        'validate' => 'js',
                        'desc' => 'Validate that it\'s javascript!',
                    ),
                    array(
                        'id' => 'css-code',
                        'type' => 'ace_editor',
                        'title' => __('CSS Code', 'travelogue'),
                        'subtitle' => __('Paste your CSS code here.', 'travelogue'),
                        'mode' => 'css',
                        'theme' => 'monokai',
                        'default' => "#id{\nmargin: 0 auto;\n}"
                    ),
                    array(
                        'id' => 'php-code',
                        'type' => 'ace_editor',
                        'title' => __('JS Code', 'travelogue'),
                        'subtitle' => __('Paste your JS code here.', 'travelogue'),
                        'mode' => 'php',
                        'theme' => 'chrome',
                        'default' => "jQuery(document).ready(function(){\n\n});"
                    )
                )
            );


            # Section #2: Styling Options
            $this->sections[] = array(
                'icon' => 'el-icon-brush',
                'title' => __('Styling Options', 'travelogue'),
                'fields' => array(
                    array(
                        'id'          => 'top_heading_font',
                        'type'        => 'typography',
                        'title'       => __('Header Heading Typography', 'travelogue'),
                        'google'      => true,
                        'font-backup' => true,
                        'output'      => array(
                            'h2.site-description',
                            '.intro-effect-grid .header h1',
                            '.intro-effect-sidefixed .title h1',
                            '.title h1'
                            ),
                        'units'       =>'px',
                        'subtitle'    => __('Style will be applied to H1 heading from intro header.', 'travelogue'),
                        'default'     => array(
                            'color'       => '#fff',
                            'font-style'  => '700',
                            'font-family' => 'Raleway',
                            'google'      => true,
                            'font-size'   => '73px',
                            'line-height' => '73px'
                        ),
                    ),                    
                    array(
                        'id'          => 'top_heading_font_blog_post',
                        'type'        => 'typography',
                        'title'       => __('Single Blog Post Header Heading Typography', 'travelogue'),
                        'google'      => true,
                        'font-backup' => true,
                        'output'      => array(
                            '.single-post h2.site-description',
                            '.single-post .intro-effect-grid .header h1',
                            '.single-post .intro-effect-sidefixed .title h1',
                            '.single-post .title h1'
                            ),
                        'units'       =>'px',
                        'subtitle'    => __('Style will be applied to H1 heading from intro header(From Single Blog Post page only).', 'travelogue'),
                        'default'     => array(
                            'color'       => '#fff',
                            'font-style'  => '700',
                            'font-family' => 'Raleway',
                            'google'      => true,
                            'font-size'   => '73px',
                            'line-height' => '73px'
                        ),
                    ),                    
                    array(
                        'id'          => 'top_heading_font_category_tags_archive',
                        'type'        => 'typography',
                        'title'       => __('Category Pages Header Heading Typography', 'travelogue'),
                        'google'      => true,
                        'font-backup' => true,
                        'output'      => array(
                            '.category h2.site-description',
                            '.category .intro-effect-grid .header h1',
                            '.category .intro-effect-sidefixed .title h1',
                            '.category .title h1'
                            ),
                        'units'       =>'px',
                        'subtitle'    => __('Style will be applied to H1 heading from intro header(From Category/Tags/Archive pages).', 'travelogue'),
                        'default'     => array(
                            'color'       => '#fff',
                            'font-style'  => '700',
                            'font-family' => 'Raleway',
                            'google'      => true,
                            'font-size'   => '73px',
                            'line-height' => '73px'
                        ),
                    ),
                    array(
                        'id'       => 'header_buttons_border',
                        'type'     => 'border',
                        'title'    => __( 'Header Buttons Border', 'travelogue' ),
                        'subtitle' => __( 'Style will be applied to: <strong>ON/OFF audio, Scroll to bottom, Search and Menu</strong> Buttons', 'travelogue' ),
                        'output'   => array( 
                            '.travelogue-icon-search',
                            '.travelogue-icon-sound',
                            'body .cd-primary-nav-trigger',
                            'body .sound',
                            'button.trigger',
                            '.travelogue-search.travelogue-search-open .travelogue-icon-search',
                            '.no-js .travelogue-search .travelogue-icon-search'
                            ),
                        // An array of CSS selectors to apply this font style to
                        'desc'     => __( 'Icon colors of header buttons will be the same with the border color set above.', 'travelogue' ),
                        'default'  => array(
                            'border-color'  => '#ffffff',
                            'border-style'  => 'solid',
                            'border-top'    => '2px',
                            'border-right'  => '2px',
                            'border-bottom' => '2px',
                            'border-left'   => '2px'
                        )
                    ),
                    // array(
                    //     'id'          => 'content_style',
                    //     'type'        => 'typography',
                    //     'title'       => __('Article content style', 'travelogue'),
                    //     'google'      => true,
                    //     'font-backup' => true,
                    //     // 'output'      => array(
                    //     //     'p',
                    //     //     'pre'
                    //     //     ),
                    //     'units'       =>'px',
                    //     'subtitle'    => __('Style will be applied to paragraphs and content text.', 'travelogue'),
                    //     'default'     => array(
                    //         'color'       => '#000',
                    //         'font-style'  => '300',
                    //         'font-family' => 'Open Sans',
                    //         'google'      => true,
                    //         'font-size'   => '18px',
                    //         'line-height' => '26px'
                    //     ),
                    // ),
                    array(
                        'id'       => 'content_background',
                        'type'     => 'background',
                        'output'   => array( 
                            '.content',
                            '.index-single #container > article'
                            ),
                        'title'    => __( 'Article content background', 'travelogue' ),
                        'subtitle' => __( 'Article content background with image, color, etc.', 'travelogue' ),
                        'desc'     => __( 'Default color: #DDDDDD', 'travelogue' ),
                        'default'   => '#DDDDDD',
                    ),
                    array(
                        'id'        => 'body_content_color_rgba',
                        'type'      => 'color_rgba',
                        'title'    => __('Article content text color', 'travelogue'),
                        'subtitle' => __('Pick a color for body text co (default: #fff).', 'travelogue'),
                     
                        // See Notes below about these lines.
                        'output'   => array( 
                            '.single-post .intro-effect-push .content > div'
                        ),
                        //'compiler'  => array('color' => '.site-header, .site-footer', 'background-color' => '.nav-bar'),
                        'default'   => array(
                            'color'     => '#000000',
                            'alpha'     => 0.8
                        ),
                     
                        // These options display a fully functional color palette.  Omit this argument
                        // for the minimal color picker, and change as desired.
                        'options'       => array(
                            'show_input'                => true,
                            'show_initial'              => true,
                            'show_alpha'                => true,
                            'show_palette'              => true,
                            'show_palette_only'         => false,
                            'show_selection_palette'    => true,
                            'max_palette_size'          => 10,
                            'allow_empty'               => true,
                            'clickout_fires_change'     => false,
                            'choose_text'               => 'Choose',
                            'cancel_text'               => 'Cancel',
                            'show_buttons'              => true,
                            'use_extended_classes'      => true,
                            'palette'                   => null,  // show default
                            'input_text'                => 'Select Color'
                        ),                       
                    ),

                    array(
                        'id'       => 'url_links_color',
                        'type'     => 'link_color',
                        'title'    => __( 'Links Color Option', 'travelogue' ),
                        'subtitle' => __( 'Only color validation can be done on this field type', 'travelogue' ),
                        'desc'     => __( 'Default colors: Regular: #339999, Hover: #339999, Focus: #339999', 'travelogue' ),
                        //'regular'   => false, // Disable Regular Color
                        //'hover'     => false, // Disable Hover Color
                        //'active'    => false, // Disable Active Color
                        //'visited'   => true,  // Enable Visited Color
                        'output'   => array( 
                            'a'
                            ),
                        'default'  => array(
                            'regular' => '#339999',
                            'hover'   => '#339999',
                            'active'  => '#339999',
                        )
                    ),

                )
            );


            # Section #3: Footer Settings
            $this->sections[] = array(
                'icon' => 'el-icon-arrow-down',
                'title' => __('Footer Settings', 'travelogue'),
                'fields' => array(
                    array(
                        'id' => 'travelogue_footer_text',
                        'type' => 'editor',
                        'title' => __('Footer Text', 'travelogue'),
                        'subtitle' => __('', 'travelogue'),
                        'default' => '2014 © Travelogue. All rights reserved.',
                    ),
                    array(
                        'id'       => 'back_to_top',
                        'type'     => 'select',
                        'title'    => __( 'Back to Top button', 'travelogue' ),
                        'subtitle' => __( 'Enable/disable Back to Top button', 'travelogue' ),
                        //Must provide key => value pairs for select options
                        'options'  => array(
                            '1' => 'Enabled',
                            '2' => 'Disabled'
                        ),
                        'default'  => '1'
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-website',
                'title' => __('Pages Settings', 'travelogue'),
                'fields' => array(
                    array(
                        'id' => 'bg_page_404',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('404 Page Background', 'travelogue'),
                        'compiler' => 'true',
                        'subtitle' => __('Add Background Image for 404 Page', 'travelogue'),
                        'desc' => __('Use the upload button to import media.', 'travelogue'),
                        'default' => array('url' => WP_CONTENT_URL . '/themes/traveloguewp/images/default/bg-404.jpg'),
                    ),
                    array(
                        'id'   => 'opt-info',
                        'type' => 'info',
                        'desc' => __( '<strong>Default page placeholders.</strong>', 'travelogue' ),
                    ),
                    array(
                        'id' => 'placeholder_1280x720',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Pages Placeholder', 'travelogue'),
                        'compiler' => 'true',
                        'subtitle' => __('Suggested image size: 1280x720px', 'travelogue'),
                        'desc' => __('Use the upload button to import media.', 'travelogue'),
                        'default' => array('url' => WP_CONTENT_URL . '/themes/traveloguewp/images/placeholders/1280x720px.jpg'),
                    )
                ),
            );

            # Section #5: Contact Settings

            $this->sections[] = array(
                'icon' => 'el-icon-map-marker-alt',
                'title' => __('Contact Settings', 'travelogue'),
                'fields' => array(
                    array(
                        'id' => 'travelogue_contact_phone',
                        'type' => 'text',
                        'title' => __('Phone Number', 'travelogue'),
                        'subtitle' => __('Contact phone number displayed on the contact us page.', 'travelogue'),
                        'validate_callback' => 'redux_validate_callback_function',
                        'default' => ' +1 777 3321 2312'
                    ),
                    array(
                        'id' => 'travelogue_contact_email',
                        'type' => 'text',
                        'title' => __('Email', 'travelogue'),
                        'subtitle' => __('Contact email displayed on the contact us page., additional info is good in here.', 'travelogue'),
                        'validate' => 'email',
                        'msg' => 'custom error message',
                        'default' => 'support@avstudio.com'
                    )
                )
            );

            # Section #6: Blog Settings

            $this->sections[] = array(
                'icon' => 'el-icon-comment',
                'title' => __('Blog Settings', 'travelogue'),
                'fields' => array(
                    array(
                        'id'       => 'travelogue_posts_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Select posts style', 'travelogue' ),
                        'subtitle' => __( 'Chosen style will be applied on <strong>Homepage pages posts</strong>.<br/> Choose between Small(4 columns) or Big(2 columns) options.', 'travelogue' ),
                        'options'  => array(
                            'small' => array(
                                'alt' => 'small',
                                'img' => get_template_directory_uri() . '/redux-framework/blog/4columns.jpg'
                            ),
                            'big' => array(
                                'alt' => 'big',
                                'img' => get_template_directory_uri() . '/redux-framework/blog/2columns.jpg'
                            )
                        ),
                        'default'  => 'small'
                    ),
                    array(
                        'id' => 'placeholder_965x320',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Big posts placeholder', 'travelogue'),
                        'compiler' => 'true',
                        'subtitle' => __('Recommended image size: <strong>965x350px</strong>', 'travelogue'),
                        'desc' => __('Use the upload button to import media.', 'travelogue'),
                        'default' => array('url' => get_template_directory_uri() . '/images/placeholders/965x320px.jpg'),
                    ), 
                    array(
                        'id' => 'placeholder_480x320',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Small posts placeholder', 'travelogue'),
                        'compiler' => 'true',
                        'subtitle' => __('Recommended image size: <strong>480x320px</strong>', 'travelogue'),
                        'desc' => __('Use the upload button to import media.', 'travelogue'),
                        'default' => array('url' => get_template_directory_uri()  . '/images/placeholders/480x320px.jpg'),
                    ),
                    array(
                        'id'    => 'opt-info-success',
                        'type'  => 'info',
                        'style' => 'success',
                        'icon'  => 'el-icon-info-sign',
                        'title' => __( 'What is a <strong>Placeholder?</strong>', 'travelogue' ),
                        'desc'  => __( 'If a blog post does not have a featured image, then it will be replaced by one of these images.', 'travelogue' )
                    )
                )
            );

            # Section #6: Search Page

            $this->sections[] = array(
                'icon' => ' el-icon-search',
                'title' => __('Search Page Settings', 'travelogue'),
                'fields' => array(
                    array(
                        'id'       => 'travelogue_enable_custom_bg_search_results',
                        'type'     => 'switch', 
                        'title'    => __('Enable custom header image for search with results?', 'travelogue'),
                        'desc' => __('If this option is disabled, the header image will be taken from the first found post.', 'travelogue'),
                        'default'  => true,
                    ),
                    array(
                        'id' => 'placeholder_1280x720_results',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Search page header image placeholder', 'travelogue'),
                        'compiler' => 'true',
                        'subtitle' => __('Recommended image size: <strong>1280x720px</strong>', 'travelogue'),
                        'desc' => __('Use the upload button to import media.', 'travelogue'),
                        'default' => array('url' => 'http://placehold.it/1280x720/7f8c8d/ffffff'),
                    ),
                    array(
                        'id'    => 'opt-info-success2',
                        'type'  => 'info',
                        'style' => 'success',
                        'icon'  => 'el-icon-info-sign',
                        'title' => __( 'What is a <strong>Placeholder?</strong>', 'travelogue' ),
                        'desc'  => __( 'If a blog post does not have a featured image, then it will be replaced by one of these images.', 'travelogue' )
                    )
                )
            );

            # Section #6: Gallery Settings

            $this->sections[] = array(
                'icon' => 'el-icon-picture',
                'title' => __('Gallery Settings', 'travelogue'),
                'fields' => array(
                    // array(
                    //     'id' => 'travelogue_gallery_items_per_page',
                    //     'type' => 'text',
                    //     'title' => __('Items per page', 'travelogue'),
                    //     'subtitle' => __('Select gallery items per page.', 'travelogue'),
                    //     'default' => '20'
                    // ),
                    array(
                        'id'       => 'travelogue_gallery_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Select gallery items style', 'travelogue' ),
                        'subtitle' => __( 'Chosen style will be applied on <strong>Gallery page</strong>.<br/> Choose between Small(4 columns) or Big(2 columns) options.', 'travelogue' ),
                        'options'  => array(
                            'small' => array(
                                'alt' => 'small',
                                'img' => get_template_directory_uri() . '/redux-framework/blog/4columns.jpg'
                            ),
                            'big' => array(
                                'alt' => 'big',
                                'img' => get_template_directory_uri() . '/redux-framework/blog/2columns.jpg'
                            )
                        ),
                        'default'  => 'small'
                    ),
                    array(
                        'id' => 'gallery_placeholder_965x320',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Big gallery items placeholder', 'travelogue'),
                        'compiler' => 'true',
                        'subtitle' => __('Recommended image size: <strong>965x350px</strong>', 'travelogue'),
                        'desc' => __('Use the upload button to import media.', 'travelogue'),
                        'default' => array('url' => get_template_directory_uri() . '/images/placeholders/965x320px.jpg'),
                    ), 
                    array(
                        'id' => 'gallery_placeholder_480x320',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Big gallery items placeholder', 'travelogue'),
                        'compiler' => 'true',
                        'subtitle' => __('Recommended image size: <strong>480x320px</strong>', 'travelogue'),
                        'desc' => __('Use the upload button to import media.', 'travelogue'),
                        'default' => array('url' => get_template_directory_uri()  . '/images/placeholders/480x320px.jpg'),
                    ), 
                    array(
                        'id' => 'gallery_placeholder_next_prev',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Next-Previous gallery item icon placeholder', 'travelogue'),
                        'compiler' => 'true',
                        'subtitle' => __('Recommended image size: <strong>90x90px</strong>', 'travelogue'),
                        'desc' => __('Use the upload button to import media.', 'travelogue'),
                        'default' => array('url' => get_template_directory_uri()  . '/images/placeholders/90x90px.jpg'),
                    ),
                    array(
                        'id'    => 'opt-info-success2',
                        'type'  => 'info',
                        'style' => 'success',
                        'icon'  => 'el-icon-info-sign',
                        'title' => __( 'What is a <strong>Placeholder?</strong>', 'travelogue' ),
                        'desc'  => __( 'If a <strong>gallery item does not have a featured image</strong>, then it will be replaced by one of these images.', 'travelogue' )
                    )

                )
            );

            # Section #7: Social Media Settings

            $this->sections[] = array(
                'icon' => 'el-icon-myspace',
                'title' => __('Social Media Settings', 'travelogue'),
                'fields' => array(
                    array(
                        'id' => 'travelogue_social_fb',
                        'type' => 'text',
                        'title' => __('Facebook URL', 'travelogue'),
                        'subtitle' => __('Type your Facebook url.', 'travelogue'),
                        'validate' => 'url',
                        'default' => 'http://facebook.com'
                    ),
                    array(
                        'id' => 'travelogue_social_pinterest',
                        'type' => 'text',
                        'title' => __('Pinterest URL', 'travelogue'),
                        'subtitle' => __('Type your Pinterest url.', 'travelogue'),
                        'validate' => 'url',
                        'default' => 'http://pinterest.com'
                    ),                    
                    array(
                        'id' => 'travelogue_social_linkedin',
                        'type' => 'text',
                        'title' => __('LinkedIn URL', 'travelogue'),
                        'subtitle' => __('Type your LinkedIn url.', 'travelogue'),
                        'validate' => 'url',
                        'default' => 'http://linkedin.com'
                    ),                    
                    array(
                        'id' => 'travelogue_social_youtube',
                        'type' => 'text',
                        'title' => __('YouTube URL', 'travelogue'),
                        'subtitle' => __('Type your YouTube url.', 'travelogue'),
                        'validate' => 'url',
                        'default' => 'http://youtube.com'
                    ),                    
                    array(
                        'id' => 'travelogue_social_google_plus',
                        'type' => 'text',
                        'title' => __('Google Plus URL', 'travelogue'),
                        'subtitle' => __('Type your Google+ url.', 'travelogue'),
                        'validate' => 'url',
                        'default' => 'http://plus.google.com'
                    ),
                    array(
                        'id' => 'travelogue_social_tw',
                        'type' => 'text',
                        'title' => __('Twitter username', 'travelogue'),
                        'subtitle' => __('Type your Twitter username.', 'travelogue'),
                        'default' => 'google'
                    ),
                    array(
                        'id' => 'travelogue_tw_consumer_key',
                        'type' => 'text',
                        'title' => __('Twitter Consumer Key', 'travelogue'),
                        'subtitle' => __('Type your Twitter Consumer key.', 'travelogue'),
                        'default' => 'iSbkrNtDw51LUizz5ouEkQ'
                    ),
                    array(
                        'id' => 'travelogue_tw_consumer_secret',
                        'type' => 'text',
                        'title' => __('Twitter Consumer Secret key', 'travelogue'),
                        'subtitle' => __('Type your Twitter Consumer Secret key.', 'travelogue'),
                        'default' => 'pZe6vUWyWdHmfDEbGfcAJpu9uJnGeEDrgujuySqk'
                    ),
                    array(
                        'id' => 'travelogue_tw_access_token',
                        'type' => 'text',
                        'title' => __('Twitter Access Token', 'travelogue'),
                        'subtitle' => __('Type your Access Token.', 'travelogue'),
                        'default' => '2385448772-FXizji2NK4imcKoohcVu036VykIp5goymadiiYF'
                    ),
                    array(
                        'id' => 'travelogue_tw_access_token_secret',
                        'type' => 'text',
                        'title' => __('Twitter Access Token Secret', 'travelogue'),
                        'subtitle' => __('Type your Twitter Access Token Secret.', 'travelogue'),
                        'default' => '2wUWJhhnd0ErTCgOYoVokrGKPWV055F9K4Xv5JpOmUL2e'
                    )

                )
            );

            $theme_info = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'travelogue') . '<a href="' . $this->theme->get('ThemeURI') . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'travelogue') . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'travelogue') . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'travelogue') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-1',
                'title' => __('', 'travelogue'),
                'content' => __('', 'travelogue')
            );

            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-2',
                'title' => __('', 'travelogue'),
                'content' => __('', 'travelogue')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('', 'travelogue');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'redux_demo', // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'), // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'), // Version that appears at the top of your panel
                'menu_type' => 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true, // Show the sections below the admin menu item or not
                'menu_title' => __('Travelogue Panel', 'travelogue'),
                'page' => __('Travelogue Theme Panel', 'travelogue'),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyBvtUn7_sSUDBIM6cclbXroP-Bz21hK1mE', // Must be defined to add google fonts to the typography module
                //'admin_bar' => false, // Show the panel pages on the admin bar
                'global_variable' => 'travelogue_redux_options', // Set a different name for your global variable other than the opt_name
                'dev_mode' => false, // Show the time the page took to load, etc
                'customizer' => true, // Enable basic customizer support
                // OPTIONAL -> Give you extra features
                'page_priority' => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options', // Permissions needed to access the options panel.
                'menu_icon' => get_template_directory_uri().'/images/travelogue_theme_panel.png', // Specify a custom URL to an icon
                'last_tab' => '', // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options', // Page slug used to denote the panel
                'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
                'default_show' => false, // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                //'domain'              => 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
                //'footer_credit'       => '', // Disable the footer credit of Redux. Please leave if you can help it.
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'show_import_export' => true, // REMOVE
                'system_info' => false, // REMOVE
                'help_tabs' => array(),
                'help_sidebar' => '', // __( '', $this->args['domain'] );            
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace("-", "_", $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('', 'travelogue'), $v);
            } else {
                $this->args['intro_text'] = __('', 'travelogue');
            }

            // Add content after the form.
            $this->args['footer_text'] = __('', 'travelogue');
        }

    }

    new Redux_Framework_travelogue_config();
}


/**

  Custom function for the callback referenced above

 */
if (!function_exists('redux_my_custom_field')):

    function redux_my_custom_field($field, $value) {
        print_r($field);
        print_r($value);
    }

endif;

/**

  Custom function for the callback validation referenced above

 * */
if (!function_exists('redux_validate_callback_function')):

    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        //$value = 'just testing';
        /*
          do your validation

          if(something) {
          $value = $value;
          } elseif(something else) {
          $error = true;
          $value = $existing_value;
          $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }


endif;
