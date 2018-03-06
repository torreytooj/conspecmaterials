<?php function lpd_bg_styles() {?>

<?php
$bg_color = ot_get_option('bg_color');
$bg_image_full = ot_get_option('bg_image_full');
$bg_image_repeat = ot_get_option('bg_image_repeat');

if($bg_color==""){
	$bg_color = "#f0f0f0";
}
?>

<?php if($bg_color||$bg_image_full||$bg_image_repeat){?>
<style>
<?php if($bg_image_repeat){?>
body{
	background: url(<?php echo $bg_image_repeat ?>);
	background-position: center top;
	background-repeat: repeat;
}
<?php } elseif($bg_image_full){?>
body{
	background: url(<?php echo $bg_image_full ?>);
	background-color: transparent;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	background-attachment: fixed;
	background-position: center top;
	background-repeat: repeat;
}
<?php } elseif($bg_color){?>
body{background-color:<?php echo $bg_color;?>}
<?php }?>
</style>
<?php }?>

<?php }?>
<?php add_action( 'wp_head', 'lpd_bg_styles' );?>