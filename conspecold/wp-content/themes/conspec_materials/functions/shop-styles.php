<?php function lpd_shop_styles_styles() {?>

<?php $sale_flash_color= ot_get_option('sale_flash_color') ?>
<?php if($sale_flash_color){?><style>span.lpd-onsale {border: 2px solid <?php echo $sale_flash_color; ?>;color: <?php echo $sale_flash_color; ?>;}</style><?php }?>

<?php }?>
<?php add_action( 'wp_head', 'lpd_shop_styles_styles' );?>