<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.glorywebs.com
 * @since             1.0.0
 * @package           Used_Media_Identifier
 *
 * @wordpress-plugin
 * Plugin Name:       Used Media Identifier
 * Plugin URI:        http://www.glorywebs.com/used_media_identifier
 * Description:       This plugin is used to identify media image is used for any post type
 * Version:           1.0.0
 * Author:            Glorywebs
 * Author URI:        http://www.glorywebs.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       used-media-identifier
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-used-media-identifier-activator.php
 */
function activate_used_media_identifier() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-used-media-identifier-activator.php';
	Used_Media_Identifier_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-used-media-identifier-deactivator.php
 */
function deactivate_used_media_identifier() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-used-media-identifier-deactivator.php';
	Used_Media_Identifier_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_used_media_identifier' );
register_deactivation_hook( __FILE__, 'deactivate_used_media_identifier' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-used-media-identifier.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_used_media_identifier() {

	$plugin = new Used_Media_Identifier();
	$plugin->run();

}
run_used_media_identifier();
