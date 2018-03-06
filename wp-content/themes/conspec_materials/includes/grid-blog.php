<?php global $the_grid_t_ID;?>
<?php $video = lpd_parse_video(get_post_meta($post->ID, 'video_post_meta', true));?>
<?php $video_thumb = lpd_parse_video_thumb(get_post_meta($post->ID, 'video_post_meta', true));?>
<?php $link = get_post_meta($post->ID, 'link_post_meta', true); ?>
<?php $post_header_image_thumbnail = wp_get_attachment_image_src( get_post_meta($post->ID, 'post_header_image', true), 'large' );?>
<?php $box_caption_meta = get_post_meta($the_grid_t_ID, 'grid_options_box_caption_meta', true);?>
<?php $box_caption = get_post_meta($the_grid_t_ID, 'grid_options_box_caption', true);?>
<?php $box_caption_excerpt = get_post_meta($the_grid_t_ID, 'grid_options_box_caption_excerpt', true);?>

        <?php if(!$box_caption||($box_caption&&has_post_thumbnail())||($box_caption&&$video_thumb)||($box_caption&&$post_header_image_thumbnail)){?><div class="<?php $allClasses = get_post_class(); foreach ($allClasses as $class) { echo $class . " "; } ?>box" data-category="<?php $category = get_the_category(); echo $category[0]->cat_name; ?>"><?php }?> 
            
	<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {?>
	
            <div class="box-image">
            
            	<div class="box-image-mask"></div>
            
                <div data-thumbnail="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); echo $image[0];?>" ></div>
                
                <div data-image="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); echo $image[0];?>" ></div>
                
                <div class="thumbnail-caption">
                      <div class="hover-lightbox open-lightbox"></div>
                      <a href="<?php if ($link){echo $link;}else{the_permalink();}?>"><div class="hover-url"></div></a>
                </div>

                <div class="lightbox-text">
                        <?php the_title();?> <span><?php _e('In', GETTEXT_DOMAIN);?> <?php $category = get_the_category(); echo $category[0]->cat_name; ?></span>
                </div>
            </div>
	
	<?php } elseif($post_header_image_thumbnail){?>
	
            <div class="box-image">
            
            	<div class="box-image-mask"></div>
            
                <div data-thumbnail="<?php echo $post_header_image_thumbnail[0];?>" ></div>
                
                <div data-image="<?php echo $post_header_image_thumbnail[0];?>" ></div>
                
                <div class="thumbnail-caption">
                      <div class="hover-lightbox open-lightbox"></div>
                      <a href="<?php if ($link){echo $link;}else{the_permalink();}?>"><div class="hover-url"></div></a>
                </div>

                <div class="lightbox-text">
                        <?php the_title();?> <span><?php _e('In', GETTEXT_DOMAIN);?> <?php $category = get_the_category(); echo $category[0]->cat_name; ?></span>
                </div>
            </div>
	
	<?php } elseif ( $video ) {?>
	
		<?php if($video_thumb){?>
		
			<div class="box-image open-lightbox-iframe box-video">
				<div data-thumbnail="<?php echo $video_thumb ?>" ></div>
				
				<div class="lightbox-iframe" width="100%" height="100%" src="<?php echo $video ?>?HD=1;autoplay=1;rel=0;showinfo=0" frameborder="0" allowfullscreen></div>
				
	            <div class="lightbox-text">
	                    <?php the_title();?> <span><?php _e('In', GETTEXT_DOMAIN);?> <?php $category = get_the_category(); echo $category[0]->cat_name; ?></span>
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
                    <div class="time">
                        <?php the_time('M j, Y'); ?>
                    </div>
                    <div class="mb_social">
                        <a href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]=<?php the_permalink();?>&p[images][0]=<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' ); echo $image[0];?>&p[title]=<?php the_title();?>&p[summary]=<?php echo lpd_excerpt(25)?>" class="fb-icon"></a>
                        <a href="http://twitter.com/home?status=<?php echo lpd_excerpt_more(10)?>, <?php the_permalink();?>" class="tw-icon"></a>
                        <a href="https://plus.google.com/share?url=<?php the_permalink();?>" class="gp-icon"></a>
                        <a href="http://pinterest.com/pin/create/button/?url=http://dev.lpd-themes.com/&media=<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' ); echo $image[0];?>&description=<?php echo lpd_excerpt(25)?>" class="pi-icon"></a>
                    </div>
                </div> 
                <?php }?>   
            </div>
            <?php }?> 
        <?php if(!$box_caption||($box_caption&&has_post_thumbnail())||($box_caption&&$video_thumb)||($box_caption&&$post_header_image_thumbnail)){?></div><?php }?>