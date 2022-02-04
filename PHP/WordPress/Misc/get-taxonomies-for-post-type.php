<?php

/**
 * Get taxonomies for a post type.
 *
 * This hunts through all the taxonomies and figures out if the
 * supplied post type is in it's list of object types.
 *
 * If it is, it stays in the list.
 *
 * @author Aubrey Portwood <aubrey@webdevstudios.com>
 * @since  Friday, February 4, 2022
 * @param  string $post_type Post Type.
 * @return array
 */
function get_taxonomies_for_post_type( string $post_type ) : array {

	static $cache = [];

	if ( is_array( $cache[ $post_type ]) ) {
		return $cache[ $post_type ];
	}

	static $wp_taxonomies = null;

	// We're going to need this list for later, cache it.
	$wp_taxonomies = is_null( $wp_taxonomies )
		? get_taxonomies( [], 'objects' )
		: $wp_taxonomies; // Cached.

	return $cache[ $post_type ] = array_values(
		array_map(
			function( $term ) {
				return $term->name;
			},
			array_filter(
				$wp_taxonomies,
				function( $term ) use ( $post_type ) {
					return in_array(
						$post_type,
						$term->object_type,
						true
					);
				}
			)
		)
	);
}
