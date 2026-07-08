<?php
/**
 * Archive template (categories, tags, taxonomies, dates, authors, CPTs).
 *
 * @package SoundsLikeSydney2026
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="sls-container sls-with-sidebar">

		<div class="sls-with-sidebar__main">
			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</header>

				<div class="sls-post-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content/content', get_post_format() );
					endwhile;
					?>
				</div>

				<?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?>

			<?php else : ?>
				<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
			<?php endif; ?>
		</div>

		<?php get_sidebar(); ?>

	</div>
</main>

<?php
get_footer();
