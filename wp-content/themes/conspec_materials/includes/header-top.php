<?php 
    $header_meta = ot_get_option('header_meta');
    $left_headermeta = ot_get_option('left_headermeta');
    $right_headermeta = ot_get_option('right_headermeta');
    $wpml_switcher = ot_get_option('wpml_switcher');
    $h_sm_locations = ot_get_option('h_sm_locations');
?>
	<?php if (!$header_meta){?>
	<div class="header-top">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="ht-left-container">
						<?php get_template_part('includes/search' ) ?>
						<?php if ($h_sm_locations=="left_t_h"){?><div class="left-meta sm-content"><?php get_template_part('includes/header-social-media' ) ?></div><?php }	?>
						<?php if ($left_headermeta){?><div class="left-meta text-content"><?php echo $left_headermeta;?></div><?php }	?>
					</div>
					<div class="ht-right-container">
						<?php get_template_part('includes/wpml' ) ?>
						<?php if ($h_sm_locations=="right_t_h"){?><div class="right-meta sm-content social-right-align"><?php get_template_part('includes/header-social-media' ) ?></div><?php }	?>
						<?php if ($right_headermeta){?><div class="right-meta text-content"><?php echo $right_headermeta;?></div><?php }	?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php }	?>