<?php
/**
 * Theme setup: supports, navigation menus, image sizes, content width.
 *
 * @package SoundsLikeSydney2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme features on after_setup_theme.
 */
function sls2026_setup() {
	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Featured images — core to a magazine layout.
	add_theme_support( 'post-thumbnails' );

	// Feed links, HTML5 markup, responsive embeds, wide/full alignment.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'custom-line-height' );
	add_theme_support( 'editor-styles' );

	// Custom logo — used in the header branding area.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 48,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Selective refresh so widgets update live in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Navigation menus mirrored from the reference design.
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'soundslikesydney2026' ),
			'top-bar' => __( 'Top Bar Menu', 'soundslikesydney2026' ),
			'footer'  => __( 'Footer Menu', 'soundslikesydney2026' ),
			'social'  => __( 'Social Links Menu', 'soundslikesydney2026' ),
		)
	);

	// Image sizes for the various card slots in the homepage grid.
	add_image_size( 'sls2026-hero', 820, 560, true );        // Big hero feature.
	add_image_size( 'sls2026-feature', 400, 300, true );     // Secondary features.
	add_image_size( 'sls2026-card', 520, 340, true );        // Recent/latest cards.
	add_image_size( 'sls2026-thumb', 120, 90, true );        // Trending list thumbs.

	// Load translations from /languages.
	load_theme_textdomain( 'soundslikesydney2026', SLS2026_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'sls2026_setup' );

/**
 * Set the content width in pixels.
 */
function sls2026_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'sls2026_content_width', 820 );
}
add_action( 'after_setup_theme', 'sls2026_content_width', 0 );

/**
 * Human-readable labels for the extra image sizes (shows them in the media UI).
 *
 * @param array $sizes Existing named sizes.
 * @return array
 */
function sls2026_custom_image_size_names( $sizes ) {
	return array_merge(
		$sizes,
		array(
			'sls2026-hero'    => __( 'SLS Hero', 'soundslikesydney2026' ),
			'sls2026-feature' => __( 'SLS Feature', 'soundslikesydney2026' ),
			'sls2026-card'    => __( 'SLS Card', 'soundslikesydney2026' ),
		)
	);
}
add_filter( 'image_size_names_choose', 'sls2026_custom_image_size_names' );
