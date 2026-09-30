<?php
/**
 * Plugin Name: Astrax Addons for Elementor
 * Plugin URI:  https://astrax.example.com
 * Description: An original, production-grade Elementor addon platform.
 * Version:     1.0.0
 * Author:      Astrax Team
 * Author URI:  https://astrax.example.com
 * Text Domain: astrax-addons
 * Domain Path: /languages
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Elementor tested up to: 3.24
 * Elementor Pro tested up to: 3.24
 *
 * @package AstraxAddons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define Constants
define( 'ASTRAX_ADDONS_VERSION', '1.0.0' );
define( 'ASTRAX_ADDONS_FILE', __FILE__ );
define( 'ASTRAX_ADDONS_DIR', plugin_dir_path( __FILE__ ) );
define( 'ASTRAX_ADDONS_URL', plugin_dir_url( __FILE__ ) );

// Native PSR-4 Autoloader for AstraxAddons (ensures plugin loads reliably)
spl_autoload_register( function ( $class ) {
	$prefix   = 'AstraxAddons\\';
	$base_dir = ASTRAX_ADDONS_DIR . 'includes/';
	$len      = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		return;
	}
	$relative_class = substr( $class, $len );
	$file           = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';
	if ( file_exists( $file ) ) {
		require_once $file;
	}
} );

// Composer Autoloader (if available)
if ( file_exists( ASTRAX_ADDONS_DIR . 'vendor/autoload.php' ) ) {
	require_once ASTRAX_ADDONS_DIR . 'vendor/autoload.php';
}

/**
 * Initialize the plugin safely.
 */
function astrax_addons_bootstrap() {
	// If the autoloader isn't present, the plugin wasn't built correctly.
	if ( ! class_exists( '\AstraxAddons\Core\Plugin' ) ) {
		add_action( 'admin_notices', function() {
			echo '<div class="notice notice-error"><p>' . esc_html__( 'Astrax Addons requires Composer dependencies. Please run `composer install`.', 'astrax-addons' ) . '</p></div>';
		} );
		return;
	}

	// Boot the core orchestrator
	\AstraxAddons\Core\Plugin::get_instance();
}

add_action( 'plugins_loaded', 'astrax_addons_bootstrap' );

/**
 * Plugin activation hook.
 */
register_activation_hook( __FILE__, function() {
	// Setup initial defaults, transient flushes, or capability setups.
} );

/**
 * Plugin deactivation hook.
 */
register_deactivation_hook( __FILE__, function() {
	// Clean up scheduled events or rewrite rules.
} );
