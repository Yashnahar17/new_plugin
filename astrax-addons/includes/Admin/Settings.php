<?php
namespace AstraxAddons\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Astrax Addons Settings & Plugin Dashboard.
 * 
 * Provides a dedicated Home/Dashboard control center in the WordPress admin panel,
 * integrating with Elementor, WordPress menus, REST controllers, and asset managers.
 *
 * @since 1.0.0
 */
class Settings {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
		add_action( 'plugin_action_links_' . plugin_basename( ASTRAX_ADDONS_FILE ), [ $this, 'add_plugin_action_links' ] );
	}

	/**
	 * Register the admin menu and dedicated submenus.
	 */
	public function register_admin_menu() {
		// Top-level Astrax Addons menu item
		add_menu_page(
			esc_html__( 'Astrax Addons Dashboard', 'astrax-addons' ),
			esc_html__( 'Astrax Addons', 'astrax-addons' ),
			'manage_options',
			'astrax-addons',
			[ $this, 'render_admin_page' ],
			'dashicons-star-filled',
			58
		);

		// Submenu: Dedicated Home / Dashboard
		add_submenu_page(
			'astrax-addons',
			esc_html__( 'Home / Dashboard', 'astrax-addons' ),
			esc_html__( 'Dashboard', 'astrax-addons' ),
			'manage_options',
			'astrax-addons',
			[ $this, 'render_admin_page' ]
		);

		// Submenu: Widgets
		add_submenu_page(
			'astrax-addons',
			esc_html__( 'Manage Widgets', 'astrax-addons' ),
			esc_html__( 'Widgets', 'astrax-addons' ),
			'manage_options',
			'astrax-addons#widgets',
			[ $this, 'render_admin_page' ]
		);

		// Submenu: Extensions
		add_submenu_page(
			'astrax-addons',
			esc_html__( 'Manage Extensions', 'astrax-addons' ),
			esc_html__( 'Extensions', 'astrax-addons' ),
			'manage_options',
			'astrax-addons#extensions',
			[ $this, 'render_admin_page' ]
		);

		// Submenu: Settings
		add_submenu_page(
			'astrax-addons',
			esc_html__( 'Plugin Settings', 'astrax-addons' ),
			esc_html__( 'Settings', 'astrax-addons' ),
			'manage_options',
			'astrax-addons#settings',
			[ $this, 'render_admin_page' ]
		);

		// Submenu: System Status
		add_submenu_page(
			'astrax-addons',
			esc_html__( 'System Status', 'astrax-addons' ),
			esc_html__( 'System Status', 'astrax-addons' ),
			'manage_options',
			'astrax-addons#system',
			[ $this, 'render_admin_page' ]
		);
	}

	/**
	 * Add direct links on the WordPress Plugins screen (Plugins -> Installed Plugins).
	 *
	 * @param array<string, string> $links Current action links.
	 * @return array<string, string>
	 */
	public function add_plugin_action_links( $links ) {
		$dashboard_link = sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url( 'admin.php?page=astrax-addons' ) ),
			esc_html__( 'Dashboard', 'astrax-addons' )
		);

		$settings_link = sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url( 'admin.php?page=astrax-addons#settings' ) ),
			esc_html__( 'Settings', 'astrax-addons' )
		);

		array_unshift( $links, $dashboard_link, $settings_link );
		return $links;
	}

	/**
	 * Enqueue admin scripts for the dashboard React application.
	 *
	 * @param string $hook The current admin page hook.
	 */
	public function enqueue_admin_scripts( $hook ) {
		if ( strpos( $hook, 'astrax-addons' ) === false ) {
			return;
		}

		wp_enqueue_script(
			'astrax-addons-admin',
			ASTRAX_ADDONS_URL . 'assets/js/admin/dashboard.js',
			[ 'wp-element', 'wp-components', 'wp-i18n', 'wp-api-fetch' ],
			ASTRAX_ADDONS_VERSION,
			true
		);

		wp_enqueue_style(
			'astrax-addons-admin',
			ASTRAX_ADDONS_URL . 'assets/css/admin/dashboard.css',
			[ 'wp-components' ],
			ASTRAX_ADDONS_VERSION
		);

		// Localize REST endpoint and security nonce
		wp_localize_script( 'astrax-addons-admin', 'astraxAdminData', [
			'restUrl'   => esc_url_raw( rest_url( 'astrax-addons/v1' ) ),
			'nonce'     => wp_create_nonce( 'wp_rest' ),
			'version'   => ASTRAX_ADDONS_VERSION,
			'siteUrl'   => esc_url( home_url( '/' ) ),
			'adminUrl'  => esc_url( admin_url( '/' ) ),
		] );
	}

	/**
	 * Render the admin dashboard mount container.
	 */
	public function render_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'astrax-addons' ) );
		}

		echo '<div class="wrap astrax-addons-admin-wrap">';
		echo '<div id="astrax-admin-app-root"></div>';
		echo '</div>';
	}
}
