<?php
/**
 * Compact newsletter box for the single-post rail.
 *
 * Matches the reference: title, one-line intro, and a gold "Subscribe" button.
 * If a provider embed is configured it is shown; otherwise the button links to
 * the full newsletter form in the footer so the signup stays functional.
 *
 * @package SoundsLikeSydney2026
 */

$sls_newsletter_title = sls2026_option( 'newsletter_title', __( 'Newsletter', 'soundslikesydney2026' ) );
$sls_newsletter_sub   = sls2026_option( 'newsletter_sub', __( 'Get the latest stories in your inbox.', 'soundslikesydney2026' ) );
$sls_newsletter_embed = sls2026_option( 'newsletter_embed' );
?>
<div class="sls-rail-newsletter">
	<h3 class="sls-rail-newsletter__title"><?php echo esc_html( $sls_newsletter_title ); ?></h3>
	<?php if ( $sls_newsletter_embed ) : ?>
		<?php echo wp_kses_post( $sls_newsletter_embed ); ?>
	<?php else : ?>
		<p class="sls-rail-newsletter__sub"><?php echo esc_html( $sls_newsletter_sub ); ?></p>
		<a class="sls-rail-newsletter__btn" href="<?php echo esc_url( home_url( '/#sls-newsletter' ) ); ?>">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4 20-7z"/></svg>
			<?php esc_html_e( 'Subscribe', 'soundslikesydney2026' ); ?>
		</a>
	<?php endif; ?>
</div>
