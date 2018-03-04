<?php function lpd_fonts_styles() {
	
	require_once(ABSPATH .'/wp-admin/includes/plugin.php');
	
?>

<?php $body_font_family = ot_get_option('body_font_family');
	
	if ($body_font_family==""){
		$body_font_family = "Lato";
	}
?>

<?php $heading_font_family = ot_get_option('heading_font_family');
	
	if ($heading_font_family==""){
		$heading_font_family = "Lato";
	}
?>

<?php $body_font_size  = ot_get_option('body_font_size');
	
	if ($body_font_size == ""){
		$body_font_size  = "13";
	}
?>

<?php $navigation_font_size  = ot_get_option('navigation_font_size');
	
	if ($navigation_font_size == ""){
		$navigation_font_size  = "13";
	}
?>

<?php $dropdown_font_size  = ot_get_option('dropdown_font_size');
	
	if ($dropdown_font_size == ""){
		$dropdown_font_size  = "13";
	}
?>

<style>

.dropdown-menu section li a,
.dropdown-menu > li > a{
	font-size: <?php echo $dropdown_font_size;?>px;
}

.navbar-nav > li > a{
	font-size: <?php echo $navigation_font_size;?>px;
}

<?php if (is_plugin_active('woocommerce/woocommerce.php')) {?>
.wordpress-456industry.woocommerce-page #payment div.payment_box,
.input-text,
#shipping_country,
#billing_country,
#calc_shipping_state{
	font-size: <?php echo $body_font_size;?>px;
}
<?php }?>

.dropdown-header,
.dropdown-menu,
.form-control,
body{
	font-size: <?php echo $body_font_size;?>px;
}

body{
	font-family:
    <?php if($body_font_family == 'Open+Sans'){
        echo "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Titillium+Web'){
        echo "'Titillium Web', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Oxygen'){
        echo "'Oxygen', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Quicksand'){
        echo "'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Lato'){
        echo "'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Raleway'){
        echo "'Raleway', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Source+Sans+Pro'){
        echo "'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Dosis'){
        echo "'Dosis', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Exo'){
        echo "'Exo', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Arvo'){
        echo "'Arvo', serif";
    }elseif($body_font_family == 'Vollkorn'){
        echo "'Vollkorn', serif";
    }elseif($body_font_family == 'Ubuntu'){
        echo "'Ubuntu', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'PT+Sans'){
        echo "'PT Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'PT+Serif'){
        echo "'PT Serif', serif";
    }elseif($body_font_family == 'Droid+Sans'){
        echo "'Droid Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Droid+Serif'){
        echo "'Droid Serif', serif";
    }elseif($body_font_family == 'Cabin'){
        echo "'Cabin', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Lora'){
        echo "'Lora', serif";
    }elseif($body_font_family == 'Oswald'){
        echo "'Oswald', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Varela+Round'){
        echo "'Varela Round', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Unna'){
        echo "'Unna', serif";
    }elseif($body_font_family == 'Rokkitt'){
        echo "'Rokkitt', serif";
    }elseif($body_font_family == 'Merriweather'){
        echo "'Merriweather', serif";
    }elseif($body_font_family == 'Bitter'){
        echo "'Bitter', serif";
    }elseif($body_font_family == 'Kreon'){
        echo "'Kreon', serif";
    }elseif($body_font_family == 'Playfair+Display'){
        echo "'Playfair Display', serif";
    }elseif($body_font_family == 'Roboto+Slab'){
        echo "'Roboto Slab', serif";
    }elseif($body_font_family == 'Bree+Serif'){
        echo "'Bree Serif', serif";
    }elseif($body_font_family == 'Libre+Baskerville'){
        echo "'Libre Baskerville', serif";
    }elseif($body_font_family == 'Cantata+One'){
        echo "'Cantata One', serif";
    }elseif($body_font_family == 'Alegreya'){
        echo "'Alegreya', serif";
    }elseif($body_font_family == 'Noto+Serif'){
        echo "'Noto Serif', serif";
    }elseif($body_font_family == 'EB+Garamond'){
        echo "'EB Garamond', serif";
    }elseif($body_font_family == 'Noticia+Text'){
        echo "'Noticia Text', serif";
    }elseif($body_font_family == 'Old+Standard+TT'){
        echo "'Old Standard TT', serif";
    }elseif($body_font_family == 'Crimson+Text'){
        echo "'Crimson Text', serif";
    }else{
       echo $body_font_family; 
    }?>;
}

h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6 {
	font-family:
    <?php if($heading_font_family == 'Open+Sans'){
        echo "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Titillium+Web'){
        echo "'Titillium Web', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Oxygen'){
        echo "'Oxygen', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Quicksand'){
        echo "'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Lato'){
        echo "'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Raleway'){
        echo "'Raleway', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Source+Sans+Pro'){
        echo "'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Dosis'){
        echo "'Dosis', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Exo'){
        echo "'Exo', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Arvo'){
        echo "'Arvo', serif";
    }elseif($heading_font_family == 'Vollkorn'){
        echo "'Vollkorn', serif";
    }elseif($heading_font_family == 'Ubuntu'){
        echo "'Ubuntu', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'PT+Sans'){
        echo "'PT Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'PT+Serif'){
        echo "'PT Serif', serif";
    }elseif($heading_font_family == 'Droid+Sans'){
        echo "'Droid Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Droid+Serif'){
        echo "'Droid Serif', serif";
    }elseif($heading_font_family == 'Cabin'){
        echo "'Cabin', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Lora'){
        echo "'Lora', serif";
    }elseif($heading_font_family == 'Oswald'){
        echo "'Oswald', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Varela+Round'){
        echo "'Varela Round', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Unna'){
        echo "'Unna', serif";
    }elseif($heading_font_family == 'Rokkitt'){
        echo "'Rokkitt', serif";
    }elseif($heading_font_family == 'Merriweather'){
        echo "'Merriweather', serif";
    }elseif($heading_font_family == 'Bitter'){
        echo "'Bitter', serif";
    }elseif($heading_font_family == 'Kreon'){
        echo "'Kreon', serif";
    }elseif($heading_font_family == 'Playfair+Display'){
        echo "'Playfair Display', serif";
    }elseif($heading_font_family == 'Roboto+Slab'){
        echo "'Roboto Slab', serif";
    }elseif($heading_font_family == 'Bree+Serif'){
        echo "'Bree Serif', serif";
    }elseif($heading_font_family == 'Libre+Baskerville'){
        echo "'Libre Baskerville', serif";
    }elseif($heading_font_family == 'Cantata+One'){
        echo "'Cantata One', serif";
    }elseif($heading_font_family == 'Alegreya'){
        echo "'Alegreya', serif";
    }elseif($heading_font_family == 'Noto+Serif'){
        echo "'Noto Serif', serif";
    }elseif($heading_font_family == 'EB+Garamond'){
        echo "'EB Garamond', serif";
    }elseif($heading_font_family == 'Noticia+Text'){
        echo "'Noticia Text', serif";
    }elseif($heading_font_family == 'Old+Standard+TT'){
        echo "'Old Standard TT', serif";
    }elseif($heading_font_family == 'Crimson+Text'){
        echo "'Crimson Text', serif";
    }else{
       echo $heading_font_family; 
    }?>;
}

</style>

<?php }?>
<?php add_action( 'wp_head', 'lpd_fonts_styles' );?>