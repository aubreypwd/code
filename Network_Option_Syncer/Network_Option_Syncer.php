<?php // @codingStandardsIgnoreLine: PSR4 Auto-loading.
/**
 * Syncs an option network-wide.
 *
 * @since  1.0.0
 * @package  WebDevStudios\AWA_Mareto_Program_ID
 */

namespace WebDevStudios\AWA_Mareto_Program_ID\Network_Option_Syncer;

/**
 * Sync an option network-wide.
 *
 * @since  1.0.0
 */
class Network_Option_Syncer implements \WebDevStudios\OopsWP\Utility\Hookable {

	/**
	 * This is documented in self::__construct.
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @var string
	 */
	private $option = '';

	/**
	 * Constructor
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @param  string $option The option name you want to sync network-wide.
	 *
	 * @throws \Exception If you try and pass an empty value for `$option`.
	 */
	public function __construct( string $option ) {
		if ( empty( $option ) ) {
			throw new \Exception( 'self::$option needs to be a non-empty value.' );
		}

		$this->option = $option;
	}

	/**
	 * Network Hooks
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @param string $how Set to `unregister` to unregister the hooks, leave empty to register hooks.
	 *
	 * @return void If we unregister, we bail before registrations.
	 */
	public function register_hooks( string $how = '' ) {
		$callback = [ $this, 'update_option_network_wide' ];

		$update_action = "update_option_{$this->option}";

		if ( 'unregister' === $how ) {
			remove_action( $update_action, $callback, 10 );
			return;
		}

		add_action( $update_action, $callback, 10, 3 );
	}

	/**
	 * Update the option network-wide.
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  1.0.0
	 *
	 * @param  string $old_value   Old value.
	 * @param  string $new_value   The new value.
	 * @param  string $option_name The option name/slug.
	 * @return string              The new value.
	 */
	public function update_option_network_wide( string $old_value, string $new_value, string $option_name ) : string {
		$blogs = get_sites();

		$this->register_hooks( 'unregister' ); // Don't cause an infinite loop.

		foreach ( $blogs as $blog ) {

			// Make sure every other blog in the network also has this same option.
			update_blog_option( $blog->blog_id, $option_name, $new_value );
		}

		$this->register_hooks(); // Catch the next save.

		return $new_value;
	}
}
