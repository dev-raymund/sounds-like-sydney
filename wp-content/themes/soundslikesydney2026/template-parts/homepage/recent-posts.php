<?php
/**
 * "Recent Posts" — main column of cards + a sidebar (Trending Posts, ads).
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
?>
<section class="sls-section sls-recent" aria-label="<?php esc_attr_e( 'Recent posts', 'soundslikesydney2026' ); ?>">
	<div class="sls-container sls-recent__grid">

		<div class="sls-recent__main">
			<header class="sls-section__head">
				<h2 class="sls-section__title"><span><?php esc_html_e( 'Recent Posts', 'soundslikesydney2026' ); ?></span></h2>
				<p class="sls-section__sub"><?php esc_html_e( 'Stay up-to-date', 'soundslikesydney2026' ); ?></p>
			</header>

			<div class="sls-recent__list">
				<?php
				while ( $sls_recent->have_posts() ) :
					$sls_recent->the_post();
					get_template_part( 'template-parts/content/content', 'card' );
				endwhile;
				?>
			</div>

			<p class="sls-recent__more">
				<a class="sls-btn" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">
					<?php esc_html_e( 'More Posts', 'soundslikesydney2026' ); ?>
				</a>
			</p>
		</div>

		<?php get_sidebar(); ?>

	</div>
</section>
<?php
wp_reset_postdata();
