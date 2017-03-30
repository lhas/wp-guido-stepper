<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://0e1dev.com
 * @since             1.0.0
 * @package           Wp_Guido_Stepper
 *
 * @wordpress-plugin
 * Plugin Name:       WP Guido Stepper
 * Plugin URI:        http://0e1dev.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            lhas
 * Author URI:        http://0e1dev.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-guido-stepper
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-guido-stepper-activator.php
 */
function activate_wp_guido_stepper() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-guido-stepper-activator.php';
	Wp_Guido_Stepper_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-guido-stepper-deactivator.php
 */
function deactivate_wp_guido_stepper() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-guido-stepper-deactivator.php';
	Wp_Guido_Stepper_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_guido_stepper' );
register_deactivation_hook( __FILE__, 'deactivate_wp_guido_stepper' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-guido-stepper.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_guido_stepper() {

	$plugin = new Wp_Guido_Stepper();
	$plugin->run();

}
run_wp_guido_stepper();
