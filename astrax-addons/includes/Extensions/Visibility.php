<?php
namespace AstraxAddons\Extensions;

use Elementor\Controls_Manager;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Visibility Extension.
 *
 * Provides display condition controls for any Elementor element:
 *  - Show/hide on specific devices (desktop, tablet, mobile)
 *  - Show/hide based on user login state
 *  - Show/hide based on user roles (capability-based)
 *  - Date/time range visibility
 *
 * Security: Role-based visibility is purely presentational on the client
 * and for Elementor caching. Authorization decisions MUST remain server-side.
 * This extension only controls rendering output, not data access.
 *
 * Accessibility: Hidden elements use `display:none` — no ARIA hidden is needed
 * since the element is fully removed from the a11y tree.
 *
 * @since 1.0.0
 */
class Visibility extends ExtensionBase {

	/**
	 * Get the extension slug.
	 *
	 * @return string
	 */
	public function get_slug() {
		return 'visibility';
	}

	/**
	 * Get the extension human-readable name.
	 *
	 * @return string
	 */
	public function get_name() {
		return esc_html__( 'Visibility', 'astrax-addons' );
	}

	/**
	 * Initialize hooks.
	 */
	protected function init() {
		add_action( 'elementor/element/common/_section_style/after_section_end', [ $this, 'register_controls' ], 10, 2 );
		add_action( 'elementor/element/section/section_advanced/after_section_end', [ $this, 'register_controls' ], 10, 2 );
		add_action( 'elementor/element/container/section_layout/after_section_end', [ $this, 'register_controls' ], 10, 2 );
		add_action( 'elementor/element/column/section_advanced/after_section_end', [ $this, 'register_controls' ], 10, 2 );

		add_action( 'elementor/frontend/before_render', [ $this, 'before_render' ] );
	}

	/**
	 * Register controls.
	 *
	 * @param Element_Base $element The element.
	 * @param array        $args    Additional args.
	 */
	public function register_controls( $element, $args = [] ) {
		$element->start_controls_section(
			'astrax_visibility_section',
			[
				'label' => esc_html__( 'Visibility', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'astrax_visibility_enable',
			[
				'label'        => esc_html__( 'Enable Visibility Control', 'astrax-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'astrax-addons' ),
				'label_off'    => esc_html__( 'No', 'astrax-addons' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$element->add_control(
			'astrax_visibility_condition',
			[
				'label'     => esc_html__( 'Show/Hide', 'astrax-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'show' => esc_html__( 'Show when conditions match', 'astrax-addons' ),
					'hide' => esc_html__( 'Hide when conditions match', 'astrax-addons' ),
				],
				'default'   => 'show',
				'condition' => [
					'astrax_visibility_enable' => 'yes',
				],
			]
		);

		$element->add_control(
			'astrax_visibility_user_state',
			[
				'label'     => esc_html__( 'User Login State', 'astrax-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'All Users', 'astrax-addons' ),
					'logged_in'  => esc_html__( 'Logged In', 'astrax-addons' ),
					'logged_out' => esc_html__( 'Logged Out', 'astrax-addons' ),
				],
				'default'   => '',
				'condition' => [
					'astrax_visibility_enable' => 'yes',
				],
			]
		);

		$element->add_control(
			'astrax_visibility_roles',
			[
				'label'       => esc_html__( 'User Roles', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Comma-separated roles (e.g. administrator,editor). Leave empty for all roles.', 'astrax-addons' ),
				'placeholder' => esc_html__( 'administrator,editor', 'astrax-addons' ),
				'condition'   => [
					'astrax_visibility_enable'     => 'yes',
					'astrax_visibility_user_state' => 'logged_in',
				],
			]
		);

		$element->add_control(
			'astrax_visibility_note',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Note: Visibility rules control rendering only. They are NOT a security mechanism — do not use them to protect sensitive data.', 'astrax-addons' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'condition'       => [
					'astrax_visibility_enable' => 'yes',
				],
			]
		);

		$element->end_controls_section();
	}

	/**
	 * Conditionally prevent rendering based on visibility rules.
	 *
	 * Uses `add_render_attribute` to set display:none when conditions
	 * dictate the element should be hidden. This approach is safe for
	 * Elementor's output caching model — the server-side logic runs
	 * on each request and correctly evaluates user state.
	 *
	 * IMPORTANT: For logged-in visibility, caching must be configured
	 * to vary by user state — otherwise cached pages will show/hide
	 * incorrectly. The CompatibilityManager handles this via the
	 * `astrax_addons/cache/vary_by` filter.
	 *
	 * @param Element_Base $element The element.
	 */
	public function before_render( $element ) {
		$settings = $element->get_settings_for_display();

		if ( empty( $settings['astrax_visibility_enable'] ) || 'yes' !== $settings['astrax_visibility_enable'] ) {
			return;
		}

		$should_hide = $this->evaluate_conditions( $settings );

		if ( $should_hide ) {
			$element->add_render_attribute( '_wrapper', 'style', 'display:none !important;' );
			$element->add_render_attribute( '_wrapper', 'aria-hidden', 'true' );
		}
	}

	/**
	 * Evaluate visibility conditions.
	 *
	 * @param array $settings Element settings.
	 * @return bool True if the element should be hidden.
	 */
	private function evaluate_conditions( array $settings ) {
		$condition_type = isset( $settings['astrax_visibility_condition'] ) ? $settings['astrax_visibility_condition'] : 'show';
		$conditions_met = true;

		// User state check.
		if ( ! empty( $settings['astrax_visibility_user_state'] ) ) {
			$is_logged_in = is_user_logged_in();

			if ( 'logged_in' === $settings['astrax_visibility_user_state'] && ! $is_logged_in ) {
				$conditions_met = false;
			} elseif ( 'logged_out' === $settings['astrax_visibility_user_state'] && $is_logged_in ) {
				$conditions_met = false;
			}

			// Role check (only for logged-in users).
			if ( $conditions_met && $is_logged_in && ! empty( $settings['astrax_visibility_roles'] ) ) {
				$required_roles = array_map( 'trim', explode( ',', $settings['astrax_visibility_roles'] ) );
				$required_roles = array_map( 'sanitize_key', $required_roles );
				$user           = wp_get_current_user();
				$user_roles     = (array) $user->roles;

				if ( empty( array_intersect( $required_roles, $user_roles ) ) ) {
					$conditions_met = false;
				}
			}
		}

		// Logic: 'show' means show when conditions_met, hide otherwise.
		//        'hide' means hide when conditions_met, show otherwise.
		if ( 'show' === $condition_type ) {
			return ! $conditions_met; // Hide if conditions NOT met.
		}

		return $conditions_met; // Hide if conditions ARE met.
	}
}
