<?php // phpcs:disable
/**
 * Thrive Apprentice Symlink Solution
 * 
 * Thrive Apprentice uses realpath so if you have symlinks anywhere
 * in WordPress it will break.
 * 
 * This seems to fix most problems.
 * 
 * @since   Jan 11, 2024
 * @version 1.0.0
 */

add_filter( 'tve_external_architect', function ( $versions ) {

	$version = end( array_keys( $versions ) );

	$versions[ $version ]['path'] = str_replace(
		'/Users/aubreypwd/Repos/github.com/awesomemotive/affiliate-wp/',
		ABSPATH . 'wp-content/plugins/',
		$versions[ $version ]['path']
	);

	$versions[ $version ]['url'] = str_replace(
		'/Users/aubreypwd/Repos/github.com/awesomemotive/affiliate-wp/',
		home_url( 'wp-content/plugins/' ),
		$versions[ $version ]['url']
	);

	return $versions;

}, 99999 );
