<?php
/**
 * Single post body.
 *
 * @package SoundsLikeSydney2026
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'sls-single' ); ?>>

	<?php
	$sls_deck = sls2026_field( 'deck' );
	if ( $sls_deck ) {
		echo '<p class="sls-single__deck">' . esc_html( $sls_deck ) . '</p>';
	}
	?>

	<div class="sls-single__content entry-content sls-drop-cap">
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

		<div class="sls-single__engage">
			<button type="button" class="sls-like" data-like-key="post-<?php the_ID(); ?>" aria-pressed="false" aria-label="<?php esc_attr_e( 'Like this article', 'soundslikesydney2026' ); ?>">
				<svg class="sls-like__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21.2l7.7-7.7 1.1-1.1a5.5 5.5 0 0 0 0-7.8z"/></svg>
				<span class="sls-like__count">1</span>
			</button>

			<ul class="sls-share sls-share--compact sls-share__list">
				<li>
					<a class="sls-share__link" href="<?php echo esc_url( sls2026_share_url( 'facebook' ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on Facebook', 'soundslikesydney2026' ); ?>">
						<?php echo sls2026_social_icon_svg( 'https://facebook.com' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted SVG. ?>
					</a>
				</li>
				<li>
					<a class="sls-share__link" href="<?php echo esc_url( sls2026_share_url( 'x' ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Share on X', 'soundslikesydney2026' ); ?>">
						<?php echo sls2026_social_icon_svg( 'https://x.com' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted SVG. ?>
					</a>
				</li>
				<li>
					<button type="button" class="sls-share__link sls-share__copy" data-copy-url="<?php the_permalink(); ?>" aria-label="<?php esc_attr_e( 'Copy link', 'soundslikesydney2026' ); ?>">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
					</button>
				</li>
			</ul>
		</div>
	</footer>

	<?php
	$sls_author_bio = get_the_author_meta( 'description' );
	?>
	<div class="sls-author-box">
		<a class="sls-author-box__avatar" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 72 ); ?>
		</a>
		<div class="sls-author-box__body">
			<p class="sls-author-box__label"><?php esc_html_e( 'Written By', 'soundslikesydney2026' ); ?></p>
			<a class="sls-author-box__name" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a>
			<?php if ( $sls_author_bio ) : ?>
				<p class="sls-author-box__bio"><?php echo esc_html( $sls_author_bio ); ?></p>
			<?php endif; ?>
			<?php sls2026_social_links( array( 'class' => 'sls-author-box__social sls-social', 'show_label' => false ) ); ?>
		</div>
	</div>

</article>
