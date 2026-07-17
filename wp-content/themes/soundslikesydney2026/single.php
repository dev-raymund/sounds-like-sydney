<?php
/**
 * Single post template.
 *
 * @package SoundsLikeSydney2026
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();

		// Full-width hero banner.
		get_template_part( 'template-parts/content/single', 'hero' );
		?>

		<div class="sls-container">
			<div class="sls-single-cols">

				<aside class="sls-single-rail">
					<?php
					get_template_part( 'template-parts/content/single', 'share' );
					get_template_part( 'template-parts/content/single', 'newsletter' );
					?>
				</aside>

				<div class="sls-single-body">
					<?php
					get_template_part( 'template-parts/content/content', 'single' );

					// Previous / next navigation.
					the_post_navigation(
						array(
							'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous', 'soundslikesydney2026' ) . '</span> <span class="nav-title">%title</span>',
							'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next', 'soundslikesydney2026' ) . '</span> <span class="nav-title">%title</span>',
						)
					);

					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>
				</div>

				<?php get_sidebar(); ?>

			</div>
		</div>

		<?php
		// Full-width band below the article.
		get_template_part( 'template-parts/content/single', 'editors-choice' );

	endwhile;
	?>
</main>

<?php
get_footer();
