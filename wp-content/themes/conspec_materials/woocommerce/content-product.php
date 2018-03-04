<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

$s_rating = ot_get_option('s_rating');
$shop_columns = ot_get_option('shop_columns');

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )

	if(!$shop_columns)
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
	else
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', $shop_columns );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ($woocommerce_loop['columns'] == "2"){
	$classes[] = 'col-md-6';
} elseif ($woocommerce_loop['columns'] == "3"){
	$classes[] = 'col-md-4';	
} elseif ($woocommerce_loop['columns'] == "4"){
	$classes[] = 'col-md-3';	
} else{
	$classes[] = 'col-md-3';	
}
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
?>
<li <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
		
		<?php woocommerce_get_template( 'loop/price.php' );?>
		<div class="item-details">
			<h3><?php the_title(); ?></h3>
			<div class="product-item-cat"><?php echo $product->get_categories(', ');?></div>
		</div>
		
		<?php if(!$s_rating){?>
			<?php woocommerce_get_template( 'loop/rating.php' );?>
		<?php }?>

		<?php
			
		?>

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

</li>