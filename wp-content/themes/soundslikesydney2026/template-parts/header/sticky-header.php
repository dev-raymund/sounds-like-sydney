<?php
/**
 * Compact sticky header — slides in on scroll (toggled by navigation.js).
 *
 * Layout mirrors the reference: logo left · primary menu centre · search right.
 * Only a search control on the right (this theme has no account/cart).
 *
 * @package SoundsLikeSydney2026
 */

?>
<div class="sls-sticky-header" data-sticky-header>
	<div class="sls-container sls-sticky-header__inner">

		<div class="sls-sticky-header__logo">
			<?php
			if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
				the_custom_logo();
			} else {
				printf(
					'<a class="site-title site-title--sticky" href="%1$s" rel="home">%2$s</a>',
					esc_url( home_url( '/' ) ),
					esc_html( get_bloginfo( 'name' ) )
				);
			}
			?>
		</div>

		<nav class="sls-sticky-header__nav" aria-label="<?php esc_attr_e( 'Primary (sticky)', 'soundslikesydney2026' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_class'     => 'sls-sticky-nav__menu',
					'container'      => false,
					'fallback_cb'    => false,
					'depth'          => 1,
				)
			);
			?>
		</nav>

		<button class="sls-search-toggle sls-search-toggle--sticky" aria-controls="sls-search-panel" aria-expanded="false">
			<span class="sls-search-toggle__icon" aria-hidden="true"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Search', 'soundslikesydney2026' ); ?></span>
		</button>

	</div>
</div>
