/**
 * Misc front-end enhancements. Intentionally light — add feature modules here.
 */
( function () {
	'use strict';

	/**
	 * Trending bar slider: prev/next arrows scroll the headline track.
	 * Native horizontal scroll under the hood, so it stays swipeable on touch.
	 * Arrows reveal only when the row actually overflows, and disable at the ends.
	 */
	function initTrending() {
		var bars = document.querySelectorAll( '[data-trending]' );

		Array.prototype.forEach.call( bars, function ( bar ) {
			var list = bar.querySelector( '.sls-trending__list' );
			var prev = bar.querySelector( '[data-trending-dir="prev"]' );
			var next = bar.querySelector( '[data-trending-dir="next"]' );
			if ( ! list || ! prev || ! next ) {
				return;
			}

			function overflows() {
				return list.scrollWidth > list.clientWidth + 4;
			}

			function update() {
				if ( ! overflows() ) {
					prev.hidden = true;
					next.hidden = true;
					return;
				}
				prev.hidden = false;
				next.hidden = false;
				prev.disabled = list.scrollLeft <= 2;
				next.disabled = list.scrollLeft + list.clientWidth >= list.scrollWidth - 2;
			}

			function step( direction ) {
				var amount = Math.max( list.clientWidth * 0.7, 200 );
				list.scrollBy( { left: direction * amount, behavior: 'smooth' } );
			}

			prev.addEventListener( 'click', function () { step( -1 ); } );
			next.addEventListener( 'click', function () { step( 1 ); } );
			list.addEventListener( 'scroll', update, { passive: true } );
			window.addEventListener( 'resize', update );

			update();
		} );
	}

	/**
	 * Auto-submit any form control marked [data-autosubmit] on change
	 * (e.g. the News sort dropdown), so no separate button press is needed.
	 * The button stays in the markup as a no-JS fallback.
	 */
	function initAutoSubmit() {
		var controls = document.querySelectorAll( '[data-autosubmit]' );
		Array.prototype.forEach.call( controls, function ( control ) {
			control.addEventListener( 'change', function () {
				if ( control.form ) {
					control.form.submit();
				}
			} );
		} );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		document.documentElement.classList.add( 'js' );
		initTrending();
		initAutoSubmit();
	} );
}() );
