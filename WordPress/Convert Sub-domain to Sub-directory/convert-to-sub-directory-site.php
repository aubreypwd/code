<?php
/**
 * Plugin Name: Convert sub-domain MU install to sub-directory install
 * Description: When used, this will convert a sub-domain MU install to a sub-dir multisite install.
 * Version:     Tuesday, August 21, 2018
 * Author:      Aubrey Portwood
 * License:     GPL2
 * Author URI:
 * Plugin URI:
 *
 * @package     aubreypwd/mu-plugins
 * @since       Tuesday, August 21, 2018
 *
 * Note, I know it's a bit quick and lazy, but it works!
 */

// When WP loads.
add_action( 'init', function() {
	global $wpdb, $table_prefix;

	// @codingStandardsIgnoreLine: Tell us to do this using ?convert-to-sub-directory-site=.
	if ( isset( $_GET['convert-to-sub-directory-site'] ) ) {
		if ( ! current_user_can( 'administrator' ) ) {
			wp_die( esc_html__( 'You must be logged in as an administrator to do this, cheater.' ) );
		}

		// Don't run this on a sub-site.
		$current_site = get_site( get_current_blog_id() );
		if ( '/' !== $current_site->path || 1 !== absint( $current_site->blog_id ) ) {

			// If you run this on one of the sub-sites $domain won't be right below.
			wp_die( 'You must run this from the main site, e.g. <code>example.com/?convert-to-sub-directory-site</code>.' );
		}

		// The time.
		$time = time();

		// @codingStandardsIgnoreLine: Get what protocol they want to use.
		$protocol = isset( $_GET['to_protocol'] ) ? strtolower( str_replace( '://', '', $_GET['to_protocol'] ) ) : 'http';

		// Get the domain of the site.
		$domain = $current_site->domain;

		// Get un-converted sites.
		$sites = get_sites();
		foreach ( $sites as $site ) {
			if ( '/' !== $site->path ) {

				// Already converted to sub-dir, if a sub-dir would be /something.
				continue;
			}

			if ( 1 === absint( $site->blog_id ) ) {

				// Don't convert the main site.
				continue;
			}

			// Generate a path.
			$path = explode( '.', $site->domain );
			$path = "/{$path[0]}/";

			// Set up wp_blogs.
			$update_wp_blogs = $wpdb->update(
				$wpdb->blogs,
				array(
					'domain' => $domain,
					'path'   => $path,
				),
				array( 'domain' => $site->domain ), // Where.
				array(
					'%s',
					'%s',
				),
				array( '%s' )
			);

			// The new URL for options tables.
			$url = untrailingslashit( "{$protocol}://{$domain}{$path}" );

			// Update the site url to the right value.
			$update_site_url = $update_options = $wpdb->update(
				"{$table_prefix}{$site->blog_id}_options",
				array(
					'option_value' => $url, // example.com/path/.
				),
				array( 'option_name' => 'siteurl' ), // Where.
				array(
					'%s',
				),
				array( '%s' )
			);

			// Update the home to the right site value too.
			$update_home = $update_options = $wpdb->update(
				"{$table_prefix}{$site->blog_id}_options",
				array(
					'option_value' => $url, // example.com/path/.
				),
				array( 'option_name' => 'home' ), // Where.
				array(
					'%s',
				),
				array( '%s' )
			);

		} // each site.

		$htaccess_file = ABSPATH . '.htaccess';

		// @codingStandardsIgnoreLine: Make a backup of the htaccess.
		@copy( $htaccess_file, "{$htaccess_file}.{$time}.bak" );

		// The .htaccess we want to have for sub-dir network.
		$htaccess = str_replace( "\t", '', '
			RewriteEngine On
			RewriteBase /
			RewriteRule ^index\.php$ - [L]

			# add a trailing slash to /wp-admin
			RewriteRule ^([_0-9a-zA-Z-]+/)?wp-admin$ $1wp-admin/ [R=301,L]

			RewriteCond %{REQUEST_FILENAME} -f [OR]
			RewriteCond %{REQUEST_FILENAME} -d
			RewriteRule ^ - [L]
			RewriteRule ^([_0-9a-zA-Z-]+/)?(wp-(content|admin|includes).*) $2 [L]
			RewriteRule ^([_0-9a-zA-Z-]+/)?(.*\.php)$ $2 [L]
			RewriteRule . index.php [L]
		' );

		// @codingStandardsIgnoreLine: Replace with new htaccess file.
		@file_put_contents( $htaccess_file, $htaccess );

		// Combos for changing to false.
		$possibilities = array(
			"define( 'SUBDOMAIN_INSTALL', true );",
			"define('SUBDOMAIN_INSTALL', true);",
			"define('SUBDOMAIN_INSTALL',true);",
			"define( 'SUBDOMAIN_INSTALL', 1 );",
			"define('SUBDOMAIN_INSTALL', 1);",
			"define('SUBDOMAIN_INSTALL',1);",
		);

		$wp_config_file = ABSPATH . 'wp-config.php';

		// @codingStandardsIgnoreLine: Make a backup of wp-config.php.
		@copy( $wp_config_file, "{$wp_config_file}.{$time}.bak" );

		$wp_config = @file_get_contents( $wp_config_file ); // @codingStandardsIgnoreLine
		foreach ( $possibilities as $replace ) {

			// Make sure we set this to false.
			$wp_config = str_replace( $replace, "define( 'SUBDOMAIN_INSTALL', false );", $wp_config );
		}

		// @codingStandardsIgnoreLine: Make sure we are not in subdomain install anymore.
		@file_put_contents( $wp_config_file, $wp_config );

		// Stop here.
		wp_die( 'Done, site should be converted to a sub-directory site.' );

	} // if convert-to-sub-directory-site.
} );
