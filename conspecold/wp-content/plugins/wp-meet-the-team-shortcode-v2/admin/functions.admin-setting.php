<?php

/*
 * WP - Meet the Team Shortcode v2
 * http://meet-the-team.jeffreycarandang.com/
 *
 * Date: Friday, 19 Jul 2013
 */


/*##################################
	SETTINGS
################################## */

class wpmtpv2_settings {
	//add init actions on settings page
	function __construct(){

		//register callback for admin menu  setup
		add_action('admin_menu', array(&$this,'wpmtpv2_menu'));

	}

	//create menu under Appearance
	function wpmtpv2_menu() {
	  $this->pagehook = add_submenu_page('edit.php?post_type=team', 'WP - Meet the Team Shortcode v2', 'Settings', 'manage_options', 'wpmtpv2-settings', array(&$this,'wpmtpv2_settings_content'));
	  
	  add_action('load-'. $this->pagehook  , array(&$this,'wpmtpv2_on_load_page'));
	}

	//will be executed if wordpress core detects this page has to be rendered
	function wpmtpv2_on_load_page() {

		//enqueue scripts
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('common');
		wp_enqueue_script('wp-lists');
		wp_enqueue_script('postbox');
		wp_enqueue_media();

		wp_register_style( 'wpmtpv2-settings', 
	    WPMTPv2_STYLES . '/admin/settings.css',
	    array(), 
	    '20130722', 
	    'all' );

	    wp_enqueue_style( 'wpmtpv2-settings' );

		//load metaboxes
		add_meta_box('wpmtpv2-fields-metabox', __('Fields','wpmtpv2'), array(&$this, 'wpmtpv2_fields_metabox'), $this->pagehook, 'normal', 'core');
		add_meta_box('wpmtpv2-social-metabox', __('Social Media','wpmtpv2'), array(&$this, 'wpmtpv2_social_metabox'), $this->pagehook, 'normal', 'core');
		add_meta_box('wpmtpv2-image-metabox', __('Image Sizes','wpmtpv2'), array(&$this, 'wpmtpv2_image_metabox'), $this->pagehook, 'normal', 'core');
		add_meta_box('wpmtpv2-advance-metabox', __('Advance Options','wpmtpv2'), array(&$this, 'wpmtpv2_advance_metabox'), $this->pagehook, 'normal', 'core');
	}

	//settings content
	function wpmtpv2_settings_content(){
		$settings_option = unserialize(get_option('wpmtpv2-setting'));
		if(isset($_POST['wpmtp_action']) && $_POST['wpmtp_action'] == "save_wpmtpv2_settings_page"){
			update_option('wpmtpv2-setting', serialize($_POST));
			$settings_option = $_POST;
		}
		?>
		<div id="howto-metaboxes-general" class="wrap">

			<?php screen_icon('options-general'); ?>
			<h2><?php _e('Meet the Team Shortcode v2','wpmtpv2');?></h2><br /><br />

			<form action="<?php _e( str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) ); ?>" method="post">
				<?php wp_nonce_field('wpmtpv2-settings-page'); ?>
				<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>
				<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>
				<input type="hidden" name="wpmtp_action" value="save_wpmtpv2_settings_page" />

				<div id="poststuff" class="metabox-holder">
					<div id="side-info-column" class="inner-sidebar">
						<?php do_meta_boxes($this->pagehook, 'side', $settings_option); ?>
					</div>
					<div id="post-body" class="has-sidebar">
						<div id="post-body-content" class="has-sidebar-content">
							<?php do_meta_boxes($this->pagehook, 'normal', $settings_option); ?>
							<p class="wpp_save_changes_row">
							<input type="submit" value="Save Changes" class="button-primary btn" name="Submit">
							 </p>
						</div>
					</div>
					<br class="clear"/>					
				</div>
			</form>
		</div>
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready( function($) {
				// close postboxes that should be closed
				$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				// postboxes setup
				postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
			});
			//]]>
		</script>
		<?php
	}

