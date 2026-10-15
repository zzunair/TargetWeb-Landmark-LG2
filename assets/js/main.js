(function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {

		/* ---------- Mobile menu toggle ---------- */
		var toggle = document.querySelector( '.gl-mobile-toggle' );
		var menu   = document.getElementById( 'gl-mobile-menu' );
		if ( toggle && menu ) {
			toggle.addEventListener( 'click', function () {
				var isOpen = menu.classList.toggle( 'is-open' );
				toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
			} );
		}

		/* ---------- FAQ accordion ---------- */
		document.querySelectorAll( '[data-gl-accordion] .gl-faq-item__question' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var item = btn.closest( '.gl-faq-item' );
				var wasOpen = item.classList.contains( 'is-open' );

				item.parentElement.querySelectorAll( '.gl-faq-item' ).forEach( function ( el ) {
					el.classList.remove( 'is-open' );
					el.querySelector( '.gl-faq-item__question' ).setAttribute( 'aria-expanded', 'false' );
				} );

				if ( ! wasOpen ) {
					item.classList.add( 'is-open' );
					btn.setAttribute( 'aria-expanded', 'true' );
				}
			} );
		} );

		/* ---------- Testimonial slider ---------- */
		document.querySelectorAll( '[data-gl-slider]' ).forEach( function ( slider ) {
			var slides = slider.querySelectorAll( '.gl-testimonial-card' );
			var dots   = slider.querySelectorAll( '.gl-dot' );
			var index  = 0;

			function show( i ) {
				slides.forEach( function ( s, si ) { s.classList.toggle( 'is-active', si === i ); } );
				dots.forEach( function ( d, di ) { d.classList.toggle( 'is-active', di === i ); } );
				index = i;
			}

			dots.forEach( function ( dot ) {
				dot.addEventListener( 'click', function () {
					show( parseInt( dot.getAttribute( 'data-goto' ), 10 ) );
				} );
			} );

			if ( slides.length ) {
				show( 0 );
				if ( slides.length > 1 ) {
					setInterval( function () {
						show( ( index + 1 ) % slides.length );
					}, 6000 );
				}
			}
		} );

	} );
})();
