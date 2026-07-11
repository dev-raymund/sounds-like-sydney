<?php
/**
 * Template Name: Contact
 *
 * Contact page — a full-bleed hero over a two-column layout: a short intro on
 * the left and the Contact Form 7 form on the right. Falls back gracefully if
 * CF7 is deactivated.
 *
 * Assign to a page via Page Attributes → Template ("Contact").
 *
 * @package SoundsLikeSydney2026
 */

get_header();

$sls_page_id = get_queried_object_id();

// Contact Form 7 form (default "Contact form 1"), referenced by its hash id.
$sls_cf7_hash    = 'e72ce68e16530e7fc708517c9d30db03c8ed3ef32b17d4d1b6cb71be638d5801';
$sls_privacy_url = function_exists( 'get_privacy_policy_url' ) ? get_privacy_policy_url() : '';
?>

<main id="primary" class="site-main sls-contact">

	<?php
	set_query_var( 'sls_hero_kicker', get_the_title( $sls_page_id ) );
	set_query_var( 'sls_hero_tagline', __( 'Get in touch.', 'soundslikesydney2026' ) );
	set_query_var( 'sls_hero_label', get_the_title( $sls_page_id ) );
	set_query_var( 'sls_hero_heading', 'h1' );
	get_template_part( 'template-parts/page-hero' );
	?>

	<div class="sls-container sls-contact__body">
		<div class="sls-contact__grid">

			<aside class="sls-contact__intro">
				<p class="entry-kicker"><?php esc_html_e( 'Say hello', 'soundslikesydney2026' ); ?></p>
				<h2 class="sls-contact__title"><?php esc_html_e( 'We’d love to hear from you', 'soundslikesydney2026' ); ?></h2>
				<p>Enter your details to contact <strong>Sounds Like Sydney</strong>. Whether it’s an editorial enquiry, a tip about what’s happening in Sydney’s music scene, or feedback on a review — we read every message.</p>

				<ul class="sls-contact__points">
					<li><?php esc_html_e( 'Editorial enquiries, story tips and interview requests.', 'soundslikesydney2026' ); ?></li>
					<li><?php esc_html_e( 'Always independent — we take no fee for content or reviews.', 'soundslikesydney2026' ); ?></li>
					<li><?php esc_html_e( 'Fields marked with * are required.', 'soundslikesydney2026' ); ?></li>
				</ul>

				<?php if ( $sls_privacy_url ) : ?>
					<p class="sls-contact__fineprint">
						<?php
						printf(
							/* translators: %s: privacy policy link. */
							esc_html__( 'We handle your details in line with our %s.', 'soundslikesydney2026' ),
							'<a href="' . esc_url( $sls_privacy_url ) . '">' . esc_html__( 'Privacy Policy', 'soundslikesydney2026' ) . '</a>'
						);
						?>
					</p>
				<?php endif; ?>
			</aside>

			<div class="sls-contact__form">
				<?php
				if ( function_exists( 'wpcf7_contact_form' ) ) {
					echo do_shortcode( '[contact-form-7 id="' . esc_attr( $sls_cf7_hash ) . '" title="Contact"]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CF7 returns trusted, escaped markup.
				} else {
					echo '<p>' . esc_html__( 'The contact form is currently unavailable — please try again shortly.', 'soundslikesydney2026' ) . '</p>';
				}
				?>
			</div>

		</div>
	</div>

</main>

<?php
get_footer();
