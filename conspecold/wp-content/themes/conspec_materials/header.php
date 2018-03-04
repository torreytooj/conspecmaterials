<?php require_once(ABSPATH .'/wp-admin/includes/plugin.php');?>

<?php get_template_part('includes/layouts' ) ?>
<?php get_template_part('includes/plug' ) ?>
<?php $h_sm_locations = ot_get_option('h_sm_locations') ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    
	<?php get_template_part('includes/title' ) ?>
    
	<?php get_template_part('includes/seo' ) ?>

	<?php get_template_part('includes/meta-viewport' ) ?>
    

    <?php get_template_part('includes/favicon' ) ?>

    <?php wp_head(); ?>
    
</head>
<body <?php body_class(); ?>>

<div id="header">

	<?php get_template_part('includes/header-top' ) ?>
	<div class="header-middle clearfix">
		<div class="header">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="header-middle-wrap">
							<?php get_template_part('includes/logo' ) ?>
							<?php if (is_plugin_active('woocommerce/woocommerce.php')) {?><?php get_template_part('includes/cart' ) ?><?php } ?>
							<?php if ( has_nav_menu( 'right-hm-menu' ) ) {?><?php wp_nav_menu( array( 'theme_location' => 'right-hm-menu', 'menu_class' => 'right-hm-menu', 'container' => '', 'depth' => 1  ) ); ?><?php } ?>
							<?php if ($h_sm_locations=="right_h"){?><div class="header-middle-sm social-right-align"><?php get_template_part('includes/header-social-media' ) ?></div><?php }	?>
						</div>
						<?php get_template_part('includes/menu' ) ?>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
