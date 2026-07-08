<?php
/**
 * Comments template.
 *
 * @package SoundsLikeSydney2026
 */

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="sls-comments">

	<?php if ( have_comments() ) : ?>
		<h2 class="sls-comments__title">
			<?php
			$sls_count = get_comments_number();
			printf(
				/* translators: 1: comment count, 2: post title. */
				esc_html( _n( '%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $sls_count, 'soundslikesydney2026' ) ),
				esc_html( number_format_i18n( $sls_count ) ),
				'<span>' . esc_html( get_the_title() ) . '</span>'
			);
			?>
		</h2>

		<ol class="sls-comments__list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation(
			array(
				'prev_text' => esc_html__( 'Older comments', 'soundslikesydney2026' ),
				'next_text' => esc_html__( 'Newer comments', 'soundslikesydney2026' ),
			)
		);
		?>

		<?php if ( ! comments_open() ) : ?>
			<p class="sls-comments__closed"><?php esc_html_e( 'Comments are closed.', 'soundslikesydney2026' ); ?></p>
		<?php endif; ?>

	<?php endif; ?>

	<?php comment_form(); ?>

</div>
