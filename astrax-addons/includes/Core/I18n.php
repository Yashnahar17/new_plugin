<?php
namespace AstraxAddons\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles Internationalization setup.
 */
class I18n {

	/**
	 * Constructor. Loads the plugin textdomain.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'load_plugin_textdomain' ] );
	}

	/**
	 * Load text domain for translations.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'astrax-addons',
			false,
			dirname( plugin_basename( ASTRAX_ADDONS_FILE ) ) . '/languages/'
		);
	}
}
