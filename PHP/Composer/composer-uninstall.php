<?php // @codingStandardsIgnoreStart.
/**
 * Composer Uninstall.
 *
 * -------------------
 *
 * Note this has been deprecated for https://github.com/aubreypwd/composer-uninstall
 *
 * -------------------
 *
 * # composer-uninstall.php
 *
 * This file was created because at WebDevStudios we use composer to manage dependencies and shared packages. We also use Git and a `composer.json` file to manage those dependences. Well, when switching branches where that `composer.json` file changes, we can't just remove a `vendor/` folder and do `composer-install` as our packages are installed to different plugin and theme locations.
 *
 * So, normally, I would have to find those, delete them, and run `composer install` again. But, that's hard to do on large projects. So this script will find all the packages installed via `composer.json` and will go delete the folder that package is installed into.
 *
 * = Installation =
 *
 * == Using `/usr/local/bin` ==
 *
 * On Mac/*nix, you can download this script and save it to your `/usr/local/bin` folder as e.g. `/usr/local/bin/composer-uninstall` and run `chmod +x /usr/local/bin/composer-uninstall` and now you should be able to run `composer-uninstall` anywhere.
 *
 * == Using an alias/function in Bash ==
 *
 * If you want to either clone this repo, or download a file you can always create a `.bash_profile`-ish alias like:
 *
 *     function composer-uninstall {
 *         php "/path/to/code/composer-uninstall/composer-uninstall.php"
 *     }
 *
 *     function composer-reinstall {
 *         composer-uninstall
 *         composer clear-cache
 *         composer install
 *     }
 *
 * Now running `composer-uninstall` will always run the PHP script. If you cloned my repo, you can always do a `git pull` to get the latest version of this file or re-download it to update it.
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
