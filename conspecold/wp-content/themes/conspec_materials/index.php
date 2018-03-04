<?php $blog_left_sidebar = ot_get_option('blog_left_sidebar') ?>
<?php get_header(); ?>

<?php get_template_part('includes/title-breadcrumb' ) ?>
<div id="main" class="inner-page <?php if ($blog_left_sidebar){?>left-sidebar-template<?php }?>">
	<div class="container">
		<div class="row">
			<div class="col-md-9 page-content">
			
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
				
				<?php get_template_part('includes/index-post' ) ?>
				
				<?php endwhile; else: ?>
				
				<p><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN); ?></p>
				
				<?php endif; wp_reset_query();?>
				
				<?php if (lpd_show_posts_nav()) : ?>
				<div class="blog-pagination">
					<?php previous_posts_link(__('&larr; Newer Entries', GETTEXT_DOMAIN), 0) ?>
					<?php next_posts_link(__('Older Entries &rarr;', GETTEXT_DOMAIN), 0); ?>
				</div>
				<?php endif; ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>