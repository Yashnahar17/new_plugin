<?php
namespace AstraxAddons\Templates;

use AstraxAddons\Utilities\HttpHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Template Library.
 *
 * Provides a UI within Elementor to sync and insert remote Astrax templates.
 *
 * @since 1.0.0
 */
class TemplateLibrary {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Example hook to add a template library tab in Elementor
		// This requires integration with Elementor's JS API for the actual modal.
		add_action( 'elementor/editor/footer', [ $this, 'render_library_template' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	/**
	 * Register REST routes for template syncing.
	 */
	public function register_routes() {
		register_rest_route(
			'astrax-addons/v1',
			'/templates/sync',
			[
				[
					'methods'             => 'GET',
					'callback'            => [ $this, 'sync_remote_templates' ],
					'permission_callback' => function() { return current_user_can( 'manage_options' ); },
				],
			]
		);
	}

	/**
	 * Safely fetch remote templates list.
	 */
	public function sync_remote_templates( \WP_REST_Request $request ) {
		// Mock remote API URL
		$remote_url = 'https://api.astrax.example.com/templates';
		
		$response = HttpHelper::safe_remote_get( $remote_url );
		
		if ( is_wp_error( $response ) ) {
			return new \WP_REST_Response( [ 'error' => $response->get_error_message() ], 400 );
		}
		
		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );
		
		return new \WP_REST_Response( $data, 200 );
	}

	/**
	 * Render the underscore.js template for the library modal.
	 */
	public function render_library_template() {
		?>
		<script type="text/template" id="tmpl-astrax-library-modal">
			<div class="elementor-templates-modal__header">
				<div class="elementor-templates-modal__header__logo-area">
					<div class="elementor-templates-modal__header__logo">
						<span class="elementor-templates-modal__header__logo__icon">
							<i class="eicon-star"></i>
						</span>
						<span class="elementor-templates-modal__header__logo__title"><?php esc_html_e( 'Astrax Library', 'astrax-addons' ); ?></span>
					</div>
				</div>
				<div class="elementor-templates-modal__header__menu-area">
					<div id="astrax-library-menu"></div>
				</div>
				<div class="elementor-templates-modal__header__items-area">
					<div class="elementor-templates-modal__header__close elementor-templates-modal__header__item">
						<i class="eicon-close" aria-hidden="true" title="<?php esc_attr_e( 'Close', 'astrax-addons' ); ?>"></i>
						<span class="elementor-screen-only"><?php esc_html_e( 'Close', 'astrax-addons' ); ?></span>
					</div>
				</div>
			</div>
			<div class="elementor-templates-modal__content">
				<!-- Templates Grid will be rendered here via JS -->
			</div>
		</script>
		<?php
	}

	/**
	 * Enqueue scripts for the template library.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script(
			'astrax-template-library',
			ASTRAX_ADDONS_URL . 'assets/js/admin/template-library.js',
			[ 'jquery', 'backbone', 'elementor-editor' ],
			ASTRAX_ADDONS_VERSION,
			true
		);
	}
}
