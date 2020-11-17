<?php

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

 // Modify query to show all posts on a single page
 add_action( 'pre_get_posts', 'wwa_all_posts_on_one_page' );
 function wwa_all_posts_on_one_page( $query ) {
   if(
     ! is_admin() &&
     $query->is_main_query()
   ) {
     $query->set( 'posts_per_page', -1 );
    //  $query->set( 'orderby', 'rand');
     return;
   }
 }
