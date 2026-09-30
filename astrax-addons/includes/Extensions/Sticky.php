<?php
namespace AstraxAddons\Extensions;

use Elementor\Controls_Manager;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sticky Extension.
 *
 * Makes any section, container, or widget sticky using CSS `position: sticky`.
 * Falls back gracefully in older browsers. Provides controls for:
 *  - Enable/disable sticky
 *  - Sticky position (top or bottom)
 *  - Offset from edge
 *  - Z-index
 *  - Device visibility (sticky only on desktop, tablet, or mobile)
 *
 * Performance: Uses CSS sticky (no JS polling/scroll listeners).
 * Accessibility: Sticky elements maintain document flow and tab order.
 * Reduced motion: No motion effects are involved.
 *
 * @since 1.0.0
 */
class Sticky extends ExtensionBase {

	/**
	 * Get the extension slug.
	 *
	 * @return string
	 */
	public function get_slug() {
		return 'sticky';
	}

	/**
	 * Get the extension human-readable name.
	 *
	 * @return string
	 */
	public function get_name() {
		return esc_html__( 'Sticky', 'astrax-addons' );
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

		add_action( 'elementor/frontend/after_register_styles', [ $this, 'register_styles' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_styles' ] );
	}

	/**
	 * Register controls.
	 *
	 * @param Element_Base $element The element.
	 * @param array        $args    Additional args.
	 */
	public function register_controls( $element, $args = [] ) {
		$element->start_controls_section(
			'astrax_sticky_section',
			[
				'label' => esc_html__( 'Sticky', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'astrax_sticky_enable',
			[
				'label'        => esc_html__( 'Enable Sticky', 'astrax-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'astrax-addons' ),
				'label_off'    => esc_html__( 'No', 'astrax-addons' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$element->add_control(
			'astrax_sticky_position',
			[
				'label'     => esc_html__( 'Stick To', 'astrax-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'top'    => esc_html__( 'Top', 'astrax-addons' ),
					'bottom' => esc_html__( 'Bottom', 'astrax-addons' ),
				],
				'default'   => 'top',
				'condition' => [
					'astrax_sticky_enable' => 'yes',
				],
			]
		);

		$element->add_control(
			'astrax_sticky_offset',
			[
				'label'      => esc_html__( 'Offset (px)', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition'  => [
					'astrax_sticky_enable' => 'yes',
				],
			]
		);

		$element->add_control(
			'astrax_sticky_zindex',
			[
				'label'       => esc_html__( 'Z-Index', 'astrax-addons' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 9999,
						'step' => 1,
					],
				],
				'default'     => [
					'size' => 100,
				],
				'condition'   => [
					'astrax_sticky_enable' => 'yes',
				],
			]
		);

		$element->add_control(
			'astrax_sticky_devices',
			[
				'label'       => esc_html__( 'Sticky On', 'astrax-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'all'     => esc_html__( 'All Devices', 'astrax-addons' ),
					'desktop' => esc_html__( 'Desktop Only', 'astrax-addons' ),
					'tablet'  => esc_html__( 'Tablet & Desktop', 'astrax-addons' ),
				],
				'default'     => 'all',
				'condition'   => [
					'astrax_sticky_enable' => 'yes',
				],
			]
		);

		$element->end_controls_section();
	}

	/**
	 * Render inline styles for sticky behavior.
	 *
	 * @param Element_Base $element The element.
	 */
	public function before_render( $element ) {
		$settings = $element->get_settings_for_display();

		if ( empty( $settings['astrax_sticky_enable'] ) || 'yes' !== $settings['astrax_sticky_enable'] ) {
			return;
		}

		$position = isset( $settings['astrax_sticky_position'] ) ? $settings['astrax_sticky_position'] : 'top';
		$offset   = isset( $settings['astrax_sticky_offset']['size'] ) ? absint( $settings['astrax_sticky_offset']['size'] ) : 0;
		$zindex   = isset( $settings['astrax_sticky_zindex']['size'] ) ? absint( $settings['astrax_sticky_zindex']['size'] ) : 100;
		$devices  = isset( $settings['astrax_sticky_devices'] ) ? $settings['astrax_sticky_devices'] : 'all';

		$element->add_render_attribute( '_wrapper', 'class', 'astrax-sticky' );
		$element->add_render_attribute( '_wrapper', 'data-astrax-sticky-position', esc_attr( $position ) );
		$element->add_render_attribute( '_wrapper', 'data-astrax-sticky-offset', esc_attr( (string) $offset ) );
		$element->add_render_attribute( '_wrapper', 'data-astrax-sticky-zindex', esc_attr( (string) $zindex ) );
		$element->add_render_attribute( '_wrapper', 'data-astrax-sticky-devices', esc_attr( $devices ) );

		// Build inline sticky styles.
		$style = sprintf(
			'position:sticky;%s:%dpx;z-index:%d;',
			esc_attr( $position ),
			$offset,
			$zindex
		);

		$element->add_render_attribute( '_wrapper', 'style', $style );
	}

	/**
	 * Register styles.
	 */
	public function register_styles() {
		wp_register_style(
			'astrax-sticky',
			ASTRAX_ADDONS_URL . 'assets/css/extensions/sticky.css',
			[],
			ASTRAX_ADDONS_VERSION
		);
	}

	/**
	 * Enqueue styles.
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'astrax-sticky' );
	}
}
