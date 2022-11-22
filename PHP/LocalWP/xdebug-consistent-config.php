<?php
/**
 * Ensure your LocalWP (https://localwp.com) xDebug configuration is consistent.
 *
 * Change to your configuration and place this in your wp-config.php file.
 *
 * This ensures that:
 *
 * 1. The port for both v2 and v3 of xDebug is set to 9021
 * 2. For xDebug v2 xdebug.remote_autostart is turned On
 * 3. For xDebug v3 xdebug.start_with_request is set to yes vs trigger
 *
 * This will go through all your php.ini.hbs files in conf and set xDebug up
 * this way.
 *
 * The reason I use this is because when you switch PHP versions Local doesn't keep your
 * configurations (mainly autostart and the port), it can turn it off and reset the
 * port to 9003 which can conflict with your local php.
 *
 * @since Nov 22, 2022
 * @author Aubrey Portwood <code@aubreypwd.com>
 */

// Make sure PHP.ini xDebug configuration is the way you like it.
foreach ( glob( dirname( dirname( __DIR__ ) ) . "/conf/php*", GLOB_BRACE ) as $php_dir ) {

	$php_ini = "{$php_dir}/php.ini.hbs";

	if ( ! file_exists( $php_ini ) ) {
		continue;
	}

	$contents = file_get_contents( $php_ini );

	$contents = str_replace(
		array(

			// xDebug v3
			'xdebug.client_port=9003', // Set your preferred port here.
			'xdebug.start_with_request=trigger',

			// xDebug v2
			'xdebug.remote_port="9000"',
			'xdebug.remote_connect_back=Off',
		),
		array(

			// xDebug v3
			'xdebug.client_port=9021',
			'xdebug.start_with_request=yes',

			// xDebug v2
			'xdebug.remote_port="9021"', // Set your preferred port here.
			"xdebug.remote_connect_back=On\nxdebug.remote_autostart=1",
		),
		$contents
	);

	file_put_contents( $php_ini, $contents );
}