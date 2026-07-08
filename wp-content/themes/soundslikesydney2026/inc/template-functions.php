<?php
/**
 * Template functions — filters and small behavioural tweaks.
 *
 * @package SoundsLikeSydney2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add helpful classes to <body>.
 *
 * @param array $classes Existing classes.
 * @return array
 */
function sls2026_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	if ( ! is_active_sidebar( 'sidebar-primary' ) ) {
		$classes[] = 'no-sidebar';
	}
	if ( sls2026_has_acf() ) {
		$classes[] = 'has-acf';
	}
	return $classes;
}
add_filter( 'body_class', 'sls2026_body_classes' );

/**
 * Add a pingback header on singular pages that allow pings.
 */
function sls2026_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'sls2026_pingback_header' );

/**
 * Custom excerpt length for card layouts.
 *
 * @param int $length Default word count.
 * @return int
 */
function sls2026_excerpt_length( $length ) {
	return is_admin() ? $length : 22;
}
add_filter( 'excerpt_length', 'sls2026_excerpt_length' );

/**
 * Custom excerpt "read more" ellipsis.
 *
 * @param string $more Default more string.
 * @return string
 */
function sls2026_excerpt_more( $more ) {
	return is_admin() ? $more : '&hellip;';
}
add_filter( 'excerpt_more', 'sls2026_excerpt_more' );

/**
 * Fallback menu shown when no primary menu is assigned.
 *
 * Keeps the header usable on a fresh install before menus are configured.
 */
function sls2026_primary_menu_fallback() {
	echo '<ul id="primary-menu" class="sls-nav__menu">';
	wp_list_pages(
		array(
			'title_li' => '',
			'depth'    => 1,
			'number'   => 6,
		)
	);
	echo '</ul>';
}
