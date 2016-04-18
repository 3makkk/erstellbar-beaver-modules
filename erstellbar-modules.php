<?php
/**
 * Plugin Name: Erstellbar -  Beaver Modules
 * Plugin URI: http://www.erstellbar.de
 * Description: Erstellbar plugin for custom builder modules.
 * Version: 1.1
 * Author: Sven Friedemann
 * Author URI: http://erstellbar.de
 */
define( 'ERSTELLBAR_MODULES_DIR', plugin_dir_path( __FILE__ ) );
define( 'ERSTELLBAR_MODULES_URL', plugins_url( '/', __FILE__ ) );
define('ERSTELLBAR_SLUG', 'erstellbar');

/**
 * Custom modules
 */
function fl_load_module_examples() {
	if ( class_exists( 'FLBuilder' ) ) {
	    require_once 'slick-slider/slick-slider.php';
		require_once 'last-posts/last-posts.php';
        require_once 'button/button.php';
        require_once 'callout/callout.php';
	}
}
add_action( 'init', 'fl_load_module_examples' );


/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
add_action( 'plugins_loaded', 'tp_bb_load_textdomain_erstellbar' );
function tp_bb_load_textdomain_erstellbar()
{
	load_plugin_textdomain( ERSTELLBAR_SLUG, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
}

/**
 * Custom fields
 */
function erstellbar_number_field( $name, $value, $field ) {
    echo '<input type="number" class="text text-full" name="' . $name . '" value="' . $value . '" />';
}
add_action( 'fl_builder_control_erstellbar-number', 'erstellbar_number_field', 1, 3 );
