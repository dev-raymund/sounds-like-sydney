<?php
/**
 * "Editor's Choice — Trending Articles": one large feature + a mini list.
 *
 * @package SoundsLikeSydney2026
 */

$sls_trend = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 5,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'orderby'             => 'comment_count',
		'order'               => 'DESC',
	)
);

if ( ! $sls_trend->have_posts() ) {
	wp_reset_postdata();
	return;
}

$sls_trend_posts = $sls_trend->posts;
$sls_trend_lead  = array_shift( $sls_trend_posts );
?>
<section class="sls-section sls-trend" aria-label="<?php esc_attr_e( 'Trending articles', 'soundslikesydney2026' ); ?>">
	<div class="sls-container">

		<header class="sls-section__head">
			<h2 class="sls-section__title"><span><?php esc_html_e( "Editor's Choice", 'soundslikesydney2026' ); ?></span></h2>
			<p class="sls-section__sub"><?php esc_html_e( 'Trending Articles', 'soundslikesydney2026' ); ?></p>
		</header>

		<div class="sls-trend__grid">

			<div class="sls-trend__lead">
				<?php
				set_query_var( 'sls_card_post', $sls_trend_lead );
				set_query_var( 'sls_card_size', 'sls2026-hero' );
				get_template_part( 'template-parts/content/card', 'overlay' );
				?>
			</div>

			<ul class="sls-trend__list">
				<?php foreach ( $sls_trend_posts as $sls_post ) : ?>
					<li>
						<?php
						set_query_var( 'sls_card_post', $sls_post );
						set_query_var( 'sls_card_size', 'sls2026-thumb' );
						get_template_part( 'template-parts/content/card', 'mini' );
						?>
					</li>
				<?php endforeach; ?>
			</ul>

		</div>
	</div>
</section>
<?php
wp_reset_postdata();
