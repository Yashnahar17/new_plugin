<?php
/**
 * Plugin Uninstall.
 *
 * @package AstraxAddons
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Cleanup plugin options securely.
 * Note: We do not touch Elementor Post Meta to preserve user content layouts.
 * We only remove Astrax-specific settings or transients.
 */

// Example cleanup:
// delete_option( 'astrax_addons_settings' );
// delete_transient( 'astrax_addons_cache' );

global $wpdb;
$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'astrax_addons_%'" );
