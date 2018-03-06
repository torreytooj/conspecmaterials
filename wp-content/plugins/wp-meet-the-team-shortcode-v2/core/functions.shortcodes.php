<?php

/*
 * WP - Meet the Team Shortcode v2
 * http://meet-the-team.jeffreycarandang.com/
 *
 * Date: Friday, 19 Jul 2013
 */


/*##################################
	SHORTCODES
################################## */
add_action( 'init', 'wpmtpv2_register_shortcodes');
function wpmtpv2_register_shortcodes(){
   add_shortcode('display-team', 'wpmtpv2_display_team');
}	

function wpmtpv2_display_team($atts, $content = null){
	extract(shortcode_atts(array(
	  'ids'				=>	null,
      'category'		=>	null,
      'orderby'			=>	null,
      'order'			=>	null,
      'position'		=>	'before',
      'limit'			=>	-1,
      'link'			=>	null,
      'hide'			=>	array(),
      'layout'			=>	'grid',
      'columns'			=>	'one',
      'align'			=>	'center',
      'social_view'		=>	'colored',
      'border'			=>	null
   ), $atts));

	$unique = uniqid();
	$num = array('','one','two','three','four','five','six','seven','eight','nine','ten','eleven','twelve');
	$terms = '';
	if(!empty($hide)){
		$hide = explode(',', $hide);
	}

	//prepare wp-query args
	$args = array(
				'post_type' => 'team',
				'post_status'	=>	'publish',
			);

	//set category
	if(!empty($category)){
		$args['tax_query'] = array(
								array(
									'taxonomy' => 'team-category',
									'field' => 'slug',
									'terms' => $category
								) 
							);
	}

	//post_in
	if(!empty($ids)){
		$ids = explode(',', $ids);
		$args['post__in'] = $ids;
	}

	//display limit
	$args['posts_per_page'] = $limit;
	

	//orderby
	if(!empty($orderby)){
		$args['orderby'] = $orderby;
	}
	//order
	if(!empty($order)){
		$args['order'] = $order;
	}

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args['paged'] = $paged;
	$query = new WP_Query( $args );

	$return_string = '<div id="wpmtp-wrapper" class="wpmtp-'. $align . '">'; 
	if($layout == "carousel"){
		$return_string .= '<div class="wpmtp-pager wpmtp-pager-'. $unique .'">
        <a id="wpmtp_prev" href="#"><i class="icon-angle-left"></i></a>
        <a id="wpmtp_next" href="#"><i class="icon-angle-right"></i></a>
      </div>
      <div class="wpmtp-clearfix"></div>';
	}
	if($layout == "filterable"){
		
		$return_string .= '<div class="wpmtp-filter">
        <ul id="wpmtp-source-'. $unique  .'"><li><a href="#" class="wpmtp-all">All</a></li>';
     	
     	$tax = get_terms("team-category");
     	foreach ($tax as $tax_term) {
     		$return_string .= '<li><a href="#" class="filter-' . $tax_term->slug . '">'. $tax_term->name .'</a></li>';
     	}

        $return_string .= '</ul>
      </div>
      <div class="wpmtp-clearfix"></div>';
	}
	$return_string .= '<ul class="wpmtp-'. $layout .' wpmtp-'. $columns .'-columns wpmtp-icon-show-'. $position .'" id="wpmtp-'. $unique .'">';

	//check if there are members
	if($query->have_posts()){
		//available fields
		$fields = WPMTPv2_OPTIONS()->fields;

		//start loop
		while ($query->have_posts()) { $query->the_post(); 
			$saved_meta = WPMTPv2_FIELDS(get_the_ID());	
			//social icons
			$socials = '';
			//show socials

			if($layout == "filterable"){
				$term_list = get_the_terms(get_the_ID(), 'team-category');
				if ( !empty( $term_list ) ) {
					$terms = array();
		            foreach ( $term_list as $term )
		                $terms[] = 'filter-' . $term->slug;
		            $terms = implode(' ', $terms);
		        }
			}

			if(!in_array('social', $hide)){
				$social_media = WPMTPv2_OPTIONS()->socials;
				$saved_socials = WPMTPv2_SOCIALS(get_the_ID());
				$socials .= '<ul class="wpmtp-social wpmtp-shape-'. WPMTPv2_OPTIONS()->shape .' wpmtp-social-'. $social_view .'">';
				foreach($social_media as $sm){
					if(!empty($saved_socials[$sm['key']])){
						if(isset($sm['visibility'])){
							if($sm['key'] == "envelope"){
								$socials .= '<li><a class="wpmtp-'. $sm['key'] .'" href="mailto:'. $saved_socials[$sm['key']] .'" data-toggle="tooltip" title="'. $sm['label'] .'">';
							}else{
								$socials .= '<li><a class="wpmtp-'. $sm['key'] .'" href="'. $saved_socials[$sm['key']] .'" target="_blank" data-toggle="tooltip" title="'. $sm['label'] .'">';
							}
							
							if($social_view != "text"){
								$socials .= ($sm['disable'] == 1) ? '<i class="icon-'. $sm['key'] .'"></i>' : '<span>' . $saved_socials[$sm['key']] . '</span>';
							}else{
								$socials .= ($sm['disable'] == 1) ? $sm['label'] : '<span>' . $saved_socials[$sm['key']] . '</span>';
							}
							
							$socials .= '</a></li>';
						}
					}
				}
				$socials .= '</ul>';
			}

			$return_string .= '<li class="wpmtp-column '. $terms .'" data-id="' . get_the_ID() . '" data-type="'. $terms .'">';

			//show photo/image
			if(!in_array('image', $hide)){
				$return_string .= '<!--Show the Photo --><div class="wpmtp-post-image">';
				if(empty($link)){
					$return_string .= '<a href="'. get_permalink(get_the_ID()) .'">';
				}

				$return_string .= wpmtpv2_thumbnail(get_the_ID());

				if(empty($link)){
					$return_string .= '</a>';
				}
				if($position == "image"){
					$return_string .= '<div class="wpmtp-social-hover">';
					$return_string .= $socials;
					$return_string .= '</div>';
				}
				$return_string .= '</div>';
			}
			$return_string .= '<div class="wpmtp-post-body">';
			//show title
			if(!in_array('title', $hide)){
				$return_string .= '<h3 class="wpmtp-post-title">';
				if(empty($link)){
					$return_string .= '<a href="'. get_permalink(get_the_ID()) .'">';
				}

				$return_string .= get_the_title();

				if(empty($link)){
					$return_string .= '</a>';
				}
				$return_string .= '</h3>';
			}

			
			foreach($fields as $field) {
				if(isset($field['frontend']) && $field['frontend'] == 1):
					if( !empty($saved_meta[$field['key']]) ){
						switch ($field['key']) {
							case 'job_title':
								//show job title
								if(!in_array('job_title', $hide)){
									$return_string .= '<h5 class="wpmtp-position">'. $saved_meta['job_title'] .'</h5>';
								}
								break;

							case 'email':
								$return_string .= '<span class="wpmtp-meta wpmtp-meta-'. $field['key'] .'">';
								if(!in_array('field_label', $hide)){
									$return_string .= '<label>'. $field['label'] .'</label>: ';
								}
								$return_string .= '<a href="mailto:'. $saved_meta[$field['key']] .'">'.  $saved_meta[$field['key']] .'</a></span>';
								break;

							case 'website':
								$return_string .= '<span class="wpmtp-meta wpmtp-meta-'. $field['key'] .'">';
								if(!in_array('field_label', $hide)){
									$return_string .= '<label>'. $field['label'] .'</label>: ';
								}
								$return_string .= '<a href="'. $saved_meta[$field['key']] .'" target="_blank">'.  $saved_meta[$field['key']] .'</a></span>';
								break;
							
							default:
								$return_string .= '<span class="wpmtp-meta wpmtp-meta-'. $field['key'] .'">';
								if(!in_array('field_label', $hide)){
									$return_string .= '<label>'. $field['label'] .'</label>: ';
								}
								$return_string .= $saved_meta[$field['key']] .'</span>';
								break;
						}
					}
				endif;
			}

			if($position == 'before')
				$return_string .= $socials;
			//show excerpt
			if(!in_array('excerpt', $hide)){
				$return_string .= '<div class="wpmtp-copy">'. get_the_excerpt() .'</div>';
			}
			if($position == 'after')
				$return_string .= $socials;

			//show more link
			if(!in_array('more', $hide)){
				if($layout == "carousel"){
					$return_string .= '<p><a href="'. get_permalink(get_the_ID()) .'" class="wpmtp-more">'. WPMTPv2_OPTIONS()->more_text .'</a></p>';
				}else{
					$return_string .= '<a href="'. get_permalink(get_the_ID()) .'" class="wpmtp-more">'. WPMTPv2_OPTIONS()->more_text .'</a>';
				}
			}

			$return_string .= '</div></li>';
		}
	}
	$return_string .= '</ul></div>';
	if((!empty($limit) || $limit > 0) && $layout == "grid"){
		$big = 999999999; // need an unlikely integer
		$return_string .='<div style="clear:both;"></div>';
		$return_string .= paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $query->max_num_pages
		) );
	}
	

	switch ($layout) {
		case 'carousel':
			$return_string .= '<script type="text/javascript">
    jQuery(window).load(function(){
      jQuery("#wpmtp-'. $unique .'").carouFredSel({
        responsive  : true,
        width   : "100%",
        auto    : false,
        scroll : {
                items : 1,
                duration        : 1000,
                timeoutDuration : 1500
        },
        items: {
                visible: {
                    min: 1,
                    max: '. array_search($columns, $num) .'
                }
              },
        prev    : ".wpmtp-pager-'. $unique .' #wpmtp_prev",
        next    : ".wpmtp-pager-'. $unique .' #wpmtp_next"
      });
    });
  </script>';
			break;

		case 'filterable':
			$return_string .= '<script type="text/javascript">
	jQuery.noConflict();
    jQuery(document).ready(function($){
    $("#wpmtp-source-'. $unique  .' li a").click(function() {
      $(this).css("outline","none");
      $("#wpmtp-source-'. $unique  .' li.current").removeClass("current");
      $(this).parent().addClass("current");
      
      var filterVal = $(this).attr("class");
          
      if(filterVal == "wpmtp-all") {
        $("ul#wpmtp-'. $unique .' li.hidden").fadeIn("slow").removeClass("hidden");
      } else {
        $("ul#wpmtp-'. $unique .' li.wpmtp-column").each(function() {
          if(!$(this).hasClass(filterVal)) {
            $(this).hide("normal").addClass("hidden");
          } else {
            $(this).show("slow").removeClass("hidden");
          }
        });
      }
      
      return false;
    });
  });
  </script>';
			break;
		
		default:
			# code...
			break;
	}

	return $return_string;
}
?>