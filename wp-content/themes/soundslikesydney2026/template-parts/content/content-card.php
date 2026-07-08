<?php
/**
 * Horizontal card (image left, text right) — used by the Recent Posts column.
 *
 * Runs inside The Loop.
 *
 * @package SoundsLikeSydney2026
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'sls-card sls-card--row' ); ?>>
	<?php sls2026_post_thumbnail( 'sls2026-card' ); ?>

	<div class="sls-card__body">
		<?php sls2026_primary_category(); ?>

		<?php the_title( '<h3 class="sls-card__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>

		<?php sls2026_entry_meta(); ?>

		<div class="sls-card__excerpt"><?php the_excerpt(); ?></div>

		<a class="sls-card__more" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Read more: %s', 'soundslikesydney2026' ), get_the_title() ) ); ?>">
			<span aria-hidden="true">&rarr;</span>
		</a>
	</div>
</article>
