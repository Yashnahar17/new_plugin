<?php
namespace AstraxAddons\REST;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * REST API Controller Manager.
 *
 * Registers all REST API route controllers for the Astrax admin dashboard.
 * Each controller is a self-contained class that defines its own routes,
 * validation, and permission callbacks.
 *
 * Security:
 *  - Every route has a permission_callback (never '__return_true').
 *  - Authorization is server-side via current_user_can().
 *  - Nonce verification via X-WP-Nonce / wp_rest.
 *  - Input validation via WP REST schema definitions.
 *
 * @since 1.0.0
 */
class RestManager {

	/**
	 * REST namespace for all Astrax routes.
	 *
	 * @var string
	 */
	const REST_NAMESPACE = 'astrax-addons/v1';

	/**
	 * Registered controller instances.
	 *
	 * @var array<string, \WP_REST_Controller>
	 */
	private $controllers = [];

	/**
	 * Constructor. Register REST routes.
	 */
	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	/**
	 * Register all REST controllers.
	 */
	public function register_routes() {
		$controller_classes = [
			'widgets'    => WidgetsController::class,
			'extensions' => ExtensionsController::class,
			'settings'   => SettingsController::class,
			'system'     => SystemStatusController::class,
		];

		/**
		 * Filter registered REST controllers.
		 *
		 * @param array<string, string> $controller_classes Controller slug => class map.
		 */
		$controller_classes = apply_filters( 'astrax_addons/rest/controllers', $controller_classes );

		foreach ( $controller_classes as $slug => $class_name ) {
			if ( class_exists( $class_name ) ) {
				$controller = new $class_name();
				$controller->register_routes();
				$this->controllers[ $slug ] = $controller;
			}
		}
	}

	/**
	 * Get a registered controller.
	 *
	 * @param string $slug Controller slug.
	 * @return \WP_REST_Controller|null
	 */
	public function get_controller( $slug ) {
		return isset( $this->controllers[ $slug ] ) ? $this->controllers[ $slug ] : null;
	}
}
