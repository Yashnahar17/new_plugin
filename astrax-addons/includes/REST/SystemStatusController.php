<?php
namespace AstraxAddons\REST;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * System Status REST API Controller.
 *
 * Provides system environment data for the dashboard.
 *
 * Routes:
 *   GET /astrax-addons/v1/system       — Get system info.
 *
 * @since 1.0.0
 */
class SystemStatusController {

	/**
	 * Register routes.
	 */
	public function register_routes() {
		register_rest_route(
			RestManager::REST_NAMESPACE,
			'/system',
			[
				[
					'methods'             => 'GET',
					'callback'            => [ $this, 'get_system_info' ],
					'permission_callback' => [ $this, 'check_permission' ],
				],
			]
		);
	}

	/**
	 * Permission check.
	 */
	public function check_permission() {
		return current_user_can( 'manage_options' );
	}

	/**
	 * Get system info.
	 */
	public function get_system_info() {
		global $wp_version;

		return new \WP_REST_Response( [
			'php_version'       => PHP_VERSION,
			'wp_version'        => $wp_version,
			'elementor_version' => defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : 'Not installed',
			'server_software'   => isset( $_SERVER['SERVER_SOFTWARE'] ) ? $_SERVER['SERVER_SOFTWARE'] : 'Unknown',
			'memory_limit'      => ini_get( 'memory_limit' ),
		], 200 );
	}
}
