<?php

// Add the Meta Box
function add_grid_options_meta_box() {
    add_meta_box(
		'grid_options', // $id
		__('Grid Options', GETTEXT_DOMAIN), // $title 
		'show_grid_options_meta_box', // $callback
		'page', // $page
		'normal', // $context
		'high'); // $priority
}
add_action('add_meta_boxes', 'add_grid_options_meta_box');

// Field Array
$prefix = 'grid_options_';
$grid_options_meta_fields = array(
	array(
		'label'	=> __('Category Filter', GETTEXT_DOMAIN),
		'desc'	=> __('Enter categories [slugs separated by commas] you would like to display.', GETTEXT_DOMAIN),
		'id'	=> $prefix.'category_filter',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Caption Meta', GETTEXT_DOMAIN),
		'desc'	=> __('Check to hide caption meta.', GETTEXT_DOMAIN),
		'id'	=> $prefix.'box_caption_meta',
		'type'	=> 'checkbox'
	),
	array(
		'label'	=> __('Caption', GETTEXT_DOMAIN),
		'desc'	=> __('Check to hide caption.', GETTEXT_DOMAIN),
		'id'	=> $prefix.'box_caption',
		'type'	=> 'checkbox'
	),
	array(
		'label'	=> __('Caption Excerpt', GETTEXT_DOMAIN),
		'desc'	=> __('The number of words in caption.', GETTEXT_DOMAIN),
		'id'	=> $prefix.'box_caption_excerpt',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Navigation Filter', GETTEXT_DOMAIN),
		'desc'	=> __('Show the navigation filter bar at the top.', GETTEXT_DOMAIN),
		'id'	=> $prefix.'showFilterBar',
		'type'	=> 'checkbox'
	),
	array(
		'label'	=> __('Loading Images', GETTEXT_DOMAIN),
		'desc'	=> __('The number of images to load when you click the load more button.', GETTEXT_DOMAIN),
		'id'	=> $prefix.'imagesToLoad',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Images', GETTEXT_DOMAIN),
		'desc'	=> __('The number of images to load when it first loads the grid.', GETTEXT_DOMAIN),
		'id'	=> $prefix.'imagesToLoadStart',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Aligning', GETTEXT_DOMAIN),
		'desc'	=> __('If you wish to center the gallery.', GETTEXT_DOMAIN),
		'id'	=> $prefix.'isFitWidth',
		'type'	=> 'checkbox'
	),
	array(
		'label'	=> __('Columns', GETTEXT_DOMAIN),
		'desc'	=> __('The number of columns.', GETTEXT_DOMAIN),
		'id'	=> $prefix.'columns',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Columns Minimal Width', GETTEXT_DOMAIN),
		'desc'	=> __('The minimum width of each columns in pixels.', GETTEXT_DOMAIN),
		'id'	=> $prefix.'columnMinWidth',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Animation', GETTEXT_DOMAIN),
		'desc'	=> __('If you wish the gallery to have animated effects when resizing the grid.', GETTEXT_DOMAIN),
		'id'	=> $prefix.'isAnimated',
		'type'	=> 'checkbox'
	),
	array(
		'label'	=> __('Lightbox Play Interval', GETTEXT_DOMAIN),
		'desc'	=> __('The interval in the auto play mode in milliseconds (eg 1000).', GETTEXT_DOMAIN),
		'id'	=> $prefix.'lightBoxPlayInterval',
		'type'	=> 'text'
	),
	array(
		'label'	=> __('Text Button', GETTEXT_DOMAIN),
		'desc'	=> __('The "Load More Entries" word so you can translate it to another language.', GETTEXT_DOMAIN),
		'id'	=> $prefix.'loadMoreWord',
		'type'	=> 'text'
	),


);



