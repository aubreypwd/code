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

	// Comment these out to ignore errors.
	if ( in_array( true, [

		/* Ignore Notices, Warnings, and Deprecations */

			$error['type'] === E_WARNING,
			$error['type'] === E_NOTICE,
			// $error['type'] === E_CORE_WARNING,
			// $error['type'] === E_COMPILE_WARNING,
			// $error['type'] === E_USER_WARNING,
			// $error['type'] === E_USER_NOTICE,
			// $error['type'] === E_STRICT,
			// $error['type'] === E_RECOVERABLE_ERROR,
			// $error['type'] === E_DEPRECATED,
			// $error['type'] === E_USER_DEPRECATED,

		/* Ignore Errors */

			// $error['type'] === E_ERROR,
			// $error['type'] === E_PARSE,
			// $error['type'] === E_CORE_ERROR,
			// $error['type'] === E_COMPILE_ERROR,
			// $error['type'] === E_USER_ERROR,

	], true ) ) {

		// Don't show anything in Ray about these.
		return;
	}

	// If we hit any of theses ERROR's, we'll show the app so you know.
	if ( in_array( true, [

		/* Errors */

		$error['type'] === E_ERROR,
		$error['type'] === E_PARSE,
		$error['type'] === E_CORE_ERROR,
		$error['type'] === E_COMPILE_ERROR,
		$error['type'] === E_USER_ERROR,

	], true ) ) {

		// Log the error (in red) and show Ray.
		\ray( $error )->showApp()->red();
		return;
	}

	\ray( $error ); // Just log the error to Ray.
}
register_shutdown_function( '____error_to_spatie_ray' );
