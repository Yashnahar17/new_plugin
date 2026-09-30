<?php
namespace AstraxAddons\Extensions;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Abstract base for all Astrax extensions.
 *
 * Each extension adds controls to the Elementor Advanced tab
 * for every element and hooks rendering logic to output
 * modified behavior (wrapper links, visibility rules, etc.).
 *
 * @since 1.0.0
 */
abstract class ExtensionBase {

	/**
	 * Constructor. Auto-registers hooks.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Extension initialization.
	 * Override to register Elementor hooks for controls and rendering.
	 */
	abstract protected function init();

	/**
	 * Get the extension slug.
	 *
	 * @return string
	 */
	abstract public function get_slug();

	/**
	 * Get the extension human-readable name.
	 *
	 * @return string
	 */
	abstract public function get_name();
}
