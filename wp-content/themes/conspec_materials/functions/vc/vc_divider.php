<?php

function vc_divider_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'height' => '',
   ), $atts ) );
   
	$out = '';
	
	$out .= '<div class="vc_divider" style="height:'.$height.'px"></div>';
	
    return $out;
}
add_shortcode( 'vc_divider', 'vc_divider_func' );


vc_map(array(
   "name" => __("Divider", GETTEXT_DOMAIN),
   "base" => "vc_divider",
   "class" => "",
   "icon" => "icon-wpb-lpd",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Divider Height", GETTEXT_DOMAIN),
			"param_name" => "height",
			"value" => array(__('5 pixels', GETTEXT_DOMAIN) => "5", __('10 pixels', GETTEXT_DOMAIN) => "10", __('20 pixels', GETTEXT_DOMAIN) => "20", __('30 pixels', GETTEXT_DOMAIN) => "30", __('40 pixels', GETTEXT_DOMAIN) => "40"),
			"description" => __("Select divider height.", GETTEXT_DOMAIN)
		)
   )
));

?>