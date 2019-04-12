<?php

/**
 * Get fully qualified function name.
 *
 * @author Aubrey Portwood <aubrey@webdevstudios.com>
 * @since  Friday, April 12, 2019
 *
 * @param  string $func The function.
 * @return string       Fully qualified function name.
 */
function namespace_func( string $func ) : string {
	return __NAMESPACE__ . '\\' . $func;
}
