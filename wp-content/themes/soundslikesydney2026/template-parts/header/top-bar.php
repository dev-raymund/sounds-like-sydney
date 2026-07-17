<?php
/**
 * Header top bar: social icons (left) + optional top-bar menu (right).
 *
 * @package SoundsLikeSydney2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="sls-topbar">
	<div class="sls-container sls-topbar__inner">

		<div class="sls-topbar__social">
			<?php
			if ( has_nav_menu( 'social' ) ) {
				sls2026_social_links(
					array(
						'class'      => 'sls-social sls-social--topbar',
						'show_label' => false,
					)
				);
			}
			?>
		</div>

		<div class="sls-topbar__meta">
			<?php
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
						'fallback_cb'    => false,
						'depth'          => 1,
					)
				);
			}
			?>
		</div>

	</div>
</div>
