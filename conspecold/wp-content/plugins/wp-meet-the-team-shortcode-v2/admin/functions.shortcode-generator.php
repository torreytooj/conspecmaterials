<?php

/*
 * WP - Meet the Team Shortcode v2
 * http://meet-the-team.jeffreycarandang.com/
 *
 * Date: Friday, 19 Jul 2013
 */


/*##################################
	SHORTCODE GENERATOR
################################## */

class wpmtpv2_shortcode_generator {
	//add init actions on settings page
	function __construct(){

		//register callback for admin menu  setup
		add_action('admin_menu', array(&$this,'wpmtpv2_sc_menu'));

	}

	//create menu under Appearance
	function wpmtpv2_sc_menu() {
	  $this->pagehook = add_submenu_page('edit.php?post_type=team', 'WP - Meet the Team Shortcode Generator', 'Shortcode Generator', 'manage_options', 'wpmtpv2-shortcode-generator', array(&$this,'wpmtpv2_sc_settings_content'));
	  
	  add_action('load-'. $this->pagehook  , array(&$this,'wpmtpv2_sc_on_load_page'));
	}

	//will be executed if wordpress core detects this page has to be rendered
	function wpmtpv2_sc_on_load_page() {
		wp_enqueue_script('common');
		wp_enqueue_script('wp-lists');
		wp_enqueue_script('postbox');

		wp_register_style( 'wpmtp-css', WPMTPv2_STYLES . '/team.css' );
		wp_register_style( 'bootstrap-tooltip', WPMTPv2_STYLES . '/bootstrap-tooltip.css' );

		wp_register_script( 'browser', WPMTPv2_SCRIPTS. '/jquery.browser.js', array( 'jquery' ));
		wp_register_script( 'carouFredSel', WPMTPv2_SCRIPTS. '/jquery.carouFredSel-6.2.1-packed.js', array( 'jquery' ));
		wp_register_script( 'quicksand', WPMTPv2_SCRIPTS. '/jquery.quicksand.js', array( 'jquery' ));
		wp_register_script( 'bootstrap-tooltip', WPMTPv2_SCRIPTS. '/bootstrap-tooltip.js', array( 'jquery' ));
		wp_register_script( 'wpmtp', WPMTPv2_SCRIPTS. '/custom.js', array( 'jquery' ));

		wp_enqueue_style( 'wpmtp-css' );
		wp_enqueue_style( 'bootstrap-tooltip' );
		wp_enqueue_script( 'browser' );
		wp_enqueue_script( 'carouFredSel' );
		wp_enqueue_script( 'quicksand' );
		wp_enqueue_script( 'bootstrap-tooltip' );
		wp_enqueue_script( 'wpmtp' );

		add_meta_box('wpmtpv2-sc-metabox', __('Shortcode Generator','wpmtpv2'), array(&$this, 'wpmtpv2_sc_metabox'), $this->pagehook, 'normal', 'core');
	}

