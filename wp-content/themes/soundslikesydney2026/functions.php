<?php
/**
 * Sounds Like Sydney 2026 — theme bootstrap.
 *
 * This file only wires up constants and loads the modular includes in /inc.
 * Keep it thin: real logic belongs in the relevant inc/*.php file so the
 * theme stays easy to reason about (and easy to extend with ACF later).
 *
 * @package SoundsLikeSydney2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

/**
 * Theme constants. Prefixed SLS2026_ to avoid collisions.
 */
define( 'SLS2026_VERSION', '1.0.0' );
define( 'SLS2026_DIR', get_template_directory() );
define( 'SLS2026_URI', get_template_directory_uri() );

/**
 * Load the modular includes.
 *
 * Order matters: setup first (registers supports/menus), then the rest.
 * acf.php is loaded last so it can safely reference helpers defined above it.
 */
$sls2026_includes = array(
	'/inc/setup.php',              // Theme supports, menus, image sizes.
	'/inc/enqueue.php',            // Styles & scripts.
	'/inc/template-tags.php',      // Reusable output helpers (meta, byline...).
	'/inc/template-functions.php', // Body classes, filters, small tweaks.
	'/inc/widgets.php',            // Widget areas / sidebars.
	'/inc/custom-post-types.php',  // Optional CPTs (podcast, video).
	'/inc/acf.php',                // ACF integration (Local JSON, blocks, options).
);

foreach ( $sls2026_includes as $sls2026_file ) {
	$sls2026_path = SLS2026_DIR . $sls2026_file;
	if ( file_exists( $sls2026_path ) ) {
		require_once $sls2026_path;
	}
}
unset( $sls2026_file, $sls2026_path );
