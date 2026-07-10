<?php
/**
 * Sidebar "Trending Posts" — numbered circular thumbnails + title/meta.
 *
 * Source: most-commented posts, falling back to recent. Rendered inside the
 * sticky sidebar of the Recent Posts section.
 *
 * @package SoundsLikeSydney2026
 */

$sls_tp = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 4,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'orderby'             => 'comment_count',
		'order'               => 'DESC',
	)
);

if ( ! $sls_tp->have_posts() ) {
	wp_reset_postdata();
	return;
}
?>
<section class="widget sls-trending-posts">
	<h3 class="widget-title widget-title--center"><span><?php esc_html_e( 'Trending Posts', 'soundslikesydney2026' ); ?></span></h3>
	<span class="sls-tposts__deco" aria-hidden="true">&times; &times; &times;</span>

	<ol class="sls-tposts">
		<?php
		$sls_n = 0;
		while ( $sls_tp->have_posts() ) :
			$sls_tp->the_post();
			$sls_n++;
			?>
			<li class="sls-tposts__item">
				<a class="sls-tposts__thumb" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
					<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'sls2026-thumb', array( 'loading' => 'lazy' ) );
					} else {
						echo '<span class="sls-card__placeholder" aria-hidden="true"></span>';
					}
					?>
					<span class="sls-tposts__num"><?php echo esc_html( number_format_i18n( $sls_n ) ); ?></span>
				</a>
				<div class="sls-tposts__body">
					<h4 class="sls-card__title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h4>
					<div class="sls-card__meta">
						<span><?php echo esc_html( get_the_date() ); ?></span>
						<?php sls2026_comment_badge( get_the_ID() ); ?>
					</div>
				</div>
			</li>
		<?php endwhile; ?>
	</ol>
</section>
<?php
wp_reset_postdata();
