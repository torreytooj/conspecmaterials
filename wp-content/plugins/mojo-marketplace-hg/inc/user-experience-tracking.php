<?php
/*
This file tracks basic user actions to improve the user experience.
*/

function mm_ux_log( $args = array() ) {
	$url = "https://ssl.google-analytics.com/collect";
	global $title;

	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return;
	}

	$path = explode( 'wp-admin', $_SERVER['REQUEST_URI'] );

	if ( empty( $path ) || empty( $path[1] ) ) {
		return;
	}

	$defaults = array(
		'v'		=> '1',
		'tid'	=> 'UA-39246514-3',
		't'		=> 'pageview', //hit type
		'cid' 	=> md5( get_option( 'siteurl' ) ),
		'uid'	=> md5( get_option( 'siteurl' ) . get_current_user_id() ), //user
		'cn'	=> 'mojo_wp_plugin', //campaign name
		'cs'	=> 'mojo_wp_plugin', //campaign source
		'cm'	=> 'plugin_admin', //campaign medium
		'ul'	=> get_locale(), //language
		'dp'	=> $path[1], //path
		'sc'	=> '', //start or end
		'ua'	=> $_SERVER['HTTP_USER_AGENT'],
		'dl'	=> $path[1],
		'dh'	=> get_option( 'siteurl' ),
		'dt'	=> $title, //title
		'ec'	=> '', //event category
		'ea'	=> '', //event action
		'el'	=> '', //event label
		'ev'	=> ''  //event value
	);
	$params = wp_parse_args( $args, $defaults );
	$query = http_build_query( array_filter( $params ) );
	$args = array(
		'body'		=> $query,
		'method'	=> 'POST',
		'blocking'	=> false
	);
	wp_remote_post( $url, $args );
}
add_action( 'admin_footer', 'mm_ux_log', 90 );

function mm_ux_log_start() {
	$session = array(
		'sc'	=> 'start'
	);
	mm_ux_log( $session );
	$event = array(
		't' => 'event',
		'ec' => 'user_action',
		'ea' => 'login',
	);
	mm_ux_log( $event );
}
add_action( 'wp_login', 'mm_ux_log_start' );

function mm_ux_log_end() {
	$session = array(
		'sc'	=> 'end'
	);
	mm_ux_log( $session );
	$user = get_user_by( 'id', get_current_user_id() );
	$role = $user->roles;
	$event = array(
		't' => 'event',
		'ec' => 'user_action',
		'ea' => 'logout',
		'el' => $role[0],
	);
	mm_ux_log( $event );
}
add_action( 'wp_logout', 'mm_ux_log_end' );

function mm_ux_log_deactivated() {
	$event = array(
		't'		=> 'event',
		'ec'	=> 'plugin_status',
		'ea'	=> 'deactivated',
		'el'	=> 'Install date: ' . get_option( 'mm_install_date', date( 'M d, Y' ) ),
	);
	mm_ux_log( $event );
}

function mm_ux_log_activated() {
	$event = array(
		't'		=> 'event',
		'ec'	=> 'plugin_status',
		'ea'	=> 'activated',
		'el'	=> 'Install date: ' . get_option( 'mm_install_date', date( 'M d, Y' ) ),

	);
	mm_ux_log( $event );
}
$plugin_dir = plugin_dir_path( dirname( __FILE__ ) );
register_activation_hook( $plugin_dir . "mojo-marketplace.php", 'mm_ux_log_activated' );
register_deactivation_hook( $plugin_dir . "mojo-marketplace.php", 'mm_ux_log_deactivated' );

function mm_ux_log_theme_preview() {
	if( isset( $_GET['page'] ) && $_GET['page'] == "mojo-theme-preview" ) {
		global $theme;
		$event = array(
			't'		=> 'event',
			'ec'	=> 'theme_preview',
			'ea'	=> esc_attr( $_GET['items'] ),
			'el'	=> $theme->name
		);
		mm_ux_log( $event );
	}
}
add_action( 'admin_footer', 'mm_ux_log_theme_preview' );

