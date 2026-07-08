<?php
/**
 * Custom search form.
 *
 * Used both inline (404, no-results) and inside the header search overlay.
 * The overlay-specific look is layered on in CSS via .sls-search-panel.
 *
 * @package SoundsLikeSydney2026
 */

$sls_id = 'sls-search-' . wp_unique_id();
?>
<form role="search" method="get" class="sls-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $sls_id ); ?>">
		<?php esc_html_e( 'Search for:', 'soundslikesydney2026' ); ?>
	</label>
	<input
		type="search"
		id="<?php echo esc_attr( $sls_id ); ?>"
		class="sls-search-field"
		placeholder="<?php esc_attr_e( 'Type here and hit enter', 'soundslikesydney2026' ); ?>"
		value="<?php echo get_search_query(); ?>"
		name="s"
		autocomplete="off"
	/>
	<button type="submit" class="sls-search-submit sls-search-submit--icon">
		<span class="screen-reader-text"><?php esc_html_e( 'Search', 'soundslikesydney2026' ); ?></span>
		<span class="sls-search-submit__icon" aria-hidden="true"></span>
	</button>
</form>
