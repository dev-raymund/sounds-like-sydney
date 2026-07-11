<?php
/**
 * Template Name: Reviews
 *
 * Reviews listing — a full-bleed hero over a paginated, sortable grid of posts
 * from the "reviews" category. Shares the reusable template-parts/post-listing.php
 * part with the News template.
 *
 * Assign to a page via Page Attributes → Template ("Reviews").
 *
 * @package SoundsLikeSydney2026
 */

get_header();

$sls_page_id = get_queried_object_id();
?>

<main id="primary" class="site-main sls-listing-page">

	<?php
	set_query_var( 'sls_hero_kicker', get_the_title( $sls_page_id ) );
	set_query_var( 'sls_hero_tagline', __( 'Independent reviews, by musicians.', 'soundslikesydney2026' ) );
	set_query_var( 'sls_hero_label', get_the_title( $sls_page_id ) );
	set_query_var( 'sls_hero_heading', 'h1' );
	get_template_part( 'template-parts/page-hero' );

	set_query_var( 'sls_list_category', 'reviews' );
	get_template_part( 'template-parts/post-listing' );
	?>

</main>

<?php
get_footer();
