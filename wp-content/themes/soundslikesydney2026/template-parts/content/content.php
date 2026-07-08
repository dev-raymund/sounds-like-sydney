<?php
/**
 * Default loop item (archive / index), stacked card style.
 *
 * Runs inside The Loop, so it uses the global post.
 *
 * @package SoundsLikeSydney2026
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'sls-card sls-card--stacked' ); ?>>
	<?php sls2026_post_thumbnail( 'sls2026-card' ); ?>

	<div class="sls-card__body">
		<?php sls2026_primary_category(); ?>

		<?php the_title( '<h2 class="sls-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

		<?php sls2026_entry_meta(); ?>

		<?php
		$sls_deck = sls2026_field( 'deck' );
		if ( $sls_deck ) {
			echo '<p class="sls-card__deck">' . esc_html( $sls_deck ) . '</p>';
		} else {
			echo '<div class="sls-card__excerpt">';
			the_excerpt();
			echo '</div>';
		}
		?>
	</div>
</article>
