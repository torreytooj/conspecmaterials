<?php

$header_search = ot_get_option('header_search');

?>

<?php if ($header_search!="none"){?>
<div class="search-meta">

	<?php if($header_search == "shop_search"){ ?>
	<form role="form" method="get" class="form-inline shop_search" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
		<input type="hidden" name="post_type" value="product" />
	    <input type="test" class="form-control" id="s" name="s" placeholder="<?php _e( 'Search For Products', GETTEXT_DOMAIN ); ?>">
		<button type="submit" class="btn"><span class="halflings search halflings-icon"></span></button>
	</form>
	<?php }else{?>
	<form role="form" method="get" class="form-inline sm-focus" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
		<button type="submit" class="btn"><span class="halflings search halflings-icon"></span></button>
	    <input type="test" class="form-control" id="s" name="s" placeholder="<?php _e( 'Search Site', GETTEXT_DOMAIN ); ?>">
		
	</form>
	<?php }?>
		
</div>
<?php }	?>
