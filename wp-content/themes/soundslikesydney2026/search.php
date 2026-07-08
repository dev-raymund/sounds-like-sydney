<?php
/**
 * Search results template.
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
					<h1 class="page-title">
						<?php
						printf(
							/* translators: %s: search query. */
							esc_html__( 'Search results for: %s', 'soundslikesydney2026' ),
							'<span>' . esc_html( get_search_query() ) . '</span>'
						);
						?>
					</h1>
				</header>

				<div class="sls-post-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content/content', 'card' );
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
