<?php

/*
 * WP - Meet the Team Shortcode v2
 * http://meet-the-team.jeffreycarandang.com/
 *
 * Date: Friday, 19 Jul 2013
 */


/*##################################
	SINGLE MEMBER CONTENT
################################## */

function wpmtpv2_single_content($content){
	global $post;

	if ( 'team' == get_post_type() && is_single() && in_the_loop() ){
		$fields = WPMTPv2_OPTIONS()->fields;
		$meta = WPMTPv2_FIELDS($post->ID);

		$tmp = '<div id="wpmtp-single-wrap">';
			$tmp .= '<div class="wpmtp-vcard">';

				$tmp .= '<div class="wpmtp-vcard-left">';
					$tmp .= wpmtpv2_featured_img($post->ID);
				$tmp .= '</div>';

				$tmp .= '<div class="wpmtp-vcard-right">';
					foreach($fields as $field) {
						if(isset($field['visibility']) && $field['visibility'] == 1):
							if(!empty($meta[$field['key']]) && $field['key'] != "job_title"){
								switch ($field['key']) {
									case 'email':
										$tmp .= '<span class="wpmtp-meta wpmtp-meta-'. $field['key'] .'"><label>'. $field['label'] .'</label>: <a href="mailto:'. $meta[$field['key']] .'">'.  $meta[$field['key']] .'</a></span>';
										break;

									case 'website':
										$tmp .= '<span class="wpmtp-meta wpmtp-meta-'. $field['key'] .'"><label>'. $field['label'] .'</label>: <a href="'. $meta[$field['key']] .'" target="_blank">'.  $meta[$field['key']] .'</a></span>';
										break;
									
									default:
										$tmp .= '<span class="wpmtp-meta wpmtp-meta-'. $field['key'] .'"><label>'. $field['label'] .'</label>: '.  $meta[$field['key']] .'</span>';
										break;
								}
							}
						endif;
					}
					$social_media = WPMTPv2_OPTIONS()->socials;
					$saved_socials = WPMTPv2_SOCIALS($post->ID);
					$socials = '<ul class="wpmtp-social wpmtp-shape-'. WPMTPv2_OPTIONS()->shape .' wpmtp-social-colored">';
					foreach($social_media as $sm){
						if(!empty($saved_socials[$sm['key']])){
							if(isset($sm['visibility'])){
								if($sm['key'] == "envelope"){
									$socials .= '<li><a class="wpmtp-'. $sm['key'] .'" href="mailto:'. $saved_socials[$sm['key']] .'" data-toggle="tooltip" title="'. $sm['label'] .'">';
								}else{
									$socials .= '<li><a class="wpmtp-'. $sm['key'] .'" href="'. $saved_socials[$sm['key']] .'" target="_blank" data-toggle="tooltip" title="'. $sm['label'] .'">';
								}

								$socials .= ($sm['disable'] == 1) ? '<i class="icon-'. $sm['key'] .'"></i>' : '<span>' . $saved_socials[$sm['key']] . '</span>';
								
								
								$socials .= '</a></li>';
							}
						}
					}
					$socials .= '</ul>';	
					$tmp .= '<span class="wpmtp-meta wpmtp-meta-socials">' . $socials . '</span>';
				$tmp .= '</div>';

			$tmp .= '<div class="wpmtp-clearfix"></div></div>';
			$tmp .= '<div id="wpmtp-single-content">';
				$tmp .= $content;
			$tmp .= '</div>';

		$tmp .= '</div>';

		$content = $tmp;
	}
	
	return $content;
}
add_filter('the_content','wpmtpv2_single_content');

function wpmtpv2_single_title($title){
	global $post;
	if(isset($post->ID)){
		$job_title = get_post_meta($post->ID,'_wpmtp_job_title',true);
		if ( 'team' == get_post_type() && is_single() && in_the_loop() ){
			wp_reset_query();
			if('team' == get_post_type()){
				$title .= "<span class='wpmtp-job-title'>" . $job_title . "</span>";
			}
		}	
	}
	return $title;
}
add_filter('the_title','wpmtpv2_single_title');

function wpmtpv2_featured_img($id){
	if(WPMTPv2_OPTIONS()->bannerx == 300 && WPMTPv2_OPTIONS()->bannery == 300){
		return get_the_post_thumbnail($id,'wpmtpv2-single');
	}
	else{
		if (has_post_thumbnail( $id ) ):
			$thumb = get_post_thumbnail_id( $id );
			$image = vt_resize( $thumb,'' , WPMTPv2_OPTIONS()->bannerx, WPMTPv2_OPTIONS()->bannery, true );
			return $img = '<img src="'. $image[url] .'">';
		endif;
	}
}

?>