<?php $st_buttons_p = ot_get_option('st_buttons_p'); ?>

<?php $sidebar_checkbox = get_post_meta($post->ID, 'sidebar_checkbox', true);?>
<?php $full_width = get_post_meta($post->ID, 'portfolio_options_full', true);?>
<?php $details = get_post_meta($post->ID, 'portfolio_options_repeatable', true); if($details){$details = array_filter($details);};?>
<?php $terms = get_the_terms($post->ID, 'portfolio_tags' ); ?>
<?php $share = get_post_meta($post->ID, 'portfolio_options_share', true);?>
<?php get_header(); ?>

<?php get_template_part('includes/title-breadcrumb' ) ?>

<div id="main" class="inner-page <?php if ($sidebar_checkbox){?>left-sidebar-template<?php }?>">
	<div class="container">
		<div class="row">
			<div class="<?php if ($full_width){?>col-md-12<?php }else{?>col-md-9<?php }?> page-content">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php get_template_part('includes/single-portfolio-post' );?>
            <?php endwhile; else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN) ?></p>
            <?php endif; ?>
            </div>
            <?php if (!$full_width){?>
			<div class="col-md-3">
			<?php if ( is_active_sidebar(4)||!empty($details) || $terms || !$share ){?>
			    <div class="sidebar">
		        <?php if ( !empty($details) || $terms || !$share ){?>
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
		        <?php }?>
			    <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Portfolio Post Sidebar') ) ?>
			    </div>
			<?php } ?>
			</div>
            <?php }?>
		</div>
	</div>
</div>


        
<?php get_footer(); ?>