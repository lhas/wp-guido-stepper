<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://0e1dev.com
 * @since      1.0.0
 *
 * @package    Wp_Guido_Stepper
 * @subpackage Wp_Guido_Stepper/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Guido_Stepper
 * @subpackage Wp_Guido_Stepper/includes
 * @author     lhas <luizhrqas@gmail.com>
 */
class Wp_Guido_Stepper_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-guido-stepper',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
