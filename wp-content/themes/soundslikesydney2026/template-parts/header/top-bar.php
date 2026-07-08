<?php
/**
 * Header top bar: social icons (left) + optional top-bar menu (right).
 *
 * ACF: social links can later come from an Options-page repeater
 * (sls2026_option('social_links')). Falls back to the 'social' nav menu.
 *
 * @package SoundsLikeSydney2026
 */

?>
<div class="sls-topbar">
	<div class="sls-container sls-topbar__inner">

		<div class="sls-topbar__social">
			<?php
			if ( has_nav_menu( 'social' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'social',
						'menu_class'     => 'sls-social-menu',
						'container'      => false,
						'depth'          => 1,
						'link_before'    => '<span class="screen-reader-text">',
						'link_after'     => '</span>',
					)
				);
			}
			?>
		</div>

		<div class="sls-topbar__meta">
			<?php
			// Optional short tagline from ACF options.
			$sls_topbar_text = sls2026_option( 'topbar_text' );
			if ( $sls_topbar_text ) {
				echo '<span class="sls-topbar__note">' . esc_html( $sls_topbar_text ) . '</span>';
			}

			if ( has_nav_menu( 'top-bar' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'top-bar',
						'menu_class'     => 'sls-topbar__menu',
						'container'      => false,
						'depth'          => 1,
					)
				);
			}
			?>
		</div>

	</div>
</div>
