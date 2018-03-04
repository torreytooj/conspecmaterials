<?php

/*
 * WP - Meet the Team Shortcode v2
 * http://meet-the-team.jeffreycarandang.com/
 *
 * Date: Friday, 19 Jul 2013
 */

/*##################################
	METABOX
################################## */

//Create Custom Metabox
function wpmtpv2_info_create_metabox(){
	add_meta_box('team-info', __('Member Information', 'wpmtpv2'),'wpmtpv2_info_metabox','team','normal','high');
	add_meta_box('team-social', __('Social Profile Links', 'wpmtpv2'),'wpmtpv2_social_metabox','team','normal','high');
}

function wpmtpv2_info_metabox($post){
		$fields = WPMTPv2_OPTIONS()->fields;
		$saved_meta = WPMTPv2_FIELDS($post->ID);
		?>
		<input type="hidden" name="wpmtpv2_info_nonce" value="<?php _e( wp_create_nonce(basename(__FILE__)) );?>" />
		<table id="newmeta" style="width: 100%;">
			<tbody>
				<?php foreach($fields as $field) :
				if(isset($field['visibility']) && $field['visibility'] == 1):
				?>
				<tr>
					<td id="newmetaleft" class="left"><label for="wpmtpv2_<?php echo $field['key'];?>"><?php echo $field['label'];?></label></td>
					<td><input type="text" class="widefat" id="wpmtpv2_<?php echo $field['key'];?>" name="wpmtp_<?php echo $field['key'];?>" size="40" value="<?php echo (isset($saved_meta[$field['key']])) ? $saved_meta[$field['key']] : '';?>"></td>
				</tr>
			<?php endif; endforeach;?>
			</tbody>
		</table>
		<?php
}

function wpmtpv2_social_metabox($post){
		$socials = WPMTPv2_OPTIONS()->socials;
		$saved_meta = WPMTPv2_SOCIALS($post->ID);
		?>
		<input type="hidden" name="wpmtpv2_social_nonce" value="<?php _e( wp_create_nonce(basename(__FILE__)) );?>" />
		<table id="newmeta" style="width: 100%;">
			<tbody>
				<?php foreach($socials as $social) : 
				if(isset($social['visibility']) && $social['visibility'] == 1):
				?>
				<tr>
					<td id="newmetaleft" class="left"><label for="wpmtpv2_<?php echo $social['key'];?>"><?php echo $social['label'];?></label></td>
					<td><input type="text" class="widefat" id="wpmtpv2_<?php echo $social['key'];?>" name="wpmtp_<?php echo $social['key'];?>" size="40" value="<?php echo (isset($saved_meta[$social['key']])) ? $saved_meta[$social['key']] : '';?>"></td>
				</tr>
			<?php endif; endforeach;?>
			</tbody>
		</table>
		<?php
}

function wpmtpv2_address_savemeta($post_id){

	if(isset($_POST['wpmtpv2_info_nonce'])){
		$fields = WPMTPv2_OPTIONS()->fields;
		foreach($fields as $field){
			if(isset($field['visibility']) && $field['visibility'] == 1)
				update_post_meta($post_id,'_wpmtp_' . $field['key'],strip_tags($_POST['wpmtp_' . $field['key']]));
		}			
	}
	if(isset($_POST['wpmtpv2_social_nonce'])){
		$socials = WPMTPv2_OPTIONS()->socials;
		foreach($socials as $social){
			if(isset($social['visibility']) && $social['visibility'] == 1){
				if($social['key'] != "envelope" && !empty($_POST['wpmtp_' . $social['key']])){
					update_post_meta($post_id,'_wpmtp_' . $social['key'], wpmtpv2_addhttp(strip_tags($_POST['wpmtp_' . $social['key']])) );
				}else{
					update_post_meta($post_id,'_wpmtp_' . $social['key'],strip_tags($_POST['wpmtp_' . $social['key']]));
				}
				
			}
		}			
	}
}
add_action('save_post','wpmtpv2_address_savemeta');

function wpmtpv2_addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}
?>