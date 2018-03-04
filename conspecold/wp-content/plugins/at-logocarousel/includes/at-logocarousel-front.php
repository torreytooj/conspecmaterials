<?php

function at_logo_carousel_func( $atts ) {
	extract( shortcode_atts( array(
		'id' => ''
	), $atts ) );
	
	if ($id) {
		$meta_tmp = get_post_meta($id, 'post_media');
		$post_media = $meta_tmp[0];
		$meta_tmp = get_post_meta($id, 'post_at_options');
		$post_options = $meta_tmp[0];
		
		$to_return = '<div class="at_logo_carousel" id="at_logo_carousel_'.$id.'" 
							data-carousel-id="'.$id.'"  
							data-speed="'.$post_options['speed'].'" 
							data-speed-random="'.$post_options['speed_random'].'" 
							data-rows="'.$post_options['rows'].'" 
							data-cols="'.$post_options['cols'].'" 
							data-alignment="'.$post_options['style'].'" 
							data-force-fullwidth="'.(($post_options['force_fullwidth'] == 'on') ? '1' : '0').'" 
							data-background="'.$post_options['background'].'" 
							data-vertical-direction="'.$post_options['animation_vertical'].'" 
							data-horizontal-direction="'.$post_options['animation_horizontal'].'" 
							data-height="'.$post_options['height'].'" 
							data-topbottom-padding="'.$post_options['logo_padding_tb'].'" 
							data-leftright-padding="'.$post_options['logo_padding_lr'].'" 
							'.(($post_options['hover_stop'] == 'on') ? 'data-hover-stop="true"' : '').'
						">';
						
		// check if there is a call to action button
		if (isset($post_options['callaction']) && $post_options['callaction'] == 'yes') {
			$to_return .= '<div class="at_logo_carousel_calltoaction_container '.$post_options['callaction_style'].'">
				<div class="at_logo_carousel_calltoaction">
					<div class="at_logo_carousel_calltoaction_block">
						<h2 class="'.$post_options['callaction_layout'].'">'.$post_options['callaction_title'].'</h2>
						<p class="'.$post_options['callaction_layout'].'">'.$post_options['callaction_text'].'</p>
						';
			
						if ($post_options['callaction_button_text']) {
							$to_return .= '<a href="'.$post_options['callaction_button_link'].'" target="'.$post_options['callaction_button_link_target'].'" class="at_logo_carousel_button '.$post_options['callaction_layout'].'">'.$post_options['callaction_button_text'].'</a>';
						}
			
						if ($post_options['callaction_dismiss'] == 'on') {
							$to_return .= '
							<div class="at_logo_carousel_dismiss_button_container">
								<a href="#" class="at_logo_carousel_dismiss_button">dismiss</a>
							</div>';
						}
						
			$to_return .= '	<div class="at_logo_clear"></div>
					</div>
				</div>
			</div>';
		}
		
		$to_return .= '<ul>';

		if ($post_media) {
			$i = 0;
			foreach($post_media as $img) {
				$img_src = wp_get_attachment_image_src($img['id'], 'medium');
				
				$to_return .= '<li>
					'.(($post_options['links'] == 'on') ? '<a href="'.$img['logo_link'].'" target="'.$post_options['links_target'].'">' : '').'
						<img src="'.$img_src[0].'" alt="" />
					'.(($post_options['links'] == 'on') ? '</a>' : '').'
				</li>';
				
				$i++;
			}
		}
			
		$to_return .= '</ul>';
		$to_return .= '</div>';
		
		$to_return .= '<style type="text/css">';
		
		// DIV
		$to_return .= '#at_logo_carousel_'.$id.' {';
		switch($post_options['borders']) {
			case 'top':
				$to_return .= 'border-top: solid 1px '.$post_options['borders_color'].';';
				break;
			case 'bottom':
				$to_return .= 'border-bottom: solid 1px '.$post_options['borders_color'].';';
				break; 
			case 'topbottom':
				$to_return .= 'border-top: solid 1px '.$post_options['borders_color'].';';
				$to_return .= 'border-bottom: solid 1px '.$post_options['borders_color'].';';
				break;
			case 'all':
				$to_return .= 'border: solid 1px '.$post_options['borders_color'].';';
				break;
		}
		$to_return .= 'margin-bottom:'.((isset($post_options['margin_bottom'])) ? $post_options['margin_bottom'] : '25').'px;';
		$to_return .= 'margin-top:'.((isset($post_options['margin_top'])) ? $post_options['margin_top'] : '0').'px;';
		$to_return .= '}';
		
		// PLACEHOLDER
		$to_return .= '#at_logo_carousel_placeholder_'.$id.' {';
		$to_return .= 'margin-bottom:'.((isset($post_options['margin_bottom'])) ? $post_options['margin_bottom'] : '25').'px;';
		$to_return .= 'margin-top:'.((isset($post_options['margin_top'])) ? $post_options['margin_top'] : '0').'px;';
		$to_return .= '}';
		
		// IMG
		$to_return .= '#at_logo_carousel_'.$id.' li img {';
		if (($post_options['logo_max_width'] != 0) && (!empty($post_options['logo_max_width']))) {
			$to_return .= 'width: '.$post_options['logo_max_width'].'px; height: auto;';
		}
		elseif (($post_options['logo_max_height'] != 0) && (!empty($post_options['logo_max_height']))) {
			$to_return .= 'height: '.$post_options['logo_max_height'].'px; width: auto;';
		}
		$to_return .= '}';
		
		$to_return .= '</style>';
		
		return $to_return;
	}
	else {
		return '';
	}
}
add_shortcode( 'at_logo_carousel', 'at_logo_carousel_func' );

?>