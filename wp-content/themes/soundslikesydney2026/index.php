<?php
/**
 * The main template file — universal fallback in the template hierarchy.
 *
 * WordPress uses this when no more specific template matches. Every other
 * template (home.php, archive.php, single.php...) overrides it, but this
 * guarantees the theme always has something to render.
 *
 * @package SoundsLikeSydney2026
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="sls-container">

		<?php if ( have_posts() ) : ?>

			<?php if ( ! is_front_page() && is_home() ) : ?>
				<header class="page-header">
					<h1 class="page-title"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<div class="sls-post-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content/content', get_post_type() );
				endwhile;
				?>
			</div>

			<?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content/content', 'none' ); ?>

		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
