<?php
/**
 * Single page template.
 *
 * @package SoundsLikeSydney2026
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="sls-container">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content/content', 'page' );

			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
