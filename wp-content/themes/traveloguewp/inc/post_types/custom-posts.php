<?php
/**
 * Custom Post Type [Gallery]
 */
function travelogue_gallery_custom_post() {
	register_post_type('Gallery', array(
						'label' => __('Gallery','travelogue'),
						'description' => '',
						'public' => true,
						'show_ui' => true,
						'show_in_menu' => true,
						'capability_type' => 'post',
						'map_meta_cap' => true,
						'hierarchical' => false,
						'rewrite' => array('slug' => 'gallery', 'with_front' => true),
						'query_var' => true,
						'menu_position' => '1',
						'menu_icon' => 'dashicons-format-gallery',
						'supports' => array('title','editor','thumbnail','author','excerpt'),
						'labels' => array (
							'name' => __('Gallery','travelogue'),
							'singular_name' => __('Gallery','travelogue'),
							'menu_name' => __('Gallery','travelogue'),
							'add_new' => __('Add Gallery Item','travelogue'),
							'add_new_item' => __('Add New Gallery Item','travelogue'),
							'edit' => __('Edit','travelogue'),
							'edit_item' => __('Edit Gallery','travelogue'),
							'new_item' => __('New Gallery','travelogue'),
							'view' => __('View Gallery','travelogue'),
							'view_item' => __('View Gallery','travelogue'),
							'search_items' => __('Search Gallery','travelogue'),
							'not_found' => __('No Gallery Found','travelogue'),
							'not_found_in_trash' => __('No Gallery Found in Trash','travelogue'),
							'parent' => __('Parent Gallery','travelogue'),
							)
						) 
					); 
}
add_action('init', 'travelogue_gallery_custom_post');



function travelogue_gallery_custom_post_category() {
    register_taxonomy( 'gallery_category',array (
                                          0 => 'gallery',
                                        ),
                                    array( 'hierarchical' => true,
                                        'label' => __('Categories','polygon'),
                                        'show_ui' => true,
                                        'query_var' => true,
                                        'show_admin_column' => false,
                                        'labels' => array (
                                                        'search_items' => 'category',
                                                        'popular_items' => '',
                                                        'all_items' => '',
                                                        'parent_item' => '',
                                                        'parent_item_colon' => '',
                                                        'edit_item' => '',
                                                        'update_item' => '',
                                                        'add_new_item' => '',
                                                        'new_item_name' => 'webdesign',
                                                        'separate_items_with_commas' => '',
                                                        'add_or_remove_items' => '',
                                                        'choose_from_most_used' => '',
                                                        )
                                        )
                        ); 
}
add_action('init', 'travelogue_gallery_custom_post_category');
?>