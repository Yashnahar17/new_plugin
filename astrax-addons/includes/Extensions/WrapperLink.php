<?php
namespace AstraxAddons\Extensions;

use Elementor\Controls_Manager;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Wrapper Link Extension.
 *
 * Adds a clickable link to any container/section/column via a data attribute
 * and a lightweight JS handler. The link is applied as a full-element
 * click target — no <a> wrapping the entire element (which would be
 * invalid HTML for block elements).
 *
 * Security: URL is escaped with esc_url() on render.
 * Accessibility: aria-label is added for screen readers, role="link" and
 * tabindex="0" for keyboard navigation. Enter/Space triggers the link.
 *
 * @since 1.0.0
 */
class WrapperLink extends ExtensionBase {

	/**
	 * Get the extension slug.
	 *
	 * @return string
	 */
	public function get_slug() {
		return 'wrapper_link';
	}

	/**
	 * Get the extension human-readable name.
	 *
	 * @return string
	 */
	public function get_name() {
		return esc_html__( 'Wrapper Link', 'astrax-addons' );
	}

	/**
	 * Initialize hooks.
	 */
	protected function init() {
		// Register controls on all common elements.
		add_action( 'elementor/element/common/_section_style/after_section_end', [ $this, 'register_controls' ], 10, 2 );
		add_action( 'elementor/element/section/section_advanced/after_section_end', [ $this, 'register_controls' ], 10, 2 );
		add_action( 'elementor/element/container/section_layout/after_section_end', [ $this, 'register_controls' ], 10, 2 );
		add_action( 'elementor/element/column/section_advanced/after_section_end', [ $this, 'register_controls' ], 10, 2 );

		// Render data attributes for frontend.
		add_action( 'elementor/frontend/before_render', [ $this, 'before_render' ] );

		// Register extension scripts.
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_scripts' ] );
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Register controls.
	 *
	 * @param Element_Base $element The element.
	 * @param array        $args    Additional args.
	 */
	public function register_controls( $element, $args = [] ) {
		$element->start_controls_section(
			'astrax_wrapper_link_section',
			[
				'label' => esc_html__( 'Wrapper Link', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'astrax_wrapper_link_enable',
			[
				'label'        => esc_html__( 'Enable Wrapper Link', 'astrax-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'astrax-addons' ),
				'label_off'    => esc_html__( 'No', 'astrax-addons' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$element->add_control(
			'astrax_wrapper_link_url',
			[
				'label'       => esc_html__( 'Link URL', 'astrax-addons' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'astrax-addons' ),
				'condition'   => [
					'astrax_wrapper_link_enable' => 'yes',
				],
			]
		);

		$element->add_control(
			'astrax_wrapper_link_aria_label',
			[
				'label'       => esc_html__( 'Accessible Label', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Describe this link for screen readers', 'astrax-addons' ),
				'condition'   => [
					'astrax_wrapper_link_enable' => 'yes',
				],
			]
		);

		$element->end_controls_section();
	}

	/**
	 * Render data attributes before the element output.
	 *
	 * @param Element_Base $element The element.
	 */
	public function before_render( $element ) {
		$settings = $element->get_settings_for_display();

		if ( empty( $settings['astrax_wrapper_link_enable'] ) || 'yes' !== $settings['astrax_wrapper_link_enable'] ) {
			return;
		}

		if ( empty( $settings['astrax_wrapper_link_url']['url'] ) ) {
			return;
		}

		$url = esc_url( $settings['astrax_wrapper_link_url']['url'] );
		$element->add_render_attribute( '_wrapper', 'data-astrax-wrapper-link', $url );
		$element->add_render_attribute( '_wrapper', 'role', 'link' );
		$element->add_render_attribute( '_wrapper', 'tabindex', '0' );
		$element->add_render_attribute( '_wrapper', 'style', 'cursor: pointer;' );

		if ( ! empty( $settings['astrax_wrapper_link_aria_label'] ) ) {
			$element->add_render_attribute(
				'_wrapper',
				'aria-label',
				esc_attr( $settings['astrax_wrapper_link_aria_label'] )
			);
		}

		// New tab / nofollow handling.
		if ( ! empty( $settings['astrax_wrapper_link_url']['is_external'] ) ) {
			$element->add_render_attribute( '_wrapper', 'data-astrax-wrapper-link-external', 'true' );
		}

		if ( ! empty( $settings['astrax_wrapper_link_url']['nofollow'] ) ) {
			$element->add_render_attribute( '_wrapper', 'data-astrax-wrapper-link-nofollow', 'true' );
		}
	}

	/**
	 * Register frontend scripts.
	 */
	public function register_scripts() {
		wp_register_script(
			'astrax-wrapper-link',
			ASTRAX_ADDONS_URL . 'assets/js/extensions/wrapper-link.js',
			[],
			ASTRAX_ADDONS_VERSION,
			true
		);
	}

	/**
	 * Enqueue scripts when extension is active.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'astrax-wrapper-link' );
	}
}
