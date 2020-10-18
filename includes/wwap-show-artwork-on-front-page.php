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

 