<?php

/*
  Plugin Name: WP - Meet the Team Shortcode v2
  Plugin URI: http://meet-the-team.jeffreycarandang.com/
  Description: With this plugin it is possible to create, organize and customize your team page easily. This plugin uses custom post type to manage your members and powered by shortcodes to show your team members beautifully on the frontend.
  Author: Jeffrey Carandang
  Version: 2.0
  Author URI: http://jeffreycarandang.com/
 */


//avoid direct calls to this file

if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

add_filter('widget_text', 'do_shortcode');

/*##################################
	ADD IMAGE SIZE
################################## */
add_image_size( 'wpmtpv2-thumb', 250, 250, true );
add_image_size( 'wpmtpv2-single', 300, 300, false );
add_image_size( 'wpmtpv2-admin-thumb', 90, 90, true );

/*##################################
	SET DEFAULT OPTIONS
################################## */
function WPMTPv2_DEFAULTS(){
	$options=get_option('wpmtpv2-setting');
	if(empty($options)){

		$defaults = array(
			'fields'	=>		array(
					'job_title'		=>		array(
												'label'	=>	'Job Title',
												'key'	=>	'job_title',
												'visibility'	=>	1,
												'disable'	=>	1
											),
					'location'		=>		array(
												'label'	=>	'Location',
												'key'	=>	'location',
												'visibility'	=>	1,
												'disable'	=>	1
											),
					'contact'		=>		array(
												'label'	=>	'Contact',
												'key'	=>	'contact',
												'visibility'	=>	1,
												'disable'	=>	0
											),
					'email'		=>		array(
												'label'	=>	'Email',
												'key'	=>	'email',
												'visibility'	=>	1,
												'disable'	=>	1
											),
					'website'		=>		array(
												'label'	=>	'Website',
												'key'	=>	'website',
												'visibility'	=>	1,
												'disable'	=>	0
											)
				),
			'socials'	=>		array(
					'envelope'		=>		array(
												'label'	=>	'Email',
												'key'	=>	'envelope',
												'visibility'	=>	1,
												'disable'	=>	1
											),
					'suitcase'		=>		array(
												'label'	=>	'Portfolio',
												'key'	=>	'suitcase',
												'visibility'	=>	1,
												'disable'	=>	1
											),
					'facebook'		=>		array(
												'label'	=>	'Facebook',
												'key'	=>	'facebook',
												'visibility'	=>	1,
												'disable'	=>	1
											),
					'twitter'		=>		array(
												'label'	=>	'Twitter',
												'key'	=>	'twitter',
												'visibility'	=>	1,
												'disable'	=>	1
											),
					'gplus'		=>		array(
												'label'	=>	'Google+',
												'key'	=>	'gplus',
												'visibility'	=>	1,
												'disable'	=>	1
											),
					'linkedin'		=>		array(
												'label'	=>	'Linkedin',
												'key'	=>	'linkedin',
												'visibility'	=>	1,
												'disable'	=>	1
											),
					'youtube'		=>		array(
												'label'	=>	'Youtube',
												'key'	=>	'youtube',
												'visibility'	=>	1,
												'disable'	=>	1
											),
					'pinterest'		=>		array(
												'label'	=>	'Pinterest',
												'key'	=>	'pinterest',
												'visibility'	=>	1,
												'disable'	=>	1
											),
					'github'		=>		array(
												'label'	=>	'Github',
												'key'	=>	'github',
												'visibility'	=>	1,
												'disable'	=>	1
											),
					'flickr'		=>		array(
												'label'	=>	'Flickr',
												'key'	=>	'flickr',
												'visibility'	=>	1,
												'disable'	=>	1
											),
					'instagram'		=>		array(
												'label'	=>	'Instagram',
												'key'	=>	'instagram',
												'visibility'	=>	1,
												'disable'	=>	1
											),
					'dribbble'		=>		array(
												'label'	=>	'Dribbble',
												'key'	=>	'dribbble',
												'visibility'	=>	1,
												'disable'	=>	1
											),
					'tumblr'		=>		array(
												'label'	=>	'Tumblr',
												'key'	=>	'tumblr',
												'visibility'	=>	1,
												'disable'	=>	1
											),
					'skype'		=>		array(
												'label'	=>	'Skype',
												'key'	=>	'skype',
												'visibility'	=>	1,
												'disable'	=>	1
											),
				),
			'thumbx'		=>		250,
			'thumby'		=>		250,
			'bannerx'		=>		300,
			'bannery'		=>		300,
			'social'		=>		'colored',
			'shape'			=>		'rounded',
			'more_text'		=>		'View Profile',
			'singular'		=>		'Member',
			'plural'		=>		'Team',
			'category'		=>		'Groups',
			'slug'			=>		'team'
		);
		$defaults = serialize($defaults);
		update_option('wpmtpv2-setting',$defaults);
	}
}
add_action('init','WPMTPv2_DEFAULTS',1);

/*##################################
	SETTINGS
################################## */

define('WPMTPv2_SHORT', 'wptmpv2');
define('WPMTPv2_VERSION', '2.0');
define('WPMTPv2_URL', WP_PLUGIN_DIR . '/meet_the_team'); 
define('WPMTPv2_URI', plugins_url() . '/meet_the_team'); 
define('WPMTPv2_IMG', WPMTPv2_URI . '/lib/images');
define('WPMTPv2_CORE', WPMTPv2_URL .'/core');
define('WPMTPv2_ADMIN', WPMTPv2_URL .'/admin');
define('WPMTPv2_VIEWS', WPMTPv2_URL .'/views');
define('WPMTPv2_LIB', WPMTPv2_URL .'/lib');
define('WPMTPv2_SCRIPTS', WPMTPv2_URI .'/lib/js');
define('WPMTPv2_STYLES', WPMTPv2_URI .'/lib/css');



/*##################################
	REQUIRE
################################## */

require_once( WPMTPv2_ADMIN. '/functions.admin-setting.php');
require_once( WPMTPv2_CORE. '/functions.meta-box.php');
require_once( WPMTPv2_CORE. '/functions.post-type.php');
require_once( WPMTPv2_CORE. '/functions.image.php');
require_once( WPMTPv2_CORE. '/functions.enqueue.php');
// require_once( WPMTP_CORE. '/functions.social-media.php');
require_once( WPMTPv2_CORE. '/functions.shortcodes.php');
require_once( WPMTPv2_CORE. '/functions.single-member.php');
require_once( WPMTPv2_ADMIN. '/functions.shortcode-generator.php');
if(!function_exists('CPTO_activated'))
	require_once( WPMTPv2_LIB . '/post-types-order/post-types-order.php');



/*##################################
	OPTIONS
################################## */
function WPMTPv2_OPTIONS(){
	$options=get_option('wpmtpv2-setting');
	$options=maybe_unserialize($options);
	return (object) $options;
}

/*##################################
	FIELDS META
################################## */
function WPMTPv2_FIELDS($postid){
	$meta = array();

	$fields = WPMTPv2_OPTIONS()->fields;
	foreach($fields as $field){
		$meta[$field['key']]=get_post_meta($postid,'_wpmtp_' . $field['key'],true);
	}
	
	return $meta;
}

/*##################################
	SOCIALS META
################################## */
function WPMTPv2_SOCIALS($postid){
	$meta = array();

	$fields = WPMTPv2_OPTIONS()->socials;
	foreach($fields as $field){
		$meta[$field['key']]=get_post_meta($postid,'_wpmtp_' . $field['key'],true);
	}
	
	return $meta;
}