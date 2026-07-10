<?php
/**
 * "Recent Posts" — main column + sticky sidebar.
 *
 *   Main : two stacked cards (image / category / title / byline), then
 *          horizontal row cards (image left, text + excerpt + arrow right),
 *          then a full-width "More Posts" button.
 *   Aside: widget area (e.g. an ad box) + built-in Trending Posts, made sticky.
 *
 * @package SoundsLikeSydney2026
 */

$sls_recent = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 5,
		'offset'              => 6,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

if ( ! $sls_recent->have_posts() ) {
	wp_reset_postdata();
	return;
}

$sls_posts = $sls_recent->posts;
$sls_top   = array_slice( $sls_posts, 0, 2 ); // Two stacked cards.
$sls_rows  = array_slice( $sls_posts, 2 );    // Horizontal row cards.

$sls_more_url = get_option( 'page_for_posts' ) ? get_permalink( (int) get_option( 'page_for_posts' ) ) : home_url( '/' );

/** Featured image (or placeholder) for a post outside the loop. */
$sls_media = static function ( $post, $size ) {
	if ( has_post_thumbnail( $post->ID ) ) {
		echo get_the_post_thumbnail( $post->ID, $size, array( 'loading' => 'lazy' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		echo '<span class="sls-card__placeholder" aria-hidden="true"></span>';
	}
};

/** "by AUTHOR · date · comments" meta row. */
$sls_meta = static function ( $post ) {
	printf(
		'<span class="byline">%1$s <a href="%2$s">%3$s</a></span><span>%4$s</span>',
		esc_html_x( 'by', 'byline', 'soundslikesydney2026' ),
		esc_url( get_author_posts_url( (int) $post->post_author ) ),
		esc_html( get_the_author_meta( 'display_name', $post->post_author ) ),
		esc_html( get_the_date( '', $post ) )
	);
	sls2026_comment_badge( $post->ID );
};
?>
<section class="sls-section sls-recent" aria-label="<?php esc_attr_e( 'Recent posts', 'soundslikesydney2026' ); ?>">
	<div class="sls-container sls-recent__grid">

		<div class="sls-recent__main">
			<header class="sls-section__head">
				<h2 class="sls-section__title"><span><?php esc_html_e( 'Recent Posts', 'soundslikesydney2026' ); ?></span></h2>
				<p class="sls-section__sub"><?php esc_html_e( 'Stay up-to-date', 'soundslikesydney2026' ); ?></p>
			</header>

			<?php if ( $sls_top ) : ?>
				<div class="sls-recent__top">
					<?php foreach ( $sls_top as $sls_post ) : ?>
						<article class="sls-hcard">
							<a class="sls-hcard__media" href="<?php echo esc_url( get_permalink( $sls_post ) ); ?>" tabindex="-1" aria-hidden="true">
								<?php $sls_media( $sls_post, 'sls2026-feature' ); ?>
							</a>
							<div class="sls-hcard__body">
								<?php sls2026_primary_category( $sls_post->ID ); ?>
								<h3 class="sls-card__title">
									<a href="<?php echo esc_url( get_permalink( $sls_post ) ); ?>"><?php echo esc_html( get_the_title( $sls_post ) ); ?></a>
								</h3>
								<div class="sls-card__meta"><?php $sls_meta( $sls_post ); ?></div>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( $sls_rows ) : ?>
				<div class="sls-recent__rows">
					<?php foreach ( $sls_rows as $sls_post ) : ?>
						<article class="sls-card sls-card--row">
							<a class="sls-card__media" href="<?php echo esc_url( get_permalink( $sls_post ) ); ?>" tabindex="-1" aria-hidden="true">
								<?php $sls_media( $sls_post, 'sls2026-card' ); ?>
							</a>
							<div class="sls-card__body">
								<?php sls2026_primary_category( $sls_post->ID ); ?>
								<h3 class="sls-card__title">
									<a href="<?php echo esc_url( get_permalink( $sls_post ) ); ?>"><?php echo esc_html( get_the_title( $sls_post ) ); ?></a>
								</h3>
								<div class="sls-card__meta"><?php $sls_meta( $sls_post ); ?></div>
								<div class="sls-card__excerpt"><?php echo esc_html( get_the_excerpt( $sls_post ) ); ?></div>
								<a class="sls-card__more" href="<?php echo esc_url( get_permalink( $sls_post ) ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Read more: %s', 'soundslikesydney2026' ), get_the_title( $sls_post ) ) ); ?>">
									<span aria-hidden="true">&rarr;</span>
								</a>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<p class="sls-recent__more">
				<a class="sls-btn sls-btn--block" href="<?php echo esc_url( $sls_more_url ); ?>">
					<?php esc_html_e( 'More Posts', 'soundslikesydney2026' ); ?>
				</a>
			</p>
		</div>

		<aside class="sls-recent__aside" aria-label="<?php esc_attr_e( 'Sidebar', 'soundslikesydney2026' ); ?>">
			<div class="sls-sticky-aside">
				<?php get_template_part( 'template-parts/homepage/trending-posts' ); ?>
			</div>
		</aside>

	</div>
</section>
<?php
wp_reset_postdata();
