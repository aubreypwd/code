/**
 * Expands yourself when Harvest Forecast loads.
 *
 * I use this in my WebCatalog app where you can goto
 *
 *     Developer > JS Code Injection
 *
 * ...and add it there.
 *
 * Make sure and replace my name with your own ;)
 *
 * @since Dec 17, 2021 Quick and dirty version.
 */

setInterval( function() {

	var person = 'Aubrey Portwood'; // Replace with your name.

	$( '.team-rows .row-info' ).each( function( i, element ) {

		var el = $( element );

		if ( el.hasClass( 'checked' ) ) {
			return; // We already looked at this one.
		}

		if ( -1 === el.html().indexOf( person ) ) {

			el.addClass( 'checked' ); // Not me, don't check again.

			return;
		}

		// Expand mine, and never do it again.
		$( element ).click().addClass( 'checked' );
	} );
}, 200 );
