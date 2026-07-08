<?php
/**
 * Render callback for the "Featured Grid" ACF block.
 *
 * Bind an ACF field group to block type "sls2026/featured-grid" with:
 *   - heading      (text)
 *   - posts        (relationship / post object, multiple)
 *
 * Field group JSON belongs in /acf-json once you create it in the admin.
 * This template degrades gracefully if ACF or the fields are absent.
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (unused for ACF preview blocks).
 * @param bool   $is_preview True during editor preview rendering.
 * @param int    $post_id    The post ID this block is saved to.
 *
 * @package SoundsLikeSydney2026
 */

$sls_heading = sls2026_field( 'heading', false, __( 'Featured', 'soundslikesydney2026' ) );
$sls_posts   = sls2026_field( 'posts', false, array() );

// Editor fallback so the block isn't empty before it's configured.
if ( empty( $sls_posts ) && ! empty( $is_preview ) ) {
	$sls_posts = get_posts( array( 'numberposts' => 4 ) );
}

// Normalise: fields may return IDs or WP_Post objects.
$sls_posts = array_map(
	static function ( $p ) {
		return $p instanceof WP_Post ? $p : get_post( $p );
	},
	(array) $sls_posts
);
$sls_posts = array_filter( $sls_posts );

$sls_anchor  = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( $block['anchor'] ) . '"' : '';
$sls_classes = 'sls-section sls-block-featured-grid';
if ( ! empty( $block['className'] ) ) {
	$sls_classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$sls_classes .= ' align' . $block['align'];
}
?>
<section<?php echo $sls_anchor; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?> class="<?php echo esc_attr( $sls_classes ); ?>">
	<div class="sls-container">
		<?php if ( $sls_heading ) : ?>
			<header class="sls-section__head">
				<h2 class="sls-section__title"><span><?php echo esc_html( $sls_heading ); ?></span></h2>
			</header>
		<?php endif; ?>

		<?php if ( $sls_posts ) : ?>
			<div class="sls-latest__grid">
				<?php foreach ( $sls_posts as $sls_post ) : ?>
					<?php
					set_query_var( 'sls_card_post', $sls_post );
					set_query_var( 'sls_card_size', 'sls2026-card' );
					get_template_part( 'template-parts/content/card', 'stacked' );
					?>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p class="sls-block-empty"><?php esc_html_e( 'Select posts for this Featured Grid in the block settings.', 'soundslikesydney2026' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
wp_reset_postdata();
