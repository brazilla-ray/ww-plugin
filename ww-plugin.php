<?php
/**
 * Plugin Name: ww-plugin
 */

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('WWAP') ) :
class WWAP {

	/** @var string The plugin version number. */
  var $version = '1.0.0';
  
  /** @var array The plugin settings array. */
	var $settings = array();
	
	/** @var array The plugin data array. */
	var $data = array();
	
	/** @var array Storage for class instances. */
	var $instances = array();
	
function initialize() {
  // Define constants
  $this->define( 'WWAP', true );
  $this->define( 'WWAP_PATH', plugin_dir_path( __FILE__ ) );
  $this->define( 'WWAP_BASENAME', plugin_basename( __FILE__ ) );
  $this->define( 'WWAP_VERSION', $this->version );
  $this->define( 'WWAP_MAJOR_VERSION', 1 );
  
  // Include utility functions.
  include_once( WWAP_PATH . 'includes/wwap-utility-functions.php');

  // wwap_include('includes/wwap-show-template-file.php');
  wwap_include('includes/wwap-query-functions.php');
  wwap_include('includes/wwap-setup-acf.php');
  wwap_include('includes/wwap-setup-rest.php');
  wwap_include('includes/wwap-setup-cptui-post-types.php');
  wwap_include('includes/wwap-setup-cptui-taxonomies.php');
}


function define( $name, $value = true ) {
  if( !defined($name) ) {
    define( $name, $value );
  }
}

} // End class WWAP definition

function wwap() {
  global $wwap;

  // Instantiate only once
  if ( !isset($wwap) ) {
    $wwap = new WWAP();
    $wwap->initialize();
  }
  return $wwap;
} 

// Instantiate
wwap();

endif; // class_exists check