<?php
namespace AstraxAddons\REST;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings REST API Controller.
 *
 * Provides endpoints for global plugin settings (like Google Maps API key, etc).
 *
 * Routes:
 *   GET  /astrax-addons/v1/settings       — Get all settings.
 *   POST /astrax-addons/v1/settings       — Update settings.
 *
 * @since 1.0.0
 */
class SettingsController {

	/**
	 * Register routes.
	 */
	public function register_routes() {
		register_rest_route(
			RestManager::REST_NAMESPACE,
			'/settings',
			[
				[
					'methods'             => 'GET',
					'callback'            => [ $this, 'get_settings' ],
					'permission_callback' => [ $this, 'check_permission' ],
				],
				[
					'methods'             => 'POST',
					'callback'            => [ $this, 'update_settings' ],
					'permission_callback' => [ $this, 'check_permission' ],
					'args'                => [
						'google_maps_api_key' => [
							'type'              => 'string',
							'sanitize_callback' => 'sanitize_text_field',
						],
					],
				]
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
	 * Get settings.
	 */
	public function get_settings() {
		$settings = get_option( 'astrax_global_settings', [] );
		if ( ! is_array( $settings ) ) {
			$settings = [];
		}

		return new \WP_REST_Response( [
			'google_maps_api_key' => isset( $settings['google_maps_api_key'] ) ? $settings['google_maps_api_key'] : '',
		], 200 );
	}

	/**
	 * Update settings.
	 */
	public function update_settings( $request ) {
		$settings = get_option( 'astrax_global_settings', [] );
		if ( ! is_array( $settings ) ) {
			$settings = [];
		}

		if ( $request->has_param( 'google_maps_api_key' ) ) {
			$settings['google_maps_api_key'] = sanitize_text_field( $request->get_param( 'google_maps_api_key' ) );
		}

		update_option( 'astrax_global_settings', $settings );

		return new \WP_REST_Response( [
			'message' => esc_html__( 'Settings updated successfully.', 'astrax-addons' ),
		], 200 );
	}
}
