<?php function lpd_color_styles() {?>

<?php
$theme_color = ot_get_option('theme_color');
$theme_color_2 = ot_get_option('theme_color_2');
$type_layouts = ot_get_option('type_layouts');

if($theme_color==""){
	$theme_color = "#76abe8";
}

if($theme_color_2==""){
	$theme_color_2 = "#364a61";
}

?>

<?php if($theme_color||$theme_color_2){?>
<style>
/* bootstrap */
a {
  color: <?php echo $theme_color;?>;
}
a:hover,
a:focus {
  color: <?php echo $theme_color_2;?>;
}
.nav .current_page_ancestor a .caret,
.nav .active a .caret,
.nav .current_page_item a .caret,
.nav a:hover .caret {
  border-top-color: <?php echo $theme_color;?>;
  border-bottom-color: <?php echo $theme_color;?>;
}
.navbar-nav > li.current_page_ancestor > a,
.navbar-nav > li.active > a,
.navbar-nav > li.current_page_item > a,
.navbar-nav > li > a:hover{
  color: <?php echo $theme_color;?>;
}
.dropdown-menu > li > a:hover,
.dropdown-menu > li > a:focus {
  background-color: <?php echo $theme_color;?>;
}
.dropdown-menu > .active > a,
.dropdown-menu > .active > a:hover,
.dropdown-menu > .active > a:focus {
  background-color: <?php echo $theme_color;?>;
}

@media (min-width: 768px) {
	.dropdown-menu > li > a {
	  background: <?php echo $theme_color;?>;
	}
	.dropdown-menu > li > a:hover,
	.dropdown-menu > li > a:focus {
	  background-color: <?php echo $theme_color_2;?>;
	}
	.dropdown-menu > .active > a,
	.dropdown-menu > .active > a:hover,
	.dropdown-menu > .active > a:focus {
	  background-color: <?php echo $theme_color_2;?>;
	}
}

.btn-primary {
  background-color: <?php echo $theme_color_2;?>;
  border-color: <?php echo $theme_color_2;?>;
}
.btn-primary:hover,
.btn-primary:focus,
.btn-primary:active,
.btn-primary.active,
.open .dropdown-toggle.btn-primary {
  background-color: <?php echo $theme_color;?>;
  border-color: <?php echo $theme_color;?>;
}

/* application */

.thumb-menu-item a:hover img{
	border-color: <?php echo $theme_color;?>;
}
.thumb-menu-item a:hover h5{
	color: <?php echo $theme_color;?>;
}
@media (min-width: 768px) {
	section .dropdown-submenu.active > a,
	section .dropdown-submenu:hover > a{
	  background-color: <?php echo $theme_color;?>;
	}
}
.dropdown-menu section li.active a,
.dropdown-menu section li a:focus,
.dropdown-menu section li a:hover {
  background-color: <?php echo $theme_color;?>;
}

@media (min-width: 768px) {
	.none-type.dropdown-menu{
	  background-color: <?php echo $theme_color;?> !important;
	}
}

.lpd_breadcrumb{
	background: <?php echo $theme_color_2;?>;
}
.lpd_breadcrumb a:focus,
.lpd_breadcrumb a:hover{
  color: <?php echo $theme_color;?>;
}
.tb-t h2{
  color: <?php echo $theme_color_2;?>;
}

.footer-menu li a:hover{
	color: <?php echo $theme_color;?>;
}
.widget.widget_rss ul li a:hover,
.widget.widget_pages ul li a:hover,
.widget.widget_nav_menu ul li a:hover,
.widget.widget_login ul li a:hover,
.widget.widget_meta ul li a:hover,
.widget.widget_categories ul li a:hover,
.widget.widget_archive ul li a:hover,
.widget.widget_recent_comments ul li a:hover,
.widget.widget_recent_entries ul li a:hover{
	color: <?php echo $theme_color;?>;
}

.search-meta .btn .halflings:before{
	color: <?php echo $theme_color;?>;
}

.wpml-switcher .ws-title .halflings:before{
	color: <?php echo $theme_color;?>;
}
.ws-dropdown ul li a:hover{
	color: <?php echo $theme_color;?>;
}
.ws-dropdown{
	background-color: <?php echo $theme_color_2;?>;
}
.ws-dropdown:after {
	border-bottom: 5px solid <?php echo $theme_color_2;?>;
}
.blog-post-title a:hover{
	color: <?php echo $theme_color;?>;
}
.single-post-meta a:hover,
.blog-post-meta a:hover{
	color: <?php echo $theme_color;?>;
}

.tagcloud a:hover,
.tags a:hover{
	border-color: <?php echo $theme_color;?>;
	background-color: <?php echo $theme_color;?>;
}

.right-hm-menu li a:hover{
	color: <?php echo $theme_color;?>;
}
.cart-bag{
  background-color: <?php echo $theme_color_2;?>;
  border-color: <?php echo $theme_color;?>;
}
a:hover .cart-bag{
  background-color: <?php echo $theme_color;?>;
}
.cart-bag-handle{
  border-color: <?php echo $theme_color;?>;
}

.mega-icon{
	background-color: <?php echo $theme_color;?>; 
}
.mega-icon:hover{
	background-color: <?php echo $theme_color_2;?>; 
}
.portfolio-item .title a:hover{
	color: <?php echo $theme_color;?>;
}
.dropcap1{
	background: <?php echo $theme_color;?>; 
}
.wpmtp-filter ul li.current a,
.wpmtp-filter ul li a:hover{
	border-color: <?php echo $theme_color;?>;
	background-color: <?php echo $theme_color;?>;
}


/* Multi Purpose Media Boxes */

.box:hover .box-caption .box-title{
  color: <?php echo $theme_color;?>;
}
.category-navbar li.select a{
  background-color: <?php echo $theme_color;?>;
}
.category-navbar li a:hover{
  background-color: <?php echo $theme_color_2;?>;
}


/* woocommerece */
.wordpress-456industry .woocommerce table.cart .cart_table_item:hover img,
.wordpress-456industry.woocommerce-page table.cart .cart_table_item:hover img{
    border-color: <?php echo $theme_color;?>;
}

.wordpress-456industry .woocommerce table.cart a.remove:hover,
.wordpress-456industry.woocommerce-page table.cart a.remove:hover{
	background: <?php echo $theme_color_2;?>;
}

.wordpress-456industry .woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
.wordpress-456industry.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle{
	background: <?php echo $theme_color;?>;
	border: 1px solid <?php echo $theme_color_2;?>;
}
.wordpress-456industry .woocommerce .widget_price_filter .ui-slider .ui-slider-handle:hover,
.wordpress-456industry.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle:hover{
	background: <?php echo $theme_color_2;?>;
}

.woocommerce ul.cart_list li a:hover img,
.woocommerce-page ul.cart_list li a:hover img,
.woocommerce ul.product_list_widget li a:hover img,
.woocommerce-page ul.product_list_widget li a:hover img{
	border: 1px solid <?php echo $theme_color;?>;
}

.woocommerce ul.cart_list li a:hover,
.woocommerce-page ul.cart_list li a:hover,
.woocommerce ul.product_list_widget li a:hover,
.woocommerce-page ul.product_list_widget li a:hover{
	color: <?php echo $theme_color;?> !important;
}
.product-category a:hover{
	border-color: <?php echo $theme_color;?>;
}
ul.lpd-products li.product.product-category:hover .product-category-title{
	background-color: <?php echo $theme_color;?>;
}
.product-item-thumb-wrap:hover{
	border-color: <?php echo $theme_color;?>;
}
.product-item_btn.loading .glyphicons:before{
	color: <?php echo $theme_color;?> !important;
}
.product-item-thumb-wrap .product-item_btn{
	color: <?php echo $theme_color;?>;
	border-color: <?php echo $theme_color;?>;
}
.product-item-thumb-wrap .product-item_btn .glyphicons:before{
	color: <?php echo $theme_color;?>;
}
.product-item-thumb-wrap .product-item_btn.add_to_cart_button.added,
.product-item-thumb-wrap .product-item_btn:hover{
	color: <?php echo $theme_color_2;?>;
	border-color: <?php echo $theme_color_2;?>;
}
.product-item-thumb-wrap .product-item_btn.add_to_cart_button.added .glyphicons:before,
.product-item-thumb-wrap .product-item_btn:hover .glyphicons:before{
	color: <?php echo $theme_color_2;?>;	
}
.wordpress-456industry.woocommerce-page div.product form.cart .group_table td.label a:hover{
	color: <?php echo $theme_color;?>;
}

.wordpress-456industry.woocommerce-page .quantity .plus:hover,
.wordpress-456industry.woocommerce-page #content .quantity .plus:hover,
.wordpress-456industry.woocommerce-page .quantity .minus:hover,
.wordpress-456industry.woocommerce-page #content .quantity .minus:hover{
	background: <?php echo $theme_color;?>;
}
.wordpress-456industry .woocommerce .woocommerce-breadcrumb a:hover,
.wordpress-456industry.woocommerce-page .woocommerce-breadcrumb a:hover{
	color: <?php echo $theme_color;?>;
}

<?php if($type_layouts=="responsive"){?>
@media (max-width: 991px) {
	.ws-dropdown ul li a{
		color: <?php echo $theme_color;?>;
	}
	.ws-dropdown ul li a:hover{
		color: <?php echo $theme_color_2;?>;
	}
}
<?php }?>

<?php if($type_layouts=="fixed"){?>
.none-type.dropdown-menu{
  background-color: <?php echo $theme_color;?> !important;
}
section .dropdown-submenu.active > a,
section .dropdown-submenu:hover > a{
  background-color: <?php echo $theme_color;?>;
}
.dropdown-menu > li > a {
  background: <?php echo $theme_color;?>;
}
.dropdown-menu > li > a:hover,
.dropdown-menu > li > a:focus {
  background-color: <?php echo $theme_color_2;?>;
}
.dropdown-menu > .active > a,
.dropdown-menu > .active > a:hover,
.dropdown-menu > .active > a:focus {
  background-color: <?php echo $theme_color_2;?>;
}
<?php }?>

</style>
<?php }?>

<?php }?>
<?php add_action( 'wp_head', 'lpd_color_styles' );?>