<?php
namespace AstraxAddons\REST;

use AstraxAddons\Widgets\WidgetRegistry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Widgets REST API Controller.
 *
 * Provides endpoints to list available widgets and toggle their enabled state.
 * Used by the React admin dashboard for the widget management panel.
 *
 * Routes:
 *   GET  /astrax-addons/v1/widgets       — List all widgets with enabled status.
 *   POST /astrax-addons/v1/widgets/toggle — Toggle a widget's enabled state.
 *
 * Security:
 *   - Requires manage_options capability.
 *   - Nonce verified via WP REST authentication.
 *   - Input sanitized and validated.
 *
 * @since 1.0.0
 */
class WidgetsController {

	/**
	 * Register routes.
	 */
	public function register_routes() {
		register_rest_route(
			RestManager::REST_NAMESPACE,
			'/widgets',
			[
				[
					'methods'             => 'GET',
					'callback'            => [ $this, 'get_widgets' ],
					'permission_callback' => [ $this, 'check_permission' ],
				],
			]
		);

		register_rest_route(
			RestManager::REST_NAMESPACE,
			'/widgets/toggle',
			[
				[
					'methods'             => 'POST',
					'callback'            => [ $this, 'toggle_widget' ],
					'permission_callback' => [ $this, 'check_permission' ],
					'args'                => [
						'widget' => [
							'required'          => true,
							'type'              => 'string',
							'sanitize_callback' => 'sanitize_key',
							'validate_callback' => function( $param ) {
							return array_key_exists( sanitize_key( $param ), WidgetRegistry::all() );
							},
						],
						'enabled' => [
							'required'          => true,
							'type'              => 'boolean',
							'sanitize_callback' => 'rest_sanitize_boolean',
						],
					],
				],
			]
		);
	}

	/**
	 * Permission check: manage_options required.
	 *
	 * @return bool|\WP_Error
	 */
	public function check_permission() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return new \WP_Error(
				'astrax_forbidden',
				esc_html__( 'You do not have permission to manage widgets.', 'astrax-addons' ),
				[ 'status' => 403 ]
			);
		}
		return true;
	}

	/**
	 * Get all widgets with their enabled status.
	 *
	 * @return \WP_REST_Response
	 */
	public function get_widgets() {
		$disabled_widgets = get_option( 'astrax_disabled_widgets', [] );
		if ( ! is_array( $disabled_widgets ) ) {
			$disabled_widgets = [];
		}

		$widgets = [];
		foreach ( WidgetRegistry::all() as $slug => $info ) {
			$widgets[] = [
				'slug'    => $slug,
				'name'    => $info['name'],
				'enabled' => ! in_array( $slug, $disabled_widgets, true ),
			];
		}

		return new \WP_REST_Response( $widgets, 200 );
	}

	/**
	 * Toggle a widget's enabled state.
	 *
	 * @param \WP_REST_Request $request The request.
	 * @return \WP_REST_Response
	 */
	public function toggle_widget( $request ) {
		$widget_slug = sanitize_key( $request->get_param( 'widget' ) );
		$enabled     = (bool) $request->get_param( 'enabled' );

		$disabled_widgets = get_option( 'astrax_disabled_widgets', [] );
		if ( ! is_array( $disabled_widgets ) ) {
			$disabled_widgets = [];
		}

		if ( $enabled ) {
			$disabled_widgets = array_diff( $disabled_widgets, [ $widget_slug ] );
		} else {
			$disabled_widgets[] = $widget_slug;
			$disabled_widgets   = array_unique( $disabled_widgets );
		}

		update_option( 'astrax_disabled_widgets', array_values( $disabled_widgets ) );

		return new \WP_REST_Response(
			[
				'slug'    => $widget_slug,
				'enabled' => $enabled,
				'message' => $enabled
					? esc_html__( 'Widget enabled.', 'astrax-addons' )
					: esc_html__( 'Widget disabled.', 'astrax-addons' ),
			],
			200
		);
	}
}
