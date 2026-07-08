<?php
/**
 * Single page body.
 *
 * @package SoundsLikeSydney2026
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'sls-page' ); ?>>

	<header class="sls-page__header">
		<?php the_title( '<h1 class="sls-page__title">', '</h1>' ); ?>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="sls-page__media"><?php the_post_thumbnail( 'sls2026-hero' ); ?></figure>
	<?php endif; ?>

	<div class="sls-page__content entry-content">
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

</article>
