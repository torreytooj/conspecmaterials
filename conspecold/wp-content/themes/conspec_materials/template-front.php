<?php 
/*
Template Name: Front Template
*/?>

<?php get_header(); ?>

<div id="main" class="front-page sticky_menu">
	<div class="container">
		<div class="row">
			<div class="col-md-12 page-content">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content();?>
            <?php endwhile; else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN) ?></p>
            <?php endif; ?>
            </div>
		</div>
	</div>
</div>
        
<?php get_footer(); ?>