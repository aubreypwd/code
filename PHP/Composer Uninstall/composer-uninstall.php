<?php // @codingStandardsIgnoreStart.
/**
 * Composer Uninstall.
 *
 * This will loop through installed packages and delete the folders
 * of those packages. When not using a simple /vendor folder for this,
 * this makes it easy to to a simple re-install of all packages.
 *
 * I would chmod +x this file, then create an alias that will execute this
 * script.
 *
 * See example at: https://github.com/aubreypwd/Bash/search?q=composer+uninstall&unscoped_q=composer+uninstall
 *
 * @version  1.0.1  Monday, October 29, 2018 <Better progress messages.>
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

	// Find the path's of the packages.
	foreach ( $packages as $package ) {

		// Something smaller to show...
		$p = trim( $package );

		// Remove the package names.
		$path = str_replace( $package, '', $path );
	}

	return stripslashes( trim( $path ) );
}, explode( "\n", shell_exec( "composer show --path" ) ) ) );

// If we have packages/paths to remove.
if ( count( $paths ) > 1 && is_array( $paths ) ) {

	// Remove those paths.
	foreach ( $paths as $path ) {
		if ( file_exists( $path ) ) {

			// Get something smaller to show.
			$small_path = basename( $path );

			// Show a message.
			echo "Removing {$small_path}...";

			// Try and remove that file/dir.
			shell_exec( "rm -Rf \"{$path}\"" );

			// Done!
			echo "Done!\n";
		}
	}

	echo "\nFinished.";
}
