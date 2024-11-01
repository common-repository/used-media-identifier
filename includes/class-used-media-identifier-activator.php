<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.glorywebs.com
 * @since      1.0.0
 *
 * @package    Used_Media_Identifier
 * @subpackage Used_Media_Identifier/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Used_Media_Identifier
 * @subpackage Used_Media_Identifier/includes
 * @author     Glorywebs <ravi@glorywebsdev.com>
 */
class Used_Media_Identifier_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
            $upload = wp_upload_dir();
            $upload_dir = $upload['basedir'];
            $upload_dir = $upload_dir . '/media_labels';
            if (! is_dir($upload_dir)) {
               mkdir( $upload_dir, 0700 );
            }
        }

}
