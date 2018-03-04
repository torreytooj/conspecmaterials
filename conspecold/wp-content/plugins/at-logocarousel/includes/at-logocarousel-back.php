<?php
function at_logocarousel_load_post_type() {

	// POST TYPE
	$labels = array(
		'name' => 'Carousels',
		'singular_name' => 'Carousel',
		'add_new' => 'Add New Set',
		'add_new_item' => 'Add a new Set of logos',
		'edit_item' => 'Edit Carousel',
		'new_item' => 'New Carousel',
		'all_items' => 'All Sets of Logos',
		'view_item' => 'View Carousel',
		'search_items' => 'Search Carousels',
		'not_found' =>  'No Carousels found',
		'not_found_in_trash' => 'No Carousels found in Trash', 
		'parent_item_colon' => '',
		'menu_name' => 'Logos Carousel'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => array( 'slug' => 'at_noti' ),
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => true,
		'menu_position' => null,
		'menu_icon' => plugin_dir_url(__FILE__).'../alchemytheme.png',
		'supports' => array('title', 'page-attributes')
	); 
	register_post_type('at_logocarousel', $args);
	
	// OPTIONS PAGE
	add_action('admin_menu' , 'at_logocarousel_options_pages');
	function at_logocarousel_options_pages() {
		add_submenu_page('edit.php?post_type=at_logocarousel', AT_LOGOCAR_PLUGIN.' Settings', __('Settings'), 'edit_posts', basename(__FILE__), 'at_logocarousel_settings_page');
	}
	function at_logocarousel_settings_page() {
		if ($_POST) {
			$at_save_options = array(
				'cc_username' => $_POST['at_logocarousel_options']['cc_username'],
				'cc_license_key' => $_POST['at_logocarousel_options']['cc_license_key'],
				'waitforimages' => $_POST['at_logocarousel_options']['waitforimages'],
				'smartresize' => $_POST['at_logocarousel_options']['smartresize'],
			);
			update_option('at_logocarousel_options', $at_save_options);
		}
		
		$at_logocarousel_options = get_option('at_logocarousel_options');
		?>
		
		<div class="wrap">
			<?php screen_icon('users'); ?><h2><?php echo AT_LOGOCAR_PLUGIN.' Settings'; ?></h2>
            
            <form method="post">
            
				<?php settings_fields('at_logocarousel_options'); ?>
                <?php do_settings_sections('at_logocarousel'); ?>
                
                <h3 class="title">Update from Repository</h3>
                <table class="form-table"> 
                	
                    
                    <tr valign="top">
                        <th colspan="3">
                            <h3>Required scripts</h3>
                            <p class="description">This plugin includes two other scripts, <strong>jquery.smartResize</strong> and <strong>jquery.waitForImages</strong>. It is sometimes possible that your theme also<br />
                            					   includes one of these scripts, in which case compatibility issues may occur. In those cases, try disabling one or both of these scripts to avoid two copies of the<br />
                                                   same script loading at the same time.<br /><br />
                                                   
                                                   Please notice that these plugins are REQUIRED by LogoCarousel, so disabled them only if your theme (or other plugin) already include a copy of them.</p>
                        </th>
                    </tr>
                    
                    <tr valign="top">
                        <th>
                            <label>smartResize</label>
                        </th>
                        <td colspan="2">
                            <select name="at_logocarousel_options[smartresize]" class="regular-text">
                            	<option value="enabled">Enabled</option>
                                <option value="disabled" <?php echo ((isset($at_logocarousel_options['smartresize']) && $at_logocarousel_options['smartresize'] == 'disabled') ? 'selected="selected"' : ''); ?>>Disabled</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th>
                            <label>waitForImages</label>
                        </th>
                        <td colspan="2">
                            <select name="at_logocarousel_options[waitforimages]" class="regular-text">
                            	<option value="enabled">Enabled</option>
                                <option value="disabled" <?php echo ((isset($at_logocarousel_options['waitforimages']) && $at_logocarousel_options['waitforimages'] == 'disabled') ? 'selected="selected"' : ''); ?>>Disabled</option>
                            </select>
                        </td>
                    </tr>
                    
                    
                    <tr valign="top">
                        <th colspan="3">
                            <h3>Repository</h3>
                        </th>
                    </tr>
                    
                    <tr valign="top">
                        <th>
                            <label>CodeCanyon Username</label>
                        </th>
                        <td colspan="2">
                            <input type="text" name="at_logocarousel_options[cc_username]" value="<?php echo $at_logocarousel_options['cc_username']; ?>" class="regular-text" />
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th>
                            <label>Purchase License Key</label>
                        </th>
                        <td colspan="2">
                            <input type="text" name="at_logocarousel_options[cc_license_key]" value="<?php echo $at_logocarousel_options['cc_license_key']; ?>" class="regular-text" />
                            <p class="description">This information is used so you can automatically<br />update your plugin from WordPress.</p>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                    
                        <td colspan="2">
                        <input name="Submit" type="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
                        </td>
                    
                    </tr>
                </table>
            </form>
		
		</div>
		
		<?php
		
	}
	
	// CUSTOM LIST COLUMNS
	add_filter('manage_edit-at_logocarousel_columns', 'at_logocarousel_columns');
	function at_logocarousel_columns($columns) {
		$columns['collections'] = 'Collection(s)';
		$columns['thumb'] = 'Thumbnail';
		
		$columns = array('cb' => '<input type="checkbox" />', 'at_logocarousel_thumb' => 'Example logo', 'title' => 'Gallery name', 'at_logocarousel_photos' => 'Logo(s)', 'date' => 'Created on');
		return $columns;
	}
	add_action('manage_pages_custom_column',  'at_logocarousel_show_columns');
	function at_logocarousel_show_columns($name) {
		global $post;
		
		if ($name == 'at_logocarousel_photos') {
			$meta_tmp = get_post_meta($post->ID, 'post_media');
			$post_media = $meta_tmp[0];
			
			if (!is_array($post_media)) { $num = 0; }
			else { $num = count($post_media); }
			
			echo $num;
		}
		else if ($name == 'at_logocarousel_thumb') {
			$meta_tmp = get_post_meta($post->ID, 'post_media');
			$post_media = $meta_tmp[0];
			
			if ((is_array($post_media)) && (count($post_media) > 0)) {
				$img_src = wp_get_attachment_image_src($post_media[1]['id'], 'medium');
				echo '<img src="'.$img_src[0].'" alt="" height="80">';
			}

		}
	}
	
	
	// METABOXES 
	add_action('add_meta_boxes', 'at_add_at_logocarousel_box' );
	add_action('save_post', 'at_save_at_logocarousel_postdata');
	
	
	function at_add_at_logocarousel_box() {
		add_meta_box('at_metabox', __('Gallery images', 'at_textdomain'), 'at_inner_at_logocarousel_box', 'at_logocarousel');
	}
	
	function at_inner_at_logocarousel_box($post) {
		wp_nonce_field(plugin_basename( __FILE__ ), 'at_noncename');
		
		$theme_options = get_option(OPTIONS);
		$meta_tmp = get_post_meta($post->ID, 'post_media');
		$post_media = $meta_tmp[0];
		$meta_tmp = get_post_meta($post->ID, 'post_at_options');
		$post_options = $meta_tmp[0];
		?>
		
        <?php add_thickbox(); ?>
        
		<style>
		</style>
		
		<script type="text/javascript">
		(function($) {
			$(document).ready(function() {
				$('#pageparentdiv').hide();
				$('#galleries-metabox .insert-media').html('Upload/Add new logo');
				$('#publish').insertBefore('#side-sortables').css({
					'width': '100%',
					'margin-bottom': '20px',
					'height': '50px',
					'text-transform': 'uppercase',
					'font-weight': 'bold',
					'letter-spacing': '2px'
				});
				$('#post-preview').hide();
				$('#submitdiv .hndle span').text('Set status');
				$('#at_logocarousel_options_div').insertBefore('#submitdiv').show();
				$('#at_logocarousel_options_div_callaction').insertAfter('#advanced-sortables').show();
				
				$('#at_carousel_style_option').change(function() {
					var val = $(this).val();
					if (val == 'horizontal') {
						$('#at_carousel_animation_vertical').hide();
						$('#at_carousel_animation_horizontal').show();
						$('#at_carousel_cols').hide();
						$('#at_carousel_rows').show();
					}
					else {
						$('#at_carousel_animation_vertical').show();
						$('#at_carousel_animation_horizontal').hide();
						$('#at_carousel_cols').show();
						$('#at_carousel_rows').hide();
					}
					
				}).change();
				
				window.original_send_to_editor = window.send_to_editor;			
				
				window.send_to_editor = function (html) {
					var o = 0;
					$('<div id="tempHTMLcodeFROMmedia" style="display: none;">'+html+'</div>').appendTo('body');
					
					if ($('#tempHTMLcodeFROMmedia').find('img').length > 0) {
						$('#tempHTMLcodeFROMmedia').find('img').each(function(i) {
							var img_src = $(this).attr('src');
							var img_class = $(this).attr('class');
							var img_classes = img_class.split(' ');
							var img_id = '';
							for (var h = 0; h < img_classes.length; h++) {
								//alert(img_classes[h]);
								if (img_classes[h].indexOf("wp-image-") != -1) {
									img_id = img_classes[h].replace("wp-image-", "");
								}
							}
							
							// Create a new ITEM 
							var li = $('<li>');
							
							// Add the image to the ITEM
							var img = $('<img>');
							img.attr('src', img_src);
							img.appendTo(li);
							
							// Add inputs to the ITEM 
							var filename_id = $('<input>');
							filename_id.attr('type', 'hidden');
							filename_id.attr('name', 'post_media['+(parseInt($('#galleries-playground > li').length,10) + i)+'][id]');
							filename_id.val(img_id);
							filename_id.appendTo(li);

							var filename_title = $('<input>');
							filename_title.attr('type', 'hidden');
							filename_title.attr('class', 'at_logocarousel_link_input');
							filename_title.attr('name', 'post_media['+(parseInt($('#galleries-playground > li').length,10) + i)+'][logo_link]');
							filename_title.val('');
							filename_title.appendTo(li);
							
							$('<ul class="options_block"> \
								<li><a href="#" class="at_logocarousel_link_input_delete">Delete</a></li> \
								<li><a href="#" class="at_logocarousel_link_input_edit">Link</a></li> \
							</ul>').appendTo(li);
							
							// Append ITEM to the playground 
							setTimeout(function() {
								li.appendTo('#galleries-playground');
								
								li.find('.at_logocarousel_link_input_edit').click(function(event) {
									event.preventDefault();
									var input = $(this).parent().parent().parent().find('.at_logocarousel_link_input');
									var new_url = prompt("URL for this logo's link", input.val());
									
									if (new_url != '' && new_url != null) {
										input.val(new_url);
									}
									
								});
								
								li.find('.at_logocarousel_link_input_delete').click(function(event) {
									event.preventDefault();
									if (confirm('Are you sure you want to delete this logo?')) {
										$(this).parent().parent().parent().fadeOut(function() {
											$(this).remove();
										});
									}
								});
								
							}, i*100);
							o++;
						});
						setTimeout(function() {
							$('#galleries-playground').sortable();
						}, ((o+1)*110)+1000);
					}
					else {
						alert('Selected file must be an image');
					}
					
					$('#tempHTMLcodeFROMmedia').remove();
					tb_remove();
					$('#galleries-playground-container .loading-block').fadeOut(1000);
				};
				
				
				jQuery('.color-picker').each(function() {
					var t = jQuery(this);
					t.wpColorPicker({
						change: function(event, uii) {
							var newColor = uii.color.toString();
							if (newColor.indexOf('#') === -1) {
								newColor = '#'+newColor;
							}
							
							//var targetField = jQuery(this).closest('.row.layer_row').find('.layer-color-picker');
							targetField = jQuery(this);
							jQuery(this).val(newColor);
							targetField.val(newColor);
						},
						clear: function(event) { 
							event.preventDefault();
							jQuery(this).parent().find('.color-picker').val('#FFFFFF').change(); 
							return false;
						}
					});
				});
				
				$('.at_logocarousel_link_input_edit').click(function(event) {
					event.preventDefault();
					var input = $(this).parent().parent().parent().find('.at_logocarousel_link_input');
					var new_url = prompt("URL for this logo's link", input.val());
					
					if (new_url != '' && new_url != null) {
						input.val(new_url);
					}
					
				});
				
				$('.at_logocarousel_link_input_delete').click(function(event) {
					event.preventDefault();
					if (confirm('Are you sure you want to delete this logo?')) {
						$(this).parent().parent().parent().fadeOut(function() {
							$(this).remove();
						});
					}
				});
				
				//$('#galleries-playground li img').live('click', function() {
				//	tb_show('', '#TB_inline?inlineId=hiddenModalContent&modal=true');
				//});
				
				$('.media-modal-content .media-toolbar .media-button-insert').live('click', function() {
					$('#galleries-playground-container .loading-block').fadeIn(500);
				});
				
				$('#galleries-playground').sortable();
				
			});
		}) (jQuery);
		</script>
		
		<div class="at-metabox" id="galleries-metabox">
			<input id="new_blank_image" type="text" size="0" name="new_blank_image" style="opacity:0; width:0px; padding:0px; margin:0px;" value="<?php echo esc_attr($value); ?>" />
			<?php do_action('media_buttons', 'new_blank_image'); ?>
			
			
			<div id="hiddenModalContent" style="display:none">
				<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
				<p style="text-align:center"><input type="submit" id="Login" value="&nbsp;&nbsp;Ok&nbsp;&nbsp;" onclick="tb_remove()" /></p>
			</div>
			
			<div id="galleries-playground-container">
				<div class="loading-block"><div class="table"><span>Loading...</span></div></div>
				<ul id="galleries-playground">
					<?php
					if ($post_media) {
						$i = 0;
						foreach($post_media as $img) {
							$img_src = wp_get_attachment_image_src($img['id'], 'medium');
							?>
							<li>
								<img src="<?php echo $img_src[0]; ?>" />
								<input type="hidden" name="post_media[<?php echo $i; ?>][id]" value="<?php echo $img['id']; ?>" />
                                <input type="hidden" class="at_logocarousel_link_input" name="post_media[<?php echo $i; ?>][logo_link]" value="<?php echo $img['logo_link']; ?>" />
                                <ul class="options_block">
	                                <li><a href="#" class="at_logocarousel_link_input_delete">Delete</a></li>
                                	<li><a href="#" class="at_logocarousel_link_input_edit">Link</a></li>
                                </ul>
							</li>
							<?php
							$i++;
						}
					}
					?>
				</ul>
			</div>
		</div>
        
        
        <div id="at_shortcode_message" class="updated"><p>Insert the carousel on your posts &amp; pages using the following shortcode:&nbsp;&nbsp;&nbsp; <strong>[at_logo_carousel id="<?php global $post; echo $post->ID; ?>"]</strong></p></div>
        
        <div id="at_logocarousel_options_div" class="postbox " style="display:none;">
            <div class="handlediv" title="Click to toggle"><br></div>
            <h3 class="hndle"><span>Carousel Options</span></h3>
            
            <div class="inside" style="margin: 0; padding: 0;">
            	<div class="submitbox" id="submitpost">
            
            
            		<div id="misc-publishing-actions">
            
                        <div class="misc-pub-section">
                        	<input id="force_fullwidth_checkbox" type="checkbox" name="post_at_options[force_fullwidth]" <?php echo ((isset($post_options['force_fullwidth']) && $post_options['force_fullwidth'] == 'on') ? 'checked="checked"' : '' ); ?> />
                            <label for="force_fullwidth_checkbox">force full page width</label>
                            
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section">
                        	<label for="post_status">Style:</label>
                            <select name="post_at_options[style]" id="at_carousel_style_option">
                            	<option value="horizontal" <?php echo ((isset($post_options['style']) && $post_options['style'] == 'horizontal') ? 'selected="selected"' : ''); ?>>Horizontal</option>
                                <option value="vertical" <?php echo ((isset($post_options['style']) && $post_options['style'] == 'vertical') ? 'selected="selected"' : ''); ?>>Vertical</option>
                            </select>
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section" id="at_carousel_rows">
                        	<label for="post_status">Rows:</label>
                            <input type="text" name="post_at_options[rows]" size="5"  value="<?php echo ((isset($post_options['rows'])) ? $post_options['rows'] : '4'); ?>" /> (default: 4)                            
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section" id="at_carousel_rows">
                        	<label for="post_status">Height:</label>
                            <input type="text" name="post_at_options[height]" size="5"  value="<?php echo ((isset($post_options['height'])) ? $post_options['height'] : '300'); ?>" />px (default: 300)                            
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section" id="at_carousel_rows">
                        	<label for="post_status">Logo max-width:</label>
                            <input type="text" name="post_at_options[logo_max_width]" size="5"  value="<?php echo ((isset($post_options['logo_max_width'])) ? $post_options['logo_max_width'] : '0'); ?>" />px (0 = disabled)                            
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section" id="at_carousel_rows">
                        	<label for="post_status">Logo max-height:</label>
                            <input type="text" name="post_at_options[logo_max_height]" size="5"  value="<?php echo ((isset($post_options['logo_max_height'])) ? $post_options['logo_max_height'] : '0'); ?>" />px (0 = disabled)                            
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section" id="at_carousel_cols">
                        	<label for="post_status">Columns:</label>
                            <input type="text" name="post_at_options[cols]" size="5"  value="<?php echo ((isset($post_options['cols'])) ? $post_options['cols'] : '5'); ?>" /> (default: 5)                            
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section">
                        	<label for="post_status">Logo sides margin:</label>
                            <input type="text" name="post_at_options[logo_padding_lr]" size="5"  value="<?php echo ((isset($post_options['logo_padding_lr'])) ? $post_options['logo_padding_lr'] : '30'); ?>" />px (def: 30)                            
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section">
                        	<label for="post_status">Logo top+bot margin:</label>
                            <input type="text" name="post_at_options[logo_padding_tb]" size="5"  value="<?php echo ((isset($post_options['logo_padding_tb'])) ? $post_options['logo_padding_tb'] : '15'); ?>" />px (def: 15)                            
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section" id="at_carousel_animation_horizontal" style="display:none;">
                        	<label for="post_status">Animation:</label>
                            <select name="post_at_options[animation_horizontal]">
                            	<option value="right" <?php echo ((isset($post_options['animation_horizontal']) && $post_options['animation_horizontal'] == 'right') ? 'selected="selected"' : ''); ?>>Left to Right</option>
                                <option value="left" <?php echo ((isset($post_options['animation_horizontal']) && $post_options['animation_horizontal'] == 'left') ? 'selected="selected"' : ''); ?>>Right to Left</option>
                            </select>
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section" id="at_carousel_animation_vertical" style="display:none;">
                        	<label for="post_status">Animation:</label>
                            <select name="post_at_options[animation_vertical]">
                            	<option value="down" <?php echo ((isset($post_options['animation_vertical']) && $post_options['animation_vertical'] == 'down') ? 'selected="selected"' : ''); ?>>Top to Bottom</option>
                                <option value="up" <?php echo ((isset($post_options['animation_vertical']) && $post_options['animation_vertical'] == 'up') ? 'selected="selected"' : ''); ?>>Bottom to Top</option>
                            </select>
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section">
                        	<label for="post_status">Speed:</label>
                            <input type="text" name="post_at_options[speed]" size="5"  value="<?php echo ((isset($post_options['speed'])) ? $post_options['speed'] : '60'); ?>" /> (default: 60)                            
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section">
                        	<label for="post_status">Speed randomizer:</label>
                            <input type="text" name="post_at_options[speed_random]" size="5" value="<?php echo ((isset($post_options['speed_random'])) ? $post_options['speed_random'] : '15'); ?>" /> (default: 15)                            
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section">
                        	<label for="post_status">Stop on mouse-over:</label>                            
                            <input type="checkbox" name="post_at_options[hover_stop]" <?php echo ((isset($post_options['hover_stop']) && $post_options['hover_stop'] == 'on') ? 'checked="checked"' : '' ); ?> />
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section">
                        	<label for="post_status">Enable links:</label>                            
                            <input type="checkbox" name="post_at_options[links]" <?php echo ((isset($post_options['links']) && $post_options['links'] == 'on') ? 'checked="checked"' : '' ); ?> />
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section">
                        	<label for="post_status">Links target:</label>
                            <select name="post_at_options[links_target]">
                            	<option value="_blank" <?php echo ((isset($post_options['links_target']) && $post_options['links_target'] == '_blank') ? 'selected="selected"' : ''); ?>>_blank</option>
                                <option value="_new" <?php echo ((isset($post_options['links_target']) && $post_options['links_target'] == '_new') ? 'selected="selected"' : ''); ?>>_new</option>
                                <option value="_parent" <?php echo ((isset($post_options['links_target']) && $post_options['links_target'] == '_parent') ? 'selected="selected"' : ''); ?>>_parent</option>
                                <option value="_self" <?php echo ((isset($post_options['links_target']) && $post_options['links_target'] == '_self') ? 'selected="selected"' : ''); ?>>_self</option>
                                <option value="_top" <?php echo ((isset($post_options['links_target']) && $post_options['links_target'] == '_top') ? 'selected="selected"' : ''); ?>>_top</option>
                            </select>
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section">
                        	<label for="post_status">Background:</label><br /><br />
                            <input type="text" class="color-picker" name="post_at_options[background]"  value="<?php echo ((isset($post_options['background'])) ? $post_options['background'] : ''); ?>" />
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section">
                        	<label for="post_status">Borders:</label>
                            <select name="post_at_options[borders]">
                            	<option value="disabled" <?php echo ((isset($post_options['borders']) && $post_options['borders'] == 'disabled') ? 'selected="selected"' : ''); ?>>Disabled</option>
                                <option value="top" <?php echo ((isset($post_options['borders']) && $post_options['borders'] == 'top') ? 'selected="selected"' : ''); ?>>Top</option>
                                <option value="bottom" <?php echo ((isset($post_options['borders']) && $post_options['borders'] == 'bottom') ? 'selected="selected"' : ''); ?>>Bottom</option>
                                <option value="topbottom" <?php echo ((isset($post_options['borders']) && $post_options['borders'] == 'topbottom') ? 'selected="selected"' : ''); ?>>Top + Bottom</option>
                                <option value="all" <?php echo ((isset($post_options['borders']) && $post_options['borders'] == 'all') ? 'selected="selected"' : ''); ?>>All</option>
                            </select>
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section" style="border-bottom:none;">
                        	<label for="post_status">Borders color:</label><br /><br />
                            <input type="text" class="color-picker" name="post_at_options[borders_color]"  value="<?php echo ((isset($post_options['borders_color'])) ? $post_options['borders_color'] : ''); ?>" />
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section">
                        	<label for="post_status">Top Margin:</label>
                            <input type="text" name="post_at_options[margin_top]" size="5" value="<?php echo ((isset($post_options['margin_top'])) ? $post_options['margin_top'] : '0'); ?>" />px (default: 0)                            
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section">
                        	<label for="post_status">Bottom Margin:</label>
                            <input type="text" name="post_at_options[margin_bottom]" size="5" value="<?php echo ((isset($post_options['margin_bottom'])) ? $post_options['margin_bottom'] : '25'); ?>" />px (default: 25)                            
                        </div><!-- .misc-pub-section -->

            			<div class="clear"></div>
            		</div>
                    
            	</div>
            </div>
        </div>
        
        <div id="at_logocarousel_options_div_callaction" class="postbox " style="display:none;">
            <div class="handlediv" title="Click to toggle"><br></div>
            <h3 class="hndle"><span>Call to Action</span></h3>
            
            <div class="inside" style="margin: 0; padding: 0;">
            	<div class="submitbox" id="submitpost">
            
            
            		<div id="misc-publishing-actions">
            
                        <div class="misc-pub-section">
                        	<label for="post_status">Add Call to Action:</label>
                            <select name="post_at_options[callaction]">
                            	<option value="no" <?php echo ((isset($post_options['callaction']) && $post_options['callaction'] == 'no') ? 'selected="selected"' : ''); ?>>No</option>
                                <option value="yes" <?php echo ((isset($post_options['callaction']) && $post_options['callaction'] == 'yes') ? 'selected="selected"' : ''); ?>>Yes</option>
                            </select>
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section">
                        	<label for="post_status">Style:</label>
                            <select name="post_at_options[callaction_style]">
                            	<option value="light" <?php echo ((isset($post_options['callaction_style']) && $post_options['callaction_style'] == 'light') ? 'selected="selected"' : ''); ?>>Light</option>
                                <option value="dark" <?php echo ((isset($post_options['callaction_style']) && $post_options['callaction_style'] == 'dark') ? 'selected="selected"' : ''); ?>>Dark</option>
                            </select>
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section" id="at_carousel_rows">
                        	<label for="post_status">Title:</label><br />
                            <input type="text" style="width:100%;" name="post_at_options[callaction_title]"  value="<?php echo ((isset($post_options['callaction_title'])) ? $post_options['callaction_title'] : ''); ?>" />                          
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section" id="at_carousel_rows">
                        	<label for="post_status">Text:</label><br />
                            <textarea style="display:block; height:130px; width:100%;" name="post_at_options[callaction_text]"><?php echo ((isset($post_options['callaction_text'])) ? $post_options['callaction_text'] : ''); ?></textarea>                          
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section">
                        	<label for="post_status">Layout:</label>
                            <select name="post_at_options[callaction_layout]">
                            	<option value="centered" <?php echo ((isset($post_options['callaction_layout']) && $post_options['callaction_layout'] == 'centered') ? 'selected="selected"' : ''); ?>>Centered text + button</option>
                                <option value="button_right" <?php echo ((isset($post_options['callaction_layout']) && $post_options['callaction_layout'] == 'button_right') ? 'selected="selected"' : ''); ?>>Text to left + button to right</option>
                                <option value="button_left" <?php echo ((isset($post_options['callaction_layout']) && $post_options['callaction_layout'] == 'button_left') ? 'selected="selected"' : ''); ?>>Text to right + button to left</option>
                            </select>
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section" id="at_carousel_rows">
                        	<label for="post_status">Button text:</label><br />
                            <input type="text" style="width:100%;" name="post_at_options[callaction_button_text]"  value="<?php echo ((isset($post_options['callaction_button_text'])) ? $post_options['callaction_button_text'] : ''); ?>" />                          
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section" id="at_carousel_rows">
                        	<label for="post_status">Button link URL:</label><br />
                            <input type="text" style="width:100%;" name="post_at_options[callaction_button_link]"  value="<?php echo ((isset($post_options['callaction_button_link'])) ? $post_options['callaction_button_link'] : ''); ?>" />                          
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section">
                        	<label for="post_status">Button link target:</label>
                            <select name="post_at_options[callaction_button_link_target]">
                            	<option value="_blank" <?php echo ((isset($post_options['callaction_button_link_target']) && $post_options['callaction_button_link_target'] == '_blank') ? 'selected="selected"' : ''); ?>>_blank</option>
                                <option value="_new" <?php echo ((isset($post_options['callaction_button_link_target']) && $post_options['callaction_button_link_target'] == '_new') ? 'selected="selected"' : ''); ?>>_new</option>
                                <option value="_parent" <?php echo ((isset($post_options['callaction_button_link_target']) && $post_options['callaction_button_link_target'] == '_parent') ? 'selected="selected"' : ''); ?>>_parent</option>
                                <option value="_self" <?php echo ((isset($post_options['callaction_button_link_target']) && $post_options['callaction_button_link_target'] == '_self') ? 'selected="selected"' : ''); ?>>_self</option>
                                <option value="_top" <?php echo ((isset($post_options['callaction_button_link_target']) && $post_options['callaction_button_link_target'] == '_top') ? 'selected="selected"' : ''); ?>>_top</option>
                            </select>
                        </div><!-- .misc-pub-section -->
                        
                        <div class="misc-pub-section" style="border-bottom:none;">
                        	<label for="post_status">Add dismiss link: </label>
                            <input type="checkbox" name="post_at_options[callaction_dismiss]" <?php echo ((isset($post_options['callaction_dismiss']) && $post_options['callaction_dismiss'] == 'on') ? 'checked="checked"' : '' ); ?> />
                            
                        </div><!-- .misc-pub-section -->

            			<div class="clear"></div>
            		</div>
                    
            	</div>
            </div>
        </div>
		<?php
	  
	}
	
	function at_save_at_logocarousel_postdata($post_id) {
		if (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;
		if (!wp_verify_nonce( $_POST['at_noncename'], plugin_basename( __FILE__ ))) return;
		if ('page' == $_POST['post_type'] ) { if (!current_user_can( 'edit_page', $post_id )) return; }
		else { if (!current_user_can( 'edit_post', $post_id )) return; }
		
		$mydata = $_POST;
		$metas = array('post_media', 'post_at_options');
	  
		foreach ($metas as $m) {
			if (get_post_meta($post_id, $m)) {
				update_post_meta($post_id, $m, $mydata[$m]);
			}
			else {
				add_post_meta($post_id, $m, $mydata[$m], true);
			}
		}
	}
	
}
add_action('init', 'at_logocarousel_load_post_type');
?>