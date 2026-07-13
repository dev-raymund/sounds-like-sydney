<?php
/**
 * Full-width single-post hero: featured image with centered kicker, title and
 * byline overlaid. Falls back to a dark gradient band when no image is set.
 *
 * @package SoundsLikeSydney2026
 */

$sls_has_hero = has_post_thumbnail();
?>
<section class="sls-single-hero-full<?php echo $sls_has_hero ? '' : ' sls-single-hero-full--placeholder'; ?>">
	<?php if ( $sls_has_hero ) : ?>
		<?php the_post_thumbnail( 'sls2026-single-hero', array( 'class' => 'sls-single-hero-full__img' ) ); ?>
		<div class="sls-single__hero-scrim"></div>
	<?php endif; ?>

	<div class="sls-single__hero-content">
		<?php sls2026_primary_category(); ?>
		<?php the_title( '<h1 class="sls-single__title">', '</h1>' ); ?>
		<div class="sls-single__meta">
			<?php
			sls2026_posted_by();
			echo ' <span class="meta-sep">&middot;</span> ';
			sls2026_posted_on();
			?>
		</div>
	</div>
</section>
