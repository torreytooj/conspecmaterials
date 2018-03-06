<?php

$cc = ot_get_option('cc');

if(!$cc){
	$cc = array();
}

?>

<?php if(in_array('2checkout',$cc)||in_array('american-express',$cc)||in_array('cirrus',$cc)||in_array('delta',$cc)||in_array('direct',$cc)||in_array('discover',$cc)||in_array('ebay',$cc)||in_array('google-checkout',$cc)||in_array('maestro',$cc)||in_array('mastercard',$cc)||in_array('moneybookers',$cc)||in_array('sagepay',$cc)||in_array('solo',$cc)||in_array('switch',$cc)||in_array('visa-electron',$cc)||in_array('visa',$cc)||in_array('western-union',$cc)){ ?>
<ul class="cc">
	<?php if(in_array('2checkout',$cc)){?><li><span rel="tooltip" data-placement="top" title="2checkout" class="cc-icon cc-2checkout ttip ttip-top"></span></li><?php }?>
	<?php if(in_array('american-express',$cc)){?><li><span rel="tooltip" data-placement="top" title="American Express" class="cc-icon cc-american-express ttip ttip-top"></span></li><?php }?>
	<?php if(in_array('cirrus',$cc)){?><li><span rel="tooltip" data-placement="top" title="Cirrus" class="cc-icon cc-cirrus ttip ttip-top"></span></li><?php }?>
	<?php if(in_array('delta',$cc)){?><li><span rel="tooltip" data-placement="top" title="Delta" class="cc-icon cc-delta ttip ttip-top"></span></li><?php }?>
	<?php if(in_array('direct',$cc)){?><li><span rel="tooltip" data-placement="top" title="Direct" class="cc-icon cc-direct ttip ttip-top"></span></li><?php }?>
	<?php if(in_array('discover',$cc)){?><li><span rel="tooltip" data-placement="top" title="Discover" class="cc-icon cc-discover ttip ttip-top"></span></li><?php }?>
	<?php if(in_array('ebay',$cc)){?><li><span rel="tooltip" data-placement="top" title="Ebay" class="cc-icon cc-ebay ttip ttip-top"></span></li><?php }?>
	<?php if(in_array('google-checkout',$cc)){?><li><span rel="tooltip" data-placement="top" title="Google Checkout" class="cc-icon cc-google-checkout ttip ttip-top"></span></li><?php }?>
	<?php if(in_array('maestro',$cc)){?><li><span rel="tooltip" data-placement="top" title="Maestro" class="cc-icon cc-maestro ttip ttip-top"></span></li><?php }?>
	<?php if(in_array('mastercard',$cc)){?><li><span rel="tooltip" data-placement="top" title="Mastercard" class="cc-icon cc-mastercard ttip ttip-top"></span></li><?php }?>
	<?php if(in_array('moneybookers',$cc)){?><li><span rel="tooltip" data-placement="top" title="Moneybookers" class="cc-icon cc-moneybookers ttip ttip-top"></span></li><?php }?>
	<?php if(in_array('sagepay',$cc)){?><li><span rel="tooltip" data-placement="top" title="Sagepay" class="cc-icon cc-sagepay ttip ttip-top"></span></li><?php }?>
	<?php if(in_array('solo',$cc)){?><li><span rel="tooltip" data-placement="top" title="Solo" class="cc-icon cc-solo ttip ttip-top"></span></li><?php }?>
	<?php if(in_array('switch',$cc)){?><li><span rel="tooltip" data-placement="top" title="Switch" class="cc-icon cc-switch ttip ttip-top"></span></li><?php }?>
	<?php if(in_array('visa-electron',$cc)){?><li><span rel="tooltip" data-placement="top" title="Visa Electron" class="cc-icon cc-visa-electron ttip ttip-top"></span></li><?php }?>
	<?php if(in_array('visa',$cc)){?><li><span rel="tooltip" data-placement="top" title="Visa" class="cc-icon cc-visa ttip ttip-top"></span></li><?php }?>
	<?php if(in_array('western-union',$cc)){?><li><span rel="tooltip" data-placement="top" title="Western Union" class="cc-icon cc-western-union ttip ttip-top"></span></li><?php }?>
</ul>
<?php }?>