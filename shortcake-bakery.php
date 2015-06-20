<?php
/*
Plugin Name: Shortcake Bakery
Version: 0.1-alpha
Description: A fine selection of shortcodes for WordPress
Author: fusioneng
Author URI: http://github.com/fusioneng/
Plugin URI: http://github.com/fusioneng/shortcake-bakery
Text Domain: shortcake-bakery
Domain Path: /languages
*/

require_once dirname( __FILE__ ) . '/inc/class-shortcake-bakery.php';

/**
 * Load the Shortcake Bakery
 */
// @codingStandardsIgnoreStart
function Shortcake_Bakery() {
	return Shortcake_Bakery::get_instance();
}
// @codingStandardsIgnoreEnd
add_action( 'after_setup_theme', 'Shortcake_Bakery' );
