<?php
namespace AstraxAddons\Providers\AI;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Server-only contract for optional AI providers.
 */
interface ProviderInterface {
	/**
	 * @return string Provider identifier.
	 */
	public function get_id();

	/**
	 * Generate a response from a validated server-side request.
	 *
	 * @param array<string, mixed> $request Validated request payload.
	 * @return array<string, mixed>|\WP_Error
	 */
	public function generate( $request );
}
