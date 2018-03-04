<?php 

$blog_number_of_post = "9999";
$the_grid_t_ID = get_the_ID();

get_header(); ?>

<?php get_template_part('includes/title-breadcrumb' ) ?>
<div id="main" class="inner-page">
	<div class="container">
		<div class="row">
			<div class="col-md-12 page-content">

		    <div id="grid-<?php echo $the_grid_t_ID ?>">
		    
				<?php $query = new WP_Query();?>
            	<?php $taxo_slug = get_queried_object()->slug;?> 
                <?php $query->query('portfolio_category='.$taxo_slug.'&post_type=portfolio&posts_per_page=-1');?>
                <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>
		            <?php get_template_part('includes/grid-portfolio' ) ?>
		        <?php endwhile; else: ?>
			        <div class="box">        
			            <div class="box-caption">
			                <a class="box-title" href="#"><?php _e('Error', GETTEXT_DOMAIN) ?></a>
			                <p><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN) ?></p>   
			            </div>
			        </div>
		        <?php endif; ?>
		            
		    </div> 
			    
            </div>
		</div>
	</div>
</div>

<?php function lpd_install_mediaboxes() {
	
	global $the_grid_t_ID;

?>

<script>
  
    jQuery('document').ready(function(){
        
        //INITIALIZE THE PLUGIN
        jQuery('#grid-<?php echo $the_grid_t_ID ?>').grid({
                showFilterBar: false, //Show the navigation filter bar at the top
                imagesToLoad: 5, //The number of images to load when you click the load more button
                imagesToLoadStart: 10, //The number of images to load when it first loads the grid
                lazyLoad: true, //If you wish to load more images when it reach the bottom of the page
                isFitWidth: true, //Nedded to be true if you wish to center the gallery to its container
                horizontalSpaceBetweenThumbnails: 15, //The space between images horizontally
                verticalSpaceBetweenThumbnails: 15, //The space between images vertically
                columnWidth: 'auto', //The width of each columns, if you set it to 'auto' it will use the columns instead
                columns: 4, //The number of columns when you set columnWidth to 'auto'
                columnMinWidth: 220, //The minimum width of each columns when you set columnWidth to 'auto'
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

<?php add_action( 'wp_footer', 'lpd_install_mediaboxes', 100);?>
        
<?php get_footer(); ?>