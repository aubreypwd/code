<?php
/**
 * Redirects traffic from https:// to http://
 *
 * #WordPress
 *
 * @since Tuesday, September 4, 2018
 * @package code
 */

// @codingStandardsIgnoreLine: Add this to wp-config.php.
if ( $_SERVER['HTTPS'] == 'on' ) {

	// Go to non https:// version.
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	// Go there.
	header( 'HTTP/1.1 301 Moved Permanently' );
	header( "Location: {$redirect}" );

	// Stop here.
	exit();
}
