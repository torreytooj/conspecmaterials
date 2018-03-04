<?php 

require_once(ABSPATH .'/wp-admin/includes/plugin.php');

$wpml_switcher = ot_get_option('wpml_switcher');

?>

<?php if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {?>
	<?php if ($wpml_switcher){?>
		<div class="wpml-switcher">
			<?php language_selector_flags(); ?>
		</div>
	<?php }	?>
<?php }	?>