function mm_ux_log_theme_category_org() {
	if( isset( $_GET['browse'] ) ) {
		$category = esc_attr( $_GET['browse'] );
	} else {
		$category = "featured";
	}
	$event = array(
		't'		=> 'event',
		'ec'	=> 'theme_category',
		'ea'	=> 'org',
		'el'	=> $category
	);
	mm_ux_log( $event );
}
add_action( 'admin_footer-theme-install.php', 'mm_ux_log_theme_category_org' );

function mm_ux_log_theme_category_mojo() {
	if( isset( $_GET['page'] ) && $_GET['page'] == "mojo-themes" ) {
		if( isset( $_GET['items'] ) ) {
			$category = esc_attr( $_GET['items'] );
		} else {
			$category = "popular";
		}

		$event = array(
			't'		=> 'event',
			'ec'	=> 'theme_category',
			'ea'	=> 'mojo',
			'el'	=> $category
		);
		mm_ux_log( $event );
	}
}
add_action( 'admin_footer', 'mm_ux_log_theme_category_mojo' );

function mm_ux_log_plugin_version() {
	if( ! function_exists( 'get_plugin_data' ) ) {
		return;
	}
	$plugin_dir = plugin_dir_path( dirname( __FILE__ ) );
	$plugin = get_plugin_data( $plugin_dir . 'mojo-marketplace.php' );
	$event = array(
		't'		=> 'event',
		'ec'	=> 'scheduled',
		'ea'	=> 'plugin_version',
		'el'	=> $plugin['Version']
	);
	mm_ux_log( $event );
}
add_action( 'mm_cron_daily', 'mm_ux_log_plugin_version' );

function mm_ux_log_wp_version() {
	global $wp_version;
	$event = array(
		't'		=> 'event',
		'ec'	=> 'scheduled',
		'ea'	=> 'wp_version',
		'el'	=> $wp_version
	);
	mm_ux_log( $event );
}
add_action( 'mm_cron_daily', 'mm_ux_log_wp_version' );

function mm_ux_log_plugin_count() {
	$plugins = get_option( 'active_plugins' );
	$event = array(
		't'		=> 'event',
		'ec'	=> 'scheduled',
		'ea'	=> 'plugin_count',
		'el'	=> count( $plugins )
	);
	mm_ux_log( $event );
}
add_action( 'mm_cron_daily', 'mm_ux_log_plugin_count' );

function mm_ux_log_theme_count() {
	$theme_root = get_theme_root();
	$files = glob( $theme_root . "/*" );
	$count = 0;
	foreach ( $files as $file ) {
		if( is_dir( $file ) ) {
			$count++;
		}
	}
	$event = array(
		't'		=> 'event',
		'ec'	=> 'scheduled',
		'ea'	=> 'theme_count',
		'el'	=> $count
	);
	mm_ux_log( $event );
}
add_action( 'mm_cron_daily', 'mm_ux_log_theme_count' );

function mm_ux_log_plugin_search() {
	if( isset( $_GET['tab'] ) && isset( $_GET['s'] ) ) {
		$event = array(
			't'		=> 'event',
			'ec'	=> 'user_action',
			'ea'	=> 'plugin_search',
			'el'	=> esc_attr( $_GET['s'] )
		);
		mm_ux_log( $event );
	}
}
add_action( 'admin_footer-plugin-install.php', 'mm_ux_log_plugin_search' );

function mm_ux_log_content_status( $new_status, $old_status, $post ) {
	$status = array( 'draft', 'pending', 'publish', 'new', 'future', 'private', 'trash' );
	if ( $old_status !== $new_status && in_array( $new_status, $status ) ) {
		//Status has changed
		$event = array(
			't'		=> 'event',
			'ec'	=> 'user_action',
			'ea'	=> 'content_status',
			'el'	=> $new_status
		);
		mm_ux_log( $event );
	}
}
add_action( 'transition_post_status', 'mm_ux_log_content_status', 10, 3 );
