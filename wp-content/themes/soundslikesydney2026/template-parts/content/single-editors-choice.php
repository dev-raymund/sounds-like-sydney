<?php
/**
 * Single: "Editor's Choice — Articles Of The Day".
 *
 * A four-across row of stacked cards below the article, closed by a "More
 * Posts" button.
 *
 * Source: the curated ACF option 'editors_choice' (shared with the homepage
 * section) → latest posts. The post being read is always excluded, and the
 * curated list is topped up from recent posts if it can't fill the row.
 *
 * @package SoundsLikeSydney2026
 */

$sls_current = (int) get_the_ID();

// Normalise the curated picks to WP_Post objects (ACF may return IDs).
$sls_picks = array_filter(
	array_map(
		static function ( $p ) {
			return $p instanceof WP_Post ? $p : get_post( $p );
		},
		(array) sls2026_option( 'editors_choice' )
	)
);

// Never point back at the post being read.
$sls_picks = array_filter(
	$sls_picks,
	static function ( $p ) use ( $sls_current ) {
		return (int) $p->ID !== $sls_current;
	}
);

// Top up from recent posts if the curated list is short (or absent).
if ( count( $sls_picks ) < 4 ) {
	$sls_seen = array_map(
		static function ( $p ) {
			return (int) $p->ID;
		},
		$sls_picks
	);

	$sls_picks = array_merge(
		$sls_picks,
		get_posts(
			array(
				'numberposts'      => 4 - count( $sls_picks ),
				'post_status'      => 'publish',
				'exclude'          => array_merge( array( $sls_current ), $sls_seen ),
				'suppress_filters' => false,
			)
		)
	);
}

$sls_picks = array_slice( array_values( $sls_picks ), 0, 4 );

if ( empty( $sls_picks ) ) {
	return;
}

$sls_more_url = get_option( 'page_for_posts' ) ? get_permalink( (int) get_option( 'page_for_posts' ) ) : home_url( '/' );
?>
<section class="sls-section sls-single-editors" aria-label="<?php esc_attr_e( "Editor's Choice", 'soundslikesydney2026' ); ?>">
	<div class="sls-container">

		<header class="sls-section__head sls-section__head--center">
			<h2 class="sls-section__title"><span><?php esc_html_e( "Editor's Choice", 'soundslikesydney2026' ); ?></span></h2>
			<p class="sls-section__sub"><?php esc_html_e( 'Articles Of The Day', 'soundslikesydney2026' ); ?></p>
		</header>

		<div class="sls-single-editors__grid">
			<?php foreach ( $sls_picks as $sls_post ) : ?>
				<article class="sls-card sls-card--stacked">
					<a class="sls-card__media" href="<?php echo esc_url( get_permalink( $sls_post ) ); ?>" tabindex="-1" aria-hidden="true">
						<?php
						if ( has_post_thumbnail( $sls_post->ID ) ) {
							echo get_the_post_thumbnail( $sls_post->ID, 'sls2026-card', array( 'loading' => 'lazy' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						} else {
							echo '<span class="sls-card__placeholder" aria-hidden="true"></span>';
						}
						?>
					</a>
					<div class="sls-card__body">
						<?php sls2026_category_list( $sls_post->ID, 2 ); ?>
						<h3 class="sls-card__title">
							<a href="<?php echo esc_url( get_permalink( $sls_post ) ); ?>"><?php echo esc_html( get_the_title( $sls_post ) ); ?></a>
						</h3>
						<div class="sls-card__meta">
							<span><?php echo esc_html( get_the_date( '', $sls_post ) ); ?></span>
							<?php sls2026_comment_badge( $sls_post->ID ); ?>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

		<p class="sls-single-editors__more">
			<a class="sls-btn sls-btn--accent" href="<?php echo esc_url( $sls_more_url ); ?>">
				<?php esc_html_e( 'More Posts', 'soundslikesydney2026' ); ?>
			</a>
		</p>

	</div>
</section>
