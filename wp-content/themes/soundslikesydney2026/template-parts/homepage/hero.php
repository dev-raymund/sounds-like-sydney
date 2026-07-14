<?php
/**
 * Homepage hero — three columns, text always OUTSIDE the image (no overlays):
 *
 *   Left   : two stacked cards  (image, then category / headline / date + comments).
 *   Centre : one lead feature   (large image, then category / headline / excerpt / byline).
 *   Right  : five compact items (category + headline on the left, thumbnail on the right).
 *
 * Data source: ACF option 'hero_posts' (curated) → featured posts → latest.
 *
 * @package SoundsLikeSydney2026
 */

$sls_hero = sls2026_option( 'hero_posts' );

if ( empty( $sls_hero ) ) {
	$sls_hero = get_posts(
		array(
			'numberposts'      => 8,
			'post_status'      => 'publish',
			'suppress_filters' => false,
		)
	);
}

if ( empty( $sls_hero ) ) {
	return;
}

// Normalise to WP_Post objects (ACF may return IDs).
$sls_hero = array_map(
	static function ( $p ) {
		return $p instanceof WP_Post ? $p : get_post( $p );
	},
	(array) $sls_hero
);
$sls_hero = array_values( array_filter( $sls_hero ) );

$sls_lead  = array_shift( $sls_hero );            // Centre lead.
$sls_left  = array_slice( $sls_hero, 0, 2 );      // Two stacked, left.
$sls_right = array_slice( $sls_hero, 2, 5 );      // Five compact, right.

if ( ! $sls_lead ) {
	return;
}

/**
 * Render a featured image (or placeholder) for a post not in the loop.
 *
 * @param WP_Post $post Post object.
 * @param string  $size Image size.
 */
