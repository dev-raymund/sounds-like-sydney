<?php
/**
 * Homepage hero.
 *
 * Layout: two stacked features (left) + one large feature (centre) +
 * a "Featured" list (right), mirroring the reference design.
 *
 * Data source priority:
 *   1. ACF option 'hero_posts' (relationship / post object) — curated.
 *   2. Posts flagged is_featured = true.
 *   3. Latest posts.
 *
 * @package SoundsLikeSydney2026
 */

// --- Resolve the pool of hero posts ------------------------------------
$sls_hero = sls2026_option( 'hero_posts' );

if ( empty( $sls_hero ) ) {
	$sls_hero = get_posts(
		array(
			'numberposts'      => 8,
			'post_status'      => 'publish',
			'suppress_filters' => false,
			// Prefer featured posts when the ACF meta exists; harmless otherwise.
			'meta_query'       => array(
				'relation' => 'OR',
				array(
					'key'     => 'is_featured',
					'value'   => '1',
					'compare' => '=',
				),
				array(
					'key'     => 'is_featured',
					'compare' => 'NOT EXISTS',
				),
			),
		)
	);
}

if ( empty( $sls_hero ) ) {
	return;
}

// Split the pool into slots.
$sls_lead      = array_shift( $sls_hero );                 // Big centre feature.
$sls_secondary = array_slice( $sls_hero, 0, 2 );           // Two stacked left.
$sls_list      = array_slice( $sls_hero, 2, 5 );           // Right-hand list.
?>
<section class="sls-section sls-hero" aria-label="<?php esc_attr_e( 'Featured stories', 'soundslikesydney2026' ); ?>">
	<div class="sls-container sls-hero__grid">

		<div class="sls-hero__side">
			<?php foreach ( $sls_secondary as $sls_post ) : ?>
				<?php
				set_query_var( 'sls_card_post', $sls_post );
				set_query_var( 'sls_card_size', 'sls2026-feature' );
				get_template_part( 'template-parts/content/card', 'overlay' );
				?>
			<?php endforeach; ?>
		</div>

		<div class="sls-hero__lead">
			<?php
			set_query_var( 'sls_card_post', $sls_lead );
			set_query_var( 'sls_card_size', 'sls2026-hero' );
			get_template_part( 'template-parts/content/card', 'overlay' );
			?>
		</div>

		<div class="sls-hero__list">
			<h2 class="sls-section__title"><span><?php esc_html_e( 'Featured', 'soundslikesydney2026' ); ?></span></h2>
			<ul class="sls-hlist">
				<?php foreach ( $sls_list as $sls_post ) : ?>
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
