<?php
require_once(ABSPATH .'/wp-admin/includes/plugin.php');

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 5 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 10 );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );


if ( ! function_exists( 'woocommerce_button_proceed_to_checkout' ) ) {

	function woocommerce_button_proceed_to_checkout() {
		$checkout_url = WC()->cart->get_checkout_url();

		?>
		<a href="<?php echo $checkout_url; ?>" class="checkout-button btn btn-primary wc-forward"><?php _e( 'Proceed to Checkout', 'woocommerce' ); ?></a>
		<?php
	}
}

add_filter('add_to_cart_fragments', 'lpd_add_to_cart_fragments');
 
function lpd_add_to_cart_fragments( $fragments ) {
	global $woocommerce;
	ob_start();?>
		
		<div class="header-cart">
			<a class="header-cart-button" href="<?php echo $woocommerce->cart->get_cart_url(); ?>">
				<span class="cart-bag-icon">
					<span class="cart-bag"><?php echo $woocommerce->cart->get_cart_contents_count(); ?></span>
					<span class="cart-bag-handle"></span>
				</span>
				<span class="cart-total"><?php _e('Cart', GETTEXT_DOMAIN); ?> - <?php echo $woocommerce->cart->get_cart_subtotal(); ?></span>
			</a>
			<div class="cart-dropdown hidden-xs hidden-sm">
				
				<div class="header_cart_list">
				
					<?php if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) : ?>
				
						<?php foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) :
				
							$_product = $cart_item['data'];
				
							// Only display if allowed
							if ( ! apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) || ! $_product->exists() || $cart_item['quantity'] == 0 )
								continue;
				
							// Get price
							$product_price = get_option( 'woocommerce_display_cart_prices_excluding_tax' ) == 'yes' || $woocommerce->customer->is_vat_exempt() ? $_product->get_price_excluding_tax() : $_product->get_price();
				
							$product_price = apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $cart_item, $cart_item_key );?>
				
							<div class="item clearfix">
								<a class="cart-thumbnail" href="<?php echo get_permalink( $cart_item['product_id'] ); ?>"><?php echo $_product->get_image('thumbnail'); ?></a>
								<div class="cart-content">
									<a class="cart-title" href="<?php echo get_permalink( $cart_item['product_id'] ); ?>"><?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?></a>
									<?php echo $woocommerce->cart->get_item_data( $cart_item ); ?>
									<div class="cart-meta">
										<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="item-remove" title="%s">%s</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', GETTEXT_DOMAIN), __('remove', GETTEXT_DOMAIN) ), $cart_item_key );?>
										<span class="quantity"><?php printf( '%s &times; %s', $cart_item['quantity'], $product_price ); ?></span>
									</div>
								</div>
							</div>
							
						<?php endforeach; ?>
				
					<?php else : ?>
				
						<div class="empty"><?php _e('No products in the cart.', GETTEXT_DOMAIN); ?></div>
				
					<?php endif; ?>
				
				</div><!-- end product list -->
				
				<?php if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) : ?>
				
				<div class="header_cart_footer">
					<p class="total cleanfix"><strong><?php _e('Cart Subtotal', GETTEXT_DOMAIN); ?>:</strong> <span><?php echo $woocommerce->cart->get_cart_subtotal(); ?></span></p>
				
					<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
				
					<p class="buttons">
						<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" class="btn btn-default btn-sm"><?php _e('View Cart &rarr;', GETTEXT_DOMAIN); ?></a>
						<a href="<?php echo $woocommerce->cart->get_checkout_url(); ?>" class="btn btn-primary btn-sm checkout"><?php _e('Checkout &rarr;', GETTEXT_DOMAIN); ?></a>
					</p>
				</div>
				
				<?php endif; ?>
				
			</div>
		</div>
		
	<?php $fragments['.header-cart'] = ob_get_clean();
	return $fragments;
}

if ( ! function_exists( 'woocommerce_page_breadcrumb' ) ) {

	function woocommerce_page_breadcrumb( $args = array() ) {

		$defaults = apply_filters( 'woocommerce_breadcrumb_defaults', array(
			'delimiter'   => '&nbsp;&rarr; ',
			'wrap_before' => '',
			'wrap_after'  => '',
			'before'      => '',
			'after'       => '',
			'home'        => _x( 'Home', 'breadcrumb', GETTEXT_DOMAIN ),
		) );

		$args = wp_parse_args( $args, $defaults );

		woocommerce_get_template( 'shop/breadcrumb.php', $args );
	}
}

