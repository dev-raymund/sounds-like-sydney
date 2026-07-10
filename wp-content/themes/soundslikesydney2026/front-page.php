<?php
/**
 * Front page — the magazine homepage.
 *
 * Composed entirely of section template parts so the layout can later be made
 * fully editable. Two paths are supported:
 *
 *   - No ACF: sections self-populate from recent posts / categories.
 *   - With ACF: an Options-page Flexible Content field ('homepage_sections')
 *     lets editors reorder/toggle sections. See the loop below.
 *
 * @package SoundsLikeSydney2026
 */

get_header();
?>

<main id="primary" class="site-main sls-home">

	<?php
	// -------------------------------------------------------------------
	// ACF-driven layout (Flexible Content) if configured, else the default
	// hard-coded section order below.
	// -------------------------------------------------------------------
	$sls_sections = sls2026_has_acf() && function_exists( 'have_rows' ) && have_rows( 'homepage_sections', 'option' );

	if ( $sls_sections ) :
		while ( have_rows( 'homepage_sections', 'option' ) ) :
			the_row();
			$sls_layout = get_row_layout();
			// Map an ACF layout name to a template part of the same name.
			$sls_map = array(
				'hero'              => 'template-parts/homepage/hero',
				'editors_choice'    => 'template-parts/homepage/editors-choice',
				'ad'                => 'template-parts/homepage/ad-banner',
				'recent_posts'      => 'template-parts/homepage/recent-posts',
				'recent_video'      => 'template-parts/homepage/recent-video',
				'latest_posts'      => 'template-parts/homepage/latest-posts',
			);
			if ( isset( $sls_map[ $sls_layout ] ) ) {
				get_template_part( $sls_map[ $sls_layout ] );
			}
		endwhile;

	else :
		// Default section order (mirrors the reference homepage).
		get_template_part( 'template-parts/homepage/hero' );
		get_template_part( 'template-parts/homepage/editors-choice' );
		get_template_part( 'template-parts/homepage/ad-banner' );
		get_template_part( 'template-parts/homepage/recent-posts' );
		get_template_part( 'template-parts/homepage/recent-video' );
		get_template_part( 'template-parts/homepage/latest-posts' );
	endif;
	?>

</main>

<?php
get_footer();