// add some custom js to the head of the page
add_action('admin_head','add_grid_options_scripts');
function add_grid_options_scripts() {
	global $grid_options_meta_fields, $post, $pagenow;
	if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
	
	$output = '<script type="text/javascript">
				jQuery(function() {';
	
	foreach ($grid_options_meta_fields as $field) { // loop through the fields looking for certain types
		// date
		if($field['type'] == 'date')
			$output .= 'jQuery(".datepicker").datepicker();';
		// slider
		if ($field['type'] == 'slider') {
			$value = get_post_meta($post->ID, $field['id'], true);
			if ($value == '') $value = $field['min'];
			$output .= '
					jQuery( "#'.$field['id'].'-slider" ).slider({
						value: '.$value.',
						min: '.$field['min'].',
						max: '.$field['max'].',
						step: '.$field['step'].',
						slide: function( event, ui ) {
							jQuery( "#'.$field['id'].'" ).val( ui.value );
						}
					});';
		}
	}
	
	$output .= '});
	
jQuery(document).ready(function($) {

var getCurrentTemplate = $("#page_template").val();

if(getCurrentTemplate == "default"||getCurrentTemplate == "template-full-width.php"||getCurrentTemplate == "template-front.php"||getCurrentTemplate == "template-sitemap.php"){
    $("#grid_options-hide").attr("checked", false);
    $("#grid_options").css({"display":"none"});
}else{
    $("#grid_options-hide").attr("checked", true);
    $("#grid_options").css({"display":"block"});
}

$("#page_template").live("change",function(){

    var getCurrentTemplate = $("#page_template").val(); 

    if(getCurrentTemplate == "default"||getCurrentTemplate == "template-full-width.php"||getCurrentTemplate == "template-front.php"||getCurrentTemplate == "template-sitemap.php"){
        $("#grid_options-hide").attr("checked", false);
        $("#grid_options").css({"display":"none"});
    }else{
        $("#grid_options-hide").attr("checked", true);
        $("#grid_options").css({"display":"block"});
    }

});

});
	
		</script>';
		
	echo $output;
	}
}

// The Callback
function show_grid_options_meta_box() {
	global $grid_options_meta_fields, $post;
	// Use nonce for verification
	echo '<input type="hidden" name="grid_options_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	
	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($grid_options_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
					// text
					case 'text':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// textarea
					case 'textarea':
						echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox
					case 'checkbox':
						echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
								<label for="'.$field['id'].'">'.$field['desc'].'</label>';
					break;
					// select
					case 'select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						foreach ($field['options'] as $option) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// radio
					case 'radio':
						foreach ( $field['options'] as $option ) {
							echo '<input type="radio" name="'.$field['id'].'" id="'.$option['value'].'" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' />
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox_group
					case 'checkbox_group':
						foreach ($field['options'] as $option) {
							echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
					// tax_select
					case 'tax_select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">Select One</option>'; // Select One
						$terms = get_terms($field['id'], 'get=all');
						$selected = wp_get_object_terms($post->ID, $field['id']);
						foreach ($terms as $term) {
							if (!empty($selected) && !strcmp($term->slug, $selected[0]->slug)) 
								echo '<option value="'.$term->slug.'" selected="selected">'.$term->name.'</option>'; 
							else
								echo '<option value="'.$term->slug.'">'.$term->name.'</option>'; 
						}
						$taxonomy = get_taxonomy($field['id']);
						echo '</select><br /><span class="description"><a href="'.get_bloginfo('home').'/wp-admin/edit-tags.php?taxonomy='.$field['id'].'">Manage '.$taxonomy->label.'</a></span>';
					break;
					// post_list
					case 'post_list':
					$items = get_posts( array (
						'post_type'	=> $field['post_type'],
						'posts_per_page' => -1
					));
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">Select One</option>'; // Select One
							foreach($items as $item) {
								echo '<option value="'.$item->ID.'"',$meta == $item->ID ? ' selected="selected"' : '','>'.$item->post_type.': '.$item->post_title.'</option>';
							} // end foreach
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// date
					case 'date':
						echo '<input type="text" class="datepicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// slider
					case 'slider':
					$value = $meta != '' ? $meta : '0';
						echo '<div id="'.$field['id'].'-slider"></div>
								<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$value.'" size="5" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// image
					case 'image':
						$image = get_template_directory_uri().'/images/image.png';	
						echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';
						if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium');	$image = $image[0]; }				
						echo	'<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" />
									<img src="'.$image.'" class="custom_preview_image" alt="" /><br />
										<input class="custom_upload_image_button button" type="button" value="Choose Image" />
										<small>&nbsp;<a href="#" class="custom_clear_image_button">Remove Image</a></small>
										<br clear="all" /><span class="description">'.$field['desc'].'</span>';
					break;
					// repeatable
					case 'repeatable':
						echo '<a class="repeatable-add button" href="#">+</a>
								<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';
						$i = 0;
						if ($meta) {
							foreach($meta as $row) {
								echo '<li><span class="sort hndle">|||</span>
											<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="'.$row.'" size="30" />
											<a class="repeatable-remove button" href="#">-</a></li>';
								$i++;
							}
						} else {
							echo '<li><span class="sort hndle">|||</span>
										<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="" size="30" />
										<a class="repeatable-remove button" href="#">-</a></li>';
						}
						echo '</ul>
							<span class="description">'.$field['desc'].'</span>';
					break;
					// wp_editor
					case 'wp_editor':
					$value = $meta != '' ? $meta : '0';
						wp_editor( $value, $field['id'], array( 'textarea_rows' => '5' ) );
						echo '<br /><span class="description">'.$field['desc'].'</span>';
					break;
				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}

// Save the Data
function save_grid_options_meta($post_id) {
    global $grid_options_meta_fields;
	
	// verify nonce
	$nonce = '';
	if(isset($_POST['grid_options_meta_box_nonce'])){ $nonce = $_POST['grid_options_meta_box_nonce']; }
	
	if (!wp_verify_nonce($nonce, basename(__FILE__))) 
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
	
	// loop through fields and save the data
	foreach ($grid_options_meta_fields as $field) {
		if($field['type'] == 'tax_select') continue;
		$old = get_post_meta($post_id, $field['id'], true);
		$new = '';
		if(isset($_POST[$field['id']])){ $new = $_POST[$field['id']]; }
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // enf foreach
	
	// save taxonomies
	#$post = get_post($post_id);
	#$category = $_POST['category'];
	#wp_set_object_terms( $post_id, $category, 'category' );
}
add_action('save_post', 'save_grid_options_meta');

?>