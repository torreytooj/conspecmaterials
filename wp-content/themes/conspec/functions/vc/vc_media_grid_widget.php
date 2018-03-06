<?php

function vc_media_grid_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      	'post_type' => '',
      	'thumbnail_style' => '',
	  	'items' => '',
	  	'category_filter' => '',
	  	'box_caption_meta' => '',
      	'box_caption' => '',
      	'box_caption_excerpt' => '',
      'showfilterbar' => '',
      'imagestoload' => '',
      'imagestoloadstart' => '',
      'isfitwidth' => '',
      'columns' => '',
      'columnminwidth' => '',
      'isanimated' => '',
      'lightboxplayinterval' => '',
      'loadmoreword' => '',
      	'order' => '',
      	'orderby' => ''
   ), $atts ) );
   
   global $shortcode_atts;
   
   $shortcode_atts = array(
      'showfilterbar' => $showfilterbar,
      'imagestoload' => $imagestoload,
      'imagestoloadstart' => $imagestoloadstart,
      'isfitwidth' => $isfitwidth,
      'columns' => $columns,
      'columnminwidth' => $columnminwidth,
      'isanimated' => $isanimated,
      'lightboxplayinterval' => $lightboxplayinterval,
      'loadmoreword' => $loadmoreword,
   );
   
   
   if($post_type=="portfolio"){
	   $post_type="portfolio";
	   $cat_terms="portfolio_category";
   } elseif($post_type=="product"){
	   $post_type="product";
	   $cat_terms="product_cat";
   } else{
	   $post_type="post";
	   $cat_terms="category";
   }
   
   if($items){
	   $posts_per_page='&posts_per_page='.$items.'';
   }else{
	   $posts_per_page='&posts_per_page=-1';
   }
   
	if($post_type=="portfolio"){
		$category_filter = '&portfolio_category='.$category_filter;
	} elseif($post_type=="product"){
		$category_filter = '&product_cat='.$category_filter;
	}else{
		$category_filter = '&category_name='.$category_filter;
	}
	
	if($thumbnail_style=="portrait"){
		$thumbnail_style="front-shop-thumb";
	} elseif($thumbnail_style=="square"){
		$thumbnail_style="front-shop-thumb2";
	} else{
		$thumbnail_style="large";
	}
	
	global $the_grid_t_ID;
	$the_grid_t_ID = get_the_ID();	
   
	ob_start();?>
	
							<div id="grid-<?php echo $the_grid_t_ID ?>">
	
	
						<?php $query = new WP_Query();?>
						<?php $query->query('post_type='.$post_type.''.$posts_per_page.''.$category_filter.'&orderby='.$orderby.'&order='.$order.'');?>
							
                        <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); global $product;?>
	
<?php $video = lpd_parse_video(get_post_meta(get_the_ID(), 'video_post_meta', true));?>
<?php $video_thumb = lpd_parse_video_thumb(get_post_meta(get_the_ID(), 'video_post_meta', true));?>
<?php $link = get_post_meta(get_the_ID(), 'link_post_meta', true); ?>

<?php if($post_type=="portfolio"){ ?>
	<?php $post_header_image_thumbnail = wp_get_attachment_image_src( get_post_meta(get_the_ID(), 'portfolio_header_image', true), $thumbnail_style );?>
	<?php $post_header_image = wp_get_attachment_image_src( get_post_meta(get_the_ID(), 'portfolio_header_image', true), 'large' );?>
	<?php $terms = get_the_terms( get_the_ID(), 'portfolio_category' ); ?>
	<?php $term = array_pop($terms); ?>
	<?php $data_category = $term->name; ?>
<?php } elseif($post_type=="product"){ ?>
	<?php $post_header_image_thumbnail = wp_get_attachment_image_src( get_post_meta(get_the_ID(), 'product_header_image', true), $thumbnail_style );?>
	<?php $post_header_image = wp_get_attachment_image_src( get_post_meta(get_the_ID(), 'product_header_image', true), 'large' );?>
	<?php $terms = get_the_terms( get_the_ID(), 'product_cat' ); ?>
	<?php $term = array_pop($terms); ?>
	<?php $data_category = $term->name; ?>
<?php } else{?>
	<?php $post_header_image_thumbnail = wp_get_attachment_image_src( get_post_meta(get_the_ID(), 'post_header_image', true), $thumbnail_style );?>
	<?php $post_header_image = wp_get_attachment_image_src( get_post_meta(get_the_ID(), 'post_header_image', true), 'large' );?>
	<?php $category = get_the_category();
	$data_category = $category[0]->cat_name; ?>
<?php } ?>

