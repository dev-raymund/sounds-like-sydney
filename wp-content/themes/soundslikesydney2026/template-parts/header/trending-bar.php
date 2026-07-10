<?php
/**
 * "Trending" ticker: a labelled, horizontally-scrollable row of headlines
 * with prev/next arrows (progressively enhanced into a slider by main.js).
 *
 * Source priority:
 *   1. ACF option 'trending_posts' (relationship / post object) — editor curated.
 *   2. Fallback: the latest published posts.
 *
 * The arrows are output hidden and revealed by JS only when the row overflows,
 * so with JS off the row is still swipeable/scrollable and no dead controls show.
 *
 * @package SoundsLikeSydney2026
 */

// Prefer a curated ACF list; fall back to recent posts. Pull enough to slide.
$sls_trending = sls2026_option( 'trending_posts' );

if ( empty( $sls_trending ) ) {
	$sls_trending = get_posts(
		array(
			'numberposts'      => 8,
			'post_status'      => 'publish',
			'suppress_filters' => false,
		)
	);
}

if ( empty( $sls_trending ) ) {
	return;
}
?>
<div class="sls-trending" data-trending>
	<div class="sls-container sls-trending__inner">
		<span class="sls-trending__label"><?php esc_html_e( 'Trending', 'soundslikesydney2026' ); ?></span>

		<ul class="sls-trending__list">
			<?php foreach ( $sls_trending as $sls_post ) : ?>
				<li>
					<a href="<?php echo esc_url( get_permalink( $sls_post ) ); ?>">
						<?php echo esc_html( get_the_title( $sls_post ) ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>

		<div class="sls-trending__nav">
			<button type="button" class="sls-trending__arrow" data-trending-dir="prev" aria-label="<?php esc_attr_e( 'Previous trending stories', 'soundslikesydney2026' ); ?>" hidden>&larr;</button>
			<button type="button" class="sls-trending__arrow" data-trending-dir="next" aria-label="<?php esc_attr_e( 'Next trending stories', 'soundslikesydney2026' ); ?>" hidden>&rarr;</button>
		</div>
	</div>
</div>
<?php
wp_reset_postdata();
