<?php

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) die( LCS_HACK_MSG );

/**
 * Registers Shortcode
 */
function lcs_carousel_shortcode( $atts ) {
    extract(shortcode_atts(array(
    	'slider_title' => ''
    ),$atts));

ob_start();
	wp_enqueue_style( 'lcs-owl-carousel-style' );
	wp_enqueue_style( 'lcs-owl-theme-style' );
	wp_enqueue_style( 'lcs-owl-transitions' );
	wp_enqueue_style( 'lcs-custom-style' );
	wp_enqueue_script( 'lcs-owl-carousel-js' );

	$lcsDisplayNavArr = lcs_get_option( 'lcs_dna', 'lcs_general_settings', 'yes' );
	$lcsLogoTitleDisplay = lcs_get_option( 'lcs_dlt', 'lcs_general_settings', 'no' );
	$lcsLogoBorderDisplay = lcs_get_option( 'lcs_dlb', 'lcs_general_settings', 'yes' );
	$lcsLogoHoverEffect = lcs_get_option( 'lcs_lhe', 'lcs_general_settings', 'yes' );
	$lcsImageCrop = lcs_get_option( 'lcs_ic', 'lcs_general_settings', 'yes' );
	$lcsImageCropWidth = lcs_get_option( 'lcs_iwfc', 'lcs_general_settings', '185' );
	$lcsImageCropHeight = lcs_get_option( 'lcs_ihfc', 'lcs_general_settings', '119' );
	$lcsLogoItems = lcs_get_option( 'lcs_lig', 'lcs_general_settings', '5' );
	$lcsAutoPlay = lcs_get_option( 'lcs_apg', 'lcs_general_settings', 'yes' );
	$lcsPagination = lcs_get_option( 'lcs_pagination', 'lcs_general_settings', 'no' );

	$args = array(
		'post_type'      => 'logocarousel', 
		'posts_per_page' => -1 
	);

	$loop = new WP_Query( $args );
	if ( $loop->have_posts() ): ?>

	<style type="text/css">
		<?php if ($lcsLogoHoverEffect == 'yes') {?>
			.lcs_logo_container a.lcs_logo_link:hover { border: 1px solid #A0A0A0; ?>; }
			.lcs_logo_container a:hover img { -moz-transform: scale(1.05); -webkit-transform: scale(1.05); -o-transform: scale(1.05); -ms-transform: scale(1.05); transform: scale(1.05); }
		<?php } ?>
		<?php if ($lcsLogoBorderDisplay == 'yes') {?>
			.lcs_logo_container a.lcs_logo_link { border: 1px solid #d6d4d4; }
		<?php } else { ?>
			.lcs_logo_container a.lcs_logo_link, .lcs_logo_container a.lcs_logo_link:hover { border: none; }
		<?php } ?>
	</style>

	<?php if( $slider_title ) { ?>
		<h2 class="lcs_logo_carousel_slider_title"><?php echo $slider_title; ?></h2>
	<?php } ?>
	<div id="lcs_logo_carousel_slider" class="owl-carousel">
	    <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
	        <?php 
	        $post_id = get_the_ID();
	        $lcs_logo_link = get_post_meta( $post_id, 'lcs_logo_link', true );

			$lcs_logo_id = get_post_thumbnail_id();
			$lcs_logo_url = wp_get_attachment_image_src($lcs_logo_id,'full',true);
			$lcs_logo_mata = get_post_meta($lcs_logo_id,'_wp_attachment_image_alt',true);
			$lcs_logo = aq_resize( $lcs_logo_url[0], $lcsImageCropWidth, $lcsImageCropHeight, true );
	    	?>
        	<div class="lcs_logo_container">
        	  <?php if(!empty($lcs_logo_link)) { ?>
	            <a href="<?php echo $lcs_logo_link; ?>" class="lcs_logo_link" target="_blank">
	            	<?php 
	            	if ( $lcsImageCrop == "yes" ) {
	            		echo '<img src="'.$lcs_logo.'" alt="'. $lcs_logo_mata . '" />'; 
					} else {
						echo '<img src="'.$lcs_logo_url[0].'" alt="'. $lcs_logo_mata . '" />';
					}
	            	?>
	            </a>
	          <?php } else { ?>
	            <a class="lcs_logo_link not_active">
	            	<?php 
	            	if ( $lcsImageCrop == "yes" ) {
	            		echo '<img src="'.$lcs_logo.'" alt="'. $lcs_logo_mata . '" />'; 
					} else {
						echo '<img src="'.$lcs_logo_url[0].'" alt="'. $lcs_logo_mata . '" />';
					}
	            	?>
	            </a>
	          <?php } ?>
              <?php if( $lcsLogoTitleDisplay == "yes" ) { ?>
                   <?php if(!empty($lcs_logo_link)) { ?>
            	       <a href="<?php echo $lcs_logo_link; ?>" target="_blank"><h3 class="lcs_logo_title"><?php echo get_the_title() ?></h3></a>
              		<?php } else { ?>
            	       <h3 class="lcs_logo_title"><?php echo get_the_title() ?></h3>
					<?php } ?>              		
              <?php } ?>
            </div> 	            
	    <?php endwhile; wp_reset_postdata(); ?>
	    <?php else: 
		_e('No logos found', 'logo-carousel-slider');
	    endif; ?>
	</div> <!-- End lcs_logo_carousel_slider -->

	<?php 

	$lcs_rtl_direction = '';
	if ( is_rtl() ) {
		$lcs_rtl_direction = "direction:'rtl'";
	}

	$lcsNavTrueFalse = ($lcsDisplayNavArr == "yes") ? "true" : "false";
	$lcsAutoPlayRun = ($lcsAutoPlay == "yes") ? "true" : "false";
	$lcsPagiTrueFalse = ($lcsPagination == "yes") ? "true" : "false";

	echo '<script type="text/javascript">
		jQuery(document).ready(function($) {
		  jQuery("#lcs_logo_carousel_slider").owlCarousel({
				autoPlay: '.$lcsAutoPlayRun.', 
				items : '.$lcsLogoItems.',
				itemsTablet : [768, 3],
				itemsMobile : [479, 2],
				pagination : '.$lcsPagiTrueFalse.',
				navigation : '.$lcsNavTrueFalse.',
				navigationText : ["‹","›"],	
				slideSpeed: 700,			
				'.$lcs_rtl_direction.'
		  });
		});
	</script>';
$carousel_content = ob_get_clean();
return $carousel_content;
}

add_shortcode("logo_carousel_slider", "lcs_carousel_shortcode");