<?php if(!$box_caption||($box_caption&&has_post_thumbnail())||($box_caption&&$video_thumb)||($box_caption&&$post_header_image_thumbnail)){?><div class="<?php $allClasses = get_post_class(); foreach ($allClasses as $class) { echo $class . " "; } ?>box" data-category="<?php echo $data_category; ?>"><?php }?> 
            
	<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {?>
	
            <div class="box-image">
            
                <div class="box-image-mask"></div>
                
                <?php if($post_type=="product"){ ?>
	                <?php if ($product->is_on_sale()) : ?>
	                	<?php echo apply_filters('woocommerce_sale_flash', '<span class="lpd-onsale">'.__('Sale!', GETTEXT_DOMAIN).'</span>', $product); ?>
	                <?php endif; ?>
                <?php } ?>
            
                <div data-thumbnail="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $thumbnail_style ); echo $image[0];?>" ></div>
                
                <div data-image="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' ); echo $image[0];?>" ></div>
                
                <div class="thumbnail-caption">
                      <div class="hover-lightbox open-lightbox"></div>
                      <a href="<?php if ($link){echo $link;}else{the_permalink();}?>"><div class="hover-url"></div></a>
                </div>

                <div class="lightbox-text">
                        <?php the_title();?> <span><?php _e('In', GETTEXT_DOMAIN);?> <?php echo $data_category; ?></span>
                </div>
            </div>
	
	<?php } elseif($post_header_image_thumbnail){?>
	
            <div class="box-image">
            
            	<div class="box-image-mask"></div>
            
                <?php if($post_type=="product"){ ?>
	                <?php if ($product->is_on_sale()) : ?>
	                	<?php echo apply_filters('woocommerce_sale_flash', '<span class="lpd-onsale">'.__('Sale!', GETTEXT_DOMAIN).'</span>', $product); ?>
	                <?php endif; ?>
                <?php } ?>
            
                <div data-thumbnail="<?php echo $post_header_image_thumbnail[0];?>" ></div>
                
                <div data-image="<?php echo $post_header_image[0];?>" ></div>
                
                <div class="thumbnail-caption">
                      <div class="hover-lightbox open-lightbox"></div>
                      <a href="<?php if ($link){echo $link;}else{the_permalink();}?>"><div class="hover-url"></div></a>
                </div>

                <div class="lightbox-text">
                        <?php the_title();?> <span><?php _e('In', GETTEXT_DOMAIN);?> <?php echo $data_category; ?></span>
                </div>
            </div>
	
	<?php } elseif ( $video ) {?>
	
		<?php if($video_thumb){?>
		
			<div class="box-image open-lightbox-iframe box-video">
				<div data-thumbnail="<?php echo $video_thumb ?>" ></div>
				
				<div class="lightbox-iframe" width="100%" height="100%" src="<?php echo $video ?>?HD=1;autoplay=1;rel=0;showinfo=0" frameborder="0" allowfullscreen></div>
				
	            <div class="lightbox-text">
	                    <?php the_title();?> <span><?php _e('In', GETTEXT_DOMAIN);?> <?php echo $data_category; ?></span>
	            </div>
			</div>
			
		<?php }?>
		
	<?php }?>
            
    <?php if(!$box_caption){?>
    <div class="box-caption <?php if(!has_post_thumbnail()&&!$post_header_image_thumbnail&&!$video){?>no-caret<?php }?>">
            
                <a class="box-title" href="<?php if ($link){echo $link;}else{the_permalink();}?>"><?php the_title();?></a>
                
                <p><?php if($box_caption_excerpt){?><?php echo lpd_excerpt($box_caption_excerpt)?><?php } else{?><?php echo lpd_excerpt(25)?><?php }?></p>
                
                <?php if(!$box_caption_meta){?>
                <div class="box-caption-bottom">
                    
                    <?php if($post_type=="portfolio"){ ?><div class="time"><?php echo $term->name; ?></div><?php } elseif($post_type=="product"){ ?><?php if ($product->get_price_html()) : ?><div class="price"><?php echo $product->get_price_html();?></div><?php endif; ?><?php } else{?><div class="time"><?php the_time('M j, Y'); ?></div><?php } ?>
                    
                    <div class="mb_social">
                        <a href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]=<?php the_permalink();?>&p[images][0]=<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' ); echo $image[0];?>&p[title]=<?php the_title();?>&p[summary]=<?php echo lpd_excerpt(25)?>" class="fb-icon"></a>
                        <a href="http://twitter.com/home?status=<?php echo lpd_excerpt_more(10)?>, <?php the_permalink();?>" class="tw-icon"></a>
                        <a href="https://plus.google.com/share?url=<?php the_permalink();?>" class="gp-icon"></a>
                        <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink();?>&media=<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' ); echo $image[0];?>&description=<?php echo lpd_excerpt(25)?>" class="pi-icon"></a>                    </div>
                </div> 
                <?php }?>   
            </div>
    <?php }?>
            
