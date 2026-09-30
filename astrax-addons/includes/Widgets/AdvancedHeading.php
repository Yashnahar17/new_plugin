<?php
namespace AstraxAddons\Widgets;

use Elementor\Controls_Manager;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Advanced Heading Widget.
 */
class AdvancedHeading extends BaseWidget {

	/**
	 * Get widget name.
	 */
	public function get_name() {
		return 'astrax-advanced-heading';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return esc_html__( 'Advanced Heading', 'astrax-addons' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'eicon-heading';
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Heading Content', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'heading_text',
			[
				'label'       => esc_html__( 'Title', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your heading', 'astrax-addons' ),
				'default'     => esc_html__( 'Add Your Heading Text Here', 'astrax-addons' ),
			]
		);

		$this->add_html_tag_control( 'heading_tag', 'h2' );

		$this->add_link_control( 'heading_link' );

		$this->add_design_variant_control( 'design_variant' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Heading Style', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_typography_control( 'title_typography', '{{WRAPPER}} .astrax-heading-title' );

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-heading-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_alignment_control( 'align', '{{WRAPPER}} .astrax-advanced-heading' );

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['heading_text'] ) ) {
			return;
		}

		$variant = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';
		$wrapper_classes = [
			'astrax-advanced-heading',
			'astrax-variant-' . $variant,
		];

		// Security: Escape rich text input dynamically.
		$safe_text = RenderHelper::esc_rich_text( $settings['heading_text'] );

		// Handle links securely
		if ( ! empty( $settings['heading_link']['url'] ) ) {
			$this->add_link_attributes( 'heading_link_wrapper', $settings['heading_link'] );
			$safe_text = sprintf(
				'<a %1$s>%2$s</a>',
				$this->get_render_attribute_string( 'heading_link_wrapper' ),
				$safe_text
			);
		}

		$this->render_wrapper_start( $wrapper_classes );
		$this->render_html_tag(
			$settings['heading_tag'],
			$safe_text,
			[ 'class' => 'astrax-heading-title' ]
		);
		$this->render_wrapper_end();
	}
}
