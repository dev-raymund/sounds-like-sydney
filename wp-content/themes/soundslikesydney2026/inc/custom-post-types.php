<?php
/**
 * Custom post types + taxonomies.
 *
 * The reference design surfaces Podcasts and Videos as distinct content types.
 * They're registered here so ACF field groups can target them by post type.
 * Everything is filterable, so you can disable a CPT without editing core.
 *
 * @package SoundsLikeSydney2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Podcast and Video post types.
 */
function sls2026_register_post_types() {

	// Allow the whole feature to be switched off via filter.
	if ( ! apply_filters( 'sls2026_enable_custom_post_types', true ) ) {
		return;
	}

	// --- Podcast ---------------------------------------------------------
	register_post_type(
		'sls_podcast',
		array(
			'labels'       => array(
				'name'          => __( 'Podcasts', 'soundslikesydney2026' ),
				'singular_name' => __( 'Podcast', 'soundslikesydney2026' ),
				'add_new_item'  => __( 'Add New Podcast', 'soundslikesydney2026' ),
				'edit_item'     => __( 'Edit Podcast', 'soundslikesydney2026' ),
				'menu_name'     => __( 'Podcasts', 'soundslikesydney2026' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-microphone',
			'rewrite'      => array( 'slug' => 'podcasts' ),
			'show_in_rest' => true, // Gutenberg + ACF Blocks support.
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author', 'custom-fields' ),
		)
	);

	// --- Video -----------------------------------------------------------
	register_post_type(
		'sls_video',
		array(
			'labels'       => array(
				'name'          => __( 'Videos', 'soundslikesydney2026' ),
				'singular_name' => __( 'Video', 'soundslikesydney2026' ),
				'add_new_item'  => __( 'Add New Video', 'soundslikesydney2026' ),
				'edit_item'     => __( 'Edit Video', 'soundslikesydney2026' ),
				'menu_name'     => __( 'Videos', 'soundslikesydney2026' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-video-alt3',
			'rewrite'      => array( 'slug' => 'videos' ),
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author', 'custom-fields' ),
		)
	);
}
add_action( 'init', 'sls2026_register_post_types' );

/**
 * A shared "Format" taxonomy (Featured, Formats, Ideas... from the design).
 */
function sls2026_register_taxonomies() {
	if ( ! apply_filters( 'sls2026_enable_custom_post_types', true ) ) {
		return;
	}

	register_taxonomy(
		'sls_format',
		array( 'post', 'sls_podcast', 'sls_video' ),
		array(
			'labels'            => array(
				'name'          => __( 'Formats', 'soundslikesydney2026' ),
				'singular_name' => __( 'Format', 'soundslikesydney2026' ),
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'format' ),
		)
	);
}
add_action( 'init', 'sls2026_register_taxonomies' );
