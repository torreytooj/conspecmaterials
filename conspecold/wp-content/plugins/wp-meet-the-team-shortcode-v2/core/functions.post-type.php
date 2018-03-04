<?php

/*
 * WP - Meet the Team Shortcode v2
 * http://meet-the-team.jeffreycarandang.com/
 *
 * Date: Friday, 19 Jul 2013
 */

/*##################################
	CUSTOM POST TYPE
################################## */

function register_wpmtpv2_post_type(){
	$labels=array(
					'name' => WPMTPv2_OPTIONS()->plural,
					'singular_name' => WPMTPv2_OPTIONS()->singular,
					'add_new' => 'Add New ' . WPMTPv2_OPTIONS()->singular,
					'add_new_item' => 'Add New ' . WPMTPv2_OPTIONS()->singular,
					'edit_item' => 'Edit ' . WPMTPv2_OPTIONS()->singular,
					'new_item' => 'New ' . WPMTPv2_OPTIONS()->singular,
					'view_item' => 'View ' . WPMTPv2_OPTIONS()->singular,
					'search_items' => 'Search ' . WPMTPv2_OPTIONS()->singular,
					'not_found' => 'No '. WPMTPv2_OPTIONS()->singular .' Found',
					'not_found_in_trash' => 'No '. WPMTPv2_OPTIONS()->singular .' Found in Trash'
					
				);
	$supports=array('title','editor','author','thumbnail','excerpt','comments','custom-fields','revisions');
		
	$args = array(
				'public' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => WPMTPv2_OPTIONS()->slug ),
				'show_in_nav_menus' => true,
				'publicly_queryable' => true,
				'has_archive' => true,
				'can_export' => true,
				'supports' => $supports,
				'exclude_from_search' => true,
				'menu_position' => 5,
				'singular_label' => WPMTPv2_OPTIONS()->singular,
				'labels' => $labels ,
				'capability_type' => 'post',
				'menu_icon' => WPMTPv2_IMG . '/icon.png',
				'register_meta_box_cb' => 'wpmtpv2_info_create_metabox',
				''
	);
	register_post_type('team',$args);
	flush_rewrite_rules();
}
add_action('init','register_wpmtpv2_post_type');

function register_wpmtpv2_taxonomy(){
	$labels = array(
				'name' => WPMTPv2_OPTIONS()->category,
				'singular_name' => WPMTPv2_OPTIONS()->category,
				'search_items' => 'Search ' . WPMTPv2_OPTIONS()->category,
				'popular_items' => 'Popular ' . WPMTPv2_OPTIONS()->category,
				'all_items' => 'All ' . WPMTPv2_OPTIONS()->category ,
				'edit_item' => 'Edit '. WPMTPv2_OPTIONS()->category .' Information' , 
				'update_item' => 'Update '. WPMTPv2_OPTIONS()->category .' Information',
				'add_new_item' =>  'Add New' ,
				'new_item_name' => 'New '. WPMTPv2_OPTIONS()->category,
				'menu_name' => WPMTPv2_OPTIONS()->category,
			);
			
	$args = array(
						'hierarchical' => true,
						'labels' => $labels,
						'show_ui' => true,
						'query_var' => true,
						'show_tagcloud' => true,
						'rewrite' => true
					);
	//Register Taxonomy				
	register_taxonomy('team-category','team',$args);
}
add_action('init','register_wpmtpv2_taxonomy');

function edit_wpmtpv2_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Name','wpmtp' ),
		'jobtitle' => __( 'Job Title','wpmtp' ),
		'image' => __( 'Image','wpmtp' )
	);

	return $columns;
}
add_filter( 'manage_edit-team_columns', 'edit_wpmtpv2_columns' ) ;

function manage_wpmtpv2_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		case 'jobtitle' :
			_e( get_post_meta($post_id,'_wpmtp_job_title',true) );
		break;

		case 'image' :
			the_post_thumbnail('wpmtpv2-admin-thumb');
		break;
		
		default :
			break;
	}
}
add_action( 'manage_team_posts_custom_column', 'manage_wpmtpv2_columns', 10, 2 );

function register_team_column_views_sortable( $newcolumn ) {
    $newcolumn['jobtitle'] = 'jobtitle';
    return $newcolumn;
}
add_filter( 'manage_edit-team_sortable_columns', 'register_team_column_views_sortable' );

function sort_views_column( $vars ) 
{
    if ( isset( $vars['orderby'] ) ) {
    	switch ($vars['orderby']) {
    		case 'jobtitle':
    			$key = '_wpmtp_job_title';
    			break;

    		default:
    			# code...
    			break;
    	}
    	if(!empty($key)){
    		$vars = array_merge( $vars, array(
	            'meta_key' => $key, //Custom field key
	            'orderby' => 'meta_value') //Custom field value (number)
	        );
    	}
    }
    return $vars;
}
add_filter( 'request', 'sort_views_column' );

?>