<?php
/**
 * Reusable full-bleed page hero.
 *
 * Shows the current page's featured image when set, otherwise a gradient
 * placeholder carrying a kicker + tagline. Works both inside and outside The
 * Loop (it resolves the page via the queried object).
 *
 * Query vars:
 *   sls_hero_kicker   — small overline label.
 *   sls_hero_tagline  — large display line.
 *   sls_hero_label    — optional aria-label for the section.
 *   sls_hero_heading  — 'h1' to render the tagline as the page <h1> (default <p>).
 *
 * @package SoundsLikeSydney2026
 */

$sls_kicker  = get_query_var( 'sls_hero_kicker' );
$sls_tagline = get_query_var( 'sls_hero_tagline' );
$sls_label   = get_query_var( 'sls_hero_label' );
$sls_tag     = ( 'h1' === get_query_var( 'sls_hero_heading' ) ) ? 'h1' : 'p';
$sls_pid     = get_queried_object_id();
$sls_has_img = $sls_pid && has_post_thumbnail( $sls_pid );
?>
<section class="sls-page-hero<?php echo $sls_has_img ? '' : ' sls-page-hero--placeholder'; ?>"<?php echo $sls_label ? ' aria-label="' . esc_attr( $sls_label ) . '"' : ''; ?>>
	<?php
	if ( $sls_has_img ) {
		echo get_the_post_thumbnail( $sls_pid, 'sls2026-hero', array( 'class' => 'sls-page-hero__img' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		?>
		<div class="sls-page-hero__inner">
			<?php if ( $sls_kicker ) : ?>
				<p class="entry-kicker sls-page-hero__kicker"><?php echo esc_html( $sls_kicker ); ?></p>
			<?php endif; ?>
			<?php if ( $sls_tagline ) : ?>
				<?php printf( '<%1$s class="sls-page-hero__tagline">%2$s</%1$s>', tag_escape( $sls_tag ), esc_html( $sls_tagline ) ); ?>
			<?php endif; ?>
		</div>
		<?php
	}
	?>
</section>
