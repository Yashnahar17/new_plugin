<?php
namespace AstraxAddons\Assets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles centralized asset registration for Elementor.
 */
class AssetManager {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'register_styles' ] );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_scripts' ] );
		add_filter( 'script_loader_tag', [ $this, 'optimize_script_loading' ], 10, 2 );
	}

	/**
	 * Register frontend styles.
	 */
	public function register_styles() {
		// Centralized registry for all widget styles.
		wp_register_style( 'astrax-v3-widgets', ASTRAX_ADDONS_URL . 'assets/css/v3-widgets.css', [], ASTRAX_ADDONS_VERSION );
		wp_register_style( 'astrax-image-accordion', ASTRAX_ADDONS_URL . 'assets/css/image-accordion.css', [], ASTRAX_ADDONS_VERSION );
		wp_register_style( 'astrax-tabs', ASTRAX_ADDONS_URL . 'assets/css/tabs.css', [], ASTRAX_ADDONS_VERSION );
		wp_register_style( 'astrax-woo-carousel', ASTRAX_ADDONS_URL . 'assets/css/woo-carousel.css', [], ASTRAX_ADDONS_VERSION );
		wp_register_style( 'astrax-gallery', ASTRAX_ADDONS_URL . 'assets/css/gallery.css', [], ASTRAX_ADDONS_VERSION );
		wp_register_style( 'astrax-bento', ASTRAX_ADDONS_URL . 'assets/css/bento.css', [], ASTRAX_ADDONS_VERSION );
	}

	/**
	 * Register frontend scripts.
	 */
	public function register_scripts() {
		// Centralized registry for all widget scripts.
		wp_register_script( 'astrax-v3-widgets', ASTRAX_ADDONS_URL . 'assets/js/v3-widgets.js', [], ASTRAX_ADDONS_VERSION, true );
		wp_register_script( 'astrax-image-accordion', ASTRAX_ADDONS_URL . 'assets/js/image-accordion.js', [ 'jquery', 'elementor-frontend' ], ASTRAX_ADDONS_VERSION, true );
		wp_register_script( 'astrax-tabs', ASTRAX_ADDONS_URL . 'assets/js/tabs.js', [ 'jquery', 'elementor-frontend' ], ASTRAX_ADDONS_VERSION, true );
		wp_register_script( 'astrax-woo-carousel', ASTRAX_ADDONS_URL . 'assets/js/woo-carousel.js', [ 'jquery', 'elementor-frontend', 'slick' ], ASTRAX_ADDONS_VERSION, true );
		wp_register_script( 'astrax-gallery', ASTRAX_ADDONS_URL . 'assets/js/gallery.js', [ 'jquery', 'elementor-frontend', 'imagesloaded' ], ASTRAX_ADDONS_VERSION, true );
	}

	/**
	 * Add defer attribute to non-blocking Astrax scripts.
	 *
	 * @param string $tag    HTML script tag.
	 * @param string $handle Script handle.
	 * @return string Modified script tag.
	 */
	public function optimize_script_loading( $tag, $handle ) {
		$deferred_handles = [
			'astrax-v3-widgets',
			'astrax-image-accordion',
			'astrax-tabs',
			'astrax-woo-carousel',
			'astrax-gallery',
		];

		if ( in_array( $handle, $deferred_handles, true ) && false === strpos( $tag, 'defer' ) ) {
			return str_replace( ' src', ' defer="defer" src', $tag );
		}

		return $tag;
	}
}