	//custom fields options
	function wpmtpv2_fields_metabox($settings_option){
		// print_r($settings_option);
		?>
		<script>
			jQuery(document).ready(function($){
				jQuery(".wpmtp_attribute_fields tbody tr").live("mouseover", function() {
			        jQuery(this).addClass("wpmtp_draggable_handle_show");
			      });;

			      jQuery(".wpmtp_attribute_fields tbody tr").live("mouseout", function() {
			        jQuery(this).removeClass("wpmtp_draggable_handle_show");
			      });;

			      jQuery(".wpmtp_add_row").live("click", function() {
			      	var randTime = (new Date).getTime();
			        jQuery(".wpmtp_attribute_fields tbody").append('<tr class="wpmtp_dynamic_table_row"><td class="wpmtp_draggable_handle">&nbsp;<input type="hidden" value="" name="fields['+ randTime +'][disable]" value="0" /></td><td class="wpmtp_attribute_label_col"><input type="text" value="" name="fields['+ randTime +'][label]" /></td><td class="wpmtp_attribute_meta_col"><input type="text" value="" name="fields['+ randTime +'][key]" /></td><td class="wpmtp_attribute_show_col"><input type="checkbox" value="1" name="fields['+ randTime +'][frontend]"></td><td class="wpmtp_attribute_visible_col"><input type="checkbox" value="1" name="fields['+ randTime +'][visibility]"></td><td class="manage-column remove-column"><a href="#" class="wpmtp_remove_row"><i class="icon-remove"></i></a></td></tr>');
			      });;
			      jQuery(".wpmtp_remove_row").live("click", function(e) {
			      	$(this).parent('td').parent('.wpmtp_dynamic_table_row').fadeOut(350,function(){ $(this).remove(); });
			      	e.preventDefault();
			      });;

			});
		</script>
		<table class="wp-list-table widefat wpmtp_attribute_fields">
			<thead>
				<tr>
					<th class="manage-column column-cb check-column">&nbsp;</th>
					<th class="manage-column"><?php _e('Label', 'wpmtpv2')?></th>
					<th class="manage-column"><?php _e('Meta Key', 'wpmtpv2')?></th>
					<th class="manage-column"><?php _e('Show <br />on<br /> Frontend', 'wpmtpv2')?></th>
					<th class="manage-column"><?php _e('Active', 'wpmtpv2')?></th>
					<th class="manage-column"><?php _e('Action', 'wpmtpv2')?></th>
				</tr>
			</thead>
			<tbody class="ui-sortable">
				<?php foreach($settings_option['fields'] as $fields): if(!empty($fields['key'])):?>
				<tr class="wpmtp_dynamic_table_row">
					<td class="wpmtp_draggable_handle">&nbsp;<input type="hidden" name="fields[<?php echo $fields['key'];?>][disable]" value="<?php echo ($fields['disable'] == 1) ? $fields['disable'] : '0';?>" /></td>
					<td class="wpmtp_attribute_label_col"><input type="text" value="<?php echo $fields['label'];?>" name="fields[<?php echo $fields['key'];?>][label]" /></td>
					<td class="wpmtp_attribute_meta_col"><input type="text" value="<?php echo $fields['key'];?>" name="fields[<?php echo $fields['key'];?>][key]" <?php echo ($fields['disable'] ) ? 'readonly="readonly"' : '';?>/></td>
					<td class="wpmtp_attribute_show_col"><input type="checkbox" value="1" <?php echo (isset($fields['frontend']) && ($fields['frontend'] == 1)) ? 'checked="checked"' : '';?> name="fields[<?php echo $fields['key'];?>][frontend]"></td>
					<td class="wpmtp_attribute_visible_col"><input type="checkbox" value="1" <?php echo (isset($fields['visibility']) && ($fields['visibility'] == 1)) ? 'checked="checked"' : '';?> name="fields[<?php echo $fields['key'];?>][visibility]"></td>
					<td class="manage-column remove-column">
						<?php if($fields['disable'] != 1 ) :?>
							<a href="#" class="wpmtp_remove_row"><i class="icon-remove"></i></a>
						<?php endif;?>
					</td>
				</tr>
			<?php endif; endforeach;?>
			</tbody>
			<tfoot>
	          <tr>
	            <td colspan="5">
	            <input type="button" class="wpmtp_add_row button-secondary" value="Add Row">
	            </td>
	          </tr>
	        </tfoot>
		</table>
		<script>
		jQuery(document).ready(function($){
			$( ".ui-sortable" ).sortable();
		});
		</script>
		<?php
	}
	function wpmtpv2_social_metabox($settings_option){
		?>
		<script>
			jQuery(document).ready(function($){
				jQuery(".wpmtp_attribute-social_fields tbody tr").live("mouseover", function() {
			        jQuery(this).addClass("wpmtp_draggable_handle_show");
			      });;

			      jQuery(".wpmtp_attribute-social_fields tbody tr").live("mouseout", function() {
			        jQuery(this).removeClass("wpmtp_draggable_handle_show");
			      });;

			     jQuery(".wpmtp_add-social_row").live("click", function() {
			      	var randTime = (new Date).getTime();
			        jQuery(".wpmtp_attribute-social_fields tbody").append('<tr class="wpmtp_dynamic_table_row"><td class="wpmtp_draggable_handle">&nbsp;<input type="hidden" value="" name="socials['+ randTime +'][disable]" value="0" /></td><td class="wpmtp_attribute_label_col"><input type="text" value="" name="socials['+ randTime +'][label]" /></td><td class="wpmtp_attribute_meta_col"><input type="text" value="" name="socials['+ randTime +'][key]" /></td><td class="wpmtp_attribute_visible_col"><input type="checkbox" value="1" name="socials['+ randTime +'][visibility]"></td><td class="manage-column remove-column"><a href="#" class="wpmtp_remove_row"><i class="icon-remove"></i></a></td></tr>');
			      });; 
			});
		</script>
		<table class="wp-list-table widefat wpmtp_attribute-social_fields">
			<thead>
				<tr>
					<th class="manage-column column-cb check-column">&nbsp;</th>
					<th class="manage-column"><?php _e('Label', 'wpmtpv2') ?></th>
					<th class="manage-column"><?php _e('Meta Key', 'wpmtpv2')?></th>
					<th class="manage-column"><?php _e('Visible', 'wpmtpv2')?></th>
					<th class="manage-column"><?php _e('Action', 'wpmtpv2')?></th>
				</tr>
			</thead>
			<tbody class="ui-sortable">
				<?php foreach($settings_option['socials'] as $fields): if(!empty($fields['key'])):?>
				<tr class="wpmtp_dynamic_table_row">
					<td class="wpmtp_draggable_handle">&nbsp;<input type="hidden" name="socials[<?php echo $fields['key'];?>][disable]" value="<?php echo ($fields['disable'] == 1) ? $fields['disable'] : '0';?>" /></td>
					<td class="wpmtp_attribute_label_col"><input type="text" value="<?php echo $fields['label'];?>" name="socials[<?php echo $fields['key'];?>][label]" /></td>
					<td class="wpmtp_attribute_meta_col"><input type="text" value="<?php echo $fields['key'];?>" name="socials[<?php echo $fields['key'];?>][key]" <?php echo ($fields['disable'] == 1) ? 'readonly="readonly"' : '';?>/></td>
					<td class="wpmtp_attribute_visible_col"><input type="checkbox" value="1" <?php echo (isset($fields['visibility']) && ($fields['visibility'] == 1)) ? 'checked="checked"' : '';?> name="socials[<?php echo $fields['key'];?>][visibility]"></td>
					<td class="manage-column remove-column">
						<?php if($fields['disable'] != 1) :?>
							<a href="#" class="wpmtp_remove_row"><i class="icon-remove"></i></a>
						<?php endif;?>
					</td>
				</tr>
			<?php endif; endforeach;?>
			</tbody>
			<tfoot>
	          <tr>
	            <td colspan="5">
	            <input type="button" class="wpmtp_add-social_row button-secondary" value="Add Row">
	            </td>
	          </tr>
	        </tfoot>
		</table>
		<?php
	}