<?php if(!$box_caption||($box_caption&&has_post_thumbnail())||($box_caption&&$video_thumb)||($box_caption&&$post_header_image_thumbnail)){?></div><?php }?>
	

						<?php endwhile; endif; wp_reset_query();?>
	
							</div>
						
						
<?php function lpd_install_mediaboxes() {
	
	global $the_grid_t_ID;
	
	global $shortcode_atts;
	
	$showFilterBar = $shortcode_atts['showfilterbar'];
	$imagesToLoad = $shortcode_atts['imagestoload'];
	$imagesToLoadStart = $shortcode_atts['imagestoloadstart'];
	$isFitWidth = $shortcode_atts['isfitwidth'];
	$columns = $shortcode_atts['columns'];
	$columnMinWidth = $shortcode_atts['columnminwidth'];
	$isAnimated = $shortcode_atts['isanimated'];
	$lightBoxPlayInterval = $shortcode_atts['lightboxplayinterval'];
	$loadMoreWord = $shortcode_atts['loadmoreword'];

?>

<script>
  
    jQuery('document').ready(function(){
        
        //INITIALIZE THE PLUGIN
        jQuery('#grid-<?php echo $the_grid_t_ID ?>').grid({
                showFilterBar: <?php if($showFilterBar) {?>true<?php } else{?>false<?php }?>, //Show the navigation filter bar at the top
                imagesToLoad: <?php if($imagesToLoad) {?><?php echo $imagesToLoad;?><?php } else{?>5<?php }?>, //The number of images to load when you click the load more button
                imagesToLoadStart: <?php if($imagesToLoadStart) {?><?php echo $imagesToLoadStart;?><?php } else{?>10<?php }?>, //The number of images to load when it first loads the grid
                lazyLoad: true, //If you wish to load more images when it reach the bottom of the page
                isFitWidth: <?php if($isFitWidth) {?>true<?php } else{?>false<?php }?>, //Nedded to be true if you wish to center the gallery to its container
                horizontalSpaceBetweenThumbnails: 15, //The space between images horizontally
                verticalSpaceBetweenThumbnails: 15, //The space between images vertically
                columnWidth: 'auto', //The width of each columns, if you set it to 'auto' it will use the columns instead
                columns: <?php if($columns) {?><?php echo $columns;?><?php } else{?>4<?php }?>, //The number of columns when you set columnWidth to 'auto'
                columnMinWidth: <?php if($columnMinWidth) {?><?php echo $columnMinWidth;?><?php } else{?>220<?php }?>, //The minimum width of each columns when you set columnWidth to 'auto'
                isAnimated: <?php if($isAnimated) {?>true<?php } else{?>false<?php }?>, //If you wish the gallery to have animated effects when resizing the grid
                caption: true, //Show the caption in mouse over
                captionType: 'grid', // 'grid', 'grid-fade', 'classic' the type of caption effect
                hoverImageIconsAnimation: true, // The animation of the Icons of the image
                hoverImageIconsSpeedAnimation: 100, // The speed of the animation of the Icons of the image
                lightBox: true, //Do you want the lightbox?
                lightboxKeyboardNav: true, //Keyboard navigation of the next and prev image
                lightBoxSpeedFx: 500, //The speed of the lightbox effects
                lightBoxZoomAnim: true, //Do you want the zoom effect of the images in the lightbox?
                lightBoxText: true, //If you wish to show the text in the lightbox
                lightboxPlayBtn: true, //Show the play button?
                lightBoxAutoPlay: false, //The first time you open the lightbox it start playing the images
                lightBoxPlayInterval: <?php if($lightBoxPlayInterval) {?><?php echo $lightBoxPlayInterval;?><?php } else{?>4000<?php }?>, //The interval in the auto play mode 
                lightBoxShowTimer: true, //If you wish to show the timer in auto play mode
                lightBoxStopPlayOnClose: false, //Do you want pause the auto play mode when you close the lightbox?
                allWord: "<?php _e('All', GETTEXT_DOMAIN) ?>", //The "All" word so you can translate it to another lenguaje
                loadMoreWord: <?php if($loadMoreWord) {?>"<?php echo $loadMoreWord;?>"<?php } else{?>"<?php _e('LOAD MORE ENTRIES', GETTEXT_DOMAIN) ?>"<?php }?>, //The "Load More Entries" word so you can translate it to another lenguaje
        });

    });    
       
</script>

<?php }?>

