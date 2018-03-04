<?php

$theme_layouts = ot_get_option('theme_layouts');
$type_layouts = ot_get_option('type_layouts');

?>

<?php if($type_layouts=="fixed"){
    add_action( 'wp_enqueue_scripts', 'lpd_fixed_1170' );
}
if($type_layouts=="responsive"){
    add_action( 'wp_enqueue_scripts', 'lpd_responsive' );
}
if($theme_layouts=="940"&&$type_layouts=="fixed"){
	add_action( 'wp_enqueue_scripts', 'lpd_fixed_960' );
}
if($theme_layouts=="940"&&$type_layouts=="responsive"){
	add_action( 'wp_enqueue_scripts', 'lpd_responsive_960' );
}?>