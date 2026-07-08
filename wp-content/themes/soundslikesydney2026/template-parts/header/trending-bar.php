<?php
/**
 * "Trending" ticker: a labelled row of the latest / most-relevant headlines.
 *
 * Default source: 3 most recent posts. When ACF is present you can instead
 * curate them via an Options-page relationship field ('trending_posts').
 *
 * @package SoundsLikeSydney2026
 */

// Prefer a curated ACF list; fall back to most-recent posts.
$sls_trending = sls2026_option( 'trending_posts' );

if ( empty( $sls_trending ) ) {
	$sls_trending = get_posts(
		array(
			'numberposts'      => 3,
			'post_status'      => 'publish',
			'suppress_filters' => false,
		)
	);
}

if ( empty( $sls_trending ) ) {
	return;
}
?>
<div class="sls-trending">
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
	</div>
</div>
<?php
wp_reset_postdata();
