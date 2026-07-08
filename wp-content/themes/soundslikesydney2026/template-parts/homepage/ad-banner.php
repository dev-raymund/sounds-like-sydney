<?php
/**
 * Ad / promo banner strip.
 *
 * Editors provide the markup (ad tag, image + link) via ACF option
 * 'ad_banner_html'. Renders nothing until configured, so it never shows an
 * empty box on a fresh install.
 *
 * @package SoundsLikeSydney2026
 */

$sls_ad = sls2026_option( 'ad_banner_html' );

if ( empty( $sls_ad ) ) {
	return;
}
?>
<section class="sls-section sls-adbanner" aria-label="<?php esc_attr_e( 'Advertisement', 'soundslikesydney2026' ); ?>">
	<div class="sls-container sls-adbanner__inner">
		<?php echo wp_kses_post( $sls_ad ); ?>
	</div>
</section>
