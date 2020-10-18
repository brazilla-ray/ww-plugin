<?php

function wwap_get_path( $filename = '' ) {
  return WWAP_PATH . ltrim($filename, '/');
}

function wwap_include( $filename = '' ) {
  $file_path = wwap_get_path($filename);
  if( file_exists($file_path) ) {
    include_once($file_path);
  }
}