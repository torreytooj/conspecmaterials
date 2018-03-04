<?php function lpd_tagline() {

global $wp_query;

$page_id = '';

$posts_page = get_page($page_id);

$page_tagline_text=$post_tagline_text=$portfolio_tagline_text=$product_tagline_text=$blog_tagline_text='';

require_once(ABSPATH .'/wp-admin/includes/plugin.php');

if (is_plugin_active('woocommerce/woocommerce.php')) {
	if(is_shop()){
		$shop_id = woocommerce_get_page_id('shop');
		$page_tagline_text = get_post_meta($shop_id, 'page_tagline_text', true);
	}else{
		$page_tagline_text = get_post_meta($posts_page->ID, 'page_tagline_text', true);
	}
}else{
	$page_tagline_text = get_post_meta($posts_page->ID, 'page_tagline_text', true);
}

$blog_tagline_text = ot_get_option('blog-tagline-title');
if(is_single()){$post_tagline_text = get_post_meta($posts_page->ID, 'post_tagline_text', true);}
if(is_singular('portfolio')){$portfolio_tagline_text = get_post_meta($posts_page->ID, 'portfolio_tagline_text', true);}
if(is_singular('product')){$product_tagline_text = get_post_meta($posts_page->ID, 'product_tagline_text', true);}
#$member_terms = get_the_terms( get_the_ID(), 'about_category' );


if ($page_tagline_text||$post_tagline_text||$portfolio_tagline_text||$product_tagline_text||$blog_tagline_text) {


	if(is_singular('portfolio')){
	
	if($portfolio_tagline_text){ echo '<span class="title-subtitle">'.$portfolio_tagline_text.'</span>'; };
	
	}
	
	if (is_plugin_active('woocommerce/woocommerce.php')) {
		if(!is_shop()){
			if($page_tagline_text){ echo '<span class="title-subtitle">'.$page_tagline_text.'</span>'; };
		}
		if(is_shop()){
			if(!is_search()){
				if($page_tagline_text){ echo '<span class="title-subtitle">'.$page_tagline_text.'</span>'; }
			}
		}
		if(!is_shop()&&!is_product_category()&&!is_tax("product_tag")){
			if(is_singular('product')){
				if($product_tagline_text){ echo '<span class="title-subtitle">'.$product_tagline_text.'</span>'; }
			}
		}
	}else{
		if(!is_home()){
			if($page_tagline_text){ echo '<span class="title-subtitle">'.$page_tagline_text.'</span>'; }
		}
	}

	if(!is_home()&&!is_archive()){
		if($post_tagline_text){ echo '<span class="title-subtitle">'.$post_tagline_text.'</span>'; }
	}
	
	if(is_home()){
		if($blog_tagline_text){ echo '<span class="title-subtitle">'.$blog_tagline_text.'</span>'; }
	}
	
	#if($member_terms) : foreach ($member_terms as $term) { echo '<span class="title-subtitle">'.$term->name.'</span>'; } endif;
}	

	
}?>