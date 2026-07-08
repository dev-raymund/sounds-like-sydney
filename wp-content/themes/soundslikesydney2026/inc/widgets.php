<?php
/**
 * Widget areas (sidebars + footer columns).
 *
 * @package SoundsLikeSydney2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register sidebars.
 */
function sls2026_widgets_init() {
	$defaults = array(
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	);

	register_sidebar(
		array_merge(
			$defaults,
			array(
				'name'        => __( 'Primary Sidebar', 'soundslikesydney2026' ),
				'id'          => 'sidebar-primary',
				'description' => __( 'Appears beside blog and archive content (Trending Posts, ads).', 'soundslikesydney2026' ),
			)
		)
	);

	// Four footer columns matching the reference footer.
	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar(
			array_merge(
				$defaults,
				array(
					/* translators: %d: footer column number. */
					'name'        => sprintf( __( 'Footer Column %d', 'soundslikesydney2026' ), $i ),
					'id'          => 'footer-' . $i,
					'description' => __( 'Footer widget column.', 'soundslikesydney2026' ),
				)
			)
		);
	}
}
add_action( 'widgets_init', 'sls2026_widgets_init' );
