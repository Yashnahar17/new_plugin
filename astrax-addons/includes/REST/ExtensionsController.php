<?php
namespace AstraxAddons\REST;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Extensions REST API Controller.
 *
 * Provides endpoints to list available extensions and toggle their enabled state.
 *
 * Routes:
 *   GET  /astrax-addons/v1/extensions       — List all extensions.
 *   POST /astrax-addons/v1/extensions/toggle — Toggle an extension.
 *
 * Security:
 *   - Requires manage_options capability.
 *   - Input sanitized and validated against a whitelist.
 *
 * @since 1.0.0
 */
class ExtensionsController {

	/**
	 * Available extensions registry.
	 *
	 * @var array<string, string>
	 */
	private static $extension_registry = [
		'wrapper_link' => 'Wrapper Link',
		'visibility'   => 'Visibility',
		'sticky'       => 'Sticky',
		'motion'       => 'Motion & Parallax',
	];

	/**
	 * Register routes.
	 */
	public function register_routes() {
		register_rest_route(
			RestManager::REST_NAMESPACE,
			'/extensions',
			[
				[
					'methods'             => 'GET',
					'callback'            => [ $this, 'get_extensions' ],
					'permission_callback' => [ $this, 'check_permission' ],
				],
			]
		);

		register_rest_route(
			RestManager::REST_NAMESPACE,
			'/extensions/toggle',
			[
				[
					'methods'             => 'POST',
					'callback'            => [ $this, 'toggle_extension' ],
					'permission_callback' => [ $this, 'check_permission' ],
					'args'                => [
						'extension' => [
							'required'          => true,
							'type'              => 'string',
							'sanitize_callback' => 'sanitize_key',
							'validate_callback' => function( $param ) {
								return array_key_exists( sanitize_key( $param ), self::$extension_registry );
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
	 * Permission check.
	 *
	 * @return bool|\WP_Error
	 */
	public function check_permission() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return new \WP_Error(
				'astrax_forbidden',
				esc_html__( 'You do not have permission to manage extensions.', 'astrax-addons' ),
				[ 'status' => 403 ]
			);
		}
		return true;
	}

	/**
	 * Get all extensions with enabled status.
	 *
	 * @return \WP_REST_Response
	 */
	public function get_extensions() {
		$disabled = get_option( 'astrax_disabled_extensions', [] );
		if ( ! is_array( $disabled ) ) {
			$disabled = [];
		}

		$extensions = [];
		foreach ( self::$extension_registry as $slug => $name ) {
			$extensions[] = [
				'slug'    => $slug,
				'name'    => $name,
				'enabled' => ! in_array( $slug, $disabled, true ),
			];
		}

		return new \WP_REST_Response( $extensions, 200 );
	}

	/**
	 * Toggle an extension.
	 *
	 * @param \WP_REST_Request $request The request.
	 * @return \WP_REST_Response
	 */
	public function toggle_extension( $request ) {
		$slug    = sanitize_key( $request->get_param( 'extension' ) );
		$enabled = (bool) $request->get_param( 'enabled' );

		$disabled = get_option( 'astrax_disabled_extensions', [] );
		if ( ! is_array( $disabled ) ) {
			$disabled = [];
		}

		if ( $enabled ) {
			$disabled = array_diff( $disabled, [ $slug ] );
		} else {
			$disabled[] = $slug;
			$disabled   = array_unique( $disabled );
		}

		update_option( 'astrax_disabled_extensions', array_values( $disabled ) );

		return new \WP_REST_Response(
			[
				'slug'    => $slug,
				'enabled' => $enabled,
				'message' => $enabled
					? esc_html__( 'Extension enabled.', 'astrax-addons' )
					: esc_html__( 'Extension disabled.', 'astrax-addons' ),
			],
			200
		);
	}
}
