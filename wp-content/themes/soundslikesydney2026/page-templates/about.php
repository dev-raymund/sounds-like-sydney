<?php
/**
 * Template Name: About
 *
 * About page — a designed, full-width layout that mirrors the reference
 * "magazine about" template: full-bleed hero, lead intro, image band,
 * a "sharing our content" trio, a stats strip, a founder feature and a
 * closing call-to-action.
 *
 * The long-form copy is bespoke to this page and lives inline. A featured
 * image, when set, replaces the gradient hero automatically.
 *
 * Assign to a page via Page Attributes → Template ("About Page").
 *
 * @package SoundsLikeSydney2026
 */

get_header();

$sls_contact_url = home_url( '/contact/' );
$sls_privacy_url = function_exists( 'get_privacy_policy_url' ) ? get_privacy_policy_url() : '';
$sls_terms_url   = home_url( '/terms-of-use/' );

/**
 * Small inline music-note glyph used for list markers and image tiles.
 */
$sls_note_svg = '<svg class="sls-note-glyph" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M9 18V5l10-2v13" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="6" cy="18" r="3" fill="currentColor"/><circle cx="16" cy="16" r="3" fill="currentColor"/></svg>';
?>

<main id="primary" class="site-main sls-about">

	<?php while ( have_posts() ) : the_post(); ?>

	<!-- Hero ---------------------------------------------------------------->
	<section class="sls-about__hero<?php echo has_post_thumbnail() ? '' : ' sls-about__hero--placeholder'; ?>" aria-label="<?php esc_attr_e( 'About Sounds Like Sydney', 'soundslikesydney2026' ); ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'sls2026-hero', array( 'class' => 'sls-about__hero-img' ) ); ?>
		<?php else : ?>
			<div class="sls-about__hero-inner">
				<p class="entry-kicker sls-about__hero-kicker"><?php esc_html_e( 'About Us', 'soundslikesydney2026' ); ?></p>
				<p class="sls-about__hero-tagline"><?php esc_html_e( 'Connecting with music.', 'soundslikesydney2026' ); ?></p>
			</div>
		<?php endif; ?>
	</section>

	<!-- Intro / lead -------------------------------------------------------->
	<section class="sls-section sls-about-intro">
		<div class="sls-container sls-about-intro__grid">

			<div class="sls-about-intro__lead">
				<p class="entry-kicker"><?php esc_html_e( 'Hello! Here we are.', 'soundslikesydney2026' ); ?></p>
				<h1 class="sls-about-intro__title"><?php esc_html_e( 'A website for music lovers, always independent.', 'soundslikesydney2026' ); ?></h1>
			</div>

			<div class="sls-about-intro__body">
				<p><strong>SoundsLikeSydney</strong> is a website for music lovers where you can catch up on musical activities in Sydney. Always independent, we take no fee for content or reviews. Visit us for:</p>

				<ul class="sls-about-notes">
					<li><?php echo $sls_note_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>Information on what&rsquo;s happening in Sydney&rsquo;s music scene &ndash; people, concerts, dates and venues; previews, reviews, features and interviews, and music news.</span></li>
					<li><?php echo $sls_note_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>The perfect platform for showcasing Sydney based musicians, and informing audiences.</span></li>
					<li><?php echo $sls_note_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>Links to interesting features from around Australia and the world.</span></li>
					<li><?php echo $sls_note_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>More than the mass media provides.</span></li>
					<li><?php echo $sls_note_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>An avenue for you to express your opinions.</span></li>
				</ul>

				<p>Our reviews are independent, fee-free and thoroughly researched. They are often written by knowledgeable musicians who have performed the pieces they are reviewing. We do not chase the headline for the sake of publicity &mdash; our primary purpose is to inform our readers.</p>
			</div>

		</div>
	</section>

	<!-- Image band ---------------------------------------------------------->
	<section class="sls-section sls-about-figures" aria-hidden="true">
		<div class="sls-container sls-about-figures__grid">
			<figure class="sls-about-tile sls-about-tile--a">
				<?php echo $sls_note_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<figcaption>Sydney&rsquo;s music scene</figcaption>
			</figure>
			<figure class="sls-about-tile sls-about-tile--b">
				<?php echo $sls_note_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<figcaption>Independent reviews</figcaption>
			</figure>
		</div>
	</section>

	<!-- Sharing our content ------------------------------------------------->
	<section class="sls-section sls-about-share">
		<div class="sls-container">

			<header class="sls-section__head sls-section__head--center">
				<h2 class="sls-section__title"><span><?php esc_html_e( 'Sharing our content', 'soundslikesydney2026' ); ?></span></h2>
				<p class="sls-section__sub"><?php esc_html_e( 'A few simple courtesies', 'soundslikesydney2026' ); ?></p>
			</header>

			<p class="sls-about-share__intro">We work hard to provide content that is informed, entertaining, diverse and well written. We would be honoured if you would like to share content that appears on SoundsLikeSydney &mdash; however we ask that you observe some simple courtesies.</p>

			<div class="sls-about-share__grid">
				<div class="sls-about-share__item">
					<h3><?php esc_html_e( 'Reprints', 'soundslikesydney2026' ); ?></h3>
					<p>Please seek our permission before reprinting a full feature or anything more than a quote. We don&rsquo;t expect to say &ldquo;No&rdquo;, but ask that the line &ldquo;Reprinted courtesy of www.soundslikesydney.com.au&rdquo; appears at the bottom of the feature. The name SoundsLikeSydney is protected by trademark law.</p>
				</div>
				<div class="sls-about-share__item">
					<h3><?php esc_html_e( 'Hotlinks', 'soundslikesydney2026' ); ?></h3>
					<p>We welcome hotlinks to our features. No permission is required, but if you do link to our features, let us know so we can reciprocate!</p>
				</div>
				<div class="sls-about-share__item">
					<h3><?php esc_html_e( 'Quotes', 'soundslikesydney2026' ); ?></h3>
					<p>You&rsquo;re very welcome to quote from our content if something we&rsquo;ve said will benefit your venture. Please follow the quote with &ldquo;SoundsLikeSydney&rdquo; &mdash; and we&rsquo;d be extra grateful if you hotlinked it back to us.</p>
				</div>
			</div>

			<p class="sls-about-share__outro">&hellip;after all, we all have the same aim &mdash; and that is to support music and musicians in Sydney!</p>

		</div>
	</section>

	<!-- Stats strip --------------------------------------------------------->
	<section class="sls-stats" aria-label="<?php esc_attr_e( 'At a glance', 'soundslikesydney2026' ); ?>">
		<div class="sls-container sls-stats__grid">
			<div class="sls-stat">
				<span class="sls-stat__num">2011</span>
				<span class="sls-stat__label"><?php esc_html_e( 'Founded in April', 'soundslikesydney2026' ); ?></span>
			</div>
			<div class="sls-stat">
				<span class="sls-stat__num">100%</span>
				<span class="sls-stat__label"><?php esc_html_e( 'Independent', 'soundslikesydney2026' ); ?></span>
			</div>
			<div class="sls-stat">
				<span class="sls-stat__num"><?php esc_html_e( 'Fee-Free', 'soundslikesydney2026' ); ?></span>
				<span class="sls-stat__label"><?php esc_html_e( 'Reviews, always', 'soundslikesydney2026' ); ?></span>
			</div>
			<div class="sls-stat">
				<span class="sls-stat__num"><?php esc_html_e( 'Sydney', 'soundslikesydney2026' ); ?></span>
				<span class="sls-stat__label"><?php esc_html_e( 'Where we call home', 'soundslikesydney2026' ); ?></span>
			</div>
		</div>
	</section>

	<!-- Founder feature ----------------------------------------------------->
	<section class="sls-section sls-founder-section">
		<div class="sls-container">

			<header class="sls-section__head sls-section__head--center">
				<h2 class="sls-section__title"><span><?php esc_html_e( 'Meet the Founder', 'soundslikesydney2026' ); ?></span></h2>
				<p class="sls-section__sub"><?php esc_html_e( 'Independent since 2011', 'soundslikesydney2026' ); ?></p>
			</header>

			<div class="sls-founder">

				<div class="sls-founder__media">
					<span class="sls-founder__avatar" aria-hidden="true">SdS</span>
					<h3 class="sls-founder__name">Shamistha de Soysa</h3>
					<p class="sls-founder__role"><?php esc_html_e( 'Founder &amp; Editor', 'soundslikesydney2026' ); ?></p>
					<ul class="sls-social sls-social--footer sls-founder__social">
						<li class="sls-social__link"><span class="sls-social__label">AMusA &middot; LMusA</span></li>
					</ul>
				</div>

				<div class="sls-founder__body">
					<p><strong>SoundsLikeSydney</strong> was founded in April 2011 by <strong>Shamistha de Soysa</strong>.</p>
					<p>Shamistha is an active musician. She sang with the Sydney Philharmonia Symphony Chorus for 12 years, performing regularly with the Sydney Symphony Orchestra at the Sydney Opera House and in other venues around Sydney and New South Wales. She was a member of the choral contingent which travelled to London in 2010 to open the BBC Proms at the Royal Albert Hall. She has also sung with the London Symphony Chorus and with several smaller choirs in Sydney, including the Sydneian Bach Choir in its Bach project from 2000&ndash;2010 and Coro Innominata. She has sung in choral concerts conducted by David Robertson, Vladimir Ashkenazy, Edo de Waart, David Zinman, Zubin Mehta, Richard Hickox and Sir Charles Mackerras.</p>
					<p>In March 2021 Shamistha began writing for Limelight as a reviewer and feature writer. She has interviewed numerous musicians, amongst them Zubin Mehta, Jordi Savall, Roger Woodward, Teddy Tahu Rhodes, Nicholas Vines, Richard Gill, Yvonne Kenny, Stuart Skelton, Paul Mealor, Nicola Benedetti, Lyndon Terracini, Jane Sheldon, Sally-Anne Russell and Sally Whitwell.</p>
					<p>She holds the AMusA Diploma in Voice and the Licentiate in Pianoforte Teaching. She also studied the violin and has played both piano and violin in social and community ensembles. For nearly five years she was a volunteer at radio station Fine Music FM, where she was a presenter, programmer, interviewer, producer, feature writer and Board member.</p>
					<p>Shamistha is an avid concert goer both in Sydney and on her travels, and has been a Patron of Opera Australia for over 10 years. Her professional work was in the field of medicine; through clinical practice and research she learnt the art of talking to people about things that matter to them, and translating that into writing.</p>
				</div>

			</div>

		</div>
	</section>

	<!-- Newsletter ---------------------------------------------------------->
	<section class="sls-about-news" aria-label="<?php esc_attr_e( 'Newsletter', 'soundslikesydney2026' ); ?>">
		<div class="sls-container sls-about-news__inner">

			<span class="sls-about-news__icon" aria-hidden="true">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
			</span>

			<h2 class="sls-about-news__title"><?php esc_html_e( 'Get the best blog stories into your inbox!', 'soundslikesydney2026' ); ?></h2>

			<form class="sls-newsletter-form sls-about-news__form" action="#" method="post" novalidate>
				<div class="sls-newsletter-field">
					<label class="screen-reader-text" for="sls-about-news-email"><?php esc_html_e( 'Email address', 'soundslikesydney2026' ); ?></label>
					<input id="sls-about-news-email" type="email" name="email" placeholder="<?php esc_attr_e( 'Enter Your Email', 'soundslikesydney2026' ); ?>" required>
					<button type="submit" class="sls-newsletter-submit">
						<span class="sls-newsletter-submit__icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4 20-7z"/></svg>
						</span>
						<span class="sls-newsletter-submit__text"><?php esc_html_e( 'Subscribe', 'soundslikesydney2026' ); ?></span>
					</button>
				</div>
				<label class="sls-newsletter-agree">
					<input type="checkbox" name="agree" required>
					<span><?php esc_html_e( 'I agree that my submitted data is being collected and stored.', 'soundslikesydney2026' ); ?></span>
				</label>
			</form>

		</div>
	</section>

	<!-- Closing call-to-action ---------------------------------------------->
	<section class="sls-about-cta">
		<div class="sls-container sls-about-cta__inner">
			<h2 class="sls-about-cta__title"><?php esc_html_e( 'Tell us what&rsquo;s happening in Sydney', 'soundslikesydney2026' ); ?></h2>
			<p class="sls-about-cta__text">SoundsLikeSydney wants to hear from you about what is happening in Sydney and your response to it &mdash; musically speaking &mdash; who, what, where and why! Join our community and tell as many people as you possibly can about us.</p>
			<div class="sls-about-cta__actions">
				<a class="sls-btn sls-btn--accent" href="<?php echo esc_url( $sls_contact_url ); ?>"><?php esc_html_e( 'Contact us', 'soundslikesydney2026' ); ?></a>
				<?php if ( $sls_privacy_url ) : ?>
					<a class="sls-about-cta__link" href="<?php echo esc_url( $sls_privacy_url ); ?>"><?php esc_html_e( 'Privacy Policy', 'soundslikesydney2026' ); ?></a>
				<?php endif; ?>
				<a class="sls-about-cta__link" href="<?php echo esc_url( $sls_terms_url ); ?>"><?php esc_html_e( 'Terms of Use', 'soundslikesydney2026' ); ?></a>
			</div>
		</div>
	</section>

	<?php endwhile; ?>

</main>

<?php
get_footer();
