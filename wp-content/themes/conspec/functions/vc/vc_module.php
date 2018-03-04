<?php

function vc_module_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'image' => '',
      'scale' => '',
      'title' => '',
      'url' => ''
   ), $atts ) );
   
   $image_cropped = wp_get_attachment_image_src( $image, 'module' );
 
	$out = '';
	$no_scale = '';
	
	if($title){
		$title='<h3>'.$title.'</h3>';
	}
	
	if($title){
		$module_content='<span class="module_content"><table><tbody><tr><td style="vertical-align:middle">'.$title.'<div class="sep-border"></div></tr></tbody></table></span>';
	}
	
	if($scale){
		$no_scale='module-no-scale';
	}
	
	$out .= '<a href="'.$url.'" class="lpd-module'.$no_scale.'"><img class="img-responsive" src="'.$image_cropped[0].'">'.$module_content.'</a>';
	
    return $out;
}
add_shortcode( 'vc_module', 'vc_module_func' );


vc_map(array(
   "name" => __("Module", GETTEXT_DOMAIN),
   "base" => "vc_module",
   "class" => "",
   "icon" => "icon-wpb-lpd",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
	    array(
	      "type" => "attach_image",
	      "heading" => __("Image", GETTEXT_DOMAIN),
	      "param_name" => "image",
	      "value" => "",
	      "description" => __("Select image from media library.", GETTEXT_DOMAIN)
	    ),
    array(
      "type" => 'checkbox',
      "heading" => __("Thumbnail Scale", GETTEXT_DOMAIN),
      "param_name" => "scale",
      "description" => __("If selected, thumbnail scale will be disabled.", GETTEXT_DOMAIN),
      "value" => Array(__("disable", GETTEXT_DOMAIN) => 'disable')
    ),
		array(
			 "type" => "textarea",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title", GETTEXT_DOMAIN),
			 "param_name" => "title",
			 "value" => __("LOREM IMSUM DOLOR", GETTEXT_DOMAIN),
			 "description" => __("Enter your title.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Url (link)", GETTEXT_DOMAIN),
			 "param_name" => "url",
			 "value" => __("#", GETTEXT_DOMAIN),
			 "description" => __("Module link.", GETTEXT_DOMAIN)
		)
   )
));

?>