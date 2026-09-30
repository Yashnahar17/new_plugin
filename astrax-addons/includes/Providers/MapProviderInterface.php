<?php
namespace AstraxAddons\Providers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Server-side contract for map providers.
 */
interface MapProviderInterface {
	/**
	 * @return string Provider identifier.
	 */
	public function get_id();

	/**
	 * Validate and normalize a public map configuration.
	 *
	 * @param array<string, mixed> $settings Map settings.
	 * @return array<string, mixed>|\WP_Error
	 */
	public function normalize_settings( $settings );
}
