<?php
/**
 * 404 (not found) template.
 *
 * @package SoundsLikeSydney2026
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="sls-container">
		<section class="sls-error-404">
			<header class="sls-error-404__head">
				<p class="sls-error-404__code">404</p>
				<h1 class="page-title"><?php esc_html_e( 'This page has gone quiet.', 'soundslikesydney2026' ); ?></h1>
				<p><?php esc_html_e( 'The page you were after can&rsquo;t be found. Try a search or head back home.', 'soundslikesydney2026' ); ?></p>
			</header>

			<div class="sls-error-404__search">
				<?php get_search_form(); ?>
			</div>

			<p class="sls-error-404__home">
				<a class="sls-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php esc_html_e( 'Back to homepage', 'soundslikesydney2026' ); ?>
				</a>
			</p>
		</section>
	</div>
</main>

<?php
get_footer();
