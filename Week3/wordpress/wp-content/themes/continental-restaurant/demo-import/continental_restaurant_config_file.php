<?php
/**
 * Settings for theme wizard
 *
 * @package Whizzie
 * @author Catapult Themes
 * @since 1.0.0
 */

/**
 * Define constants
 **/
if ( ! defined( 'WHIZZIE_DIR' ) ) {
	define( 'WHIZZIE_DIR', dirname( __FILE__ ) );
}
// Load the Whizzie class and other dependencies
require trailingslashit( WHIZZIE_DIR ) . 'importer.php';
// Gets the theme object
$current_theme = wp_get_theme();
$theme_title = $current_theme->get( 'Name' );

/**
 * Make changes below
 **/

// Change the title and slug of your wizard page
$continental_restaurant_config['page_slug'] 	= 'continental-restaurant';
$continental_restaurant_config['page_title']	= 'Get Started';

// You can remove elements here as required
// Don't rename the IDs - nothing will break but your changes won't get carried through
$continental_restaurant_config['steps'] = array(
	'intro' => array(
		'id'			=> 'intro', // ID for section - don't rename
		'title'			=> __( 'Welcome to ', 'continental-restaurant' ) . $theme_title, // Section title
		'icon'			=> 'dashboard', // Uses Dashicons
		'button_text'	=> __( 'System Status', 'continental-restaurant' ), // Button text
		'can_skip'		=> false, // Show a skip button?
		'icon_url'      => get_template_directory_uri().'/demo-import/assets/images/Icons-01.png'
	),
	'plugins' => array(
		'id'			=> 'plugins',
		'title'			=> __( 'Plugins', 'continental-restaurant' ),
		'icon'			=> 'admin-plugins',
		'button_text'	=> __( 'Install Plugins', 'continental-restaurant' ),
		'can_skip'		=> true,
	),
	'widgets' => array(
		'id'			=> 'widgets',
		'title'			=> __( 'Demo Importer', 'continental-restaurant' ),
		'icon'			=> 'welcome-widgets-menus',
		'button_text_one'	=> __( 'Click On The Image To Import Customizer Demo', 'continental-restaurant' ),
		'button_text_two'	=> __( 'Click On The Image To Import Gutenberg Block Demo', 'continental-restaurant' ),
		'can_skip'		=> true,
	),
	'done' => array(
		'id'			=> 'done',
		'title'			=> __( 'All Done', 'continental-restaurant' ),
		'icon'			=> 'yes',
	)
);

/**
 * This kicks off the wizard
 **/
if( class_exists( 'ThemeWhizzie' ) ) {
	$ThemeWhizzie = new ThemeWhizzie( $continental_restaurant_config );
}
