<?php
/**
 * Template tags — small, reusable output helpers used across templates.
 *
 * @package SoundsLikeSydney2026
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'sls2026_posted_on' ) ) {
	/**
	 * Print the published date, linked to the post.
	 */
	function sls2026_posted_on() {
		$time = sprintf(
			'<time class="entry-date published" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);
		printf(
			'<span class="posted-on"><a href="%1$s" rel="bookmark">%2$s</a></span>',
			esc_url( get_permalink() ),
			$time // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built above.
		);
	}
}

if ( ! function_exists( 'sls2026_posted_by' ) ) {
	/**
	 * Print the author byline, linked to their archive.
	 */
	function sls2026_posted_by() {
		printf(
			'<span class="byline">%1$s <a class="url fn n" href="%2$s">%3$s</a></span>',
			esc_html_x( 'by', 'post author', 'soundslikesydney2026' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}
}

if ( ! function_exists( 'sls2026_primary_category' ) ) {
	/**
	 * Print the post's primary category as a small kicker label.
	 *
	 * Honours ACF/Yoast primary-term if present, else first category.
	 *
	 * @param int|null $post_id Optional post ID.
	 */
	function sls2026_primary_category( $post_id = null ) {
		$post_id    = $post_id ? $post_id : get_the_ID();
		$categories = get_the_category( $post_id );
		if ( empty( $categories ) ) {
			return;
		}
		$primary = $categories[0];
		printf(
			'<a class="entry-kicker" href="%1$s">%2$s</a>',
			esc_url( get_category_link( $primary->term_id ) ),
			esc_html( $primary->name )
		);
	}
}

if ( ! function_exists( 'sls2026_category_list' ) ) {
	/**
	 * Print up to $limit categories as a comma-separated kicker
	 * (e.g. "FEATURED, HEALTH"), matching the reference hero.
	 *
	 * @param int|null $post_id Optional post ID.
	 * @param int      $limit   Max categories to show.
	 */
	function sls2026_category_list( $post_id = null, $limit = 2 ) {
		$post_id    = $post_id ? $post_id : get_the_ID();
		$categories = get_the_category( $post_id );
		if ( empty( $categories ) ) {
			return;
		}
		$categories = array_slice( $categories, 0, max( 1, (int) $limit ) );
		$links      = array();
		foreach ( $categories as $cat ) {
			$links[] = sprintf(
				'<a href="%1$s">%2$s</a>',
				esc_url( get_category_link( $cat->term_id ) ),
				esc_html( $cat->name )
			);
		}
		echo '<span class="entry-kicker">' . implode( ', ', $links ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- links escaped above.
	}
}

if ( ! function_exists( 'sls2026_comment_badge' ) ) {
	/**
	 * Print a small comment-count badge with a speech-bubble icon.
	 *
	 * @param int|null $post_id Optional post ID.
	 */
	function sls2026_comment_badge( $post_id = null ) {
		$post_id = $post_id ? $post_id : get_the_ID();
		$count   = get_comments_number( $post_id );
		printf(
			'<span class="entry-comments"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.38 8.38 0 0 1-8.5 8.5 8.5 8.5 0 0 1-3.8-.9L3 21l1.9-5.7A8.38 8.38 0 0 1 4 11.5 8.5 8.5 0 0 1 12.5 3 8.38 8.38 0 0 1 21 11.5z"/></svg>%s</span>',
			esc_html( number_format_i18n( $count ) )
		);
	}
}

if ( ! function_exists( 'sls2026_entry_meta' ) ) {
	/**
	 * Print a compact meta row: author + date.
	 */
	function sls2026_entry_meta() {
		if ( 'post' !== get_post_type() ) {
			return;
		}
		echo '<div class="entry-meta">';
		sls2026_posted_by();
		echo ' <span class="meta-sep">&middot;</span> ';
		sls2026_posted_on();
		echo '</div>';
	}
}

if ( ! function_exists( 'sls2026_post_thumbnail' ) ) {
	/**
	 * Print a linked featured image with a sensible size + graceful fallback.
	 *
	 * @param string $size Registered image size.
	 */
	function sls2026_post_thumbnail( $size = 'sls2026-card' ) {
		if ( post_password_required() || is_attachment() ) {
			return;
		}
		echo '<a class="post-thumbnail" href="' . esc_url( get_permalink() ) . '" aria-hidden="true" tabindex="-1">';
		if ( has_post_thumbnail() ) {
			the_post_thumbnail(
				$size,
				array(
					'loading' => 'lazy',
					'alt'     => the_title_attribute( array( 'echo' => false ) ),
				)
			);
		} else {
			printf(
				'<span class="post-thumbnail--placeholder" role="img" aria-label="%s"></span>',
				esc_attr__( 'No featured image', 'soundslikesydney2026' )
			);
		}
		echo '</a>';
	}
}

if ( ! function_exists( 'sls2026_reading_time' ) ) {
	/**
	 * Estimate reading time in minutes from the post content.
	 *
	 * @param int|null $post_id Optional post ID.
	 * @return int Minutes (minimum 1).
	 */
	function sls2026_reading_time( $post_id = null ) {
		$post_id = $post_id ? $post_id : get_the_ID();
		$words   = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ) );
		return max( 1, (int) ceil( $words / 200 ) );
	}
}

if ( ! function_exists( 'sls2026_social_icon_svg' ) ) {
	/**
	 * Return an inline brand SVG for a social URL (detected from its host).
	 *
	 * @param string $url The link URL.
	 * @return string SVG markup (trusted, from a fixed map).
	 */
	function sls2026_social_icon_svg( $url ) {
		$host = strtolower( (string) wp_parse_url( $url, PHP_URL_HOST ) );

		$net = 'link';
		$map = array(
			'facebook'  => 'facebook',
			'fb.com'    => 'facebook',
			'x.com'     => 'x',
			'twitter'   => 'x',
			'youtube'   => 'youtube',
			'youtu.be'  => 'youtube',
			'instagram' => 'instagram',
			'linkedin'  => 'linkedin',
			'tiktok'    => 'tiktok',
		);
		foreach ( $map as $needle => $slug ) {
			if ( '' !== $host && false !== strpos( $host, $needle ) ) {
				$net = $slug;
				break;
			}
		}

		$icons = array(
			'facebook'  => '<path d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.2c-1.2 0-1.6.8-1.6 1.6V12h2.7l-.4 2.9h-2.3v7A10 10 0 0 0 22 12z"/>',
			'x'         => '<path d="M18.9 2H22l-7.1 8.1L23 22h-6.6l-5.2-6.8L5.3 22H2.2l7.6-8.7L1.5 2h6.8l4.6 6.1L18.9 2zm-1.2 18h1.8L7.4 3.9H5.5L17.7 20z"/>',
			'youtube'   => '<path d="M23 12s0-3.2-.4-4.7a2.4 2.4 0 0 0-1.7-1.7C19.3 5.2 12 5.2 12 5.2s-7.3 0-8.9.4A2.4 2.4 0 0 0 1.4 7.3C1 8.8 1 12 1 12s0 3.2.4 4.7a2.4 2.4 0 0 0 1.7 1.7c1.6.4 8.9.4 8.9.4s7.3 0 8.9-.4a2.4 2.4 0 0 0 1.7-1.7c.4-1.5.4-4.7.4-4.7zM9.8 15.3V8.7l6.2 3.3-6.2 3.3z"/>',
			'instagram' => '<path d="M12 2c2.7 0 3 0 4.1.1 1.1 0 1.8.2 2.4.5.6.2 1.1.5 1.6 1s.8 1 1 1.6c.3.6.5 1.3.5 2.4.1 1.1.1 1.4.1 4.1s0 3-.1 4.1c0 1.1-.2 1.8-.5 2.4a4.3 4.3 0 0 1-2.6 2.6c-.6.3-1.3.5-2.4.5-1.1.1-1.4.1-4.1.1s-3 0-4.1-.1c-1.1 0-1.8-.2-2.4-.5a4.3 4.3 0 0 1-2.6-2.6c-.3-.6-.5-1.3-.5-2.4C2 15 2 14.7 2 12s0-3 .1-4.1c0-1.1.2-1.8.5-2.4A4.3 4.3 0 0 1 5.2 2.9c.6-.3 1.3-.5 2.4-.5C9 2 9.3 2 12 2zm0 1.8c-2.6 0-3 0-4 .1-.9 0-1.4.2-1.7.3-.4.2-.7.4-1 .7s-.5.6-.7 1c-.1.3-.3.8-.3 1.7-.1 1-.1 1.3-.1 4s0 3 .1 4c0 .9.2 1.4.3 1.7.2.4.4.7.7 1s.6.5 1 .7c.3.1.8.3 1.7.3 1 .1 1.3.1 4 .1s3 0 4-.1c.9 0 1.4-.2 1.7-.3.4-.2.7-.4 1-.7s.5-.6.7-1c.1-.3.3-.8.3-1.7.1-1 .1-1.3.1-4s0-3-.1-4c0-.9-.2-1.4-.3-1.7-.2-.4-.4-.7-.7-1s-.6-.5-1-.7c-.3-.1-.8-.3-1.7-.3-1-.1-1.3-.1-4-.1zm0 3.1a5.1 5.1 0 1 1 0 10.2 5.1 5.1 0 0 1 0-10.2zm0 1.8a3.3 3.3 0 1 0 0 6.6 3.3 3.3 0 0 0 0-6.6zm5.3-3.2a1.2 1.2 0 1 1 0 2.5 1.2 1.2 0 0 1 0-2.5z"/>',
			'linkedin'  => '<path d="M20.4 20.4h-3.6v-5.6c0-1.3 0-3-1.9-3s-2.1 1.4-2.1 2.9v5.7H9.2V9h3.4v1.6h.1c.5-.9 1.7-1.9 3.4-1.9 3.6 0 4.3 2.4 4.3 5.5v6.2zM5.3 7.4a2.1 2.1 0 1 1 0-4.2 2.1 2.1 0 0 1 0 4.2zm1.8 13H3.5V9h3.6v11.4zM22.2 0H1.8C.8 0 0 .8 0 1.7v20.6c0 .9.8 1.7 1.8 1.7h20.4c1 0 1.8-.8 1.8-1.7V1.7c0-.9-.8-1.7-1.8-1.7z"/>',
			'tiktok'    => '<path d="M16.5 2h-3v13.5a2.5 2.5 0 1 1-2-2.4v-3a5.5 5.5 0 1 0 5 5.4V8.6a7 7 0 0 0 4 1.3V6.8a4 4 0 0 1-4-4z"/>',
			'link'      => '<path d="M3.9 12A3.1 3.1 0 0 1 7 8.9h4V7H7a5 5 0 0 0 0 10h4v-1.9H7A3.1 3.1 0 0 1 3.9 12zM8 13h8v-2H8v2zm9-6h-4v1.9h4a3.1 3.1 0 0 1 0 6.2h-4V17h4a5 5 0 0 0 0-10z"/>',
		);

		$path = isset( $icons[ $net ] ) ? $icons[ $net ] : $icons['link'];
		return '<svg class="sls-social__svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">' . $path . '</svg>';
	}
}

if ( ! function_exists( 'sls2026_social_links' ) ) {
	/**
	 * Render the "social" menu location as icon links (optionally labelled).
	 *
	 * @param array $args {
	 *     @type string $class      UL class.
	 *     @type bool   $show_label Show the item title beside the icon.
	 * }
	 */
	function sls2026_social_links( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'class'      => 'sls-social',
				'show_label' => true,
			)
		);

		$locations = get_nav_menu_locations();
		if ( empty( $locations['social'] ) ) {
			return;
		}
		$items = wp_get_nav_menu_items( $locations['social'] );
		if ( empty( $items ) ) {
			return;
		}

		echo '<ul class="' . esc_attr( $args['class'] ) . '">';
		foreach ( $items as $item ) {
			printf(
				'<li class="sls-social__item"><a class="sls-social__link" href="%1$s" rel="noopener noreferrer" target="_blank"><span class="sls-social__icon">%2$s</span>%3$s</a></li>',
				esc_url( $item->url ),
				sls2026_social_icon_svg( $item->url ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted SVG.
				$args['show_label']
					? '<span class="sls-social__label">' . esc_html( $item->title ) . '</span>'
					: '<span class="screen-reader-text">' . esc_html( $item->title ) . '</span>'
			);
		}
		echo '</ul>';
	}
}
