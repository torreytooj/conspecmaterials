<?php $the_grid_p_ID = get_the_ID(); ?>
<?php $st_buttons_p = ot_get_option('st_buttons_p'); ?>

<?php $video = lpd_parse_video(get_post_meta($post->ID, 'video_post_meta', true));?>
<?php $full_width = get_post_meta($post->ID, 'portfolio_options_full', true);?>
<?php $details = get_post_meta($post->ID, 'portfolio_options_repeatable', true); if($details){$details = array_filter($details);};?>
<?php $terms = get_the_terms($post->ID, 'portfolio_tags' ); ?>
<?php $share = get_post_meta($post->ID, 'portfolio_options_share', true);?>

<div id="post-<?php the_ID(); ?>" class="single-post <?php $allClasses = get_post_class(); foreach ($allClasses as $class) { echo $class . " "; } ?>">
	<?php if ($video) { ?>
	<iframe class="scale-with-grid-front page-thumbnail" width="850" height="478" src="<?php echo $video ?>?wmode=transparent;showinfo=0" frameborder="0" allowfullscreen></iframe>
	<?php } elseif ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {?>
	<?php $post_thumbnail_id = get_post_thumbnail_id(); ?> 
	<?php $alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);?>
	<?php if ($full_width){?>
	<img class="page-thumbnail img-responsive" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'default-page' ); echo $image[0];?>" />
	<?php }else{?>
	<img class="page-thumbnail img-responsive" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'default-sidebar-page' ); echo $image[0];?>" />
	<?php }?>
	<?php }?>
	
	<?php if ( $full_width ) {?>
	<div class="row">
		<?php if ( !empty($details) || $terms || !$share ){?>
		<div class="col-md-9">
		<?php }else{?>
		<div class="col-md-12">
		<?php }?>
			<div class="content">
				<div class="post_content">
					<?php the_content(); ?>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
        <?php if ( !empty($details) || $terms || !$share ){?>
		<div class="col-md-3 portfolio-full-width">
	        <div class="widget portfolio-info-widget">
	            <ul>
	                <?php if($details){ ?>
	                <?php $separator = "%%";
	                $output = '';
	                foreach ($details as $item) {
	                    if($item){
	                        list($item_text1, $item_text2) = explode($separator, trim($item));
	                        $output .= '<li><strong>' . $item_text1 . ':</strong> ' . do_shortcode($item_text2) . '</li>';
	                    }
	                }
	                echo $output;?>
	                <?php } ?>
	                <?php if($terms){?>
	                <li class="tags">
	                    <?php if($terms) : foreach ($terms as $term) { ?>
	                        <?php echo '<a title="'.$term->name.'" href="'.get_term_link($term->slug, 'portfolio_tags').'">'.$term->name.'</a>'?>
	                    <?php } endif;?>
	                    <div class="clearfix"></div>
	                </li>
	                <?php }?>
	                <?php if(!$share&&$st_buttons_p){?>
	                <li class="st-share-portfolio"><strong><?php _e( 'Share', GETTEXT_DOMAIN);?>:</strong>
	                	<?php echo $st_buttons_p;?>
	                </li>
	                <?php }?>
	            </ul>
	        </div>
		</div>
        <?php }?>
	</div>
	<?php } else {?>
	<div class="content">
		<div class="post_content">
			<?php the_content(); ?>
		</div>
	</div>
	<?php }?>

    <?php $args = array(
    'numberposts' => 9999, // change this to a specific number of images to grab
    'offset' => 0,
    'post_parent' => $post->ID,
    'post_type' => 'attachment',
    'nopaging' => false,
    'post_mime_type' => 'image',
    'order' => 'ASC', // change this to reverse the order
    'orderby' => 'menu_order ID', // select which type of sorting
    'post_status' => 'any'
    );
    $attachments = get_children($args);?>
                
    <?php if ($attachments) {?>
    <div class="divider20"></div>
    <div id="grid-<?php echo $the_grid_p_ID ?>">
    
		<?php foreach($attachments as $attachment) {
        $title = $attachment->post_title;
        $image = wp_get_attachment_image_src($attachment->ID, 'large', false);?> 
	        <div class="box" data-category="<?php the_title(); ?>">
	            <div class="box-image">
	                <div data-thumbnail="<?php echo $image[0] ?>" ></div>
	                <div data-image="<?php echo $image[0] ?>" ></div>
	                <div class="box-image-mask"></div>
	                <div class="thumbnail-caption">
	                      <div class="hover-lightbox open-lightbox"></div>
	                </div>
	
	                <div class="lightbox-text">
	                        <?php echo $title ?> <span><?php _e('In', GETTEXT_DOMAIN);?> <?php the_title(); ?></span>
	                </div>
	            </div>
	        </div>
		<?php }?>
            
    </div>
    <?php }?>

</div>

<?php function lpd_install_mediaboxes_p() {
	
	$the_grid_p_ID = get_the_ID();
	
	$full_width = get_post_meta($the_grid_p_ID, 'portfolio_options_full', true);

?>

<script>
  
    jQuery('document').ready(function(){
        
        //INITIALIZE THE PLUGIN
        jQuery('#grid-<?php echo $the_grid_p_ID ?>').grid({
                showFilterBar: false, //Show the navigation filter bar at the top
                imagesToLoad: 5, //The number of images to load when you click the load more button
                imagesToLoadStart: 999, //The number of images to load when it first loads the grid
                lazyLoad: true, //If you wish to load more images when it reach the bottom of the page
                isFitWidth: true, //Nedded to be true if you wish to center the gallery to its container
                horizontalSpaceBetweenThumbnails: 15, //The space between images horizontally
                verticalSpaceBetweenThumbnails: 15, //The space between images vertically
                columnWidth: 'auto', //The width of each columns, if you set it to 'auto' it will use the columns instead
                columns: <?php if($full_width) {?>5<?php } else{?>4<?php }?>, //The number of columns when you set columnWidth to 'auto'
                columnMinWidth: <?php if($full_width) {?>180<?php } else{?>200<?php }?>, //The minimum width of each columns when you set columnWidth to 'auto'
                isAnimated: true, //If you wish the gallery to have animated effects when resizing the grid
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
                lightBoxPlayInterval: 4000, //The interval in the auto play mode 
                lightBoxShowTimer: true, //If you wish to show the timer in auto play mode
                lightBoxStopPlayOnClose: false, //Do you want pause the auto play mode when you close the lightbox?
                allWord: "<?php _e('All', GETTEXT_DOMAIN) ?>", //The "All" word so you can translate it to another lenguaje
                loadMoreWord: "<?php _e('LOAD MORE ENTRIES', GETTEXT_DOMAIN) ?>", //The "Load More Entries" word so you can translate it to another lenguaje
        });

    });    
       
</script>

<?php }?>

<?php add_action( 'wp_footer', 'lpd_install_mediaboxes_p', 100);?>