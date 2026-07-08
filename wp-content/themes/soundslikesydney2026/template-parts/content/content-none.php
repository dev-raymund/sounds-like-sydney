<?php
/**
 * Shown when a query returns no results.
 *
 * @package SoundsLikeSydney2026
 */

?>
<section class="sls-noresults">
	<header class="sls-noresults__head">
		<h1 class="page-title"><?php esc_html_e( 'Nothing found', 'soundslikesydney2026' ); ?></h1>
	</header>

	<div class="sls-noresults__body">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p>
				<?php
				printf(
					wp_kses(
						/* translators: %s: URL to the new-post screen. */
						__( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'soundslikesydney2026' ),
						array( 'a' => array( 'href' => array() ) )
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, nothing matched your search. Try again with different keywords.', 'soundslikesydney2026' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'soundslikesydney2026' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div>
</section>
