<?php
/**
 * Enqueue front-end and editor assets.
 *
 * @package SoundsLikeSydney2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front-end styles and scripts.
 */
function sls2026_enqueue_assets() {
	// Main stylesheet (the real design lives here; style.css is just the header + fallback tokens).
	wp_enqueue_style(
		'sls2026-main',
		SLS2026_URI . '/assets/css/main.css',
		array(),
		SLS2026_VERSION
	);

	// Required root stylesheet so WordPress recognises theme metadata; loaded after main.
	wp_enqueue_style(
		'sls2026-style',
		get_stylesheet_uri(),
		array( 'sls2026-main' ),
		SLS2026_VERSION
	);

	// Navigation / interaction JS, deferred, no jQuery dependency.
	wp_enqueue_script(
		'sls2026-navigation',
		SLS2026_URI . '/assets/js/navigation.js',
		array(),
		SLS2026_VERSION,
		true
	);

	wp_enqueue_script(
		'sls2026-main',
		SLS2026_URI . '/assets/js/main.js',
		array(),
		SLS2026_VERSION,
		true
	);

	// Threaded comments where enabled.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'sls2026_enqueue_assets' );

/**
 * Match the block editor to the front-end so ACF Blocks preview accurately.
 */
function sls2026_enqueue_editor_assets() {
	wp_enqueue_style(
		'sls2026-editor',
		SLS2026_URI . '/assets/css/editor.css',
		array(),
		SLS2026_VERSION
	);
}
add_action( 'enqueue_block_editor_assets', 'sls2026_enqueue_editor_assets' );

/**
 * Add async/defer where useful without a build step.
 *
 * @param string $tag    Script tag HTML.
 * @param string $handle Registered handle.
 * @return string
 */
function sls2026_script_loader_tag( $tag, $handle ) {
	if ( in_array( $handle, array( 'sls2026-navigation', 'sls2026-main' ), true ) ) {
		return str_replace( ' src', ' defer src', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'sls2026_script_loader_tag', 10, 2 );
