<?php
/**
 * Single post template.
 *
 * @package SoundsLikeSydney2026
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="sls-container sls-with-sidebar">

		<div class="sls-with-sidebar__main">
			<?php
			while ( have_posts() ) :
				the_post();

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

			endwhile;
			?>
		</div>

		<?php get_sidebar(); ?>

	</div>
</main>

<?php
get_footer();
