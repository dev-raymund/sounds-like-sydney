<?php
/**
 * Share-this-article icon row (Facebook, X, print, copy link).
 *
 * @package SoundsLikeSydney2026
 */

?>
<div class="sls-share">
	<h3 class="sls-share__title"><?php esc_html_e( 'Share This Article', 'soundslikesydney2026' ); ?></h3>
	<ul class="sls-share__list">
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
			<button type="button" class="sls-share__link sls-share__print" onclick="window.print()" aria-label="<?php esc_attr_e( 'Print this article', 'soundslikesydney2026' ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
			</button>
		</li>
		<li>
			<button type="button" class="sls-share__link sls-share__copy" data-copy-url="<?php the_permalink(); ?>" aria-label="<?php esc_attr_e( 'Copy link', 'soundslikesydney2026' ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
			</button>
		</li>
	</ul>
</div>
