<?php
/**
 * "Recent Video" — dark section with a big featured video + a playlist.
 *
 * Source: the sls_video CPT if present, else posts whose ACF media_type =
 * 'video', else latest posts (thumbnails act as poster frames).
 *
 * @package SoundsLikeSydney2026
 */

$sls_video_args = array(
	'posts_per_page'      => 5,
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);

if ( post_type_exists( 'sls_video' ) ) {
	$sls_video_args['post_type'] = 'sls_video';
} else {
	$sls_video_args['post_type'] = 'post';
}

$sls_videos = new WP_Query( $sls_video_args );

if ( ! $sls_videos->have_posts() ) {
	wp_reset_postdata();
	return;
}

$sls_video_posts = $sls_videos->posts;
$sls_video_lead  = array_shift( $sls_video_posts );
?>
<section class="sls-section sls-video" aria-label="<?php esc_attr_e( 'Recent video', 'soundslikesydney2026' ); ?>">
	<div class="sls-container">

		<header class="sls-section__head sls-section__head--light">
			<h2 class="sls-section__title"><span><?php esc_html_e( 'Recent Video', 'soundslikesydney2026' ); ?></span></h2>
			<p class="sls-section__sub"><?php esc_html_e( 'Stay up-to-date', 'soundslikesydney2026' ); ?></p>
		</header>

		<div class="sls-video__grid">

			<article class="sls-video__lead">
				<a class="sls-video__play" href="<?php echo esc_url( get_permalink( $sls_video_lead ) ); ?>">
					<?php
					if ( has_post_thumbnail( $sls_video_lead ) ) {
						echo get_the_post_thumbnail( $sls_video_lead, 'sls2026-hero', array( 'loading' => 'lazy' ) );
					}
					?>
					<span class="sls-video__play-icon" aria-hidden="true"></span>
				</a>
				<div class="sls-video__lead-body">
					<?php sls2026_primary_category( $sls_video_lead->ID ); ?>
					<h3 class="sls-video__title">
						<a href="<?php echo esc_url( get_permalink( $sls_video_lead ) ); ?>">
							<?php echo esc_html( get_the_title( $sls_video_lead ) ); ?>
						</a>
					</h3>
				</div>
			</article>

			<ul class="sls-video__playlist">
				<?php foreach ( $sls_video_posts as $sls_post ) : ?>
					<li>
						<?php
						set_query_var( 'sls_card_post', $sls_post );
						set_query_var( 'sls_card_size', 'sls2026-thumb' );
						set_query_var( 'sls_card_play', true );
						get_template_part( 'template-parts/content/card', 'mini' );
						?>
					</li>
				<?php endforeach; ?>
			</ul>

		</div>
	</div>
</section>
<?php
wp_reset_postdata();
