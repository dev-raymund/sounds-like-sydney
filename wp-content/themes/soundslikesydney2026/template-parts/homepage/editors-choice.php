<?php
/**
 * "Editor's Choice" — a numbered row of five featured cards.
 *
 * Source: ACF option 'editors_choice' (curated) → posts in a chosen
 * category → latest posts.
 *
 * @package SoundsLikeSydney2026
 */

$sls_ec = sls2026_option( 'editors_choice' );

if ( empty( $sls_ec ) ) {
	$sls_ec = get_posts(
		array(
			'numberposts'      => 5,
			'offset'           => 1,
			'post_status'      => 'publish',
			'suppress_filters' => false,
		)
	);
}

if ( empty( $sls_ec ) ) {
	return;
}

// Normalise to WP_Post objects (ACF may return IDs).
$sls_ec = array_map(
	static function ( $p ) {
		return $p instanceof WP_Post ? $p : get_post( $p );
	},
	(array) $sls_ec
);
$sls_ec = array_slice( array_values( array_filter( $sls_ec ) ), 0, 5 );
?>
<section class="sls-section sls-editors" aria-label="<?php esc_attr_e( "Editor's Choice", 'soundslikesydney2026' ); ?>">
	<div class="sls-container">

		<header class="sls-section__head">
			<h2 class="sls-section__title"><span><?php esc_html_e( "Editor's Choice", 'soundslikesydney2026' ); ?></span></h2>
			<p class="sls-section__sub"><?php esc_html_e( 'Featured Articles', 'soundslikesydney2026' ); ?></p>
		</header>

		<ol class="sls-editors__grid">
			<?php
			$sls_n = 0;
			foreach ( $sls_ec as $sls_post ) :
				$sls_n++;
				?>
				<li class="sls-editors__item">
					<a class="sls-editors__media" href="<?php echo esc_url( get_permalink( $sls_post ) ); ?>" tabindex="-1" aria-hidden="true">
						<?php
						if ( has_post_thumbnail( $sls_post->ID ) ) {
							echo get_the_post_thumbnail( $sls_post->ID, 'sls2026-feature', array( 'loading' => 'lazy' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						} else {
							echo '<span class="sls-card__placeholder" aria-hidden="true"></span>';
						}
						?>
					</a>
					<div class="sls-editors__meta">
						<span class="sls-editors__num"><?php echo esc_html( number_format_i18n( $sls_n ) ); ?></span>
						<div class="sls-editors__text">
							<?php sls2026_primary_category( $sls_post->ID ); ?>
							<h3 class="sls-card__title">
								<a href="<?php echo esc_url( get_permalink( $sls_post ) ); ?>"><?php echo esc_html( get_the_title( $sls_post ) ); ?></a>
							</h3>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>

	</div>
</section>
<?php
wp_reset_postdata();
