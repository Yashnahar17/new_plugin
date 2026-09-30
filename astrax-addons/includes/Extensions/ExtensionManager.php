<?php
namespace AstraxAddons\Extensions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Extension Manager.
 *
 * Registers all Elementor extensions (cross-cutting features
 * that apply to every element via the Advanced tab).
 * Each extension is a self-contained class that hooks
 * its own controls and rendering logic.
 *
 * @since 1.0.0
 */
class ExtensionManager {

	/**
	 * Loaded extension instances.
	 *
	 * @var array<string, ExtensionBase>
	 */
	private $extensions = [];

	/**
	 * Constructor. Register extensions via elementor/init.
	 */
	public function __construct() {
		$this->register_extensions();
	}

	/**
	 * Register all available extensions.
	 *
	 * Each extension class self-registers its Elementor hooks.
	 * Extensions are conditionally loaded based on admin settings
	 * (to be wired in Phase 7 dashboard).
	 */
	private function register_extensions() {
		$extension_classes = [
			'wrapper_link' => WrapperLink::class,
			'visibility'   => Visibility::class,
			'sticky'       => Sticky::class,
			'motion'       => Motion::class,
		];

		/**
		 * Filter registered extensions.
		 *
		 * @param array<string, string> $extension_classes Extension slug => class map.
		 */
		$extension_classes = apply_filters( 'astrax_addons/extensions/registered', $extension_classes );

		$disabled = get_option( 'astrax_disabled_extensions', [] );
		if ( ! is_array( $disabled ) ) {
			$disabled = [];
		}

		foreach ( $extension_classes as $slug => $class_name ) {
			if ( in_array( $slug, $disabled, true ) ) {
				continue; // Skip loading disabled extensions.
			}

			if ( class_exists( $class_name ) ) {
				$this->extensions[ $slug ] = new $class_name();
			}
		}
	}

	/**
	 * Get a loaded extension by slug.
	 *
	 * @param string $slug Extension slug.
	 * @return ExtensionBase|null
	 */
	public function get_extension( $slug ) {
		return isset( $this->extensions[ $slug ] ) ? $this->extensions[ $slug ] : null;
	}

	/**
	 * Get all loaded extensions.
	 *
	 * @return array<string, ExtensionBase>
	 */
	public function get_extensions() {
		return $this->extensions;
	}
}
