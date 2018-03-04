<?php 
/*
Template Name: Sitemap Template
*/?>

<?php get_header(); ?>

<?php get_template_part('includes/title-breadcrumb' ) ?>
<div id="main" class="inner-page">
	<div class="container">
		<div class="row">
			<div class="col-md-9 page-content">
	        	<div class="row">
	                <?php $query = new WP_Query();?>
	                <?php $posts = $query->query('ignore_sticky_posts=1&post_status=publish&posts_per_page=-1');?>
	                <?php if($posts){?>
		        	<div class="col-lg-6 col-md-6">
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
		        	<div class="col-lg-12 col-md-12">
			        <?php }else{?>
			        <div class="col-lg-6 col-md-6">
			        <?php }?>
	                   <h4><?php _e('Eaton Strainers and Parts', GETTEXT_DOMAIN) ?>:</h4>
	                    <div class="halflings-icon-list book">
	                        		        				        	<div class="col-lg-12 col-md-12">
				        					        

					        <div class="halflings-icon-list shopping-cart">
			                    <ul>
	                            <li class="page_item page-item-344"><a href="http://eatonstrainersandparts.com/about-eaton-strainers-and-parts/">About Us</a></li>
	                            <li class="page_item page-item-1149"><a href="http://eatonstrainersandparts.com/shop/">Order Eaton Hayward Strainers</a></li>
<li class="page_item page-item-1149"><a href="http://eatonstrainersandparts.com/eaton-filtration-strainers-and-parts/">Order Eaton Filtration Parts</a></li>
<li class="page_item page-item-833"><a href="http://eatonstrainersandparts.com/contact-eaton-strainers-and-parts/">Get a Quote</a></li>

	                        </ul>
					        </div>
			        	</div>
	                    </div> 
		        	</div>
		        </div>
		        <hr />
	        	<div class="row">
	                <?php if (is_plugin_active('woocommerce/woocommerce.php')) {?>
	                    <?php $query = new WP_Query();?>
	                    <?php $portfolio = $query->query('post_type=portfolio&ignore_sticky_posts=1&post_status=publish');?>
	                    <?php $products = $query->query('post_type=product&ignore_sticky_posts=1&post_status=publish&posts_per_page=-1');?>
	                    
	                    <?php if($products){?>
			        	
			        	<?php if(!$portfolio){?>
			        	<div class="col-lg-12 col-md-12">
				        <?php }else{?>
				        <div class="col-lg-6 col-md-6">
				        <?php }?>
					        
					        <h4><?php _e('Eaton Filtration Products', GETTEXT_DOMAIN) ?>:</h4>
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
	                <?php if (is_plugin_active('woocommerce/woocommerce.php')) {?>
	                <?php $products = $query->query('post_type=product&ignore_sticky_posts=1&post_status=publish');?><?php }?>
	                <?php $portfolio = $query->query('post_type=portfolio&ignore_sticky_posts=1&post_status=publish&posts_per_page=-1');?>
	                
		        	<?php if($portfolio){?>
		        	
		        	<?php if(!$products){?>
		        	<div class="col-lg-12 col-md-12">
			        <?php }else{?>
			        <div class="col-lg-6 col-md-6">
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
            </div>
            <?php get_sidebar(); ?>
		</div>
	</div>
</div>
        
<?php get_footer(); ?>