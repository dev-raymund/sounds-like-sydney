<?php
/**
 * Card variant: small thumbnail beside a headline (lists / playlists).
 *
 * Expects query vars:
 *   sls_card_post — WP_Post object.
 *   sls_card_size — registered image size (default sls2026-thumb).
 *   sls_card_play — bool, show a play badge over the thumb (video lists).
 *
 * @package SoundsLikeSydney2026
 */

$sls_post = get_query_var( 'sls_card_post' );
if ( ! $sls_post instanceof WP_Post ) {
	return;
}
$sls_size = get_query_var( 'sls_card_size' ) ? get_query_var( 'sls_card_size' ) : 'sls2026-thumb';
$sls_play = (bool) get_query_var( 'sls_card_play' );
$sls_id   = $sls_post->ID;
?>
<article class="sls-card sls-card--mini<?php echo $sls_play ? ' sls-card--play' : ''; ?>">
	<a class="sls-card__media" href="<?php echo esc_url( get_permalink( $sls_id ) ); ?>" tabindex="-1" aria-hidden="true">
		<?php
		if ( has_post_thumbnail( $sls_id ) ) {
			echo get_the_post_thumbnail( $sls_id, $sls_size, array( 'loading' => 'lazy' ) );
		} else {
			echo '<span class="sls-card__placeholder" aria-hidden="true"></span>';
		}
		if ( $sls_play ) {
			echo '<span class="sls-card__play-icon" aria-hidden="true"></span>';
		}
		?>
	</a>
	<div class="sls-card__body">
		<?php sls2026_primary_category( $sls_id ); ?>
		<h4 class="sls-card__title">
			<a href="<?php echo esc_url( get_permalink( $sls_id ) ); ?>"><?php echo esc_html( get_the_title( $sls_id ) ); ?></a>
		</h4>
	</div>
</article>