$sls_media = static function ( $post, $size ) {
	if ( has_post_thumbnail( $post->ID ) ) {
		echo get_the_post_thumbnail( $post->ID, $size, array( 'loading' => 'lazy' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		echo '<span class="sls-card__placeholder" aria-hidden="true"></span>';
	}
};
?>
<section class="sls-section sls-hero" aria-label="<?php esc_attr_e( 'Featured stories', 'soundslikesydney2026' ); ?>">
	<div class="sls-container sls-hero__grid">

		<!-- Left: two stacked cards -->
		<div class="sls-hero__side">
			<?php foreach ( $sls_left as $sls_post ) : ?>
				<article class="sls-hcard">
					<a class="sls-hcard__media" href="<?php echo esc_url( get_permalink( $sls_post ) ); ?>" tabindex="-1" aria-hidden="true">
						<?php $sls_media( $sls_post, 'sls2026-feature' ); ?>
					</a>
					<div class="sls-hcard__body">
						<?php sls2026_category_list( $sls_post->ID, 1 ); ?>
						<h3 class="sls-hcard__title">
							<a href="<?php echo esc_url( get_permalink( $sls_post ) ); ?>"><?php echo esc_html( get_the_title( $sls_post ) ); ?></a>
						</h3>
						<div class="sls-hcard__meta">
							<span><?php echo esc_html( get_the_date( '', $sls_post ) ); ?></span>
							<?php sls2026_comment_badge( $sls_post->ID ); ?>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

		<!-- Centre: lead feature -->
		<article class="sls-hero__lead sls-hlead">
			<a class="sls-hlead__media" href="<?php echo esc_url( get_permalink( $sls_lead ) ); ?>" tabindex="-1" aria-hidden="true">
				<?php $sls_media( $sls_lead, 'sls2026-hero' ); ?>
			</a>
			<div class="sls-hlead__body">
				<?php sls2026_category_list( $sls_lead->ID, 1 ); ?>
				<h2 class="sls-hlead__title">
					<a href="<?php echo esc_url( get_permalink( $sls_lead ) ); ?>"><?php echo esc_html( get_the_title( $sls_lead ) ); ?></a>
				</h2>
				<p class="sls-hlead__excerpt"><?php echo esc_html( get_the_excerpt( $sls_lead ) ); ?></p>
				<div class="sls-hlead__meta">
					<span class="byline">
						<?php echo esc_html_x( 'by', 'byline', 'soundslikesydney2026' ); ?>
						<a class="author" href="<?php echo esc_url( get_author_posts_url( (int) $sls_lead->post_author ) ); ?>">
							<?php echo esc_html( get_the_author_meta( 'display_name', $sls_lead->post_author ) ); ?>
						</a>
					</span>
					<span><?php echo esc_html( get_the_date( '', $sls_lead ) ); ?></span>
					<?php sls2026_comment_badge( $sls_lead->ID ); ?>
				</div>
			</div>
		</article>

		<!-- Right: upcoming events (falls back to compact posts) -->
		<?php
		$sls_ev = array();
		if ( post_type_exists( 'tribe_events' ) ) {
			$sls_ev = get_posts(
				array(
					'post_type'      => 'tribe_events',
					'post_status'    => 'publish',
					'posts_per_page' => 5,
					'meta_key'       => '_EventStartDate', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
					'orderby'        => 'meta_value',
					'order'          => 'ASC',
					'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
						array(
							'key'     => '_EventStartDate',
							'value'   => current_time( 'Y-m-d H:i:s' ),
							'compare' => '>=',
							'type'    => 'DATETIME',
						),
					),
				)
			);
		}
		?>
		<?php if ( $sls_ev ) : ?>
			<aside class="sls-hero__events" aria-label="<?php esc_attr_e( 'Upcoming events', 'soundslikesydney2026' ); ?>">
				<h3 class="sls-hero__events-title"><?php esc_html_e( 'Upcoming Events', 'soundslikesydney2026' ); ?></h3>
				<ul class="sls-hevents">
					<?php
					foreach ( $sls_ev as $sls_event ) :
						$sls_eid    = $sls_event->ID;
						$sls_allday = function_exists( 'tribe_event_is_all_day' ) && tribe_event_is_all_day( $sls_eid );
						$sls_link   = get_permalink( $sls_eid );
						?>
						<li class="sls-hevent">
							<a class="sls-hevent__date" href="<?php echo esc_url( $sls_link ); ?>" tabindex="-1" aria-hidden="true">
								<span class="sls-hevent__dow"><?php echo esc_html( tribe_get_start_date( $sls_eid, false, 'D' ) ); ?></span>
								<span class="sls-hevent__day"><?php echo esc_html( tribe_get_start_date( $sls_eid, false, 'j' ) ); ?></span>
								<span class="sls-hevent__mon"><?php echo esc_html( tribe_get_start_date( $sls_eid, false, 'M' ) ); ?></span>
							</a>
							<div class="sls-hevent__body">
								<span class="sls-hevent__time"><?php echo esc_html( $sls_allday ? __( 'All day', 'soundslikesydney2026' ) : tribe_get_start_date( $sls_eid, false, 'g:i a' ) ); ?></span>
								<h4 class="sls-hevent__title"><a href="<?php echo esc_url( $sls_link ); ?>"><?php echo esc_html( get_the_title( $sls_eid ) ); ?></a></h4>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
				<?php if ( function_exists( 'tribe_get_events_link' ) ) : ?>
					<a class="sls-hevents__more" href="<?php echo esc_url( tribe_get_events_link() ); ?>"><?php esc_html_e( 'View Calendar', 'soundslikesydney2026' ); ?></a>
				<?php endif; ?>
			</aside>
		<?php else : ?>
			<ul class="sls-hero__list">
				<?php foreach ( $sls_right as $sls_post ) : ?>
					<li>
						<div class="sls-hitem__body">
							<?php sls2026_category_list( $sls_post->ID, 2 ); ?>
							<h4 class="sls-hitem__title">
								<a href="<?php echo esc_url( get_permalink( $sls_post ) ); ?>"><?php echo esc_html( get_the_title( $sls_post ) ); ?></a>
							</h4>
						</div>
						<a class="sls-hitem__thumb" href="<?php echo esc_url( get_permalink( $sls_post ) ); ?>" tabindex="-1" aria-hidden="true">
							<?php $sls_media( $sls_post, 'sls2026-thumb' ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

	</div>
</section>
<?php
wp_reset_postdata();
