<?php
/**
 * Plugin Name: Allowed File Types
 * Description: Adds file types to be allowed through the media library.
 * Version:     1.0.0
 * Author:      Aubrey Portwood
 * Author URI:  http://aubreypwd.com
 * License:     GPL2
 *
 * @package WebDevStudios/MuPlugins
 * @since   Tuesday, August 28, 2018
 */

add_filter( 'upload_mimes', function( $mime_types ) {
	return array_merge( $mime_types, array(
		'eot'   => 'application/vnd.ms-fontobject',
		'otf'   => 'application/font-sfnt',
		'svg'   => 'image/svg+xml',
		'ttf'   => 'application/x-font-ttf',
		'woff'  => 'application/octet-stream',
		'woff2' => 'application/octet-stream',
		'json'  => 'application/json',
	) );
}, 9999 );
