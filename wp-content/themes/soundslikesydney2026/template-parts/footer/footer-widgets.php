<?php
/**
 * Footer top: brand logo · Categories · Links · Newsletter.
 *
 * The two middle columns use the footer-1 / footer-2 widget areas when filled,
 * and fall back to a category list / footer menu so the footer matches the
 * reference out of the box.
 *
 * @package SoundsLikeSydney2026
 */

$sls_newsletter_title = sls2026_option( 'newsletter_title', __( 'Newsletter', 'soundslikesydney2026' ) );
$sls_newsletter_embed = sls2026_option( 'newsletter_embed' ); // Raw provider markup.
?>
<div class="sls-footer-top">
	<div class="sls-container sls-footer-top__inner">

		<div class="sls-footer-brand">
			<?php
			if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
				the_custom_logo();
			} else {
				printf(
					'<a class="site-title site-title--footer" href="%1$s" rel="home">%2$s</a>',
					esc_url( home_url( '/' ) ),
					esc_html( get_bloginfo( 'name' ) )
				);
			}
			?>
		</div>

		<div class="sls-footer-col">
			<?php
			if ( is_active_sidebar( 'footer-1' ) ) {
				dynamic_sidebar( 'footer-1' );
			} else {
				echo '<h3 class="widget-title"><span>' . esc_html__( 'Categories', 'soundslikesydney2026' ) . '</span></h3>';
				echo '<ul class="sls-footer-list">';
				wp_list_categories(
					array(
						'title_li' => '',
						'number'   => 5,
						'orderby'  => 'count',
						'order'    => 'DESC',
					)
				);
				echo '</ul>';
			}
			?>
		</div>

		<div class="sls-footer-col">
			<?php
			if ( is_active_sidebar( 'footer-2' ) ) {
				dynamic_sidebar( 'footer-2' );
			} else {
				echo '<h3 class="widget-title"><span>' . esc_html__( 'Links', 'soundslikesydney2026' ) . '</span></h3>';
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'menu_class'     => 'sls-footer-list',
							'container'      => false,
							'depth'          => 1,
						)
					);
				} else {
					echo '<ul class="sls-footer-list">';
					wp_list_pages( array( 'title_li' => '', 'number' => 5 ) );
					echo '</ul>';
				}
			}
			?>
		</div>

		<div class="sls-footer-newsletter">
			<h3 class="widget-title"><span><?php echo esc_html( $sls_newsletter_title ); ?></span></h3>
			<?php
			if ( $sls_newsletter_embed ) {
				echo wp_kses_post( $sls_newsletter_embed );
			} else {
				?>
				<form class="sls-newsletter-form" action="#" method="post" novalidate>
					<div class="sls-newsletter-field">
						<label class="screen-reader-text" for="sls-newsletter-email">
							<?php esc_html_e( 'Email address', 'soundslikesydney2026' ); ?>
						</label>
						<input id="sls-newsletter-email" type="email" name="email" placeholder="<?php esc_attr_e( 'Enter Your Email', 'soundslikesydney2026' ); ?>" required>
						<button type="submit" class="sls-newsletter-submit">
							<span class="sls-newsletter-submit__icon" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4 20-7z"/></svg>
							</span>
							<span class="sls-newsletter-submit__text"><?php esc_html_e( 'Subscribe', 'soundslikesydney2026' ); ?></span>
						</button>
					</div>
					<label class="sls-newsletter-agree">
						<input type="checkbox" name="agree" required>
						<span><?php esc_html_e( 'I agree that my submitted data is being collected and stored.', 'soundslikesydney2026' ); ?></span>
					</label>
				</form>
				<?php
			}
			?>
		</div>

	</div>
</div>