	//settings content
	function wpmtpv2_sc_settings_content(){
		$options = array();
		?>
		<div id="howto-metaboxes-general" class="wrap">

			<?php screen_icon('options-general'); ?>
			<h2><?php _e('Meet the Team Shortcode Generator','wpmtpv2');?></h2><br /><br />
			<?php
				if(isset($_POST['wpmtp_sc_action']) && $_POST['wpmtp_sc_action'] == "save_wpmtpv2_sc_generator"){
					$options = serialize($_POST['wpmtp']);
					$options = unserialize($options);
					$shortcode = '[display-team';
					foreach ($options as $key => $value) {
						if(!empty($value)){
							if($key != 'hide'){
								$shortcode .= ' '. $key . '="'. $value .'"';
							}else{
								$implode = implode(',', array_keys($value));
								$shortcode .= ' '. $key . '="'. $implode .'"';
							}
						}
					}
					$shortcode .= ']';
					echo '<strong>Copy this code and paste it into your post, page or text widget content.</strong>';
					echo '<input type="text" style="color: #fff;background: #7e4e0b;border: none;width: 100%;-webkit-border-radius: 6px;border-radius: 6px;" value=\''. $shortcode .'\' />';
				}
			?>
			<form action="<?php _e( str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) ); ?>" method="post">
				<?php wp_nonce_field('wpmtpv2-shortcode-page'); ?>
				<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>
				<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>
				<input type="hidden" name="wpmtp_sc_action" value="save_wpmtpv2_sc_generator" />

				<div id="poststuff" class="metabox-holder">
					<div id="side-info-column" class="inner-sidebar">
						<?php do_meta_boxes($this->pagehook, 'side', $options); ?>
					</div>
					<div id="post-body" class="has-sidebar">
						<div id="post-body-content" class="has-sidebar-content" style="margin-bottom:0px;">
							<?php do_meta_boxes($this->pagehook, 'normal', $options); ?>
						</div>
					</div>
					<br class="clear"/>					
				</div>
			</form>
			<?php if(isset($_POST['wpmtp_sc_action']) && $_POST['wpmtp_sc_action'] == "save_wpmtpv2_sc_generator"){?>
			<h3>Preview</h3>
			<?php echo do_shortcode($shortcode); }?>
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
	function wpmtpv2_sc_metabox($option){
		$terms = get_terms("team-category");
		$count_terms = count($terms);
		$num = array('','one','two','three','four','five','six','seven','eight','nine','ten','eleven','twelve');
		?>
		<div style="float:left; width:50%; min-width:350px;">
			<h3>Display</h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_ids"><?php _e('Specific ID','wpmtpv2')?>: </label></th>
						<td>
							<input type="text" size="30" name="wpmtp[ids]" class="wpmtpv2_sc" id="wpmtpv2_ids" value="<?php echo (isset($option['ids'])) ? $option['ids'] : '';?>"> <br /><em>Separate by comma for multiple ID</em>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_category"><?php echo WPMTPv2_OPTIONS()->category;?>: </label></th>
						<td>
							<select name="wpmtp[category]" class="wpmtpv2_sc" id="wpmtpv2_category">
								<option value="">All</option>
								<?php if($count_terms > 0) :  foreach ( $terms as $term ) {?>
									<option value="<?php echo $term->slug;?>" <?php echo (isset($option['category']) && $option['category'] =="$term->slug") ? 'selected="selected"' : '';?>><?php echo $term->name;?></option>
								<?php } endif;?>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_orderby"><?php _e('Orderby','wpmtpv2')?>: </label></th>
						<td>
							<select name="wpmtp[orderby]" class="wpmtpv2_sc" id="wpmtpv2_orderby">
								<option value="">Default</option>
								<option value="title" <?php echo (isset($option['orderby']) && $option['orderby'] =="title") ? 'selected="selected"' : '';?>>Name</option>
								<option value="menu_order" <?php echo (isset($option['orderby']) && $option['orderby'] =="menu_order") ? 'selected="selected"' : '';?>>Custom Order</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_order"><?php _e('Order','wpmtpv2')?>: </label></th>
						<td>
							<select name="wpmtp[order]" class="wpmtpv2_sc" id="wpmtpv2_order">
								<option value="">Default</option>
								<option value="asc" <?php echo (isset($option['order']) && $option['order'] =="asc") ? 'selected="selected"' : '';?>>ASC</option>
								<option value="desc" <?php echo (isset($option['order']) && $option['order'] =="desc") ? 'selected="selected"' : '';?>>DESC</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_position"><?php _e('Social Icon Position','wpmtpv2')?>: </label></th>
						<td>
							<select name="wpmtp[position]" class="wpmtpv2_sc" id="wpmtpv2_position">
								<option value="">Default</option>
								<option value="before" <?php echo (isset($option['position']) && $option['position'] =="before") ? 'selected="selected"' : '';?>>Before Excerpt/Content</option>
								<option value="after" <?php echo (isset($option['position']) && $option['position'] =="after") ? 'selected="selected"' : '';?>>After Excerpt/Content</option>
								<option value="image" <?php echo (isset($option['position']) && $option['position'] =="image") ? 'selected="selected"' : '';?>>On Image Mouseover</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_entry"><?php _e('Number of Entries to display','wpmtpv2')?>: </label></th>
						<td>
							<input type="text" size="3" name="wpmtp[limit]" class="wpmtpv2_sc" id="wpmtpv2_entry" value="<?php echo (isset($option['limit'])) ? $option['limit'] : '';?>"> <em>Enter 0 or blank to display all.</em>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_hide_title"><?php _e('Hide Name/Title','wpmtpv2')?>: </label></th>
						<td>
							<input type="checkbox" value="1" name="wpmtp[hide][title]" class="wpmtpv2_sc" id="wpmtpv2_hide_title" <?php echo (isset($option['hide']) && array_key_exists('title', $option['hide'])) ? 'checked="checked"' : '';?> />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_hide_job_title"><?php _e('Hide Job Title','wpmtpv2')?>: </label></th>
						<td>
							<input type="checkbox" value="1" name="wpmtp[hide][job_title]" class="wpmtpv2_sc" id="wpmtpv2_hide_job_title" <?php echo (isset($option['hide']) && array_key_exists('job_title', $option['hide'])) ? 'checked="checked"' : '';?> />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_hide_image"><?php _e('Hide Photo/Image','wpmtpv2')?>: </label></th>
						<td>
							<input type="checkbox" value="1" name="wpmtp[hide][image]" class="wpmtpv2_sc" id="wpmtpv2_hide_image" <?php echo (isset($option['hide']) && array_key_exists('image', $option['hide'])) ? 'checked="checked"' : '';?> />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_hide_excerpt"><?php _e('Hide Excerpt/Content','wpmtpv2')?>: </label></th>
						<td>
							<input type="checkbox" value="1" name="wpmtp[hide][excerpt]" class="wpmtpv2_sc" id="wpmtpv2_hide_excerpt" <?php echo (isset($option['hide']) && array_key_exists('excerpt', $option['hide'])) ? 'checked="checked"' : '';?> />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_hide_social"><?php _e('Hide Social Media Icons','wpmtpv2')?>: </label></th>
						<td>
							<input type="checkbox" value="1" name="wpmtp[hide][social]" class="wpmtpv2_sc" id="wpmtpv2_hide_social" <?php echo (isset($option['hide']) && array_key_exists('social', $option['hide'])) ? 'checked="checked"' : '';?> />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_hide_more"><?php _e('Hide More Link','wpmtpv2')?>: </label></th>
						<td>
							<input type="checkbox" value="1" name="wpmtp[hide][more]" class="wpmtpv2_sc" id="wpmtpv2_hide_more" <?php echo (isset($option['hide']) && array_key_exists('more', $option['hide'])) ? 'checked="checked"' : '';?> />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_hide_meta_label"><?php _e('Hide Field Labels','wpmtpv2')?>: </label></th>
						<td>
							<input type="checkbox" value="1" name="wpmtp[hide][field_label]" class="wpmtpv2_sc" id="wpmtpv2_hide_meta_label" <?php echo (isset($option['hide']) && array_key_exists('field_label', $option['hide'])) ? 'checked="checked"' : '';?> />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_link"><?php _e('Disable Name/Title Link','wpmtpv2')?>: </label></th>
						<td>
							<input type="checkbox" value="1" name="wpmtp[link]" class="wpmtpv2_sc" id="wpmtpv2_link" <?php echo (isset($option['link'])) ? 'checked="checked"' : '';?> />
						</td>
					</tr>

				</tbody>
			</table>
		</div>
		<div style="float:left; width:50%; min-width:350px;">
			<h3>Layout</h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_layout"><?php _e('Layout','wpmtpv2');?></label></th>
						<td>
							<select name="wpmtp[layout]" class="wpmtpv2_sc" id="wpmtpv2_layout">
								<option value="grid" <?php echo (isset($option['layout']) && $option['layout'] =="grid") ? 'selected="selected"' : '';?>>Grid</option>
								<option value="carousel" <?php echo (isset($option['layout']) && $option['layout'] =="carousel") ? 'selected="selected"' : '';?>>Carousel</option>
								<option value="filterable" <?php echo (isset($option['layout']) && $option['layout'] =="filterable") ? 'selected="selected"' : '';?>>Filterable</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_columns"><?php _e('Columns','wpmtpv2');?></label></th>
						<td>
							<select name="wpmtp[columns]" class="wpmtpv2_sc" id="wpmtpv2_columns">
								<?php for($x=1; $x <= 12 ; $x++) {?>
								<option value="<?php echo $num[$x];?>" <?php echo (isset($option['columns']) && $option['columns'] ==$num[$x]) ? 'selected="selected"' : '';?>><?php echo $x;?></option>
								<?php }?>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_align"><?php _e('Text Align','wpmtpv2');?></label></th>
						<td>
							<select name="wpmtp[align]" class="wpmtpv2_sc" id="wpmtpv2_align">
								<option value="center" <?php echo (isset($option['align']) && $option['align'] =="center") ? 'selected="selected"' : '';?>>Center</option>
								<option value="left" <?php echo (isset($option['align']) && $option['align'] =="left") ? 'selected="selected"' : '';?>>Left</option>
								<option value="right" <?php echo (isset($option['align']) && $option['align'] =="right") ? 'selected="selected"' : '';?>>Right</option>
								<option value="justify" <?php echo (isset($option['align']) && $option['align'] =="justify") ? 'selected="selected"' : '';?>>Justify</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wpmtpv2_social"><?php _e('Social Media','wpmtpv2');?></label></th>
						<td>
							<select name="wpmtp[social_view]" class="wpmtpv2_sc" id="wpmtpv2_social_view">
								<option value="colored" <?php echo (isset($option['social_view']) && $option['social_view'] =="colored") ? 'selected="selected"' : '';?>>Colored Icons</option>
								<option value="text" <?php echo (isset($option['social_view']) && $option['social_view'] =="text") ? 'selected="selected"' : '';?>>Text Link</option>
								<option value="dark" <?php echo (isset($option['social_view']) && $option['social_view'] =="dark") ? 'selected="selected"' : '';?>>Dark Icons</option>
								<option value="light" <?php echo (isset($option['social_view']) && $option['social_view'] =="light") ? 'selected="selected"' : '';?>>Light Icons</option>
							</select>
						</td>
					</tr>
					<!-- <tr valign="top">
						<th scope="row"><label for="wpmtpv2_border"><?php _e('Disable Bottom Border','wpmtpv2')?>: </label></th>
						<td>
							<input type="checkbox" value="1" name="border" class="wpmtpv2_sc" id="wpmtpv2_border" />
						</td>
					</tr> -->

				</tbody>
			</table>
			<p class="wpp_save_changes_row">
			<input type="submit" value="Generate Shortcode" class="button-primary btn" name="Submit">
			 </p>
		</div>
		<div style="clear:both;"></div>
		<?php
	}

}
$wpmtpv2_shortcode_generator = new wpmtpv2_shortcode_generator();

	function sampl_sc(){
		return 'Thank you so much for reading! And remember to subscribe to our RSS feed. '; 
	}
	add_shortcode('signoff', 'sampl_sc'); 
?>