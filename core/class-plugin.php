<?php
/**
 * Core class
 *
 * @package Remove_Noreferrer
 * @subpackage Core
 * @since 1.3.0
 */

namespace Remove_Noreferrer\Core;

use Remove_Noreferrer\Admin\Plugin as Admin;
use Remove_Noreferrer\Frontend\Plugin as Frontend;
use Remove_Noreferrer\Frontend\Links_Processor as Links_Processor;

/**
 * Core class
 *
 * @since 1.3.0
 */
class Plugin {
	/**
	 * Remove_Noreferrer\Core\Options instance
	 *
	 * @since 1.3.0
	 * @access private
	 * @var \Remove_Noreferrer\Core\Options $_options
	 */
	private $_options;

	/**
	 * Constructor
	 *
	 * @since 1.3.0
	 * @access public
	 *
	 * @param \Remove_Noreferrer\Core\Options $options Options class.
	 */
	public function __construct( \Remove_Noreferrer\Core\Options $options ) {
		$this->_options = $options;

		do_action( 'remove_noreferrer_core_plugin_loaded' );
	}

	/**
	 * Activates plugin
	 *
	 * @since 1.3.0
	 * @access public
	 * @static
	 */
	public static function activate() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		do_action( 'remove_noreferrer_core_plugin_activated' );
	}

	/**
	 * Deactivates plugin
	 *
	 * @since 1.3.0
	 * @access public
	 * @static
	 */
	public static function deactivate() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		do_action( 'remove_noreferrer_core_plugin_deactivated' );
	}

	/**
	 * Uninstalls plugin
	 *
	 * @since 1.3.0
	 * @access public
	 * @static
	 */
	public static function uninstall() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		do_action( 'remove_noreferrer_core_plugin_uninstalled' );
	}
}

