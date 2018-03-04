<?php
/*
Plugin Name: Logo Carousel Slider
Description: Logo Carousel is a Premium logo display plugin for WordPress 3+.
Plugin URI: http://www.alchemythemes.com/
Author: AlchemyThemes
Version: 0.2
Author URI: http://www.alchemythemes.com/
*/

define('AT_LOGOCAR_PLUGIN', 	'AlchemyThemes Logo Carousel');
define('AT_LOGOCAR_LANG', 		'alchemythemes-logo-carousel');
define('AT_LOGOCAR_VERSION', 	'0.1');
load_plugin_textdomain(AT_LOGOCAR_LANG, false, basename(dirname( __FILE__  )).'/localization' );

// Load scripts and styles for the wp-admin
add_action('admin_enqueue_scripts', 'at_logocar_load_admin_scripts');
function at_logocar_load_admin_scripts() {
	wp_enqueue_script( 'wp-color-picker' );
}

add_action( 'admin_init', 'at_init_gallery_posty_type_style' );
function at_init_gallery_posty_type_style() {
	wp_register_style( AT_GALLERY_LANG, plugins_url('at-gallery.css', __FILE__) );
	wp_enqueue_style( AT_GALLERY_LANG );
	wp_enqueue_style( 'wp-color-picker' );
}

// Load scripts and styles for the front-end
add_action('wp_enqueue_scripts', 'at_logocar_load_frontend_scripts');
function at_logocar_load_frontend_scripts() {
	$at_logocarousel_options = get_option('at_logocarousel_options');
	
	wp_enqueue_style( 'at_logocarousel_style', 					plugin_dir_url(__FILE__).'includes/at.logocarousel.css' );
	
	if (!isset($at_logocarousel_options['waitforimages']) || $at_logocarousel_options['waitforimages'] != 'disabled') {
		// Wait for images
		wp_enqueue_script( 'at_logocarousel_script_waitforit', 		plugin_dir_url(__FILE__).'includes/jquery.waitforimages.js', 	array('jquery'), 							AT_LOGOCAR_VERSION, true );
	}
	
	if (!isset($at_logocarousel_options['smartresize']) || $at_logocarousel_options['smartresize'] != 'disabled') {
		// Smart resize
		wp_enqueue_script( 'at_logocarousel_script_smartresize', 	plugin_dir_url(__FILE__).'includes/jquery.debouncedresize.js', 	array('jquery'), 							AT_LOGOCAR_VERSION, true );
	}
	
	// LogoCarousel
	wp_enqueue_script( 'at_logocarousel_script', 				plugin_dir_url(__FILE__).'includes/jquery.at.logocarousel.min.js', 	array('at_logocarousel_script_waitforit'), 	AT_LOGOCAR_VERSION, true );
}


// Includes
include_once('includes/at-logocarousel-back.php');
include_once('includes/at-logocarousel-front.php');

// Autoupdate
include_once('includes/at-autoupdate.php');
function at_logo_auto_update_init() {
	$at_logocarousel_options = get_option('at_logocarousel_options');
	$cc_username = $at_logocarousel_options['cc_username'];
	$cc_key = $at_logocarousel_options['cc_license_key'];
	
	new at_auto_update(AT_LOGOCAR_VERSION, 'http://repository.alchemythemes.com/at-logocarousel/update.php?user='.$cc_username.'&key='.$cc_key, plugin_basename(__FILE__));
}
add_action('init', 'at_logo_auto_update_init');


// Parse color string
if (!function_exists('at_parseColor')) {
	function at_parseColor($color) {
		if ( substr( $color, 0, 1 ) != "#" ) { $color = '#'.$color; }
		return $color;
	}
}
?>