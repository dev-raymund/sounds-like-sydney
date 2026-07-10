/**
 * Header interactions:
 *   - mobile menu toggle
 *   - full-screen search overlay (open/close, Escape, backdrop click, focus)
 *   - compact sticky header reveal on scroll
 * Vanilla JS, no dependencies.
 */
( function () {
	'use strict';

	/**
	 * Simple class-based toggle (used for the mobile nav).
	 */
	function bindToggle( button, target, openClass ) {
		if ( ! button || ! target ) {
			return;
		}
		button.addEventListener( 'click', function () {
			var expanded = button.getAttribute( 'aria-expanded' ) === 'true';
			button.setAttribute( 'aria-expanded', String( ! expanded ) );
			target.classList.toggle( openClass );
		} );
	}

	/**
	 * Full-screen search overlay. Supports multiple triggers (header + sticky).
	 */
	function initSearch() {
		var toggles = document.querySelectorAll( '.sls-search-toggle' );
		var panel   = document.getElementById( 'sls-search-panel' );
		if ( ! toggles.length || ! panel ) {
			return;
		}

		var field      = panel.querySelector( '.sls-search-field' );
		var close       = panel.querySelector( '.sls-search-close' );
		var lastToggle = null;

		function setExpanded( value ) {
			Array.prototype.forEach.call( toggles, function ( t ) {
				t.setAttribute( 'aria-expanded', String( value ) );
			} );
		}

		function open( trigger ) {
			lastToggle = trigger || toggles[ 0 ];
			panel.hidden = false;
			window.requestAnimationFrame( function () {
				panel.classList.add( 'is-open' );
			} );
			setExpanded( true );
			document.body.classList.add( 'sls-search-open' );
			if ( field ) {
				field.focus();
			}
		}

		function hide() {
			panel.classList.remove( 'is-open' );
			setExpanded( false );
			document.body.classList.remove( 'sls-search-open' );
			window.setTimeout( function () {
				if ( ! panel.classList.contains( 'is-open' ) ) {
					panel.hidden = true;
				}
			}, 250 );
			if ( lastToggle ) {
				lastToggle.focus();
			}
		}

		Array.prototype.forEach.call( toggles, function ( t ) {
			t.addEventListener( 'click', function () {
				if ( panel.classList.contains( 'is-open' ) ) {
					hide();
				} else {
					open( t );
				}
			} );
		} );

		if ( close ) {
			close.addEventListener( 'click', hide );
		}

		panel.addEventListener( 'click', function ( event ) {
			if ( event.target === panel ) {
				hide();
			}
		} );

		document.addEventListener( 'keydown', function ( event ) {
			if ( ( event.key === 'Escape' || event.key === 'Esc' ) && panel.classList.contains( 'is-open' ) ) {
				hide();
			}
		} );
	}

	/**
	 * Reveal the compact sticky header once the main masthead is scrolled past.
	 */
	function initStickyHeader() {
		var header   = document.querySelector( '[data-sticky-header]' );
		var masthead = document.getElementById( 'masthead' );
		if ( ! header ) {
			return;
		}

		var trigger = masthead ? masthead.offsetHeight : 300;
		var ticking = false;

		function update() {
			header.classList.toggle( 'is-visible', window.pageYOffset > trigger );
			ticking = false;
		}

		window.addEventListener( 'scroll', function () {
			if ( ! ticking ) {
				window.requestAnimationFrame( update );
				ticking = true;
			}
		}, { passive: true } );

		window.addEventListener( 'resize', function () {
			trigger = masthead ? masthead.offsetHeight : 300;
			update();
		} );

		update();
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		bindToggle(
			document.querySelector( '.sls-nav-toggle' ),
			document.getElementById( 'site-navigation' ),
			'is-open'
		);
		initSearch();
		initStickyHeader();
	} );
}() );
