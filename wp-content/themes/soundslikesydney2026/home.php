<?php
/**
 * Blog posts index (used when a static front page is set, or as the blog page).
 *
 * @package SoundsLikeSydney2026
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="sls-container sls-with-sidebar">

		<div class="sls-with-sidebar__main">
			<header class="page-header">
				<h1 class="page-title">
					<?php
					$sls_blog = get_option( 'page_for_posts' );
					echo esc_html( $sls_blog ? get_the_title( $sls_blog ) : __( 'Latest Stories', 'soundslikesydney2026' ) );
					?>
				</h1>
			</header>

			<?php if ( have_posts() ) : ?>
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
