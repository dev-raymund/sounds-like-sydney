<?php
/**
 * Template Name: News
 *
 * News listing — a full-bleed hero over a paginated, sortable grid of posts
 * from the "news" category. The listing itself lives in the reusable
 * template-parts/post-listing.php part.
 *
 * Assign to a page via Page Attributes → Template ("News").
 *
 * @package SoundsLikeSydney2026
 */

get_header();

$sls_page_id = get_queried_object_id();
?>

<main id="primary" class="site-main sls-listing-page">

	<?php
	set_query_var( 'sls_hero_kicker', get_the_title( $sls_page_id ) );
	set_query_var( 'sls_hero_tagline', __( 'The latest from Sydney’s music scene.', 'soundslikesydney2026' ) );
	set_query_var( 'sls_hero_label', get_the_title( $sls_page_id ) );
	set_query_var( 'sls_hero_heading', 'h1' );
	get_template_part( 'template-parts/page-hero' );

	set_query_var( 'sls_list_category', 'news' );
	get_template_part( 'template-parts/post-listing' );
	?>

</main>

<?php
get_footer();
