<?php

$navigation_font_style = ot_get_option('navigation_font_style');
$dropdown_font_style = ot_get_option('dropdown_font_style');

?>

<div class="header-menu">
	<nav class="navbar" role="navigation">
		<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
		  <span class="sr-only"><?php _e('Toggle navigation', GETTEXT_DOMAIN); ?></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</button>
		<span class="navbar-brand visible-xs"><?php _e('Navigation', GETTEXT_DOMAIN); ?></span>
		</div>
		<div class="collapse navbar-collapse navbar-ex1-collapse <?php if ($dropdown_font_style=="bold") { ?>dd-bold-font<?php } ?> <?php if ($navigation_font_style=="bold") { ?>bold-font<?php } ?> animation-dd">
			<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
			<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'nav navbar-nav', 'container' => '', 'walker' => new lpd_bootstrap_nav_menu_walker() ) ); ?>
			<?php } else { ?>
			<ul class="nav navbar-nav">
			<?php wp_list_pages( array('title_li' => '', 'menu_class' => '', 'walker' => new lpd_bootstrap_list_pages_walker() )); ?>
			</ul>
			<?php } ?>
		</div>
	</nav>
</div>