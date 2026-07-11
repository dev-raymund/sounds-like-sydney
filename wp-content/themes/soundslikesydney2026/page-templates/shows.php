<?php
/**
 * Template Name: Shows
 *
 * Shows — upcoming events from The Events Calendar, rendered in the site's own
 * style (hero + event rows) with a link out to TEC's full List/Month/Day
 * calendar. Free TEC has no calendar-embed shortcode, so the list is a themed
 * WP_Query over `tribe_events` using TEC's template tags for dates/venues.
 *
 * Assign to a page via Page Attributes → Template ("Shows").
 *
 * @package SoundsLikeSydney2026
 */

get_header();

$sls_page_id  = get_queried_object_id();
$sls_per_page = 10;
$sls_paged    = isset( $_GET['paged'] ) ? max( 1, absint( wp_unslash( $_GET['paged'] ) ) ) : 1; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

// Upcoming, published events ordered by start date.
$sls_events = new WP_Query(
	array(
		'post_type'      => 'tribe_events',
		'post_status'    => 'publish',
		'posts_per_page' => $sls_per_page,
		'paged'          => $sls_paged,
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

$sls_archive = function_exists( 'tribe_get_events_link' ) ? tribe_get_events_link() : home_url( '/events/' );
$sls_total   = (int) $sls_events->found_posts;
?>

<main id="primary" class="site-main sls-shows">

	<?php
	set_query_var( 'sls_hero_kicker', get_the_title( $sls_page_id ) );
	set_query_var( 'sls_hero_tagline', __( 'Upcoming concerts &amp; performances.', 'soundslikesydney2026' ) );
	set_query_var( 'sls_hero_label', get_the_title( $sls_page_id ) );
	set_query_var( 'sls_hero_heading', 'h1' );
	get_template_part( 'template-parts/page-hero' );
	?>

	<div class="sls-container sls-listing">

		<div class="sls-listing__toolbar">
			<p class="sls-listing__count">
				<?php
				echo esc_html(
					$sls_total
						/* translators: %s: number of upcoming shows. */
						? sprintf( _n( '%s upcoming show', '%s upcoming shows', $sls_total, 'soundslikesydney2026' ), number_format_i18n( $sls_total ) )
						: __( 'No upcoming shows', 'soundslikesydney2026' )
				);
				?>
			</p>
			<a class="sls-btn" href="<?php echo esc_url( $sls_archive ); ?>"><?php esc_html_e( 'View full calendar', 'soundslikesydney2026' ); ?></a>
		</div>

		<?php if ( $sls_events->have_posts() ) : ?>

			<ul class="sls-shows__list">
				<?php
				while ( $sls_events->have_posts() ) :
					$sls_events->the_post();
					$sls_id     = get_the_ID();
					$sls_allday = function_exists( 'tribe_event_is_all_day' ) && tribe_event_is_all_day( $sls_id );
					$sls_when   = $sls_allday
						? tribe_get_start_date( $sls_id, false, 'F j, Y' )
						: tribe_get_start_date( $sls_id, true, 'F j @ g:i a' );
					$sls_venue  = tribe_get_venue( $sls_id );
					$sls_addr   = implode(
						', ',
						array_filter(
							array(
								tribe_get_address( $sls_id ),
								tribe_get_city( $sls_id ),
								tribe_get_region( $sls_id ),
								tribe_get_country( $sls_id ),
							)
						)
					);
					?>
					<li class="sls-show">
						<div class="sls-show__date" aria-hidden="true">
							<span class="sls-show__dow"><?php echo esc_html( tribe_get_start_date( $sls_id, false, 'D' ) ); ?></span>
							<span class="sls-show__day"><?php echo esc_html( tribe_get_start_date( $sls_id, false, 'j' ) ); ?></span>
							<span class="sls-show__mon"><?php echo esc_html( tribe_get_start_date( $sls_id, false, 'M' ) ); ?></span>
						</div>

						<div class="sls-show__body">
							<p class="sls-show__when"><?php echo esc_html( $sls_when ); ?></p>
							<h2 class="sls-show__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
							<?php if ( $sls_venue ) : ?>
								<p class="sls-show__where">
									<strong><?php echo esc_html( $sls_venue ); ?></strong>
									<?php if ( $sls_addr ) : ?><span><?php echo esc_html( $sls_addr ); ?></span><?php endif; ?>
								</p>
							<?php endif; ?>
							<div class="sls-show__excerpt"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 28 ) ); ?></div>
						</div>

						<a class="sls-show__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
							<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'sls2026-card', array( 'loading' => 'lazy' ) );
							} else {
								echo '<span class="sls-card__placeholder"></span>';
							}
							?>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>

			<?php
			$sls_base = esc_url_raw( remove_query_arg( 'paged' ) );
			$sls_glue = ( false === strpos( $sls_base, '?' ) ) ? '?' : '&';
			$sls_links = paginate_links(
				array(
					'base'      => $sls_base . $sls_glue . 'paged=%#%',
					'format'    => '',
					'current'   => $sls_paged,
					'total'     => (int) $sls_events->max_num_pages,
					'mid_size'  => 1,
					'end_size'  => 1,
					'prev_text' => '&lsaquo;',
					'next_text' => '&rsaquo;',
					'type'      => 'plain',
				)
			);
			if ( $sls_links ) {
				echo '<nav class="pagination" aria-label="' . esc_attr__( 'Shows pagination', 'soundslikesydney2026' ) . '">' . $sls_links . '</nav>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- paginate_links() escapes each link.
			}
			?>

		<?php else : ?>

			<div class="sls-shows__empty">
				<p><?php esc_html_e( 'No upcoming shows are scheduled right now.', 'soundslikesydney2026' ); ?></p>
				<a class="sls-btn sls-btn--accent" href="<?php echo esc_url( $sls_archive ); ?>"><?php esc_html_e( 'Browse the full calendar', 'soundslikesydney2026' ); ?></a>
			</div>

		<?php endif; ?>

	</div>

</main>

<?php
wp_reset_postdata();
get_footer();
