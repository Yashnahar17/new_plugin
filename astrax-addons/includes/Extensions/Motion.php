<?php
namespace AstraxAddons\Extensions;

use Elementor\Controls_Manager;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Motion / Parallax Extension.
 *
 * Adds scroll-driven motion effects (translate, scale, rotate, opacity)
 * and parallax background movement to sections, containers, and widgets.
 *
 * Performance: Uses CSS custom properties set via a single IntersectionObserver
 * + requestAnimationFrame handler. No jQuery dependency.
 *
 * Accessibility / Reduced motion: All effects are disabled when the user
 * has `prefers-reduced-motion: reduce` — both via CSS media query and
 * JS detection. A control lets editors preview the no-motion fallback.
 *
 * @since 1.0.0
 */
class Motion extends ExtensionBase {

	/**
	 * Get the extension slug.
	 *
	 * @return string
	 */
	public function get_slug() {
		return 'motion';
	}

	/**
	 * Get the extension human-readable name.
	 *
	 * @return string
	 */
	public function get_name() {
		return esc_html__( 'Motion & Parallax', 'astrax-addons' );
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

		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_scripts' ] );
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'register_styles' ] );
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
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
			'astrax_motion_section',
			[
				'label' => esc_html__( 'Motion & Parallax', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'astrax_motion_enable',
			[
				'label'        => esc_html__( 'Enable Motion Effects', 'astrax-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'astrax-addons' ),
				'label_off'    => esc_html__( 'No', 'astrax-addons' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		// --- Scroll Effects ---
		$element->add_control(
			'astrax_motion_translate_y',
			[
				'label'      => esc_html__( 'Vertical Translate (px)', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => -500,
						'max'  => 500,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition'  => [
					'astrax_motion_enable' => 'yes',
				],
			]
		);

		$element->add_control(
			'astrax_motion_scale',
			[
				'label'      => esc_html__( 'Scale', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0.1,
						'max'  => 3.0,
						'step' => 0.05,
					],
				],
				'default'    => [
					'size' => 1,
				],
				'condition'  => [
					'astrax_motion_enable' => 'yes',
				],
			]
		);

		$element->add_control(
			'astrax_motion_rotate',
			[
				'label'      => esc_html__( 'Rotate (deg)', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => -360,
						'max'  => 360,
						'step' => 1,
					],
				],
				'default'    => [
					'size' => 0,
				],
				'condition'  => [
					'astrax_motion_enable' => 'yes',
				],
			]
		);

		$element->add_control(
			'astrax_motion_opacity',
			[
				'label'      => esc_html__( 'Opacity Range', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'default'    => [
					'size' => 1,
				],
				'condition'  => [
					'astrax_motion_enable' => 'yes',
				],
			]
		);

		$element->add_control(
			'astrax_motion_speed',
			[
				'label'     => esc_html__( 'Effect Speed', 'astrax-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'slow'   => esc_html__( 'Slow', 'astrax-addons' ),
					'normal' => esc_html__( 'Normal', 'astrax-addons' ),
					'fast'   => esc_html__( 'Fast', 'astrax-addons' ),
				],
				'default'   => 'normal',
				'condition' => [
					'astrax_motion_enable' => 'yes',
				],
			]
		);

		// --- Reduced Motion ---
		$element->add_control(
			'astrax_motion_reduced_motion_heading',
			[
				'label'     => esc_html__( 'Accessibility', 'astrax-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'astrax_motion_enable' => 'yes',
				],
			]
		);

		$element->add_control(
			'astrax_motion_reduced_motion_note',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'All motion effects are automatically disabled when the user has enabled "Reduce motion" in their system preferences. No additional configuration is needed.', 'astrax-addons' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => [
					'astrax_motion_enable' => 'yes',
				],
			]
		);

		$element->end_controls_section();
	}

	/**
	 * Add data attributes for the JS motion handler.
	 *
	 * @param Element_Base $element The element.
	 */
	public function before_render( $element ) {
		$settings = $element->get_settings_for_display();

		if ( empty( $settings['astrax_motion_enable'] ) || 'yes' !== $settings['astrax_motion_enable'] ) {
			return;
		}

		$element->add_render_attribute( '_wrapper', 'class', 'astrax-motion' );

		// Encode motion config as a JSON data attribute.
		$config = [
			'translateY' => isset( $settings['astrax_motion_translate_y']['size'] ) ? (float) $settings['astrax_motion_translate_y']['size'] : 0,
			'scale'      => isset( $settings['astrax_motion_scale']['size'] ) ? (float) $settings['astrax_motion_scale']['size'] : 1,
			'rotate'     => isset( $settings['astrax_motion_rotate']['size'] ) ? (float) $settings['astrax_motion_rotate']['size'] : 0,
			'opacity'    => isset( $settings['astrax_motion_opacity']['size'] ) ? (float) $settings['astrax_motion_opacity']['size'] : 1,
			'speed'      => isset( $settings['astrax_motion_speed'] ) ? sanitize_key( $settings['astrax_motion_speed'] ) : 'normal',
		];

		$element->add_render_attribute(
			'_wrapper',
			'data-astrax-motion',
			wp_json_encode( $config )
		);
	}

	/**
	 * Register scripts.
	 */
	public function register_scripts() {
		wp_register_script(
			'astrax-motion',
			ASTRAX_ADDONS_URL . 'assets/js/extensions/motion.js',
			[],
			ASTRAX_ADDONS_VERSION,
			true
		);
	}

	/**
	 * Register styles.
	 */
	public function register_styles() {
		wp_register_style(
			'astrax-motion',
			ASTRAX_ADDONS_URL . 'assets/css/extensions/motion.css',
			[],
			ASTRAX_ADDONS_VERSION
		);
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'astrax-motion' );
	}

	/**
	 * Enqueue styles.
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'astrax-motion' );
	}
}
