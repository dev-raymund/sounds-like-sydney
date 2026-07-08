<?php
/**
 * Footer bottom bar: copyright + footer menu + social.
 *
 * @package SoundsLikeSydney2026
 */

$sls_copyright = sls2026_option( 'footer_copyright' );
?>
<div class="sls-footer-bottom">
	<div class="sls-container sls-footer-bottom__inner">

		<p class="sls-footer-copyright">
			<?php
			if ( $sls_copyright ) {
				echo esc_html( $sls_copyright );
			} else {
				printf(
					/* translators: 1: year, 2: site name. */
					esc_html__( '&copy; %1$s %2$s. All rights reserved.', 'soundslikesydney2026' ),
					esc_html( gmdate( 'Y' ) ),
					esc_html( get_bloginfo( 'name' ) )
				);
			}
			?>
		</p>

		<?php
		if ( has_nav_menu( 'footer' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'menu_class'     => 'sls-footer-menu',
					'container'      => 'nav',
					'container_class' => 'sls-footer-nav',
					'depth'          => 1,
				)
			);
		}

		if ( has_nav_menu( 'social' ) ) {
			wp_nav_menu(
				array(
					'theme_location'  => 'social',
					'menu_class'      => 'sls-social-menu sls-social-menu--footer',
					'container'       => 'div',
					'container_class' => 'sls-footer-social',
					'depth'           => 1,
					'link_before'     => '<span class="screen-reader-text">',
					'link_after'      => '</span>',
				)
			);
		}
		?>

	</div>
</div>
