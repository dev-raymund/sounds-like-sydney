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
					'style'       => 'ol',
					'short_ping'  => true,
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

	<?php
	comment_form(
		array(
			'class_form'         => 'comment-form sls-comment-form',
			'class_submit'       => 'submit sls-comment-form__submit',
			'title_reply'        => esc_html__( 'Leave a comment', 'soundslikesydney2026' ),
			/* translators: %s: comment author name. */
			'title_reply_to'     => esc_html__( 'Reply to %s', 'soundslikesydney2026' ),
			'cancel_reply_link'  => esc_html__( 'Cancel reply', 'soundslikesydney2026' ),
			'label_submit'       => esc_html__( 'Post comment', 'soundslikesydney2026' ),
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h2>',
			'comment_field'      => sprintf(
				'<p class="comment-form-comment"><label for="comment">%1$s <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="6" maxlength="65525" required="required" placeholder="%2$s"></textarea></p>',
				esc_html__( 'Comment', 'soundslikesydney2026' ),
				esc_attr__( 'Share your thoughts on this story&hellip;', 'soundslikesydney2026' )
			),
		)
	);
	?>

</div>
