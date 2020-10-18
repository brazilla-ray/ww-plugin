<?php 
function cptui_register_my_cpts() {

	/**
	 * Post Type: Artwork.
	 */

	$labels = [
		"name" => __( "Artwork", "ww-theme" ),
		"singular_name" => __( "Artwork", "ww-theme" ),
	];

	$args = [
		"label" => __( "Artwork", "ww-theme" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => [ "slug" => "artwork", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-admin-customizer",
		"supports" => [ "title", "editor", "thumbnail" ],
		"taxonomies" => [ "post_tag", "wwa_type" ],
	];

	register_post_type( "wwa_artwork", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );
