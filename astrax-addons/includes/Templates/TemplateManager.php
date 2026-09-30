<?php
namespace AstraxAddons\Templates;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Template Manager.
 *
 * Registers the Astrax Templates custom post type and integrates
 * with the Elementor Template Library.
 *
 * @since 1.0.0
 */
class TemplateManager {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_post_type' ] );
		
		// Initialize the library integration if in admin or Elementor editor.
		if ( is_admin() || ( defined( 'ELEMENTOR_VERSION' ) && is_callable( '\Elementor\Plugin::instance' ) ) ) {
			new TemplateLibrary();
		}
	}

	/**
	 * Register the custom post type for Astrax Templates.
	 */
	public function register_post_type() {
		$labels = [
			'name'               => esc_html__( 'Astrax Templates', 'astrax-addons' ),
			'singular_name'      => esc_html__( 'Astrax Template', 'astrax-addons' ),
			'menu_name'          => esc_html__( 'Astrax Templates', 'astrax-addons' ),
			'name_admin_bar'     => esc_html__( 'Astrax Template', 'astrax-addons' ),
			'add_new'            => esc_html__( 'Add New', 'astrax-addons' ),
			'add_new_item'       => esc_html__( 'Add New Template', 'astrax-addons' ),
			'new_item'           => esc_html__( 'New Template', 'astrax-addons' ),
			'edit_item'          => esc_html__( 'Edit Template', 'astrax-addons' ),
			'view_item'          => esc_html__( 'View Template', 'astrax-addons' ),
			'all_items'          => esc_html__( 'Saved Templates', 'astrax-addons' ),
			'search_items'       => esc_html__( 'Search Templates', 'astrax-addons' ),
			'not_found'          => esc_html__( 'No templates found.', 'astrax-addons' ),
			'not_found_in_trash' => esc_html__( 'No templates found in Trash.', 'astrax-addons' ),
		];

		$args = [
			'labels'              => $labels,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => 'astrax-addons',
			'show_in_nav_menus'   => false,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'supports'            => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'elementor' ],
		];

		register_post_type( 'astrax_template', $args );
	}

	/**
	 * Safe Template Import (No PHP/JS Execution).
	 *
	 * @param string $json_string Raw JSON export from Elementor.
	 * @return array|\WP_Error
	 */
	public function safe_import_template( $json_string ) {
		$data = json_decode( $json_string, true );

		if ( json_last_error() !== JSON_ERROR_NONE ) {
			return new \WP_Error( 'invalid_json', 'Invalid JSON format.' );
		}

		if ( empty( $data['content'] ) || ! is_array( $data['content'] ) ) {
			return new \WP_Error( 'invalid_template', 'Invalid template structure.' );
		}

		// Security: Recursively strip executable tags (script, php, iframe, object, embed)
		$data['content'] = $this->sanitize_template_content( $data['content'] );

		return $data;
	}

	/**
	 * Recursively sanitize template content array.
	 *
	 * @param array $content
	 * @return array
	 */
	private function sanitize_template_content( $content ) {
		foreach ( $content as $key => &$value ) {
			if ( is_array( $value ) ) {
				$value = $this->sanitize_template_content( $value );
			} elseif ( is_string( $value ) ) {
				// Prevent script tags, object, embed, iframe
				$value = preg_replace( '@<(script|style|iframe|object|embed)[^>]*?>.*?</\\1>@si', '', $value );
				// Basic fallback
				$value = wp_kses_post( $value );
			}
		}
		return $content;
	}
}
