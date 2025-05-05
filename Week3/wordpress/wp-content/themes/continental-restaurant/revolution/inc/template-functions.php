<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Continental Restaurant
 */

function continental_restaurant_body_classes( $continental_restaurant_classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$continental_restaurant_classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$continental_restaurant_classes[] = 'no-sidebar'; 
	}

	return $continental_restaurant_classes;
}
add_filter( 'body_class', 'continental_restaurant_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function continental_restaurant_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'continental_restaurant_pingback_header' );