if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {

	function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
	
		global $post, $woocommerce;
		global $product;

		$shop_thumb_type = ot_get_option('shop_thumb_type');

			$output = '';
			
			$output .= '<div class="product-item-thumb-wrap">';
			
			if ($product->is_on_sale()) {
			
				$output .= apply_filters('woocommerce_sale_flash', '<span class="lpd-onsale">'.__( 'Sale!', GETTEXT_DOMAIN ).'</span>', $post, $product);
			
			}
			
			if ( (! $product->is_in_stock()) || ($product->product_type == 'external') || ( ! $product->is_purchasable() && ! in_array( $product->product_type, array( 'external', 'grouped' ) ) ) ){}
	
			if ( has_post_thumbnail() ) {
			
				if($shop_thumb_type=="none"){
				
					$thumbnail = get_the_post_thumbnail( $post->ID, $size );
				
				}else{
				
					if($shop_thumb_type=="portrait"){
						$thumbnail = get_the_post_thumbnail( $post->ID, 'front-shop-thumb' );	
					}else{
						$thumbnail = get_the_post_thumbnail( $post->ID, 'front-shop-thumb2' );
					}
				
				}
	
				if ( ! $product->is_purchasable() && ! in_array( $product->product_type, array( 'external', 'grouped' ) ) ){
				
					$output .= '<a class="product-item-thumb" href="'.get_permalink().'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
					
				}else{
				
					if ( ! $product->is_in_stock() ){
					
						$output .= '<a class="product-item-thumb" href="'.get_permalink().'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
					
					}else{
					
						$disable = '';
					
						switch ( $product->product_type ) {
						case "variable" :
							$link 	= apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
							$label 	= apply_filters( 'variable_add_to_cart_text', __('Select options', GETTEXT_DOMAIN) );
						break;
						case "grouped" :
							$link 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
							$label 	= apply_filters( 'grouped_add_to_cart_text', __('View options', GETTEXT_DOMAIN) );
						break;
						case "external" :
							$disable = 'yes';
						break;
						default :
							$link 	= get_permalink();
							$label 	= apply_filters( 'add_to_cart_text', __('Add to cart', GETTEXT_DOMAIN) );
						break;
						}
							
						if($disable == 'yes'){
							
							$output .= '<a class="product-item-thumb" href="'.get_permalink().'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
						
						}else{
				
							$output .= '<a class="product-item-thumb" href="'.$link.'" title="'.$label.'">'.$thumbnail.'</a>';
						
						}
				
					}
				
				}
	
			} 
			else {
			
				$thumbnail = '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="480" height="480" />';
	
				if ( ! $product->is_purchasable() && ! in_array( $product->product_type, array( 'external', 'grouped' ) ) ){
				
					$output .= '<a class="product-item-thumb" data-placement="bottom" href="'.get_permalink().'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
					
				}else{
				
					if ( ! $product->is_in_stock() ){
					
						$output .= '<a class="product-item-thumb" href="'.apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ).'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
					
					}else{
					
						$disable = '';
						
						switch ( $product->product_type ) {
						case "variable" :
							$link 	= apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
							$label 	= apply_filters( 'variable_add_to_cart_text', __('Select options', GETTEXT_DOMAIN) );
						break;
						case "grouped" :
							$link 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
							$label 	= apply_filters( 'grouped_add_to_cart_text', __('View options', GETTEXT_DOMAIN) );
						break;
						case "external" :
							$disable = 'yes';
						break;
						default :
							$link 	= get_permalink();
							$label 	= apply_filters( 'add_to_cart_text', __('Add to cart', GETTEXT_DOMAIN) );
						break;
						}
								
						if($disable == 'yes'){
							
							$output .= '<a class="product-item-thumb" href="'.get_permalink().'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
						
						}else{
				
							$output .= '<a class="product-item-thumb" href="'.$link.'" title="'.$label.'">'.$thumbnail.'</a>';
						
						}
				
					}
				
				}
	
			}
			
			
			if ( ! $product->is_in_stock() ) {
			
					$output .= '<a href="'.apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ).'" class="product-item_btn"><span class="glyphicons shopping_cart glyphicons-icon"></span></a>';
			
			}
			else {
					$link = array(
						'url'   => '',
						'label' => '',
						'class' => ''
					);
			
					$handler = apply_filters( 'woocommerce_add_to_cart_handler', $product->product_type, $product );
			
					switch ( $handler ) {
						case "variable" :
							$link['url'] 	= apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
							$link['label'] 	= apply_filters( 'variable_add_to_cart_text', __( 'Select options', GETTEXT_DOMAIN ) );
						break;
						case "grouped" :
							$link['url'] 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
							$link['label'] 	= apply_filters( 'grouped_add_to_cart_text', __( 'View options', GETTEXT_DOMAIN ) );
						break;
						case "external" :
							$link['url'] 	= apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
							$link['label'] 	= apply_filters( 'external_add_to_cart_text', __( 'Read More', GETTEXT_DOMAIN ) );
						break;
						default :
							if ( $product->is_purchasable() ) {
								$link['url'] 	= apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
								$link['label'] 	= apply_filters( 'add_to_cart_text', __( 'Add to cart', GETTEXT_DOMAIN ) );
								$link['class']  = apply_filters( 'add_to_cart_class', 'add_to_cart_button' );
							} else {
								$link['url'] 	= apply_filters( 'not_purchasable_url', get_permalink( $product->id ) );
								$link['label'] 	= apply_filters( 'not_purchasable_text', __( 'Read More', GETTEXT_DOMAIN ) );
							}
						break;
					}
			
					$output .= apply_filters( 'woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="%s product-item_btn  product_type_%s" title="%s"><span class="glyphicons shopping_cart glyphicons-icon"></span></a>', esc_url( $link['url'] ), esc_attr( $product->id ), esc_attr( $product->get_sku() ), esc_attr( $link['class'] ), esc_attr( $product->product_type ), esc_html( $link['label'] ) ), $product, $link );
			
			}			
			
			$output .= '</div>';
			
			return $output;
	}
}


remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
if ( ! function_exists( 'woocommerce_output_related_products' ) ) {
	function woocommerce_output_related_products() {
		$args = array(
			'posts_per_page' => 4,
			'columns' => 4,
			'orderby' => 'rand'
		);

		woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
	}
}
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );
 
if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
	function woocommerce_output_upsells() {
	woocommerce_upsell_display( 4,4 );
	}
}

add_filter( 'woocommerce_cross_sells_columns', 'lpd_cross_sells_columns' );
function lpd_cross_sells_columns( $columns ) {
	return 4;
}

add_filter ( 'woocommerce_product_thumbnails_columns', 'ptc_lpd_themes' ); 
function ptc_lpd_themes() {
	return 3;
}


add_filter('loop_shop_per_page', 'new_loop_shop_per_page');
function new_loop_shop_per_page() {

	$loop_shop_per_page= ot_get_option('loop_shop_per_page');

	if (!$loop_shop_per_page){
	    $loop_shop_per_page = 12;
	}
	
	return $loop_shop_per_page;

}

add_filter ( 'single_product_large_thumbnail_size', 'woo_lts_lpd_themes' ); 
function woo_lts_lpd_themes() {			

	$product_image_type= ot_get_option('product_image_type');
				
	if($product_image_type=="none"){
		return 'shop_catalog';
	}else{
		if($product_image_type=="portrait"){
			return 'front-shop-thumb';	
		}else{
			return 'front-shop-thumb2';
		}
	}
	
}

add_filter ( 'single_product_small_thumbnail_size', 'woo_sts_lpd_themes' );
function woo_sts_lpd_themes() {	

	$product_thumb_type= ot_get_option('product_thumb_type');
	
	if($product_thumb_type=="none"){
		return 'shop_catalog';
	}else{		
		if($product_thumb_type=="portrait"){
			return 'front-shop-thumb';	
		}else{
			return 'front-shop-thumb2';
		}
	}
	
}

?>