	function wpmtpv2_image_metabox($settings_option){
		?>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="wpmtpv2_thumbx"><?php _e('Thumbnail','wpmtpv2');?></label></th>
					<td>Width: <input type="text" name="thumbx" id="wpmtpv2_thumbx" value="<?php echo $settings_option['thumbx'];?>" size="3">px &nbsp;&nbsp; Height: <input type="text" name="thumby" id="wpmtpv2_thumby" value="<?php echo $settings_option['thumby'];?>" size="3">px</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="wpmtpv2_bannerx"><?php _e('Single Page Image','wpmtpv2');?></label></th>
					<td>Width: <input type="text" name="bannerx" id="wpmtpv2_bannerx" value="<?php echo $settings_option['bannerx'];?>" size="3">px &nbsp; Height: <input type="text" name="bannery" id="wpmtpv2_bannery" value="<?php echo $settings_option['bannery'];?>" size="3">px</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="wpmtpv2_shape"><?php _e('Social Icons','wpmtpv2');?></label></th>
					<td>
						<select id="wpmtpv2_shape" name="shape">
							<option value="rounded" <?php echo ($settings_option['shape'] == "rounded") ? 'selected="selected"' : '';?>>Rounded</option>
							<option value="square" <?php echo ($settings_option['shape'] == "square") ? 'selected="selected"' : '';?>>Square</option>
						</select>
				</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	function wpmtpv2_advance_metabox($settings_option){
		?>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="wpmtpv2_more_text"><?php _e('View Link Text','wpmtpv2');?></label></th>
					<td><input type="text" name="more_text" id="wpmtpv2_more_text" value="<?php echo $settings_option['more_text'];?>"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="wpmtpv2_singular"><?php _e('Singular Name','wpmtpv2');?></label></th>
					<td><input type="text" name="singular" id="wpmtpv2_singular" value="<?php echo $settings_option['singular'];?>"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="wpmtpv2_plural"><?php _e('Plural Name','wpmtpv2');?></label></th>
					<td><input type="text" name="plural" id="wpmtpv2_plural" value="<?php echo $settings_option['plural'];?>"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="wpmtpv2_category"><?php _e('Category','wpmtpv2');?></label></th>
					<td><input type="text" name="category" id="wpmtpv2_category" value="<?php echo $settings_option['category'];?>"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="wpmtpv2_slug"><?php _e('Slug','wpmtpv2');?></label></th>
					<td><input type="text" name="slug" id="wpmtpv2_plural" value="<?php echo $settings_option['slug'];?>"> &nbsp;<em>If you change this option, you might have to update/save the 'permalink' settings again.</em></td>
				</tr>
			</tbody>
		</table>
		<?php
	}
}
$wpmtpv2_settings = new wpmtpv2_settings();
?>