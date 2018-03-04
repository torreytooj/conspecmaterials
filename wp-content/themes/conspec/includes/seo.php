<?php

$disable_seo = ot_get_option('disable_seo');
$keywords = ot_get_option('keywords');
$description = ot_get_option('description');

?>

<?php if($disable_seo != 'Disable') {
    if($keywords):
	?>
		
	<?php
	endif;

	if($description):
	?>
		
	<?php
	endif;
}?>