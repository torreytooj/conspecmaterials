<?php 
    $custom_logo = ot_get_option('custom_logo');
?>

<?php if($custom_logo){?>
<div id="logo" class="img">
    <h1><a title="<?php bloginfo( 'name' ); ?>" href="<?php echo home_url(); ?>"><img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo $custom_logo?>"/></a></h1>
</div>
<?php }else{?>
<div id="logo">
    <h1><a title="<?php bloginfo( 'name' ); ?>" href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
</div>
<?php }?>