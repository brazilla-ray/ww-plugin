<?php
/**
 * Plugin Name: ww-plugin
 */

function ww_custom_post_artwork() {
  register_post_type( 'ww_artwork',
    array(
      'labels' => array(
        'name' => __( 'Artwork', 'textdomain' ),
        'singular_name' => __( 'Artwork', 'textdomain' ),
      ),
        'public'      => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'supports' => array( 'title', 'editor', 'custom-fields' ),
        'rewrite'     => array( 'slug' => 'artwork' ),
        'description' => ( 'Custom post type for displaying artwork' ),
    )
  );
}
add_action( 'init', 'ww_custom_post_artwork' );