<?php
/**
 * Single post body.
 *
 * @package SoundsLikeSydney2026
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'sls-single' ); ?>>

	<header class="sls-single__header">
		<?php sls2026_primary_category(); ?>
		<?php the_title( '<h1 class="sls-single__title">', '</h1>' ); ?>

		<?php
		$sls_deck = sls2026_field( 'deck' );
		if ( $sls_deck ) {
			echo '<p class="sls-single__deck">' . esc_html( $sls_deck ) . '</p>';
		}
		?>

		<div class="sls-single__meta">
			<?php
			sls2026_posted_by();
			echo ' <span class="meta-sep">&middot;</span> ';
			sls2026_posted_on();
			printf(
				' <span class="meta-sep">&middot;</span> <span class="reading-time">%s</span>',
				esc_html(
					sprintf(
						/* translators: %d: minutes. */
						_n( '%d min read', '%d min read', sls2026_reading_time(), 'soundslikesydney2026' ),
						sls2026_reading_time()
					)
				)
			);
			?>
		</div>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="sls-single__media">
			<?php the_post_thumbnail( 'sls2026-hero' ); ?>
			<?php
			$sls_caption = get_the_post_thumbnail_caption();
			if ( $sls_caption ) {
				echo '<figcaption>' . esc_html( $sls_caption ) . '</figcaption>';
			}
			?>
		</figure>
	<?php endif; ?>

	<div class="sls-single__content entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'soundslikesydney2026' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<footer class="sls-single__footer">
		<?php
		$sls_tags = get_the_tag_list( '<ul class="sls-tags"><li>', '</li><li>', '</li></ul>' );
		if ( $sls_tags ) {
			echo wp_kses_post( $sls_tags );
		}
		?>
	</footer>

</article>
