<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
?>
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly?>

<?php global $post;?>

<?php if (is_shop()){?>
	<?php if (!is_search()){?>
		<?php $shop_page = get_post( woocommerce_get_page_id( 'shop' ) ); ?>
		<?php $sidebar_checkbox = get_post_meta($shop_page->ID, 'sidebar_checkbox', true);?>
	<?php }?>
<?php } elseif (is_singular( 'product' )){?>
	<?php $sidebar_checkbox = get_post_meta($post->ID, 'sidebar_checkbox', true); ?>
<?php }?>

<?php get_template_part('includes/title-breadcrumb' ) ?>
<div id="main" class="inner-page <?php if ($sidebar_checkbox){?>left-sidebar-template<?php }?>">
	<div class="container">
		<div class="row">
		<?php if(is_singular( 'product' )){ ?>
			<?php if ( is_active_sidebar(6) ){?>
				<div class="col-md-10 page-content shop-post-page">
			<?php } else{?>
				<div class="col-md-12 page-content shop-post-page">
			<?php } ?>
		<?php } else{?>
			<?php if ( is_active_sidebar(5) ){?>
				<div class="col-md-9 page-content shop-page">
			<?php } else{?>
				<div class="col-md-12 page-content shop-page">
			<?php } ?>
		<?php } ?>