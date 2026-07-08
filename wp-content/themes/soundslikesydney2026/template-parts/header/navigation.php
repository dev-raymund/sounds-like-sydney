<?php
/**
 * Primary navigation bar.
 *
 * @package SoundsLikeSydney2026
 */

?>
<nav id="site-navigation" class="sls-nav" aria-label="<?php esc_attr_e( 'Primary', 'soundslikesydney2026' ); ?>">
	<div class="sls-container">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'sls-nav__menu',
				'container'      => false,
				'fallback_cb'    => 'sls2026_primary_menu_fallback',
				'depth'          => 3,
			)
		);
		?>
	</div>
</nav>
