/**
 * Header interactions:
 *   - mobile menu toggle
 *   - full-screen search overlay (open/close, Escape, backdrop click, focus)
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
	 * Full-screen search overlay.
	 */
	function initSearch() {
		var toggle = document.querySelector( '.sls-search-toggle' );
		var panel  = document.getElementById( 'sls-search-panel' );
		if ( ! toggle || ! panel ) {
			return;
		}

		var field = panel.querySelector( '.sls-search-field' );
		var close = panel.querySelector( '.sls-search-close' );

		function open() {
			panel.hidden = false;
			// Let the browser paint `hidden=false` before adding the transition class.
			window.requestAnimationFrame( function () {
				panel.classList.add( 'is-open' );
			} );
			toggle.setAttribute( 'aria-expanded', 'true' );
			document.body.classList.add( 'sls-search-open' );
			if ( field ) {
				field.focus();
			}
		}

		function hide() {
			panel.classList.remove( 'is-open' );
			toggle.setAttribute( 'aria-expanded', 'false' );
			document.body.classList.remove( 'sls-search-open' );
			// Wait for the fade-out before removing from the a11y tree.
			window.setTimeout( function () {
				if ( ! panel.classList.contains( 'is-open' ) ) {
					panel.hidden = true;
				}
			}, 250 );
			toggle.focus();
		}

		toggle.addEventListener( 'click', function () {
			if ( panel.classList.contains( 'is-open' ) ) {
				hide();
			} else {
				open();
			}
		} );

		if ( close ) {
			close.addEventListener( 'click', hide );
		}

		// Click on the dark backdrop (but not the form/close inside) closes.
		panel.addEventListener( 'click', function ( event ) {
			if ( event.target === panel ) {
				hide();
			}
		} );

		// Escape closes when open.
		document.addEventListener( 'keydown', function ( event ) {
			if ( ( event.key === 'Escape' || event.key === 'Esc' ) && panel.classList.contains( 'is-open' ) ) {
				hide();
			}
		} );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		bindToggle(
			document.querySelector( '.sls-nav-toggle' ),
			document.getElementById( 'site-navigation' ),
			'is-open'
		);
		initSearch();
	} );
}() );
