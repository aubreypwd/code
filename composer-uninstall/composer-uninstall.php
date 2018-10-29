<?php // @codingStandardsIgnoreStart.
/**
 * Composer Uninstall.
 *
 * This will loop through installed packages and delete the folders
 * of those packages. When not using a simple /vendor folder for this,
 * this makes it easy to to a simple re-install of all packages.
 *
 * I would chmod +x this file, then create an alias that will execute this
 * script. Or, you could chmod +x this file and also create a symlink
 * in e.g. /usr/local/bin to it so you can execute it easily.
 *
 * @version  1.0.0  Monday, October 29, 2018
 * @author          Aubrey Portwood <aubrey@webdevstudios.com>
 */

// Get the paths by removing the package names from composer show -path.
$paths = array_unique( array_map( function( $path ) {
	if ( empty( $path ) ) {

		// Nope.
		return '';
	}

	// Get the packages so we can remove them from the below command.
	$packages = explode( "\n", shell_exec( "composer show --name-only" ) );
	if ( empty( $packages ) ) {

		// No packages, no paths.
		return '';
	}

	foreach ( $packages as $package ) {

		// Remove the package names.
		$path = str_replace( $package, '', $path );
	}

	// Show progress.
	echo ".";

	return stripslashes( trim( $path ) );
}, explode( "\n", shell_exec( "composer show --path" ) ) ) );

// If we have packages/paths to remove.
if ( count( $paths ) > 1 && is_array( $paths ) ) {

	// Remove those paths.
	foreach ( $paths as $path ) {
		if ( file_exists( $path ) ) {

			// Show progress.
			echo ".";

			// Try and remove that file/dir.
			shell_exec( "rm -R \"{$path}\"" );
		}
	}

	// The the user they can now run composer install.
	echo "\nYou can now run composer install.";
}
