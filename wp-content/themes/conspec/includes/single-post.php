<?php $st_buttons = ot_get_option('st_buttons'); ?>

<?php $video = lpd_parse_video(get_post_meta($post->ID, 'video_post_meta', true));?>

<div id="post-<?php the_ID(); ?>" class="single-post <?php $allClasses = get_post_class(); foreach ($allClasses as $class) { echo $class . " "; } ?>">
	<?php if ($video) { ?>
	<iframe class="scale-with-grid-front page-thumbnail" width="850" height="478" src="<?php echo $video ?>?wmode=transparent;showinfo=0" frameborder="0" allowfullscreen></iframe>
	<?php } elseif ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {?>
	<?php $post_thumbnail_id = get_post_thumbnail_id(); ?> 
	<?php $alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);?>
	<img class="page-thumbnail img-responsive" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'default-sidebar-page' ); echo $image[0];?>" />
	<?php }?>
	
	<div class="single-post-content">
		<div class="single-post-meta">
			<a href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')); ?>" class="date"><span class="halflings calendar halflings-icon"></span><?php the_time('M j, Y'); ?></a>
			<a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" class="author"><span class="halflings user halflings-icon"></span><?php echo get_the_author(); ?></a>
			<a href="<?php comments_link(); ?>" class="comment"><span class="halflings comments halflings-icon"></span><?php comments_number(__('No Comments', GETTEXT_DOMAIN), __('1 Comment', GETTEXT_DOMAIN), __('% Comments', GETTEXT_DOMAIN)); ?></a>
		</div>
		<div class="single-post-content-content">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
			<div class="clearfix"></div>
			<?php edit_post_link( __('edit', GETTEXT_DOMAIN), '<span class="edit-post">[', ']</span>' ); ?>
		</div>
		<?php if ($st_buttons){?>
		<div class="st-share">
			<?php echo $st_buttons;?>
		</div>
		<?php }else{?>
			<div class="divider20"></div>
		<?php }?>
	</div>
</div>