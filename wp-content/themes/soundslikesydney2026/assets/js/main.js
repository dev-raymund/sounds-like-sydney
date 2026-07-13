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

	/**
	 * "Copy link" buttons: copy the post URL to the clipboard and flash
	 * a brief "Copied" state on the button.
	 */
	function initCopyLink() {
		var buttons = document.querySelectorAll( '[data-copy-url]' );
		Array.prototype.forEach.call( buttons, function ( button ) {
			button.addEventListener( 'click', function () {
				var url = button.getAttribute( 'data-copy-url' );
				if ( ! url || ! navigator.clipboard ) {
					return;
				}
				navigator.clipboard.writeText( url ).then( function () {
					button.classList.add( 'is-copied' );
					window.setTimeout( function () {
						button.classList.remove( 'is-copied' );
					}, 1500 );
				} );
			} );
		} );
	}

	/**
	 * Like button: a lightweight client-side "like" persisted in localStorage
	 * (no backend). Toggles the count by one and remembers per-post state.
	 */
	function initLike() {
		var buttons = document.querySelectorAll( '.sls-like[data-like-key]' );
		Array.prototype.forEach.call( buttons, function ( button ) {
			var key = 'sls-like-' + button.getAttribute( 'data-like-key' );
			var countEl = button.querySelector( '.sls-like__count' );
			var base = parseInt( countEl.textContent, 10 ) || 0;
			var liked = false;
			try {
				liked = window.localStorage.getItem( key ) === '1';
			} catch ( e ) {}

			function render() {
				button.classList.toggle( 'is-liked', liked );
				button.setAttribute( 'aria-pressed', liked ? 'true' : 'false' );
				countEl.textContent = base + ( liked ? 1 : 0 );
			}

			button.addEventListener( 'click', function () {
				liked = ! liked;
				try {
					window.localStorage.setItem( key, liked ? '1' : '0' );
				} catch ( e ) {}
				render();
			} );

			render();
		} );
	}

	/**
	 * Turn the sidebar Archives list into a compact dropdown that navigates to
	 * the chosen month on change. Works for both classic (.widget_archive ul)
	 * and block (.wp-block-archives-list) markup; the original list is the
	 * no-JS fallback.
	 */
	function initArchivesDropdown() {
		var lists = document.querySelectorAll(
			'.sls-sidebar .wp-block-archives-list, .sls-sidebar .widget_archive ul'
		);
		Array.prototype.forEach.call( lists, function ( list ) {
			var links = list.querySelectorAll( 'a' );
			if ( links.length < 2 ) {
				return;
			}

			var select = document.createElement( 'select' );
			select.className = 'sls-archive-select';
			select.setAttribute( 'aria-label', 'Archives' );

			var placeholder = document.createElement( 'option' );
			placeholder.textContent = 'Select Month';
			placeholder.value = '';
			placeholder.selected = true;
			select.appendChild( placeholder );

			Array.prototype.forEach.call( links, function ( a ) {
				var opt = document.createElement( 'option' );
				opt.value = a.href;
				opt.textContent = a.textContent.replace( /\s+/g, ' ' ).trim();
				select.appendChild( opt );
			} );

			select.addEventListener( 'change', function () {
				if ( select.value ) {
					window.location.href = select.value;
				}
			} );

			list.parentNode.insertBefore( select, list );
			list.parentNode.removeChild( list );
		} );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		document.documentElement.classList.add( 'js' );
		initTrending();
		initAutoSubmit();
		initCopyLink();
		initLike();
		initArchivesDropdown();
	} );
}() );
