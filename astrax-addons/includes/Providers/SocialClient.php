<?php
namespace AstraxAddons\Providers;

use AstraxAddons\Utilities\HttpHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shared, server-side HTTP boundary for optional social integrations.
 */
class SocialClient {
	/**
	 * Fetch a documented endpoint through the SSRF-protected HTTP helper.
	 *
	 * Credentials belong in server-side options and must never be passed to widgets.
	 *
	 * @param string $url HTTPS endpoint.
	 * @param array<string, mixed> $args Request arguments.
	 * @return array|\WP_Error
	 */
	public function get( $url, $args = [] ) {
		$args['headers'] = isset( $args['headers'] ) && is_array( $args['headers'] ) ? $args['headers'] : [];
		$args['headers']['Accept'] = 'application/json';

		return HttpHelper::safe_remote_get( $url, $args );
	}
}
