<?php
require get_template_directory() . '/demo-import/tgm/class-tgm-plugin-activation.php';
/**
 * Recommended plugins.
 */
function continental_restaurant_register_recommended_plugins_set() {
	$plugins = array(
		array(
			'name'             => __( 'Woocommerce', 'continental-restaurant' ),
			'slug'             => 'woocommerce',
			'source'           => '',
			'required'         => true,
			'force_activation' => false,
		),
	);
	$continental_restaurant_config = array();
	tgmpa( $plugins, $continental_restaurant_config );
}
add_action( 'tgmpa_register', 'continental_restaurant_register_recommended_plugins_set' );
