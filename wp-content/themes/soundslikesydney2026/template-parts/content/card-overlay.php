<?php
/**
 * Card variant: full-bleed image with the headline overlaid (hero / feature).
 *
 * Expects query vars:
 *   sls_card_post — WP_Post object.
 *   sls_card_size — registered image size (default sls2026-feature).
 *
 * @package SoundsLikeSydney2026
 */

$sls_post = get_query_var( 'sls_card_post' );
if ( ! $sls_post instanceof WP_Post ) {
	return;
}
$sls_size = get_query_var( 'sls_card_size' ) ? get_query_var( 'sls_card_size' ) : 'sls2026-feature';
$sls_id   = $sls_post->ID;
?>
<article class="sls-card sls-card--overlay">
	<a class="sls-card__media" href="<?php echo esc_url( get_permalink( $sls_id ) ); ?>" aria-hidden="true" tabindex="-1">
		<?php
		if ( has_post_thumbnail( $sls_id ) ) {
			echo get_the_post_thumbnail( $sls_id, $sls_size, array( 'loading' => 'lazy' ) );
		} else {
			echo '<span class="sls-card__placeholder" aria-hidden="true"></span>';
		}
		?>
	</a>
	<div class="sls-card__overlay">
		<?php sls2026_primary_category( $sls_id ); ?>
		<h3 class="sls-card__title">
			<a href="<?php echo esc_url( get_permalink( $sls_id ) ); ?>"><?php echo esc_html( get_the_title( $sls_id ) ); ?></a>
		</h3>
		<div class="sls-card__meta">
			<?php
			printf(
				/* translators: 1: author name, 2: date. */
				esc_html_x( 'by %1$s', 'card byline', 'soundslikesydney2026' ),
				esc_html( get_the_author_meta( 'display_name', $sls_post->post_author ) )
			);
			echo ' <span class="meta-sep">&middot;</span> ';
			echo esc_html( get_the_date( '', $sls_id ) );
			?>
		</div>
	</div>
</article>
