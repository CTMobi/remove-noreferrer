<?php
/**
 * Admin's part of the plugin : Plugin class
 *
 * Manages plugin's backend
 *
 * @package Remove_Noreferrer
 * @subpackage Admin
 * @since 1.1.0
 */

namespace Remove_Noreferrer\Admin;

/**
 * Admin's part of the plugin
 *
 * @since 1.1.0
 */
class Plugin extends \Remove_Noreferrer\Base\Plugin {
	/**
	 * Where should plugin's menu item be located
	 *
	 * @since 1.1.0
	 * @access public
	 * @var string GRN_PARENT_SLUG
	 */
	const GRN_PARENT_SLUG = 'options-general.php';

	/**
	 * Plugin's menu slug
	 *
	 * @since 1.1.0
	 * @access public
	 * @var string GRN_MENU_SLUG
	 */
	const GRN_MENU_SLUG = 'remove_noreferrer';

	/**
	 * Plugin's nonce value
	 *
	 * @since 1.1.0
	 * @access public
	 * @var string GRN_NONCE_VALUE
	 */
	const GRN_NONCE_VALUE = 'gruz0_remove_noreferrer_nonce';

	/**
	 * Plugin's nonce action
	 *
	 * @since 1.1.0
	 * @access public
	 * @var string GRN_NONCE_ACTION
	 */
	const GRN_NONCE_ACTION = 'remove_noreferrer';

	/**
	 * Remove_Noreferrer\Core\Options instance
	 *
	 * @since 2.0.0
	 * @access private
	 * @var Remove_Noreferrer\Core\Options $_options
	 */
	private $_options;

	/**
	 * Constructor
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param \Remove_Noreferrer\Core\Options $options Options class.
	 */
	public function __construct( \Remove_Noreferrer\Core\Options $options ) {
		$this->_options = $options;

		parent::__construct();
	}

	/**
	 * Initializes plugin
	 *
	 * @since 2.0.0
	 * @access public
	 */
	public function init() {
		add_action( 'admin_menu', array( & $this, 'add_menu' ) );
		add_action( 'admin_post_remove_noreferrer_update_options', array( & $this, 'update_options' ) );

		parent::init();
	}

	/**
	 * Add options page under the Settings menu
	 *
	 * @since 1.1.0
	 * @access public
	 */
	public function add_menu() {
		$page_title = __( 'Remove Noreferrer Options', 'remove-noreferrer' );
		$menu_title = __( 'Remove Noreferrer', 'remove-noreferrer' );
		$capability = 'manage_options';
		$function   = array( & $this, 'render_options_page' );

		add_submenu_page( self::GRN_PARENT_SLUG, $page_title, $menu_title, $capability, self::GRN_MENU_SLUG, $function );
	}

	/**
	 * Validate and save options
	 *
	 * @since 1.1.0
	 * @access public
	 */
	public function update_options() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Unauthorized user' );
		}

		if ( empty( $_POST[ self::GRN_NONCE_VALUE ] ) ) {
			wp_die( __( 'Nonce must be set', 'remove-noreferrer' ) );
		}

		if ( ! wp_verify_nonce( $_POST[ self::GRN_NONCE_VALUE ], self::GRN_NONCE_ACTION ) ) {
			wp_die( __( 'Invalid nonce', 'remove-noreferrer' ) );
		}

		$new_values = $_POST['remove_noreferrer'] ?? array();

		update_option( GRN_OPTION_KEY, $this->validate_options( $new_values ) );

		wp_redirect(
			add_query_arg(
				array(
					'page'    => self::GRN_MENU_SLUG,
					'updated' => true,
					'tab'     => $this->get_current_tab(),
				),
				admin_url( self::GRN_PARENT_SLUG )
			),
			303
		);

		exit;
	}

	/**
	 * Render form
	 *
	 * @since 1.1.0
	 * @access public
	 */
	public function render_options_page() {
		echo $this->options_page()->render( $this->_options->get_options(), $this->get_current_tab() );
	}

	/**
	 * Options Page class
	 *
	 * @since 1.1.0
	 * @access private
	 *
	 * @return Remove_Noreferrer\Admin\Options_Page
	 */
	private function options_page() {
		return new Options_Page();
	}

	/**
	 * Validate and sanitize options
	 *
	 * @since 1.1.0
	 * @access private
	 *
	 * @param mixed $new_values New values.
	 *
	 * @return array
	 */
	private function validate_options( $new_values ) {
		return $this->options_validator()->call( $new_values );
	}

	/**
	 * Options Validator class
	 *
	 * @since 1.1.0
	 * @access private
	 *
	 * @return Remove_Noreferrer\Admin\Options_Validator
	 */
	private function options_validator() {
		return new Options_Validator();
	}

	/**
	 * Returns current tab
	 *
	 * @since 2.0.0
	 * @access private
	 *
	 * @return string
	 */
	private function get_current_tab() {
		return $_GET['tab'] ?? 'general';
	}
}

