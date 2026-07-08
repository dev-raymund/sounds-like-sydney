<?php
/**
 * Card variant: image on top, kicker + title + meta below (grid cards).
 *
 * Expects query vars:
 *   sls_card_post — WP_Post object.
 *   sls_card_size — registered image size (default sls2026-card).
 *
 * @package SoundsLikeSydney2026
 */

$sls_post = get_query_var( 'sls_card_post' );
if ( ! $sls_post instanceof WP_Post ) {
	return;
}
$sls_size = get_query_var( 'sls_card_size' ) ? get_query_var( 'sls_card_size' ) : 'sls2026-card';
$sls_id   = $sls_post->ID;
?>
<article class="sls-card sls-card--stacked">
	<a class="sls-card__media" href="<?php echo esc_url( get_permalink( $sls_id ) ); ?>" tabindex="-1" aria-hidden="true">
		<?php
		if ( has_post_thumbnail( $sls_id ) ) {
			echo get_the_post_thumbnail( $sls_id, $sls_size, array( 'loading' => 'lazy' ) );
		} else {
			echo '<span class="sls-card__placeholder" aria-hidden="true"></span>';
		}
		?>
	</a>
	<div class="sls-card__body">
		<?php sls2026_primary_category( $sls_id ); ?>
		<h3 class="sls-card__title">
			<a href="<?php echo esc_url( get_permalink( $sls_id ) ); ?>"><?php echo esc_html( get_the_title( $sls_id ) ); ?></a>
		</h3>
		<div class="sls-card__meta">
			<?php echo esc_html( get_the_date( '', $sls_id ) ); ?>
		</div>
	</div>
</article>
