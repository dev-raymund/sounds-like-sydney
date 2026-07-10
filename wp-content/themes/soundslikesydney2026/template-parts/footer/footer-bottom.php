<?php
/**
 * Footer bottom bar: copyright (brand in accent) + labelled social icons.
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
					/* translators: 1: site name (accented), 2: year. */
					wp_kses(
						__( '<span class="sls-footer-copyright__brand">%1$s</span> &copy; %2$s. All Rights Reserved.', 'soundslikesydney2026' ),
						array( 'span' => array( 'class' => array() ) )
					),
					esc_html( get_bloginfo( 'name' ) ),
					esc_html( gmdate( 'Y' ) )
				);
			}
			?>
		</p>

		<?php
		if ( has_nav_menu( 'social' ) ) {
			sls2026_social_links(
				array(
					'class'      => 'sls-social sls-social--footer',
					'show_label' => true,
				)
			);
		}
		?>

	</div>
</div>
