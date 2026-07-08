<?php
/**
 * Footer widget area: brand column + up to four widget columns, with an
 * optional newsletter block sourced from ACF options.
 *
 * @package SoundsLikeSydney2026
 */

$sls_has_widgets = is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' )
	|| is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' );

$sls_newsletter_title = sls2026_option( 'newsletter_title', __( 'Newsletter', 'soundslikesydney2026' ) );
$sls_newsletter_text  = sls2026_option( 'newsletter_text', __( 'Sign up for the latest from Sounds Like Sydney.', 'soundslikesydney2026' ) );
$sls_newsletter_embed = sls2026_option( 'newsletter_embed' ); // Raw form HTML from a provider.
?>
<div class="sls-footer-top">
	<div class="sls-container sls-footer-top__inner">

		<div class="sls-footer-brand">
			<?php
			if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
				the_custom_logo();
			} else {
				printf(
					'<span class="site-title site-title--footer">%s</span>',
					esc_html( get_bloginfo( 'name' ) )
				);
			}
			$sls_footer_about = sls2026_option( 'footer_about', get_bloginfo( 'description' ) );
			if ( $sls_footer_about ) {
				echo '<p class="sls-footer-brand__about">' . esc_html( $sls_footer_about ) . '</p>';
			}
			?>
		</div>

		<?php if ( $sls_has_widgets ) : ?>
			<div class="sls-footer-cols">
				<?php for ( $sls_i = 1; $sls_i <= 4; $sls_i++ ) : ?>
					<?php if ( is_active_sidebar( 'footer-' . $sls_i ) ) : ?>
						<div class="sls-footer-col sls-footer-col--<?php echo (int) $sls_i; ?>">
							<?php dynamic_sidebar( 'footer-' . $sls_i ); ?>
						</div>
					<?php endif; ?>
				<?php endfor; ?>
			</div>
		<?php endif; ?>

		<div class="sls-footer-newsletter">
			<h3 class="widget-title"><span><?php echo esc_html( $sls_newsletter_title ); ?></span></h3>
			<?php if ( $sls_newsletter_text ) : ?>
				<p class="sls-footer-newsletter__text"><?php echo esc_html( $sls_newsletter_text ); ?></p>
			<?php endif; ?>
			<?php
			if ( $sls_newsletter_embed ) {
				// Provider-supplied markup (Mailchimp, etc.). Editors control this via ACF.
				echo wp_kses_post( $sls_newsletter_embed );
			} else {
				?>
				<form class="sls-newsletter-form" action="#" method="post" novalidate>
					<label class="screen-reader-text" for="sls-newsletter-email">
						<?php esc_html_e( 'Email address', 'soundslikesydney2026' ); ?>
					</label>
					<input id="sls-newsletter-email" type="email" name="email" placeholder="<?php esc_attr_e( 'Enter your email', 'soundslikesydney2026' ); ?>" required>
					<button type="submit"><?php esc_html_e( 'Subscribe', 'soundslikesydney2026' ); ?></button>
				</form>
				<?php
			}
			?>
		</div>

	</div>
</div>