<?php add_action( 'wp_footer', 'lpd_install_mediaboxes', 100);?>
						
						
	<?php return ob_get_clean();
    
    
}
add_shortcode( 'vc_media_grid', 'vc_media_grid_func' );


vc_map(array(
   "name" => __("Media Grid", GETTEXT_DOMAIN),
   "base" => "vc_media_grid",
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
			"value" => array(__('Blog Posts', GETTEXT_DOMAIN) => "post", __('Portfolio Posts', GETTEXT_DOMAIN) => "portfolio", __('Product Posts', GETTEXT_DOMAIN) => "product"),
			"description" => __("Select post type.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Thumbnail Style", GETTEXT_DOMAIN),
			"param_name" => "thumbnail_style",
			"value" => array(__('Default', GETTEXT_DOMAIN) => "default", __('Portrait', GETTEXT_DOMAIN) => "portrait", __('Square', GETTEXT_DOMAIN) => "square"),
			"description" => __("Select post type.", GETTEXT_DOMAIN)
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
			 "param_name" => "category_filter",
			 "value" => "",
			 "description" => __("Category slug separated by comma, an example: link,full.", GETTEXT_DOMAIN)
		),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Caption Meta", GETTEXT_DOMAIN),
	      "param_name" => "box_caption_meta",
	      "description" => __("Check to hide caption meta.", GETTEXT_DOMAIN),
	      "value" => Array(__("disable", GETTEXT_DOMAIN) => 'disable')
	    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Caption", GETTEXT_DOMAIN),
	      "param_name" => "box_caption",
	      "description" => __("Check to hide caption.", GETTEXT_DOMAIN),
	      "value" => Array(__("disable", GETTEXT_DOMAIN) => 'disable')
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Caption Excerpt", GETTEXT_DOMAIN),
			 "param_name" => "box_caption_excerpt",
			 "value" => "",
			 "description" => __("The number of words in caption.", GETTEXT_DOMAIN)
		),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Navigation Filter", GETTEXT_DOMAIN),
	      "param_name" => "showfilterbar",
	      "description" => __("Show the navigation filter bar at the top.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable')
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Loading Images", GETTEXT_DOMAIN),
			 "param_name" => "imagestoload",
			 "value" => "",
			 "description" => __("The number of images to load when you click the load more button.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Images", GETTEXT_DOMAIN),
			 "param_name" => "imagestoloadstart",
			 "value" => "",
			 "description" => __("The number of images to load when it first loads the grid.", GETTEXT_DOMAIN)
		),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Align", GETTEXT_DOMAIN),
	      "param_name" => "isfitwidth",
	      "description" => __("If you wish to center the gallery.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable')
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Columns", GETTEXT_DOMAIN),
			 "param_name" => "columns",
			 "value" => "",
			 "description" => __("The number of columns.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Columns Minimal Width", GETTEXT_DOMAIN),
			 "param_name" => "columnminwidth",
			 "value" => "",
			 "description" => __("The minimum width of each columns in pixels.", GETTEXT_DOMAIN)
		),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Animation", GETTEXT_DOMAIN),
	      "param_name" => "isanimated",
	      "description" => __("If you wish the gallery to have animated effects when resizing the grid.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable')
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Lightbox Play Interval", GETTEXT_DOMAIN),
			 "param_name" => "lightboxplayinterval",
			 "value" => "",
			 "description" => __("The interval in the auto play mode in milliseconds (eg 1000).", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Text Button", GETTEXT_DOMAIN),
			 "param_name" => "loadmoreword",
			 "value" => "",
			 "description" => __("The 'Load More Entries' word so you can translate it to another language.", GETTEXT_DOMAIN)
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