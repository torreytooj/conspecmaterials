<?php 
    $st_javascript = ot_get_option('st_javascript');
    $st_javascript_p = ot_get_option('st_javascript_p');
?>

<div id="footer">
	<?php if ( is_active_sidebar(7)||is_active_sidebar(2) ){?>
	<div class="footer-top">
		<div class="container">
			<div class="row">
			<?php if ( is_active_sidebar(7) ){?>
				<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Top 3 Column') ) ?>
			<?php } else{?>
				<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Top') ) ?>
			<?php } ?>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php get_template_part('includes/footer-meta') ?>
	<?php if ( is_active_sidebar(8)||is_active_sidebar(3) ){?>
	<div class="footer">
		<div class="container">
			<div class="row">
			<?php if ( is_active_sidebar(8) ){?>
				<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 3 Column') ) ?>
			<?php } else{?>
				<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer') ) ?>
			<?php } ?>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php get_template_part('includes/footer-logo' ) ?>
					<div class="footer-m-copyright">
					<?php get_template_part('includes/copyright' ) ?>
					<?php if ( has_nav_menu( 'footer-menu' ) ) {?>
					<?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'menu_class' => 'footer-menu', 'container' => '', 'depth' => 1  ) ); ?>
					<?php } ?>
					</div>	
				</div>
				<div class="col-md-6">
					<?php get_template_part('includes/payment-method') ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_template_part('includes/custom_css') ?>
<?php get_template_part('includes/custom_js') ?>

<?php if (is_singular()) {?>
<!-- sharethis buttons -->
	<?php if ($st_javascript) {?>
		<?php echo $st_javascript;?>
	<?php } ?>
<?php } ?>

<?php if (is_singular('portfolio')) {?>
<!-- sharethis buttons -->
	<?php if ($st_javascript_p) {?>
		<?php echo $st_javascript_p;?>
	<?php } ?>
<?php } ?>
    
<?php wp_footer(); ?>
 
</body>
</html>