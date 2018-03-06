<?php

function vc_widget_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'post_type' => '',
      'columns' => '',	
      'items' => '',
      'cat_filter' => '',
      'order' => '',
      'orderby' => ''
   ), $atts ) );
   
   
   if($post_type=="post"){
	   $post_type="post";
	   $cat_terms="category";
   }else{
	   $post_type="portfolio";
	   $cat_terms="portfolio_category";
   }
   
   if($items){
	   $posts_per_page='&posts_per_page='.$items.'';
   }else{
	   $posts_per_page='&posts_per_page=-1';
   }
   
	if($post_type=="portfolio"){
		$category_filter = '&portfolio_category='.$cat_filter;
	}else{
		$category_filter = '&category_name='.$cat_filter;
	}	
   
	ob_start();?>
	
							<div class="post-widget">
							<div class="row">
	
	
						<?php $query = new WP_Query();?>
						<?php $query->query('post_type='.$post_type.''.$posts_per_page.''.$category_filter.'&orderby='.$orderby.'&order='.$order.'');?>
							
                        <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>
                        
						<?php $video = lpd_parse_video(get_post_meta(get_the_ID(), 'video_post_meta', true));?>
						<?php $link = get_post_meta(get_the_ID(), 'link_post_meta', true);?>
						
						<?php $gallery_type = get_post_meta(get_the_ID(), 'portfolio_options_select', true);?>
						<?php $terms = get_the_terms( get_the_ID(), $cat_terms ); ?>
						<?php $portfolio_header_image = get_post_meta(get_the_ID(), 'portfolio_header_image', true); ?>
						<?php $portfolio_header_image_thumbnail = wp_get_attachment_image_src( $portfolio_header_image, 'default-sidebar-page' );?>
						<?php $post_header_image = get_post_meta(get_the_ID(), 'post_header_image', true); ?>
						<?php $post_header_image_thumbnail = wp_get_attachment_image_src( $post_header_image, 'default-sidebar-page' );?>
						  
	<div class="col-lg-<?php echo $columns ?> col-md-<?php echo $columns ?>">
		<div class="lpd-portfolio-item">
		<?php if ( $link ) { ?>
	        <?php if(has_post_thumbnail()) {?>
				<a href="<?php echo $link; ?>" class="effect-thumb">
					<img alt="<?php the_title(); ?>" class="img-responsive" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'default-sidebar-page' ); echo $image[0];?>"/>
					<div class="mega-icon link"></div>
				</a>
			<?php }elseif ($portfolio_header_image) { ?>
				<a href="<?php echo $link; ?>" class="effect-thumb">
					<?php if ($portfolio_header_image) { ?><img alt="<?php the_title(); ?>" class="img-responsive" src="<?php echo $portfolio_header_image_thumbnail[0];?>"/><?php } ?>
					<div class="mega-icon link"></div>
				</a>
			<?php }elseif ($post_header_image) { ?>
				<a href="<?php echo $link; ?>" class="effect-thumb">
					<?php if ($post_header_image) { ?><img alt="<?php the_title(); ?>" class="img-responsive" src="<?php echo $post_header_image_thumbnail[0];?>"/><?php } ?>
					<div class="mega-icon link"></div>
				</a>
	        <?php }else{?>
		        <a href="<?php echo $link; ?>" class="effect-thumb">
		        	<img class="img-responsive" alt="<?php the_title(); ?>" src="<?php echo THEME_ASSETS; ?>img/link-post-type1.png"/>
					<div class="mega-icon link"></div>
				</a>
	        <?php }?>
	    <?php } elseif ( $video ) { ?>
	        <?php if(has_post_thumbnail()) {?>
				<a href="<?php the_permalink(); ?>" class="effect-thumb">
					<img alt="<?php the_title(); ?>" class="img-responsive" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'default-sidebar-page' ); echo $image[0];?>"/>
					<div class="mega-icon reel"></div>
				</a>
			<?php }elseif ($portfolio_header_image) { ?>
				<a href="<?php the_permalink(); ?>" class="effect-thumb">
					<?php if ($portfolio_header_image) { ?><img alt="<?php the_title(); ?>" class="img-responsive" src="<?php echo $portfolio_header_image_thumbnail[0];?>"/><?php } ?>
					<div class="mega-icon reel"></div>
				</a>
			<?php }elseif ($post_header_image) { ?>
				<a href="<?php the_permalink(); ?>" class="effect-thumb">
					<?php if ($post_header_image) { ?><img alt="<?php the_title(); ?>" class="img-responsive" src="<?php echo $post_header_image_thumbnail[0];?>"/><?php } ?>
					<div class="mega-icon reel"></div>
				</a>
	        <?php }else{?>
		        <a href="<?php the_permalink(); ?>" class="effect-thumb">
		        	<img class="img-responsive" alt="<?php the_title(); ?>" src="<?php echo THEME_ASSETS; ?>img/video-post-type1.png"/>
					<div class="mega-icon reel"></div>
				</a>
	        <?php }?>
	    <?php } elseif ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>
			<a href="<?php the_permalink(); ?>" class="effect-thumb">
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<img alt="<?php the_title(); ?>" class="img-responsive" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'default-sidebar-page' ); echo $image[0];?>"/>
				<?php } ?>
				<div class="mega-icon eye"></div>
			</a>
		<?php } elseif ($portfolio_header_image) { ?>
			<a href="<?php the_permalink(); ?>" class="effect-thumb">
		<?php if ($portfolio_header_image) { ?>
			<img alt="<?php the_title(); ?>" class="img-responsive" src="<?php echo $portfolio_header_image_thumbnail[0];?>"/>
		<?php } ?>
				<div class="mega-icon eye"></div>
			</a>
		<?php } elseif ($post_header_image) { ?>
			<a href="<?php the_permalink(); ?>" class="effect-thumb">
		<?php if ($post_header_image) { ?>
			<img alt="<?php the_title(); ?>" class="img-responsive" src="<?php echo $post_header_image_thumbnail[0];?>"/>
		<?php } ?>
				<div class="mega-icon eye"></div>
			</a>
	    <?php }?>
			<div class="content">
				<?php if ( $link ) { ?>
				<h4 class="title"><a href="<?php echo $link; ?>"><?php the_title(); ?></a></h4>
				<?php }else{?>
				<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<?php }?>
				<div class="column">
			<div class="post_content">
				<p><?php echo lpd_excerpt(25)?> 
				<?php if ( $link ) { ?>
				<a class="more-link" href="<?php echo $link; ?>"><?php _e("[read more]", GETTEXT_DOMAIN)?></a></p>
				<?php }else{?>
				<a class="more-link" href="<?php the_permalink(); ?>"><?php _e("[read more]", GETTEXT_DOMAIN)?></a></p>
				<?php }?>
			</div>
		</div>
				<?php if($terms){?>
				<div class="portfolio-categories">
			<?php $resultstr = array(); ?>
            <?php if($terms) : foreach ($terms as $term) { ?>
                <?php $resultstr[] = '<a title="'.$term->name.'" href="'.get_term_link($term->slug, $cat_terms).'">'.$term->name.'</a>'?>
            <?php } ?>
            <?php echo implode(", ",$resultstr); endif;?>
		</div>
				<?php }?>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	
						<?php endwhile; endif; wp_reset_query();?>
	
							</div>
						</div>
						
	<?php return ob_get_clean();
    
    
}
add_shortcode( 'vc_widget', 'vc_widget_func' );


