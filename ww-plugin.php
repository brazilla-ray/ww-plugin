<?php
/**
 * Plugin Name: ww-plugin
 */

 // Modify query to show wwa_artwork on front page
 add_action( 'pre_get_posts', 'wwa_show_artwork_on_front_page' );
 function wwa_show_artwork_on_front_page( $query ) {
   if(
     is_front_page() &&
     empty( $query->query_vars['supress_filters'] ) &&
     $query->is_main_query()
   ) {
     $query->set( 'post_type', array(
       'wwa_artwork'
     ) );
     $query->set( 'tag', array(
       'recent'
     ) );
   }
 }

 // Show which template file is being used
 add_action( 'wp_footer', 'wwa_show_template_file' );
 function wwa_show_template_file() {
   global $template;
   print_r( $template );
 }