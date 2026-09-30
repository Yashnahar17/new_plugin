<?php
namespace AstraxAddons\Core;

use AstraxAddons\Compatibility\CompatibilityManager;
use AstraxAddons\Assets\AssetManager;
use AstraxAddons\Widgets\WidgetManager;
use AstraxAddons\Extensions\ExtensionManager;
use AstraxAddons\Templates\TemplateManager;
use AstraxAddons\Admin\Settings;
use AstraxAddons\REST\RestManager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin orchestrator singleton.
 */
final class Plugin {
	private static $instance = null;

	public $assets;
	public $widgets;
	public $extensions;
	public $templates;
	public $settings;
	public $rest;
	public $i18n;

	/**
	 * Get instance.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor. Initializes the plugin lifecycle.
	 */
	private function __construct() {
		// Initialize internationalization.
		$this->i18n = new I18n();

		// Check compatibility before doing anything.
		$compatibility = new CompatibilityManager();
		if ( ! $compatibility->is_compatible() ) {
			return;
		}

		// Proceed with initialization via Elementor hooks.
		add_action( 'elementor/init', [ $this, 'init' ] );
		
		// Admin settings and REST API don't rely on Elementor init.
		$this->settings = new Settings();
		$this->rest     = new RestManager();
		$this->templates = new TemplateManager();
	}

	/**
	 * Initialize core components once Elementor is ready.
	 */
	public function init() {
		$this->assets     = new AssetManager();
		$this->widgets    = new WidgetManager();
		$this->extensions = new ExtensionManager();
	}
}
