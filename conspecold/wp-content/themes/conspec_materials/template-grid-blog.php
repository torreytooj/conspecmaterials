<?php 
/*
Template Name: Grid Blog Template
*/?>

<?php
$blog_number_of_post = "9999";
$the_grid_t_ID = get_the_ID();

$category_filter = get_post_meta($post->ID, 'grid_options_category_filter', true);


get_header(); ?>

<?php get_template_part('includes/title-breadcrumb' ) ?>
<div id="main" class="inner-page">
	<div class="container">
		<div class="row">
			<div class="col-md-12 page-content">
			
	        <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
                <?php $post_thumbnail_id = get_post_thumbnail_id(); ?> 
                <?php $alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);?>
	            <img class="page-thumbnail img-responsive" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'default-page' ); echo $image[0];?>" />
	        <?php }?>

			
			<?php if($post->post_content != "") {?>
			<div class="template-content">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php the_content();?>
				<?php endwhile; else: ?>
					<p><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN) ?></p>
				<?php endif; ?>
			</div>
			<?php }?>
    
    
		    <div id="grid-<?php echo $the_grid_t_ID ?>">
		    
				<?php if ($blog_number_of_post){ $num_posts = $blog_number_of_post; }else{ $num_posts = 10; }?>
				
		        <?php if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } elseif ( get_query_var('page') ) { $paged = get_query_var('page'); } else { $paged = 1; }
		        
		        query_posts( array( 'post_type' => 'post', 'paged' => $paged, 'posts_per_page' => $num_posts, 'category_name' => $category_filter ) );
		        if (have_posts()) : while (have_posts()) : the_post(); ?>
		            <?php get_template_part('includes/grid-blog' ) ?>
		        <?php endwhile; else: ?>
			        <div class="box">        
			            <div class="box-caption">
			                <a class="box-title" href="#"><?php _e('Error', GETTEXT_DOMAIN) ?></a>
			                <p><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN) ?></p>   
			            </div>
			        </div>
		        <?php endif; wp_reset_query();?>
		            
		    </div> 
			    
            </div>
		</div>
	</div>
</div>

<?php function lpd_install_mediaboxes() {
	
	global $the_grid_t_ID;
	
	$showFilterBar = get_post_meta($the_grid_t_ID, 'grid_options_showFilterBar', true);
	$isFitWidth = get_post_meta($the_grid_t_ID, 'grid_options_isFitWidth', true);
	$columns = get_post_meta($the_grid_t_ID, 'grid_options_columns', true);
	$columnMinWidth = get_post_meta($the_grid_t_ID, 'grid_options_columnMinWidth', true);
	$isAnimated = get_post_meta($the_grid_t_ID, 'grid_options_isAnimated', true);
	$lightBoxPlayInterval = get_post_meta($the_grid_t_ID, 'grid_options_lightBoxPlayInterval', true);

?>

<script>
  
    jQuery('document').ready(function(){
        
        //INITIALIZE THE PLUGIN
        jQuery('#grid-<?php echo $the_grid_t_ID ?>').grid({
                showFilterBar: <?php if($showFilterBar) {?>true<?php } else{?>false<?php }?>, //Show the navigation filter bar at the top
                imagesToLoadStart: 999, //The number of images to load when it first loads the grid
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
        });

    });    
       
</script>

<?php }?>

<?php add_action( 'wp_footer', 'lpd_install_mediaboxes', 100);?>
        
<?php get_footer(); ?>