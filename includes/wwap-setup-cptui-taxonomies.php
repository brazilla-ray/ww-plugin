<?php

function cptui_register_my_taxes() {

/**
 * Taxonomy: Types.
 */

$labels = [
  "name" => __( "Types", "ww-theme" ),
  "singular_name" => __( "Type", "ww-theme" ),
  "menu_name" => __( "Type", "ww-theme" ),
];

$args = [
  "label" => __( "Types", "ww-theme" ),
  "labels" => $labels,
  "public" => true,
  "publicly_queryable" => true,
  "hierarchical" => true,
  "show_ui" => true,
  "show_in_menu" => true,
  "show_in_nav_menus" => true,
  "query_var" => true,
  "rewrite" => [ 'slug' => 'type', 'with_front' => true,  'hierarchical' => true, ],
  "show_admin_column" => false,
  "show_in_rest" => true,
  "rest_base" => "wwa_type",
  "rest_controller_class" => "WP_REST_Terms_Controller",
  "show_in_quick_edit" => false,
    ];
register_taxonomy( "wwa_type", [ "wwa_artwork" ], $args );

/**
 * Taxonomy: Sizes.
 */

$labels = [
  "name" => __( "Sizes", "ww-theme" ),
  "singular_name" => __( "Size", "ww-theme" ),
  "menu_name" => __( "Size", "ww-theme" ),
];

$args = [
  "label" => __( "Sizes", "ww-theme" ),
  "labels" => $labels,
  "public" => true,
  "publicly_queryable" => true,
  "hierarchical" => true,
  "show_ui" => true,
  "show_in_menu" => true,
  "show_in_nav_menus" => true,
  "query_var" => true,
  "rewrite" => [ 'slug' => 'size', 'with_front' => true,  'hierarchical' => true, ],
  "show_admin_column" => false,
  "show_in_rest" => true,
  "rest_base" => "wwa_size",
  "rest_controller_class" => "WP_REST_Terms_Controller",
  "show_in_quick_edit" => true,
    ];
register_taxonomy( "wwa_size", [ "wwa_artwork" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes' );
