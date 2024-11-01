<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.glorywebs.com
 * @since      1.0.0
 *
 * @package    Used_Media_Identifier
 * @subpackage Used_Media_Identifier/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Used_Media_Identifier
 * @subpackage Used_Media_Identifier/includes
 * @author     Glorywebs <ravi@glorywebsdev.com>
 */
class Used_Media_Identifier_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'used-media-identifier',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
