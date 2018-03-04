<?php

/*
 * WP - Meet the Team Shortcode v2
 * http://meet-the-team.jeffreycarandang.com/
 *
 * Date: Friday, 19 Jul 2013
 */

/*##################################
	SCRIPTS AND STYLE
################################## */

add_action( 'wp_enqueue_scripts', 'wpmtpv2_register_scripts' );

function wpmtpv2_register_scripts(){
	wp_register_style( 'wpmtp-css', WPMTPv2_STYLES . '/team.css' );
	wp_register_style( 'bootstrap-tooltip', WPMTPv2_STYLES . '/bootstrap-tooltip.css' );

	wp_register_script( 'browser', WPMTPv2_SCRIPTS. '/jquery.browser.js', array( 'jquery' ));
	wp_register_script( 'carouFredSel', WPMTPv2_SCRIPTS. '/jquery.carouFredSel-6.2.1-packed.js', array( 'jquery' ));
	wp_register_script( 'jquery-easing', WPMTPv2_SCRIPTS. '/jquery.easing.js', array( 'jquery' ));
	wp_register_script( 'bootstrap-tooltip', WPMTPv2_SCRIPTS. '/bootstrap-tooltip.js', array( 'jquery' ));
	wp_register_script( 'wpmtp', WPMTPv2_SCRIPTS. '/custom.js', array( 'jquery' ));

	wp_enqueue_style( 'wpmtp-css' );
	wp_enqueue_style( 'bootstrap-tooltip' );
	wp_enqueue_script( 'browser' );
	wp_enqueue_script( 'carouFredSel' );
	wp_enqueue_script( 'jquery-easing' );
	wp_enqueue_script( 'bootstrap-tooltip' );
	wp_enqueue_script( 'wpmtp' );
}

add_action('wp_head', 'wpmtpv2_head_scripts');
function wpmtpv2_head_scripts(){
	echo '<!--[if IE]>';
    echo '<script src="'. WPMTPv2_SCRIPTS. '/iefix.js' .'"></script>';
    echo '<![endif]-->';
}
?>