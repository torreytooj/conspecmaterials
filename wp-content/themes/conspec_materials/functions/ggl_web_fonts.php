<?php

function lpd_ggl_web_font() {

	$body_font_family = ot_get_option('body_font_family');
	
	if ($body_font_family==""){
		$body_font_family = "Lato";
	}
	
	$heading_font_family = ot_get_option('heading_font_family');
	
	if ($heading_font_family==""){
		$heading_font_family = "Lato";
	}
	
	$new_body_font_family = $new_heading_font_family = '';
	
	if($body_font_family!=$heading_font_family){
		if($heading_font_family == 'Open+Sans'
		|| $heading_font_family == 'Titillium+Web'
		|| $heading_font_family == 'Oxygen'
		|| $heading_font_family == 'Quicksand'
		|| $heading_font_family == 'Lato'
		|| $heading_font_family == 'Raleway'
		|| $heading_font_family == 'Source+Sans+Pro'
		|| $heading_font_family == 'Dosis'
		|| $heading_font_family == 'Exo'
		|| $heading_font_family == 'Arvo'
		|| $heading_font_family == 'Vollkorn'
		|| $heading_font_family == 'Ubuntu'
		|| $heading_font_family == 'PT+Sans'
		|| $heading_font_family == 'PT+Serif'
		|| $heading_font_family == 'Droid+Sans'
		|| $heading_font_family == 'Droid+Serif'
		|| $heading_font_family == 'Cabin'
		|| $heading_font_family == 'Lora'
		|| $heading_font_family == 'Oswald'
		|| $heading_font_family == 'Varela+Round'
		|| $heading_font_family == 'Unna'
		|| $heading_font_family == 'Rokkitt'
		|| $heading_font_family == 'Merriweather'
		|| $heading_font_family == 'Bitter'
		|| $heading_font_family == 'Kreon'
		|| $heading_font_family == 'Playfair+Display'
		|| $heading_font_family == 'Roboto+Slab'
		|| $heading_font_family == 'Bree+Serif'
		|| $heading_font_family == 'Libre+Baskerville'
		|| $heading_font_family == 'Cantata+One'
		|| $heading_font_family == 'Alegreya'
		|| $heading_font_family == 'Noto+Serif'
		|| $heading_font_family == 'EB+Garamond'
		|| $heading_font_family == 'Noticia+Text'
		|| $heading_font_family == 'Old+Standard+TT'
		|| $heading_font_family == 'Crimson+Text'){
			$new_heading_font_family = $heading_font_family .':400,700,900,700italic,400italic|';
		}
	}
	
	if($body_font_family == 'Open+Sans'
	|| $body_font_family == 'Titillium+Web'
	|| $body_font_family == 'Oxygen'
	|| $body_font_family == 'Quicksand'
	|| $body_font_family == 'Lato'
	|| $body_font_family == 'Raleway'
	|| $body_font_family == 'Source+Sans+Pro'
	|| $body_font_family == 'Dosis'
	|| $body_font_family == 'Exo'
	|| $body_font_family == 'Arvo'
	|| $body_font_family == 'Vollkorn'
	|| $body_font_family == 'Ubuntu'
	|| $body_font_family == 'PT+Sans'
	|| $body_font_family == 'PT+Serif'
	|| $body_font_family == 'Droid+Sans'
	|| $body_font_family == 'Droid+Serif'
	|| $body_font_family == 'Cabin'
	|| $body_font_family == 'Lora'
	|| $body_font_family == 'Oswald'
	|| $body_font_family == 'Varela+Round'
	|| $body_font_family == 'Unna'
	|| $body_font_family == 'Rokkitt'
	|| $body_font_family == 'Merriweather'
	|| $body_font_family == 'Bitter'
	|| $body_font_family == 'Kreon'
	|| $body_font_family == 'Playfair+Display'
	|| $body_font_family == 'Roboto+Slab'
	|| $body_font_family == 'Bree+Serif'
	|| $body_font_family == 'Libre+Baskerville'
	|| $body_font_family == 'Cantata+One'
	|| $body_font_family == 'Alegreya'
	|| $body_font_family == 'Noto+Serif'
	|| $body_font_family == 'EB+Garamond'
	|| $body_font_family == 'Noticia+Text'
	|| $body_font_family == 'Old+Standard+TT'
	|| $body_font_family == 'Crimson+Text'){
		$new_body_font_family = $body_font_family .':400,700,900,700italic,400italic|';
	}
	
	if (!is_admin()) {
		wp_register_style('lpd_ggl_web_font', 'http://fonts.googleapis.com/css?family='. $new_body_font_family .''. $new_heading_font_family .'');
		wp_enqueue_style('lpd_ggl_web_font');
	} 
  
}

?>