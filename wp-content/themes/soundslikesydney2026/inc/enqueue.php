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
 * Google Fonts URL for the theme.
 *
 * Ibarra Real Nova — an elegant text serif used site-wide for headings and body.
 * Loaded with roman + italic across weights 400–700.
 *
 * Filterable so the pairing can be swapped (or the fonts self-hosted) later.
 *
 * @return string
 */
function sls2026_fonts_url() {
	$url = 'https://fonts.googleapis.com/css2?family=Ibarra+Real+Nova:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&display=swap';
	return apply_filters( 'sls2026_fonts_url', $url );
}

/**
 * Preconnect to the Google Fonts hosts so the fonts start downloading sooner.
 *
 * @param array  $hints    URLs to hint.
 * @param string $relation Relation type.
 * @return array
 */
function sls2026_resource_hints( $hints, $relation ) {
	if ( 'preconnect' === $relation ) {
		$hints[] = 'https://fonts.googleapis.com';
		$hints[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'sls2026_resource_hints', 10, 2 );

/**
 * Cache-busting version for a theme-owned asset: its file modification time,
 * so CSS/JS edits appear immediately with no manual version bumps. Falls back
 * to the theme version if the file can't be found.
 *
 * @param string $relative_path Path relative to the theme root (e.g. '/assets/css/main.css').
 * @return string
 */
function sls2026_asset_version( $relative_path ) {
	$file = SLS2026_DIR . $relative_path;
	return file_exists( $file ) ? (string) filemtime( $file ) : SLS2026_VERSION;
}

/**
 * Front-end styles and scripts.
 */
function sls2026_enqueue_assets() {
	// Web font (Ibarra Real Nova, site-wide). Loaded first so main.css can
	// depend on it. Version null: external, don't cache-bust.
	wp_enqueue_style( 'sls2026-fonts', sls2026_fonts_url(), array(), null );

	// Main stylesheet (the real design lives here; style.css is just the header + fallback tokens).
	wp_enqueue_style(
		'sls2026-main',
		SLS2026_URI . '/assets/css/main.css',
		array( 'sls2026-fonts' ),
		sls2026_asset_version( '/assets/css/main.css' )
	);

	// Required root stylesheet so WordPress recognises theme metadata; loaded after main.
	wp_enqueue_style(
		'sls2026-style',
		get_stylesheet_uri(),
		array( 'sls2026-main' ),
		sls2026_asset_version( '/style.css' )
	);

	// Navigation / interaction JS, deferred, no jQuery dependency.
	wp_enqueue_script(
		'sls2026-navigation',
		SLS2026_URI . '/assets/js/navigation.js',
		array(),
		sls2026_asset_version( '/assets/js/navigation.js' ),
		true
	);

	wp_enqueue_script(
		'sls2026-main',
		SLS2026_URI . '/assets/js/main.js',
		array(),
		sls2026_asset_version( '/assets/js/main.js' ),
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
	wp_enqueue_style( 'sls2026-fonts', sls2026_fonts_url(), array(), null );
	wp_enqueue_style(
		'sls2026-editor',
		SLS2026_URI . '/assets/css/editor.css',
		array( 'sls2026-fonts' ),
		sls2026_asset_version( '/assets/css/editor.css' )
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
