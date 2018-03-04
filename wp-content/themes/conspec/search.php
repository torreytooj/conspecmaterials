<?php 
/*
Template Name: Sitemap Template
*/?>

<?php get_header(); ?>

<?php get_template_part('includes/title-breadcrumb' ) ?>
<div id="main" class="inner-page">
	<div class="container">
		<div class="row">
			<div class="<?php if (have_posts()){?>col-md-12<?php } else{?>col-md-9<?php }?> page-content">
				<?php if (have_posts()){?>
                <div class="Search">
	                <div class="row">
		                <form role="search" method="get" class="form-inline" action="<?php echo site_url(); ?>">
		                    <div class="page-search">
		                        <div class="col-lg-10"><input id="s" class="search_input form-control" type="text" name="s" value="<?php the_search_query() ?>"/></div>
		                        <input class="btn btn-primary" id="searchsubmit" type="submit" value="<?php _e('Search', GETTEXT_DOMAIN) ?>"/>
		                    </div>
		                </form>
	                </div>
                </div>
                <?php }?>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php get_template_part('includes/search-post') ?>
                <?php endwhile; ?>
				<div class="search-pagination">
					<?php previous_posts_link(__('&larr; Newer Entries', GETTEXT_DOMAIN), 0) ?>
					<?php next_posts_link(__('Older Entries &rarr;', GETTEXT_DOMAIN), 0); ?>
				</div>
                <?php else: ?>
                <h4><?php _e('Nothing Found', GETTEXT_DOMAIN) ?></h4>
                <p><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN) ?></p>
                <div class="row">
	                <form role="search" method="get" class="form-inline" action="<?php echo site_url(); ?>">
	                    <div class="page-search">
	                        <div class="col-lg-10"><input id="s" class="search_input form-control" type="text" name="s" value="<?php the_search_query() ?>"/></div>
	                        <input class="btn btn-primary" id="searchsubmit" type="submit" value="<?php _e('Search', GETTEXT_DOMAIN) ?>"/>
	                    </div>
	                </form>
                </div>
                <hr />
	        	<div class="row">
                    <?php $query = new WP_Query();?>
                    <?php $posts = $query->query('ignore_sticky_posts=1&post_status=publish&posts_per_page=-1');?>
                    <?php if($posts){?>
		        	<div class="col-md-6">
				        <h4><?php _e('Blog Posts', GETTEXT_DOMAIN) ?>:</h4>
				        <div class="halflings-icon-list tag">
		                    <ul>
		                        <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
		                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		                        <?php endwhile; endif; ?> 
		                        <?php wp_reset_query(); ?>
		                    </ul>
				        </div>
		        	</div>
		        	<?php }?>
		        	<?php if(!$posts){?>
		        	<div class="col-md-12">
			        <?php }else{?>
			        <div class="col-md-6">
			        <?php }?>
                        <h4><?php _e('Available Pages', GETTEXT_DOMAIN) ?>:</h4>
                        <div class="halflings-icon-list book">
	                        <ul>
	                            <?php wp_list_pages('title_li=&posts_per_page=-1'); ?>
	                        </ul>
                        </div>
		        	</div>
		        </div>
		        <hr />
	        	<div class="row">
	        	
                    <?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
                        <?php $query = new WP_Query();?>
                        <?php $portfolio = $query->query('post_type=portfolio&ignore_sticky_posts=1&post_status=publish');?>
                        <?php $products = $query->query('post_type=product&ignore_sticky_posts=1&post_status=publish&posts_per_page=-1');?>
                        
                        <?php if($products){?>
			        	
			        	<?php if(!$portfolio){?>
			        	<div class="col-md-12">
				        <?php }else{?>
				        <div class="col-md-6">
				        <?php }?>
					        
					        <h4><?php _e('Available Products', GETTEXT_DOMAIN) ?>:</h4>
					        <div class="halflings-icon-list shopping-cart">
			                    <ul>
			                        <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
			                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			                        <?php endwhile; endif; ?> 
			                        <?php wp_reset_query(); ?>
			                    </ul>
					        </div>
			        	</div>
			        	<?php }?>
			        	<?php wp_reset_query();?>
		        	<?php }?>
		        	
		        	<?php $query = new WP_Query();?>
                    <?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?><?php $products = $query->query('post_type=product&ignore_sticky_posts=1&post_status=publish');?><?php }?>
                    <?php $portfolio = $query->query('post_type=portfolio&ignore_sticky_posts=1&post_status=publish&posts_per_page=-1');?>
                    
		        	<?php if($portfolio){?>
		        	
		        	<?php if(!$products){?>
		        	<div class="col-md-12">
			        <?php }else{?>
			        <div class="col-md-6">
			        <?php }?>
			        
                        <h4><?php _e('Portfolio Posts', GETTEXT_DOMAIN) ?>:</h4>
                        <div class="halflings-icon-list picture">
	                    <ul>
	                        <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
	                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	                        <?php endwhile; endif; ?> 
	                        <?php wp_reset_query(); ?>
	                    </ul>
                        </div>
		        	</div>
		        	<?php }?>
		        	<?php wp_reset_query();?>
		        	
		        </div>
                <?php endif; ?>
            </div>
            <?php if (!have_posts()){?><?php get_sidebar(); ?><?php }?>
		</div>
	</div>
</div>
        
<?php get_footer(); ?>