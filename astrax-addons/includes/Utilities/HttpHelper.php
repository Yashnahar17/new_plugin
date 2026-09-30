<?php
namespace AstraxAddons\Utilities;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * HTTP Helper Class for SSRF Protection.
 *
 * @since 1.0.0
 */
class HttpHelper {

	/**
	 * Safe remote get, guarding against SSRF.
	 *
	 * @param string $url The URL to fetch.
	 * @param array  $args wp_remote_get args.
	 * @return array|\WP_Error
	 */
	public static function safe_remote_get( $url, $args = [] ) {
		$parsed = wp_parse_url( $url );
		if ( ! $parsed || empty( $parsed['host'] ) ) {
			return new \WP_Error( 'invalid_url', 'Invalid URL provided.' );
		}

		// Prevent internal network requests (SSRF protection)
		$ip = gethostbyname( $parsed['host'] );
		if ( ! filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) ) {
			return new \WP_Error( 'ssrf_blocked', 'Request blocked for security reasons (SSRF).' );
		}

		// Enforce HTTPS
		if ( 'https' !== $parsed['scheme'] ) {
			return new \WP_Error( 'insecure_url', 'Only HTTPS requests are allowed.' );
		}

		// Timeout protection
		$args['timeout'] = isset( $args['timeout'] ) ? $args['timeout'] : 10;

		return wp_remote_get( $url, $args );
	}
}