vc_map(array(
   "name" => __("Posts Widget", GETTEXT_DOMAIN),
   "base" => "vc_widget",
   "class" => "",
   "icon" => "icon-wpb-lpd",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(

		array(
			"type" => "dropdown",
			"heading" => __("Post Type", GETTEXT_DOMAIN),
			"param_name" => "post_type",
			"value" => array(__('Blog Posts', GETTEXT_DOMAIN) => "post", __('Portfolio Posts', GETTEXT_DOMAIN) => "portfolio"),
			"description" => __("Select post type.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Columns", GETTEXT_DOMAIN),
			"param_name" => "columns",
			"value" => array(__('4 Columns', GETTEXT_DOMAIN) => "3", __('3 Columns', GETTEXT_DOMAIN) => "4", __('2 Columns', GETTEXT_DOMAIN) => "6"),
			"description" => __("Select number of columns.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Posts", GETTEXT_DOMAIN),
			 "param_name" => "items",
			 "value" => "",
			 "description" => __("Enter number of post to show.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Filter", GETTEXT_DOMAIN),
			 "param_name" => "cat_filter",
			 "value" => "",
			 "description" => __("Category slug separated by comma, an example: link,full.", GETTEXT_DOMAIN)
		),
    array(
      "type" => "dropdown",
      "heading" => __("Order by", GETTEXT_DOMAIN),
      "param_name" => "orderby",
      "value" => array( __("Date", GETTEXT_DOMAIN) => "date", __("ID", GETTEXT_DOMAIN) => "ID", __("Author", GETTEXT_DOMAIN) => "author", __("Title", GETTEXT_DOMAIN) => "title", __("Modified", GETTEXT_DOMAIN) => "modified", __("Random", GETTEXT_DOMAIN) => "rand", __("Comment count", GETTEXT_DOMAIN) => "comment_count", __("Menu order", GETTEXT_DOMAIN) => "menu_order" ),
      "description" => sprintf(__('Select how to sort retrieved posts. More at %s.', GETTEXT_DOMAIN), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Order way", GETTEXT_DOMAIN),
      "param_name" => "order",
      "value" => array( __("Descending", GETTEXT_DOMAIN) => "DESC", __("Ascending", GETTEXT_DOMAIN) => "ASC" ),
      "description" => sprintf(__('Designates the ascending or descending order. More at %s.', GETTEXT_DOMAIN), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
    )
   )
));


?>