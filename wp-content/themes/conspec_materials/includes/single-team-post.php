<?php $st_buttons = ot_get_option('st_buttons'); ?>

<?php $video = lpd_parse_video(get_post_meta($post->ID, 'video_post_meta', true));?>

<div id="post-<?php the_ID(); ?>" class="single-post <?php $allClasses = get_post_class(); foreach ($allClasses as $class) { echo $class . " "; } ?>">
	<div class="single-post-content">
		<div class="single-post-content-content">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
			<div class="clearfix"></div>
			<?php edit_post_link( __('edit', GETTEXT_DOMAIN), '<span class="edit-post">[', ']</span>' ); ?>
		</div>
	</div>
</div>