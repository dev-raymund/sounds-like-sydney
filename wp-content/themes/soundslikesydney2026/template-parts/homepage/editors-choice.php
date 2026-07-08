<?php
/**
 * "Editor's Choice" — a numbered row of five featured cards.
 *
 * Source: ACF option 'editors_choice' (curated) → posts in a chosen
 * category → latest posts.
 *
 * @package SoundsLikeSydney2026
 */

$sls_ec = sls2026_option( 'editors_choice' );

if ( empty( $sls_ec ) ) {
	$sls_ec = get_posts(
		array(
			'numberposts'      => 5,
			'offset'           => 1,
			'post_status'      => 'publish',
			'suppress_filters' => false,
		)
	);
}

if ( empty( $sls_ec ) ) {
	return;
}

$sls_ec = array_slice( (array) $sls_ec, 0, 5 );
?>
<section class="sls-section sls-editors" aria-label="<?php esc_attr_e( "Editor's Choice", 'soundslikesydney2026' ); ?>">
	<div class="sls-container">

		<header class="sls-section__head">
			<h2 class="sls-section__title"><span><?php esc_html_e( "Editor's Choice", 'soundslikesydney2026' ); ?></span></h2>
			<p class="sls-section__sub"><?php esc_html_e( 'Featured Articles', 'soundslikesydney2026' ); ?></p>
		</header>

		<ol class="sls-editors__grid">
			<?php
			$sls_n = 0;
			foreach ( $sls_ec as $sls_post ) :
				$sls_n++;
				?>
				<li class="sls-editors__item">
					<span class="sls-editors__num"><?php echo esc_html( $sls_n ); ?></span>
					<?php
					set_query_var( 'sls_card_post', $sls_post );
					set_query_var( 'sls_card_size', 'sls2026-feature' );
					get_template_part( 'template-parts/content/card', 'stacked' );
					?>
				</li>
			<?php endforeach; ?>
		</ol>

	</div>
</section>
<?php
wp_reset_postdata();
