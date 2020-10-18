<?php

 // Show which template file is being used
 add_action( 'wp_footer', 'wwa_show_template_file' );
 function wwa_show_template_file() {
   global $template;
   print_r( $template );
   echo '</br>';
   print_r( '||||' );
 }
