<?php
/**
 * The site header: <head>, top bar, branding + primary nav, trending bar.
 *
 * @package SoundsLikeSydney2026
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

	<a class="skip-link screen-reader-text" href="#primary">
		<?php esc_html_e( 'Skip to content', 'soundslikesydney2026' ); ?>
	</a>

	<header id="masthead" class="site-header">

		<?php
		// Logo / site title + search toggle.
		get_template_part( 'template-parts/header/site-branding' );

		// Primary navigation.
		get_template_part( 'template-parts/header/navigation' );

		// "Trending" ticker row.
		get_template_part( 'template-parts/header/trending-bar' );
		?>

	</header><!-- #masthead -->

	<?php get_template_part( 'template-parts/header/sticky-header' ); ?>

	<div id="content" class="site-content">
