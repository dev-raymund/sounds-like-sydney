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
