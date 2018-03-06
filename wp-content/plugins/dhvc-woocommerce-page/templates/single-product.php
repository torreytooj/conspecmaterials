<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/dhvc-woocommerce-page/single-product.php
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product_page;

get_header( 'shop' ); ?>
	
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
	<?php 
	while (have_posts()):the_post();
		/**
		 * woocommerce_before_single_product hook
		*
		* @hooked wc_print_notices - 10
		*/
		do_action( 'woocommerce_before_single_product' );
		
		if ( post_password_required() ) {
			echo get_the_password_form();
			return;
		}
		?>
		<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<?php
		the_product_page_content();
		?>
		
		<?php //do_action( 'woocommerce_after_single_product' ); ?>
		
		<meta itemprop="url" content="<?php the_permalink(); ?>" />
		</div>
		<?php
	endwhile;
	?>
	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>