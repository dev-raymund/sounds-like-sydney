<?php
/**
 * "Latest Posts" — a four-across row of cards.
 *
 * @package SoundsLikeSydney2026
 */

$sls_latest = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 4,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

if ( ! $sls_latest->have_posts() ) {
	wp_reset_postdata();
	return;
}
?>
<section class="sls-section sls-latest" aria-label="<?php esc_attr_e( 'Latest posts', 'soundslikesydney2026' ); ?>">
	<div class="sls-container">

		<header class="sls-section__head">
			<h2 class="sls-section__title"><span><?php esc_html_e( 'Latest Posts', 'soundslikesydney2026' ); ?></span></h2>
			<p class="sls-section__sub"><?php esc_html_e( 'Featured Articles', 'soundslikesydney2026' ); ?></p>
		</header>

		<div class="sls-latest__grid">
			<?php
			while ( $sls_latest->have_posts() ) :
				$sls_latest->the_post();
				set_query_var( 'sls_card_post', get_post() );
				set_query_var( 'sls_card_size', 'sls2026-card' );
				get_template_part( 'template-parts/content/card', 'stacked' );
			endwhile;
			?>
		</div>

	</div>
</section>
<?php
wp_reset_postdata();
