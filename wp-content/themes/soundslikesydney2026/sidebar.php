<?php
/**
 * Primary sidebar (Trending Posts, ad slots, widgets).
 *
 * @package SoundsLikeSydney2026
 */

if ( ! is_active_sidebar( 'sidebar-primary' ) ) {
	return;
}
?>
<aside id="secondary" class="widget-area sls-sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'soundslikesydney2026' ); ?>">
	<?php dynamic_sidebar( 'sidebar-primary' ); ?>
</aside>
