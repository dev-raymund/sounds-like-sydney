<?php
/**
 * Site branding: custom logo or serif wordmark, centred like the reference.
 *
 * @package SoundsLikeSydney2026
 */

?>
<div class="sls-branding">
	<div class="sls-container sls-branding__inner">

		<button class="sls-nav-toggle" aria-controls="primary-menu" aria-expanded="false">
			<span class="sls-nav-toggle__bars" aria-hidden="true"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'soundslikesydney2026' ); ?></span>
		</button>

		<div class="sls-branding__logo">
			<?php
			if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
				the_custom_logo();
			} else {
				$sls_tag = ( is_front_page() && is_home() ) ? 'h1' : 'p';
				printf(
					'<%1$s class="site-title"><a href="%2$s" rel="home">%3$s</a></%1$s>',
					esc_attr( $sls_tag ),
					esc_url( home_url( '/' ) ),
					esc_html( get_bloginfo( 'name' ) )
				);
			}
			?>
		</div>

		<button class="sls-search-toggle" aria-controls="sls-search-panel" aria-expanded="false">
			<span class="sls-search-toggle__icon" aria-hidden="true"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Search', 'soundslikesydney2026' ); ?></span>
		</button>

	</div>

	<div id="sls-search-panel" class="sls-search-panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Search', 'soundslikesydney2026' ); ?>" hidden>
		<div class="sls-search-panel__inner">
			<?php get_search_form(); ?>
		</div>
		<button type="button" class="sls-search-close" aria-label="<?php esc_attr_e( 'Close search', 'soundslikesydney2026' ); ?>">
			<span class="sls-search-close__icon" aria-hidden="true"></span>
		</button>
	</div>
</div>
