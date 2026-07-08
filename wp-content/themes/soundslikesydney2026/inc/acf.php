<?php
/**
 * Advanced Custom Fields (ACF) integration layer.
 *
 * The theme is designed to work WITHOUT ACF installed (every template falls
 * back to core queries / native fields). When the ACF (or ACF Pro) plugin is
 * activated, this file wires everything up:
 *
 *   1. Local JSON  — field groups are saved to /acf-json and version controlled,
 *                    so field definitions travel with the theme. No DB drift.
 *   2. ACF Blocks  — registers block types from /template-parts/blocks (ACF Pro).
 *   3. Options page— a site-wide "Theme Settings" area for header/footer content.
 *   4. sls2026_field() — a null-safe wrapper so templates never fatal when ACF
 *                    is inactive; they just render fallbacks instead.
 *
 * NOTHING here requires ACF to be present. Guarded with function_exists().
 *
 * @package SoundsLikeSydney2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Is ACF (free or Pro) available right now?
 *
 * @return bool
 */
function sls2026_has_acf() {
	return function_exists( 'get_field' );
}

/**
 * Null-safe field getter.
 *
 * Use this everywhere in templates instead of get_field() directly so the
 * theme degrades gracefully before ACF is installed.
 *
 * @param string          $selector Field name/key.
 * @param int|string|null $post_id  Post ID, 'option', term, etc. Default current.
 * @param mixed           $default  Value to return when ACF is absent or empty.
 * @return mixed
 */
function sls2026_field( $selector, $post_id = null, $default = null ) {
	if ( ! sls2026_has_acf() ) {
		return $default;
	}
	$value = get_field( $selector, $post_id );
	return ( null === $value || false === $value || '' === $value ) ? $default : $value;
}

/**
 * Shorthand for an option-page field (post_id = 'option').
 *
 * @param string $selector Field name/key.
 * @param mixed  $default  Fallback value.
 * @return mixed
 */
function sls2026_option( $selector, $default = null ) {
	return sls2026_field( $selector, 'option', $default );
}

/* -------------------------------------------------------------------------
 * 1. Local JSON — save + load points
 *
 * WordPress writes new/edited field groups as .json into /acf-json and reads
 * them back on load. Commit that folder and field groups follow the theme.
 * ---------------------------------------------------------------------- */

/**
 * Save ACF field group JSON into the theme's /acf-json folder.
 *
 * @param string $path Default save path.
 * @return string
 */
function sls2026_acf_json_save_point( $path ) {
	return SLS2026_DIR . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'sls2026_acf_json_save_point' );

/**
 * Add the theme's /acf-json folder to ACF's load paths.
 *
 * @param array $paths Existing load paths.
 * @return array
 */
function sls2026_acf_json_load_point( $paths ) {
	$paths[] = SLS2026_DIR . '/acf-json';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'sls2026_acf_json_load_point' );

/* -------------------------------------------------------------------------
 * 2. Options page — site-wide theme settings
 *
 * Header tagline, top-bar text, footer columns, newsletter copy, ad slots,
 * default section headings... all editable without touching code.
 * Requires ACF Pro (acf_add_options_page).
 * ---------------------------------------------------------------------- */

/**
 * Register the "Theme Settings" options page (and sub-pages).
 */
function sls2026_acf_options_pages() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return; // ACF free / not installed.
	}

	acf_add_options_page(
		array(
			'page_title' => __( 'Theme Settings', 'soundslikesydney2026' ),
			'menu_title' => __( 'Theme Settings', 'soundslikesydney2026' ),
			'menu_slug'  => 'sls2026-settings',
			'capability' => 'edit_theme_options',
			'position'   => 59,
			'icon_url'   => 'dashicons-admin-customizer',
			'redirect'   => true,
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'  => __( 'Header & Top Bar', 'soundslikesydney2026' ),
			'menu_title'  => __( 'Header', 'soundslikesydney2026' ),
			'parent_slug' => 'sls2026-settings',
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'  => __( 'Footer', 'soundslikesydney2026' ),
			'menu_title'  => __( 'Footer', 'soundslikesydney2026' ),
			'parent_slug' => 'sls2026-settings',
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'  => __( 'Homepage Sections', 'soundslikesydney2026' ),
			'menu_title'  => __( 'Homepage', 'soundslikesydney2026' ),
			'parent_slug' => 'sls2026-settings',
		)
	);
}
add_action( 'acf/init', 'sls2026_acf_options_pages' );

/* -------------------------------------------------------------------------
 * 3. ACF Blocks (ACF Pro)
 *
 * Auto-register any block defined by a block.json manifest under
 * /template-parts/blocks/<name>/block.json. Drop a folder in, done.
 * ---------------------------------------------------------------------- */

/**
 * Register ACF blocks from /template-parts/blocks/*.
 */
function sls2026_register_acf_blocks() {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}

	$blocks_dir = SLS2026_DIR . '/template-parts/blocks';
	if ( ! is_dir( $blocks_dir ) ) {
		return;
	}

	foreach ( glob( $blocks_dir . '/*/block.json' ) as $manifest ) {
		register_block_type( dirname( $manifest ) );
	}
}
add_action( 'init', 'sls2026_register_acf_blocks' );

/**
 * Provide a "Sounds Like Sydney" block category for the theme's ACF blocks.
 *
 * @param array $categories Existing categories.
 * @return array
 */
function sls2026_block_categories( $categories ) {
	return array_merge(
		array(
			array(
				'slug'  => 'sls2026',
				'title' => __( 'Sounds Like Sydney', 'soundslikesydney2026' ),
				'icon'  => 'megaphone',
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'sls2026_block_categories' );

/* -------------------------------------------------------------------------
 * 4. Admin nudge — remind editors to install ACF (dismissible, optional).
 * ---------------------------------------------------------------------- */

/**
 * Show a gentle admin notice if ACF is missing.
 */
function sls2026_acf_admin_notice() {
	if ( sls2026_has_acf() || ! current_user_can( 'install_plugins' ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( ! $screen || 'dashboard' !== $screen->id ) {
		return;
	}
	printf(
		'<div class="notice notice-info is-dismissible"><p>%s</p></div>',
		esc_html__( 'Sounds Like Sydney 2026 works out of the box, but installing Advanced Custom Fields unlocks the editable Theme Settings, homepage section controls and custom blocks.', 'soundslikesydney2026' )
	);
}
add_action( 'admin_notices', 'sls2026_acf_admin_notice' );
