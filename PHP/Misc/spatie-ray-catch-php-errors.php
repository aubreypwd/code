<?php

/**
 * Report errors to Spatie Ray.
 *
 * Add to your `wp-config.php` in WordPress.
 *
 * @author Aubrey Portwood <aubrey@webdevstudios.com>
 * @since  Monday, December 27, 2021
 * @return void
 */
function ____error_to_spatie_ray() {

	$error = error_get_last();

	if ( $error === NULL ) {
		return;
	}

	// Comment these out to ignore notices and warnings.
	if ( in_array( true, [
		// $error['type'] === E_WARNING,
		// $error['type'] === E_NOTICE,
		// $error['type'] === E_CORE_WARNING,
		// $error['type'] === E_COMPILE_WARNING,
		// $error['type'] === E_USER_WARNING,
		// $error['type'] === E_USER_NOTICE,
	], true ) ) {
		return;
	}

	\ray( $error );
}
register_shutdown_function( '____error_to_spatie_ray' );
